<?php

use App\Models\Company;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('logs in with valid credentials', function () {
    $company = Company::factory()->create();

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('secret123'),
        'company_id' => $company->id
    ]);

    UserProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticatedAs($user);
});

it('does not login with invalid credentials', function () {
    $company = Company::factory()->create();

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('secret123'),
        'company_id' => $company->id
    ]);

    UserProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = post(route('login'), [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertRedirect(route('login'))
        ->assertSessionHasErrors('login');

    $this->assertGuest();
});

it('logs out the authenticated user', function () {
    $company = Company::factory()->create();

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('secret123'),
        'company_id' => $company->id
    ]);

    UserProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user);

    $response = post(route('logout'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});
