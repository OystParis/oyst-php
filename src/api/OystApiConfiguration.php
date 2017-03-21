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
    private $allowedVersions;

    /** @var array */
    private $allowedEnvironments;

    /** @var string */
    private $entity;

    /** @var array */
    private $allowedEntities;

    /**
     * @param \Symfony\Component\Yaml\Parser $yamlParser
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
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        if (in_array($version, $this->allowedVersions)) {
            $this->version = $version;
        }

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
     * @param $environment
     *
     * @return $this
     */
    public function setEnvironment($environment)
    {
        if (in_array($environment, $this->allowedEnvironments)) {
            $this->environment = $environment;
        }

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
     *
     * @return $this
     */
    public function setEntity($entity)
    {
        if (in_array($entity, $this->allowedEntities)) {
            $this->entity = $entity;
        }

        return $this;
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
    public function getDefault()
    {
        return $this->getParameters()['default'];
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
        $this->allowedVersions = $this->getSettings()['allowed_versions'];
        $this->allowedEnvironments = $this->getSettings()['allowed_environments'];
        $this->allowedEntities = $this->getSettings()['allowed_entities'];

        $this->setEnvironment($this->getDefault()['environment']);
        $this->setVersion($this->getDefault()['version']);

        return $this;
    }
}
