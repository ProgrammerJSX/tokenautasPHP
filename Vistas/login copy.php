<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['mensaje'])) {
    echo "<p>" . $_SESSION['mensaje'] . "</p>";
    unset($_SESSION['mensaje']);
}
?>
<form action="../Controladores/LoginControlador.php" method="post">
    <div>
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <input type="hidden" name="action" value="login">
    <div>
        <button type="submit">Iniciar sesión</button>
    </div>
</form>
</body>
</html>
