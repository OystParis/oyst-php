<?php

namespace Oyst\Api;

use Oyst\Classes\OneClickNotification;
use Oyst\Classes\OneClickOrderParams;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystUser;

/**
 * Class OystOneClickApi
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOneClickApi extends AbstractOystApiClient
{
    /**
     * Check if an order can be processed for the selected product / quantity
     * If it's the case, an order is created (can be retrieved via getOrder(s) method)
     *
     * @param string $productRef
     * @param int $quantity
     * @param string $variationRef
     * @param OystUser|null $user
     * @param int $version
     * @param OystProduct $product OystProduct for catalog less
     * @param OneClickOrderParams $orderParams
     * @param array $context Context is data about order which is received on order notification
     * @param OneClickNotification $notification Allow to manage notification like order.shipments.get to get live shipment price
     *
     * @return mixed
     */
    public function authorizeOrder(
        $productRef,
        $quantity = 1,
        $variationRef = null,
        OystUser $user = null,
        $version = 1,
        OystProduct $product = null,
        OneClickOrderParams $orderParams = null,
        $context = null,
        OneClickNotification $notification = null
    ) {
        $data = array(
            'product_reference' => (string)$productRef,
            'quantity' => (int)$quantity,
            'version' => (int)$version,
        );

        if (!is_null($variationRef)) {
            $data['variation_reference'] = (string)$variationRef;
        }

        if (!is_null($user)) {
            $data['user'] = $user->toArray();
        }

        if (!is_null($product)) {
            $data['product'] = $product->toArray();
        }

        if (!is_null($orderParams)) {
            $data['order'] = $orderParams->toArray();
        }

        if (is_array($context)) {
            $data['context'] = $context;
        }

        if (!is_null($notification)) {
            $data['notification'] = $notification->toArray();
        }

        $response = $this->executeCommand('AuthorizeOrder', $data);

        return $response;
    }
}
