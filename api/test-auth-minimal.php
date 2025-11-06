<?php
// Minimal auth test - show exact error
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting auth test...\n";

try {
    echo "1. Loading Response.php...\n";
    require_once __DIR__ . '/core/Response.php';
    echo "✅ Response.php loaded\n";

    echo "2. Loading Database.php...\n";
    require_once __DIR__ . '/core/Database.php';
    echo "✅ Database.php loaded\n";

    echo "3. Loading Auth.php...\n";
    require_once __DIR__ . '/core/Auth.php';
    echo "✅ Auth.php loaded\n";

    echo "4. Setting headers...\n";
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    echo "✅ Headers set\n";

    echo "5. Getting POST data...\n";
    $data = json_decode(file_get_contents('php://input'), true);
    echo "✅ Data received: " . print_r($data, true) . "\n";

    echo "6. Attempting login...\n";
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $user = Auth::login($email, $password, false);
    echo "✅ Login successful\n";

    echo "7. Sending response...\n";
    Response::success($user, 'Giriş başarılı');

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    Response::error($e->getMessage(), 400);
}
