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
     * @return OneClickOrderParams $orderParams
     */
    public static function getOrderParams()
    {
        $orderParams = new OneClickOrderParams();
        $orderParams->setDelay(5);
        $orderParams->setIsMaterialized(false);
        $orderParams->setManageQuantity(false);
        $orderParams->setShouldReinitBuffer(true);

        return $orderParams;
    }
}
