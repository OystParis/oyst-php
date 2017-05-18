<?php

namespace Oyst\Test;

use Symfony\Component\Yaml\Parser;

class TestSettings
{
    /** @var  string */
    private $apiKey;

    /** @var  string */
    private $env;

    /** @var  string */
    private $userAgent;

    /** @var  string */
    private $parametersFile;

    private $orderId;

    public function __construct()
    {
        $this->setParameterFile('parameters_api.yml');
    }

    public function load()
    {
        if (isset($this->parametersFile)) {
            $parserYml = new Parser();
            $params = $parserYml->parse(file_get_contents($this->parametersFile))['test'];
            $this->apiKey = $params['apiKey'];
            $this->env = $params['env'];
            $this->userAgent = $params['userAgent'];
            $this->userAgent = $params['orderId'];
        }

        // Look for environment
        $this->apiKey = ($apiKey = getenv('API_KEY')) ? $apiKey : $this->apiKey;
        $this->env = ($env = getenv('API_ENV')) ? $env : $this->env;
        $this->userAgent = ($userAgent = getenv('API_USER_AGENT')) ? $userAgent : $this->userAgent;
        $this->orderId = ($orderId = getenv('API_ORDER_ID')) ? $orderId : $this->orderId;
    }

    /**
     * @param $file
     * @return $this
     */
    public function setParameterFile($file)
    {
        $this->parametersFile = __DIR__.'/../../../src/config/'.$file;

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
