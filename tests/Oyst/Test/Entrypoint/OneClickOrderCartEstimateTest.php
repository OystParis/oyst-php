<?php

namespace Oyst\Test\Entrypoint;

use Guzzle\Http\Message\Response;
use Oyst\Classes\OneClickItem;
use Oyst\Classes\OneClickMerchantDiscount;
use Oyst\Classes\OneClickOrderCartEstimate;
use Oyst\Classes\OneClickShipmentCatalogLess;
use Oyst\Classes\OystCarrier;
use Oyst\Classes\OystPrice;

/**
 * Class OneClickOrderCartEstimateTest for unitary tests
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickOrderCartEstimateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the OneClickOrderCartEstimate endpoint data minimum required
     */
    public function testOneClickOrderCartEstimateRequired()
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

        $oneClickOrderCartEstimate = new OneClickOrderCartEstimate($shipments);

        $this->assertEquals(
            $fakeResponse->getBody(true),
            $oneClickOrderCartEstimate->toJson()
        );
    }

    /**
     * Test the OneClickOrderCartEstimate endpoint data full
     */
    public function testOneClickOrderCartEstimateFull()
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"shipments":[{"amount":{"value":490,"currency":"EUR"},"delay":48,"primary":true,"carrier":{"id":"colissimo","name":"Colissimo","type":"home_delivery"}}],"items":[{"reference":"33245342","amount":{"value":3490,"currency":"EUR"},"quantity":1,"crossed_out_amount":{"value":3800,"currency":"EUR"}}],"order_amount":{"value":3490,"currency":"EUR"},"free_items":[{"reference":"4323","amount":{"value":0,"currency":"EUR"},"quantity":1,"title":"Special gift"}],"merchant_discounts":[{"amount":{"value":1337,"currency":"EUR"},"name":"bday discount"}],"message":"Happy bday","discount_coupon_error":"Invalid coupon"}'
        );

        $colissimo = new OneClickShipmentCatalogLess(
            new OystPrice(4.90, 'EUR'),
            48,
            new OystCarrier('colissimo', 'Colissimo', 'home_delivery'),
            true
        );

        $shipments[] = $colissimo;

        $item33245342 = new OneClickItem('33245342', new OystPrice(34.90, 'EUR'), 1);
        $item33245342->__set('crossedOutAmount', new OystPrice(38.00, 'EUR'));
        $items[] = $item33245342;

        $oneClickOrderCartEstimate = new OneClickOrderCartEstimate($shipments);
        $oneClickOrderCartEstimate->setItems($items);
        $oneClickOrderCartEstimate->setOrderAmount(new OystPrice(34.90, 'EUR'));

        $freeItems4323 = new OneClickItem('4323', new OystPrice(0, 'EUR'), 1);
        $freeItems4323->__set('title', 'Special gift');
        $freeItems[] = $freeItems4323;
        $oneClickOrderCartEstimate->setFreeItems($freeItems);
        $oneClickOrderCartEstimate->setMerchantDiscounts(
            array(new OneClickMerchantDiscount(new OystPrice(13.37, 'EUR'), 'bday discount'))
        );
        $oneClickOrderCartEstimate->setMessage('Happy bday');
        $oneClickOrderCartEstimate->setDiscountCouponError('Invalid coupon');

        $this->assertEquals(
            $fakeResponse->getBody(true),
            $oneClickOrderCartEstimate->toJson()
        );
    }

    /**
     * Test the OneClickOrderCartEstimate endpoint primary default is set
     */
    public function testOneClickOrderCartEstimateDefaultPrimary()
    {
        $fakeResponse = new Response(
            200,
            array('Content-Type' => 'application/json'),
            '{"shipments":[{"amount":{"value":490,"currency":"EUR"},"delay":48,"primary":true,"carrier":{"id":"colissimo","name":"Colissimo","type":"home_delivery"}}],"items":[{"reference":"33245342","amount":{"value":3800,"currency":"EUR"},"quantity":1}],"order_amount":{"value":3490,"currency":"EUR"}}'
        );

        $colissimo = new OneClickShipmentCatalogLess(
            new OystPrice(4.90, 'EUR'),
            48,
            new OystCarrier('colissimo', 'Colissimo', 'home_delivery'),
            true
        );

        $shipments[] = $colissimo;

        $item33245342 = new OneClickItem('33245342', new OystPrice(38, 'EUR'), 1);
        $items[] = $item33245342;

        $oneClickOrderCartEstimate = new OneClickOrderCartEstimate($shipments);
        $oneClickOrderCartEstimate->setDefaultPrimaryShipmentByType();
        $oneClickOrderCartEstimate->setItems($items);
        $oneClickOrderCartEstimate->setOrderAmount(new OystPrice(34.90, 'EUR'));

        $this->assertEquals(
            $fakeResponse->getBody(true),
            $oneClickOrderCartEstimate->toJson()
        );
    }
}
