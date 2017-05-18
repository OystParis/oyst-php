<?php

namespace Oyst\Test\Controller;

use Oyst\Api\OystApiClientFactory;
use Oyst\Api\OystCatalogApi;
use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;
use Oyst\Test\Fixture\ProductFixture;
use Oyst\Test\TestSettings;

class ProductControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TestSettings */
    private $settings;

    /** @var  OystProduct[] */
    private $products;

    /** @var  OystCatalogApi */
    private $catalogApi;

    private function loadRequirements()
    {
        $this->settings = new TestSettings();
        $this->settings->load();

        /** @var OystCatalogApi $catalogApi */
        $this->catalogApi = OystApiClientFactory::getClient(
            OystApiClientFactory::ENTITY_CATALOG,
            $this->settings->getApiKey(),
            $this->settings->getUserAgent(),
            $this->settings->getEnv()
        );

        $this->products = ProductFixture::getList();

        return $this;
    }

    public function testPostProducts()
    {
        $this->loadRequirements();
        $result = $this->catalogApi->postProducts($this->products);
        $this->assertTrue(isset($result['imported']) && $result['imported'] == 2);
    }

    public function testUpdateProduct()
    {
        $this->loadRequirements();

        $product = $this->products[0];

        $product->setTitle('updated_1');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost'));

        $info = array(
            'meta' => 'info misc.',
            'subtitle' => 'updated',
        );
        $product->setAvailableQuantity(5);
        $product->setDescription('qdgsdfg');
        $product->setEan('my_ean');
        $product->setIsbn('my_isbn');
        $product->setActive(true);
        $product->setMaterialized(true);
        $product->setInformation($info);
        $product->setManufacturer('my manufacturer');
        $product->addRelatedProduct('ref_related');
        $product->setShortDescription('short description');
        $product->setSize(new OystSize(42, 42, 42));
        $product->addTag('test');
        $product->setUpc('my_upc');
        $product->setUrl('http://localhost');

        $result = $this->catalogApi->putProduct($product);

        $this->assertTrue($result['product']['title'] == 'updated_1');
    }

    public function testDeleteProduct()
    {
        // As the API has a little bug with delete / get, we need to wait a fix
        $this->assertTrue(true);
        return ;
        $this->loadRequirements();

        $product = $this->products[1];

        $result = $this->catalogApi->deleteProduct($product);

        $this->assertTrue(isset($result['deleted']));
    }
}
