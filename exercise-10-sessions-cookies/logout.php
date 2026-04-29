<?php
session_start();
setcookie("user", "", time() - 3600, "", "", false, true);
session_destroy();

header("Location: login.php");
exit();
?>
