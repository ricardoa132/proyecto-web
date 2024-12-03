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
$accion = $_POST['accion'];

$estado = ($accion == 'aceptar') ? 'aceptado' : 'rechazado';

$sql = "UPDATE solicitudes SET estado = :estado WHERE id = :id_solicitud";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':estado', $estado);
$stmt->bindParam(':id_solicitud', $id_solicitud);

if ($stmt->execute()) {
    header("Location: admin.php");
} else {
    echo "Error al gestionar la solicitud";
}
?>
