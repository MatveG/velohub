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
            'type' => 'string',
            'value' => 'jpg'
        ]);
        DB::table('settings')->insert([
            'group' => 'images',
            'key' => 'dimension',
            'type' => 'number',
            'value' => '1000',
            'hint' => 'px'
        ]);
        DB::table('settings')->insert([
            'group' => 'images',
            'key' => 'size',
            'type' => 'number',
            'value' => '1024',
            'hint' => 'kb'
        ]);

        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'title',
            'type' => 'string',
            'value' => 'гривны'
        ]);
        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'abbr',
            'type' => 'string',
            'value' => 'грн'
        ]);
        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'sign',
            'type' => 'string',
            'value' => '₴'
        ]);
        DB::table('settings')->insert([
            'group' => 'currency',
            'key' => 'align',
            'type' => 'string',
            'value' => 'right'
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'cashback',
            'type' => 'number',
            'value' => 5,
            'hint' => '%'
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'stocks',
            'type' => 'object',
            'value' => json_encode([
                'stock-1' => 'Stock 1',
                'stock-2' => 'Stock 2',
            ]),
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'parameters',
            'type' => 'object',
            'value' => json_encode([
                'number' => 'число',
                'string' => 'строка',
                'select' => 'выбор',
            ]),
        ]);
        DB::table('settings')->insert([
            'group' => 'shop',
            'key' => 'features',
            'type' => 'object',
            'value' => json_encode([
                'group' => 'группа',
                'number' => 'число',
                'string' => 'строка',
                'text' => 'текст',
                'boolean' => 'есть/нет',
                'select' => 'выбор',
                'multiple' => 'мульти выбор'
            ]),
        ]);
    }
}
