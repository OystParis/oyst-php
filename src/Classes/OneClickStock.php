<?php

namespace Oyst\Classes;

/**
 * Class OneClickStock
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickStock implements OystArrayInterface
{
    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $skuReference;

    public function __construct($quantity, $skuReference)
    {
        $this->quantity = (int)$quantity;
        $this->skuReference = $skuReference;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return OneClickStock
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int)$quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getSkuReference()
    {
        return $this->skuReference;
    }

    /**
     * @param string $skuReference
     *
     * @return OneClickStock
     */
    public function setSkuReference($skuReference)
    {
        $this->skuReference = $skuReference;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $stock = array(
            'quantity' => $this->quantity,
            'product_reference' => $this->skuReference,
        );

        return $stock;
    }
}
