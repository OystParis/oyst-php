<?php

namespace Oyst\Classes;

use Oyst\Helper\OystCollectionHelper;

/**
 * Class OystProduct
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystProduct implements OystArrayInterface
{
    /**
     * Mandatory
     *
     * @var string
     */
    private $reference;

    /**
     * Mandatory
     *
     * @var string
     */
    private $title;

    /**
     * Mandatory
     *
     * @var OystPrice
     */
    private $amountIncludingTax;

    /**
     * Mandatory
     *
     * @var int
     */
    private $quantity;


    /**
     * Optional
     *
     * @var bool
     */
    private $active;

    /**
     * Optional
     *
     * @var bool
     */
    private $materialized;

    /**
     * Optional
     *
     * @var string
     */
    private $condition;

    /**
     * Optional
     *
     * @var string
     */
    private $shortDescription;

    /**
     * Optional
     *
     * @var string
     */
    private $description;

    /**
     * Optional
     *
     * @var array
     */
    private $tags;

    /**
     * Optional
     *
     * @var OystPrice
     */
    private $amountExcludingTax;

    /**
     * Optional
     *
     * @var string
     */
    private $url;

    /**
     * Optional
     *
     * @var OystCategory[]
     */
    private $categories;

    /**
     * Optional
     *
     * @var string
     */
    private $manufacturer;

    /**
     * Optional
     *
     * @var OystShipment[]
     */
    private $shipments;

    /**
     * Optional
     *
     * @var OystSize
     */
    private $size;

    /**
     * Optional
     *
     * @var int
     */
    private $availableQuantity;

    /**
     * Optional
     *
     * @var string
     */
    private $weight;

    /**
     * Optional
     *
     * @var bool
     */
    private $discounted;

    /**
     * Optional
     *
     * @var string
     */
    private $ean;

    /**
     * Optional
     *
     * @var string
     */
    private $upc;

    /**
     * Optional
     *
     * @var string
     */
    private $isbn;

    /**
     * Optional
     *
     * @var array
     */
    private $images;

    /**
     * Optional
     *
     * @var array
     */
    private $information;

    /**
     * Optional
     *
     * @var array
     */
    private $relatedProducts;

    /**
     * Optional
     *
     * @var array
     */
    private $variations;

    public function __construct()
    {
        $this->condition = null;
        $this->discounted = false;
        $this->categories = array();
        $this->shipments = array();
        $this->tags = array();
        $this->images = array();
        $this->relatedProducts = array();
        $this->variations = array();
        $this->information = array();
    }

    /**
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * @param $property
     * @param $value
     *
     * @return $this
     */
    public function __set($property, $value)
    {
        $this->$property = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $oystCollectionHelper = new OystCollectionHelper();

        $product = array(
            'reference' => $this->reference,
            'title' => $this->title,
            'amount_including_taxes' => $this->amountIncludingTax ? $this->amountIncludingTax->toArray() : array(),
            'quantity' => $this->quantity,

            'is_active' => $this->active,
            'is_materialized' => $this->materialized,
            'condition' => $this->condition,
            'short_description' => $this->shortDescription,
            'description' => $this->description,
            'tags' => $this->tags,
            'amount_excluding_taxes' => $this->amountExcludingTax ? $this->amountExcludingTax->toArray() : array(),
            'url' => $this->url,
            'categories' => $oystCollectionHelper->collectionToArray($this->categories),
            'manufacturer' => $this->manufacturer,
            'shipments' => $oystCollectionHelper->collectionToArray($this->shipments),
            'size' => $this->size ? $this->size->toArray() : array(),
            'available_quantity' => $this->availableQuantity,
            'weight' => $this->weight,
            'is_discounted' => $this->discounted,
            'ean' => $this->ean,
            'upc' => $this->upc,
            'isbn' => $this->isbn,
            'images' => $this->images,
            'informations' => $this->information ?: new \stdClass(),
            'related_products' => $this->relatedProducts,
            'variations' => $oystCollectionHelper->collectionToArray($this->variations),
        );

        return $product;
    }
}
