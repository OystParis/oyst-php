<?php

function oystAutoload($className)
{
    $folders = array(
        'api',
        'classes',
        'helper',
    );

    // Simple autoload without sub directories for now
    foreach ($folders as $folder) {
        $path = __DIR__.'/src/'.$folder.'/'.$className.'.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
}

spl_autoload_register('oystAutoload');

require_once __DIR__.'/vendor/autoload.php';
