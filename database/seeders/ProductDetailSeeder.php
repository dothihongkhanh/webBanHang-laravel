<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('product_details')->insert([
            [
                'id_product' => '1',
                'size' => '36',
                'color' => 'Cloud White',
                'avt_detail' => 'Cloud White.jpg',
                'inventory_number' => '10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_product' => '1',
                'size' => '36',
                'color' => 'Core Black',
                'avt_detail' => 'Core Black.jpg',
                'inventory_number' => '10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_product' => '2',
                'size' => '38',
                'color' => 'Black',
                'avt_detail' => 'Roger Vivier Black.jpg',
                'inventory_number' => '5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id_product' => '3',
                'size' => '37',
                'color' => 'Blue',
                'avt_detail' => 'Purple Sandal Blue.jpg',
                'inventory_number' => '5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
