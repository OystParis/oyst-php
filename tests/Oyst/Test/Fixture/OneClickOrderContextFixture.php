<?php

namespace Oyst\Test\Fixture;

/**
 * Class OneClickOrderContextFixture
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickOrderContextFixture
{
    /**
     * @return array
     */
    public static function getOrderContext()
    {
        return array(
            'mykey' => 'myvalue',
            'happy' => true,
        );
    }
}
