<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystOrderApi;
use Oyst\Classes\Enum\AbstractOrderState;
use Oyst\Classes\OystOrder;
use Oyst\Test\TestSettings;

class OrderControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TestSettings */
    private $settings;

    /** @var  OystOrderApi */
    private $orderApi;

    private function loadRequirements()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        /** @var OystOrderApi $catalogApi */
        $this->orderApi = OystApiClientFactory::getClient(
            OystApiClientFactory::ENTITY_ORDER,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        return $this;
    }


    public function testGetOrders()
    {
        $this->loadRequirements();

        $result = $this->orderApi->getOrders();
        $this->assertTrue(is_array($result['orders']) && isset($result['count']));
    }

    public function testUpdateOrder()
    {
        // TODO: This order part should work better with a new created order
        // As we can't create order on the API for real functional test, We need to create
        // a new one from live plugin and then register the id inside the settings here.
        $this->loadRequirements();

        // This part works, but we need to develop the post
        if (!$this->settings->getOrderId()) {
            return ;
        }

        $orderInfo = $this->orderApi->getOrder($this->settings->getOrderId());

        $this->assertTrue(is_array($orderInfo));

        $currentState = $orderInfo['current_status'];

        if ($currentState == AbstractOrderState::WAITING) {
            $nextStatus = AbstractOrderState::PENDING;
        } elseif ($currentState == AbstractOrderState::PENDING) {
            $nextStatus = AbstractOrderState::ACCEPTED;
        } elseif ($currentState == AbstractOrderState::ACCEPTED) {
            $nextStatus = AbstractOrderState::FINALIZED;
        } elseif ($currentState == AbstractOrderState::FINALIZED) {
            $nextStatus = AbstractOrderState::SHIPPED;
        } else {
            $nextStatus = AbstractOrderState::PENDING;
        }

        $result = $this->orderApi->updateStatus($this->settings->getOrderId(), $nextStatus);

        $this->assertEquals(200, $this->orderApi->getLastHttpCode());
        $this->assertEquals($nextStatus, $result['order']['current_status']);
    }
}
