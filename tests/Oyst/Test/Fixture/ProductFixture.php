<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;

class ProductFixture
{
    /**
     * @return OystProduct[]
     */
    public static function getList()
    {
        $products = array();

        $product = new OystProduct();
        $product->setRef('test-10');
        $product->setTitle('my title1');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost/test-1'));

        $info = array(
            'meta' => 'info misc.',
            'subtitle' => 'test',
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
        $products[] = clone $product;

        $product->setRef('test-20');
        $product->setTitle('my title2');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost/test-2'));

        $products[] = clone $product;
        return $products;
    }

    /**
     * @return OystProduct
     */
    public static function getOneClickOrder()
    {
        $products = self::getList();

        return $products[1];
    }
}
