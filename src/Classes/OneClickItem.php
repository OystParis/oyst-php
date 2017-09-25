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
     *
     * @var string
     */
    private $reference;

    /**
     * @var int
     */
    private $quantity;

    /**
     * Optional
     *
     * @var string
     */
    private $message;

    /**
     * Optional
     *
     * @var OystPrice
     */
    private $amountOriginal;

    /**
     * Optional
     *
     * @var OystPrice
     */
    private $amountPromotional;

    /**
     * Constructs a OneClickItem instance.
     *
     * @param string $reference
     * @param int $quantity
     */
    public function __construct($reference, $quantity)
    {
        $this->reference = $reference;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return OneClickItem
     */
    public function setReference($reference)
    {
        $this->reference = (string)$reference;

        return $this;
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
     * @return OneClickItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int)$quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return OneClickItem
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmountOriginal()
    {
        return $this->amountOriginal;
    }

    /**
     * @param OystPrice $amountOriginal
     *
     * @return OneClickItem
     */
    public function setAmountOriginal(OystPrice $amountOriginal)
    {
        $this->amountOriginal = $amountOriginal;

        return $this;
    }

    /**
     * @return OystPrice
     */
    public function getAmountPromotional()
    {
        return $this->amountPromotional;
    }

    /**
     * @param OystPrice $amountPromotional
     *
     * @return OneClickItem
     */
    public function setAmountPromotional(OystPrice $amountPromotional)
    {
        $this->amountPromotional = $amountPromotional;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $oneClickItem = array(
            'reference' => $this->reference,
            'quantity' => $this->quantity,
            'message' => $this->message,
            'amount' => array(
                'original' => $this->amountOriginal instanceof OystPrice ? $this->amountOriginal->toArray() : array(),
                'promotional' => $this->amountPromotional instanceof OystPrice ? $this->amountPromotional->toArray() :
                    array(),
            ),
        );

        return $oneClickItem;
    }
}
