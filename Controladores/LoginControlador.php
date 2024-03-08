<?php
// Controladores/LoginControlador.php
session_start();
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../Modelos/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $usuarioModelo = new Usuario($pdo);

    // Validar credenciales del usuario
    if ($usuarioModelo->validarCredenciales($username, $password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../Vistas/dashboard.php");
        exit;
    } else {
        $_SESSION['mensaje'] = "Nombre de usuario o contraseña incorrecta.";
        header("Location: ../Vistas/login.php");
        exit;
    }
}
?>
