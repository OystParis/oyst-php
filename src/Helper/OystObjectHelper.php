<?php

/**
 * Class ObjectHelper
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
namespace Oyst\Helper;

class OystObjectHelper
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    static public function getValue($data)
    {
        $value = isset($data) ? $data : null;

        return $value;
    }

    /**
     * @param string $data
     *
     * @return \DateTime|null
     */
    static public function getDate($data)
    {
        $date = isset($data) ? new \DateTime($data) : null;

        return $date;
    }
}
