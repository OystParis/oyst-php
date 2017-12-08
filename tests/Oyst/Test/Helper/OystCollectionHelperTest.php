<?php

namespace Oyst\Test\Helper;

use Oyst\Classes\OystCategory;
use Oyst\Classes\OystPrice;
use Oyst\Classes\OystProduct;
use Oyst\Helper\OystCollectionHelper;

/**
 * Class OystCollectionHelperTest
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCollectionHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * DataProvider
     *
     * @return array
     */
    public function dataToClean()
    {
        return array(
            array(
                array(
                    'id' => 42
                ),
                array(
                    'id' => 42
                )
            ),
            array(
                array(
                    'id' => 42,
                    'ref' => ''
                ),
                array(
                    'id' => 42
                )
            ),
            array(
                array(
                    'id' => 42,
                    'ref' => null
                ),
                array(
                    'id' => 42
                )
            ),
            array(
                array(
                    'id' => 42,
                    'ref' => false
                ),
                array(
                    'id' => 42,
                    'ref' => false
                )
            ),
            array(
                array(
                    'id' => 42,
                    'ref' => 0
                ),
                array(
                    'id' => 42,
                    'ref' => 0
                )
            ),
            array(
                array(
                    'id' => 42,
                    'ref' => '0'
                ),
                array(
                    'id' => 42,
                    'ref' => '0'
                )
            ),
        );
    }

    /**
     * DataProvider
     *
     * @return array
     */
    public function collectionData()
    {
        $product = new OystProduct();

        return array(
            array(
                array(
                    new OystProduct(),
                    $product
                        ->__set('reference', 'ref1')
                        ->__set('title', 'title1')
                        ->__set('amountIncludingTax', new OystPrice(13.37, 'EUR'))
                        ->__set('quantity', 'quantity1')
                        ->__set('description', 'description1')
                        ->__set('categories', array(new OystCategory('cat1_ref', 'my_cat1', true),
                            new OystCategory('cat2_ref', 'my_cat2', false)))
                ),
                array(
                    array(
                        'reference' => null,
                        'title' => null,
                        'quantity' => null,
                        'is_active' => null,
                        'is_materialized' => null,
                        'condition' => null,
                        'short_description' => null,
                        'description' => null,
                        'tags' => array(),
                        'amount_including_taxes' => array(),
                        'amount_excluding_taxes' => array(),
                        'url' => null,
                        'categories' => array(),
                        'manufacturer' => null,
                        'shipments' => array(),
                        'size' => array(),
                        'available_quantity' => null,
                        'weight' => null,
                        'is_discounted' => false,
                        'ean' => null,
                        'upc' => null,
                        'isbn' => null,
                        'images' => array(),
                        'informations' => new \stdClass(),
                        'related_products' => array(),
                        'variations' => array()
                    ),
                    array(
                        'reference' => 'ref1',
                        'title' => 'title1',
                        'quantity' => 'quantity1',
                        'is_active' => null,
                        'is_materialized' => null,
                        'condition' => null,
                        'short_description' => null,
                        'description' => 'description1',
                        'tags' => array(),
                        'amount_including_taxes' => array(
                            'value' => 1337,
                            'currency' => 'EUR',
                        ),
                        'amount_excluding_taxes' => array(),
                        'url' => null,
                        'categories' => array(
                            array(
                                'reference' => 'cat1_ref',
                                'is_main' => true,
                                'title' => 'my_cat1'
                            ),
                            array(
                                'reference' => 'cat2_ref',
                                'is_main' => false,
                                'title' => 'my_cat2'
                            )
                        ),
                        'manufacturer' => null,
                        'shipments' => array(),
                        'size' => array(),
                        'available_quantity' => null,
                        'weight' => null,
                        'is_discounted' => false,
                        'ean' => null,
                        'upc' => null,
                        'isbn' => null,
                        'images' => array(),
                        'informations' => new \stdClass(),
                        'related_products' => array(),
                        'variations' => array()
                    )
                )
            ),
        );
    }

    /**
     * @dataProvider dataToClean
     */
    public function testCleanData($data, $expectedData)
    {
        $oystCollectionHelper = new OystCollectionHelper();
        $oystCollectionHelper->cleanData($data);

        $this->assertEquals($data, $expectedData);
    }

    /**
     * @dataProvider collectionData
     */
    public function testCollectionToArray($collection, $expectedData)
    {
        $oystCollectionHelper = new OystCollectionHelper();
        $data = $oystCollectionHelper->collectionToArray($collection);

        $this->assertEquals($data, $expectedData);
    }
}
