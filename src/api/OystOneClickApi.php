<?php

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
     * @param string        $productRef
     * @param string        $variationRef
     * @param int           $quantity
     * @param OystUser|null $user
     *
     * @return mixed
     */
    public function authorizeOrder($productRef, $variationRef, $quantity, OystUser $user = null)
    {
        $data = array(
            'product_reference'   => $productRef,
            'variation_reference' => $variationRef,
            'quantity'            => $quantity,
        );

        if (!is_null($user)) {
            $data['user'] = $user->toArray();
        }

        $response = $this->executeCommand('AuthorizeOrder', $data);

        return $response;
    }
}
