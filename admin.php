<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.html");
    exit();
}

require 'conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

// Obtén todas las solicitudes
$sql = "SELECT s.id, p.titulo, u.nombre, s.estado
        FROM solicitudes s
        JOIN proyectos p ON s.id_proyecto = p.id
        JOIN usuarios u ON s.id_voluntario = u.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, Administrador <?php echo $_SESSION['nombre']; ?>!</h1>

        <!-- Crear proyectos -->
        <h2>Crear Nuevo Proyecto</h2>
        <form action="crear_proyecto.php" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required>
            <button type="submit" class="boton">Crear Proyecto</button>
        </form>

        <!-- Gestionar solicitudes -->
        <h2>Solicitudes de Participación</h2>
        <?php foreach ($solicitudes as $solicitud): ?>
            <div class="solicitud">
                <p><strong>Proyecto:</strong> <?php echo $solicitud['titulo']; ?></p>
                <p><strong>Voluntario:</strong> <?php echo $solicitud['nombre']; ?></p>
                <p><strong>Estado:</strong> <?php echo ucfirst($solicitud['estado']); ?></p>
                <?php if ($solicitud['estado'] == 'pendiente'): ?>
                    <form action="gestionar_solicitud.php" method="POST">
                        <input type="hidden" name="id_solicitud" value="<?php echo $solicitud['id']; ?>">
                        <button type="submit" name="accion" value="aceptar" class="boton">Aceptar</button>
                        <button type="submit" name="accion" value="rechazar" class="boton">Rechazar</button>
                    </form>
                <?php elseif ($solicitud['estado'] == 'rechazado'): ?>
                    <form action="eliminar_solicitud.php" method="POST">
                        <input type="hidden" name="id_solicitud" value="<?php echo $solicitud['id']; ?>">
                        <button type="submit" class="boton boton-eliminar">Eliminar</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <a href="logout.php" class="boton">Cerrar Sesión</a>
    </div>
</body>
</html>
