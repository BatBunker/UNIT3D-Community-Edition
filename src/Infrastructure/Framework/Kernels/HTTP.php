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

namespace Src\Infrastructure\Framework\Kernels;

use Fruitcake\Cors\HandleCors;
use HDVinnie\SecureHeaders\SecureHeadersMiddleware;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Src\Infrastructure\Framework\Middlewares\Authenticate;
use Src\Infrastructure\Framework\Middlewares\CheckForAdmin;
use Src\Infrastructure\Framework\Middlewares\CheckForModo;
use Src\Infrastructure\Framework\Middlewares\CheckForOwner;
use Src\Infrastructure\Framework\Middlewares\CheckIfBanned;
use Src\Infrastructure\Framework\Middlewares\EncryptCookies;
use Src\Infrastructure\Framework\Middlewares\Http2ServerPush;
use Src\Infrastructure\Framework\Middlewares\PreventRequestsDuringMaintenance;
use Src\Infrastructure\Framework\Middlewares\RedirectIfAuthenticated;
use Src\Infrastructure\Framework\Middlewares\SetLanguage;
use Src\Infrastructure\Framework\Middlewares\TrimStrings;
use Src\Infrastructure\Framework\Middlewares\TwoStepAuth;
use Src\Infrastructure\Framework\Middlewares\UpdateLastAction;
use Src\Infrastructure\Framework\Middlewares\VerifyCsrfToken;

class HTTP extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = array(
        // Default Laravel
      PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        //\App\Http\Middleware\TrustProxies::class,
        HandleCors::class,

        // Extra
        SecureHeadersMiddleware::class,
        Http2ServerPush::class,
    );

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            SubstituteBindings::class,
           VerifyCsrfToken::class,
            UpdateLastAction::class,
        ],
        'api' => [
            'throttle:api',
            'bindings',
        ],
        'announce' => [
            'throttle:announce',
            'bindings',
        ],
        'rss' => [
            'throttle:rss',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin'         => CheckForAdmin::class,
        'auth'          => Authenticate::class,
        'auth.basic'    => AuthenticateWithBasicAuth::class,
        'banned'        => CheckIfBanned::class,
        'bindings'      => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can'           => Authorize::class,
        'csrf'          => VerifyCsrfToken::class,
        'guest'         => RedirectIfAuthenticated::class,
        'language'      => SetLanguage::class,
        'modo'          => CheckForModo::class,
        'owner'         => CheckForOwner::class,
        'throttle'      => ThrottleRequestsWithRedis::class,
        'twostep'       => TwoStepAuth::class,
        'signed'        => ValidateSignature::class,
        'verified'      => EnsureEmailIsVerified::class,
    ];
}
