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
    // 7.0.1
    private static $version = array(
        'major' => '7',
        'minor' => '0',
        'patch' => '1',
    );

    const ENTITY_CATALOG = 'catalog';
    const ENTITY_ORDER = 'order';
    const ENTITY_PAYMENT = 'payment';
    const ENTITY_ONECLICK = 'oneclick';

    const ENV_SANDBOX = 'sandbox';
    const ENV_PROD = 'prod';
    const ENV_CUSTOM = 'custom';

    /**
     * Get the current version string
     *
     * @return string
     */
    public static function getVersion()
    {
        $version = self::$version;

        return trim("{$version['major']}.{$version['minor']}.{$version['patch']}");
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
    public static function getClient(
        $entityName,
        $apiKey,
        OystUserAgent $userAgent,
        $env = self::ENV_PROD,
        $customUrl = null
    ) {
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
        $serviceDescription = new ServiceDescription();
        $description = $serviceDescription->factory($configurationFile);

        return $description;
    }

    /**
     * Server environments
     *
     * @return array
     */
    public static function getEnvironments()
    {
        return array(
            self::ENV_SANDBOX,
            self::ENV_PROD,
            self::ENV_CUSTOM,
        );
    }
}
