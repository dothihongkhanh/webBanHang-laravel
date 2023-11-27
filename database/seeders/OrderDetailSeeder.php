<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('order_details')->insert([
            [
                'id_order' => '1',
                'id_product_detail' => '1',
                'quantity' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id_order' => '1',
                'id_product_detail' => '2',
                'quantity' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id_order' => '2',
                'id_product_detail' => '3',
                'quantity' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
