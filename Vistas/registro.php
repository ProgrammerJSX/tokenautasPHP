<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
<h2>Registro de Usuario</h2>
<form action="../Controladores/RegistroControlador.php" method="post">

    <div>
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <input type="hidden" name="action" value="register">
    <div>
        <button type="submit">Registrar</button>
    </div>
</form>
</body>
</html>
