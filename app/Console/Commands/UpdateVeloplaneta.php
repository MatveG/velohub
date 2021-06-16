<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class UpdateVeloplaneta extends Command
{
    private const XML_URL = '/app/storage/xml/price.xml';
    private const STOCK_CODE = 'planeta';
    protected $signature = 'update:veloplaneta {xmlPath?}';
    protected $description = 'Update Veloplaneta stocks';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): string
    {
        $counter = 0;
        $xml = simplexml_load_file($this->argument('xmlPath') ?? self::XML_URL);

        if (empty($xml->shop->offer)) {
            return "Xml file is empty";
        }

        Product::query()->update(['stocks' => ['planeta' => 0]]);

        foreach ($xml->shop->offer as $offer) {
            $counter += Product::where('code', (string)$offer->vp_sku)->update($this->parseData($offer));
        }

        return "Updated $counter products";
    }

    private function parseData(object $offer): array
    {
        $rest = (int)$offer->rest;
        $is_active = $is_stock = $rest > 0;
        $is_sale = (int)$offer->Discount > 0;
        $price = $is_sale ? (int)$offer->RRP_D : (int)$offer->RRP;
        $price_old = $is_sale && (int)$offer->RRP ? (int)$offer->RRP : null;
        $stocks = [self::STOCK_CODE => $rest];

        return compact([
            'is_active',
            'is_stock',
            'is_sale',
            'price',
            'price_old',
            'stocks',
        ]);
    }
}
