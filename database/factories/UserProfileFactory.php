<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone' => fake()->phoneNumber(),
            'role' => fake()->randomElement(
                array_column(UserRole::cases(), 'value')
            ),
            'department' => 'IT'
        ];
    }
}
