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

function productById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function cartItems($conn, $cart) {
    $items = [];

    foreach ($cart as $cartKey => $quantity) {
        $id = (int) substr((string) $cartKey, 1);
        $quantity = (int) $quantity;
        $product = productById($conn, $id);

        if ($product && $quantity > 0) {
            $items[] = [
                "id" => $id,
                "name" => $product["name"],
                "price" => (float) $product["price"],
                "quantity" => $quantity,
            ];
        }
    }

    return $items;
}

function buyNowItems($conn, $id) {
    $product = productById($conn, $id);

    if (!$product) {
        return [];
    }

    return [[
        "id" => $id,
        "name" => $product["name"],
        "price" => (float) $product["price"],
        "quantity" => 1,
    ]];
}

function orderTotal($items) {
    $total = 0;

    foreach ($items as $item) {
        $total += $item["price"] * $item["quantity"];
    }

    return $total;
}

$errors = [];
$orderPlaced = false;
$source = $_POST["source"] ?? (isset($_GET["buy"]) ? "buy" : "cart");
$buyId = (int) ($_POST["buy_id"] ?? $_GET["buy"] ?? 0);
$items = $source === "buy" ? buyNowItems($conn, $buyId) : cartItems($conn, $_SESSION["cart"]);
$total = orderTotal($items);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $city = trim($_POST["city"] ?? "");
    $pincode = trim($_POST["pincode"] ?? "");
    $payment = trim($_POST["payment"] ?? "");

    if ($name === "") {
        $errors[] = "Name is required.";
    }

    if ($phone === "") {
        $errors[] = "Phone number is required.";
    }

    if ($address === "" || $city === "" || $pincode === "") {
        $errors[] = "Complete delivery address is required.";
    }

    if ($payment === "") {
        $errors[] = "Choose a payment method.";
    }

    if (count($items) === 0) {
        $errors[] = "Your checkout has no products.";
    }

    if (count($errors) === 0) {
        $order = [
            "id" => "ORD" . date("YmdHis"),
            "items" => $items,
            "total" => $total,
            "customer" => $name,
            "phone" => $phone,
            "address" => $address,
            "city" => $city,
            "pincode" => $pincode,
            "payment" => $payment,
            "created_at" => date("d M Y, h:i A"),
        ];

        $_SESSION["last_order"] = $order;
        $_SESSION["orders"][] = $order;

        if ($source === "cart") {
            $_SESSION["cart"] = [];
        }

        $orderPlaced = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="shell">
<header class="topbar">
    <div class="brand">
        <div class="logo">MS</div>
        <div>
            <h1><?php echo $orderPlaced ? "Order Placed" : "Checkout"; ?></h1>
            <p><?php echo $orderPlaced ? "Your order is confirmed." : "Review items and add delivery details."; ?></p>
        </div>
    </div>
    <nav class="actions">
        <a class="btn" href="index.php">Shop</a>
        <a class="btn" href="cart.php">Cart</a>
        <a class="btn danger" href="logout.php">Logout</a>
    </nav>
</header>

<?php if ($orderPlaced): ?>
<section class="checkout-layout">
    <div class="checkout-card success-card">
        <span class="pill">Confirmed</span>
        <h2>Thanks, <?php echo e($_SESSION["last_order"]["customer"]); ?>.</h2>
        <p class="meta">Order <?php echo e($_SESSION["last_order"]["id"]); ?> placed on <?php echo e($_SESSION["last_order"]["created_at"]); ?>.</p>
        <p class="meta">Deliver to <?php echo e($_SESSION["last_order"]["address"]); ?>, <?php echo e($_SESSION["last_order"]["city"]); ?> - <?php echo e($_SESSION["last_order"]["pincode"]); ?>.</p>
        <div class="actions">
            <a class="btn primary" href="index.php">Continue Shopping</a>
            <a class="btn" href="cart.php">View Cart</a>
        </div>
    </div>

    <aside class="checkout-card">
        <h2>Receipt</h2>
        <?php foreach ($_SESSION["last_order"]["items"] as $item): ?>
        <div class="line-item">
            <span><?php echo e($item["name"]); ?> x <?php echo e($item["quantity"]); ?></span>
            <strong>Rs <?php echo e(number_format($item["price"] * $item["quantity"], 2)); ?></strong>
        </div>
        <?php endforeach; ?>
        <div class="summary compact">
            <span>Total Paid</span>
            <strong>Rs <?php echo e(number_format($_SESSION["last_order"]["total"], 2)); ?></strong>
        </div>
    </aside>
</section>
<?php elseif (count($items) === 0): ?>
<div class="checkout-card">
    <h2>No items to checkout</h2>
    <p class="empty">Add products to your cart or use Buy Now from a product card.</p>
    <a class="btn primary" href="index.php">Browse Products</a>
</div>
<?php else: ?>
<section class="checkout-layout">
    <form class="checkout-card form" method="POST">
        <input type="hidden" name="source" value="<?php echo e($source); ?>">
        <input type="hidden" name="buy_id" value="<?php echo e($buyId); ?>">

        <h2>Delivery Address</h2>

        <?php if (count($errors) > 0): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
            <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <label>
            Full Name
            <input name="name" value="<?php echo e($_POST["name"] ?? ""); ?>" placeholder="Your name" required>
        </label>

        <label>
            Phone
            <input name="phone" value="<?php echo e($_POST["phone"] ?? ""); ?>" placeholder="10-digit phone number" required>
        </label>

        <label>
            Address
            <textarea name="address" placeholder="House number, street, area" required><?php echo e($_POST["address"] ?? ""); ?></textarea>
        </label>

        <div class="two-col">
            <label>
                City
                <input name="city" value="<?php echo e($_POST["city"] ?? ""); ?>" placeholder="City" required>
            </label>
            <label>
                Pincode
                <input name="pincode" value="<?php echo e($_POST["pincode"] ?? ""); ?>" placeholder="Pincode" required>
            </label>
        </div>

        <label>
            Payment Method
            <select name="payment" required>
                <option value="">Choose payment</option>
                <option value="Cash on Delivery" <?php echo ($_POST["payment"] ?? "") === "Cash on Delivery" ? "selected" : ""; ?>>Cash on Delivery</option>
                <option value="UPI" <?php echo ($_POST["payment"] ?? "") === "UPI" ? "selected" : ""; ?>>UPI</option>
                <option value="Card" <?php echo ($_POST["payment"] ?? "") === "Card" ? "selected" : ""; ?>>Card</option>
            </select>
        </label>

        <button class="btn primary full" type="submit">Place Order</button>
    </form>

    <aside class="checkout-card">
        <h2>Order Summary</h2>
        <p class="meta"><?php echo e(array_sum(array_column($items, "quantity"))); ?> item<?php echo array_sum(array_column($items, "quantity")) === 1 ? "" : "s"; ?></p>

        <?php foreach ($items as $item): ?>
        <div class="line-item">
            <span><?php echo e($item["name"]); ?> x <?php echo e($item["quantity"]); ?></span>
            <strong>Rs <?php echo e(number_format($item["price"] * $item["quantity"], 2)); ?></strong>
        </div>
        <?php endforeach; ?>

        <div class="line-item">
            <span>Delivery</span>
            <strong>Free</strong>
        </div>

        <div class="summary compact">
            <span>Total</span>
            <strong>Rs <?php echo e(number_format($total, 2)); ?></strong>
        </div>
    </aside>
</section>
<?php endif; ?>
</main>

</body>
</html>
