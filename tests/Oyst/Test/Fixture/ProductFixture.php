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
        $product->__set('reference', 'prod-1');
        $product->__set('title', 'My first product');
        $product->__set('amountIncludingTax', new OystPrice(42, 'EUR'));
        $product->__set('quantity', 1);

        $product->__set('categories', array(new OystCategory('cat_ref-1', 'cat title 1', true)));
        $product->__set('images', array('http://localhost.local/product-1'));
        $info = array(
            'meta' => 'info misc.',
            'subtitle' => 'test',
        );
        $product->__set('availableQuantity', 5);
        $description = 'Lorem ipsum dolor sit amet, cetero delectus nec et, no ius nonumy ignota, vocent pertinax ';
        $description .= 'ei qui. No sit iudico feugiat ponderum, an mea enim aperiam scriptorem, pri te cibo quaeque ';
        $description .= 'disputando. Has ut meis adhuc vivendo, illud partem molestie vix in. An his dictas ceteros. ';
        $description .= 'Te quod graeco sit. Quod prima vim an, odio blandit pri ne.';
        $product->__set('description', $description);
        $product->__set('ean', 'my_ean_1');
        $product->__set('isbn', 'my_isbn_1');
        $product->__set('active', true);
        $product->__set('materialized', true);
        $product->__set('information', $info);
        $product->__set('manufacturer', 'my manufacturer');
        $product->__set('relatedProducts', array('ref_related'));
        $shortDescription = 'Ut fuisset molestie vim, sed eu essent tamquam iudicabit. Ex amet commodo consequuntur ';
        $shortDescription .= 'eos. Amet mazim has id, id wisi deseruisse his. Modo liber inciderint ex his. Id natum ';
        $shortDescription .= 'laoreet detracto sed.';
        $product->__set('shortDescription', $shortDescription);
        $product->__set('size', new OystSize(42, 42, 42));
        $product->__set('tags', array('test'));
        $product->__set('upc', 'my_upc');
        $product->__set('url', 'http://localhost.local');
        $products[] = clone $product;

        $product->__set('reference', 'prod-2');
        $product->__set('title', 'My second product');
        $product->__set('amountIncludingTax', new OystPrice(1337, 'EUR'));
        $product->__set('quantity', 2);

        $product->__set('categories', array(new OystCategory('cat_ref_2', 'cat title 2', true)));
        $product->__set('images', array('http://localhost.local/product-2'));
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
