<?php

namespace Oyst\Test\Helper;

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
        $price = new OystPrice(13.37, 'EUR');
        $product = new OystProduct('ref1', 'title1', $price, 42);

        return array(
            array(
                array(
                    $product
                ),
                array(
                    array(
                        'reference' => 'ref1',
                        'title' => 'title1',
                        'amount_including_taxes' => array(
                            'value' => 1337,
                            'currency' => 'EUR',
                        ),
                        'quantity' => 42,
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
