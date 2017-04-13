<?php

/**
 * Class AbstractOystApiClient
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
abstract class AbstractOystApiClient
{
    /**
     * @var \Guzzle\Service\Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $userAgent;

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
    public function __construct(\Guzzle\Service\Client $client, $apiKey, $userAgent)
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
    protected function executeCommand($commandName, $params = array())
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

            $this->lastError    = false;
            $this->lastHttpCode = $command->getResponse() ? $command->getResponse()->getStatusCode() : 200;
        } catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            $responseBody = json_decode($responseBody, true);
            $errorMessage = is_array($responseBody['error']) && isset($responseBody['error']['message']) ? $responseBody['error']['message'] : (isset($responseBody['message']) ? $responseBody['message'] : $responseBody['error']);

            $this->lastError    = $errorMessage ?: $responseBody;
            $this->lastHttpCode = $e->getResponse()->getStatusCode();
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
