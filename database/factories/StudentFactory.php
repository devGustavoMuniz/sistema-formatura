<?php

namespace Database\Factories;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'name' => $user->name,
            'ra' => $this->faker->unique()->numerify('#########'),
            'user_id' => $user->id,
            'institute_id' => Institute::factory(),
        ];
    }
}