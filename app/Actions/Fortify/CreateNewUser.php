<?php

namespace App\Actions\Fortify;

use App\Models\Group;
use App\Models\Invite;
use App\Models\PrivateMessage;
use App\Models\User;
use App\Models\UserActivation;
use App\Models\UserNotification;
use App\Models\UserPrivacy;
use App\Repositories\ChatRepository;
use App\Rules\EmailBlacklist;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use DispatchesJobs;

    private ?string $inviteKey;
    private ?string $code;

    public function __construct(private Request $request, private readonly ChatRepository $chatRepository)
    {
        $this->code = $this->request->code;
        $this->inviteKey = Invite::where('code', '=', $this->code)->first();
        if (\config('other.invite-only') == 1 && (!$this->inviteKey || $this->inviteKey->accepted_by !== null)) {
            return \redirect()->back()
                ->with(['code' => $this->code])
                ->withErrors(\trans('auth.invalid-key'));
        }
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {

        $validatingGroup = \cache()->rememberForever('validating_group', fn() => Group::where('slug', '=', 'validating')->pluck('id'));

        $request = $this->request;
        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->passkey = \md5(\random_bytes(60) . $user->password);
        $user->rsskey = \md5(\random_bytes(60) . $user->password);
        $user->uploaded = \config('other.default_upload');
        $user->downloaded = \config('other.default_download');
        $user->style = \config('other.default_style', 0);
        $user->locale = \config('app.locale');
        $user->group_id = $validatingGroup[0];
        $this->validationRules($input);
        $user->save();


        $userPrivacy = new UserPrivacy();
        $userPrivacy->setDefaultValues();
        $userPrivacy->user_id = $user->id;
        $userPrivacy->save();
        $userNotification = new UserNotification();
        $userNotification->setDefaultValues();
        $userNotification->user_id = $user->id;
        $userNotification->save();

        if ($this->inviteKey) {
            // Update The Invite Record
            $this->inviteKey->accepted_by = $user->id;
            $this->inviteKey->accepted_at = new Carbon();
            $this->inviteKey->save();
        }


//        // Handle The Activation System
//        $token = \hash_hmac('sha256', $user->username . $user->email . Str::random(16), \config('app.key'));
//        $userActivation = new UserActivation();
//        $userActivation->user_id = $user->id;
//        $userActivation->token = $token;
//        $userActivation->save();
//        $this->dispatch(new SendActivationMail($user, $token));
        // Select A Random Welcome Message
        $profileUrl = \href_profile($user);
        $welcomeArray = [
            \sprintf('[url=%s]%s[/url], Welcome to ', $profileUrl, $user->username) . \config('other.title') . '! Hope you enjoy the community :rocket:',
            \sprintf("[url=%s]%s[/url], We've been expecting you :space_invader:", $profileUrl, $user->username),
            \sprintf("[url=%s]%s[/url] has arrived. Party's over. :cry:", $profileUrl, $user->username),
            \sprintf("It's a bird! It's a plane! Nevermind, it's just [url=%s]%s[/url].", $profileUrl, $user->username),
            \sprintf('Ready player [url=%s]%s[/url].', $profileUrl, $user->username),
            \sprintf('A wild [url=%s]%s[/url] appeared.', $profileUrl, $user->username),
            'Welcome to ' . \config('other.title') . \sprintf(' [url=%s]%s[/url]. We were expecting you ( ͡° ͜ʖ ͡°)', $profileUrl, $user->username),
        ];
        $selected = random_int(0, \count($welcomeArray) - 1);
        $this->chatRepository->systemMessage(
            $welcomeArray[$selected]
        );
        // Send Welcome PM
        $privateMessage = new PrivateMessage();
        $privateMessage->sender_id = 1;
        $privateMessage->receiver_id = $user->id;
        $privateMessage->subject = \config('welcomepm.subject');
        $privateMessage->message = \config('welcomepm.message');
        $privateMessage->save();

//        return \to_route('login')
//            ->withSuccess(\trans('auth.register-thanks'));
        return $user;


    }




//    public function create(array $input)
//    {
//
//        Validator::make($input, [
//            'name' => ['required', 'string', 'max:255'],
//            'email' => [
//                'required',
//                'string',
//                'email',
//                'max:255',
//                Rule::unique(User::class),
//            ],
//            'password' => $this->passwordRules(),
//        ])->validate();
//
//        return User::create([
//            'name' => $input['name'],
//            'email' => $input['email'],
//            'password' => Hash::make($input['password']),
//        ]);
//    }

    private function validationRules(array $input)
    {

        if (\config('email-blacklist.enabled')) {
            if (!\config('captcha.enabled')) {
                $v = \validator($input, [
                    'username' => 'required|alpha_dash|string|between:3,25|unique:users',
                    'password' => ['required', 'max:25', 'string', $this->passwordRules()],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:70',
                        'unique:users',
                        new EmailBlacklist(),
                    ],
                ]);
            } else {
                $v = \validator($input, [
                    'username' => 'required|alpha_dash|string|between:3,25|unique:users',
                    'password' => ['required', 'max:25', 'string', $this->passwordRules()],
                    'email' => [
                        'required',
                        'string',
                        'email',
                        'max:70',
                        'unique:users',
                        new EmailBlacklist(),
                    ],
                    'captcha' => 'hiddencaptcha',
                ]);
            }
        } elseif (!\config('captcha.enabled')) {
            $v = \validator($input, [
                'username' => 'required|alpha_dash|string|between:3,25|unique:users',
                'password' => ['required', 'max:25', 'string', $this->passwordRules()],
                'email' => 'required|string|email|max:70|unique:users',
            ]);
        } else {
            $v = \validator($input, [
                'username' => 'required|alpha_dash|string|between:3,25|unique:users',
                'password' => ['required', 'max:25', 'string', $this->passwordRules()],
                'email' => 'required|string|email|max:70|unique:users',
                'captcha' => 'hiddencaptcha',
            ]);
        }

        if ($v->fails()) {
            return \redirect()->back()->with(['code' => $this->code])
                ->withErrors($v->errors());
        }

    }
}