<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDonation extends Model {

    public $table = 'donations';

    protected $guarded = ['*'];
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donation_cycle()
    {
        return $this->belongsTo(DonationCycle::class);
    }
}
