<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OneClickNotifications;

/**
 * Class OneClickNotificationsFixture
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickNotificationsFixture
{
    /**
     * @return OneClickNotifications
     */
    public static function getNotifications()
    {
        $notifications = new OneClickNotifications();
        $notifications->setShouldAskShipments(true);
        $notifications->setUrl('http://localhost/success');

        return $notifications;
    }
}
