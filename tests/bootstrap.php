<?php

$autoloader = __DIR__ . '/../vendor/autoload.php';

if (!is_readable($autoloader)) {
    die(PHP_EOL . "Missing Composer's vendor/autoload.php; run 'composer install' first." . PHP_EOL . PHP_EOL);
}

if (! function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        return $default;
    }
}

require_once $autoloader;