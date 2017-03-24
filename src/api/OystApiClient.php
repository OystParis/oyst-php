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
     * @var string
     */
    private $lastError;

    /**
     * @var int
     */
    private $lastHttpCode;

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
     *
     * @return mixed
     */
    protected function executeCommand($commandName, $params = [])
    {
        $response = null;
        $command  = $this->client->getCommand($commandName, $params);

        try {
            $request = $command->prepare();
            $request->setHeaders(array(
                'Authorization'  => 'Bearer '.$this->apiKey,
                'User-Agent'     => $this->userAgent,
            ));
            $response = $command->execute();

            $this->lastError    = "";
            $this->lastHttpCode = "";
        } catch (\Exception $e) {
            $this->lastError    = $e->getMessage();
            $this->lastHttpCode = $e->getCode();
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * @return int
     */
    public function getLastHttpCode()
    {
        return $this->lastHttpCode;
    }
}
