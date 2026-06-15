<?php
// TARGETED FIX - Delete specific cached view file
// DELETE THIS FILE AFTER USE!

$base = dirname(__FILE__);

// The problematic cached view file
$targetFile = $base . '/storage/framework/views/9c027c31f4b00e3fa177cb88cecb4acd.php';

$deleted = [];
$failed = [];

// Delete the specific problematic file
if (file_exists($targetFile)) {
    if (unlink($targetFile)) {
        $deleted[] = basename($targetFile);
    } else {
        $failed[] = $targetFile;
    }
}

// Delete ALL view cache files to be safe
$viewsDir = $base . '/storage/framework/views';
if (is_dir($viewsDir)) {
    $files = glob($viewsDir . '/*.php');
    foreach ($files as $file) {
        if (file_exists($file)) {
            if (unlink($file)) $deleted[] = basename($file);
            else $failed[] = $file;
        }
    }
}

// Delete bootstrap cache
$bootFiles = glob($base . '/bootstrap/cache/*.php');
foreach ($bootFiles as $file) {
    if (file_exists($file)) {
        if (unlink($file)) $deleted[] = basename($file);
        else $failed[] = $file;
    }
}

// Now patch the dashboard view to use URL instead of route()
$dashboardFile = $base . '/resources/views/admin/dashboard.blade.php';
if (file_exists($dashboardFile)) {
    $content = file_get_contents($dashboardFile);
    // Replace route('admin.settings.index') with direct URL
    $content = str_replace(
        "route('admin.settings.index')",
        "'/admin/settings'",
        $content
    );
    $content = str_replace(
        'route("admin.settings.index")',
        '"/admin/settings"',
        $content
    );
    file_put_contents($dashboardFile, $content);
    $deleted[] = 'dashboard.blade.php (patched)';
}

echo "<!DOCTYPE html><html><body style='font-family:sans-serif;padding:30px;max-width:600px'>";
echo "<h2 style='color:green'>✓ Fix Applied!</h2>";
if ($deleted) {
    echo "<p><strong>Deleted/Fixed (" . count($deleted) . "):</strong></p><ul>";
    foreach ($deleted as $f) echo "<li style='color:green'>✓ $f</li>";
    echo "</ul>";
}
if ($failed) {
    echo "<p><strong style='color:red'>Failed:</strong></p><ul>";
    foreach ($failed as $f) echo "<li style='color:red'>✗ $f</li>";
    echo "</ul>";
}
echo "<p style='color:red;font-weight:bold'>⚠ Ab is file ko server se DELETE karo!</p>";
echo "<p><a href='/admin/dashboard' style='background:#0A3A7A;color:white;padding:10px 20px;border-radius:8px;text-decoration:none'>→ Admin Dashboard Kholo</a></p>";
echo "</body></html>";
