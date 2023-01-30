<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\FeaturedTorrent;
use App\Models\FreeleechToken;
use App\Models\Group;
use App\Models\PersonalFreeleech;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Torrent;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\Staff\HomeControllerTest
 */
class HomeController extends Controller
{
    final const TAKE_LIMIT = 8;

    /**
     * Display Home Page.
     *
     * @throws \Exception
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        // For Cache
        $current = Carbon::now();
        $expiresAt = $current->addMinutes(1);

        // Authorized User
        $user = $request->user();

        // Latest Articles/News Block
        $articles = \cache()->remember('latest_article', $expiresAt, fn() => Article::latest()->take(1)->get());
        foreach ($articles as $article) {
            $article->newNews = ($user->updated_at->subDays(3)->getTimestamp() < $article->created_at->getTimestamp()) ? 1 : 0;
        }

        // Latest Torrents Block
        $personalFreeleech = PersonalFreeleech::where('user_id', '=', $user->id)->first();

        $newest = \cache()->remember('newest_torrents', $expiresAt, fn() => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->latest()
            ->take(self::TAKE_LIMIT)
            ->get());

        $seeded = \cache()->remember('seeded_torrents', $expiresAt, fn() => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->latest('seeders')
            ->take(self::TAKE_LIMIT)
            ->get());

        $leeched = \cache()->remember('leeched_torrents', $expiresAt, fn() => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->latest('leechers')
            ->take(self::TAKE_LIMIT)
            ->get());

        $dying = \cache()->remember('dying_torrents', $expiresAt, fn() => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->where('seeders', '=', 1)
            ->where('times_completed', '>=', 1)
            ->latest('leechers')
            ->take(self::TAKE_LIMIT)
            ->get());

        $dead = \cache()->remember('dead_torrents', $expiresAt, fn() => Torrent::with(['user', 'category', 'type', 'resolution'])
            ->withCount(['thanks', 'comments'])
            ->where('seeders', '=', 0)
            ->latest('leechers')
            ->take(self::TAKE_LIMIT)
            ->get());

        // Latest Topics Block
        $topics = \cache()->remember('latest_topics', $expiresAt, fn() => Topic::with('forum')->latest()->take(5)->get());

        // Latest Posts Block
        $posts = \cache()->remember('latest_posts', $expiresAt, fn() => Post::with('topic', 'user')->latest()->take(5)->get());

        // Online Block
        $users = \cache()->remember('online_users', $expiresAt, fn() => User::with('group', 'privacy')
            ->withCount([
                'warnings' => function (Builder $query) {
                    $query->whereNotNull('torrent')->where('active', '1');
                },
            ])
            ->where('last_action', '>', \now()->subMinutes(5))
            ->get());

        $groups = \cache()->remember('user-groups', $expiresAt, fn() => Group::select(['name', 'color', 'effect', 'icon'])->oldest('position')->get());

        // Featured Torrents Block
        $featured = \cache()->remember('latest_featured', $expiresAt, fn() => FeaturedTorrent::with('torrent', 'torrent.resolution', 'torrent.type', 'torrent.category', 'user', 'user.group')->get());

        // Latest Poll Block
        $poll = \cache()->remember('latest_poll', $expiresAt, fn() => Poll::latest()->first());


        $uploaders = \cache()->remember('top_uploaders', $expiresAt, function () use ($current) {
            $todayUploaders = Torrent::with(['user', 'user.group'])
                ->select(DB::raw('user_id, count(*) as current_value'))
                ->groupBy('user_id')
                ->latest('current_value')
                ->take(10)
                ->get()->toArray();
            $pastUploaders = Torrent::with(['user', 'user.group'])
                ->where('created_at', '>', $current->copy()->subDays(30)->toDateTimeString())
                ->select(DB::raw('user_id, count(*) as past_value'))
                ->groupBy('user_id')
                ->latest('past_value')
                ->take(10)
                ->get();

            return collect([$todayUploaders, $pastUploaders])
                ->flatten(1)
                ->groupBy('user_id')
                ->map(fn(Collection $item) => Arr::collapse($item->toArray()));
        });
        $freeleechTokens = FreeleechToken::where('user_id', $user->id)->get();
        $bookmarks = Bookmark::where('user_id', $user->id)->get();

        $randomTorrent = cache()->remember('randomTorrent', now()->addDay(), function () {
            return Torrent::query()->with('category')
                ->inRandomOrder()
                ->where('tmdb', '!=', 0)
                ->where("seeders", '>', 1)
                ->take(1)
                ->get()
                ->first();
        });


        return \view('home.index', [
            'user' => $user,
            'personal_freeleech' => $personalFreeleech,
            'users' => $users,
            'groups' => $groups,
            'articles' => $articles,
            'newest' => $newest,
            'seeded' => $seeded,
            'dying' => $dying,
            'leeched' => $leeched,
            'dead' => $dead,
            'topics' => $topics,
            'posts' => $posts,
            'featured' => $featured,
            'poll' => $poll,
            'uploaders' => $uploaders,
            'freeleech_tokens' => $freeleechTokens,
            'bookmarks' => $bookmarks,
            'random_torrent' => $randomTorrent
        ]);
    }
}
