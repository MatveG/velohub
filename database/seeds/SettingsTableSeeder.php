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
            'name' => 'prices',
            'value' => json_encode([
                'retail' => [
                    'key' => 'retail',
                    'code' => 'грн',
                    'sign' => '₴',
                    'align' => 'right',
                ],
                'wholesale' => [
                    'key' => 'wholesale',
                    'code' => 'USD',
                    'sign' => '$',
                    'align' => 'left',
                ]
            ]),
        ]);
        DB::table('settings')->insert([
            'section' => 'shop',
            'name' => 'cashback_amount',
            'value' => 0.05,
        ]);
    }
}
