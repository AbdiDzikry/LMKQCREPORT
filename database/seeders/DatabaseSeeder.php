<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Leader User',
            'email' => 'leader@lmk.com',
            'password' => bcrypt('password'),
            'role' => 'leader',
        ]);

        User::factory()->create([
            'name' => 'Section Head User',
            'email' => 'sectionhead@lmk.com',
            'password' => bcrypt('password'),
            'role' => 'section_head',
        ]);
    }
}
