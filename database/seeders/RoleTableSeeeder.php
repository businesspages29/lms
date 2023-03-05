<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name" => "Admin",
            ],
            [
                "name" => "User",
            ],
        ];

        foreach ($data as $key => $value) {
            Role::updateOrCreate([
                'name' => $value['name']
            ],$value);
        }
    }
}
