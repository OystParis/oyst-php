<?php

namespace Oyst\Classes;

/**
 * Class OystShipment
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystShipment implements OystArrayInterface
{
    /**
     * @var int
     */
    private $freeShipping;

    /**
     * @var bool
     */
    private $primary;

    /**
     * @var ShipmentAmount
     */
    private $amount;

    /**
     * @var OystCarrier
     */
    private $carrier;

    /**
     * @var int
     */
    private $delay;

    /**
     * @var string[]
     */
    private $zones;

    public function __construct()
    {
        $this->zones = array();
    }

    /**
     * @return int
     */
    public function getFreeShipping()
    {
        return $this->freeShipping;
    }

    /**
     * @param type $delay
     *
     * @return MerchantShipment
     */
    public function setFreeShipping($freeShipping)
    {
        $this->freeShipping = $freeShipping;
    }

    /**
     * @return bool
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param bool $delay
     *
     * @return MerchantShipment
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    /**
     * @return ShipmentAmount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param ShipmentAmount $delay
     *
     * @return MerchantShipment
     */
    public function setAmount(ShipmentAmount $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return OystCarrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param OystCarrier $delay
     *
     * @return MerchantShipment
     */
    public function setCarrier(OystCarrier $carrier)
    {
        $this->carrier = $carrier;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param int $delay
     *
     * @return MerchantShipment
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return string[]
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * @param string[] $zones
     *
     * @return MerchantShipment
     */
    public function setZones($zones)
    {
        $this->zones = $zones;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $shipment = array(
            'free_shipping' => $this->freeShipping,
            'primary' => $this->primary,
            'amount' => $this->amount instanceof ShipmentAmount ? $this->amount->toArray() : array(),
            'carrier' => $this->carrier instanceof OystCarrier ? $this->carrier->toArray() : array(),
            'delay' => $this->delay,
            'zones' => $this->zones
        );

        return $shipment;
    }
}
