<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple Test</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current directory: " . __DIR__ . "</p>";
echo "<p>Document root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

echo "<h2>Files in current directory:</h2>";
echo "<pre>";
print_r(scandir(__DIR__));
echo "</pre>";

echo "<h2>Check if api folder exists:</h2>";
if (file_exists(__DIR__ . '/api')) {
    echo "✅ /api folder EXISTS in current directory<br>";
    echo "Contents:<br><pre>";
    print_r(scandir(__DIR__ . '/api'));
    echo "</pre>";
} else {
    echo "❌ /api folder DOES NOT EXIST in current directory<br>";
}

if (file_exists(__DIR__ . '/../api')) {
    echo "✅ /../api folder EXISTS (parent directory)<br>";
    echo "Contents:<br><pre>";
    print_r(scandir(__DIR__ . '/../api'));
    echo "</pre>";
} else {
    echo "❌ /../api folder DOES NOT EXIST (parent directory)<br>";
}

echo "<h2>Check if shared folder exists:</h2>";
if (file_exists(__DIR__ . '/shared')) {
    echo "✅ /shared folder EXISTS<br>";
} else {
    echo "❌ /shared folder DOES NOT EXIST<br>";
}

if (file_exists(__DIR__ . '/../shared')) {
    echo "✅ /../shared folder EXISTS (parent directory)<br>";
} else {
    echo "❌ /../shared folder DOES NOT EXIST (parent directory)<br>";
}

echo "<h2>Try to load config:</h2>";
try {
    if (file_exists(__DIR__ . '/api/config/database.php')) {
        $config = require __DIR__ . '/api/config/database.php';
        echo "✅ Loaded database config from ./api/config/<br>";
        echo "<pre>" . print_r($config, true) . "</pre>";
    } else if (file_exists(__DIR__ . '/../api/config/database.php')) {
        $config = require __DIR__ . '/../api/config/database.php';
        echo "✅ Loaded database config from ../api/config/<br>";
        echo "<pre>" . print_r($config, true) . "</pre>";
    } else {
        echo "❌ Cannot find database.php<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
