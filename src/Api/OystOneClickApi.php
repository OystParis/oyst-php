<?php

/**
 * Class OystOneClickApi
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
namespace Oyst\Api;

class OystOneClickApi extends AbstractOystApiClient
{
    /**
     * @param string        $productRef
     * @param string        $variationRef
     * @param int           $quantity
     * @param OystUser|null $user
     *
     * @return mixed
     */
    public function authorizeOrder($productRef, $quantity = 1, $variationRef = null, OystUser $user = null)
    {
        $data = array(
            'product_reference'   => $productRef,
            'quantity'            => $quantity,
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
