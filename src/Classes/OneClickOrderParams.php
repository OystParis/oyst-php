<?php

namespace Oyst\Classes;

/**
 * Class OneClickOrderParams
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickOrderParams implements OystArrayInterface
{
    /**
     * @var bool
     */
    private $isMaterialized = null;

    /**
     * @var int
     */
    private $delay = null;

    /**
     * @var bool
     */
    private $manageQuantity = null;

    /**
     * @var bool
     */
    private $shouldReinitBuffer = null;

    /**
     * @var bool
     */
    private $isCheckoutCart = false;

    /**
     * @var bool
     */
    private $allowDiscountCoupon = false;

    /**
     * @return bool
     */
    public function isMaterialized()
    {
        return $this->isMaterialized;
    }

    /**
     * Is order materialized
     *
     * @param bool $isMaterialized
     */
    public function setIsMaterialized($isMaterialized)
    {
        $this->isMaterialized = (bool)$isMaterialized;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Delay in minutes ; minimum 1.
     *
     * @param int $delay
     */
    public function setDelay($delay)
    {
        if (1 > $delay) {
            $delay = 1;
        }
        $this->delay = (int)$delay;
    }

    /**
     * @return bool
     */
    public function isManageQuantity()
    {
        return $this->manageQuantity;
    }

    /**
     * Allow to adjust quantity
     *
     * @param bool $manageQuantity
     */
    public function setManageQuantity($manageQuantity)
    {
        $this->manageQuantity = (bool)$manageQuantity;
    }


    /**
     * @return bool
     */
    public function isShouldReinitBuffer()
    {
        return $this->shouldReinitBuffer;
    }

    /**
     * Reinit the buffer (timer) when product added
     *
     * @param bool $shouldReinitBuffer
     */
    public function setShouldReinitBuffer($shouldReinitBuffer)
    {
        $this->shouldReinitBuffer = (bool)$shouldReinitBuffer;
    }

    /**
     * @return bool
     */
    public function isCheckoutCart()
    {
        return $this->isCheckoutCart;
    }

    /**
     * Is order cart checkout
     *
     * @param bool $isCheckoutCart
     */
    public function setIsCheckoutCart($isCheckoutCart)
    {
        $this->isCheckoutCart = (bool)$isCheckoutCart;
    }

    /**
     * @return bool
     */
    public function isAllowDiscountCoupon()
    {
        return $this->allowDiscountCoupon;
    }

    /**
     * @param bool $allowDiscountCoupon
     */
    public function setAllowDiscountCoupon($allowDiscountCoupon)
    {
        $this->allowDiscountCoupon = (bool)$allowDiscountCoupon;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $orderParams = array(
            'is_materialized' => $this->isMaterialized,
            'delay' => $this->delay,
            'manage_quantity' => $this->manageQuantity,
            'should_reinit_buffer' => $this->shouldReinitBuffer,
            'is_cart_checkout' => $this->isCheckoutCart,
            'allow_discount_coupon' => $this->allowDiscountCoupon,
        );

        return $orderParams;
    }
}
