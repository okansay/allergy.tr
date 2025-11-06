<?php
// Debug version of auth.php - shows exactly where it fails

// Step 1: Basic output
header('Content-Type: text/plain; charset=utf-8');
echo "Step 1: Starting auth-debug.php\n";
flush();

// Step 2: Try to load Response
echo "Step 2: Loading Response.php...\n";
try {
    require_once __DIR__ . '/core/Response.php';
    echo "✅ Response.php loaded\n";
} catch (Throwable $e) {
    echo "❌ Failed to load Response.php: " . $e->getMessage() . "\n";
    die();
}
flush();

// Step 3: Try to load Database
echo "Step 3: Loading Database.php...\n";
try {
    require_once __DIR__ . '/core/Database.php';
    echo "✅ Database.php loaded\n";
} catch (Throwable $e) {
    echo "❌ Failed to load Database.php: " . $e->getMessage() . "\n";
    die();
}
flush();

// Step 4: Try to load Auth
echo "Step 4: Loading Auth.php...\n";
try {
    require_once __DIR__ . '/core/Auth.php';
    echo "✅ Auth.php loaded\n";
} catch (Throwable $e) {
    echo "❌ Failed to load Auth.php: " . $e->getMessage() . "\n";
    die();
}
flush();

// Step 5: Set headers
echo "Step 5: Setting headers...\n";
try {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    echo "✅ Headers set\n";
} catch (Throwable $e) {
    echo "❌ Failed to set headers: " . $e->getMessage() . "\n";
    die();
}
flush();

// Step 6: Get action
echo "Step 6: Getting action parameter...\n";
$action = $_GET['action'] ?? 'none';
echo "✅ Action: $action\n";
flush();

// Step 7: Handle login
if ($action === 'login') {
    echo "Step 7: Handling login...\n";

    // Get POST data
    echo "Step 7a: Reading POST data...\n";
    $input = file_get_contents('php://input');
    echo "✅ Raw input length: " . strlen($input) . "\n";

    echo "Step 7b: Decoding JSON...\n";
    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "❌ JSON error: " . json_last_error_msg() . "\n";
        die();
    }
    echo "✅ JSON decoded\n";

    echo "Step 7c: Calling Auth::login...\n";
    try {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $user = Auth::login($email, $password, false);
        echo "✅ Login successful\n";

        // Send JSON response
        header('Content-Type: application/json; charset=utf-8');
        ob_clean(); // Clear all previous output
        Response::success($user, 'Giriş başarılı');
    } catch (Exception $e) {
        echo "❌ Login failed: " . $e->getMessage() . "\n";
        header('Content-Type: application/json; charset=utf-8');
        ob_clean();
        Response::error($e->getMessage(), 400);
    }
} else {
    echo "\n✅ All steps completed. Action was: $action\n";
}
