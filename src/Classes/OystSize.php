<?php

namespace Oyst\Classes;

/**
 * Class OystSize
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
        $this->setHeight($height);
        $this->setWidth($width);
        $this->setDepth($depth);
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
     *
     * @return OystSize
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;

        return $this;
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
     *
     * @return OystSize
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;

        return $this;
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
     *
     * @return OystSize
     */
    public function setDepth($depth)
    {
        $this->depth = (int) $depth;

        return $this;
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
