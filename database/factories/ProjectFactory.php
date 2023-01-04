<?php

namespace Database\Factories;

use App\Models\ContractorCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->catchPhrase(),
            'description' => $this->faker->text(),
            'start_execution' => date("Y-m-d"),
            'end_execution' => date("Y-m-d", strtotime($this->random_months(), strtotime(today()))),
            'contractor_company_id' => $this->random_contractor_company(),
        ];
    }

    public function random_months ()
    {
        return $this->faker->randomElement(['+1 month', '+2 month', '+3 month', '+4 month', '+5 month', '+6 month', '+7 month', '+8 month']);
    }

    public function random_contractor_company ()
    {
        $random_contractor_company = ContractorCompany::inRandomOrder()->first();
        return $random_contractor_company->id;
    }
}
