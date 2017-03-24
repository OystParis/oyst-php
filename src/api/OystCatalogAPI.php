<?php

/**
 * Class OystCatalogAPI
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCatalogAPI extends OystAPIHelper
{
    /**
     * @var OystProductApiConfigurationLoader
     */
    protected $apiConfigurationLoader;

    /**
     * OystCatalogAPI constructor.
     * @param OystProductApiConfigurationLoader $oystProductApiConfigurationLoader
     * @param string $apiKey
     * @param string $userAgent
     */
    public function __construct(OystProductApiConfigurationLoader $oystProductApiConfigurationLoader, $apiKey, $userAgent)
    {
        $oystProductApiConfigurationLoader->setEntity('catalog');
        parent::__construct($oystProductApiConfigurationLoader, $apiKey, $userAgent);
    }

    /**
     * @param $oystProducts
     * @return mixed
     */
    public function postProducts($oystProducts)
    {
        $formattedData = [];
        /** @var OystArrayInterface $product */
        foreach ($oystProducts as $oystProduct) {
            $productData = $oystProduct->toArray();
            OystCollectionHelper::cleanData($productData);
            $formattedData[] = $productData;
        }

        $data = array('products' => $formattedData);
        $endpointInfo = $this->apiConfigurationLoader->getMethodAddProducts();

        return $this->send($endpointInfo['method'], $endpointInfo['endpoint'], $data);
    }

    /**
     * PUT /products/{id}
     *
     * @param OystProduct $product
     *
     * @return array
     */
    public function putProduct(OystProduct $product)
    {
        $endpointInfo = $this->apiConfigurationLoader->getMethodUpdateProducts();
        $url  = $endpointInfo['endpoint'].$product->getId();
        $data = $product->toArray();

        return $this->send($endpointInfo['method'], $url, $data);
    }

    /**
     * DELETE /products/{id}
     *
     * @param OystProduct $oystProduct
     * @return array
     *
     */
    public function deleteProduct(OystProduct $oystProduct)
    {
        $endpointInfo = $this->apiConfigurationLoader->getMethodDeleteProducts();
        $url  = $endpointInfo['endpoint'].$oystProduct->getId();

        return $this->send($endpointInfo['method'], $url);
    }

    /**
     * @return mixed
     */
    public function requestNewExport()
    {
        $endpointInfo = $this->apiConfigurationLoader->getMethodNotifyNewExport();
        return $this->send($endpointInfo['method'], $endpointInfo['endpoint']);
    }
}
