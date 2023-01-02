<?php

namespace Tests\Feature;

use App\Models\Employee;
use GuzzleHttp\Psr7\UploadedFile as Psr7UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function list_employees()
    {
        //revisa si hay registros en la base de datos
        $total_employee = count(Employee::get());

        //en caso deno haber registroscrea unos nuevos
        if ($total_employee == 0) {
            Employee::factory()->count(3)->create();
            $total_employee = 3;
        }

        //entra a la ruta yverifica si retorna un dato JSON
        $response = $this->getJson('/api/employee');
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
    public function show_employee ()
    {
        $total_employee = count(Employee::get());

        if ($total_employee > 0) {
            $employee = Employee::first();
        } else {
            $total_employee = Employee::factory()->count(3)->create();
            $employee = Employee::first();
        }

        $response = $this->getJson('api/employee/'.$employee->id);

        $response ->assertStatus(200)
         ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', $employee->id)
                ->where('cc', $employee->cc)
                ->where('first_name', $employee->first_name)
                ->where('last_name', $employee->last_name)
                ->where('birthdate', $employee->birthdate)
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
            $json   ->has('id')
                    ->hasAny(
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
        $total_employee = count(Employee::get());

        if ($total_employee > 0) {
            $employee = Employee::first();
        } else {
            $total_employee = Employee::factory()->count(3)->create();
            $employee = Employee::first();
        }

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
            $json->where('id', $employee->id)
                ->where('first_name', 'Martina')
                ->where('second_name', 'Helena')
                ->where('last_name', 'Manrique')
                ->where('profile_photo', $new_profile_photo)
            ->etc()
        );

    }

    /** @test */
    public function delete_employee ()
    {
        $total_employee = count(Employee::get());

        if ($total_employee > 0) {
            $employee = Employee::first();
        } else {
            $total_employee = Employee::factory()->count(3)->create();
            $employee = Employee::first();
        }

        $response = $this->deleteJson('api/employee/'.$employee->id);

        $response -> assertStatus(200)
            ->assertJsonFragment(['deleted']);
    }
}
