<?php

namespace Oyst\Api;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Oyst\Classes\OystUserAgent;
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
    private static $version = array(
        'major' => '1',
        'minor' => '6',
        'patch' => '0',
    );

    const ENTITY_CATALOG = 'catalog';
    const ENTITY_ORDER = 'order';
    const ENTITY_PAYMENT = 'payment';
    const ENTITY_ONECLICK = 'oneclick';

    const ENV_PROD = 'prod';
    const ENV_PREPROD = 'preprod';

    /**
     * Gets the current version string
     *
     * @return string
     */
    public static function getVersion()
    {
        $ver = self::$version;

        return trim("{$ver['major']}.{$ver['minor']}.{$ver['patch']}");
    }

    /**
     * Returns the right API for the entityName passed in the parameters
     *
     * @param string $entityName
     * @param string $apiKey
     * @param OystUserAgent $userAgent
     * @param string $env
     * @param string $customUrl
     *
     * @return AbstractOystApiClient
     *
     * @throws \Exception
     */
    public static function getClient($entityName, $apiKey, OystUserAgent $userAgent, $env = self::ENV_PROD, $customUrl = null)
    {
        $client = static::createClient($entityName, $env, $customUrl);

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
                throw new \Exception('Entity not managed or do not exist: ' . $entityName);
                break;
        }

        return $oystClientAPI;
    }

    /**
     * Create a Guzzle Client
     *
     * @param string $entityName
     * @param string $env
     * @param string $customUrl
     *
     * @return Client
     */
    private static function createClient($entityName, $env, $customUrl)
    {
        $configurationLoader = static::getApiConfiguration($entityName, $env, $customUrl);
        $description = static::getApiDescription($entityName);

        $url = $configurationLoader->getBaseUrl();

        if (!in_array($entityName, array(static::ENTITY_PAYMENT))) {
            $url .= '/' . $description->getApiVersion();
        }

        $client = new Client($url);
        $client->setDescription($description);

        return $client;
    }

    /**
     * Create the API Configuration by loading parameters according to the env or the url passed in parameters
     *
     * @param string $entity
     * @param string $env
     * @param string $customUrl
     *
     * @return OystApiConfiguration
     */
    private static function getApiConfiguration($entity, $env, $customUrl)
    {
        $parametersFile = __DIR__ . '/../Config/parameters.yml';
        $parserYml = new Parser();
        $configuration = new OystApiConfiguration($parserYml, $parametersFile);
        $configuration->setEnvironment($env);
        $configuration->setCustomUrl($customUrl);
        $configuration->setEntity($entity);
        $configuration->load();

        return $configuration;
    }

    /**
     * Returns a Service Description by loading the right JSON file according to the entityName passed in parameters
     *
     * @param string $entityName
     *
     * @return ServiceDescription
     */
    private static function getApiDescription($entityName)
    {
        $configurationFile = __DIR__ . '/../Config/description_' . $entityName . '.json';
        $description = ServiceDescription::factory($configurationFile);

        return $description;
    }
}
