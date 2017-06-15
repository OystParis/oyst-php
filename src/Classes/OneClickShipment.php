<?php

namespace Oyst\Classes;

/**
 * Class OneClickShipment
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickShipment implements OystArrayInterface
{
    const HOME_DELIVERY = 'home_delivery';
    const PICKUP_DELIVERY = 'pickup';

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
     * @param int $freeShipping
     *
     * @return OneClickShipment
     *
     */
    public function setFreeShipping($freeShipping)
    {
        $this->freeShipping = $freeShipping * 100;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param bool $primary
     *
     * @return OneClickShipment
     *
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * @return ShipmentAmount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param ShipmentAmount $amount
     *
     * @return OneClickShipment
     *
     */
    public function setAmount(ShipmentAmount $amount)
    {
        $this->amount = $amount;

        return $this;
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
     *
     * @return OneClickShipment
     *
     */
    public function setCarrier(OystCarrier $carrier)
    {
        $this->carrier = $carrier;

        return $this;
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
     * @return OneClickShipment
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
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
     * @return OneClickShipment
     */
    public function setZones($zones)
    {
        $this->zones = $zones;

        return $this;
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
