<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'label' => 'In stock'],
            ['id' => 2, 'label' => 'Out of stock'],
            ['id' => 3, 'label' => 'Not available'],
            ['id' => 4, 'label' => 'Size not offered']
        ];

        DB::table('availabilities')->insert($data);
    }
}
