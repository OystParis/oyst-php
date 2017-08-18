<?php

namespace Oyst\Classes;

/**
 * Class ShipmentAmount
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class ShipmentAmount implements OystArrayInterface
{
    /**
     * @var int
     */
    private $amountFollower;

    /**
     * @var int
     */
    private $amountLeader;

    /**
     * @var string
     */
    private $currency;

    /**
     * @param int $amountFollower
     * @param int $amountLeader
     * @param string $currency
     */
    public function __construct($amountFollower, $amountLeader, $currency)
    {
        $this->setAmountFollower($amountFollower);
        $this->setAmountLeader($amountLeader);
        $this->setCurrency($currency);
    }

    /**
     * @return int
     */
    public function getAmountFollower()
    {
        return $this->amountFollower;
    }

    /**
     * @param int $amountFollower
     *
     * @return ShipmentAmount
     */
    public function setAmountFollower($amountFollower)
    {
        $this->amountFollower = (int)round($amountFollower * 100);

        return $this;
    }

    /**
     * @return int
     */
    public function getAmountLeader()
    {
        return $this->amountLeader;
    }

    /**
     * @param int $amountLeader
     *
     * @return ShipmentAmount
     */
    public function setAmountLeader($amountLeader)
    {
        $this->amountLeader = (int)round($amountLeader * 100);

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return ShipmentAmount
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $amount = array(
            'follower' => $this->amountFollower,
            'leader' => $this->amountLeader,
            'currency' => $this->currency,
        );

        return $amount;
    }
}
