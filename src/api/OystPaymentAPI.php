<?php

/**
 * Class OystPaymentAPI
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystPaymentAPI extends OystApiClient
{
    /**
     * POST /payments
     *
     * @param float  $amount
     * @param string $currency
     * @param string $cartId
     * @param array  $urls
     * @param bool   $is3d
     * @param array  $user
     *
     * @return mixed The result on success, false on failure
     */
    public function payment($amount, $currency, $cartId, $urls, $is3d, $user)
    {
        $url  = 'payments';
        $data = array(
            'user'     => $user,
            'order_id' => (string) $cartId,
            'is_3d'    => $is3d,
            'amount'   => array(
                'value'    => (float) $amount,
                'currency' => (string) $currency,
            ),
            'notification_url' => $urls['notification'],
            'redirects'        => array(
                'cancel_url' => $urls['cancel'],
                'error_url'  => $urls['error'],
                'return_url' => $urls['return'],
            ),
        );

        return $this->send('POST', $url, $data);
    }
}
