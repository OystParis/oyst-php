<?php

namespace Oyst\Api;

use Oyst\Classes\Enum\AbstractOrderState;
use Oyst\Classes\OystOrder;
use Oyst\Classes\OystPrice;
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
     * @param int $perPage 10 by default
     * @param string $status the order status (see constants)
     *
     * @return mixed
     */
    public function getOrders($perPage = 10, $status = AbstractOrderState::ACCEPTED)
    {
        $data = array(
            'per_page' => $perPage,
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

        return isset($response['order']) ? $response : false;
    }

    /**
     * @param $orderId
     * @param $status
     *
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
     *
     * @return mixed
     */
    public function deny($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::DENIED);
    }

    /**
     * @param $orderId
     *
     * @return mixed
     */
    public function accept($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::ACCEPTED);
    }

    /**
     * @param $orderId
     *
     * @return mixed
     */
    public function pending($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::PENDING);
    }

    /**
     * @param $orderId
     *
     * @return mixed
     */
    public function shipped($orderId)
    {
        return $this->updateStatus($orderId, AbstractOrderState::SHIPPED);
    }

    /**
     * Refund an order
     *
     * @param string $orderId
     * @param OystPrice|null $price If $price is null then the refund is total
     *
     * @return mixed
     */
    public function refunds($orderId, OystPrice $price = null)
    {
        $data = array(
            'id' => $orderId,
        );

        if (!is_null($price)) {
            $data['amount'] = $price->toArray();
        }

        $response = $this->executeCommand('Refunds', $data);

        return $response;
    }

    /**
     * @param string $orderId
     * @param string $merchantOrderReference
     *
     * @return mixed
     */
    public function updateOrder($orderId, $merchantOrderReference)
    {
        $data = array(
            'id' => $orderId,
            'order_reference' => $merchantOrderReference,
        );

        $response = $this->executeCommand('updateOrder', $data);

        return $response;
    }
}
