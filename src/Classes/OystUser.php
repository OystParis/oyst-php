<?php

namespace Oyst\Classes;

use Oyst\Helper\OystCollectionHelper;

/**
 * Class OystUser
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystUser implements OystArrayInterface
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $additionalData;

    /**
     * @var array
     */
    private $addresses;

    /**
     * @var array
     */
    private $billingAddresses;

    public function __construct()
    {
        $this->addresses        = array();
        $this->billingAddresses = array();
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return OystUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return OystUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return OystUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return OystUser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return OystUser
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return array
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }

    /**
     * @param array $additionalData Custom array
     *
     * @return OystUser
     */
    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param array $addresses An array of Address
     *
     * @return OystUser
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @param OystAddress $address
     *
     * @return OystUser
     */
    public function addAddress(OystAddress $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * @return array
     */
    public function getBillingAddresses()
    {
        return $this->billingAddresses;
    }

    /**
     * @param array $billingAddresses An array of Address
     *
     * @return OystUser
     */
    public function setBillingAddresses($billingAddresses)
    {
        $this->billingAddresses = $billingAddresses;

        return $this;
    }

    /**
     * @param OystAddress $billingAddress
     *
     * @return OystUser
     */
    public function addBillingAddress(OystAddress $billingAddress)
    {
        $this->billingAddresses[] = $billingAddress;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $user = array(
            'first_name'        => $this->firstName,
            'last_name'         => $this->lastName,
            'language'          => $this->language,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'additional_data'   => $this->additionalData,
            'addresses'         => OystCollectionHelper::collectionToArray($this->addresses),
            'billing_addresses' => OystCollectionHelper::collectionToArray($this->billingAddresses),
        );

        return $user;
    }
}
