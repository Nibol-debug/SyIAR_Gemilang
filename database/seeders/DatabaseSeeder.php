<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
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
        // Buat Cabang Dulu
        $branch = Branch::create(['branch_name' => 'Rumah Gemilang Pusat']);

        User::factory()->create([
            'name' => 'Admin TKJ 34',
            'email' => 'admin@gemilang.com',
            'branch_id' => $branch->id,
            'role' => 'admin',
            'password' => bcrypt('Gibran123'),
        ]);
    }
}
