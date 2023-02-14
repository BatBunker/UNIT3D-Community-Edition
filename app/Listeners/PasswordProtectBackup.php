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

namespace App\Listeners;

use Spatie\Backup\Events\BackupZipWasCreated;
use Src\Helper\BackupPassword;

class PasswordProtectBackup
{
    /**
     * Handle the event.
     */
    public function handle(BackupZipWasCreated $backupZipWasCreated): string
    {
        return (new BackupPassword($backupZipWasCreated->pathToZip))->path;
    }
}
