<?php

/**
 * Class OystShipment
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystShipment implements OystArrayInterface
{
    /**
     * @var string
     */
    private $zone;

    /**
     * @var string
     */
    private $carrier;

    /**
     * @var string
     */
    private $delay;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $currency;

    /**
     * @return string
     */
    private function getZone()
    {
        return $this->zone;
    }

    /**
     * @param string $zone
     *
     * @return OystShipment
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return string
     */
    private function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param string $carrier
     *
     * @return OystShipment
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;

        return $this;
    }

    /**
     * @return string
     */
    private function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param string $delay
     *
     * @return OystShipment
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * @return string
     */
    private function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return OystShipment
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    private function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return OystShipment
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $shipment = array(
            'zone'    => $this->getZone(),
            'carrier' => $this->getCarrier(),
            'delay'   => $this->getDelay(),
            'amount'  => array(
                'value'    => $this->getValue(),
                'currency' => $this->getCurrency(),
            ),
        );

        return $shipment;
    }
}
