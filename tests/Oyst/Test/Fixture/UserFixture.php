<?php

namespace Oyst\Test\Fixture;

/**
 * Class UserFixture
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class UserFixture
{
    /**
     * @return array
     */
    public static function getOne()
    {
        return array(
            'addresses' => array(),
            'billing_addresses' => array(),
            'email' => 'test@oyst.com',
            'first_name' => 'Test',
            'language' => 'fr',
            'last_name' => 'Test',
            'phone' => '0100000000',
        );
    }
}
