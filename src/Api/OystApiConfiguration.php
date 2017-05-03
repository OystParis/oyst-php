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
    /** @var string */
    private $parametersFile;

    /** @var Parser */
    private $yamlParser;

    /** @var array */
    private $parameters;

    /** @var string */
    private $environment;

    /** @var string */
    private $entity;

    /**
     * @param Parser $yamlParser
     * @param string $descriptionFile
     */
    public function __construct(Parser $yamlParser, $descriptionFile)
    {
        $this->parametersFile = $descriptionFile;
        $this->yamlParser     = $yamlParser;
        $this->environment    = OystApiClientFactory::ENV_PROD;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param $environment
     *
     * @return $this
     */
    public function setEnvironment($environment)
    {
        if ($this->isValidEnvironment($environment)) {
            $this->environment = $environment;
        }

        return $this;
    }

    /**
     * @param string $environment
     *
     * @return bool
     */
    private function isValidEnvironment($environment)
    {
        return isset($this->parameters['api']['url'][$environment]);
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
     *
     * @return $this
     */
    public function setEntity($entity)
    {
        if ($this->isValidEntity($entity)) {
            $this->entity = $entity;
        }

        return $this;
    }

    /**
     * @param string $entity
     *
     * @return bool
     */
    private function isValidEntity($entity)
    {
        return isset($this->parameters['api']['url'][$this->environment][$entity]);
    }

    /**
     * @return string|null
     */
    public function getApiUrl()
    {
        if (isset($this->parameters['api']['url'][$this->environment][$this->entity])) {
            return $this->parameters['api']['url'][$this->environment][$this->entity];
        }

        return null;
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
            throw new \Exception('Configuration file missing: '.$this->parametersFile);
        }

        if (!isset($this->parameters)) {
            $this->parameters = $this->yamlParser->parse(file_get_contents($this->parametersFile));
        }

        return $this;
    }
}
