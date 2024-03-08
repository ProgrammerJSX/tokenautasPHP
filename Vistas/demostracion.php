<?php
// demostracion.php

session_start();
require_once __DIR__ . '/../conexion.php'; // Subir un nivel en la estructura de directorios
require_once __DIR__ . '/../Funciones/verImagenesWallets.php';
require_once __DIR__ . '/../Funciones/verWalletBTC.php';
require_once __DIR__ . '/../Funciones/verWalletUSDT.php';

// Asegúrate de que el usuario esté logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id']; // Cambia a la clave real que estás usando en $_SESSION

// Ejecuta las funciones y almacena los resultados
$imagenesUsuario = getUserImages($userId, $pdo);
$valorWalletBTC = obtenerValorWalletBTC($userId, $pdo);
$valorWalletUSDT = obtenerValorWalletUSDT($userId, $pdo);

// Verifica si las claves existen en el array antes de intentar acceder a ellas
$imagenUSD = isset($imagenesUsuario['imagenusdt']) ? $imagenesUsuario['imagenusdt'] : '';
$imagenBTC = isset($imagenesUsuario['imagenbtc']) ? $imagenesUsuario['imagenbtc'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Usuario</title>
    <!-- Agrega aquí tu archivo de estilo si tienes uno. -->
</head>
<body>
    <div>
        <h2>Imágenes del Usuario</h2>
        <p>Imagen USD: <img src="<?php echo '../' . htmlspecialchars($imagenUSD); ?>" alt="Imagen USD"></p>
<p>Imagen BTC: <img src="<?php echo '../' . htmlspecialchars($imagenBTC); ?>" alt="Imagen BTC"></p>

    </div>
    
    <div>
        <h2>Wallet BTC</h2>
        <p>Valor actual en BTC: <?php echo htmlspecialchars($valorWalletBTC); ?></p>
    </div>
    
    <div>
        <h2>Wallet USDT</h2>
        <p>Valor actual en USDT: <?php echo htmlspecialchars($valorWalletUSDT); ?></p>
    </div>
</body>
</html>

