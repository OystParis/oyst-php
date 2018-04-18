<?php

namespace Oyst\Test\Api;

use Guzzle\Http\Message\Response;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOneClickApi;
use Oyst\Test\OystApiContext;

/**
 * Class OneClickApiTest for unitary tests
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickApiTest extends OystApiContext
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
     * Catalog less order with simple product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderWithSimpleProduct($apiKey, $userAgent, $product)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder(
            'test',
            42,
            null,
            null,
            1,
            $product
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with variation product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderWithVariationProduct($apiKey, $userAgent, $product)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder(
            'test',
            42,
            'test',
            null,
            1,
            $product
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product dematerialize
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderWithSimpleProductDematerialize($apiKey, $userAgent, $product)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder(
            'test',
            42,
            'test',
            null,
            1,
            $product,
            null
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product and order params
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderWithSimpleProductAndOrderParams(
        $apiKey,
        $userAgent,
        $product,
        $oneClickOrderParams
    ) {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder(
            'test',
            42,
            'test',
            null,
            1,
            $product,
            $oneClickOrderParams
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product and context
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderWithSimpleProductAndContext($apiKey, $userAgent, $product, $oneClickOrderContext)
    {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder(
            'test',
            42,
            'test',
            null,
            1,
            $product,
            null,
            $oneClickOrderContext
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product and context
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderWithSimpleProductAndNotification(
        $apiKey,
        $userAgent,
        $product,
        $oneClickOrderParams,
        $oneClickOrderContext,
        $oneClickNotifications
    ) {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrder(
            'test',
            42,
            'test',
            null,
            1,
            $product,
            null,
            null,
            $oneClickNotifications
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }

    /**
     * Catalog less order with simple product
     *
     * @dataProvider fakeData
     */
    public function testAuthorizeOrderV2WithSimpleProduct(
        $apiKey,
        $userAgent,
        $product,
        $oneClickOrderParams,
        $oneClickOrderContext,
        $oneClickNotifications,
        $user
    ) {
        /** @var OystOneClickAPI $oneClickApi */
        $oneClickApi = $this->getApi($apiKey, $userAgent);

        $result = $oneClickApi->authorizeOrderv2(
            array($product),
            $oneClickNotifications,
            $user,
            $oneClickOrderParams,
            $oneClickOrderContext
        );
        $this->assertEquals($oneClickApi->getLastHttpCode(), 200);
        $this->assertEquals($result['url'], 'http://localhost/success');
    }
}
