<?php
session_start();
session_destroy();
header("Location: main.php"); // Redirige a la página principal
exit();
?>
