<?php

use OsiOpenSource\LaravelTeamsLogging\LoggerAvatar;
use OsiOpenSource\LaravelTeamsLogging\LoggerColour;

return [
    /*
    |--------------------------------------------------------------------------
    | Display Avatars
    |--------------------------------------------------------------------------
    |
    | Display avatars in teams notification. When dissalowed, avatars value will
    | not used. Allowed value: true (default) and false
    |
    */
    'show_avatars' => true,

    /*
    |--------------------------------------------------------------------------
    | Display Error Type
    |--------------------------------------------------------------------------
    |
    | Display error type in teams notification. Allowed value: true (default) and false
    |
    */
    'show_type' => true,

    /*
    |--------------------------------------------------------------------------
    | Avatars
    |--------------------------------------------------------------------------
    |
    | Avatars icon to display for each log type
    |
    */
    'avatars' => [
        'emergency' => LoggerAvatar::EMERGENCY,
        'alert'     => LoggerAvatar::ALERT,
        'critical'  => LoggerAvatar::CRITICAL,
        'error'     => LoggerAvatar::ERROR,
        'warning'   => LoggerAvatar::WARNING,
        'notice'    => LoggerAvatar::NOTICE,
        'info'      => LoggerAvatar::INFO,
        'debug'     => LoggerAvatar::DEBUG,
    ],

    /*
    |--------------------------------------------------------------------------
    | Colours
    |--------------------------------------------------------------------------
    |
    | Colours to display for each log type
    |
    */
    'colours' => [
        'emergency' => LoggerColour::EMERGENCY,
        'alert'     => LoggerColour::ALERT,
        'critical'  => LoggerColour::CRITICAL,
        'error'     => LoggerColour::ERROR,
        'warning'   => LoggerColour::WARNING,
        'notice'    => LoggerColour::NOTICE,
        'info'      => LoggerColour::INFO,
        'debug'     => LoggerColour::DEBUG,
    ],
];
