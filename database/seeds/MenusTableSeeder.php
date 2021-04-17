<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'parent_id' => 0,
            'ord' => 1,
            'is_active' => true,
            'link' => '/',
            'name' => 'Главная',
        ]);
        DB::table('menus')->insert([
            'parent_id' => 0,
            'ord' => 2,
            'is_active' => true,
            'link' => '/dostavka/',
            'name' => 'Доставка',
        ]);
        DB::table('menus')->insert([
            'parent_id' => 0,
            'ord' => 3,
            'is_active' => true,
            'link' => '/garantija/',
            'name' => 'Гарантия',
        ]);
        DB::table('menus')->insert([
            'parent_id' => 0,
            'ord' => 4,
            'is_active' => 1,
            'link' => '/servis/',
            'name' => 'Сервис',
        ]);
        DB::table('menus')->insert([
            'parent_id' => 0,
            'ord' => 5,
            'is_active' => 1,
            'link' => '/kontakti/',
            'name' => 'Контакты',
        ]);
    }
}
