<?php

namespace Oyst\Classes;

/**
 * Interface OystArrayInterface
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
interface OystArrayInterface
{
    /**
     * Transform object to array to send it to the API
     *
     * @return array
     */
    public function toArray();
}
