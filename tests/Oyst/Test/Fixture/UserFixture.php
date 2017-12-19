<?php

namespace Oyst\Test\Fixture;

use Oyst\Classes\OystAddress;
use Oyst\Classes\OystUser;

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
     * @return OystUser $user
     */
    public static function getOne()
    {
        $user = new OystUser();
        $user->setEmail('foo.bar@oyst.com');
        $user->setPhone('0123456789');

        $oystAddress = new OystAddress();
        $oystAddress->setFirstName('Foo');
        $oystAddress->setLastName('Bar');
        $oystAddress->setCompanyName('Oyst');
        $oystAddress->setLabel('Work');
        $oystAddress->setStreet('123 rue de la victoire');
        $oystAddress->setComplementary('Code 007');
        $oystAddress->setPostCode('75016');
        $oystAddress->setCity('Paris');
        $oystAddress->setRegion('Paris');
        $oystAddress->setCountry('FR');

        $user->setAddresses(array($oystAddress));
        $user->setBillingAddresses(array($oystAddress));
        $user->setLanguage('fr');
        $user->setLastName('Bar');
        $user->setFirstName('Foo');
        $user->setAdditionalData(array('Floor' => '2nd'));

        return $user;
    }
}
