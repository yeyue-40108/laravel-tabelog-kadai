<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = [
            '1,000円未満', '1,000~2,000円', '2,000~3,000円', '3,000~4,000円', '4,000~5,000円', '5,000円以上'
        ];

        foreach ($prices as $price) {
            Price::create([
                'range' => $price
            ]);
        }
    }
}
