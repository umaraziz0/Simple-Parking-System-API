<?php

namespace Database\Seeders;

use App\Models\Admins;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admins::insert([
            ["name" => "Admin 1", "email" => "admin@mail.com", "password" => bcrypt("admin")],
            ["name" => "Admin 2", "email" => "admin2@mail.com", "password" => bcrypt("admin2")],
            ["name" => "Admin 3", "email" => "admin3@mail.com", "password" => bcrypt("admin3")],
        ]);
    }
}
