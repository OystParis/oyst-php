<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystCatalogApi;
use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;
use Oyst\Test\Fixture\OneClickShipmentFixture;
use Oyst\Test\OystApiContext;

/**
 * Class OystCatalogApiTest for unitary tests
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
     * @param string $apiKey
     * @param string $userAgent
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
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"imported": 2}'
        );
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);

        $products = array();
        $price = new OystPrice(42, 'EUR');
        $product = new OystProduct('sku1', 'my title', $price, 1);

        $category = new OystCategory('cat_ref_1', 'cat title 1', true);
        $product->__set('categories', array($category->toArray()));
        $product->__set('images', array('http://localhost'));
        $info = array(
            'meta' => 'info en vrac',
            'subtitle' => 'test',
        );
        $product->__set('availableQuantity', 5);
        $product->__set('description', 'Lorem ipsum');
        $product->__set('ean', 'my_ean');
        $product->__set('isbn', 'my_isbn');
        $product->__set('active', true);
        $product->__set('materialized', true);
        $product->__set('information', $info);
        $product->__set('manufacturer', 'my manufacturer');
        $product->__set('relatedProducts', array('ref_related'));
        $product->__set('shortDescription', 'short description');
        $size = new OystSize(42, 42, 42);
        $product->__set('size', $size->toArray());
        $product->__set('tags', array('test'));
        $product->__set('upc', 'my_upc');
        $product->__set('url', 'http://localhost');
        $products[] = $product;

        $price = new OystPrice(1337, 'EUR');
        $product = new OystProduct('sku2', 'my title', $price, 2);

        $category2 = new OystCategory('cat_ref_2', 'cat title_2', true);
        $product->__set('categories', array($category2->toArray()));
        $product->__set('images', array('http://localhost'));

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
        $fakeResponse = new Response(
            404,
            array('Content-Type' => 'application/json'),
            '{"error": {"code": "CAT-404", "message": "product-not-found"}}'
        );
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
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"import_id": "fake_uuid"}'
        );
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $catalogApi->notifyImport();

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(!is_null($result['import_id']));
    }

    /**
     * @dataProvider fakeData
     */
    public function testGetShipments($apiKey, $userAgent)
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{
                "error": {
                  "code": "CAT-404",
                  "message": "shipments-not-found"
                },
                "merchantId": "merchant_uuid"
            }'
        );
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $catalogApi->getShipments();

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
    }

    /**
     * @dataProvider fakeData
     */
    public function testGetShipmentTypes($apiKey, $userAgent)
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{
                "types": {
                  "home_delivery": "Home delivery",
                  "pick_up": "Navette Pick-up",
                  "mondial_relay": "Mondial Relay"
                }
            }'
        );
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $catalogApi->getShipmentTypes();

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['types']));
        $this->assertTrue(count($result['types']) === 3);
    }

    /**
     * @dataProvider fakeData
     */
    public function testPostShipments($apiKey, $userAgent)
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{
                "shipments": [
                    {
                        "id": "shipment_guid1",
                        "free_shipping": 100000,
                        "merchant_id": "merchant_uuid",
                        "primary": true,
                        "amount": {
                            "currency": "EUR",
                            "follower": 100,
                            "leader": 490
                        },
                        "carrier": {
                            "id": "test1",
                            "name": "UPS",
                            "type": "home_delivery"
                        },
                        "delay": 72,
                        "zones": ["FR", "EN", "IE"]
                    },
                    {
                        "id": "shipment_guid2",
                        "free_shipping": 50000,
                        "merchant_id": "merchant_uuid",
                        "primary": false,
                        "amount": {
                            "currency": "EUR",
                            "follower": 100,
                            "leader": 490
                        },
                        "carrier": {
                            "id": "test2",
                            "name": "Navette Pick-up",
                            "type": "pick_up"
                        },
                        "delay": 72,
                        "zones": ["FR", "EN", "IE"]
                    }
                ]
            }'
        );
        $catalogApi = $this->getApi($fakeResponse, $apiKey, $userAgent);

        $oneClickShipmentFixture = new OneClickShipmentFixture();
        $shipments = $oneClickShipmentFixture->getList();

        $result = $catalogApi->postShipments($shipments);

        $this->assertEquals($catalogApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['shipments']));
        $this->assertTrue(count($result['shipments']) === 2);
    }
}
