<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('contents')->insert([
            'is_active' => '1',
            'latin' => 'index',
            'name' => 'Главная',
        ]);
        DB::table('contents')->insert([
            'is_active' => '1',
            'latin' => 'dostavka',
            'name' => 'Доставка',
        ]);
        DB::table('contents')->insert([
            'is_active' => '1',
            'latin' => 'garantija',
            'name' => 'Гарантия',
        ]);
        DB::table('contents')->insert([
            'is_active' => '1',
            'latin' => 'servis',
            'name' => 'Сервис',
        ]);
        DB::table('contents')->insert([
            'is_active' => '1',
            'latin' => 'kontakti',
            'name' => 'Контакты',
        ]);
    }
}
