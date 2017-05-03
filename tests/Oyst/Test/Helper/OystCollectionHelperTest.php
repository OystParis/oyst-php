<?php

namespace Oyst\Test\Helper;

use Oyst\Classes\OystCategory;
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
                        ->setRef('ref1')
                        ->setTitle('title1')
                        ->setDescription('description1')
                        ->setCategories(array(new OystCategory('cat1_ref', 'my_cat1', true)))
                        ->addCategory(new OystCategory('cat2_ref', 'my_cat2', false))
                ),
                array(
                    array(
                        'reference'              => null,
                        'is_active'              => null,
                        'is_materialized'        => null,
                        'title'                  => null,
                        'condition'              => 'new',
                        'short_description'      => null,
                        'description'            => null,
                        'tags'                   => array(),
                        'amount_including_taxes' => array(),
                        'url'                    => null,
                        'categories'             => array(),
                        'manufacturer'           => null,
                        'shipments'              => array(),
                        'size'                   => array(),
                        'available_quantity'     => null,
                        'weight'                 => null,
                        'is_discounted'          => false,
                        'ean'                    => null,
                        'upc'                    => null,
                        'isbn'                   => null,
                        'images'                 => array(),
                        'informations'           => new \stdClass(),
                        'related_products'       => array(),
                        'variations'             => array()
                    ),
                    array(
                        'reference'              => 'ref1',
                        'is_active'              => null,
                        'is_materialized'        => null,
                        'title'                  => 'title1',
                        'condition'              => 'new',
                        'short_description'      => null,
                        'description'            => 'description1',
                        'tags'                   => array(),
                        'amount_including_taxes' => array(),
                        'url'                    => null,
                        'categories'             => array(
                            array(
                                'reference' => 'cat1_ref',
                                'is_main'   => true,
                                'title'     => 'my_cat1'
                            ),
                            array(
                                'reference' => 'cat2_ref',
                                'is_main'   => false,
                                'title'     => 'my_cat2'
                            )
                        ),
                        'manufacturer'           => null,
                        'shipments'              => array(),
                        'size'                   => array(),
                        'available_quantity'     => null,
                        'weight'                 => null,
                        'is_discounted'          => false,
                        'ean'                    => null,
                        'upc'                    => null,
                        'isbn'                   => null,
                        'images'                 => array(),
                        'informations'           => new \stdClass(),
                        'related_products'       => array(),
                        'variations'             => array()
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
        OystCollectionHelper::cleanData($data);

        $this->assertEquals($data, $expectedData);
    }

    /**
     * @dataProvider collectionData
     */
    public function testCollectionToArray($collection, $expectedData)
    {
        $data = OystCollectionHelper::collectionToArray($collection);

        $this->assertEquals($data, $expectedData);
    }
}
