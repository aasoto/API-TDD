<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use App\Traits\CreateRecords;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    // use RefreshDatabase;
    use CreateRecords;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function list_employees()
    {
        $this->create_employees(3);

        //entra a la ruta yverifica si retorna un dato JSON
        $response = $this->getJson('/api/employee');
        $response -> assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json   -> has('current_page')
                    -> hasAny(
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
    public function clean_list_employees ()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '12345678'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->create_employees(3);

        $response = $this->getJson('api/employee/all');
        $response -> assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json->whereType('0.id', 'integer')
                ->whereAllType([
                    '0.cc' => 'string',
                    '0.first_name' => 'string',
                    '0.second_name' => 'string|null',
                    '0.last_name' => 'string',
                    '0.second_last_name' => 'string|null',
                    '0.gender' => 'string|null',
                    '0.birthdate' => 'string',
                    '0.profile_photo' => 'string|null'
                ])
        );
    }

    /** @test */
    public function show_employee ()
    {
        $employee = $this->create_and_get_employees(3);

        $response = $this->getJson('api/employee/'.$employee->id);

        $response ->assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json   -> where('id', $employee->id)
                    -> where('cc', $employee->cc)
                    -> where('first_name', $employee->first_name)
                    -> where('last_name', $employee->last_name)
                    -> where('birthdate', $employee->birthdate)
            ->etc()
        );
    }

    /** @test */
    public function store_employee ()
    {

        $response = $this->postJson('api/employee', [
            'cc' => fake()->numerify('##########'),
            'first_name' => fake()->firstName($gender = 'male'|'female'),
            'second_name' => fake()->firstName($gender = 'male'|'female'),
            'last_name' => fake()->lastName(),
            'second_last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['m', 'f', 'o', 'ne']),
            'birthdate' => fake()->date(),
            'profile_photo' => fake()->image(storage_path('app/public/profile-photos'), 500, 500, null, false)
        ]);

        $response->assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json   -> has('id')
                    -> hasAny(
                        'cc',
                        'first_name',
                        'second_name',
                        'last_name',
                        'second_last_name',
                        'gender',
                        'birthdate',
                        'profile_photo',
                        'updated_at',
                        'created_at'
                    )
        );
    }

    /** @test */
    public function update_employee ()
    {
        $employee = $this->create_and_get_employees();

        $new_profile_photo = fake()->image(storage_path('app/public/profile-photos'), 500, 500, null, false);

        $response = $this->putJson('api/employee/'.$employee->id, [
            'cc' => fake()->numerify('##########'),
            'first_name' => 'Martina',
            'second_name' => 'Helena',
            'last_name' => 'Manrique',
            'birthdate' => fake()->date(),
            'profile_photo' => $new_profile_photo
        ]);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
            $json   -> where('id', $employee->id)
                    -> where('first_name', 'Martina')
                    -> where('second_name', 'Helena')
                    -> where('last_name', 'Manrique')
                    -> where('profile_photo', $new_profile_photo)
                ->etc()
        );

    }

    /** @test */
    public function delete_employee ()
    {
        $employee = $this->create_and_get_employees();

        $response = $this->deleteJson('api/employee/'.$employee->id);

        $response -> assertStatus(200)
            -> assertJsonFragment(['deleted']);
    }
}
