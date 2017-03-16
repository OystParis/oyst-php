<?php

require_once(__DIR__.'/../../autoload.php');

/**
 * Class OystCategory
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCategory implements OystArrayInterface
{
    /**
     * Optional
     *
     * @var string
     */
    private $ref;

    /**
     * Mandatory
     *
     * @var bool
     */
    private $main;

    /**
     * Optional
     *
     * @var string
     */
    private $title;

    /**
     * @param string $ref
     * @param string $title
     * @param bool   $isMain
     */
    public function __construct($ref, $title, $isMain = false)
    {
        $this->ref    = $ref;
        $this->title  = $title;
        $this->isMain = $isMain;
    }

    /**
     * @return string
     */
    private function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     *
     * @return OystCategory
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMain()
    {
        return $this->main;
    }

    /**
     * @param bool $main
     *
     * @return OystCategory
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return string
     */
    private function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return OystCategory
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $category = array(
            'reference' => $this->getRef(),
            'is_main'   => $this->isMain(),
            'title'     => $this->getTitle(),
        );

        return $category;
    }
}
