<?php

namespace Oyst\Classes;

/**
 * Class OneClickMerchantDiscount
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickMerchantDiscount implements OystArrayInterface
{
    /**
     * Mandatory
     *
     * @var OystPrice
     */
    private $amount;

    /**
     * Mandatory
     *
     * @var string
     */
    private $name;

    /**
     * Constructs a OneClickMerchantDiscount instance.
     *
     * @param OystPrice $amount
     * @param string $name
     */
    public function __construct(OystPrice $amount, $name)
    {
        $this->amount = $amount;
        $this->name = (string)$name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $oneClickMerchantDiscount = array(
            'amount' => $this->amount->toArray(),
            'name' => $this->name,
        );

        return $oneClickMerchantDiscount;
    }
}
