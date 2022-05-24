<?php

if (! function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle)
    {
        $needle_len = strlen($needle);
        return ($needle_len === 0 || 0 === substr_compare($haystack, $needle, - $needle_len));
    }
}

function api_files() {
    $files = [];

    $iter = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(__DIR__ . '/API', RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
        RecursiveIteratorIterator::CATCH_GET_CHILD
    );

    foreach ($iter as $path => $f) {
        if ($f->isFile() && str_ends_with($path, '.php'))
            $files[] = $path;
    }
    
    return $files;
}

foreach(api_files() as $file) {
    require_once($file);
}

require_once(__DIR__ . '/dispatcher.php');
