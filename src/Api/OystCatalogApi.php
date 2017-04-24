<?php

/**
 * Class OystCatalogApi
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
namespace Oyst\Api;

use Oyst\Classes\OystProduct;
use Oyst\Helper\OystCollectionHelper;

class OystCatalogApi extends AbstractOystApiClient
{
    /**
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
     * @param OystProduct $oystProduct
     *
     * @return mixed
     */
    public function postProduct(OystProduct $oystProduct)
    {
        return $this->postProducts(array($oystProduct));
    }

    /**
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
     * @param string $oystProductRef
     *
     * @return mixed
     */
    public function deleteProduct($oystProductRef)
    {
        $data = array(
            'id' => $oystProductRef,
        );
        $response = $this->executeCommand('DeleteProduct', $data);

        return $response;
    }

    /**
     * @return mixed
     */
    public function notifyImport()
    {
        $response = $this->executeCommand('NotifyImport');

        return $response;
    }
}
