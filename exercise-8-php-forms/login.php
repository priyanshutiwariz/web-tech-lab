<?php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif ($email == "admin@gmail.com" && $password == "123456") {
        header("Location: success.php");
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
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
<h2>Login</h2>

<form method="POST">
<input type="email" name="email" placeholder="Email">
<input type="password" name="password" placeholder="Password">

<button type="submit">Login</button>
</form>

<p class="error"><?php echo $error; ?></p>

</div>

</body>
</html>