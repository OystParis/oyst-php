<?php

namespace Oyst\Test;

use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Oyst\Api\AbstractOystApiClient;
use Oyst\Api\OystApiClientFactory;

/**
 * Created by PhpStorm.
 * User: ndecraene
 * Date: 02/05/17
 * Time: 16:35
 */
abstract class OystApiContext extends \PHPUnit_Framework_TestCase
{
    /**
     * DataProvider
     *
     * @return array
     */
    public function fakeData()
    {
        return array(
            array('api_key', 'user_agent')
        );
    }

    /**
     * @param Response $fakeResponse
     * @param string   $apiKey
     * @param string   $userAgent
     *
     * @return AbstractOystApiClient
     */
    abstract public function getApi($fakeResponse, $apiKey, $userAgent);

    /**
     * @param string   $entityName
     * @param Response $fakeResponse
     */
    public function createClientTest($entityName, $fakeResponse)
    {
        $reflectionMethod = new \ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiConfiguration');
        $reflectionMethod->setAccessible(true);
        $configuration = $reflectionMethod->invoke(null, $entityName, OystApiClientFactory::ENV_TEST);

        $reflectionMethod = new \ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $description = $reflectionMethod->invoke(null, $entityName);

        $baseUrl = $configuration->getApiUrl();
        $client = new \Guzzle\Service\Client($baseUrl);
        $client->setDescription($description);

        $plugin = new MockPlugin();
        $plugin->addResponse($fakeResponse);
        $client->addSubscriber($plugin);

        return $client;
    }
}
