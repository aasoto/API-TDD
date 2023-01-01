<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\es_ES;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Employee::class;

    public function definition()
    {
        return [
            'cc' => $this->faker->numerify('##########'),
            'first_name' => $this->faker->firstName($gender = 'male'|'female'),
            'second_name' => $this->faker->firstName($gender = 'male'|'female'),
            'last_name' => $this->faker->lastName(),
            'second_last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['m', 'f', 'o', 'ne']),
            'birthdate' => $this->faker->date(),
            'profile_photo' => $this->faker->image(storage_path('app/public/profile-photos'), 500, 500, null, false)
        ];
    }
}
