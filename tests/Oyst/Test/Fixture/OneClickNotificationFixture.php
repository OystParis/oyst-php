<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OneClickNotification;

/**
 * Class OneClickNotificationFixture
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickNotificationFixture
{
    /**
     * @return OneClickNotification
     */
    public static function getNotification()
    {
        $notification = new OneClickNotification();
        $notification->setShouldAskShipments(true);
        $notification->setUrl('http://localhost/success');

        return $notification;
    }
}
