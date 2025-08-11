<?php

echo "🔍 E-Learning System Setup Validation\n";
echo str_repeat("=", 50) . "\n\n";

$checks = [];
$passed = 0;
$failed = 0;

// Check PHP version
echo "📋 Checking PHP version...\n";
if (version_compare(PHP_VERSION, '8.1.0', '>=')) {
    echo "✅ PHP version: " . PHP_VERSION . " (OK)\n";
    $passed++;
} else {
    echo "❌ PHP version: " . PHP_VERSION . " (Requires PHP 8.1+)\n";
    $failed++;
}

// Check required PHP extensions
$required_extensions = ['pdo', 'pdo_mysql', 'mysqli', 'gd', 'intl', 'opcache'];
echo "\n📋 Checking PHP extensions...\n";
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ Extension {$ext}: Available\n";
        $passed++;
    } else {
        echo "❌ Extension {$ext}: Missing\n";
        $failed++;
    }
}

// Check directories
$required_dirs = [
    'public',
    'src',
    'config',
    'uploads',
    'logs',
    'vendor'
];

echo "\n📋 Checking directory structure...\n";
foreach ($required_dirs as $dir) {
    if (is_dir(__DIR__ . '/' . $dir)) {
        echo "✅ Directory /{$dir}: Exists\n";
        $passed++;
    } else {
        echo "❌ Directory /{$dir}: Missing\n";
        $failed++;
    }
}

// Check critical files
$required_files = [
    'composer.json',
    '.env.example',
    'Dockerfile',
    'docker-compose.yml',
    'src/bootstrap.php',
    'public/index.php'
];

echo "\n📋 Checking critical files...\n";
foreach ($required_files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ File {$file}: Exists\n";
        $passed++;
    } else {
        echo "❌ File {$file}: Missing\n";
        $failed++;
    }
}

// Check .env file
echo "\n📋 Checking environment configuration...\n";
if (file_exists(__DIR__ . '/.env')) {
    echo "✅ Environment file: Exists\n";
    $passed++;
} else {
    echo "⚠️  Environment file: Missing (copy .env.example to .env)\n";
    $failed++;
}

// Check write permissions
$writable_dirs = ['uploads', 'logs'];
echo "\n📋 Checking write permissions...\n";
foreach ($writable_dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path) && is_writable($path)) {
        echo "✅ Directory /{$dir}: Writable\n";
        $passed++;
    } else {
        echo "❌ Directory /{$dir}: Not writable\n";
        $failed++;
    }
}

// Security checks
echo "\n📋 Checking security configuration...\n";

// Check if sensitive files are protected
$sensitive_files = ['.env', 'composer.json', 'config/database.php'];
foreach ($sensitive_files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ Sensitive file {$file}: Protected by .htaccess\n";
        $passed++;
    } else {
        echo "❌ Sensitive file {$file}: Missing\n";
        $failed++;
    }
}

// Summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 VALIDATION SUMMARY\n";
echo str_repeat("=", 50) . "\n";
echo "✅ Passed: {$passed}\n";
echo "❌ Failed: {$failed}\n";
echo "📈 Success Rate: " . round(($passed / ($passed + $failed)) * 100, 1) . "%\n\n";

if ($failed === 0) {
    echo "🎉 All checks passed! Your system is ready for deployment.\n";
    echo "\nNext steps:\n";
    echo "1. Copy .env.example to .env and configure your settings\n";
    echo "2. Run: docker-compose up -d\n";
    echo "3. Visit: http://localhost:8080\n";
} else {
    echo "⚠️  Some checks failed. Please fix the issues above before deployment.\n";
}

echo "\n";
?>