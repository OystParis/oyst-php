<?php

namespace Oyst\Api;

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
     *
     * @return mixed
     */
    public function authorizeOrder(
        $productRef,
        $quantity = 1,
        $variationRef = null,
        OystUser $user = null,
        $version = 1,
        OystProduct $product = null
    ) {
        $data = array(
            'product_reference' => $productRef,
            'quantity' => $quantity,
            'version' => $version,
            'product' => $product,
        );

        if (!is_null($variationRef)) {
            $data['variation_reference'] = $variationRef;
        }

        if (!is_null($user)) {
            $data['user'] = $user->toArray();
        }

        $response = $this->executeCommand('AuthorizeOrder', $data);

        return $response;
    }
}
