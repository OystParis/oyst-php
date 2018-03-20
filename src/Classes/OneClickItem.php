<?php

namespace Oyst\Classes;

/**
 * Class OneClickItem
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickItem implements OystArrayInterface
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
     * @var OystPrice
     */
    private $amount;

    /**
     * Mandatory
     *
     * @var int
     */
    private $quantity;

    /**
     * Optional
     *
     * @var array
     */
    private $images = array();

    /**
     * Optional
     *
     * @var OystPrice
     */
    private $crossedOutAmount;

    /**
     * Optional
     *
     * @var string
     */
    private $message = '';

    /**
     * Constructs a OneClickItem instance used as item/free_items from API.
     *
     * @param string $reference
     * @param OystPrice $amount
     * @param int $quantity
     */
    public function __construct($reference, OystPrice $amount, $quantity)
    {
        $this->reference = (string)$reference;
        $this->amount = $amount;
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
        $oneClickItem = array(
            'reference' => $this->reference,
            'amount' => $this->amount->toArray(),
            'quantity' => $this->quantity,
            'images' => is_array($this->images) ? $this->images : array(),
            'crossed_out_amount' => $this->crossedOutAmount instanceof OystPrice ? $this->crossedOutAmount->toArray() :
                array(),
            'message' => $this->message,
        );

        foreach (get_object_vars($this) as $property => $value) {
            if (in_array($property, array('reference', 'amount', 'quantity', 'images', 'crossedOutAmount', 'message'))) {
                continue;
            }

            $oneClickItem[$property] = $value;
        }

        return $oneClickItem;
    }
}
