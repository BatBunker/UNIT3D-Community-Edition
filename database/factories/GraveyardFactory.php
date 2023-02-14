<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use src\Domain\Torrent\Torrent;

class GraveyardFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id'    => fn () => User::factory()->create()->id,
            'torrent_id' => fn () => Torrent::factory()->create()->id,
            'seedtime'   => $this->faker->randomNumber(),
            'rewarded'   => $this->faker->boolean(),
        ];
    }
}
