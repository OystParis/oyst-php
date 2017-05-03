<?php

namespace Oyst\Classes;

/**
 * Class OystOrder
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystOrder
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $productReference;

    /**
     * @var string
     */
    private $skuReference;

    /**
     * @var int
     */
    private $productAmount;

    /**
     * @var string
     */
    private $productCurrency;

    /**
     * @var int
     */
    private $orderAmount;

    /**
     * @var string
     */
    private $orderCurrency;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $currentStatus;

    /**
     * @var OystShipment
     */
    private $shipment;

    /**
     * @var array
     */
    private $statusHistoric;

    /**
     * @var OystUser
     */
    private $user;

    /**
     * @var string
     */
    private $cpa;

    /**
     * @var string
     */
    private $commissionValue;

    /**
     * @var string
     */
    private $commissionCurrency;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return OystOrder
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductReference()
    {
        return $this->productReference;
    }

    /**
     * @param string $productReference
     *
     * @return OystOrder
     */
    public function setProductReference($productReference)
    {
        $this->productReference = $productReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getSkuReference()
    {
        return $this->skuReference;
    }

    /**
     * @param string $skuReference
     *
     * @return OystOrder
     */
    public function setSkuReference($skuReference)
    {
        $this->skuReference = $skuReference;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductAmount()
    {
        return $this->productAmount;
    }

    /**
     * @param int $productAmount
     *
     * @return OystOrder
     */
    public function setProductAmount($productAmount)
    {
        $this->productAmount = $productAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductCurrency()
    {
        return $this->productCurrency;
    }

    /**
     * @param string $productCurrency
     *
     * @return OystOrder
     */
    public function setProductCurrency($productCurrency)
    {
        $this->productCurrency = $productCurrency;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * @param int $orderAmount
     *
     * @return OystOrder
     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderCurrency()
    {
        return $this->orderCurrency;
    }

    /**
     * @param string $orderCurrency
     *
     * @return OystOrder
     */
    public function setOrderCurrency($orderCurrency)
    {
        $this->orderCurrency = $orderCurrency;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return OystOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @param string $currentStatus
     *
     * @return OystOrder
     */
    public function setCurrentStatus($currentStatus)
    {
        $this->currentStatus = $currentStatus;

        return $this;
    }

    /**
     * @return OystShipment
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @param OystShipment $shipment
     *
     * @return OystOrder
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * @return array
     */
    public function getStatusHistoric()
    {
        return $this->statusHistoric;
    }

    /**
     * @param array $statusHistoric
     *
     * @return OystOrder
     */
    public function setStatusHistoric($statusHistoric)
    {
        $this->statusHistoric = $statusHistoric;

        return $this;
    }

    /**
     * @return OystUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param OystUser $user
     *
     * @return OystOrder
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getCpa()
    {
        return $this->cpa;
    }

    /**
     * @param string $cpa
     *
     * @return OystOrder
     */
    public function setCpa($cpa)
    {
        $this->cpa = $cpa;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommissionValue()
    {
        return $this->commissionValue;
    }

    /**
     * @param string $commissionValue
     *
     * @return OystOrder
     */
    public function setCommissionValue($commissionValue)
    {
        $this->commissionValue = $commissionValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommissionCurrency()
    {
        return $this->commissionCurrency;
    }

    /**
     * @param string $commissionCurrency
     *
     * @return OystOrder
     */
    public function setCommissionCurrency($commissionCurrency)
    {
        $this->commissionCurrency = $commissionCurrency;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return OystOrder
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return OystOrder
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
