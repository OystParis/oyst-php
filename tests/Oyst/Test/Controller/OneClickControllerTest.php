<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOneClickApi;
use Oyst\Classes\OneClickNotifications;
use Oyst\Classes\OystProduct;
use Oyst\Test\Fixture\OneClickNotificationsFixture;
use Oyst\Test\Fixture\OneClickOrderContextFixture;
use Oyst\Test\Fixture\OneClickOrderParamsFixture;
use Oyst\Test\Fixture\ProductFixture;
use Oyst\Test\TestSettings;

/**
 * Class OneClickControllerTest
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TestSettings */
    private $settings;

    /** @var  OystOneClickApi */
    private $oneClickApi;

    /** @var  OystProduct */
    private $product;

    /** @var  OneClickOrderParams */
    private $oneClickOrderParams;

    /** @var  OneClickOrderContext */
    private $oneClickOrderContext;

    /** @var  OneClickNotifications */
    private $oneClickNotifications;

    protected function setUp()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        $oystApiClientFactory = new OystApiClientFactory();

        /** @var OystOneClickApi $catalogApi */
        $this->oneClickApi = $oystApiClientFactory->getClient(
            $oystApiClientFactory::ENTITY_ONECLICK,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        $productFixture = new ProductFixture();
        $this->product = $productFixture::getOneClickOrder();

        $oneClickOrderParamsFixture = new OneClickOrderParamsFixture();
        $this->oneClickOrderParams = $oneClickOrderParamsFixture::getOrderParams();

        $oneClickOrderContextFixture = new OneClickOrderContextFixture();
        $this->oneClickOrderContext = $oneClickOrderContextFixture::getOrderContext();

        $oneClickNotificationsFixture = new OneClickNotificationsFixture();
        $this->oneClickNotifications = $oneClickNotificationsFixture::getNotifications();
    }

    public function testNotifyImport()
    {
        $apiVersion = 2;
        $result = $this->oneClickApi->authorizeOrder(
            $this->product->getRef(),
            1,
            null,
            null,
            $apiVersion,
            null,
            null,
            null,
            null
        );

        $this->assertTrue(isset($result['url']), $this->oneClickApi->getBody());
        parse_str(parse_url($result['url'], PHP_URL_QUERY), $queries);
        $this->assertTrue(isset($queries['v']) && $queries['v'] == $apiVersion);
    }
}
