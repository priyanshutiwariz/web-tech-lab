<?php
session_start();

$error = "";

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // simple demo login
    if ($email == "admin@gmail.com" && $password == "123456") {
        $_SESSION["user"] = $email;

        // cookie (7 days)
        setcookie("user", $email, time() + (7 * 24 * 60 * 60), "", "", false, true);

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="panel">
<div class="brand">
    <div class="logo">MS</div>
    <div>
        <h1>Mini Shop</h1>
        <p>Sign in to start your cart.</p>
    </div>
</div>

<form class="form" method="POST">
<input type="email" name="email" placeholder="Email" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button class="btn primary" type="submit">Login</button>
</form>

<p class="error"><?php echo e($error); ?></p>
</main>

</body>
</html>
