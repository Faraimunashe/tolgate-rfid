<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TolfeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            ['class' => 1, 'description' => 'Light Vehicles', 'amount' => 10.20],
            ['class' => 2, 'description' => 'Minibuses', 'amount' => 15.20],
            ['class' => 3, 'description' => 'Buses', 'amount' => 20.20],
            ['class' => 4, 'description' => 'Heavy Vehicles', 'amount' => 25.20],
            ['class' => 5, 'description' => 'Haulage Trucks', 'amount' => 30.20],
        ];

        foreach ($fees as $fee) {
            DB::table('types')->insert($fee);
        }
    }
}
