<?php

namespace Oyst\Test;

use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Service\Client;
use Oyst\Api\AbstractOystApiClient;
use Oyst\Api\OystApiConfiguration;
use Oyst\Classes\OystUserAgent;
use Oyst\Test\Fixture\OneClickNotificationsFixture;
use Oyst\Test\Fixture\OneClickOrderContextFixture;
use Oyst\Test\Fixture\OneClickOrderParamsFixture;
use Oyst\Test\Fixture\ProductFixture;

/**
 * Class OystApiContext
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
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
        $userAgent = new OystUserAgent('test', '', '', 'php', phpversion());

        $productFixture = new ProductFixture();
        $product = $productFixture->getOneClickOrder();

        $oneClickOrderParamsFixture = new OneClickOrderParamsFixture();
        $oneClickOrderParams = $oneClickOrderParamsFixture->getOrderParams();

        $oneClickOrderContextFixture = new OneClickOrderContextFixture();
        $oneClickOrderContext = $oneClickOrderContextFixture->getOrderContext();

        $oneClickNotificationsFixture = new OneClickNotificationsFixture();
        $oneClickNotifications = $oneClickNotificationsFixture->getNotifications();

        return array(
            array('api_key', $userAgent, $product, $oneClickOrderParams, $oneClickOrderContext, $oneClickNotifications)
        );
    }

    /**
     * @param Response $fakeResponse
     * @param string $apiKey
     * @param string $userAgent
     *
     * @return AbstractOystApiClient
     */
    abstract public function getApi($fakeResponse, $apiKey, $userAgent);

    /**
     * @param string $entityName
     * @param Response $fakeResponse
     *
     * @return Client
     */
    public function createClientTest($entityName, $fakeResponse)
    {
        $reflectionMethod = new \ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiConfiguration');
        $reflectionMethod->setAccessible(true);

        /** @var OystApiConfiguration $configuration */
        $configuration = $reflectionMethod->invoke(null, $entityName, null, 'https://localhost');

        $reflectionMethod = new \ReflectionMethod('Oyst\Api\OystApiClientFactory', 'getApiDescription');
        $reflectionMethod->setAccessible(true);
        $description = $reflectionMethod->invoke(null, $entityName);

        $baseUrl = $configuration->getBaseUrl();
        $client = new Client($baseUrl);
        $client->setDescription($description);

        $plugin = new MockPlugin();
        $plugin->addResponse($fakeResponse);
        $client->addSubscriber($plugin);

        return $client;
    }
}
