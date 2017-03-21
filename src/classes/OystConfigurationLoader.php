<?php

class OystConfigurationLoader
{
    /** @var  string */
    private $configurationFile;

    /**
     * @var Yampee_Yaml_Parser
     */
    private $yamlParser;

    /** @var  array */
    private $parameters;

    /**
     * OystConfigurationLoader constructor
     * @param Yampee_Yaml_Parser $yamlParser
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

        if (!isset($this->parameters)) {
            $this->parameters = $this->yamlParser->parse(file_get_contents($this->configurationFile));
        }

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