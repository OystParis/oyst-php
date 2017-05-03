<?php

namespace Oyst\Api;

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
    const STATUS_ACCEPTED  = 'accepted';
    const STATUS_DENIED    = 'denied';
    const STATUS_PENDING   = 'pending';
    const STATUS_REFUNDED  = 'refunded';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_SHIPPED   = 'shipped';
    const STATUS_FINALIZED = 'finalized';

    /**
     * Get oneclick orders (paginated)
     *
     * @param int    $limit   10 by default
     * @param string $status  the order status (see constants)
     *
     * @return mixed
     */
    public function getOrders($limit = 10, $status = self::STATUS_ACCEPTED)
    {
        $data = array(
            'limit'  => $limit,
            'status' => $status
        );

        $response = $this->executeCommand('GetOrderList', $data);

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
}
