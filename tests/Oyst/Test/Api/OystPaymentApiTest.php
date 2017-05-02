<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystPaymentApi;
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
}
