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
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'username' => 'johndoe',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@gmail.com',
                'username' => 'janesmith',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@gmail.com',
                'username' => 'michaelbrown',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@gmail.com',
                'username' => 'emilydavis',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Christopher Wilson',
                'email' => 'christopher.wilson@gmail.com',
                'username' => 'christopherwilson',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jessica Martinez',
                'email' => 'jessica.martinez@gmail.com',
                'username' => 'jessicamartinez',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Daniel Taylor',
                'email' => 'daniel.taylor@gmail.com',
                'username' => 'danieltaylor',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
