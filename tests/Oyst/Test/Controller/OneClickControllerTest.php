<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOneClickApi;
use Oyst\Classes\OneClickNotification;
use Oyst\Classes\OystProduct;
use Oyst\Test\Fixture\OneClickNotificationFixture;
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

    /** @var  OneClickNotification */
    private $oneClickNotification;

    protected function setUp()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        /** @var OystOneClickApi $catalogApi */
        $this->oneClickApi = OystApiClientFactory::getClient(
            OystApiClientFactory::ENTITY_ONECLICK,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        $this->product = ProductFixture::getOneClickOrder();
        $this->oneClickOrderParams = OneClickOrderParamsFixture::getOrderParams();
        $this->oneClickOrderContext = OneClickOrderContextFixture::getOrderContext();
        $this->oneClickNotification = OneClickNotificationFixture::getNotification();
    }

    public function testNotifyImport()
    {
        $apiVersion = 1;
        $result = $this->oneClickApi->authorizeOrder(
            $this->product->getRef(),
            1,
            null,
            null,
            $apiVersion,
            null
        );

        $this->assertTrue(isset($result['url']), $this->oneClickApi->getBody());
        parse_str(parse_url($result['url'], PHP_URL_QUERY), $queries);
        $this->assertTrue(isset($queries['v']) && $queries['v'] == $apiVersion);
    }
}
