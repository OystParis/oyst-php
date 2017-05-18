<?php

namespace Oyst\Test\Fixture;

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
