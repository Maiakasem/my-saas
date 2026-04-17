<?php

namespace Database\Factories;

use App\Models\Conference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Conference>
 */
class ConferenceFactory extends Factory
{
    public function definition(): array
    {
        $startsAt = now()->addMonths(6);
        $endsAt = (clone $startsAt)->addDays(3);

        $cfpStartsAt = (clone $startsAt)->subMonths(4);
        $cfpEndsAt = (clone $cfpStartsAt)->addMonths(2);

        return [
            'title' => fake()->sentence(),
            'location' => fake()->city(),
            'description' => fake()->text(),

            'url' => fake()->url(),

            'starts_at' => $startsAt,
            'ends_at' => $endsAt,

            'cfp_starts_at' => $cfpStartsAt,
            'cfp_ends_at' => $cfpEndsAt,
        ];
    }
}