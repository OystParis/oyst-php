<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOneClickApi;
use Oyst\Test\OystApiContext;

/**
 * Class OystOneClickApiTest
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOneClickApiTest extends OystApiContext
{
    /**
     * @param Response $fakeResponse
     * @param string   $apiKey
     * @param string   $userAgent
     *
     * @return OystOneClickApi
     */
    public function getApi($fakeResponse, $apiKey, $userAgent)
    {
        $client = $this->createClientTest(OystApiClientFactory::ENTITY_ONECLICK, $fakeResponse);
        $oneClickApi = new OystOneClickApi($client, $apiKey, $userAgent);

        return $oneClickApi;
    }

    /**
     * @dataProvider fakeData
     */
    public function testAuthorizeOrder($apiKey, $userAgent)
    {
        $fakeResponse = new Response(200, array('Content-Type' => 'application/json'), '{"url": "http://localhost/success"}');

        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($fakeResponse, $apiKey, $userAgent);
        $result = $oneClickApi->authorizeOrder('test', 666, 'test');

        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }
}
