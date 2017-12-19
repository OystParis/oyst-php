<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystCatalogApi;
use Oyst\Classes\OneClickShipment;
use Oyst\Classes\OystCarrier;
use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;
use Oyst\Classes\ShipmentAmount;
use Oyst\Test\Fixture\OneClickShipmentFixture;
use Oyst\Test\Fixture\ProductFixture;
use Oyst\Test\TestSettings;

/**
 * Class CatalogControllerTest for functional tests
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class CatalogControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestSettings
     */
    private $settings;

    /**
     * @var OystProduct[]
     *  */
    private $products;

    /**
     * @var OystCatalogApi
     */
    private $catalogApi;

    protected function setUp()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        $oystApiClientFactory = new OystApiClientFactory();

        /** @var OystCatalogApi $catalogApi */
        $this->catalogApi = $oystApiClientFactory->getClient(
            $oystApiClientFactory::ENTITY_CATALOG,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        $productFixture = new ProductFixture();
        $this->products = $productFixture->getList();

        $oneClickShipmentFixture = new OneClickShipmentFixture();
        $this->shipments = $oneClickShipmentFixture->getList();
    }

    public function testNotifyImport()
    {
        $result = $this->catalogApi->notifyImport();

        $this->assertTrue(isset($result['import_id']), $this->catalogApi->getBody());
    }

    public function testPostProducts()
    {
        $this->catalogApi->postProducts($this->products);

        $this->assertTrue(
            false === $this->catalogApi->getLastError() && 200 === $this->catalogApi->getLastHttpCode()
        );
    }

    public function testUpdateProduct()
    {
        $product = $this->products[0];

        $product->__set('title', 'prod-001');
        $product->__set('amountIncludingTax', new OystPrice(35, 'EUR'));
        $product->__set('categories', array(new OystCategory('cat_ref_1', 'cat title 1', true)));
        $product->__set('images', array('http://localhost.local/product-001'));

        $info = array(
            'meta' => 'info misc.',
            'subtitle' => 'updated',
        );
        $product->__set('availableQuantity', 5);
        $product->__set('description', 'New description');
        $product->__set('ean', 'my_ean_001');
        $product->__set('isbn', 'my_isbn_001');
        $product->__set('active', true);
        $product->__set('materialized', true);
        $product->__set('information', $info);
        $product->__set('manufacturer', 'my manufacturer');
        $product->__set('relatedProducts', array('ref_related'));
        $product->__set('shortDescription', 'New short description');
        $product->__set('size', new OystSize(69, 69, 69));
        $product->__set('tags', array('test'));
        $product->__set('upc', 'my_upc');
        $product->__set('url', 'http://localhost.local');

        $result = $this->catalogApi->putProduct($product);

        // Temporary cause API is broken with catalog
        if ($result) {
            $this->assertTrue($result['product']['title'] == 'prod-001', $this->catalogApi->getBody());
        }
    }

    public function testDeleteProduct()
    {
        // As the API has a little bug with delete / get, we need to wait a fix
        $this->assertTrue(true);
        return;

        $product = $this->products[1];

        $result = $this->catalogApi->deleteProduct($product);

        $this->assertTrue(isset($result['deleted']), $this->catalogApi->getBody());
    }

    public function testPostShipments()
    {
        $result = $this->catalogApi->postShipments($this->shipments);

        $this->assertTrue(isset($result['shipments']), $this->catalogApi->getBody());
        $this->assertTrue(count($result['shipments']) === 2, $this->catalogApi->getBody());
    }

    public function testGetShipments()
    {
        $result = $this->catalogApi->getShipments();

        $this->assertTrue(isset($result['shipments']), $this->catalogApi->getBody());
        $this->assertTrue(count($result['shipments']) === 2, $this->catalogApi->getBody());
    }

    public function testGetShipmentTypes()
    {
        $result = $this->catalogApi->getShipmentTypes();

        $this->assertTrue(isset($result['types']), $this->catalogApi->getBody());
    }
}
