<?php

namespace Oyst\Classes\Enum;

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
