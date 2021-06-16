<?php

namespace App\Console\Commands;

use SimpleXMLElement;
use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImagesUploader;

class ParseVeloplaneta extends Command
{
    private const XML_URL = '/app/storage/xml/veloplaneta.xml';
    private const MAX_RUNS = 100;
    private const DEFAULT_ACTIVE = false;
    private const IGNORED_PARAMS = [
        'Не отображать на сайте',
    ];
    private const CATEGORY_MAP = [
        "что-02-0311688" => 0,   // Pride
        "акс" => 0,              // Аксессуары
        "что-02-0348160" => 7,   // Звонки
        "что-02-0348180" => 6,   // Защита пера
        "что-02-0348181" => 13,   // Подножки
        "что-02-0348182" => 8,   // Зеркала
        "что-02-0348183" => 15,   // Сувениры
        "что-02-0348185" => 17,   // Тренировочные колеса
        "что-02-0348192" => 9,   // Крепления для телефонов
        "что-02-0349635" => 3,   // Детские аксессуары
        "что-02-0359437" => 21,   // Велокомпьютеры и пульсометры
        "что-02-0348191" => 21,   // Велокомпьютеры
        "что-02-0348193" => 21,   // Пульсометры
        "что-02-0348172" => 12,   // Освещение
        "что-02-0348186" => 12,   // Комплект переднего и заднего света
        "что-02-0348187" => 12,   // Мигалка передняя
        "что-02-0348188" => 12,   // Мигалка задняя
        "что-02-0348189" => 12,   // Велосипедные фары
        "что-02-0348190" => 12,   // Фонари
        "что-02-0348174" => 10,   // Крылья
        "что-02-0359424" => 10,   // Крылья на детский велосипед
        "что-02-0359425" => 10,   // Крылья на взрослый велосипед
        "что-02-0348175" => 2,   // Багажники
        "что-02-0359433" => 2,   // Передний багажник
        "что-02-0359434" => 2,   // Задний багажник
        "что-02-0348176" => 9,   // Корзины
        "что-02-0359435" => 9,   // Корзины на детский велосипед
        "что-02-0359436" => 9,   // Корзины на взрослый велосипед
        "что-02-0348177" => 5,   // Замки
        "что-02-0359426" => 5,   // U-Lock замки
        "что-02-0359427" => 5,   // Цепные замки
        "что-02-0359428" => 5,   // Замок-трос
        "что-02-0359429" => 5,   // Сегментные замки
        "что-02-0348178" => 0,   // Питьевые системы
        "что-02-0348194" => 0,   // Гидраторы
        "что-02-0348195" => 19,   // Фляги
        "что-02-0348196" => 20,   // Флягодержатели
        "что-02-0348179" => 16,   // Сумки
        "что-02-0348155" => 14,   // Рюкзаки
        "что-02-0359499" => 16,   // Сумки на велосипед
        "что-02-0359501" => 16,   // Кейсы для перевозки велосипеда
        "что-02-0348184" => 4,   // Велокресла
        "что-02-0348197" => 4,   // Аксессуары к велокреслам
        "что-02-0348199" => 4,   // Тележки
        "что-02-0359430" => 4,   // Передние кресла
        "что-02-0359431" => 4,   // Задние кресла на подседельную трубу
        "что-02-0359432" => 4,   // Задние кресла на багажник
        "что-02-0348534" => 0,   // Спортивное питание
        "что-02-0359438" => 0,   // Гели
        "что-02-0359439" => 0,   // Батончики
        "что-02-0359440" => 0,   // Изотонические напитки
        "что-02-0359441" => 0,   // Таблетки
        "что-02-0311625" => 0,   // Акция
        "что-02-0340289" => 0,   // Запчасти супер акция
        "с213" => 0,             // Велосипеды
        "что-02-0347825" => 1,   // Горные
        "что-02-0347826" => 1,   // Городские / Гибриды
        "что-02-0347827" => 1,   // Шоссейные
        "что-02-0347828" => 1,   // Детские
        "что-02-0347829" => 1,   // Беговелы
        "что-02-0347830" => 0,   // Самокаты
        "что-02-0350451" => 1,   // BMX / Dirt Jump
        "что-02-0354892" => 1,   // Гравийные
        "что-02-0311607" => 0,   // Зимние товары
        "WhSKID-49387" => 0,     // Ледоступы
        "что-02-0349169" => 0,   // Зимняя защита
        "что-02-0349171" => 0,   // Перчатки
        "что-02-0311330" => 0,   // Одежда и защита
        "что-02-0347233" => 0,   // Куртки
        "что-02-0347243" => 0,   // Защита наколенники, налокотники
        "что-02-0349151" => 0,   // Бахилы
        "что-02-0347236" => 0,   // Штаны
        "что-02-0359465" => 0,   // Штаны с лямками
        "что-02-0359466" => 0,   // Штаны без лямок
        "что-02-0347237" => 0,   // Шорты
        "что-02-0359449" => 0,   // Шорты с лямками
        "что-02-0359450" => 0,   // Шорты без лямок
        "что-02-0359451" => 0,   // Велосипедный памперс
        "что-02-0347238" => 0,   // Термобельё
        "что-02-0359492" => 0,   // Термокофты
        "что-02-0359493" => 0,   // Термоноски
        "что-02-0347239" => 0,   // Перчатки
        "что-02-0359480" => 0,   // Перчатки с пальцами
        "что-02-0359481" => 0,   // Перчатки без пальцев
        "что-02-0347240" => 0,   // Головные уборы
        "что-02-0359484" => 0,   // Шапки, балаклавы, подшлемники
        "что-02-0359485" => 0,   // Банданы, утеплители шеи
        "что-02-0347241" => 0,   // Очки
        "что-02-0359489" => 0,   // Очки с комплектом сменных линз
        "что-02-0359490" => 0,   // Очки с одной линзой
        "что-02-0347242" => 0,   // Обувь
        "что-02-0359491" => 0,   // Обувь МТБ
        "что-02-0359559" => 0,   // Обувь шоссе
        "что-02-0359418" => 0,   // Джерси
        "что-02-0347234" => 0,   // Джерси длинный рукав
        "что-02-0347235" => 0,   // Джерси короткий рукав
        "что-02-0359474" => 0,   // Повседневная одежда
        "что-02-0359475" => 0,   // Футболки
        "что-02-0359476" => 0,   // Кофты
        "что-02-0359477" => 0,   // Утеплители
        "что-02-0359478" => 0,   // Утеплители для рук
        "что-02-0359479" => 0,   // Утеплители для ног
        "что-02-0347256" => 3,   // Шлемы
        "что-02-0359486" => 3,   // Детские шлемы
        "что-02-0359487" => 3,   // Взрослые шлемы
        "что-02-0359576" => 3,   // Аксессуары для шлемов
        "что-02-0339526" => 0,   // Cannondale
        "что-02-0348530" => 0,   // Компоненты Cannondale Lefty
        "что-02-0348531" => 0,   // Специфические ключи и запчасти Cannondale
        "что-02-0311547" => 0,   // Компоненты
        "с222" => 0,             // Рамы и запчасти для рам
        "что-02-0348283" => 1,   // Рамы
        "что-02-0348284" => 3,   // Запчасти для рам
        "что-02-0311603" => 5,   // Колесные части
        "что-02-0337031" => 8,   // Покрышки
        "что-02-0337032" => 5,   // Втулки передние
        "что-02-0337033" => 5,   // Спицы
        "что-02-0311579" => 5,   // Колеса
        "что-02-0337035" => 5,   // Обода
        "что-02-0348289" => 5,   // Втулки задние
        "что-02-0348290" => 5,   // Ниппели
        "что-02-0348291" => 8,   // Ободные ленты
        "что-02-0348292" => 8,   // Камеры
        "что-02-0348293" => 5,   // Колпачки для камер, накладки на спицы
        "что-02-0348294" => 5,   // Эксцентрики, оси
        "что-02-0311328" => 10,   // Седла, подседелы
        "что-02-0348324" => 10,   // Седла
        "что-02-0348325" => 10,   // Подседельные трубы
        "что-02-0348326" => 10,   // Хомуты
        "что-02-0348285" => 2,   // Вилки, амортизаторы
        "что-02-0348286" => 2,   // Вилки
        "что-02-0348295" => 13,   // Трансмиссия
        "что-02-0348296" => 7,   // Переключатели передние
        "что-02-0348297" => 7,   // Переключатели задние
        "что-02-0348298" => 7,   // Ручки переключения
        "что-02-0348299" => 7,   // Успокоители, натяжители цепи
        "что-02-0348300" => 7,   // Ролики
        "что-02-0348301" => 14,   // Тросики, рубашки и колпачки
        "что-02-0348302" => 14,   // Тросики
        "что-02-0348303" => 14,   // Рубашки
        "что-02-0348304" => 14,   // Колпачки
        "что-02-0348305" => 7,   // Привод
        "что-02-0348306" => 13,   // Шатуны
        "что-02-0348307" => 13,   // Звезды к шатунам
        "что-02-0348308" => 13,   // Каретки
        "что-02-0348309" => 6,   // Педали
        "что-02-0348311" => 6,   // Компоненты к педалям
        "что-02-0348314" => 13,   // Задние звезды
        "что-02-0348316" => 13,   // Цепи
        "что-02-0348317" => 13,   // Болты шатунов, бонки
        "что-02-0348318" => 11,   // Тормозные системы
        "что-02-0348319" => 12,   // Тормозные колодки
        "что-02-0348320" => 11,   // Дисковые тормоза
        "что-02-0348321" => 11,   // Ободные тормоза
        "что-02-0348322" => 11,   // Тормозные ручки
        "что-02-0348323" => 11,   // Компоненты к тормозам
        "что-02-0348327" => 9,   // Рулевое управление
        "что-02-0348328" => 9,   // Рули
        "что-02-0348329" => 9,   // Рулевые колонки
        "что-02-0348330" => 9,   // Выносы руля
        "что-02-0348331" => 9,   // Рога
        "что-02-0348332" => 9,   // Баренды, замки
        "что-02-0348333" => 9,   // Грипсы
        "что-02-0348334" => 9,   // Обмотка руля
        "что-02-0311329" => 0,   // Инструменты и обслуживание
        "что-02-0348073" => 0,   // Инструменты
        "что-02-0348090" => 0,   // Одиночные ключи
        "что-02-0348091" => 0,   // Мультитулы
        "что-02-0348092" => 0,   // Для цепи
        "что-02-0348093" => 0,   // Для кассеты и трещотки
        "что-02-0348094" => 0,   // Для каретки, шатунов и педалей
        "что-02-0348095" => 0,   // Спицные ключи и станки
        "что-02-0348096" => 0,   // Ремкомплекты для шин
        "что-02-0348097" => 0,   // Насосы
        "что-02-0348100" => 0,   // Кусачки, плоскогубцы, ножницы
        "что-02-0348103" => 0,   // Прессы и слесарное оборудование
        "что-02-0348137" => 0,   // Для тормозов
        "что-02-0348102" => 0,   // Оборудование для мастерской
        "что-02-0348101" => 0,   // Наборы инструмента для механика
        "что-02-0348074" => 13,   // Смазки
        "что-02-0348083" => 13,   // Для цепи
        "что-02-0348084" => 13,   // Для подшипников
        "что-02-0348085" => 0,   // Пасты для сборки велосипеда
        "что-02-0348171" => 13,   // Для вилок
        "что-02-0348075" => 0,   // Мойки, очистители
        "что-02-0348077" => 0,   // Цепемойки
        "что-02-0348078" => 13,   // Очистители
        "что-02-0348079" => 13,   // Щетки
        "что-02-0348076" => 18,   // Хранение велосипеда
        "что-02-0348081" => 18,   // Подвесные системы
        "что-02-0348082" => 18,   // Напольные стойки
        "что-02-0311659" => 0,   // Рекламные материалы
        "что-02-0311706" => 0,   // Рекламные материалы Cannondale
        "что-02-0346039" => 0,   // Промо-материалы
        "1985701" => 0,          // На замену
        "что-02-0339657" => 0,   // Cannondale
        "что-02-0347340" => 0,   // Pride образцы
        "что-02-0353286" => 0,   // Образцы Pride 2020
        "что-02-0360306" => 0,   // Mavic
    ];
    protected $signature = 'parse:veloplaneta {xmlPath?}';
    protected $description = 'Parse Veloplaneta XML';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): string
    {
        $counter = 0;
        $xml = simplexml_load_file($this->argument('xmlPath') ?? self::XML_URL);

        if (empty($xml->shop->categories->category) || empty($xml->shop->offers->offer)) {
            return "Xml file is empty";
        }

        foreach ($xml->shop->offers->offer as $offer) {
            if ($counter >= self::MAX_RUNS) {
                break;
            }
            $productSku = (string)$offer->vp_sku;
            $categoryId = self::CATEGORY_MAP[(string)$offer->categoryId];
            $category = Category::where('id', $categoryId)->where('is_parent', false)->first();

            if ($category && !$this->productExists($productSku) && $this->hasPicture($offer)) {
                $offerData = $this->parseOfferData($offer);
                $product = $category->products()->firstOrCreate($offerData);
                $product->features = $this->mapFeatures($offer->param, $category);
                $product->save();
                $product->images = ImagesUploader::upload([(string)$offer->picture], $product->imagesStoragePath);
                $product->save();
                $counter++;
            }
        }

        return "Parsed $counter new items";
    }

    private function hasPicture(SimpleXMLElement $offer): bool
    {
        return !empty((string)$offer->picture) && get_headers((string)$offer->picture)[0] === 'HTTP/1.1 200 OK';
    }

    private function productExists(string $productCode): bool
    {
        return Product::where('code', $productCode)->exists();
    }

    private function parseOfferData(SimpleXMLElement $offer): array
    {
        $category_id = self::CATEGORY_MAP[(string)$offer->categoryId];
        $is_active = self::DEFAULT_ACTIVE;
        $name = trim((string)$offer->name);
        $code = trim((string)$offer->vp_sku);
        $barcode = trim((string)$offer->barcode);
        $brand = trim(ucwords(strtolower((string)$offer->brand)));
        $description = trim((string)$offer->description);
        [$title, $model] = strpos($name, $brand) ? preg_split("/" . preg_quote($brand) . "/i", $name) : [null, $name];
        $title = trim($title);
        $model = trim($model);

        return compact([
            'category_id',
            'is_active',
            'code',
            'barcode',
            'title',
            'brand',
            'model',
            'description',
        ]);
    }

    private function mapFeatures(object $offerParams, Category $category): array
    {
        foreach ($offerParams as $param) {
            $title = (string)$param->attributes()->name;

            if (!in_array($title, self::IGNORED_PARAMS)) {
                $feature = $category->features()->firstOrCreate([
                    'parent_id' => 0,
                    'title' => $title,
                    'type' => 'string',
                ]);
                $featuresMap['f' . $feature->id] = (string)$param;
            }
        }

        return $featuresMap ?? [];
    }
}
