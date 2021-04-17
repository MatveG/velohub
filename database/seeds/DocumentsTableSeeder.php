<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'index',
            'title' => 'Главная',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'dostavka',
            'title' => 'Доставка',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'garantija',
            'title' => 'Гарантия',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'servis',
            'title' => 'Сервис',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'kontakti',
            'title' => 'Контакты',
        ]);
    }
}
