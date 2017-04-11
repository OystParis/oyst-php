<?php

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
     * @param int      $page    1 by default
     * @param int      $perPage 100 by default
     * @param string[] statuses Array of available statuses (see constants)
     *
     * @return mixed
     */
    public function getOrders($page = 1, $perPage = 100, $statuses = array())
    {
        $data = array(
            'page'     => $page,
            'per_page' => $perPage,
            'status'   => empty($statuses) ? array(self::STATUS_ACCEPTED, self::STATUS_PENDING) : $statuses
        );

        $response = $this->executeCommand('GetOrderList', $data);

        return $response;
    }

    /**
     * @param $orderId
     *
     * @return string
     */
    public function getOrder($orderId)
    {
        $data = array(
            'id' => $orderId,
        );

        $response = $this->executeCommand('GetOrder', $data);

        return $response;
    }
}
