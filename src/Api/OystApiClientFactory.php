<?php

namespace Oyst\Api;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Symfony\Component\Yaml\Parser;

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
    const ENTITY_CATALOG  = 'catalog';
    const ENTITY_ORDER    = 'order';
    const ENTITY_PAYMENT  = 'payment';
    const ENTITY_ONECLICK = 'oneclick';

    const ENV_PROD    = 'prod';
    const ENV_PREPROD = 'preprod';
    const ENV_TEST    = 'test';

    /**
     * Returns the right API for the entityName passed in the parameters
     *
     * @param string $entityName
     * @param string $apiKey
     * @param string $userAgent
     * @param string $environment
     *
     * @return AbstractOystApiClient
     *
     * @throws \Exception
     */
    public static function getClient($entityName, $apiKey, $userAgent, $environment = self::ENV_PROD)
    {
        $client = static::createClient($entityName, $environment);

        switch ($entityName) {
            case self::ENTITY_CATALOG:
                $oystClientAPI = new OystCatalogApi($client, $apiKey, $userAgent);
                break;
            case self::ENTITY_ORDER:
                $oystClientAPI = new OystOrderApi($client, $apiKey, $userAgent);
                break;
            case self::ENTITY_PAYMENT:
                $oystClientAPI = new OystPaymentApi($client, $apiKey, $userAgent);
                break;
            case self::ENTITY_ONECLICK:
                $oystClientAPI = new OystOneClickApi($client, $apiKey, $userAgent);
                break;
            default:
                throw new \Exception('Entity not managed or do not exist: '.$entityName);
                break;
        }

        return $oystClientAPI;
    }

    /**
     * Create a Guzzle Client
     *
     * @param string $entityName
     * @param string $environment
     *
     * @return Client
     */
    private static function createClient($entityName, $environment = self::ENV_PROD)
    {
        $configurationLoader = static::getApiConfiguration($entityName, $environment);
        $description = static::getApiDescription($entityName);

        $baseUrl = $configurationLoader->getApiUrl();

        if (!in_array($entityName, array(static::ENTITY_PAYMENT))) {
            $baseUrl .= '/'.$description->getApiVersion();
        }

        $client = new Client($baseUrl);
        $client->setDescription($description);

        return $client;
    }

    /**
     * Create the API Configuration by loading parameters according to the environment passed in parameters
     *
     * @param string $entity
     * @param string $environment
     *
     * @return OystApiConfiguration
     */
    private static function getApiConfiguration($entity, $environment)
    {
        $parametersFile = __DIR__.'/../Config/parameters.yml';
        $parserYml      = new Parser();
        $configuration  = new OystApiConfiguration($parserYml, $parametersFile);
        $configuration->load();
        $configuration->setEnvironment($environment);
        $configuration->setEntity($entity);

        return $configuration;
    }

    /**
     * Returns a Service Description by loading the right json file according to the entityName passed in parameters
     *
     * @param string $entityName
     *
     * @return ServiceDescription
     */
    private static function getApiDescription($entityName)
    {
        $configurationFile = __DIR__.'/../Config/description_'.$entityName.'.json';
        $description       = ServiceDescription::factory($configurationFile);

        return $description;
    }
}
