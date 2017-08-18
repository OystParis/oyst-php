<?php

namespace Oyst\Api;

use Symfony\Component\Yaml\Parser;

/**
 * Class OystApiConfiguration
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystApiConfiguration
{
    /**
     * @var string
     */
    private $parametersFile;

    /**
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $customUrl;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $entity;

    /** @var  \string */
    private $baseUrl;

    /**
     * @param Parser $yamlParser
     * @param string $descriptionFile
     */
    public function __construct(Parser $yamlParser, $descriptionFile)
    {
        $this->parametersFile = $descriptionFile;
        $this->yamlParser = $yamlParser;
    }

    /**
     * @return string
     */
    public function getCustomUrl()
    {
        return $this->customUrl;
    }

    /**
     * @param $customUrl
     *
     * @return $this
     *
     */
    public function setCustomUrl($customUrl)
    {
        $this->customUrl = $customUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     *
     * @return $this
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     * @return $this
     * @throws \Exception
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Load the parameters
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function load()
    {
        if (!file_exists($this->parametersFile)) {
            throw new \Exception('Configuration file missing: ' . $this->parametersFile);
        }

        if (!isset($this->parameters)) {
            $this->parameters = $this->yamlParser->parse(file_get_contents($this->parametersFile));
        }

        if (!is_null($this->customUrl)) {
            $baseUrl = trim($this->customUrl, '/');
        } elseif (isset($this->parameters['api']['env'][$this->environment])) {
            $baseUrl = $this->parameters['api']['env'][$this->environment];
        } else {
            throw new \Exception('Custom url or the environment is missing, did you forgot to set one of them ?');
        }

        if (!isset($this->parameters['api']['path'][$this->entity])) {
            throw new \Exception('Entity doesn\'t exist, please set a valid one');
        }

        $this->baseUrl = $baseUrl . '/' . trim($this->parameters['api']['path'][$this->entity], '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
