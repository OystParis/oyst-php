<?php

namespace Oyst\Api;

use Oyst\Classes\OystArrayInterface;
use Oyst\Classes\OystProduct;
use Oyst\Helper\OystCollectionHelper;

/**
 * Class OystCatalogApi
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCatalogApi extends AbstractOystApiClient
{
    /**
     * Get product
     *
     * @param string $oystProductRef
     *
     * @return mixed
     */
    public function getProduct($oystProductRef)
    {
        $data = array(
            'id' => $oystProductRef,
        );
        $response = $this->executeCommand('GetProduct', $data);

        return $response;
    }

    /**
     * Synchronize the merchant catalog
     *
     * @param OystProduct[] $oystProducts
     *
     * @return mixed
     */
    public function postProducts($oystProducts)
    {
        $formattedData = array();
        /** @var OystArrayInterface $product */
        foreach ($oystProducts as $oystProduct) {
            $oystProductArray = $oystProduct->toArray();

            OystCollectionHelper::cleanData($oystProductArray);

            $formattedData[] = $oystProductArray;
        }

        $data     = array('products' => $formattedData);
        $response = $this->executeCommand('PostProducts', $data);

        return $response;
    }

    /**
     * Send a single product (used when the product is created by the merchant)
     *
     * @param OystProduct $oystProduct
     *
     * @return mixed
     */
    public function postProduct(OystProduct $oystProduct)
    {
        return $this->postProducts(array($oystProduct));
    }

    /**
     * Update the information of the product (used when the merchant apply some changes to the product)
     *
     * @param OystProduct $oystProduct
     *
     * @return mixed
     */
    public function putProduct(OystProduct $oystProduct)
    {
        $data = array(
            'id'      => $oystProduct->getRef(),
            'product' => $oystProduct->toArray()
        );
        $response = $this->executeCommand('PutProduct', $data);

        return $response;
    }

    /**
     * Delete the product
     *
     * @param string $productRef The reference of the product to delete
     *
     * @return mixed
     */
    public function deleteProduct($productRef)
    {
        $data = array(
            'id' => $productRef,
        );
        $response = $this->executeCommand('DeleteProduct', $data);

        return $response;
    }

    /**
     * Notify Oyst that the merchant wants to export its catalog of products
     *
     * @return mixed
     */
    public function notifyImport()
    {
        $response = $this->executeCommand('NotifyImport');

        return $response;
    }
}
