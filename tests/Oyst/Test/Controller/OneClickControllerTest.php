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

    private function loadRequirements()
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

        return $this;
    }

    public function testNotifyImport()
    {
        $this->loadRequirements();

        $result = $this->oneClickApi->authorizeOrder($this->product->getRef(), 1);
        $this->assertTrue(isset($result['url']));
    }
}
