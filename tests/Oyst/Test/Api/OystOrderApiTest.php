<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Guzzle\Service\Resource\Model;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOrderApi;
use Oyst\Test\OystApiContext;

/**
 * Class OystOrderApiTest
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOrderApiTest extends OystApiContext
{
    /**
     * @param Response $fakeResponse
     * @param string   $apiKey
     * @param string   $userAgent
     *
     * @return OystOrderApi
     */
    public function getApi($fakeResponse, $apiKey, $userAgent)
    {
        $client = $this->createClientTest(OystApiClientFactory::ENTITY_ORDER, $fakeResponse);
        $orderApi = new OystOrderApi($client, $apiKey, $userAgent);

        return $orderApi;
    }

    /**
     * @dataProvider fakeData
     */
    public function testOkGetOrders($apiKey, $userAgent)
    {
        $json = '{"total_items": "400", "total_pages": "40", "orders": [{"id": 1, "product_reference": "sku"}, {"id": 2, "product_amount": {"value": 5000, "currency": "EUR", "param_supp": "test"}}, {"id": 3, "param_supp": "test"}]}';
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), $json);
        $orderApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        /** @var Model $result */
        $result = $orderApi->getOrders();

        $this->assertEquals($orderApi->getLastHttpCode(), 200);
        $this->assertEquals($result->get('totalItems'), '400');
        $this->assertEquals($result->get('totalPages'), '40');
        $this->assertEquals($result->get('unknownProperty'), null);
        $this->assertTrue(is_array($result->get('items')));
        $this->assertEquals(count($result->get('items')), 3);
    }

    /**
     * @dataProvider fakeData
     */
    public function testKoGetOrders($apiKey, $userAgent)
    {
        $fakeResponse = new Response(404, array('Content-Type' => 'application/json'), '{"statusCode": 404, "error": "Not Found"}');
        $orderApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $orderApi->getOrders();

        $this->assertEquals($orderApi->getLastHttpCode(), 404);
        $this->assertEquals($orderApi->getLastError(), 'Not Found');
        $this->assertTrue(is_null($result));
    }
}
