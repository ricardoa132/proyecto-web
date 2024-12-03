<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'usuario') {
    header("Location: login.html");
    exit();
}

require 'conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

// Obtén todos los proyectos
$sql = "SELECT * FROM proyectos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se recuperaron proyectos
if (!$proyectos) {
    echo "<p>No hay proyectos disponibles en este momento.</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h1>
        <h2>Proyectos Disponibles</h2>
        <?php foreach ($proyectos as $proyecto): ?>
            <div class="proyecto">
                <h3><?php echo $proyecto['titulo']; ?></h3>
                <p><?php echo $proyecto['descripcion']; ?></p>
                <form action="solicitar.php" method="POST">
                    <input type="hidden" name="id_proyecto" value="<?php echo $proyecto['id']; ?>">
                    <button type="submit" class="boton">Solicitar Participación</button>
                </form>
            </div>
        <?php endforeach; ?>
        <a href="logout.php" class="boton">Cerrar Sesión</a>
    </div>
</body>
</html>
