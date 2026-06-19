<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "=== PHP Version: " . phpversion() . " ===<br><br>";

// Test 1: Kiểm tra helper.php
echo "1. Testing helper.php...<br>";
try {
    require __DIR__ . '/../app/Core/helper.php';
    echo "✅ helper.php loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 2: Kiểm tra Database.php
echo "<br>2. Testing Database.php...<br>";
try {
    require __DIR__ . '/../app/Core/Database.php';
    echo "✅ Database.php loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 3: Kiểm tra kết nối database
echo "<br>3. Testing Database connection...<br>";
try {
    $config = require __DIR__ . '/../config/database.php';
    echo "Config loaded: host={$config['host']}, db={$config['database']}<br>";
    
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
        $config['username'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Database connected successfully!<br>";
    
    // Kiểm tra bảng books
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    echo "Tables in database: ";
    foreach ($tables as $table) {
        echo $table['Tables_in_bookstore_db'] . ", ";
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test 4: Kiểm tra BookRepository
echo "<br>4. Testing BookRepository...<br>";
try {
    require __DIR__ . '/../app/Repositories/BookRepository.php';
    echo "✅ BookRepository.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 5: Kiểm tra BookController
echo "<br>5. Testing BookController...<br>";
try {
    require __DIR__ . '/../app/Controllers/BookController.php';
    echo "✅ BookController.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br>=== Test Complete ===";