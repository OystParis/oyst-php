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
     * @param string $languageName
     * @param string $languageVersion
     */
    public function __construct($platformName, $packageVersion, $platformVersion, $languageName, $languageVersion)
    {
        $this->oystUserAgentPattern = 'Oyst%PLATFORM_NAME%/%PACKAGE_VERSION% %PLATFORM_NAME% %CMS_VERSION%, %LANGUAGE_NAME% %LANGUAGE_VERSION%)';

        $this->platformName = (string)trim($platformName);
        $this->packageVersion = (string)trim($packageVersion);
        $this->platformVersion = (string)trim($platformVersion);
        $this->languageName = (string)trim($languageName);
        $this->languageVersion = (string)trim($languageVersion);
    }

    /**
     * @return array
     */
    public function toString()
    {
        $data = array(
            "%PLATFORM_NAME%" => $this->platformName,
            "%PACKAGE_VERSION%" => $this->packageVersion,
            "%CMS_VERSION%" => $this->platformVersion,
            "%LANGUAGE_NAME%" => $this->languageName,
            "%LANGUAGE_VERSION%" => $this->languageVersion,
        );

        $userAgent = str_replace(array_keys($data), array_values($data), $this->oystUserAgentPattern);

        return $userAgent;
    }
}
