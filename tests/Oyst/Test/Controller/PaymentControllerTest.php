<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystPaymentApi;
use Oyst\Test\Fixture\UserFixture;
use Oyst\Test\TestSettings;

class PaymentControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TestSettings */
    private $settings;

    /** @var  OystPaymentApi */
    private $paymentApi;

    /** @var  array */
    private $user;

    private function loadRequirements()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        /** @var OystPaymentApi $catalogApi */
        $this->paymentApi = OystApiClientFactory::getClient(
            OystApiClientFactory::ENTITY_PAYMENT,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        $this->user = UserFixture::getOne();
        return $this;
    }

    public function testPayment()
    {
        $this->loadRequirements();

        $urls = array(
            'notification' => 'http://localhost.test',
            'cancel' => 'http://localhost.test',
            'error' => 'http://localhost.test',
            'return' => 'http://localhost.test',
        );

        $result = $this->paymentApi->payment(
            123,
            'EUR',
            3,
            $urls,
            true,
            $this->user
        );

        $this->assertTrue(isset($result['url']));
    }
}
