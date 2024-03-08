<?php
// Funciones/automatizacionIMG.php
// Arrays globales que puedes modificar según necesites

$arrayusdt = [
    ['imagen' => 'Assets/src/imagen_usdt_1.png', 'palabraSecreta' => 'secreto_usdt_1'],
    ['imagen' => 'Assets/src/imagen_usdt_2.png', 'palabraSecreta' => 'secreto_usdt_2'],
    ['imagen' => 'Assets/src/1.png', 'palabraSecreta' => 'secreto_usdt_3'],
    ['imagen' => 'Assets/src/2.png', 'palabraSecreta' => 'secreto_usdt_4'],
    ['imagen' => 'Assets/src/3.jpg', 'palabraSecreta' => 'secreto_usdt_5'],
    ['imagen' => 'Assets/src/4.jpg', 'palabraSecreta' => 'secreto_usdt_6'],
];

$arraybtc = [
    ['imagen' => 'Assets/src/imagen_btc_1.png', 'palabraSecreta' => 'secreto_btc_1'],
    ['imagen' => 'Assets/src/imagen_btc_2.png', 'palabraSecreta' => 'secreto_btc_2'],
    ['imagen' => 'Assets/src/5.jpg', 'palabraSecreta' => 'secreto_btc_3'],
    ['imagen' => 'Assets/src/6.jpg', 'palabraSecreta' => 'secreto_btc_4'],
    ['imagen' => 'Assets/src/7.jpg', 'palabraSecreta' => 'secreto_btc_5'],
    ['imagen' => 'Assets/src/8.jpg', 'palabraSecreta' => 'secreto_btc_6'],
];


function seleccionarImagenYPalabra($tipo, $pdo) {
    global $arrayusdt, $arraybtc;

    // Selección del array correspondiente basada en el tipo
    $arraySeleccionado = ($tipo == 'usdt') ? $arrayusdt : $arraybtc;

    foreach ($arraySeleccionado as $item) {
        // Verificar si la imagen y palabraSecreta ya están asignadas
        if (!imagenOPalabraAsignada($item['imagen'], $item['palabraSecreta'], $pdo)) {
            // Si no están asignadas, retornar estas para su uso
            return [$item['imagen'], $item['palabraSecreta']];
        }
    }

    // En caso de no encontrar ninguna opción disponible, retornar valores nulos o manejar el error según convenga
    return [null, null];
}

function imagenOPalabraAsignada($imagen, $palabraSecreta, $pdo) {
    $sql = "SELECT COUNT(*) FROM usuarios WHERE imagenusdt = ? OR imagenbtc = ? OR walletUSDT = ? OR walletBTC = ?";
    $stmt = $pdo->prepare($sql);
    
    // Vincular parámetros usando bindValue() de PDO
    $stmt->bindValue(1, $imagen);
    $stmt->bindValue(2, $imagen);
    $stmt->bindValue(3, $palabraSecreta);
    $stmt->bindValue(4, $palabraSecreta);

    $stmt->execute();

    // PDOStatement::fetchColumn() devuelve el valor de una sola columna de la siguiente fila en el result set
    $count = $stmt->fetchColumn();

    return $count > 0;
}

?>
