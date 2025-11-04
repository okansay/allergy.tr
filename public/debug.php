<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Debug - Allergy.tr</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        pre { background: #f0f0f0; padding: 10px; overflow-x: auto; }
        h2 { margin-top: 0; border-bottom: 2px solid #135bec; padding-bottom: 10px; }
    </style>
</head>
<body>

<div class="box">
    <h2>🔍 Allergy.tr - System Debug</h2>
    <p>Bu sayfa sistemdeki sorunları tespit etmek için oluşturuldu.</p>
</div>

<!-- PHP Version -->
<div class="box">
    <h2>1. PHP Version</h2>
    <p>PHP Version: <span class="success"><?= phpversion() ?></span></p>
    <p>Server: <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></p>
    <p>Document Root: <?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></p>
</div>

<!-- File Structure -->
<div class="box">
    <h2>2. File Structure Check</h2>
    <?php
    $files_to_check = [
        'index.php' => __DIR__ . '/index.php',
        'login.php' => __DIR__ . '/login.php',
        'dashboard.php' => __DIR__ . '/dashboard.php',
        'Auth.php' => __DIR__ . '/../api/core/Auth.php',
        'Database.php' => __DIR__ . '/../api/core/Database.php',
        'Response.php' => __DIR__ . '/../api/core/Response.php',
        'auth.php API' => __DIR__ . '/../api/auth.php',
        'header.php' => __DIR__ . '/../shared/components/header.php',
        'footer.php' => __DIR__ . '/../shared/components/footer.php',
    ];

    foreach ($files_to_check as $name => $path) {
        $exists = file_exists($path);
        $readable = $exists && is_readable($path);
        echo "<p>";
        echo "$name: ";
        if ($readable) {
            echo "<span class='success'>✅ Exists & Readable</span>";
            echo " (" . number_format(filesize($path)) . " bytes)";
        } elseif ($exists) {
            echo "<span class='warning'>⚠️ Exists but NOT Readable</span>";
        } else {
            echo "<span class='error'>❌ NOT FOUND</span>";
        }
        echo "</p>";
    }
    ?>
</div>

<!-- PHP Classes -->
<div class="box">
    <h2>3. PHP Classes Check</h2>
    <?php
    // Try to load classes
    $api_path = __DIR__ . '/../api/core/';

    echo "<p>Trying to load classes from: <code>$api_path</code></p>";

    $errors = [];

    // Database
    echo "<p><strong>Database Class:</strong> ";
    try {
        if (file_exists($api_path . 'Database.php')) {
            require_once $api_path . 'Database.php';
            if (class_exists('Database')) {
                echo "<span class='success'>✅ Loaded Successfully</span>";
            } else {
                echo "<span class='error'>❌ File loaded but class not found</span>";
                $errors[] = "Database class not found after require";
            }
        } else {
            echo "<span class='error'>❌ File not found</span>";
            $errors[] = "Database.php file not found";
        }
    } catch (Exception $e) {
        echo "<span class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</span>";
        $errors[] = $e->getMessage();
    }
    echo "</p>";

    // Response
    echo "<p><strong>Response Class:</strong> ";
    try {
        if (file_exists($api_path . 'Response.php')) {
            require_once $api_path . 'Response.php';
            if (class_exists('Response')) {
                echo "<span class='success'>✅ Loaded Successfully</span>";
            } else {
                echo "<span class='error'>❌ File loaded but class not found</span>";
                $errors[] = "Response class not found after require";
            }
        } else {
            echo "<span class='error'>❌ File not found</span>";
            $errors[] = "Response.php file not found";
        }
    } catch (Exception $e) {
        echo "<span class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</span>";
        $errors[] = $e->getMessage();
    }
    echo "</p>";

    // Auth
    echo "<p><strong>Auth Class:</strong> ";
    try {
        if (file_exists($api_path . 'Auth.php')) {
            require_once $api_path . 'Auth.php';
            if (class_exists('Auth')) {
                echo "<span class='success'>✅ Loaded Successfully</span>";
            } else {
                echo "<span class='error'>❌ File loaded but class not found</span>";
                $errors[] = "Auth class not found after require";
            }
        } else {
            echo "<span class='error'>❌ File not found</span>";
            $errors[] = "Auth.php file not found";
        }
    } catch (Exception $e) {
        echo "<span class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</span>";
        $errors[] = $e->getMessage();
    }
    echo "</p>";

    if (!empty($errors)) {
        echo "<div style='background: #fee; padding: 10px; margin-top: 10px;'>";
        echo "<strong>Errors Found:</strong><br>";
        foreach ($errors as $error) {
            echo "• " . htmlspecialchars($error) . "<br>";
        }
        echo "</div>";
    }
    ?>
</div>

<!-- Database Connection -->
<div class="box">
    <h2>4. Database Connection Test</h2>
    <?php
    if (class_exists('Database')) {
        echo "<p>Attempting database connection...</p>";
        try {
            $db = Database::getConnection();
            echo "<p class='success'>✅ Database connection successful!</p>";

            // Test query
            $result = Database::query("SELECT COUNT(*) as cnt FROM users");
            echo "<p>Users table: <span class='success'>" . $result[0]['cnt'] . " users found</span></p>";

        } catch (Exception $e) {
            echo "<p class='error'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<pre>";
            echo "Error Details:\n";
            echo "Message: " . $e->getMessage() . "\n";
            echo "File: " . $e->getFile() . "\n";
            echo "Line: " . $e->getLine() . "\n";
            echo "</pre>";
        }
    } else {
        echo "<p class='error'>❌ Database class not loaded - skipping test</p>";
    }
    ?>
</div>

<!-- API Endpoint Test -->
<div class="box">
    <h2>5. API Endpoint Test</h2>
    <p>Testing: <code>/api/auth.php?action=me</code></p>
    <?php
    $api_file = __DIR__ . '/../api/auth.php';
    if (file_exists($api_file)) {
        echo "<p class='success'>✅ API file exists</p>";

        // Test with internal request simulation
        $_GET['action'] = 'me';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        echo "<p>Executing API file...</p>";
        echo "<pre>";

        ob_start();
        try {
            // Capture output
            include $api_file;
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            echo "Trace: " . $e->getTraceAsString();
        }
        $output = ob_get_clean();

        echo htmlspecialchars($output);
        echo "</pre>";

    } else {
        echo "<p class='error'>❌ API file not found</p>";
    }
    ?>
</div>

<!-- Alpine.js Test -->
<div class="box">
    <h2>6. Alpine.js Test</h2>
    <p>Testing Alpine.js loading...</p>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('testApp', () => ({
                message: 'Alpine.js is working!',
                init() {
                    console.log('✅ Alpine.js initialized successfully');
                }
            }));
        });

        // Check if Alpine loads
        setTimeout(() => {
            const alpineLoaded = typeof Alpine !== 'undefined';
            const statusEl = document.getElementById('alpine-status');
            if (alpineLoaded) {
                statusEl.innerHTML = '<span class="success">✅ Alpine.js loaded successfully</span>';
                statusEl.innerHTML += '<div x-data="testApp"><p>Message: <strong x-text="message"></strong></p></div>';
            } else {
                statusEl.innerHTML = '<span class="error">❌ Alpine.js failed to load</span>';
            }
        }, 2000);
    </script>

    <div id="alpine-status">
        <span class="warning">⏳ Checking Alpine.js...</span>
    </div>
</div>

<!-- File Content Check -->
<div class="box">
    <h2>7. Critical File Content Check</h2>

    <h3>header.php (first 50 lines):</h3>
    <pre><?php
    $header_file = __DIR__ . '/../shared/components/header.php';
    if (file_exists($header_file)) {
        $lines = file($header_file);
        echo htmlspecialchars(implode('', array_slice($lines, 0, 50)));
    } else {
        echo "File not found!";
    }
    ?></pre>

    <h3>Database.php (checking for namespace):</h3>
    <pre><?php
    $db_file = __DIR__ . '/../api/core/Database.php';
    if (file_exists($db_file)) {
        $content = file_get_contents($db_file);
        $has_namespace = strpos($content, 'namespace') !== false;
        if ($has_namespace) {
            echo "<span class='error'>❌ PROBLEM: File still contains 'namespace' - not updated!</span>\n";
        } else {
            echo "<span class='success'>✅ Good: No namespace found</span>\n";
        }

        // Show first 30 lines
        $lines = explode("\n", $content);
        echo "\nFirst 30 lines:\n";
        echo htmlspecialchars(implode("\n", array_slice($lines, 0, 30)));
    } else {
        echo "File not found!";
    }
    ?></pre>
</div>

<!-- Recommendations -->
<div class="box">
    <h2>8. Recommendations</h2>
    <?php
    $issues = [];

    // Check if files are updated
    if (file_exists(__DIR__ . '/../api/core/Database.php')) {
        $content = file_get_contents(__DIR__ . '/../api/core/Database.php');
        if (strpos($content, 'namespace') !== false) {
            $issues[] = "⚠️ <strong>CRITICAL:</strong> Database.php still contains namespace - files NOT updated from GitHub!";
        }
    }

    if (!empty($issues)) {
        echo "<div style='background: #ffeaa7; padding: 15px; border-left: 4px solid #fdcb6e;'>";
        echo "<strong>Issues Found:</strong><br><br>";
        foreach ($issues as $issue) {
            echo $issue . "<br>";
        }
        echo "<br><strong>Solution:</strong><br>";
        echo "1. Pull latest files from GitHub: <code>git pull</code><br>";
        echo "2. Re-upload ALL files to Hostinger<br>";
        echo "3. Make sure to overwrite old files<br>";
        echo "</div>";
    } else {
        echo "<div style='background: #dfe6e9; padding: 15px; border-left: 4px solid #74b9ff;'>";
        echo "✅ All checks passed! If you still have errors, check browser console for JavaScript errors.";
        echo "</div>";
    }
    ?>
</div>

<div class="box">
    <p style="text-align: center; color: #666;">
        <strong>Debug completed at:</strong> <?= date('Y-m-d H:i:s') ?><br>
        <a href="/" style="color: #135bec;">← Back to Home</a>
    </p>
</div>

</body>
</html>
