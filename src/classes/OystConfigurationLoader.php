<?php

/**
 * Class OystConfigurationLoader
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystConfigurationLoader
{
    /** @var  string */
    private $configurationFile;

    /**
     * @var \Symfony\Component\Yaml\Parser
     */
    private $yamlParser;

    /** @var  array */
    private $parameters;

    /**
     * @param \Symfony\Component\Yaml\Parser $yamlParser
     */
    public function __construct(Yampee_Yaml_Parser $yamlParser)
    {
        $this->configurationFile = __DIR__.'/../config.yml';
        $this->yamlParser = $yamlParser;
    }

    /**
     * @throws Exception
     *
     * @return $this
     */
    public function load()
    {
        if (!file_exists($this->configurationFile)) {
            throw new Exception('Configuration file missing: '.$this->configurationFile);
        }

        if (isset($this->parameters)) {
            return $this;
        }

        $this->parameters = $this->yamlParser->parse(file_get_contents($this->configurationFile));

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
