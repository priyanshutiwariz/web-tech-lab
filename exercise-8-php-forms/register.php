<?php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {
        $success = "Registration successful";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
<h2>Register</h2>

<form method="POST">
<input type="text" name="name" placeholder="Name">
<input type="email" name="email" placeholder="Email">
<input type="password" name="password" placeholder="Password">

<button type="submit">Register</button>
</form>

<p class="error"><?php echo $error; ?></p>
<p class="success"><?php echo $success; ?></p>

<a href="login.php">Go to Login</a>

</div>

</body>
</html>