<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('2022-01-01', 'now'),
            'reason' => $this->faker->text,
            'child_profile_id' =>$this->faker->numberBetween(2,9)
        ];
    }
}
