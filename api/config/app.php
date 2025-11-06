<?php

/**
 * Application Configuration
 */

return array(
    'name' => 'Allergy.tr',
    'version' => '1.0.0',
    'environment' => 'development', // development, production
    'debug' => true,
    'timezone' => 'Europe/Istanbul',
    'locale' => 'tr',

    'session' => array(
        'lifetime' => 7200, // 2 hours
        'cookie_name' => 'allergytr_session',
        'secure' => false, // true for HTTPS only
        'httponly' => true,
        'samesite' => 'Lax'
    ),

    'paths' => array(
        'root' => dirname(dirname(__DIR__)),
        'api' => dirname(__DIR__),
        'public' => dirname(dirname(__DIR__)) . '/public',
        'modules' => dirname(__DIR__) . '/modules',
    )
);
