<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'id' => 1, 
            'name' => 'Admin', 
            'email' => 'admin@avlbl.test', 
            'password' => Hash::make('p@ssw0rd'),
            'accounttype_id' => DB::table('accounttypes')->where('label', 'like', 'admin')->value('id')
        ];

        DB::table('users')->insert($data);
    }
}
