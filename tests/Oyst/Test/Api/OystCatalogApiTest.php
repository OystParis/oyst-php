<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystCatalogApi;
use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;
use Oyst\Test\OystApiContext;

/**
 * Class OystCatalogApiTest
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCatalogApiTest extends OystApiContext
{
    /**
     * @param Response $fakeResponse
     * @param string   $apiKey
     * @param string   $userAgent
     *
     * @return OystCatalogApi
     */
    public function getApi($fakeResponse, $apiKey, $userAgent)
    {
        $client = $this->createClientTest(OystApiClientFactory::ENTITY_CATALOG, $fakeResponse);
        $catalogApi = new OystCatalogApi($client, $apiKey, $userAgent);

        return $catalogApi;
    }

    /**
     * @dataProvider fakeData
     */
    public function testPostProducts($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"imported": 2}');
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);

        $products = array();
        $product = new OystProduct();
        $product->setRef('sku1');
        $product->setTitle('my title');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost'));

        $info = array(
            'meta'     => 'info en vrac',
            'subtitle' => 'test'
        );
        $product->setAvailableQuantity(5);
        $product->setDescription('qdgsdfg');
        $product->setEan('my_ean');
        $product->setIsbn('my_isbn');
        $product->setActive(true);
        $product->setMaterialized(true);
        $product->setInformation($info);
        $product->setManufacturer('my manufacturer');
        $product->addRelatedProduct('ref_related');
        $product->setShortDescription('short description');
        $product->setSize(new OystSize(42, 42, 42));
        $product->addTag('test');
        $product->setUpc('my_upc');
        $product->setUrl('http://localhost');
        $products[] = $product;

        $product = new OystProduct();
        $product->setRef('sku2');
        $product->setTitle('my title');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost'));

        $products[] = $product;

        $result = $catalogApi->postProducts($products);

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(!is_null($result['imported']));
    }

    /**
     * @dataProvider fakeData
     */
    public function testDeleteProduct($apiKey, $userAgent)
    {
        $fakeResponse = new Response(404, array('Content-Type' => 'application/json'), '{"error": {"code": "CAT-404", "message": "product-not-found"}}');
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $catalogApi->deleteProduct('1-1');

        $this->assertEquals($catalogApi->getLastHttpCode(), 404);
        $this->assertEquals($catalogApi->getLastError(), 'product-not-found');
        $this->assertTrue(is_null($result));
    }

    /**
     * @dataProvider fakeData
     */
    public function testNotifyImport($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"import_id": "fake_uuid"}');
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $catalogApi->notifyImport();

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(!is_null($result['import_id']));
    }
}
