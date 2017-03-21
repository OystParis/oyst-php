<?php

/**
 * Class OystApiClient
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
abstract class OystApiClient
{
    /**
     * @param \Guzzle\Service\Client $client
     * @param string                 $apiKey
     * @param string                 $userAgent
     */
    public function __construct($client, $apiKey, $userAgent)
    {
        $this->client    = $client;
        $this->apiKey    = $apiKey;
        $this->userAgent = $userAgent;
    }

    /**
     * @param string $commandName
     * @param array  $params
     */
    protected function executeCommand($commandName, $params)
    {
        $command = $this->client->getCommand($commandName, $params);
        $responseModel = $this->client->execute($command);

        return $responseModel;
    }
}
