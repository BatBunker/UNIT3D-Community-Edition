<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationCycle extends Model {

    public $table = 'donations_cycle';

    protected $fillable = ['open'];
    protected $hidden = [];

    /**
     * Has Many Torrents.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
