<?php
include "db.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $category = trim($_POST["category"]);
    $price = (float) $_POST["price"];
    $rating = (float) $_POST["rating"];
    $stock = (int) $_POST["stock"];
    $brand = trim($_POST["brand"]);
    $inCart = isset($_POST["inCart"]) ? 1 : 0;

    $stmt = $conn->prepare("
        INSERT INTO products (name, category, price, rating, stock, brand, inCart)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssddisi", $name, $category, $price, $rating, $stock, $brand, $inCart);

    if ($stmt->execute()) {
        $message = "Product added successfully!";
        $messageType = "success";
    } else {
        $message = "Error: " . $conn->error;
        $messageType = "error";
    }
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<link rel="stylesheet" href="styles.css">
</head>

<body>

<main class="panel">
<div class="brand">
    <div class="logo">PM</div>
    <div>
        <h1>Add Product</h1>
        <p>Enter product details below</p>
    </div>
</div>

<?php if ($message): ?>
<div class="<?php echo $messageType === 'success' ? 'success' : 'error-box'; ?>">
    <p><?php echo e($message); ?></p>
    <?php if ($messageType === 'success'): ?>
    <p><a href="index.php" class="btn accent">View Products</a></p>
    <?php endif; ?>
</div>
<?php endif; ?>

<form class="form" method="POST">
<label>
    Product Name
    <input name="name" placeholder="Enter product name" value="<?php echo e($_POST["name"] ?? ""); ?>" required>
</label>

<label>
    Category
    <input name="category" placeholder="Enter category" value="<?php echo e($_POST["category"] ?? ""); ?>" required>
</label>

<label>
    Price
    <input type="number" step="0.01" name="price" placeholder="0.00" value="<?php echo e($_POST["price"] ?? ""); ?>" required>
</label>

<label>
    Rating
    <input type="number" step="0.1" min="0" max="5" name="rating" placeholder="0.0 - 5.0" value="<?php echo e($_POST["rating"] ?? ""); ?>" required>
</label>

<label>
    Stock Quantity
    <input type="number" min="0" name="stock" placeholder="0" value="<?php echo e($_POST["stock"] ?? ""); ?>" required>
</label>

<label>
    Brand
    <input name="brand" placeholder="Enter brand name" value="<?php echo e($_POST["brand"] ?? ""); ?>" required>
</label>

<label class="checkbox-label">
    <input type="checkbox" name="inCart" <?php echo isset($_POST["inCart"]) ? "checked" : ""; ?>>
    Add to cart
</label>

<button class="btn primary full" type="submit">Add Product</button>
</form>

<div style="margin-top: 24px; text-align: center;">
    <a href="index.php" class="btn">← Back to Products</a>
</div>
</main>

</body>
</html>
