<?php
session_start();
include "db.php";

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

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

if (isset($_GET["increase"])) {
    $id = (int) $_GET["increase"];
    $cartKey = "p" . $id;
    $_SESSION["cart"][$cartKey] = ($_SESSION["cart"][$cartKey] ?? 0) + 1;
    header("Location: cart.php");
    exit();
}

if (isset($_GET["decrease"])) {
    $id = (int) $_GET["decrease"];
    $cartKey = "p" . $id;

    if (isset($_SESSION["cart"][$cartKey])) {
        $_SESSION["cart"][$cartKey]--;

        if ($_SESSION["cart"][$cartKey] <= 0) {
            unset($_SESSION["cart"][$cartKey]);
        }
    }

    header("Location: cart.php");
    exit();
}

if (isset($_GET["remove"])) {
    unset($_SESSION["cart"]["p" . (int) $_GET["remove"]]);
    header("Location: cart.php");
    exit();
}

if (isset($_GET["clear"])) {
    $_SESSION["cart"] = [];
    header("Location: cart.php");
    exit();
}

$cart = $_SESSION["cart"] ?? [];
$cartCount = array_sum($cart);
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="shell">
<header class="topbar">
    <div class="brand">
        <div class="logo">MS</div>
        <div>
            <h1>Your Cart</h1>
            <p><?php echo e($cartCount); ?> item<?php echo $cartCount === 1 ? "" : "s"; ?> selected</p>
        </div>
    </div>
    <nav class="actions">
        <a class="btn" href="index.php">Back to Shop</a>
        <?php if ($cartCount > 0): ?>
        <a class="btn primary" href="checkout.php">Checkout</a>
        <a class="btn danger" href="cart.php?clear=1">Clear Cart</a>
        <?php endif; ?>
    </nav>
</header>

<?php if ($cartCount === 0): ?>
<p class="empty">Your cart is empty. Add a few products from the shop.</p>
<?php else: ?>
<table class="cart-table">
<tr>
<th>Name</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
<th>Action</th>
</tr>

<?php
$total = 0;

foreach ($cart as $cartKey => $quantity) {
    $id = (int) substr((string) $cartKey, 1);
    $quantity = (int) $quantity;
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        continue;
    }

    $subtotal = (float) $row["price"] * $quantity;

    echo "<tr>
            <td>" . e($row["name"]) . "</td>
            <td>Rs " . e(number_format((float) $row["price"], 2)) . "</td>
            <td>
                <div class=\"qty\">
                    <a class=\"btn\" href=\"cart.php?decrease=" . e($id) . "\">-</a>
                    <strong>" . e($quantity) . "</strong>
                    <a class=\"btn\" href=\"cart.php?increase=" . e($id) . "\">+</a>
                </div>
            </td>
            <td>Rs " . e(number_format($subtotal, 2)) . "</td>
            <td><a class=\"btn danger\" href=\"cart.php?remove=" . e($id) . "\">Remove</a></td>
          </tr>";

    $total += $subtotal;
}
?>

</table>

<section class="summary">
    <span>Total</span>
    <strong>Rs <?php echo number_format($total, 2); ?></strong>
</section>
<?php endif; ?>
</main>

</body>
</html>
