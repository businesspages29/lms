<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeeder::class);

        \App\Models\User::factory()->create([
            'role_id' => 1,
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        \App\Models\User::factory(100)->create();
    }
}
