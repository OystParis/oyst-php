<?php

namespace Oyst\Test\Helper;

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
        return array(
            array(array('created_at' => '1955-11-05 17:37:42'), new \DateTime('1955-11-05 17:37:42')),
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

    }
}
