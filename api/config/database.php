<?php

/**
 * Database Configuration
 *
 * Güvenlik notu: Production'da environment variables kullanın
 */

return array(
    'host' => 'localhost',
    'database' => 'u647793141_allergytr',
    'username' => 'u647793141_allergytr',
    'password' => 'Qw-3456789',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    )
);
