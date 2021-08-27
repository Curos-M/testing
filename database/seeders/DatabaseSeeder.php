<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\JenjangSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserSeeder::run();
        RoleSeeder::run();
        JenjangSeeder::run();
    }
}
