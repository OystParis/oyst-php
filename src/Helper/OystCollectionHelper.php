<?php

namespace Oyst\Helper;

use Oyst\Classes\OystArrayInterface;

/**
 * Class OystCollectionHelper
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class OystCollectionHelper
{
    /**
     * @param $collection
     *
     * @return array
     */
    public static function collectionToArray($collection)
    {
        $data = array();

        /** @var OystArrayInterface $element */
        foreach ($collection as $element) {
            $data[] = $element->toArray();
        }

        return $data;
    }

    /**
     * Unset empty values
     *
     * @param array $data
     */
    public static function cleanData(&$data)
    {
        foreach ($data as $field => $value) {
            if (!is_array($value) && !is_integer($value)) {
                if ((empty($value) || !$value) && $value != '0') {
                    unset($data[$field]);
                }
            }
            if (is_array($value) && empty($value)) {
                unset($data[$field]);
            }
        }
    }
}
