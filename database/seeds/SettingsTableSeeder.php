<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'section' => 'shop',
            'name' => 'items_per_page',
            'value' => '18',
        ]);

        DB::table('settings')->insert([
            'section' => 'shop',
            'name' => 'default_price',
            'value' => 'retail',
        ]);

        DB::table('settings')->insert([
            'section' => 'shop',
            'name' => 'cashback_amount',
            'value' => 0.05,
        ]);

        DB::table('settings')->insert([
            'section' => 'shop',
            'name' => 'prices',
            'value' => json_encode([
                'retail' => [
                    'title' => 'retail',
                    'code' => 'грн',
                    'sign' => '₴',
                    'align' => 'right',
                ],
                'wholesale' => [
                    'title' => 'wholesale',
                    'code' => 'USD',
                    'sign' => '$',
                    'align' => 'left',
                ]
            ]),
        ]);

        DB::table('settings')->insert([
            'section' => 'shop',
            'name' => 'stocks',
            'value' => json_encode([
                'stock-1' => [
                    'title' => 'Склад 1',
                ],
                'stock-2' => [
                    'title' => 'Склад 2',
                ]
            ]),
        ]);
    }
}
