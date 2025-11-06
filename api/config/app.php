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
        'root' => dirname(__DIR__, 2),
        'api' => dirname(__DIR__),
        'public' => dirname(__DIR__, 2) . '/public',
        'modules' => dirname(__DIR__) . '/modules',
    )
);
