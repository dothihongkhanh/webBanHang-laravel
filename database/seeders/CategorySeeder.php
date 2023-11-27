<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('categories')->insert([
            [
                'name_category' => 'Sneaker',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name_category' => 'Sandal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name_category' => 'High heels',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
