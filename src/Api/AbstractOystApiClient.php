<?php

namespace Oyst\Api;

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Service\Client;

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

    /**
     * @var mixed
     */
    private $response;

    /**
     * @var string
     */
    private $body;

    /** @var  string */
    private $notifyUrl;

    /**
     * @param Client $client
     * @param string $apiKey
     * @param string $userAgent
     */
    public function __construct(Client $client, $apiKey, $userAgent)
    {
        $this->client    = $client;
        $this->apiKey    = $apiKey;
        $this->userAgent = $userAgent;
    }

    /**
     * Execute the command described in the description_[entityName].json file
     *
     * @param string $commandName
     * @param array  $params
     *
     * @return mixed
     */
    protected function executeCommand($commandName, $params = array())
    {
        $this->response = null;

        try {
            $command = $this->client->getCommand($commandName, $params);

            $request = $command->prepare();
            $headers = array(
                'Authorization'  => 'Bearer '.$this->apiKey,
                'User-Agent'     => $this->userAgent,
            );

            if (isset($this->notifyUrl)) {
                $headers['oyst-notification-url'] = $this->notifyUrl;
            }

            $request->setHeaders($headers);

            $this->response     = $command->execute();
            $this->lastError    = false;
            $this->lastHttpCode = $command->getResponse() ? $command->getResponse()->getStatusCode() : 200;
            $this->body         = $command->getResponse()->getBody(true);
        } catch (BadResponseException $e) {
            $this->body = $e->getResponse()->getBody(true);
            $responseBody = json_decode($this->body, true);

            $this->lastError = false;
            $this->lastHttpCode = $e->getResponse()->getStatusCode();
            if (isset($responseBody['error'])) {
                if (is_array($responseBody['error']) && isset($responseBody['error']['message'])) {
                    $this->lastError = $responseBody['error']['message'];
                } else {
                    $this->lastError = $responseBody['error'];
                }
            } elseif (isset($responseBody['message'])) {
                $this->lastError = $responseBody['message'];
            } else {
                $this->lastError = $responseBody;
            }
        } catch (RequestException $e) {
            $this->lastError    = $e->getMessage();
            $this->lastHttpCode = $e->getCode();
        } catch (\Exception $e) {
            $this->lastError    = $e->getMessage();
            $this->lastHttpCode = $e->getCode();
        }

        return $this->response;
    }

    /**
     * Get the error of the last command executed
     *
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Get the HTTP Status Code of the last command executed
     *
     * @return int
     */
    public function getLastHttpCode()
    {
        return $this->lastHttpCode;
    }

    /**
     * Get the response of the last command executed
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the body of the last command executed
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $notifyUrl
     * @return AbstractOystApiClient
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }
}
