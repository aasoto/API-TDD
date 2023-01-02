<?php

namespace Database\Factories;

use App\Models\ContractorCompany;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContractorCompany>
 */
class ContractorCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ContractorCompany::class;

    public function definition()
    {
        return [
            'nit' => $this->faker->numerify('##########'),
            'business_name' => $this->faker->company(),
            'address' => $this->faker->streetAddress(),
            'country_id' => $this->random_country(),
            'tags' => $this->tags(),
            'responsable' => $this->faker->name($gender = 'male'|'female'),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber()
        ];
    }

    public function random_country ()
    {
        $random_country = Country::inRandomOrder()->limit(1)->get();
        return $random_country[0]->id;
    }

    public function tags ()
    {
        $tags = $this->faker->randomElements(['construccion', 'informatica', 'salud', 'educacion', 'agropecuaria'], 3);
        return json_encode($tags);
    }
}
