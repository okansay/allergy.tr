<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>API Test - Step by Step</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";

echo "<h2>Step 1: Load Response.php</h2>";
try {
    require_once __DIR__ . '/api/core/Response.php';
    echo "✅ Response.php loaded successfully<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 2: Load Database.php</h2>";
try {
    require_once __DIR__ . '/api/core/Database.php';
    echo "✅ Database.php loaded successfully<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 3: Load Auth.php</h2>";
try {
    require_once __DIR__ . '/api/core/Auth.php';
    echo "✅ Auth.php loaded successfully<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 4: Test Database Connection</h2>";
try {
    $conn = Database::getConnection();
    echo "✅ Database connection successful<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 5: Test Query</h2>";
try {
    $result = Database::query('SELECT COUNT(*) as count FROM users');
    echo "✅ Query successful. User count: " . $result[0]['count'] . "<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 6: Test Auth Init</h2>";
try {
    Auth::initSession();
    echo "✅ Session initialized<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>✅ ALL TESTS PASSED!</h2>";
echo "<p>The API should work. Try login now.</p>";
