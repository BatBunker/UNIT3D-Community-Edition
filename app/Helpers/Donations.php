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

namespace App\Helpers;

use App\Models\DonationCycle;
use App\Models\UserDonation;

class Donations {
    /**
     * Returns ratio of (donation made)/(donation expected).
     * If there is no cycle open, then null is returned.
     */
    public static function donationCycleRatio(): ?float {
        $openDonationCycle = DonationCycle::where('open', true)->first();
        if ($openDonationCycle == null) {
            return null;
        }
        $donatedAmount = UserDonation::where('transaction_status', 'accepted')
                ->where('donation_cycle_id', $openDonationCycle->id)
                ->sum('transaction_amount_usd');
        $expectedAmount = $openDonationCycle->amount_wanted_usd;
        return $donatedAmount/$expectedAmount;
    }
}
