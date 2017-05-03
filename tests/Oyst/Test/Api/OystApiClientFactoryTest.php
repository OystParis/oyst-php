<?php

namespace Oyst\Test\Api;

use Guzzle\Service\Client;
use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystApiConfiguration;
use ReflectionMethod;

/**
 * Class OystApiClientFactoryTest
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
            array(OystApiClientFactory::ENTITY_CATALOG, OystApiClientFactory::ENV_TEST, 'https://localhost/catalog/v1'),
            array(OystApiClientFactory::ENTITY_ORDER, OystApiClientFactory::ENV_TEST, 'https://localhost/order/v1'),
            array(OystApiClientFactory::ENTITY_ONECLICK, OystApiClientFactory::ENV_TEST, 'https://localhost/oneclick/v1'),
            array(OystApiClientFactory::ENTITY_PAYMENT, OystApiClientFactory::ENV_TEST, 'https://localhost/payment'),
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function clientDataOk()
    {
        return array(
            array('Oyst\Api\OystCatalogApi', 'catalog', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystPaymentApi', 'payment', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystOrderApi', 'order', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystOneClickApi', 'oneclick', 'api_key', 'user_agent', 'preprod'),
            array('Oyst\Api\OystCatalogApi', 'catalog', 'api_key', 'user_agent', 'unknow_env'),
            array('Oyst\Api\OystPaymentApi', 'payment', 'api_key', 'user_agent', 'unknow_env'),
            array('Oyst\Api\OystOrderApi', 'order', 'api_key', 'user_agent', 'unknow_env'),
            array('Oyst\Api\OystOneClickApi', 'oneclick', 'api_key', 'user_agent', 'unknow_env')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function clientDataException()
    {
        return array(
            array('unknown_entity', 'api_key', 'user_agent', 'preprod')
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function configurationData()
    {
        return array(
            array(OystApiClientFactory::ENTITY_CATALOG, OystApiClientFactory::ENV_TEST, 'catalog', 'test', 'https://localhost/catalog'),
            array(OystApiClientFactory::ENTITY_ORDER, OystApiClientFactory::ENV_TEST, 'order', 'test', 'https://localhost/order'),
            array(OystApiClientFactory::ENTITY_PAYMENT, OystApiClientFactory::ENV_TEST, 'payment', 'test', 'https://localhost/payment'),
            array(OystApiClientFactory::ENTITY_ONECLICK, OystApiClientFactory::ENV_TEST, 'oneclick', 'test', 'https://localhost/oneclick'),
            array('unknown_entity', OystApiClientFactory::ENV_TEST, null, 'test', null),
            array(OystApiClientFactory::ENTITY_CATALOG, 'unknown_env', 'catalog', 'prod', 'https://api.oyst.com/catalog'),
            array('unknown_entity', 'unknown_env', null, 'prod', null),
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
            array('unknown_entity')
        );
    }

    /**
     * @dataProvider clientUrlData
     */
    public function testCreateClient($entityName, $env, $expectedApiUrl)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'createClient');
        $reflectionMethod->setAccessible(true);

        /** @var Client $client */
        $client = $reflectionMethod->invoke($entityName, $entityName, $env);

        $this->assertEquals($client->getBaseUrl(), $expectedApiUrl);

        return $client;
    }

    /**
     * @dataProvider clientDataOk
     */
    public function testOkGetClient($expectedClassName, $entityName, $apiKey, $userAgent, $env)
    {
        $clientApi = OystApiClientFactory::getClient($entityName, $apiKey, $userAgent, $env);

        $this->assertInstanceOf($expectedClassName, $clientApi);
    }

    /**
     * @dataProvider clientDataException
     *
     * @expectedException \Exception
     */
    public function testExceptionGetClient($entityName, $apiKey, $userAgent, $env)
    {
        OystApiClientFactory::getClient($entityName, $apiKey, $userAgent, $env);
    }

    /**
     * @dataProvider configurationData
     */
    public function testApiConfiguration($entityName, $env, $expectedEntity, $expectedEnv, $expectedApiUrl)
    {
        $reflectionMethod = new ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiConfiguration');
        $reflectionMethod->setAccessible(true);
        /** @var OystApiConfiguration $configuration */
        $configuration = $reflectionMethod->invoke(null, $entityName, $env);

        $this->assertEquals($configuration->getEntity(), $expectedEntity);
        $this->assertEquals($configuration->getEnvironment(), $expectedEnv);
        $this->assertEquals($configuration->getApiUrl(), $expectedApiUrl);
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
