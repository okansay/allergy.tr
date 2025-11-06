<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Index Minimal Test</h1>";
echo "<p>Testing each include step by step...</p>";

echo "<h2>Step 1: Load Auth</h2>";
try {
    require_once __DIR__ . '/api/core/Auth.php';
    echo "✅ Auth.php loaded<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 2: Init Session</h2>";
try {
    Auth::initSession();
    echo "✅ Session initialized<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 3: Get User</h2>";
try {
    $user = Auth::user();
    echo "✅ User: " . ($user ? $user['email'] : 'Not logged in') . "<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 4: Include Header</h2>";
$pageTitle = 'Test Page';
try {
    include __DIR__ . '/shared/components/header.php';
    echo "✅ Header included<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 5: Include Sidebar</h2>";
try {
    include __DIR__ . '/shared/components/sidebar.php';
    echo "✅ Sidebar included<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 6: Include Dashboard</h2>";
try {
    include __DIR__ . '/dashboard.php';
    echo "✅ Dashboard included<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>Step 7: Include Footer</h2>";
try {
    include __DIR__ . '/shared/components/footer.php';
    echo "✅ Footer included<br>";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    die();
}

echo "<h2>✅ ALL INCLUDES SUCCESSFUL!</h2>";
