<?php
// config/db.php

/**
 * Hàm tự đọc file .env (hoặc pass.env) và nạp vào $_ENV
 */
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Bỏ qua dòng chú thích
        if (strpos($line, '#') === 0 || strpos($line, '//') === 0) {
            continue;
        }

        // Tách chuỗi theo dấu =
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name  = trim($name);
            $value = trim($value);
            $value = trim($value, '"\'');

            $_ENV[$name]    = $value;
            $_SERVER[$name] = $value;
            putenv("{$name}={$value}");
        }
    }
}

// 1. Tải file cấu hình (.env hoặc pass.env)
// Nếu bạn đặt tên file là pass.env thì sửa '.env' bên dưới thành 'pass.env'
loadEnv(__DIR__ . '/.env');

// 2. Bật báo lỗi strict cho MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 3. Lấy biến môi trường
$host     = $_ENV['DB_HOST'] ?? 'localhost';
$dbname   = $_ENV['DB_NAME'] ?? 'thtravel_db';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

// 4. Khởi tạo kết nối CSDL
try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Lỗi kết nối CSDL chi tiết: " . $e->getMessage());
}
?>