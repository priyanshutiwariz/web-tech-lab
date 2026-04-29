<?php
session_start();
include "db.php";

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

// protect page
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// initialize cart
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

foreach ($_SESSION["cart"] as $key => $value) {
    if (is_int($key)) {
        unset($_SESSION["cart"][$key]);
        $cartKey = "p" . (int) $value;
        $_SESSION["cart"][$cartKey] = ($_SESSION["cart"][$cartKey] ?? 0) + 1;
    }
}

// add to cart
if (isset($_GET["add"])) {
    $id = (int) $_GET["add"];
    $cartKey = "p" . $id;
    $_SESSION["cart"][$cartKey] = ($_SESSION["cart"][$cartKey] ?? 0) + 1;
    header("Location: index.php");
    exit();
}

$cartCount = array_sum($_SESSION["cart"]);
$result = $conn->query("SELECT * FROM products ORDER BY category, name");
?>

<!DOCTYPE html>
<html>
<head>
<title>Mini Shop</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="shell">
<header class="topbar">
    <div class="brand">
        <div class="logo">MS</div>
        <div>
            <h1>Mini Shop</h1>
            <p>Welcome <?php echo e($_SESSION["user"]); ?></p>
        </div>
    </div>
    <nav class="actions">
        <a class="btn" href="cart.php">Cart (<?php echo e($cartCount); ?>)</a>
        <a class="btn danger" href="logout.php">Logout</a>
    </nav>
</header>

<?php if (isset($_COOKIE["user"])): ?>
<p class="notice">Welcome back, <?php echo e($_COOKIE["user"]); ?>.</p>
<?php endif; ?>

<section class="grid">

<?php while($row = $result->fetch_assoc()): ?>
<article class="card">
    <div>
        <span class="pill"><?php echo e($row["category"]); ?></span>
        <h2 class="product-name"><?php echo e($row["name"]); ?></h2>
        <p class="meta"><?php echo e($row["brand"]); ?> · <?php echo e($row["stock"]); ?> in stock</p>
        <p class="rating">Rating <?php echo e($row["rating"]); ?>/5</p>
    </div>
    <div>
        <p class="price">Rs <?php echo e(number_format((float) $row["price"], 2)); ?></p>
        <div class="product-actions">
            <a class="btn primary" href="index.php?add=<?php echo e($row["id"]); ?>">Add to Cart</a>
            <a class="btn accent" href="checkout.php?buy=<?php echo e($row["id"]); ?>">Buy Now</a>
        </div>
    </div>
</article>
<?php endwhile; ?>

</section>
</main>

</body>
</html>
