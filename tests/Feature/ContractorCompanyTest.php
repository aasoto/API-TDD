<?php

namespace Tests\Feature;

use App\Models\ContractorCompany;
use App\Providers\RouteServiceProvider;
use App\Traits\CountryTrait;
use App\Traits\CreateRecords;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ContractorCompanyTest extends TestCase
{
    use CountryTrait;
    use CreateRecords;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function list_contractors ()
    {
        $this->create_contractors_companies(3);

        $response = $this->getJson('api/contractor-company');
        $response -> assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json->has('current_page')
                ->hasAny(
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total'
                )
        );
    }

    /** @test */
    public function clean_list_contractor ()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '12345678'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->create_contractors_companies(3);

        $response = $this->getJson('api/contractor-company/all');
        $response -> assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json   -> whereType('0.id', 'integer')
                    -> whereAllType([
                        '0.nit' => 'string',
                        '0.business_name' => 'string',
                        '0.address' => 'string',
                        '0.country_id' => 'integer',
                        '0.tags' => 'string|null',
                        '0.responsable' => 'string',
                        '0.email' => 'string',
                        '0.phone' => 'string'
                    ])
        );
    }

    /** @test */
    public function show_contractor ()
    {
        $contractor = $this->create_and_get_contractors_companies(3);

        $response = $this->getJson('api/contractor-company/'.$contractor->id);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
            $json   -> where('id', $contractor->id)
                    -> where('nit', $contractor->nit)
                    -> where('business_name', $contractor->business_name)
                    -> where('address', $contractor->address)
                    -> where('country_id', $contractor->country_id)
                    -> where('tags', $contractor->tags)
                    -> where('responsable', $contractor->responsable)
                    -> where('email', $contractor->email)
                    -> where('phone', $contractor->phone)
            -> etc()
        );
    }

    /** @test */
    public function store_contractor ()
    {

        $response = $this->postJson('api/contractor-company', [
            'nit' => fake()->numerify('##########'),
            'business_name' => fake()->firstName($gender = 'male'|'female'),
            'address' => fake()->address(),
            'country_id' => $this->random_country(),
            'tags' => json_encode(fake()->randomElements(['construccion', 'informatica', 'salud', 'educacion', 'agropecuaria'], 3)),
            'responsable' => fake()->name($gender = 'male'|'female'),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber()
        ]);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
                $json   ->has('id')
                    -> hasAny(
                        'nit',
                        'business_name',
                        'address',
                        'country_id',
                        'tags',
                        'responsable',
                        'email',
                        'phone',
                        'updated_at',
                        'created_at'
                    )
        );
    }

    /** @test */
    public function update_contractor ()
    {
        $contractor = $this->create_and_get_contractors_companies(3);

        $response = $this->putJson('api/contractor-company/'.$contractor->id, [
            'nit' => $contractor->nit,
            'business_name' => 'Constructora Las Torres',
            'address' => 'Cra. 85 No. 123-54',
            'country_id' => $contractor->country_id,
            'tags' => $contractor->tags,
            'responsable' => 'Fernando Herrera Torres',
            'email' => $contractor->email,
            'phone' => $contractor->phone
        ]);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
            $json   -> where('business_name', 'Constructora Las Torres')
                    -> where('address', 'Cra. 85 No. 123-54')
                    -> where('responsable', 'Fernando Herrera Torres')
            ->etc()
        );
    }

    /** @test */
    public function delete_contractor ()
    {
        $contractor = $this->create_and_get_contractors_companies(3);

        $response = $this->deleteJson('api/contractor-company/'.$contractor->id);

        $response -> assertStatus(200)
            -> assertJsonFragment(['deleted']);
    }
}
