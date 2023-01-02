<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function list_projects ()
    {
        $total_projects = count(Project::get());

        if ($total_projects == 0) {
            Project::factory()->count(3)->create();
        }

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
}
