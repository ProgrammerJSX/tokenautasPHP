<?php
session_start();

// Verifica si el usuario ya está logueado
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Si está logueado, redirige al dashboard
    header("Location: Vistas/dashboard.php");
    exit;
}
// Nota: No hay redirección al login aquí, permitiendo que el HTML se muestre a usuarios no autenticados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Nuestra Aplicación</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Asegúrate de ajustar la ruta a tu archivo CSS -->
</head>
<body>
    <header>
        <h1>Bienvenido a Nuestra Aplicación</h1>
    </header>
    <main>
        <p>Esta es una aplicación diseñada para facilitar la gestión de tus tareas diarias.</p>
        <a href="Vistas/login.php">Iniciar sesión</a> | <a href="Vistas/registro.php">Registrarse</a>
    </main>
    <footer>
        <p>&copy; 2024 Nuestra Aplicación. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
