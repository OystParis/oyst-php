<?php

namespace Oyst\Classes;

/**
 * Class OystProduct
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystProduct implements OystArrayInterface
{
    /**
     * Mandatory
     *
     * @var string
     */
    private $reference;

    /**
     * Mandatory
     *
     * @var string
     */
    private $title;

    /**
     * Mandatory
     *
     * @var OystPrice
     */
    private $amountIncludingTax;

    /**
     * Mandatory
     *
     * @var int
     */
    private $quantity;


    public function __construct($reference, $title, OystPrice $amountIncludingTax, $quantity)
    {
        $this->reference = (string)$reference;
        $this->title = (string)$title;
        $this->amountIncludingTax = $amountIncludingTax;
        $this->quantity = (int)$quantity;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * @param string $property
     * @param array|bool|int|string $value
     *
     * @return $this
     */
    public function __set($property, $value)
    {
        $this->$property = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $product = array(
            'reference' => $this->reference,
            'title' => $this->title,
            'amount_including_taxes' => $this->amountIncludingTax->toArray(),
            'quantity' => $this->quantity,
        );

        foreach (get_object_vars($this) as $property => $value) {
            if (in_array($property, array('reference', 'title', 'amountIncludingTax', 'quantity',))) {
                continue;
            }

            $product[$property] = $value;
        }

        return $product;
    }
}
