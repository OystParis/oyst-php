<?php

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
    /** @var array */
    private $parameters;

    /** @var int */
    private $version;

    /** @var string */
    private $environment;

    /** @var array */
    private $allowedEnvironments;

    /** @var string */
    private $entity;

    /** @var array */
    private $allowedEntities;

    /**
     * @param \Symfony\Component\Yaml\Parser $yamlParser
     * @param string                         $descriptionFile
     */
    public function __construct(\Symfony\Component\Yaml\Parser $yamlParser, $descriptionFile)
    {
        $this->parametersFile = $descriptionFile;
        $this->yamlParser     = $yamlParser;
    }

    /**
     * @return array
     */
    final public function getParameters()
    {
        return $this->parameters['api'];
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
        return isset($this->getParameters()['url'][$environment]);
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
        return isset($this->getParameters()['url'][$this->environment][$entity]);
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->getParameters()['url'][$this->environment][$this->entity];
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->getParameters()['settings'];
    }

    /**
     * @return array
     */
    public function getDefaultEnvironment()
    {
        return $this->getParameters()['environment'];
    }

    /**
     * @return $this
     */
    public function load()
    {
        if (!file_exists($this->parametersFile)) {
            throw new Exception('Configuration file missing: '.$this->parametersFile);
        }

        if (isset($this->parameters)) {
            return $this;
        }

        $this->parameters = $this->yamlParser->parse(file_get_contents($this->parametersFile));
        $this->allowedEnvironments = $this->getSettings()['allowed_environments'];
        $this->allowedEntities = $this->getSettings()['allowed_entities'];

        $this->setEnvironment($this->getDefaultEnvironment());

        return $this;
    }
}
