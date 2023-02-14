<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use src\Domain\Torrent\Torrent;

class TorrentFileFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'size'       => $this->faker->randomNumber(),
            'torrent_id' => fn () => Torrent::factory()->create()->id,
        ];
    }
}
