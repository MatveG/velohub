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
            'group' => 'shop',
            'key' => 'items_per_page',
            'value' => '18',
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'default_price',
            'value' => 'price-1',
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'cashback_amount',
            'value' => 0.05,
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'prices',
            'value' => json_encode([
                'price-1' => [
                    'title' => 'retail',
                    'code' => 'грн',
                    'sign' => '₴',
                    'align' => 'right',
                ],
                'price-2' => [
                    'title' => 'wholesale',
                    'code' => 'USD',
                    'sign' => '$',
                    'align' => 'left',
                ]
            ]),
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'stocks',
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
