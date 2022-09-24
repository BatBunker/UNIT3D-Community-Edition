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

return [

    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | Hit and Run On / Off
    |
    */

    'enabled' => (bool) env('HIT_RUN', true),

    /*
    |--------------------------------------------------------------------------
    | Seedtime
    |--------------------------------------------------------------------------
    |
    | Min Seedtime Required In Seconds
    |
    */

    'seedtime' => (int) env('SEEDTIME', 604800),

    /*
    |--------------------------------------------------------------------------
    | Max Warnings
    |--------------------------------------------------------------------------
    |
    | Max Warnings Before Ban
    |
    */

    'max_warnings' => (int) env('MAX_WARNINGS', 3),

    /*
    |--------------------------------------------------------------------------
    | Revoke Permissions
    |--------------------------------------------------------------------------
    |
    | Max Warnings Before Certain Permissions Are Revoked
    |
    */

    'revoke' => (int) env('REVOKE_TIME', 2),

    /*
    |--------------------------------------------------------------------------
    | Grace Period
    |--------------------------------------------------------------------------
    |
    | Max Grace Time For User To Be Disconnected If "Seedtime" Value
    | Is Not Yet Met. "In Days"
    |
    */

    'grace' => (int) env('GRACE_TIME', 3),

    /*
    |--------------------------------------------------------------------------
    | Buffer
    |--------------------------------------------------------------------------
    |
    | Percentage Buffer of Torrent thats checked against 'actual_downloaded'
    |
    */

    'buffer' => (int) env('BUFFER_PERCENTAGE', 3),

    /*
    |--------------------------------------------------------------------------
    | Warning Expire
    |--------------------------------------------------------------------------
    |
    | Max Days A Warning Lasts Before Expiring "In Days"
    |
    */

    'expire' => (int) env('EXPIRE_TIME', 14),

    /*
    |--------------------------------------------------------------------------
    | Prewarn Period
    |--------------------------------------------------------------------------
    |
    | Max Time For User To Be Disconnected If "Seedtime" Value
    | Is Not Yet Met. A Prewarning PM Will Be Sent. "In Days"
    |
    */

    'prewarn' => (int) env('PREWARN_TIME', 1),

];
