<?php

namespace Oyst\Classes;

use Oyst\Helper\OystCollectionHelper;

/**
 * Class OneClickShipmentCalculation
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickOrderCartEstimate implements OystArrayInterface
{
    /**
     * Mandatory
     *
     * @var OneClickShipmentCatalogLess[]
     */
    private $shipments;

    /**
     * Optional
     *
     * @var OneClickItem[]
     */
    private $items = array();

    /**
     * Optional
     *
     * Promotional message
     *
     * @var string
     */
    private $message;

    /**
     * Optional
     *
     * @var OystPrice
     */
    private $cartAmount;

    /**
     * Optional
     *
     * @var OneClickItem[]
     */
    private $freeItems;

    /**
     * Optional
     *
     * @var OneClickMerchantDiscount
     */
    private $merchantDiscounts;

    /**
     * Optional
     *
     * Discount coupon error message
     *
     * @var string
     */
    private $discountCouponError;

    /**
     * Constructs a OneClickShipmentCalculation instance.
     *
     * @param OneClickShipmentCatalogLess[] $shipments
     */
    public function __construct(array $shipments = null)
    {
        $this->setShipments($shipments);
    }

    /**
     * @return OneClickShipmentCatalogLess[]
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * @param OneClickShipmentCatalogLess[] $shipments
     *
     * @return $this
     */
    public function setShipments($shipments)
    {
        if (!empty($shipments)) {
            foreach ($shipments as $shipment) {
                if (!$shipment instanceof OneClickShipmentCatalogLess) {
                    throw new \InvalidArgumentException('$shipment must be an array of
                    Oyst\Classes\OneClickShipmentCatalogLess');
                }
            }

            $this->shipments = $shipments;
        }

        return $this;
    }

    /**
     * @param OneClickShipmentCatalogLess $shipment
     *
     * @return $this
     */
    public function addShipment(OneClickShipmentCatalogLess $shipment)
    {
        $this->shipments[] = $shipment;

        return $this;
    }

    /**
     * @return OneClickItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param OneClickItem[] $items
     *
     * @return $this
     */
    public function setItems($items)
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                if (!$item instanceof OneClickItem) {
                    throw new \InvalidArgumentException('$item must be an array of Oyst\Classes\OneClickItem');
                }
            }

            $this->items = $items;
        }

        return $this;
    }

    /**
     * @param OneClickItem $item
     *
     * @return $this
     */
    public function addItem(OneClickItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return OystPrice
     */
    public function getCartAmount()
    {
        return $this->cartAmount;
    }

    /**
     * @param OystPrice $cartAmount
     *
     * @return $this
     */
    public function setCartAmount(OystPrice $cartAmount)
    {
        $this->cartAmount = $cartAmount;

        return $this;
    }

    /**
     * @return OneClickItem[]
     */
    public function getFreeItems()
    {
        return $this->freeItems;
    }

    /**
     * @param OneClickItem[] $freeItems
     *
     * @return $this
     */
    public function setFreeItems($freeItems)
    {
        $this->freeItems = $freeItems;

        return $this;
    }

    /**
     * @param OneClickItem $freeItem
     *
     * @return $this
     */
    public function addFreeItems(OneClickItem $freeItem)
    {
        $this->freeItems[] = $freeItem;

        return $this;
    }

    /**
     * @return OneClickMerchantDiscount
     */
    public function getMerchantDiscounts()
    {
        return $this->merchantDiscounts;
    }

    /**
     * @param OneClickMerchantDiscount[] $merchantDiscounts
     *
     * @return $this
     */
    public function setMerchantDiscounts($merchantDiscounts)
    {
        if (!empty($merchantDiscounts)) {
            foreach ($merchantDiscounts as $merchantDiscount) {
                if (!$merchantDiscount instanceof OneClickMerchantDiscount) {
                    throw new \InvalidArgumentException(
                        '$merchantDiscounts must be an array of Oyst\Classes\OneClickMerchantDiscount'
                    );
                }
            }

            $this->merchantDiscounts = $merchantDiscounts;
        }

        return $this;
    }

    /**
     * @param OneClickMerchantDiscount $merchantDiscount
     *
     * @return $this
     */
    public function addMerchantDiscount(OneClickMerchantDiscount $merchantDiscount)
    {
        $this->merchantDiscounts[] = $merchantDiscount;

        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountCouponError()
    {
        return $this->discountCouponError;
    }

    /**
     * @param string $discountCouponError
     *
     * @return $this
     */
    public function setDiscountCouponError($discountCouponError)
    {
        $this->discountCouponError = $discountCouponError;

        return $this;
    }

    /**
     * Force customer to have a primary shipment
     *
     * @param string $type One carrier of OystCarrier
     *
     * @return $this
     */
    public function setDefaultPrimaryShipmentByType($type = OystCarrier::HOME_DELIVERY)
    {
        $isPrimarySet = false;

        // Set first shipment found with the type required.
        foreach ($this->shipments as &$shipment) {
            $shipment->setPrimary(false);

            if ($shipment->getCarrier()->getType() === $type && !$isPrimarySet) {
                $shipment->setPrimary(true);
                $isPrimarySet = true;
            }
        }

        if (!$isPrimarySet) {
            throw new \LogicException('Shipment must have a primary shipment');
        }

        $this->setShipments($this->shipments);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $oystCollectionHelper = new OystCollectionHelper();

        $oneClickOrderCartEstimate = array(
            'shipments' => $oystCollectionHelper->collectionToArray($this->shipments),
            'items' => $oystCollectionHelper->collectionToArray($this->items),
            'cart_amount' => $this->cartAmount instanceof OystPrice ? $this->cartAmount->toArray() : array(),
            'free_items' => $oystCollectionHelper->collectionToArray($this->freeItems),
            'merchant_discounts' => $oystCollectionHelper->collectionToArray($this->merchantDiscounts),
            'message' => $this->message,
            'discount_coupon_error' => $this->discountCouponError,
        );

        return $oneClickOrderCartEstimate;
    }

    /**
     * @return string
     */
    public function toJson($params = null)
    {
        $oneClickOrderCartEstimate = $this->toArray();
        $oystCollectionHelper = new OystCollectionHelper();
        $oystCollectionHelper->cleanData($oneClickOrderCartEstimate);

        return json_encode($oneClickOrderCartEstimate, $params);
    }
}
