<?php

use App\Models\Company;
use App\Models\User;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();

    $this->user = User::factory()->create([
        'company_id' => $this->company->id
    ]);

    actingAs($this->user);

    $this->project = Project::factory()->create([
        'company_id' => $this->company->id
    ]);
});

it('renders the edit user profile page', function () {
    get(route('users-profile.edit', $this->user->id))
        ->assertInertia(
            fn(AssertableInertia $page) =>
            $page
                ->component('UserProfile/CreateEdit')
                ->where('user.id', $this->user->id)
        );
});

it('updates the user profile with new data', function () {
    $data = [
        'email' => 'tes@gmail.com',
        'name' => 'tes',
        'phone' => '(99)99999-9999'
    ];

    put(route('users-profile.update', $this->user->id), $data)
        ->assertRedirectBack();

    assertDatabaseHas('user_profiles', [
        'user_id' => $this->user->id,
        'phone' => '(99)99999-9999',
    ]);

    assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'tes',
        'email' => 'tes@gmail.com',
    ]);
});

it('creates a profile if none exists', function () {
    $data = [
        'email' => 'tes@gmail.com',
        'name' => 'tes',
        'phone' => '(99)99999-9999'
    ];

    $this->assertNull($this->user->profile);

    put(route('users-profile.update', $this->user->id), $data)
        ->assertRedirectBack();

    assertDatabaseHas('user_profiles', [
        'user_id' => $this->user->id,
        'phone' => '(99)99999-9999',
    ]);

    assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'tes',
        'email' => 'tes@gmail.com',
    ]);
});
