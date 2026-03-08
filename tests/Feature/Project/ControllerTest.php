<?php

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();

    $this->user = User::factory()->create([
        'company_id' => $this->company->id
    ]);

    actingAs($this->user);
});

it('lists projects', function () {
    Project::factory()
        ->count(3)
        ->create([
            'company_id' => $this->company->id
        ]);

    $response = get(route('projects.index'));

    $response->assertStatus(200);

    $response->assertInertia(
        fn($page) =>
        $page->component('Project/Index')
            ->has('projects.data', 3)
    );
});

it('creates project', function () {

    $data = [
        'name' => 'Test Project',
        'description' => 'Example'
    ];

    $response = post(route('projects.store'), $data);

    $response->assertRedirect(route('projects.index'));

    $this->assertDatabaseHas('projects', [
        'name' => 'Test Project'
    ]);
});

it('updates project', function () {

    $project = Project::factory()->create([
        'company_id' => $this->company->id
    ]);

    $response = put(route('projects.update', $project), [
        'name' => 'Updated Project',
        'description' => 'Example'
    ]);

    $response->assertRedirect(route('projects.index'));

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'name' => 'Updated Project',
        'company_id' => $this->company->id
    ]);
});

it('deletes project', function () {

    $project = Project::factory()->create([
        'company_id' => $this->company->id
    ]);

    $response = delete(route('projects.destroy', $project));

    $response->assertRedirect(route('projects.index'));

    $this->assertDatabaseMissing('projects', [
        'id' => $project->id
    ]);
});
