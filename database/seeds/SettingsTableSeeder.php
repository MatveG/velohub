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
            'key' => 'images_format',
            'value' => 'jpg',
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'items_per_page',
            'value' => '18',
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'currency',
            'value' => json_encode([
                'title' => 'гривны',
                'abbr' => 'UAH',
                'sign' => '₴',
                'align' => 'right',
                'default' => true,
            ]),
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'currencies',
            'value' => json_encode([
                'uah' => [
                    'title' => 'гривны',
                    'abbr' => 'UAH',
                    'sign' => '₴',
                    'align' => 'right',
                    'default' => true,
                ],
                'usd' => [
                    'title' => 'доллары',
                    'abbr' => 'USD',
                    'sign' => '$',
                    'align' => 'left',
                    'default' => false,
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

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'cashback_amount',
            'value' => 0.05,
        ]);
    }
}
