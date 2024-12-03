<?php
try {
    $conn = new PDO("mysql:host=IP_DE_LA_BD;dbname=voluntariado", "webuser", "contraseña_segura");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
