<?php

/**
 * Class CollectionHelper
 *
 * PHP version 5.2
 *
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
class CollectionHelper
{
    /**
     * @param $collection
     *
     * @return array
     */
    static public function collectionToArray($collection)
    {
        $data = array();

        /** @var ArrayableInterface $element */
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
    static public function cleanData(&$data)
    {
        foreach ($data as $field => $value) {
            if (!is_array($value) && !is_integer($value)) {
                if (empty($value) || !$value) {
                    unset($data[$field]);
                }
            }
            if (is_array($value) && empty($value)) {
                unset($data[$field]);
            }
        }
    }
}
