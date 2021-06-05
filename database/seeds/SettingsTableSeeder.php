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
            'key' => 'currency',
            'value' => json_encode((object)[
                'title' => 'гривны',
                'abbr' => 'UAH',
                'sign' => '₴',
                'align' => 'right',
                'default' => true,
            ], JSON_UNESCAPED_UNICODE),
        ]);

        DB::table('settings')->insert([
            'key' => 'currencies',
            'value' => json_encode((object)[
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
            ], JSON_UNESCAPED_UNICODE),
        ]);

        DB::table('settings')->insert([
            'key' => 'stocks',
            'value' => json_encode((object)[
                'stock-1' => [
                    'title' => 'Склад 1',
                ],
                'stock-2' => [
                    'title' => 'Склад 2',
                ]
            ], JSON_UNESCAPED_UNICODE),
        ]);

        DB::table('settings')->insert([
            'key' => 'images_format',
            'value' => 'jpg',
        ]);

        DB::table('settings')->insert([
            'key' => 'cashback_amount',
            'value' => 0.05,
        ]);

        DB::table('settings')->insert([
            'key' => 'admin.per_page',
            'value' => '18',
        ]);

    }
}
