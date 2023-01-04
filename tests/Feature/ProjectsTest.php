<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\ContractorCompanyTrait;
use App\Traits\CreateRecords;
use App\Traits\ExtraTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use CreateRecords;
    use ExtraTrait;
    use ContractorCompanyTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function list_projects ()
    {
        $this->create_projects(3);

        $response = $this->getJson('api/projects');

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
    public function clean_list_projects ()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '12345678'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->create_projects(3);

        $response = $this->getJson('api/projects/all');
        $response -> assertStatus(200)
        -> assertJson(fn (AssertableJson $json) =>
            $json   -> whereType('0.id', 'integer')
                    -> whereAllType([
                        '0.title' => 'string',
                        '0.description' => 'string',
                        '0.start_execution' => 'string',
                        '0.end_execution' => 'string|null',
                        '0.contractor_company_id' => 'integer'
                    ])
        );
    }

    /** @test */
    public function store_project ()
    {
        $response = $this->postJson('api/projects', [
            'title' => fake()->catchPhrase(),
            'description' => fake()->text(),
            'start_execution' => date('Y-m-d'),
            'end_execution' => date("Y-m-d", strtotime($this->random_months(), strtotime(today()))),
            'contractor_company_id' => $this->random_contractor_company()
        ]);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
                $json   ->has('id')
                    -> hasAny(
                        'title',
                        'description',
                        'start_execution',
                        'end_execution',
                        'contractor_company_id',
                        'updated_at',
                        'created_at'
                    )
        );
    }

    /** @test */
    public function show_project ()
    {
        $project = $this->create_and_get_projects(3);
        $response = $this->getJson('api/projects/'.$project->id);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
            $json   -> where('id', $project->id)
                    -> where('title', $project->title)
                    -> where('description', $project->description)
                    -> where('start_execution', $project->start_execution)
                    -> where('end_execution', $project->end_execution)
                    -> where('contractor_company_id', $project->contractor_company_id)
            -> etc()
        );
    }

    /** @test */
    public function update_project ()
    {
        $project = $this->create_and_get_projects(3);

        $response = $this->putJson('api/projects/'.$project->id, [
            'title' => 'Desarrollo de nuevo sistema de gestión documental en Seguros Sudamericana.',
            'description' => $project->description,
            'start_execution' => date('Y-m-d'),
            'end_execution' => date("Y-m-d", strtotime('+6 month', strtotime(today()))),
            'contractor_company_id' => $project->contractor_company_id
        ]);

        $response -> assertStatus(200)
            -> assertJson(fn (AssertableJson $json) =>
            $json   -> where('title', 'Desarrollo de nuevo sistema de gestión documental en Seguros Sudamericana.')
                    -> where('start_execution', date('Y-m-d'))
                    -> where('end_execution', date("Y-m-d", strtotime('+6 month', strtotime(today()))))
            ->etc()
        );
    }

    /** @test */
    public function delete_project ()
    {
        $project = $this->create_and_get_projects(3);

        $response = $this->deleteJson('api/projects/'.$project->id);

        $response -> assertStatus(200)
            -> assertJsonFragment(['deleted']);
    }
}
