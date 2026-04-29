<?php
include "db.php";

$result = $conn->query("SELECT * FROM products");

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Products</title>
<link rel="stylesheet" href="styles.css">
</head>

<body>

<main class="shell">
<header class="topbar">
    <div class="brand">
        <div class="logo">PM</div>
        <div>
            <h1>Product Manager</h1>
            <p>Manage your product inventory</p>
        </div>
    </div>
    <nav class="actions">
        <a class="btn primary" href="add_product.php">Add Product</a>
    </nav>
</header>

<section>
    <table class="products-table">
    <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Rating</th>
    <th>Stock</th>
    <th>Brand</th>
    <th>In Cart</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>

    <tr>
    <td><?php echo e($row['id']); ?></td>
    <td><?php echo e($row['name']); ?></td>
    <td><span class="pill"><?php echo e($row['category']); ?></span></td>
    <td><span class="price">Rs <?php echo e(number_format((float) $row['price'], 2)); ?></span></td>
    <td><span class="rating">★ <?php echo e($row['rating']); ?>/5</span></td>
    <td><?php echo e($row['stock']); ?> in stock</td>
    <td><?php echo e($row['brand']); ?></td>
    <td><span class="in-cart <?php echo $row['inCart'] ? 'yes' : 'no'; ?>"><?php echo $row['inCart'] ? "Yes" : "No"; ?></span></td>
    </tr>

    <?php endwhile; ?>

    </table>
</section>
</main>

</body>
</html>
