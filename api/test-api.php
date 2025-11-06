<?php

/**
 * API Test - Shows exact PHP errors
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>API Test</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";

echo "<h2>1. Testing Config Files</h2>";
try {
    $dbConfig = require __DIR__ . '/config/database.php';
    echo "✅ database.php loaded successfully<br>";
    echo "<pre>" . print_r($dbConfig, true) . "</pre>";
} catch (Exception $e) {
    echo "❌ database.php error: " . $e->getMessage() . "<br>";
}

try {
    $appConfig = require __DIR__ . '/config/app.php';
    echo "✅ app.php loaded successfully<br>";
    echo "<pre>" . print_r($appConfig, true) . "</pre>";
} catch (Exception $e) {
    echo "❌ app.php error: " . $e->getMessage() . "<br>";
}

echo "<h2>2. Testing Core Classes</h2>";
try {
    require_once __DIR__ . '/core/Database.php';
    echo "✅ Database.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Database.php error: " . $e->getMessage() . "<br>";
}

try {
    require_once __DIR__ . '/core/Response.php';
    echo "✅ Response.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Response.php error: " . $e->getMessage() . "<br>";
}

try {
    require_once __DIR__ . '/core/Auth.php';
    echo "✅ Auth.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Auth.php error: " . $e->getMessage() . "<br>";
}

echo "<h2>3. Testing Database Connection</h2>";
try {
    $conn = Database::getConnection();
    echo "✅ Database connected successfully<br>";

    // Test query
    $result = Database::query('SELECT COUNT(*) as count FROM users');
    echo "✅ Query executed. User count: " . $result[0]['count'] . "<br>";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
    echo "<pre>Stack trace: " . $e->getTraceAsString() . "</pre>";
}

echo "<h2>4. Testing Auth Class</h2>";
try {
    Auth::initSession();
    echo "✅ Session initialized<br>";

    $user = Auth::user();
    echo "Current user: " . ($user ? $user['email'] : 'Not logged in') . "<br>";
} catch (Exception $e) {
    echo "❌ Auth error: " . $e->getMessage() . "<br>";
    echo "<pre>Stack trace: " . $e->getTraceAsString() . "</pre>";
}

echo "<h2>5. Testing Login Endpoint</h2>";
echo "<p>Now test: <a href='/api/auth.php?action=login' target='_blank'>/api/auth.php?action=login</a></p>";
