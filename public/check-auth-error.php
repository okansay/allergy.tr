<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Check Auth.php Error</h1>";
echo "<p>This will capture the exact error from auth.php</p>";

// Capture output
ob_start();

// Simulate POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_GET['action'] = 'login';

// Create fake input
$fakeInput = json_encode([
    'email' => 'demo@allergy.tr',
    'password' => 'password123',
    'remember' => false
]);

// Temporarily create php://input simulation
file_put_contents('php://temp/fake-input', $fakeInput);

try {
    include __DIR__ . '/api/auth.php';
} catch (Throwable $e) {
    echo "<h2 style='color:red'>❌ FATAL ERROR:</h2>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

$output = ob_get_clean();

echo "<h2>Output from auth.php:</h2>";
echo "<pre style='background:#f5f5f5;padding:10px;border:1px solid #ccc;'>";
echo htmlspecialchars($output);
echo "</pre>";

echo "<h2>First 500 characters (raw):</h2>";
echo "<pre style='background:#fff5f5;padding:10px;border:1px solid #fcc;'>";
echo htmlspecialchars(substr($output, 0, 500));
echo "</pre>";
