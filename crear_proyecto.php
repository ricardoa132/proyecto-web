<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.html");
    exit();
}

require 'conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$ubicacion = $_POST['ubicacion'];
$id_admin = $_SESSION['id']; // ID del administrador actual

$sql = "INSERT INTO proyectos (titulo, descripcion, ubicacion, id_admin)
        VALUES (:titulo, :descripcion, :ubicacion, :id_admin)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':ubicacion', $ubicacion);
$stmt->bindParam(':id_admin', $id_admin);

if ($stmt->execute()) {
    header("Location: admin.php");
} else {
    echo "Error al crear el proyecto.";
}
?>
