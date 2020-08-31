<?php

namespace App\Services\Wishlist;

use App\Repositories\Frontend\Appliance\ApplianceRepository;
use Illuminate\Support\Facades\Storage;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use Mfa\Application\Command\UpdateOrCreateApplianceCommand;
use Mfa\Domain\ApplianceCategory;
use Mfa\Domain\ApplianceId;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\Collection;

class SmallAppliancesCrawler
{
    use DispatchesCommands;

    const BASE_DOMAIN = 'https://www.kainos.lt';
    const SMALL_APPLIANCES_URL = self::BASE_DOMAIN . '/smulki-buitine-technika';

    /**
     * @var ApplianceRepository
     */
    private $applianceRepository;

    /**
     * SmallAppliancesCrawler constructor.
     * @param ApplianceRepository $applianceRepository
     */
    public function __construct(ApplianceRepository $applianceRepository)
    {
        $this->applianceRepository = $applianceRepository;
    }

    /**
     * @param callable $callbackAfterPageLoaded
     * @param callable $callbackAfterItemProcessed
     */
    public function importData(callable $callbackAfterPageLoaded, callable $callbackAfterItemProcessed)
    {
        $dom = new Dom;
        $pageIndex = 1;

        do {
            $this->loadPage($callbackAfterPageLoaded, $pageIndex, $dom);
            $products = $this->parseProductList($callbackAfterItemProcessed, $dom);
            $pageIndex++;
        } while ($products->count() > 0);
    }

    /**
     * @param callable $callbackAfterPageLoaded
     * @param $pageIndex
     * @param Dom $dom
     */
    private function loadPage(callable $callbackAfterPageLoaded, $pageIndex, Dom $dom)
    {
        $pageUrl = $this->buildResultsPageUrl($pageIndex);
        $dom->loadFromUrl($pageUrl);
        $callbackAfterPageLoaded($pageUrl);
    }

    /**
     * @param callable $callbackAfterItemProcessed
     * @param Dom $dom
     * @return array|Collection
     */
    private function parseProductList(callable $callbackAfterItemProcessed, $dom)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $products = $dom->find('.product-tile');

        /** @var Collection $product */
        foreach ($products as $product) {
            $data = $this->parseProduct($product);
            $this->importProductImage($data);
            $this->dispatch(UpdateOrCreateApplianceCommand::fromData($data));
            $callbackAfterItemProcessed($data);
        }

        return $products;
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProduct($product)
    {
        $productId = $this->parseProductId($product);
        $data['appliance_id'] = ApplianceId::generate();
        $data['external_id'] = $productId;
        $data['title'] = $this->parseProductTile($product);
        $data['description'] = $this->parseProductDescription($product);
        $data['product_url'] = $this->parseProductUrl($product);
        $data['image'] = $productId;
        $data['image_url'] = $this->parseProductImageUrl($product);
        $data['category'] = ApplianceCategory::SMALL_APPLIANCE;
        $data['price_amount'] = $this->parseProductPriceAmount($product);
        $data['price_currency'] = 'EUR'; // All product prices are in euros.
        return $data;
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProductTile($product)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $product->find('h3.title')->innerHtml();
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProductDescription($product)
    {
        return '';
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProductUrl($product)
    {
        /** @noinspection PhpUndefinedMethodInspection */
       return self::BASE_DOMAIN . $product->find('a')->getAttribute('href');
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProductId($product)
    {
        $productUrl = $this->parseProductUrl($product);
        if (preg_match("/\/(\d+)$/", $productUrl, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProductImageUrl($product)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $product->find('.image-container img')->getAttribute('src');
    }

    /**
     * @param $product
     * @return mixed
     */
    private function parseProductPriceAmount($product)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $price = $product->find('.price')->innerHtml();
        $price = str_replace('€', '', $price);
        $price = str_replace(',', '', $price);
        $price = str_replace('nuo', '', $price);
        $price = trim($price);
        $priceInCents = round($price * 100);
        return $priceInCents;
    }

    /**
     * @param array $data
     */
    private function importProductImage(array $data)
    {
        $imageName = $data['external_id'];
        /** @noinspection PhpUndefinedMethodInspection */
        Storage::put("public/appliances/$imageName", file_get_contents($data['image_url']), 'public');
    }

    /**
     * @param $pageIndex
     * @return string
     */
    private function buildResultsPageUrl($pageIndex)
    {
        return self::SMALL_APPLIANCES_URL . "?page=$pageIndex";
    }
}