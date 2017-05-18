<?php

namespace Oyst\Api;

use Oyst\Classes\Enum\AbstractOrderState;
use Oyst\Classes\OystOrder;
use Oyst\Helper\OystCollectionHelper;

/**
 * Class OystOrderApi
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOrderApi extends AbstractOystApiClient
{
    /**
     * Get oneclick orders (paginated)
     *
     * @param int    $limit   10 by default
     * @param string $status  the order status (see constants)
     *
     * @return mixed
     */
    public function getOrders($limit = 10, $status = AbstractOrderState::ACCEPTED)
    {
        $data = array(
            'limit'  => $limit,
            'status' => $status
        );

        $response = $this->executeCommand('GetOrders', $data);

        return $response;
    }

    /**
     * Get oneclick order
     *
     * @param $orderId
     *
     * @return string[]|false
     */
    public function getOrder($orderId)
    {
        $data = array(
            'id' => $orderId,
        );

        $response = $this->executeCommand('GetOrder', $data);

        return isset($response['order']) ? $response['order'] : false;
    }

    /**
     * @param $orderId
     * @param $status
     * @return mixed
     */
    public function updateStatus($orderId, $status)
    {
        $data = array(
            'id' => $orderId,
            'status' => $status
        );
        $response = $this->executeCommand('updateStatus', $data);

        return $response;
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function decline($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::DECLINED);
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function accept($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::ACCEPTED);
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function pending($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::PENDING);
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function shipped($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::SHIPPED);
    }
}
