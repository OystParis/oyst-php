<?php

namespace Oyst\Classes;

/**
 * Class OystCarrier
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCarrier implements OystArrayInterface
{
    const HOME_DELIVERY = 'home_delivery';
    const MONDIAL_RELAY = 'mondial_relay';
    const PICKUP_DELIVERY = 'pickup';

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $identifier
     * @param string $name
     * @param string $type
     */
    public function __construct($identifier, $name, $type)
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     *
     * @return OystCarrier
     */
    public function setId($identifier)
    {
        $this->identifier = (string)$identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return OystCarrier
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return OystCarrier
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        $shippingTypes = array(self::HOME_DELIVERY, self::MONDIAL_RELAY, self::PICKUP_DELIVERY);
        if (!in_array($type, $shippingTypes)) {
            throw new \InvalidArgumentException('Type ' . $type . ' is not in '. explode(',', $shippingTypes));
        }
        $this->type = (string)$type;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $carrier = array(
            'id' => $this->identifier,
            'name' => $this->name,
            'type' => $this->type,
        );

        return $carrier;
    }
}
