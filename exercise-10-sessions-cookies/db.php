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

    $products = [
        ["Wireless Mouse", "Electronics", 499.00, 4.3, 20, "Logitech"],
        ["Notebook", "Stationery", 80.00, 4.1, 50, "Classmate"],
        ["Water Bottle", "Accessories", 299.00, 4.5, 15, "Milton"],
        ["Desk Lamp", "Home", 899.00, 4.6, 12, "Wipro"],
        ["USB-C Cable", "Electronics", 249.00, 4.4, 35, "Portronics"],
        ["Canvas Tote", "Accessories", 349.00, 4.2, 18, "DailyCarry"],
        ["Sticky Notes", "Stationery", 120.00, 4.0, 60, "3M"],
        ["Coffee Mug", "Home", 199.00, 4.7, 25, "ClayCo"],
        ["Bluetooth Speaker", "Electronics", 1299.00, 4.5, 10, "Boat"],
    ];

    $exists = $conn->prepare("SELECT id FROM products WHERE name = ? LIMIT 1");
    $insert = $conn->prepare("
        INSERT INTO products (name, category, price, rating, stock, brand, inCart)
        VALUES (?, ?, ?, ?, ?, ?, 0)
    ");

    foreach ($products as $product) {
        [$name, $category, $price, $rating, $stock, $brand] = $product;

        $exists->bind_param("s", $name);
        $exists->execute();

        if ($exists->get_result()->num_rows === 0) {
            $insert->bind_param("ssddis", $name, $category, $price, $rating, $stock, $brand);
            $insert->execute();
        }
    }
} catch (mysqli_sql_exception $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, "UTF-8"));
}
?>
