# Estructura de Directorios del Proyecto 📁

proyecto/
├── 📄 conexion.php
├── 📄 index.php
│
├── 📂 Modelos/
│ ├── 📄 Usuario.php
│ └── ...
│
├── 📂 Vistas/
│ ├── 📄 login.php
│ ├── 📄 registro.php
│ └── 📄 dashboard.php
│
├── 📂 Controladores/
│ ├── 📄 RegistroControlador.php
│ ├── 📄 LoginControlador.php
│ └── ...
│
├── 📂 Funciones/
│ ├── 📄 verImagenesWallets.php
│ ├── 📄 verWalletBTC.php
│ ├── 📄 verWalletUSDT.php
│ └── 📄 automatizacionIMG.php
│
└── 📂 assets/
└── 📂 src/
├── 🖼️ imagen_usdt_1.jpg
├── 🖼️ imagen_usdt_2.jpg
├── 🖼️ imagen_btc_1.jpg
└── 🖼️ imagen_btc_2.jpg



//

CREATE DATABASE IF NOT EXISTS mi_base_de_datos;
USE mi_base_de_datos;

CREATE TABLE IF NOT EXISTS usuarios (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    mi_billetera1 VARCHAR(255),
    walletUSDT VARCHAR(255),
    walletBTC VARCHAR(255),
    imagenusdt VARCHAR(255),
    imagenbtc VARCHAR(255),
    alias VARCHAR(255),
    nombre_banco VARCHAR(255),
    tipo_cuenta VARCHAR(255),
    titular_cuenta VARCHAR(255),
    cedula_titular VARCHAR(255),
    valor_retirar DECIMAL(10, 2),
    estado VARCHAR(255),
    fecha_hora DATETIME,
    identificador_transaccion VARCHAR(255),
    historial_retiro TEXT
);









//


se crea otra tabla y se relaciona la anterior para poder funcionar la funcion registrar bancos  y su formulario: CREATE TABLE IF NOT EXISTS bancos_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    alias VARCHAR(255) NOT NULL,
    nombre_banco VARCHAR(255) NOT NULL,
    tipo_cuenta VARCHAR(255) NOT NULL,
    titular_cuenta VARCHAR(255) NOT NULL,
    cedula_titular VARCHAR(255) NOT NULL,
    numeroCuenta VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuarios(user_id)
);




espera olvide algo: esta es la estructura de mis directorios correcta, ahora si reestructura tu respuesta: proyecto/
│
├── conexion.php
├── index.php
│
├── Modelos/
│   ├── Usuario.php
│   └── ...
│
├── Vistas/
│   ├── login.php
│   ├── registro.php
│   ├── dashboard.php
│   └── demostracion.php   <-- Tu archivo demostracion.php aquí
│
├── Controladores/
│   ├── RegistroControlador.php
│   ├── LoginControlador.php
│   └── ...
│
├── Funciones/
│   ├── verImagenesWallets.php
│   ├── verWalletBTC.php
│   ├── verWalletUSDT.php
│   └── automatizacionIMG.php
│
└── assets/
    └── src/
        ├── imagen_usdt_1.jpg
        ├── imagen_usdt_2.jpg
        ├── imagen_btc_1.jpg
        └── imagen_btc_2.jpg