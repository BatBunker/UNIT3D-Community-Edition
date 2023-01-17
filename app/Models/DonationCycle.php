<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationCycle extends Model
{
    public $table = 'donations_cycle';

    protected $fillable = ['open'];
    protected $hidden = [];

    /**
     * Has Many Donations.
     */
    public function donations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserDonation::class);
    }

    /**
     * @return float|int
     *
     * Get Donation Ratio for the progress bar.
     * If there is no cycle open, then 0 is returned.
     */
    public static function getCycleRatio(): float|int
    {
        $openDonationCycle = self::query()->where('open', '=', true)->first();
        if ($openDonationCycle !== null) {
            $donatedAmount = UserDonation::getDonationStatusByCycle($openDonationCycle->id);
            $expectedAmount = $openDonationCycle->amount_wanted_usd;
            // to avoid Division By Zero error
            if ($donatedAmount > 0) {
                return $donatedAmount / $expectedAmount;
            }
        }


        return 0;
    }
}
