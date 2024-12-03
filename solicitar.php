<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'usuario') {
    header("Location: login.html");
    exit();
}

require 'conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

$id_voluntario = $_SESSION['id'];
$id_proyecto = $_POST['id_proyecto'];

$sql = "INSERT INTO solicitudes (id_proyecto, id_voluntario) VALUES (:id_proyecto, :id_voluntario)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_proyecto', $id_proyecto);
$stmt->bindParam(':id_voluntario', $id_voluntario);

if ($stmt->execute()) {
    echo "Solicitud enviada exitosamente";
    header("Location: usuario.php");
} else {
    echo "Error al enviar la solicitud";
}
?>
