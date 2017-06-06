<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OneClickShipment;
use Oyst\Classes\OystCarrier;
use Oyst\Classes\ShipmentAmount;

class OneClickShipmentFixture
{
    /**
     * @return OneClickShipment[]
     */
    public static function getList()
    {
        $shipments = array();
        $shipment = new OneClickShipment();
        $shipment->setAmount(new ShipmentAmount(100, 490, 'EUR'));
        $shipment->setCarrier(new OystCarrier('test1', 'UPS', 'home_delivery'));
        $shipment->setDelay(72);
        $shipment->setFreeShipping(100000);
        $shipment->setPrimary(true);
        $shipment->setZones(array('FR', 'EN', 'IE'));
        $shipments[] = $shipment;

        $shipment = new OneClickShipment();
        $shipment->setAmount(new ShipmentAmount(100, 490, 'EUR'));
        $shipment->setCarrier(new OystCarrier('test2', 'Navette Pick-up', 'pick_up'));
        $shipment->setDelay(72);
        $shipment->setFreeShipping(50000);
        $shipment->setPrimary(false);
        $shipment->setZones(array('FR', 'EN', 'IE'));
        $shipments[] = $shipment;

        return $shipments;
    }
}
