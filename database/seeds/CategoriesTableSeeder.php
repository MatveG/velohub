<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    private array $dataRows = [
        ['id' => '1','parent_id' => '0','is_parent' => false,'slug' => 'velosipedy','title' => 'Велосипеды','title_short' => 'Велосипеды','ord' => '1','is_active' => true],
        ['id' => '2','parent_id' => '0','is_parent' => true,'slug' => 'zapchasty','title' => 'Запчасти','title_short' => 'Запчасти','ord' => '2','is_active' => true],
        ['id' => '3','parent_id' => '0','is_parent' => true,'slug' => 'aksessuary','title' => 'Аксессуары','title_short' => 'Аксессуары','ord' => '3','is_active' => true],
        ['id' => '4','parent_id' => '0','is_parent' => true,'slug' => 'odezhda','title' => 'Одежда','title_short' => 'Одежда','ord' => '4','is_active' => true],
        ['id' => '6','parent_id' => '0','is_parent' => true,'slug' => 'uslugi','title' => 'Услуги','title_short' => 'Услуги','ord' => '6','is_active' => true],
        ['id' => '7','parent_id' => '2','is_parent' => false,'slug' => 'veloramy','title' => 'Велорамы','title_short' => 'Велорамы','ord' => '1','is_active' => true],
        ['id' => '8','parent_id' => '2','is_parent' => false,'slug' => 'zapchasti-dlja-ram','title' => 'Запчасти для рам','title_short' => 'Запчасти для рам','ord' => '3','is_active' => true],
        ['id' => '9','parent_id' => '2','is_parent' => false,'slug' => 'kolesa','title' => 'Колеса','title_short' => 'Колеса','ord' => '5','is_active' => true],
        ['id' => '10','parent_id' => '2','is_parent' => false,'slug' => 'pokryshki-i-kamery','title' => 'Резина и Камеры','title_short' => 'Резина и Камеры','ord' => '8','is_active' => true],
        ['id' => '11','parent_id' => '2','is_parent' => false,'slug' => 'vilki-amortizatory','title' => 'Вилки и Амортизаторы','title_short' => 'Вилки и Амортизаторы','ord' => '2','is_active' => true],
        ['id' => '12','parent_id' => '2','is_parent' => false,'slug' => 'privod','title' => 'Привод','title_short' => 'Привод','ord' => '7','is_active' => true],
        ['id' => '13','parent_id' => '2','is_parent' => false,'slug' => 'transmissija','title' => 'Трансмиссия','title_short' => 'Трансмиссия','ord' => '13','is_active' => true],
        ['id' => '14','parent_id' => '2','is_parent' => false,'slug' => 'kolesnye-chasti','title' => 'Колеса','title_short' => 'Колеса','ord' => '4','is_active' => true],
        ['id' => '15','parent_id' => '2','is_parent' => false,'slug' => 'tormoznaja-sistema','title' => 'Тормозная система','title_short' => 'Тормозная система','ord' => '11','is_active' => true],
        ['id' => '16','parent_id' => '2','is_parent' => false,'slug' => 'sedla-i-podsedely','title' => 'Седла и Штыри','title_short' => 'Седла и Штыри','ord' => '10','is_active' => true],
        ['id' => '17','parent_id' => '2','is_parent' => false,'slug' => 'rulevoe-upravlenie','title' => 'Рулевое управление','title_short' => 'Рулевое управление','ord' => '9','is_active' => true],
        ['id' => '18','parent_id' => '2','is_parent' => false,'slug' => 'trosiki-rubashki-kolpachki','title' => 'Тросики и Рубашки','title_short' => 'Тросики и Рубашки','ord' => '14','is_active' => true],
        ['id' => '19','parent_id' => '3','is_parent' => false,'slug' => 'krylja','title' => 'Крылья','title_short' => 'Крылья','ord' => '10','is_active' => true],
        ['id' => '20','parent_id' => '3','is_parent' => false,'slug' => 'bagazhniki','title' => 'Велобагажники','title_short' => 'Велобагажники','ord' => '2','is_active' => true],
        ['id' => '21','parent_id' => '3','is_parent' => false,'slug' => 'korziny','title' => 'Корзины','title_short' => 'Корзины','ord' => '9','is_active' => true],
        ['id' => '22','parent_id' => '3','is_parent' => false,'slug' => 'zamki','title' => 'Замки','title_short' => 'Замки','ord' => '5','is_active' => true],
        ['id' => '23','parent_id' => '3','is_parent' => false,'slug' => 'sumki','title' => 'Сумки и Рюкзаки','title_short' => 'Сумки и Рюкзаки','ord' => '16','is_active' => true],
        ['id' => '24','parent_id' => '3','is_parent' => false,'slug' => 'rjukzaki','title' => 'Рюкзаки','title_short' => 'Рюкзаки','ord' => '14','is_active' => true],
        ['id' => '25','parent_id' => '3','is_parent' => false,'slug' => 'pitevye-sistemy','title' => 'Фляги','title_short' => 'Фляги','ord' => '19','is_active' => true],
        ['id' => '26','parent_id' => '3','is_parent' => false,'slug' => 'osveshhenie','title' => 'Освещение','title_short' => 'Освещение','ord' => '12','is_active' => true],
        ['id' => '27','parent_id' => '3','is_parent' => false,'slug' => 'gadzhety','title' => 'Электроника','title_short' => 'Электроника','ord' => '21','is_active' => true],
        ['id' => '28','parent_id' => '3','is_parent' => false,'slug' => 'detskie-velokresla','title' => 'Детские велокресла','title_short' => 'Детские велокресла','ord' => '4','is_active' => true],
        ['id' => '29','parent_id' => '3','is_parent' => false,'slug' => 'detskie-aksessuary','title' => 'Детские аксессуары','title_short' => 'Детские аксессуары','ord' => '3','is_active' => true],
        ['id' => '30','parent_id' => '3','is_parent' => false,'slug' => 'trenirovochnye-kolesa','title' => 'Учебные колеса','title_short' => 'Учебные колеса','ord' => '17','is_active' => true],
        ['id' => '31','parent_id' => '3','is_parent' => false,'slug' => 'zvonki','title' => 'Звонки и Клаксоны','title_short' => 'Звонки и Клаксоны','ord' => '7','is_active' => true],
        ['id' => '32','parent_id' => '3','is_parent' => false,'slug' => 'zerkala','title' => 'Зеркала','title_short' => 'Зеркала','ord' => '8','is_active' => true],
        ['id' => '33','parent_id' => '3','is_parent' => false,'slug' => 'podnozhki','title' => 'Подножки','title_short' => 'Подножки','ord' => '13','is_active' => true],
        ['id' => '34','parent_id' => '3','is_parent' => false,'slug' => 'zashhita-pera','title' => 'Защита велосипеда','title_short' => 'Защита велосипеда','ord' => '6','is_active' => true],
        ['id' => '35','parent_id' => '3','is_parent' => false,'slug' => 'suveniry','title' => 'Сувениры','title_short' => 'Сувениры','ord' => '15','is_active' => true],
        ['id' => '36','parent_id' => '4','is_parent' => false,'slug' => 'dzhersi','title' => 'Джерси','title_short' => 'Джерси','ord' => '2','is_active' => true],
        ['id' => '37','parent_id' => '4','is_parent' => false,'slug' => 'kurtki','title' => 'Куртки','title_short' => 'Куртки','ord' => '4','is_active' => true],
        ['id' => '38','parent_id' => '4','is_parent' => false,'slug' => 'shorty','title' => 'Шорты','title_short' => 'Шорты','ord' => '10','is_active' => true],
        ['id' => '39','parent_id' => '4','is_parent' => false,'slug' => 'shtany','title' => 'Штаны','title_short' => 'Штаны','ord' => '11','is_active' => true],
        ['id' => '40','parent_id' => '4','is_parent' => false,'slug' => 'perchatki','title' => 'Перчатки','title_short' => 'Перчатки','ord' => '7','is_active' => true],
        ['id' => '41','parent_id' => '4','is_parent' => false,'slug' => 'golovnye-ubory','title' => 'Головные уборы','title_short' => 'Головные уборы','ord' => '1','is_active' => true],
        ['id' => '42','parent_id' => '4','is_parent' => false,'slug' => 'shlemy','title' => 'Шлемы','title_short' => 'Шлемы','ord' => '9','is_active' => true],
        ['id' => '43','parent_id' => '4','is_parent' => false,'slug' => 'ochki','title' => 'Очки','title_short' => 'Очки','ord' => '6','is_active' => true],
        ['id' => '44','parent_id' => '4','is_parent' => false,'slug' => 'termobeljo','title' => 'Термо одежда','title_short' => 'Термо одежда','ord' => '8','is_active' => true],
        ['id' => '45','parent_id' => '4','is_parent' => false,'slug' => 'obuv','title' => 'Обувь','title_short' => 'Обувь','ord' => '5','is_active' => true],
        ['id' => '46','parent_id' => '4','is_parent' => false,'slug' => 'zashhita','title' => 'Защита','title_short' => 'Защита','ord' => '3','is_active' => true],
        ['id' => '50','parent_id' => '3','is_parent' => false,'slug' => 'hranenie','title' => 'Хранение','title_short' => 'Хранение','ord' => '18','is_active' => true],
        ['id' => '51','parent_id' => '3','is_parent' => false,'slug' => 'avtobagazhniki','title' => 'Автобагажники','title_short' => 'Автобагажники','ord' => '1','is_active' => true],
        ['id' => '52','parent_id' => '3','is_parent' => false,'slug' => 'fljagoderzhateli','title' => 'Флягодержатели','title_short' => 'Флягодержатели','ord' => '20','is_active' => true],
        ['id' => '53','parent_id' => '3','is_parent' => false,'slug' => 'Nasosy','title' => 'Насосы','title_short' => 'Насосы','ord' => '11','is_active' => true],
        ['id' => '54','parent_id' => '2','is_parent' => false,'slug' => 'pedali','title' => 'Педали','title_short' => 'Педали','ord' => '6','is_active' => true],
        ['id' => '55','parent_id' => '2','is_parent' => false,'slug' => 'tormoznye-kolodki','title' => 'Тормозные колодки','title_short' => 'Тормозные колодки','ord' => '12','is_active' => true],
        ['id' => '56','parent_id' => '6','is_parent' => false,'slug' => 'prokat-velosipedov','title' => 'Прокат велосипедов','title_short' => 'Прокат велосипедов','ord' => '1','is_active' => true],
        ['id' => '57','parent_id' => '6','is_parent' => false,'slug' => 'remont-obsluzhivanie-velosipedov','title' => 'Ремонт и обслуживание велосипедов','title_short' => 'Ремонт и обслуживание','ord' => '2','is_active' => true]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->dataRows as $row) {
            $row['created_at'] = NOW();
            $row['updated_at'] = NOW();
            DB::table('categories')->insert($row);
        }
    }
}
