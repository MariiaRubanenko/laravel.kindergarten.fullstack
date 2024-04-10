<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Child_profile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child_profile>
 */
class ChildProfileFactory extends Factory
{


    protected $model = Child_profile:: class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birthday' => $this->faker->date(),
            'allergies' => $this->faker->text, 
            'illnesses' => $this->faker->text,
            'family_account_id'=>$this->faker->numberBetween(1,3)
            //
        ];
    }
}
