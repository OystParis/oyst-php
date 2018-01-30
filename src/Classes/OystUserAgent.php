<?php

namespace Oyst\Classes;

/**
 * Class OystUserAgent
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystUserAgent
{
    /**
     * @var string
     */
    private $platformName;

    /**
     * @var string
     */
    private $packageVersion;

    /**
     * @var string
     */
    private $platformVersion;

    /**
     * @var string
     */
    private $languageName;

    /**
     * @var string
     */
    private $languageVersion;

    /**
     * @var string
     */
    private $oystUserAgentPattern;

    /**
     * OystUserAgent constructor.
     *
     * @param string $platformName
     * @param string $packageVersion
     * @param string $platformVersion
     */
    public function __construct($platformName, $packageVersion, $platformVersion)
    {
        $this->oystUserAgentPattern = sprintf(
            'Oyst%s /%s (%s %s; %s %s)',
            $platformName,
            $packageVersion,
            $platformName,
            $platformVersion,
            php_sapi_name(),
            phpversion()
        );
    }

    /**
     * @return array
     */
    public function toString()
    {
        return $this->oystUserAgentPattern;
    }
}
