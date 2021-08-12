<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'full_name' => 'Administrator',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 0,

        ]);
    }
}
