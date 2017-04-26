<?php

/**
 * Class AbstractOystApiClient
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
namespace Oyst\Api;

use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Service\Client;

abstract class AbstractOystApiClient
{
    /**
     * @var Client
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

    /** @var  mixed */
    private $response;

    /** @var  string */
    private $body;

    /**
     * @param Client    $client
     * @param string    $apiKey
     * @param string    $userAgent
     */
    public function __construct(Client $client, $apiKey, $userAgent)
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
        $this->response = null;
        $command  = $this->client->getCommand($commandName, $params);

        try {
            $request = $command->prepare();
            $request->setHeaders(array(
                'Authorization'  => 'Bearer '.$this->apiKey,
                'User-Agent'     => $this->userAgent,
            ));
            $this->response = $command->execute();

            $this->lastError    = false;
            $this->lastHttpCode = $command->getResponse() ? $command->getResponse()->getStatusCode() : 200;
            $this->body = $command->getResponse()->getBody();

        } catch (ClientErrorResponseException $e) {
            $this->body = $e->getResponse()->getBody(true);
            $responseBody = json_decode($this->body, true);

            if (is_array($responseBody['error']) && isset($responseBody['error']['message'])) {
                $errorMessage = $responseBody['error']['message'];
            } elseif (isset($responseBody['message'])) {
                $errorMessage = $responseBody['message'];
            } else {
                $errorMessage = $responseBody['error'];
            }

            $this->lastError    = $errorMessage ?: $responseBody;
            $this->lastHttpCode = $e->getResponse()->getStatusCode();
        } catch (\Exception $e) {
            $this->lastError    = $e->getMessage();
            $this->lastHttpCode = $e->getCode();
        }

        return $this->response;
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

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
