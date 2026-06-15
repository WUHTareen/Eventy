<?php
// Advanced Cache Cleaner - DELETE AFTER USE!

$base = dirname(__FILE__);
$deleted = 0;
$errors = [];

$targets = [
    $base . '/bootstrap/cache/config.php',
    $base . '/bootstrap/cache/routes-v7.php',
    $base . '/bootstrap/cache/packages.php',
    $base . '/bootstrap/cache/services.php',
    $base . '/bootstrap/cache/events.php',
];

// Delete specific bootstrap cache files
foreach ($targets as $file) {
    if (file_exists($file)) {
        if (unlink($file)) $deleted++;
        else $errors[] = $file;
    }
}

// Delete ALL compiled view files
$viewsDir = $base . '/storage/framework/views';
if (is_dir($viewsDir)) {
    foreach (glob($viewsDir . '/*.php') as $file) {
        if (unlink($file)) $deleted++;
        else $errors[] = $file;
    }
}

// Delete cache data
$cacheDir = $base . '/storage/framework/cache/data';
if (is_dir($cacheDir)) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cacheDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if ($file->isFile()) {
            if (unlink($file->getRealPath())) $deleted++;
        }
    }
}

echo "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:30px'>";
echo "<h2 style='color:green'>✓ Cache Fully Cleared!</h2>";
echo "<p><strong>$deleted</strong> files deleted.</p>";

if ($errors) {
    echo "<p style='color:red'>Could not delete:</p><ul>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul>";
}

echo "<p style='color:red;font-weight:bold'>⚠ Ab is file ko server se DELETE karo!</p>";
echo "<p><a href='/admin/dashboard'>→ Admin Dashboard</a></p>";
echo "</body></html>";