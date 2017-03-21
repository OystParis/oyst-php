<?php

/**
 * Class OystOrderAPI
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOrderAPI extends OystApiClient
{
    const STATUS_ACCEPTED  = 'accepted';
    const STATUS_DENIED    = 'denied';
    const STATUS_PENDING   = 'pending';
    const STATUS_REFUNDED  = 'refunded';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_SHIPPED   = 'shipped';
    const STATUS_FINALIZED = 'finalized';

    /**
     * GET /orders
     *
     * @param int    $page    1 by default
     * @param int    $perPage 100 by default
     * @param string $status  Array of available status (see constants)
     *
     * @return mixed
     */
    public function getOrders($page = 1, $perPage = 100, $statuses = array())
    {
        $params = http_build_query(array(
            'page'     => $page,
            'per_page' => $perPage,
            'status'   => empty($statuses) ? array(self::STATUS_ACCEPTED, self::STATUS_PENDING) : $statuses
        ));
        $url = 'orders?'.$params;

        return $this->send('GET', $url);
    }

    /**
     * GET /orders/{id}
     *
     * @param $orderId
     *
     * @return array
     */
    public function getOrder($orderId)
    {
        $url = 'orders/'.$orderId;

        return $this->send('GET', $url);
    }

    /**
     * PATCH /orders/{id}
     *
     * @param int    $id
     * @param string $status One of the available status (see constants)
     */
    public function patchOrder($orderId, $status)
    {
        $url  = 'orders/'.$orderId;
        $data = array(
            'status' => $status
        );

        return $this->send('PATCH', $url, $data);
    }

    /**
     * POST /orders/authorize
     *
     * @param string        $productRef
     * @param string        $skuRef
     * @param int           $quantity
     * @param OystUser|null $user
     *
     * @return array
     */
    public function authorizeOrder($productRef, $skuRef, $quantity, User $user = null)
    {
        $url  = 'orders/authorize';
        $data = array(
            'product_reference' => $productRef,
            'sku_reference'     => $skuRef,
            'quantity'          => $quantity,
        );

        if (!is_null($user)) {
            $data['user'] = $user->toArray();
        }

        return $this->send('POST', $url, $data);
    }
}
