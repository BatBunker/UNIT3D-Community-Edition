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
    | Download Check Page
    |--------------------------------------------------------------------------
    |
    | Weather Or Not User Will Be Stopped At Download Check Page Or Not
    |
    */

    'download_check_page' => (int)env('DOWNLOAD_CHECK_PAGE', 0),

    /*
    |--------------------------------------------------------------------------
    | Source Value
    |--------------------------------------------------------------------------
    |
    | Torrent Source Value
    |
    */

    'source' => env('TORRENT_SOURCE', config('APP_NAME', '')),

    /*
    |--------------------------------------------------------------------------
    | Created By
    |--------------------------------------------------------------------------
    |
    | Created By Value
    |
    */

    'created_by' => env('CREATED_BY', 'Edited by' . env('APP_NAME', '')),
    'created_by_append' => (bool) env('AAD_CREATED_BY', true),

    /*
    |--------------------------------------------------------------------------
    | Comment
    |--------------------------------------------------------------------------
    |
    | Comment Value
    |
    */

    'comment' => env('TORRENT_COMMENT', 'This torrent was downloaded from' . env('APP_NAME', '')),

    /*
    |--------------------------------------------------------------------------
    | Magnet
    |--------------------------------------------------------------------------
    |
    | Enable/Disable magnet links
    |
    */

    'magnet' => (int) env('ENABLE_MAGNET', 0),

];
