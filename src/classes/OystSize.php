<?php

/**
 * Class OystSize
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystSize implements OystArrayInterface
{
    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $depth;

    /**
     * @param int $height
     * @param int $width
     * @param int $depth
     */
    public function __construct($height, $width, $depth)
    {
        $this->height = $height;
        $this->width  = $width;
        $this->depth  = $depth;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $size = array(
            'height' => $this->height,
            'width'  => $this->width,
            'depth'  => $this->depth
        );

        return $size;
    }
}
