<?php

/**
 * Class OystApiClientFactory
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystApiClientFactory
{
    /**
     * @param string $apiKey
     * @param string $userAgent
     *
     * @return OystCatalogAPI
     */
    public static function createCatalogApiClient($apiKey, $userAgent)
    {
        $client     = self::createClient('catalog');
        $catalogApi = new OystCatalogAPI($client, $apiKey, $userAgent);

        return $catalogApi;
    }

    /**
     * @param string $apiKey
     * @param string $userAgent
     *
     * @return OystOrderAPI
     */
    public static function createOrderApiClient($apiKey, $userAgent)
    {
        $client   = self::createClient('order');
        $orderApi = new OystOrderAPI($client, $apiKey, $userAgent);

        return $orderApi;
    }

    /**
     * @param string $apiKey
     * @param string $userAgent
     *
     * @return OystPaymentAPI
     */
    public static function createPaymentApiClient($apiKey, $userAgent)
    {
        $client     = self::createClient('payment');
        $paymentApi = new OystPaymentAPI($client, $apiKey, $userAgent);

        return $paymentApi;
    }

    /**
     * @param string $apiKey
     * @param string $userAgent
     *
     * @return OystOrderAPI
     */
    public static function createOneClickApiClient($apiKey, $userAgent)
    {
        $client   = self::createClient('oneclick');
        $orderApi = new OystOrderAPI($client, $apiKey, $userAgent);

        return $orderApi;
    }

    /**
     * @param string $apiKey
     * @param string $userAgent
     *
     * @return \Guzzle\Service\Client
     */
    private static function createClient($entity)
    {
        $configurationLoader = self::getApiConfiguration($entity);
        $description = self::getApiDescription();

        $baseUrl = $configurationLoader->getApiUrl();
        //$baseUrl = trim($configurationLoader->getApiUrl(), '/').'/'.$description->getApiVersion();

        $client = new \Guzzle\Service\Client($baseUrl);
        $client->setDescription($description);

        return $client;
    }

    /**
     * @return OystApiConfiguration
     */
    private static function getApiConfiguration($entity)
    {
        $parametersFile = __DIR__.'/../config/parameters.yml';
        $parserYml      = new \Symfony\Component\Yaml\Parser();
        $configuration  = new OystApiConfiguration($parserYml, $parametersFile);
        $configuration->load();
        $configuration->setEntity($entity);

        return $configuration;
    }

    /**
     * @return \Guzzle\Service\Description\ServiceDescription
     */
    private static function getApiDescription()
    {
        $configurationFile = __DIR__.'/../config/description.json';
        $description       = \Guzzle\Service\Description\ServiceDescription::factory($configurationFile);

        return $description;
    }
}
