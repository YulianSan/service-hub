<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::factory()->create([
            'name' => 'KPMG',
        ]);

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'company_id' => $company->id
        ]);

        UserProfile::factory()->create([
            'role' => UserRole::ADMIN,
            'user_id' => $user->id
        ]);
    }
}
