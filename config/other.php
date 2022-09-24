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
// TODO We have to improve the pages management system.
// Currently it really sucks :(
return [

    /*
    |--------------------------------------------------------------------------
    | Site title
    |--------------------------------------------------------------------------
    |
    | Title of Site
    |
    */

    'title' => env('APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | Site SubTitle
    |--------------------------------------------------------------------------
    |
    | SubTitle
    |
    */

    'subTitle' => env('SUB_TITLE', ''),

    /*
    |--------------------------------------------------------------------------
    | Site email
    |--------------------------------------------------------------------------
    |
    | Email address to send emails
    |
    */

    'email' => env('DEFAULT_OWNER_EMAIL', 'unit3d@none.com'),

    /*
    |--------------------------------------------------------------------------
    | Meta description
    |--------------------------------------------------------------------------
    |
    | Default meta description content
    |
    */

    'meta_description' => env('SUB_TITLE', ''),

    /*
    |--------------------------------------------------------------------------
    | Site Birthdate
    |--------------------------------------------------------------------------
    |
    | Date Site Was Born
    |
    */
    'birthdate' => 'December 30th 2017',

    /*
    |--------------------------------------------------------------------------
    | Freelech State
    |--------------------------------------------------------------------------
    |
    | Global Freeleech
    |
    */
    'freeleech' => (bool) env('FREELEECH', false),

    'freeleech_until' => (string) env('FREELEECH_UNTIL', ''),

    /*
    |--------------------------------------------------------------------------
    | Double Upload State
    |--------------------------------------------------------------------------
    |
    | Global Double Upload
    |
    */
    'doubleup' => (bool)env('DOUBLE_UPLOAD', false),

    /*
    |--------------------------------------------------------------------------
    | Min Ratio
    |--------------------------------------------------------------------------
    |
    | Minimum Ratio To Download
    |
    */

    'ratio' => \number_format(env('MIN_RATIO', 0.4), 1),

    /*
    |--------------------------------------------------------------------------
    | Invite only
    |--------------------------------------------------------------------------
    |
    | Invite System On/Off (Open Reg / Closed)
    | Expire time in days
    |
    | Restricted mode for invites. If set to true, invites will be restricted
    | Exempt these groups from the invite restrictions
    */
    'invite-only' => (bool)env('INVITE_ONLY', true),
    'invite_expire' => (string)env('INVITE_EXPIRE', '14'),

    'invites_restriced' => false,
    'invite_groups' => [
        'Administrator',
        'Owner',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Users Stats
    |--------------------------------------------------------------------------
    |
    | This will be the upload and download given to new members. (In Bytes!)
    | Default: 50GiB Upload and 1GiB Download
    */
    'default_upload' => '53687091200',
    'default_download' => '1073741824',

    /*
    |--------------------------------------------------------------------------
    | Default Site Style
    |--------------------------------------------------------------------------
    | 0 = Light Theme
    | 1 = Galactic Theme
    | 2 = Dark Blue Theme
    | 3 = Dark Green Theme
    | 4 = Dark Pink Theme
    | 5 = Dark Purple Theme
    | 6 = Dark Red Theme
    | 7 = Dark Teal Theme
    | 8 = Dark Yellow Theme
    */
    'default_style' => 0,

    /*
    |--------------------------------------------------------------------------
    | Default Font Awesome Style
    |--------------------------------------------------------------------------
    | fas = Solid
    | far = Regular
    | fal = Light
    */
    'font-awesome' => 'fas',

    /*
    |--------------------------------------------------------------------------
    | Application Signups
    |--------------------------------------------------------------------------
    | True/1 = Enabled
    | False/0 = Disabled
    */
    'application_signups' => env('APPLICATION_SIGNUPS', false),

    /*
    |--------------------------------------------------------------------------
    | Rules Page URL
    |--------------------------------------------------------------------------
    | Example: 1
    */
    'rules_url' => 'https://' . parse_url(env('APP_URL'), PHP_URL_HOST) . '/pages/1',

    /*
    |--------------------------------------------------------------------------
    | FAQ Page URL
    |--------------------------------------------------------------------------
    | Example: 2
    */
    'faq_url' => 'https://' . parse_url(env('APP_URL'), PHP_URL_HOST) . '/pages/2',

    /*
    |--------------------------------------------------------------------------
    | Upload Guide Page URL For Upload Page
    |--------------------------------------------------------------------------
    | Example: 4
    */
    'upload-guide_url' => 'https://' . parse_url(env('APP_URL'), PHP_URL_HOST) . '/pages/4',

    /*
    |--------------------------------------------------------------------------
    | Hide Staff Area Forum Posts From Chat
    |--------------------------------------------------------------------------
    | 1 = Enabled
    | 0 = Disabled
    | If enabled, Staff members get notifications instead of posting being announced in chat.
    */
    'staff-forum-notify' => '0',

    /*
    |--------------------------------------------------------------------------
    | Staff Forum Id
    |--------------------------------------------------------------------------
    | Example: 2
    | The ID value of staff forum area. Should be the main / parent ID.
    */
    'staff-forum-id' => '',

    /*
    |--------------------------------------------------------------------------
    | Show Poll
    |--------------------------------------------------------------------------
    |
    | Hide or show the Poll's
    |
    */

    'show-poll' => (bool) env('SHOW_POLL', true),

];
