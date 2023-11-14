<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'brand_name' => 'Walton',
                'brand_pay_of_line' => 'Best Product',
                'brand_title' => 'Energy Efficient & Eco Friendly',
                'brand_description' => 'brand_description',

                'brand_official_email' => 'Walton Air Conditioner is integrated with intelligent inverter technology that saves maximum electricity.',

                'brand_official_phone' => '01718022214',
                'brand_official_address' => 'brand_official_address',
                'brand_slug' => 'walton',
                'sub_category_status' => 1,
                'category_id' => 1,
                'category_slug' => 'electronics',
                'sub_category_creator' => 2,
                'created_at' => Carbon::now()->toDateTimeLocalString(),
            ],

        ]);
    }
}
