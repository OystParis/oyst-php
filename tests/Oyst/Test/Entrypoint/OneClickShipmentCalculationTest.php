<?php

namespace Oyst\Test\Entrypoint;

use Guzzle\Http\Message\Response;
use Oyst\Classes\OneClickItem;
use Oyst\Classes\OneClickShipmentCalculation;
use Oyst\Classes\OneClickShipmentCatalogLess;
use Oyst\Classes\OystCarrier;
use Oyst\Classes\OystPrice;

/**
 * Class OneClickShipmentCalculationTest for unitary tests
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickShipmentCalculationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the OneClickShipmentCalculation endpoint data minimum required
     */
    public function testOneClickShipmentCalculationRequired()
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"shipments":[{"amount":{"value":490,"currency":"EUR"},"delay":48,"primary":true,"carrier":{"id":"colissimo","name":"Colissimo","type":"home_delivery"}}]}'
        );

        $colissimo = new OneClickShipmentCatalogLess(
            new OystPrice(4.90, 'EUR'),
            48,
            new OystCarrier('colissimo', 'Colissimo', 'home_delivery'),
            true
        );
        $shipments[] = $colissimo;

        $oneClickShipmentCalculation = new OneClickShipmentCalculation($shipments);

        $this->assertEquals(
            $fakeResponse->getBody(true),
            $oneClickShipmentCalculation->toJson()
        );
    }

    /**
     * Test the OneClickShipmentCalculation endpoint data full
     */
    public function testOneClickShipmentCalculationFull()
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"shipments":[{"amount":{"value":490,"currency":"EUR"},"delay":48,"primary":true,"carrier":{"id":"colissimo","name":"Colissimo","type":"home_delivery"}}],"items":[{"reference":"33245342","quantity":1,"amount":{"original":{"value":3800,"currency":"EUR"},"promotional":{"value":3000,"currency":"EUR"}}}],"order_amount":{"value":3490,"currency":"EUR"}}'
        );

        $colissimo = new OneClickShipmentCatalogLess(
            new OystPrice(4.90, 'EUR'),
            48,
            new OystCarrier('colissimo', 'Colissimo', 'home_delivery'),
            true
        );

        $shipments[] = $colissimo;

        $item33245342 = new OneClickItem('33245342', 1);
        $item33245342->setAmountOriginal(new OystPrice(38, 'EUR'));
        $item33245342->setAmountPromotional(new OystPrice(30, 'EUR'));
        $items[] = $item33245342;

        $oneClickShipmentCalculation = new OneClickShipmentCalculation($shipments);
        $oneClickShipmentCalculation->setItems($items);
        $oneClickShipmentCalculation->setOrderAmount(new OystPrice(34.90, 'EUR'));

        $this->assertEquals(
            $fakeResponse->getBody(true),
            $oneClickShipmentCalculation->toJson()
        );
    }

    /**
     * Test the OneClickShipmentCalculation endpoint primary default is set
     */
    public function testOneClickShipmentCalculationDefaultPrimary()
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"shipments":[{"amount":{"value":490,"currency":"EUR"},"delay":48,"primary":true,"carrier":{"id":"colissimo","name":"Colissimo","type":"home_delivery"}}],"items":[{"reference":"33245342","quantity":1,"amount":{"original":{"value":3800,"currency":"EUR"},"promotional":{"value":3000,"currency":"EUR"}}}],"order_amount":{"value":3490,"currency":"EUR"}}'
        );

        $colissimo = new OneClickShipmentCatalogLess(
            new OystPrice(4.90, 'EUR'),
            48,
            new OystCarrier('colissimo', 'Colissimo', 'home_delivery'),
            true
        );

        $shipments[] = $colissimo;

        $item33245342 = new OneClickItem('33245342', 1);
        $item33245342->setAmountOriginal(new OystPrice(38, 'EUR'));
        $item33245342->setAmountPromotional(new OystPrice(30, 'EUR'));
        $items[] = $item33245342;

        $oneClickShipmentCalculation = new OneClickShipmentCalculation($shipments);
        $oneClickShipmentCalculation->setDefaultPrimaryShipmentByType();
        $oneClickShipmentCalculation->setItems($items);
        $oneClickShipmentCalculation->setOrderAmount(new OystPrice(34.90, 'EUR'));

        $this->assertEquals(
            $fakeResponse->getBody(true),
            $oneClickShipmentCalculation->toJson()
        );
    }
}
