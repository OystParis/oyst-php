<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystPaymentApi;
use Oyst\Classes\OystPrice;
use Oyst\Test\OystApiContext;

/**
 * Class OystPaymentApiTest
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystPaymentApiTest extends OystApiContext
{
    /**
     * @param Response $fakeResponse
     * @param string   $apiKey
     * @param string   $userAgent
     *
     * @return OystPaymentApi
     */
    public function getApi($fakeResponse, $apiKey, $userAgent)
    {
        $client = $this->createClientTest(OystApiClientFactory::ENTITY_PAYMENT, $fakeResponse);
        $paymentApi = new OystPaymentApi($client, $apiKey, $userAgent);

        return $paymentApi;
    }

    /**
     * @dataProvider fakeData
     */
    public function testPayment($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"url": "http://localhost/success"}');
        $paymentApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $paymentApi->payment(123, 'EUR', 3, array(
            'notification' => 'http://localhost.test',
            'cancel' => 'http://localhost.test',
            'error' => 'http://localhost.test',
            'return' => 'http://localhost.test',
        ), true, array(
            'addresses' => array(),
            'billing_addresses' => array(),
            'email' => 'test@oyst.com',
            'first_name' => 'Test',
            'language' => 'fr',
            'last_name' => 'Test',
            'phone' => '0100000000',
        ));

        $this->assertEquals($paymentApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * @dataProvider fakeData
     */
    public function testCancel($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"payment_id": "9eef1d60-3ed1-11e7-8336-1b2205bd98b6", "response": "cancel-received"}');
        $paymentApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $paymentApi->cancelOrRefund('9eef1d60-3ed1-11e7-8336-1b2205bd98b6');

        $this->assertEquals($paymentApi->getLastHttpCode(), 200);
        $this->assertEquals($result['payment_id'], '9eef1d60-3ed1-11e7-8336-1b2205bd98b6');
        $this->assertEquals($result['response'], 'cancel-received');
    }

    /**
     * @dataProvider fakeData
     */
    public function testTotalRefund($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"refund": {"id": "9eef1d60-3ed1-11e7-8336-1b2205bd98b6", "success": true, "status": "refund-received"}}');
        $paymentApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $paymentApi->cancelOrRefund('9eef1d60-3ed1-11e7-8336-1b2205bd98b6');

        $this->assertEquals($paymentApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['refund']));
        $this->assertEquals($result['refund']['id'], '9eef1d60-3ed1-11e7-8336-1b2205bd98b6');
    }

    /**
     * @dataProvider fakeData
     */
    public function testPartialRefund($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"refund": {"id": "9eef1d60-3ed1-11e7-8336-1b2205bd98b6", "success": true, "status": "refund-received"}}');
        $paymentApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $price = new OystPrice(6.66, 'EUR');
        $result = $paymentApi->cancelOrRefund('9eef1d60-3ed1-11e7-8336-1b2205bd98b6', $price);

        $this->assertEquals($paymentApi->getLastHttpCode(), 200);
        $this->assertTrue(is_array($result['refund']));
        $this->assertEquals($result['refund']['id'], '9eef1d60-3ed1-11e7-8336-1b2205bd98b6');
    }
}
