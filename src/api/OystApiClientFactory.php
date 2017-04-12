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
    const ENTITY_CATALOG  = 'catalog';
    const ENTITY_ORDER    = 'order';
    const ENTITY_PAYMENT  = 'payment';
    const ENTITY_ONECLICK = 'oneclick';

    const ENV_PROD    = 'prod';
    const ENV_PREPROD = 'preprod';
    const ENV_INT     = 'integration';
    const ENV_TEST    = 'test';

    /**
     * @param string $apiKey
     * @param string $userAgent
     * @param string $environment
     *
     * @return AbstractOystApiClient
     *
     * @throws Exception
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
                throw new Exception('Entity not managed or do not exist: '.$entityName);
                break;
        }

        return $oystClientAPI;
    }

    /**
     * @param string $entityName
     * @param string $environment
     *
     * @return \Guzzle\Service\Client
     */
    private static function createClient($entityName, $environment = self::ENV_PROD)
    {
        $configurationLoader = static::getApiConfiguration($entityName, $environment);
        $description = static::getApiDescription($entityName);

        $baseUrl = $configurationLoader->getApiUrl();

        if (!in_array($environment, [static::ENV_INT]) && !in_array($entityName, [static::ENTITY_ONECLICK])) {
            $baseUrl = $configurationLoader->getApiUrl().'/'.$description->getApiVersion();
        }

        $client = new \Guzzle\Service\Client($baseUrl);
        $client->setDescription($description);

        return $client;
    }

    /**
     * @return OystApiConfiguration
     */
    private static function getApiConfiguration($entity, $environment)
    {
        $parametersFile = __DIR__.'/../config/parameters.yml';
        $parserYml      = new \Symfony\Component\Yaml\Parser();
        $configuration  = new OystApiConfiguration($parserYml, $parametersFile);
        $configuration->load();
        $configuration->setEnvironment($environment);
        $configuration->setEntity($entity);

        return $configuration;
    }

    /**
     * @return \Guzzle\Service\Description\ServiceDescription
     */
    private static function getApiDescription($entityName)
    {
        $configurationFile = __DIR__.'/../config/description_'.$entityName.'.json';
        $description       = \Guzzle\Service\Description\ServiceDescription::factory($configurationFile);

        return $description;
    }
}
