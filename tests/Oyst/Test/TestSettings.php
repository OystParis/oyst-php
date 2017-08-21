<?php

namespace Oyst\Test;

use Oyst\Classes\OystUserAgent;
use Symfony\Component\Yaml\Parser;

class TestSettings
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $env;

    /** @var OystUserAgent */
    private $userAgent;

    /** @var string */
    private $parametersFile;

    /** @var int */
    private $orderId;

    public function __construct()
    {
        $this->setParameterFile('parameters_api.yml');
    }

    public function load()
    {
        $userAgent = 'Test';
        if (isset($this->parametersFile) && file_exists($this->parametersFile)) {
            $parserYml = new Parser();
            $parameters = $parserYml->parse(file_get_contents($this->parametersFile));
            $paramsTest = $parameters['test'];
            $this->apiKey = $paramsTest['apiKey'];
            $this->env = $paramsTest['env'];
            $userAgent = $paramsTest['userAgent'];
            $this->orderId = $paramsTest['orderId'];
        }

        // Look for environment
        $this->apiKey = ($apiKey = getenv('API_KEY')) ? $apiKey : $this->apiKey;
        $this->env = ($env = getenv('API_ENV')) ? $env : $this->env;
        $userAgent = ($userAgentEnv = getenv('API_USER_AGENT')) ? $userAgentEnv : $userAgent;
        $this->userAgent = new OystUserAgent($userAgent, '', '', 'php', phpversion());
        $this->orderId = ($orderId = getenv('API_ORDER_ID')) ? $orderId : $this->orderId;
    }

    /**
     * @param $file
     * @return $this
     */
    public function setParameterFile($file)
    {
        $this->parametersFile = __DIR__ . '/../../../src/Config/' . $file;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
