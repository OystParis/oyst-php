<?php

/**
 * @category Oyst
 * @author   Oyst <dev@oyst.com>
 * @license  Copyright 2017, Oyst
 * @link     http://www.oyst.com
 */
if (!$loader = @include __DIR__ . '/../vendor/autoload.php') {
    die('Project dependencies missing');
}

$loader->add('Oyst\Test', __DIR__);
