<?php
$name = $email = $message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["message"])) {
        $error = "All fields are required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);
        $message = htmlspecialchars($_POST["message"]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
<h2>Contact Form</h2>

<form method="POST">
<input type="text" name="name" placeholder="Name">
<input type="email" name="email" placeholder="Email">
<input type="text" name="message" placeholder="Message">

<button type="submit">Send</button>
</form>

<?php if ($error): ?>
<p class="error"><?php echo $error; ?></p>
<?php elseif ($_POST): ?>
<p class="success">Message submitted successfully</p>
<?php endif; ?>

</div>

</body>
</html>