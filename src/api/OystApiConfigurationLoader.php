<?php

abstract class OystApiConfigurationLoader extends OystConfigurationLoader
{
    const DEFAULT_ENV = 'prod';

    /** @var  int */
    private $version;

    /** @var  string */
    private $environment;

    /** @var  array */
    private $allowedVersions;

    /** @var  array */
    private $allowedEnvironments;

    /** @var  string */
    private $entity;

    /** @var  array */
    private $allowedEntities;

    /**
     * @return array
     */
    final public function getParameters()
    {
        return parent::getParameters()['api'];
    }

    /**
     * @return array
     */
    final public function getEndpoints()
    {
        return $this->getParameters()['endpoints']['v'.$this->version];
    }

    /**
     * @return array
     */
    final public function getCatalogEndpoints()
    {
        return $this->getEndpoints()['catalog'];
    }

    /**
     * @return array
     */
    final public function getOrderEndpoints()
    {
        return $this->getEndpoints()['order'];
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
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->getParameters()['url'][$this->environment][$this->entity];
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
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
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
        parent::load();

        $this->allowedVersions = $this->getSettings()['allowed_versions'];
        $this->allowedEnvironments = $this->getSettings()['allowed_environments'];
        $this->allowedEntities = $this->getSettings()['allowed_entities'];

        $this->setEnvironment($this->getDefault()['environment']);
        $this->setVersion($this->getDefault()['version']);

        return $this;
    }
}
