<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Mail\ActivateUser;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                /** @var Redirector $Redirector */
                $redirector = app('redirect');
                /** @var User $user */
                $user = \auth()->user();

                $bannedGroup = \cache()->rememberForever('banned_group', fn() => Group::where('slug', '=', 'banned')->pluck('id'));
                $validatingGroup = \cache()->rememberForever('validating_group', fn() => Group::where('slug', '=', 'validating')->pluck('id'));
                $disabledGroup = \cache()->rememberForever('disabled_group', fn() => Group::where('slug', '=', 'disabled')->pluck('id'));
                $memberGroup = \cache()->rememberForever('member_group', fn() => Group::where('slug', '=', 'user')->pluck('id'));

                if ($user->active == 0 || $user->group_id == $validatingGroup[0]) {
                    \auth()->guard()->logout();
                    $request->session()->invalidate();

                    return $redirector->route('login')
                        ->withErrors(\trans('auth.not-activated'));
                }

                if ($user->group_id == $bannedGroup[0]) {
                    \auth()->guard()->logout();
                    $request->session()->invalidate();

                    return $redirector->route('login')
                        ->withErrors(\trans('auth.banned'));
                }

                if ($user->group_id == $disabledGroup[0]) {
                    $user->group_id = $memberGroup[0];
                    $user->can_upload = 1;
                    $user->can_download = 1;
                    $user->can_comment = 1;
                    $user->can_invite = 1;
                    $user->can_request = 1;
                    $user->can_chat = 1;
                    $user->disabled_at = null;
                    $user->save();

                    return $redirector->route('home.index')
                        ->withSuccess(\trans('auth.welcome-restore'));
                }

                if (\auth()->viaRemember() && $user->group_id == $disabledGroup[0]) {
                    $user->group_id = $memberGroup[0];
                    $user->can_upload = 1;
                    $user->can_download = 1;
                    $user->can_comment = 1;
                    $user->can_invite = 1;
                    $user->can_request = 1;
                    $user->can_chat = 1;
                    $user->disabled_at = null;
                    $user->save();

                    return $redirector->route('home.index')
                        ->withSuccess(\trans('auth.welcome-restore'));
                }

                if ($user->read_rules == 0) {
                    return $redirector->route('pages.show', ['slug' => \config('other.rules_slug_name')])
                        ->withWarning(\trans('auth.require-rules'));
                }

                return $redirector->intended()
                    ->withSuccess(\trans('auth.welcome'));
            }
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Fortify::loginView(static fn() => view('auth.login'));
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });
        Fortify::registerView(function (Request $request) {
            $code = $request->code;;
            if ($code === 'null' && \config('other.invite-only') == 1 && \config('other.application_signups')) {
                return \to_route('application.create')
                    ->withInfo(\trans('auth.allow-invite-appl'));
            }

            // Make sure open reg is off and invite code is not present
            if ($code === 'null' && \config('other.invite-only') == 1) {
                return \to_route('login')
                    ->withWarning(\trans('auth.allow-invite'));
            }

            return \view('auth.register', ['code' => $code]);
        });
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('username', $request->username)->first();
            $this->validateLoginRequest($request);

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string)$request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }

    /**
     * validate the login request with validation rules
     *
     * @param Request $request
     * @return ?void
     */
    private function validateLoginRequest(Request $request): void
    {
        if (\config('captcha.enabled')) {
            $validator = validator($request->toArray(), [
                'username' => 'required|string',
                'password' => 'required|string',
                'captcha' => 'hiddencaptcha',
            ]);
        } else {
            $validator = validator($request->toArray(), [
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
        }

        if ($validator->fails()) {
            to_route('login')->withErrors($validator);
            return;
        }
    }

}


