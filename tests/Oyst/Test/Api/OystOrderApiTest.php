<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Guzzle\Service\Resource\Model;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOrderApi;
use Oyst\Classes\OystPrice;
use Oyst\Test\OystApiContext;

/**
 * Class OystOrderApiTest for unitary tests
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
     * @param string $apiKey
     * @param string $userAgent
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
        $json = '{"orders":[],"count":"3"}';
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), $json);
        $orderApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        /** @var Model $result */
        $result = $orderApi->getOrders();

        $this->assertEquals($orderApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['orders']));
        $this->assertEquals($result['count'], 3);
    }

    /**
     * @dataProvider fakeData
     */
    public function testKoGetOrders($apiKey, $userAgent)
    {
        $fakeResponse = new Response(
            404,
            array('Content-Type' => 'application/json'),
            '{"statusCode": 404, "error": "Not Found"}'
        );
        $orderApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $orderApi->getOrders();

        $this->assertEquals($orderApi->getLastHttpCode(), 404);
        $this->assertEquals($orderApi->getLastError(), 'Not Found');
        $this->assertTrue(is_null($result));
    }

    /**
     * @dataProvider fakeData
     */
    public function testRefunds($apiKey, $userAgent)
    {
        $json = '{
    "order": {
        "id": "71e98840-028b-11e8-9727-53a142d36ff7",
        "refunds": [
            {
                "id": "101eeca0-051e-11e8-8910-57362bbc7dea",
                "amount": {
                    "value": 123,
                    "currency": "EUR"
                },
                "refund_id": "102a8560-051e-11e8-a0ff-c3d1b2c8d625",
                "created_at": "2018-01-29T17:58:51.241Z",
                "deleted_at": null,
                "updated_at": "2018-01-29T17:58:51.632Z",
                "aggregate_id": "71e98840-028b-11e8-9727-53a142d36ff7",
                "has_succeeded": true
            }
        ]
    }
}';
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), $json);
        $orderApi = $this->getApi($fakeResponse, $apiKey, $userAgent);

        $price = new OystPrice(1.23, 'EUR');
        /** @var Model $result */
        $result = $orderApi->refunds('71e98840-028b-11e8-9727-53a142d36ff7', $price);

        $this->assertEquals($orderApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['order']));
        $this->assertEquals($result['order']['id'], '71e98840-028b-11e8-9727-53a142d36ff7');
        $this->assertEquals($result['order']['refunds'][0]['id'], '101eeca0-051e-11e8-8910-57362bbc7dea');
    }

    /**
     * @dataProvider fakeData
     */
    public function testUpdateOrders($apiKey, $userAgent)
    {
        $json = '{
    "order": {
        "merchant_order_reference": "test 68"
    }
}';
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), $json);
        $orderApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        /** @var Model $result */
        $result = $orderApi->updateOrder('71e98840-028b-11e8-9727-53a142d36ff7', 'test 68');

        $this->assertEquals($orderApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['order']));
        $this->assertEquals($result['order']['merchant_order_reference'], 'test 68');
    }
}
