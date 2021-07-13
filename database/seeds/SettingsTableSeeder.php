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
            'group' => 'images',
            'key' => 'format',
            'value' => 'jpg'
        ]);
        DB::table('settings')->insert([
            'group' => 'images',
            'key' => 'dimension',
            'value' => '1000',
            'hint' => 'px'
        ]);
        DB::table('settings')->insert([
            'group' => 'images',
            'key' => 'size',
            'value' => '1024',
            'hint' => 'kb'
        ]);

        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'title',
            'value' => 'гривны'
        ]);
        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'abbr',
            'value' => 'грн'
        ]);
        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'sign',
            'value' => '₴'
        ]);
        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'align',
            'value' => 'right'
        ]);

        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'stocks',
            'value' => json_encode([
                'stock-1' => 'Stock 1',
                'stock-2' => 'Stock 2',
            ]),
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'cashback',
            'value' => 5,
            'hint' => '%'
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'features',
            'value' => json_encode([
                'stock-1' => 'Stock 1',
                'stock-2' => 'Stock 2',
            ]),
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'parameters',
            'value' => json_encode([
                'group' => 'группа',
                'number' => 'число',
                'string' => 'строка',
                'text' => 'текст',
                'bool' => 'есть/нет',
                'select' => 'выбор',
                'multiple' => 'мульти выбор'
            ]),
        ]);
    }
}
