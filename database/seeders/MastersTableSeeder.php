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
        $master = new Master();
        $master->email = 'master@example.com';
        $master->password = Hash::make('password');
        $master->save();
    }
}
