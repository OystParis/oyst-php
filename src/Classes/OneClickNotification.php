<?php

namespace Oyst\Classes;

/**
 * Class OneClickNotification
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickNotification implements OystArrayInterface
{
    /**
     * @var bool
     */
    private $shouldAskShipments;

    /**
     * @var string
     */
    private $url;

    /**
     * @return bool
     */
    public function isShouldAskShipments()
    {
        return $this->shouldAskShipments;
    }

    /**
     * @param bool $shouldAskShipments
     */
    public function setShouldAskShipments($shouldAskShipments)
    {
        $this->shouldAskShipments = (bool)$shouldAskShipments;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $notification = array(
            'should_ask_shipments' => $this->shouldAskShipments,
            'url' => $this->url,
        );

        return $notification;
    }
}
