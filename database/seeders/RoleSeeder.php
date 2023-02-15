<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            ['role' => 'administrator', 'active'=>1],
            ['role' => 'billing manager', 'active'=>1],
            ['role' => 'purchase manager', 'active'=>1],
            ['role' => 'accountant', 'active'=>1]
        ]);
    }
}
