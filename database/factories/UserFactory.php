<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $nameArray = explode(" ",$name);
        $random = Str::random(5);
        $username = Str::slug(trim($name),'');
        return [
            'name' => $name,
            'first_name' => !empty($nameArray[0]) ? $nameArray[0] : $name,
            'last_name' => !empty($nameArray[1]) ? $nameArray[1] : $name,
            'username' =>  $username,
            'employee_code' =>  $username.$random,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            // 'status' => 1,
            'phone_number' => rand(10000000000,9999999999),
            'role_id' =>  fake()->randomElement([1,2])
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
