<?php

/**
 *
 * Class APIHelper
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
abstract class OystAPIHelper
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var OystApiConfigurationLoader
     */
    protected $apiConfigurationLoader;

    /** @var  bool */
    protected $hadError;

    /** @var   */
    private $lastError;

    /**
     * @param OystApiConfigurationLoader $apiConfigurationLoader
     * @param string $apiKey
     * @param string $userAgent
     * @internal param $url
     * @internal param string $apiEndPoint
     */
    public function __construct(OystApiConfigurationLoader $apiConfigurationLoader, $apiKey, $userAgent)
    {
        $this->apiKey      = $apiKey;
        $this->userAgent   = $userAgent;
        $this->apiConfigurationLoader = $apiConfigurationLoader;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array  $data
     *
     * @return mixed $response The result on success, false on failure
     *
     * @throws Exception
     */
    final protected function send($method, $endpoint, $data = array())
    {
        $this->hadError = false;
        $this->lastError = '';
        $url = $this->apiConfigurationLoader->getApiUrl().
            '/v'.$this->apiConfigurationLoader->getVersion().
            $endpoint
        ;

        $dataJson = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: '.strlen($dataJson),
            'User-Agent: '.$this->userAgent,
            'Authorization: Bearer '.$this->apiKey
        ));

        if ($data && in_array($method, array('POST', 'PUT'))) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        }

        $response = curl_exec($ch);
        if (!$response) {
            $this->hadError = true;
            $this->lastError =  curl_errno($ch);
        }

        curl_close($ch);

        return $response;
    }

    /**
     * @return bool
     */
    public function hadError()
    {
        return $this->hadError;
    }

    /**
     * @return mixed
     */
    public function getLastError()
    {
        return $this->lastError;
    }
}
