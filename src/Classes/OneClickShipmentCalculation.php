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
class OneClickShipmentCalculation implements OystArrayInterface
{
    /**
     * @var OneClickShipmentCatalogLess[]
     */
    private $shipments;

    /**
     * @var OneClickItem[]
     */
    private $items = array();

    /**
     * Promotional message
     *
     * @var string
     */
    private $message;

    /**
     * @var OystPrice
     */
    private $orderAmount;

    /**
     * Constructs a OneClickShipmentCalculation instance.
     *
     * @param OneClickShipmentCatalogLess[] $shipments
     */
    public function __construct(array $shipments)
    {
        $this->setShipments($shipments);
        //$this->items = array();
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
     * @return OneClickShipmentCalculation
     */
    public function setShipments($shipments)
    {
        if (!empty($shipments)) {
            foreach ($shipments as $shipment) {
                if (!$shipment instanceof OneClickShipmentCatalogLess) {
                    throw new InvalidArgumentException('$shipment must be an array of
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
     * @return OneClickShipmentCalculation
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
     * @return OneClickShipmentCalculation
     */
    public function setItems($items)
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                if (!$item instanceof OneClickItem) {
                    throw new InvalidArgumentException('$item must be an array of Oyst\Classes\OneClickItem');
                }
            }

            $this->items = $items;
        }

        return $this;
    }

    /**
     * @param OneClickItem $item
     *
     * @return OneClickShipmentCalculation
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
     * @return OneClickShipmentCalculation
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return OystPrice
     */
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * @param OystPrice $orderAmount
     *
     * @return OneClickShipmentCalculation
     */
    public function setOrderAmount(OystPrice $orderAmount)
    {
        $this->orderAmount = $orderAmount;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $oystCollectionHelper = new OystCollectionHelper();

        $oneClickShipmentCalculation = array(
            'shipments' => $oystCollectionHelper->collectionToArray($this->shipments),
            'items' => $oystCollectionHelper->collectionToArray($this->items),
            'message' => $this->message,
            'order_amount' => $this->orderAmount instanceof OystPrice ? $this->orderAmount->toArray() : array(),
        );

        return $oneClickShipmentCalculation;
    }

    /**
     * @return string
     */
    public function toJson($params = null)
    {
        $oneClickShipmentCalculation = $this->toArray();
        $oystCollectionHelper = new OystCollectionHelper();
        $oystCollectionHelper->cleanData($oneClickShipmentCalculation);

        return json_encode($oneClickShipmentCalculation, $params);
    }
}
