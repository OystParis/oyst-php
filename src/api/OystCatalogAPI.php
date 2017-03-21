<?php

/**
 * Class OystCatalogAPI
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCatalogAPI extends OystApiClient
{
    /**
     * @param OystProduct[] $oystProducts
     *
     * @return mixed
     */
    public function postProducts($oystProducts)
    {
        $formattedData = [];
        /** @var OystArrayInterface $product */
        foreach ($oystProducts as $oystProduct) {
            $formattedData[] = $oystProduct->toArray();
        }

        $data     = array('products' => $oystProducts);
        $response = $this->executeCommand('PostProducts', $data);

        return $response;
    }

    /**
     * @param $orderId
     *
     * @return string
     */
    public function notifyImport()
    {
        $response = $this->executeCommand('NotifyImport');

        return $response;
    }
}
