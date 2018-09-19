<?php

namespace Oyst\Test\Api;

use Guzzle\Service\Client;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystApiConfiguration;
use Oyst\Classes\OystUserAgent;
use ReflectionMethod;

/**
 * Class OystApiClientFactoryTest for unitary tests
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystApiClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * DataProvider
     *
     * @return array
     */
    public function clientUrlData()
    {
        return array(
            // @codingStandardsIgnoreLine
            array(OystApiClientFactory::ENTITY_CATALOG, OystApiClientFactory::ENV_PROD, 'https://localhost', 'https://api-gw.oyst.com/oneclick-api/merchants'),
            array(OystApiClientFactory::ENTITY_ORDER, null, 'https://localhost', 'https://localhost/oneclick-api/merchants'),
            // @codingStandardsIgnoreLine
            array(OystApiClientFactory::ENTITY_ONECLICK, OystApiClientFactory::ENV_PROD, null, 'https://api-gw.oyst.com/oneclick-api'),
            array(OystApiClientFactory::ENTITY_PAYMENT, null, 'https://localhost', 'https://localhost/oneclick-api'),
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function clientUrlDataException()
    {
        return array(
            array(OystApiClientFactory::ENTITY_CATALOG, null, null),
            array('unknown_entity', null, 'https://localhost'),
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function clientDataOk()
    {
        $userAgent = new OystUserAgent('user_agent', '', '');

        return array(
            array('Oyst\Api\OystCatalogApi', 'catalog', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystPaymentApi', 'payment', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystOrderApi', 'order', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystOneClickApi', 'oneclick', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystCatalogApi', 'catalog', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystPaymentApi', 'payment', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystOrderApi', 'order', 'api_key', $userAgent, null, 'https://localhost'),
            array('Oyst\Api\OystOneClickApi', 'oneclick', 'api_key', $userAgent, null, 'https://localhost')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function clientDataException()
    {
        $userAgent = new OystUserAgent('user_agent', '', '');

        return array(
            array('unknown_entity', 'api_key', $userAgent, null, 'https://localhost')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function configurationData()
    {
        $url = 'https://localhost';
        return array(
            array(OystApiClientFactory::ENTITY_CATALOG, null, $url, 'catalog', 'https://localhost/oneclick-api/merchants'),
            array(OystApiClientFactory::ENTITY_ORDER, null, $url, 'order', 'https://localhost/oneclick-api/merchants'),
            array(OystApiClientFactory::ENTITY_PAYMENT, null, $url, 'payment', 'https://localhost/oneclick-api'),
            array(OystApiClientFactory::ENTITY_ONECLICK, null, $url, 'oneclick', 'https://localhost/oneclick-api'),
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function descriptionData()
    {
        return array(
            array('catalog'),
            array('order'),
            array('payment'),
            array('oneclick')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function descriptionDataException()
    {
        return array(
            array('unknown_entity'),
        );
    }

    /**
     * @dataProvider clientUrlData
     */
    public function testCreateClient($entityName, $env, $url, $expectedApiUrl)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'createClient');
        $reflectionMethod->setAccessible(true);

        /** @var Client $client */
        $client = $reflectionMethod->invoke(null, $entityName, $env, $url);

        $this->assertEquals($client->getBaseUrl(), $expectedApiUrl);

        return $client;
    }

    /**
     * @dataProvider clientUrlDataException
     *
     * @expectedException \Exception
     */
    public function testExceptionCreateClient($entityName, $env, $url)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'createClient');
        $reflectionMethod->setAccessible(true);

        /** @var Client $client */
        $reflectionMethod->invoke(null, $entityName, $env, $url);
    }

    /**
     * @dataProvider clientDataOk
     */
    public function testOkGetClient($expectedClassName, $entityName, $apiKey, $userAgent, $env, $url)
    {
        $oystApiClientFactory = new OystApiClientFactory();
        $clientApi = $oystApiClientFactory->getClient($entityName, $apiKey, $userAgent, $env, $url);

        $this->assertInstanceOf($expectedClassName, $clientApi);
    }

    /**
     * @dataProvider clientDataException
     *
     * @expectedException \Exception
     */
    public function testExceptionGetClient($entityName, $apiKey, $userAgent, $env, $url)
    {
        $oystApiClientFactory = new OystApiClientFactory();
        $oystApiClientFactory->getClient($entityName, $apiKey, $userAgent, $env, $url);
    }

    /**
     * @dataProvider configurationData
     */
    public function testApiConfiguration($entityName, $env, $url, $expectedEntity, $expectedApiUrl)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiConfiguration');
        $reflectionMethod->setAccessible(true);
        /** @var OystApiConfiguration $configuration */
        $configuration = $reflectionMethod->invoke(null, $entityName, $env, $url);

        $this->assertEquals($configuration->getEntity(), $expectedEntity);
        $this->assertEquals($configuration->getBaseUrl(), $expectedApiUrl);
    }

    /**
     * @dataProvider descriptionData
     */
    public function testApiDescription($entityName)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $description = $reflectionMethod->invoke(null, $entityName);

        $this->assertInstanceOf('Guzzle\Service\Description\ServiceDescription', $description);
    }

    /**
     * @dataProvider descriptionDataException
     *
     * @expectedException \Exception
     */
    public function testExceptionApiDescription($entityName)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke(null, $entityName);
    }
}
