<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOneClickApi;
use Oyst\Test\OystApiContext;

/**
 * Class OystOneClickApiTest for unitary tests
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOneClickApiTest extends OystApiContext
{
    /**
     * @param string $apiKey
     * @param string $userAgent
     * @param Response $fakeResponse
     *
     * @return OystOneClickApi
     */
    public function getApi($apiKey, $userAgent, $fakeResponse = null)
    {
        if (is_null($fakeResponse)) {
            $fakeResponse = new Response(
                200,
                array('Content-Type' => 'application/json'),
                '{"url": "http://localhost/success"}'
            );
        }

        $client = $this->createClientTest(OystApiClientFactory::ENTITY_ONECLICK, $fakeResponse);
        $oneClickApi = new OystOneClickApi($client, $apiKey, $userAgent);

        return $oneClickApi;
    }

    /**
     * Catalog order with simple product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderForCatalogOrderWithSimpleProduct($apiKey, $userAgent)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder('test', 42);
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog order with variation product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderForCatalogOrderWithVariationProduct($apiKey, $userAgent)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder('test', 42, 'test');
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog order with simple product dematerialize
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderForCatalogOrderWithSimpleProductDematerialize($apiKey, $userAgent)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder('test', 42, null, null, 1, null, null);
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderForCatalogLessOrderWithSimpleProduct($apiKey, $userAgent, $product)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder('test', 42, null, null, 1, $product);
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with variation product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderForCatalogLessOrderWithVariationProduct($apiKey, $userAgent, $product)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder('test', 42, 'test', null, 1, $product);
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product dematerialize
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderForCatalogLessOrderWithSimpleProductDematerialize($apiKey, $userAgent, $product)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder('test', 42, 'test', null, 1, $product, null);
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }
}
