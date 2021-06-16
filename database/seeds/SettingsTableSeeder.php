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
            'key' => 'images.format',
            'value' => 'jpg'
        ]);
        DB::table('settings')->insert([
            'key' => 'images.dimension',
            'value' => '1000',
            'hint' => 'px'
        ]);
        DB::table('settings')->insert([
            'key' => 'images.size',
            'value' => '1024',
            'hint' => 'kb'
        ]);

        DB::table('settings')->insert([
            'key' => 'currency.title',
            'value' => 'гривны'
        ]);
        DB::table('settings')->insert([
            'key' => 'currency.abbr',
            'value' => 'грн'
        ]);
        DB::table('settings')->insert([
            'key' => 'currency.sign',
            'value' => '₴'
        ]);
        DB::table('settings')->insert([
            'key' => 'currency.align',
            'value' => 'right'
        ]);

        DB::table('settings')->insert([
            'key' => 'shop.stocks',
            'value' => json_encode([
                'stock-1' => 'Stock 1',
                'stock-2' => 'Stock 2',
            ]),
        ]);
        DB::table('settings')->insert([
            'key' => 'shop.cashback',
            'value' => 5,
            'hint' => '%'
        ]);
    }
}
