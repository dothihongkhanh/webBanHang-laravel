<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'name' => 'nguyenthanhminh',
                'email' => 'minh@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => 'ABC12345',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => '2'
            ],

            [
                'name' => 'lekhanh',
                'email' => 'khanh@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => 'ABC12345',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => '1'
            ],

            [
                'name' => 'tranvan',
                'email' => 'van@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => 'ABC12345',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => '2'
            ],

            [
                'name' => 'letuananh',
                'email' => 'tuananh@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => 'ABC12345',
                'remember_token' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'id_role' => '2'
            ],
        ]);
    }
}
