<?php

namespace Oyst\Classes;

/**
 * Class OneClickShipmentCatalogLess
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickShipmentCatalogLess implements OystArrayInterface
{
    /**
     * @var OystPrice
     */
    private $amount;

    /**
     * @var int In hours
     */
    private $delay;

    /**
     * @var bool Define if shipping mode is primary
     */
    private $primary;

    /**
     * @var OystCarrier Details about carrier
     */
    private $carrier;

    /**
     * @return OystPrice
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param OystPrice $amount
     */
    public function setAmount(OystPrice $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * In hours
     *
     * @param int $delay
     */
    public function setDelay($delay)
    {
        $this->delay = (int)$delay;
    }

    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param bool $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = (bool)$primary;
    }

    /**
     * @return OystCarrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param OystCarrier $carrier
     */
    public function setCarrier(OystCarrier $carrier)
    {
        $this->carrier = $carrier;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $oneClickShipmentCatalogLess = array(
            'amount' => $this->amount instanceof OystPrice ? $this->amount->toArray() : array(),
            'delay' => $this->delay,
            'primary' => $this->primary,
            'carrier' => $this->carrier instanceof OystCarrier ? $this->carrier->toArray() : array(),
        );

        return $oneClickShipmentCatalogLess;
    }
}
