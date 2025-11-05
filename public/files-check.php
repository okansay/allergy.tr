<?php
// File structure diagnostic
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Structure Check - Allergy.tr</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4">📁 File Structure Diagnostic</h1>

        <div class="space-y-4">
            <div class="border rounded p-4">
                <h2 class="font-bold text-lg mb-2">Current Directory Files:</h2>
                <pre class="bg-gray-50 p-3 rounded text-sm overflow-x-auto"><?php
                $files = scandir(__DIR__);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $path = __DIR__ . '/' . $file;
                        $type = is_dir($path) ? '[DIR]' : '[FILE]';
                        $size = is_file($path) ? filesize($path) . ' bytes' : '';
                        echo "$type $file $size\n";
                    }
                }
                ?></pre>
            </div>

            <div class="border rounded p-4">
                <h2 class="font-bold text-lg mb-2">Document Root:</h2>
                <pre class="bg-gray-50 p-3 rounded text-sm"><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'N/A'; ?></pre>
            </div>

            <div class="border rounded p-4">
                <h2 class="font-bold text-lg mb-2">Current Script Path:</h2>
                <pre class="bg-gray-50 p-3 rounded text-sm"><?php echo __FILE__; ?></pre>
            </div>

            <div class="border rounded p-4">
                <h2 class="font-bold text-lg mb-2">Key Files Check:</h2>
                <ul class="space-y-2">
                    <?php
                    $keyFiles = [
                        'index.php',
                        'login.php',
                        'register.php',
                        'dashboard.php',
                        'debug.php',
                        'test.php',
                        '.htaccess'
                    ];

                    foreach ($keyFiles as $file) {
                        $exists = file_exists(__DIR__ . '/' . $file);
                        $icon = $exists ? '✅' : '❌';
                        $status = $exists ? 'EXISTS' : 'MISSING';
                        $class = $exists ? 'text-green-600' : 'text-red-600';
                        echo "<li class='$class'>$icon <strong>$file</strong>: $status</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="border rounded p-4">
                <h2 class="font-bold text-lg mb-2">Test Links:</h2>
                <div class="flex flex-wrap gap-2">
                    <a href="/" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Index</a>
                    <a href="/login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
                    <a href="/register.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Register</a>
                    <a href="/debug.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Debug</a>
                    <a href="/test.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Test</a>
                </div>
            </div>

            <div class="text-xs text-gray-500 mt-4">
                Generated: <?php echo date('Y-m-d H:i:s'); ?>
            </div>
        </div>
    </div>
</body>
</html>
