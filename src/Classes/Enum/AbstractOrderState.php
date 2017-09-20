<?php

namespace Oyst\Classes\Enum;

/**
 * Class AbstractOrderState
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class AbstractOrderState
{
    const WAITING = 'waiting';
    const DENIED = 'denied';
    const ACCEPTED = 'accepted';
    const FINALIZED = 'finalized';
    const PENDING = 'pending';
    const REFUNDED = 'refunded';
    const SHIPPED = 'shipped';

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
