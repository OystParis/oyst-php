<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOneClickApi;
use Oyst\Classes\OystProduct;
use Oyst\Test\Fixture\ProductFixture;
use Oyst\Test\TestSettings;

class OneClickControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TestSettings */
    private $settings;

    /** @var  OystOneClickApi */
    private $oneClickApi;

    /** @var  OystProduct */
    private $product;

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
    }

    public function testNotifyImport()
    {
        $apiVersion = 1;
        $result = $this->oneClickApi->authorizeOrder(
            $this->product->getRef(),
            1,
            null,
            null,
            $apiVersion
        );

        $this->assertTrue(isset($result['url']));
        parse_str(parse_url($result['url'], PHP_URL_QUERY), $queries);
        $this->assertTrue(isset($queries['v']) && $queries['v'] == $apiVersion);
    }
}
