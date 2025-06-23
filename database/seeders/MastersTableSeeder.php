<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Master;
use Illuminate\Support\Facades\Hash;

class MastersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Master::create([
            'email' => 'master@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);
        
        Master::factory()->count(10)->create();
    }
}
