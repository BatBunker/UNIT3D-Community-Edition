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
    | Graveyard On/Off
    |
    */

    'enabled' => (bool) env('GRAVEYARD', true),

    /*
    |--------------------------------------------------------------------------
    | Seedtime
    |--------------------------------------------------------------------------
    |
    | Time In Seconds Needed For Successful Ressurection (Default: 2592000seconds / 30days)
    |
    */

    'time' => env('RESSURECTION_TIME', '2592000'),

    /*
    |--------------------------------------------------------------------------
    | Reward Amount
    |--------------------------------------------------------------------------
    |
    | Amount of Freeleech tokens one is required for a successful resurrection
    |
    */

    'reward' => env('REWARD', '5'),

];
