<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Classes\OystSize;

/**
 * Class ProductFixture
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class ProductFixture
{
    /**
     * @return OystProduct[]
     */
    public static function getList()
    {
        $products = array();

        $product = new OystProduct();
        $product->setRef('prod-1');
        $product->setTitle('My first product');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref', 'cat title', true)));
        $product->setImages(array('http://localhost.local/product-1'));

        $info = array(
            'meta' => 'info misc.',
            'subtitle' => 'test',
        );
        $product->setAvailableQuantity(5);
        $description = 'Lorem ipsum dolor sit amet, cetero delectus nec et, no ius nonumy ignota, vocent pertinax ';
        $description .= 'ei qui. No sit iudico feugiat ponderum, an mea enim aperiam scriptorem, pri te cibo quaeque ';
        $description .= 'disputando. Has ut meis adhuc vivendo, illud partem molestie vix in. An his dictas ceteros. ';
        $description .= 'Te quod graeco sit. Quod prima vim an, odio blandit pri ne.';
        $product->setDescription($description);
        $product->setEan('my_ean_1');
        $product->setIsbn('my_isbn_1');
        $product->setActive(true);
        $product->setMaterialized(true);
        $product->setInformation($info);
        $product->setManufacturer('my manufacturer');
        $product->addRelatedProduct('ref_related');
        $shortDescription = 'Ut fuisset molestie vim, sed eu essent tamquam iudicabit. Ex amet commodo consequuntur ';
        $shortDescription .= 'eos. Amet mazim has id, id wisi deseruisse his. Modo liber inciderint ex his. Id natum ';
        $shortDescription .= 'laoreet detracto sed.';
        $product->setShortDescription($shortDescription);
        $product->setSize(new OystSize(42, 42, 42));
        $product->addTag('test');
        $product->setUpc('my_upc');
        $product->setUrl('http://localhost.local');
        $products[] = clone $product;

        $product->setRef('prod-2');
        $product->setTitle('My second product');
        $product->setAmountIncludingTax(new OystPrice(25, 'EUR'));
        $product->setCategories(array(new OystCategory('cat_ref_2', 'cat title', true)));
        $product->setImages(array('http://localhost.local/product-2'));
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
