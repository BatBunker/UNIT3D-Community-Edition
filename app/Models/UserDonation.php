<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDonation extends Model
{
    public $table = 'donations';

    protected $guarded = ['*'];
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Belongs To A  User
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Belongs To A Donation Cycle
     */
    public function donation_cycle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DonationCycle::class);
    }

    public static function getDonationStatusByCycle(int $cycleId, string $status = 'accepted')
    {
        return self::query()
            ->where('transaction_status', '=', $status)
            ->where('donation_cycle_id', '=', $cycleId)
            ->sum('transaction_amount_usd');
    }
}
