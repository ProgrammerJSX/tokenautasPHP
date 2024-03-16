<?php
session_start();

// Si el usuario no está logueado, redirigirlo al login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// El HTML más abajo se mostrará si el usuario está logueado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido al Dashboard</h1>
    <?php echo "<p>Hola, " . htmlspecialchars($_SESSION['username']) . "! Has iniciado sesión con éxito.</p>"; ?>
    <p><a href="demostracion.php">Ver Demostración</a></p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
