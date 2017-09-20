<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OneClickOrderParams;

/**
 * Class OneClickOrderParamsFixture
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickOrderParamsFixture
{
    /**
     * @return OneClickOrderParams
     */
    public static function getOrderParams()
    {
        $oneClickOrderParams = new OneClickOrderParams();
        $oneClickOrderParams->setDelay(5);
        $oneClickOrderParams->setIsMaterialized(false);
        $oneClickOrderParams->setManageQuantity(false);
        $oneClickOrderParams->setShouldReinitBuffer(true);

        return $oneClickOrderParams;
    }
}
