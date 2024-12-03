<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.html");
    exit();
}

require 'conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

$id_solicitud = $_POST['id_solicitud'];

$sql = "DELETE FROM solicitudes WHERE id = :id_solicitud AND estado = 'rechazado'";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_solicitud', $id_solicitud);

if ($stmt->execute()) {
    header("Location: admin.php");
} else {
    echo "Error al eliminar la solicitud.";
}
?>
