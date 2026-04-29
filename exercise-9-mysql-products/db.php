<?php
$host = getenv("MYSQL_HOST") ?: "127.0.0.1";
$port = (int) (getenv("MYSQL_PORT") ?: 3307);
$user = getenv("MYSQL_USER") ?: "root";
$password = getenv("MYSQL_PASSWORD") ?: "";
$database = getenv("MYSQL_DATABASE") ?: "ecommerce";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $password, "", $port);
    $conn->set_charset("utf8mb4");

    $conn->query("CREATE DATABASE IF NOT EXISTS `$database`");
    $conn->select_db($database);

    $conn->query("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            category VARCHAR(100) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            rating DECIMAL(3, 1) NOT NULL,
            stock INT NOT NULL,
            brand VARCHAR(100) NOT NULL,
            inCart TINYINT(1) NOT NULL DEFAULT 0
        )
    ");
} catch (mysqli_sql_exception $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
?>
