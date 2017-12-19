<?php

namespace Oyst\Classes;

/**
 * Class OneClickNotifications
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OneClickNotifications implements OystArrayInterface
{
    /**
     * Notification url (migration of notification passed in headers)
     * @var string
     */
    private $url = null;

    /**
     * @var array
     */
    private $events = array();

    /**
     * @var bool
     */
    private $shouldAskShipments = null;

    /**
     * @var bool
     */
    private $shouldAskStock = null;

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
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param array $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @param string $event
     */
    public function addEvent($event)
    {
        $this->events[] = (string)$event;
    }

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
     * @return bool
     */
    public function isShouldAskStock()
    {
        return $this->shouldAskStock;
    }

    /**
     * @param bool $shouldAskStock
     */
    public function setShouldAskStock($shouldAskStock)
    {
        $this->shouldAskStock = (bool)$shouldAskStock;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $notifications = array(
            'url' => $this->url,
            'events' => $this->events,
            'should_ask_shipments' => $this->shouldAskShipments,
            'should_ask_stock' => $this->shouldAskStock,
        );

        return $notifications;
    }
}
