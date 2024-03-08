<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

// Genera un token de formulario si no existe
if (!isset($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

// Incluye los archivos necesarios
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../Funciones/automatizacionIMG.php';
require_once __DIR__ . '/../Funciones/verImagenesWallets.php';
require_once __DIR__ . '/../Funciones/verWalletBTC.php';
require_once __DIR__ . '/../Funciones/verWalletUSDT.php';
require_once __DIR__ . '/../Funciones/obtenerMiBilletera1.php';

// Recupera el ID del usuario de la sesión
$userId = $_SESSION['user_id']; // Asegúrate de tener la sesión iniciada y el user_id disponible
$miBilletera1 = obtenerMiBilletera1($pdo, $userId);
$miBilletera1 = $miBilletera1 === null ? '0.00' : $miBilletera1;

// Usar la función obtenerMiBilletera1 para obtener el valor de la billetera del usuario actual
$userId = $_SESSION['user_id']; // Asegúrate de tener la sesión iniciada y el user_id disponible
$miBilletera1 = obtenerMiBilletera1($pdo, $userId);


// Obtiene la información del usuario usando las funciones
$userImages = getUserImages($userId, $pdo);
$valorWalletBTC = obtenerValorWalletBTC($userId, $pdo);
$valorWalletUSDT = obtenerValorWalletUSDT($userId, $pdo);

// Función para generar un ID de transacción
function generateTransactionId() {
    return uniqid() . bin2hex(random_bytes(8));
}

// Manejo del formulario POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alias'], $_POST['token'])) {
    if (!hash_equals($_SESSION['form_token'], $_POST['token'])) {
        die("Error de validación del token.");
    }
    unset($_SESSION['form_token']);

    $alias = $_POST['alias'];
    $nombre_banco = $_POST['nombre_banco'];
    $tipo_cuenta = $_POST['tipo_cuenta'];
    $titular_cuenta = $_POST['titular_cuenta'];
    $cedula_titular = $_POST['cedula_titular'];
    $numeroCuenta = $_POST['numeroCuenta'];

    // Preparar y ejecutar la consulta para insertar el alias del banco
    $stmt = $pdo->prepare("INSERT INTO bancos_usuarios (user_id, alias, nombre_banco, tipo_cuenta, titular_cuenta, cedula_titular, numeroCuenta) SELECT ?, ?, ?, ?, ?, ?, ? FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM bancos_usuarios WHERE user_id = ? AND alias = ?)");
    if ($stmt->execute([$userId, $alias, $nombre_banco, $tipo_cuenta, $titular_cuenta, $cedula_titular, $numeroCuenta, $userId, $alias])) {
        if ($stmt->rowCount() > 0) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "El banco ya está registrado o no se pudo registrar.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../stylex.css">
  <link rel="stylesheet" href="../form.css">

  <!--=============== REMIXICONS ===============-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://kit.fontawesome.com/a62869df81.js" crossorigin="anonymous"></script>

  <!--=============== CSS ===============-->
  <link rel="stylesheet" href="../Assets/css/styles.css">

  <title>Tokenautas</title>
</head>

<body>
  <!-- Sidebar bg JJJJ -->
  <img src="" alt="sidebar img" class="bg-image">

  <!--=============== HEADER ===============-->
  <header class="header">
    <div class="header__container container">
      <div class="header__toggle" id="header-toggle">
        <i class="ri-menu-line"></i>
      </div>

      <a href="#" class="header__logo" style=" width: 100%; position: absolute;"><img style="width: 340px; margin-left: 1000px;" src="../img/letra tokenauta-05.png" alt="">
      </a>
    </div>
  </header>

  <script>
    alert("Una vez hallas transferido tus tokens o criptomonedas podras ver tu saldo reflejado, retiralo cuando quieras y a donde quieras. O envialo a quien quieras ")



function mostrarSeccion(seccionId) {
    // Ocultar todas las secciones
    document.querySelectorAll('.section').forEach(function(section) {
        section.style.display = 'none';
    });

    // Mostrar la sección solicitada
    document.getElementById(seccionId).style.display = 'block';
}





  </script>
  <!--=============== SIDEBAR ===============-->
  <div class="sidebar" id="sidebar">
    <nav class="sidebar__container">
      <div class="sidebar__logo" style="width: 200px;">
        <img src="../img/cohete06.png" style="width: 180px; margin-left:-12px" alt="">
      </div>

      <div class="sidebar__content">
        <div class="sidebar__list">
          <h3 class="sidebar__title">


                    <a href="./dashboard.php" class="sidebar__link">

            <span class="sidebar__link-name" style="font-size: 12px;">Inicio</span>
            <span class="sidebar__link-floating" style="font-size: 12px;">Inicio</span></a>




          <a href="./retirar.php" class="sidebar__link">

            <span class="sidebar__link-name" style="font-size: 12px;">Retirar</span>
            <span class="sidebar__link-floating" style="font-size: 12px;">Retirar</span></a>


          <a hhref="./depositar.php"  class="sidebar__link">

            <span class="sidebar__link-name" style="font-size: 12px;">Depositar</span>
            <span class="sidebar__link-floating" style="font-size: 12px;">Depositar</span></a>



          <a href="javascript:void(0);" onclick="mostrarSeccion('bancos-registrados')" class="sidebar__link">

            <span class="sidebar__link-name" style="font-size: 12px;">Mis Bancos</span>
            <span class="sidebar__link-floating" style="font-size: 12px;">Mis Bancos</span>
          </a>



          <ahref="javascript:void(0);" onclick="mostrarSeccion('registrar-bancos')" class="sidebar__link">

            <span class="sidebar__link-name" style="font-size: 12px;">Registrar Bancos</span>
            <span class="sidebar__link-floating" style="font-size: 12px;">Registar Bancos</span>
            </a>






        </div>





      </div>

      <h3 class="sidebar__title">
        <span>Historial</span>
      </h3>

      <div class="sidebar__list">
        <a href="javascript:void(0);" onclick="mostrarSeccion('historial-retiro')" class="sidebar__link">

          <span class="sidebar__link-name" style="font-size: 12px;">Historial de Retiro</span>
          <span class="sidebar__link-floating" style="font-size: 12px;">Historial de Retiro</span>
        </a>













        <!--===============
                  <a href="javascript:void(0);" class="sidebar__link" onclick="mostrarSeccion('historial-deposito')" >
                    <span class="sidebar__link-name" style="font-size: 12px;">Historial Deposito</span>
                    <span class="sidebar__link-floating" style="font-size: 12px;">Historial Deposito</span></a>
                 ===============-->

        <h3 class="sidebar__title">
          <span>Usuario</span>
        </h3>
        <a href="logout.php" class="sidebar__link">
          <i class="ri-logout-box-r-line"></i>
          <span class="sidebar__link-name" style="font-size: 12px;">Salir</span>
          <span class="sidebar__link-floating" style="font-size: 12px;">Salir</span>
        </a>
      </div>
  </div>


  </nav>
  </div>

  <!--=============== MAIN ===============-->
  <!--=============== MAIN ===============-->
  <!--=============== MAIN ===============-->
  <main class="main container" id="main" >
    <div class="dash" >



   




      <!-- BODY REGISTRAR BANCOS-->
      <div class="body section" id="registrar-bancos">


        <!-- MAIN INICIO -->
        <main class="main" id="main_inicio">

          <!-- COL-1 -->
          <div class="main__col-1">

            <!-- HEADING -->
            <div>
              <h2 class="main__heading"><span style="background: linear-gradient(to bottom, hsl(70, 6%, 21%), hsl(300, 3%, 6%)); box-shadow: 0 2px 12px hsla(247, 88%, 70%, .3)">
                  <img src="./img/coheteLogoBlanco.png" alt="" height="50rem">
                </span><?php echo $_SESSION['username']; ?></h2>
              <p class="main__desc" style="font-size: 50px;">$<?php echo $miBilletera1; ?></p>
              <p class="main__sub" style="font-size: 25px;"><span>COP:</span> <span>Pesos Colombianos</span></p>
            </div>

            <!-- LIST -->
            <div class="main__list-heading-wrap">
              <h2 class="main__list-heading ss-heading" style="font-size: 25px;">Mi Estudio</h2>
              <a href="#" class="ss-show"></a>
            </div>

            <ul class="main__list">

              <li class="main__list-item">
                <div class="main__list-item-image">
                  <img src="./spaceModels.png" width="40px" alt="">
                </div>
                <div class="main__list-content-wrap">
                  <p class="main__list-content">Space Models</p>
                  <p class="main__list-sub" style="margin-top: 5px; font-size: 10px !important">Cucuta - Bucaramanga - Medellin</p>

                </div>
              </li>

              <div class="main__list-heading-wrap">
                <h1>En esta seccion puedes agregar los bancos que necesites tener disponibles para recibir los pagos de los tokens o criptomonedas que nos vendas.</h1>
                </li>

            </ul>

          </div>

          <!-- COL-2 -->
          <div class="main__col-2">


            <!-- CROSSING -->
            <div class="main__crossing-container">
        
              <div class="main__crossing-current">
              
                <h3 class="main__crossing-heading" style="font-size:25px;  font-weight: bold;">
                  REGISTRAR BANCOS
                </h3>
              </div>
            </div>








<style>
  /* Estilos para la sección de registro de bancos */
.discover-form-container {
  padding: 20px !important;
  background-color: #2c3e50 !important;
  border-radius: 10px !important;
  color: #ecf0f1 !important;
  max-width: 500px !important;
  margin: 0 auto !important;
 
  
}

.discover-form-container h3 {
  margin-bottom: 20px !important;
}

.discover-form-input {
  width: calc(100% - 24px) !important;
  padding: 12px !important;
  margin: 6px 0 !important;
  border-radius: 5px !important;
  border: 1px solid #34495e !important;
  background-color: #3a506b !important;
  color: #ecf0f1 !important;
}

.discover-form-button {
  width: calc(100% - 24px) !important;
  padding: 15px !important;
  margin: 12px 0 !important;
  border-radius: 5px !important;
  border: none !important;
  background-color: #e1e1e1 !important;
  color: #2c3e50 !important;
  cursor: pointer !important;
  font-weight: bold !important;
}

.discover-form-button:hover {
  background-color: #d1d1d1 !important;
}

</style>











   <!-- DISCOVER -->
<div class="main__discover" style="">
  <div class="main__discover-heading-container">
    <h3 class="main__discover-heading ss-heading">Añade el banco donde te pagaremos !</h3>
    <a href="#" class="ss-show"></a>
  </div>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="token" value="<?php echo $_SESSION['form_token']; ?>">
    <input class="discover-form-input" type="text" name="alias" required placeholder="Alias">
    <input class="discover-form-input" type="text" name="nombre_banco" required placeholder="Nombre del banco">
    <input class="discover-form-input" type="text" name="numeroCuenta" required placeholder="Número de Cuenta">
    <input class="discover-form-input" type="text" name="tipo_cuenta" required placeholder="Cuenta: ¿Ahorro? o ¿Corriente?">
    <input class="discover-form-input" type="text" name="titular_cuenta" required placeholder="Titular de la cuenta">
    <input class="discover-form-input" type="text" name="cedula_titular" required placeholder="Cédula del titular">
    <button class="discover-form-button" type="submit" style="background-color: #007bff !important; color: white !important; font-size: 12px !important" >Registrar Banco</button>
  </form>
</div>


            <!-- FOOTER -->
            <footer class="main__footer">

              <a href="#" class="main__footer-more ss-show">Leer normativa de www.tokenautas.com <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </span></a>

              <div class="main__info">
                <a href="https://twitter.com/AbubakerSaeed96/status/1329417170368016385" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                  </svg>
                </a>
                <a href="https://github.com/AbubakerSaeed/dashboard-ui-n20" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                  </svg>
                </a>
                <a href="https://dribbble.com/shots/14615615-Dashboard-UI" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path>
                  </svg>
                </a>

                <p class="main__cp" style="font-size: 1.4rem; text-align: center; ">
                  Copyright &copy; <a href="https://twitter.com/AbubakerSaeed96" target="_blank" rel="noreferrer noopener" class="main__info-link" style="border-bottom: 1px solid  hsla(270, 10%, 50%, .4);">2024 by</a>
                </p>

                <p class="main__cr">
                  <a href="https://activosdigitales.com.co" target="_blank" rel="noreferrer noopener">
                    <img src="./img/logoCompletoBlanco.png" alt="" height="80rem">
                  </a>
                </p>
              </div>

            </footer>

          </div>

        </main>












      </div>

      <!-- BANCOS REGISTRADPS-->

      <div class="body section" id="bancos-registrados">


        <!-- MAIN INICIO -->
        <main class="main" id="main_inicio">

          <!-- COL-1 -->
          <div class="main__col-1">

            <!-- HEADING -->
            <div>
              <h2 class="main__heading"><span style="background: linear-gradient(to bottom, hsl(70, 6%, 21%), hsl(300, 3%, 6%)); box-shadow: 0 2px 12px hsla(247, 88%, 70%, .3)">
                  <img src="./img/coheteLogoBlanco.png" alt="" height="50rem">
                </span><?php echo $_SESSION['username']; ?></h2>
              <p class="main__desc" style="font-size: 50px;"><?php echo $miBilletera1; ?></p>
              <p class="main__sub" style="font-size: 25px;"><span>COP:</span> <span>Pesos Colombianos</span></p>
            </div>


            <!-- LIST -->
            <div class="main__list-heading-wrap">
              <h2 class="main__list-heading ss-heading" style="font-size: 25px;">Mi Estudio</h2>
              <a href="#" class="ss-show"></a>
            </div>

            <ul class="main__list">

              <li class="main__list-item">
                <div class="main__list-item-image">
                <img src="./spaceModels.png" width="40px" alt="">
                </div>
                <div class="main__list-content-wrap">
                  <p class="main__list-content">Space Models</p>
                  <p class="main__list-sub" style="margin-top: 5px; font-size: 10px !important">Cucuta - Bucaramanga - Medellin</p>

                </div>
              </li>

              <div class="main__list-heading-wrap">
                <h1>En esta seccion estan los bancos que haz agregado para recibir tu dinero. Recuerda que tokenautas.com te permite recibir pagos el cualquier cuenta bancaria, personal o de un tercero.</h1>
                </li>












            </ul>

          </div>

          <!-- COL-2 -->
          <div class="main__col-2">


            <!-- CROSSING -->
            <div class="main__crossing-container">
          
              <div class="main__crossing-current">
          
                <h3 class="main__crossing-heading" style="font-size:25px;  font-weight: bold;">
                  MIS BANCOS
                </h3>
              </div>
            </div>




            <style>
              .main__discover--responsive {
  display: flex;
  flex-wrap: wrap;
  gap: 20px; /* Este es el espacio entre las tarjetas */
  justify-content: center; /* Centra las tarjetas en el contenedor */
  padding: 20px; /* Un poco de espacio alrededor del contenedor */
}

.banco-registrado--responsive {
  background-color: #fff; /* Fondo blanco para las tarjetas */
  border-radius: 8px; /* Bordes redondeados para suavidad */
  box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra sutil */
  padding: 20px; /* Espacio dentro de las tarjetas */
  width: 300px; /* Ancho fijo para todas las tarjetas */
  box-sizing: border-box; /* Incluye el padding y el borde en el ancho total */
  margin-bottom: 20px; /* Espacio adicional en la parte inferior si se apilan */
}

.banco-registrado--responsive p {
  margin: 5px 0; /* Espacio vertical entre párrafos */
  color: #333; /* Color oscuro para el texto */
}

            </style>



<style>
/* Estilos personalizados para la sección de bancos */
.discover-banks-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  overflow-y: auto;
  max-height: calc(100vh - 200px);
  padding: 10px;
}

.bank-card {
  background: #2c3e50;
  color: #ecf0f1;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  min-width: 250px;
  max-width: calc(33% - 20px);
  box-sizing: border-box;
}

.bank-card p {
  margin: 5px 0;
}

/* Estilos personalizados para la barra de desplazamiento de la sección de bancos */
.discover-banks-container::-webkit-scrollbar {
  width: 12px;
}

.discover-banks-container::-webkit-scrollbar-track {
  background: #34495e;
  border-radius: 10px;
}

.discover-banks-container::-webkit-scrollbar-thumb {
  background-color: #ecf0f1;
  border-radius: 10px;
  border: 3px solid #34495e;
}

.discover-banks-container::-webkit-scrollbar-thumb:hover {
  background: #bdc3c7;
}

/* Estilos para Firefox */
.discover-banks-container {
  scrollbar-width: thin;
  scrollbar-color: #ecf0f1 #34495e;
}




</style>



            <!-- DISCOVER -->
            <div class="main__discover" style="display: flex;">

            <div class="discover-banks-container">
  <?php
  $userId = $_SESSION['user_id']; // Asegúrate de que esto corresponde al usuario logueado
  $stmt = $conn->prepare("SELECT * FROM bancos_usuarios WHERE user_id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div class='bank-card'>";
      echo "<p>Alias: " . htmlspecialchars($row['alias'], ENT_QUOTES, 'UTF-8') . "</p>";
      echo "<p>Nombre del Banco: " . htmlspecialchars($row['nombre_banco'], ENT_QUOTES, 'UTF-8') . "</p>";
      echo "<p>Tipo de Cuenta: " . htmlspecialchars($row['tipo_cuenta'], ENT_QUOTES, 'UTF-8') . "</p>";
      echo "<p>Titular de la Cuenta: " . htmlspecialchars($row['titular_cuenta'], ENT_QUOTES, 'UTF-8') . "</p>";
      echo "<p>Cédula del Titular: " . htmlspecialchars($row['cedula_titular'], ENT_QUOTES, 'UTF-8') . "</p>";
      // Añadir esta línea para mostrar el número de cuenta, si es necesario
      echo "<p>Número de Cuenta: " . htmlspecialchars($row['numeroCuenta'], ENT_QUOTES, 'UTF-8') . "</p>";
      echo "</div>"; // Cierre del div bank-card
    }
  } else {
    echo "<p>No tienes bancos registrados.</p>";
  }
  
  $stmt->close();
  ?>
</div>




            </div>

            <!-- FOOTER -->
            <footer class="main__footer">

              <a href="#" class="main__footer-more ss-show">Leer normativa de www.tokenautas.com <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </span></a>

              <div class="main__info">
                <a href="https://twitter.com/AbubakerSaeed96/status/1329417170368016385" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                  </svg>
                </a>
                <a href="https://github.com/AbubakerSaeed/dashboard-ui-n20" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                  </svg>
                </a>
                <a href="https://dribbble.com/shots/14615615-Dashboard-UI" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path>
                  </svg>
                </a>

                <p class="main__cp" style="font-size: 1.4rem; text-align: center; ">
                  Copyright &copy; <a href="https://twitter.com/AbubakerSaeed96" target="_blank" rel="noreferrer noopener" class="main__info-link" style="border-bottom: 1px solid  hsla(270, 10%, 50%, .4);">2024 by</a>
                </p>

                <p class="main__cr">
                  <a href="https://activosdigitales.com.co" target="_blank" rel="noreferrer noopener">
                    <img src="./img/logoCompletoBlanco.png" alt="" height="80rem">
                  </a>
                </p>
              </div>

            </footer>

          </div>

        </main>












      </div>















      <!-- HISTORIAL DE RETIROS-->

      <div class="body section" id="historial-retiro">


        <!-- MAIN INICIO -->
        <main class="main" id="main_inicio">

          <!-- COL-1 -->
          <div class="main__col-1">

            <!-- HEADING -->
            <div>
              <h2 class="main__heading"><span style="background: linear-gradient(to bottom, hsl(70, 6%, 21%), hsl(300, 3%, 6%)); box-shadow: 0 2px 12px hsla(247, 88%, 70%, .3)">
                  <img src="./img/coheteLogoBlanco.png" alt="" height="50rem">
                </span><?php echo $_SESSION['username']; ?></h2>
              <p class="main__desc" style="font-size: 50px;">$<?php echo $miBilletera1; ?></p>
              <p class="main__sub" style="font-size: 25px;"><span>COP:</span> <span>Pesos Colombianos</span></p>
            </div>


            <!-- LIST -->
            <div class="main__list-heading-wrap">
              <h2 class="main__list-heading ss-heading" style="font-size: 25px;">Mi Estudio</h2>
              <a href="#" class="ss-show"></a>
            </div>

            <ul class="main__list">

              <li class="main__list-item">
                <div class="main__list-item-image">
                  <img src="./spaceModels.png" width="40px" alt="">
                </div>
                <div class="main__list-content-wrap">
                  <p class="main__list-content">Space Models</p>
                  <p class="main__list-sub" style="margin-top: 5px; font-size: 10px !important">Cucuta - Bucaramanga - Medellin</p>

                </div>
              </li>

              <div class="main__list-heading-wrap">
                <h1>En esta seccion puedes visualizar los retiros que haz realizado a tus bancos registrados. Por favor fijate en el estado que cambiara de "Pendiente" a "Aprobado" cuando hallamos depositado tus fondos.</h1>
                </li>


            </ul>

          </div>

          <!-- COL-2 -->
          <div class="main__col-2">


            <!-- CROSSING -->
            <div class="main__crossing-container">
           
              <div class="main__crossing-current">
            
                <h3 class="main__crossing-heading" style="font-size:25px;  font-weight: bold;">
                  HISTORIAL DE RETIRO
                </h3>
              </div>
            </div>



<style>

.historial-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px; /* Puedes ajustar el espacio entre cartas */
  overflow-y: auto;
  max-height: 200px; /* Ajusta esto según necesites */
  padding: 10px;
}

.historial-card {
  background: #2c3e50; /* Un color oscuro para combinar con tu tema */
  color: #ecf0f1; /* Un color claro para el texto */
  border-radius: 10px; /* Esquinas redondeadas */
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra sutil para profundidad */
  min-width: 250px; /* Ancho mínimo de cada tarjeta */
  max-width: calc(50% - 20px); /* Ancho máximo para 2 cartas por fila, ajusta el gap si cambias esto */
}

.historial-card p {
  margin: 5px 0; /* Asegúrate de que los párrafos no estén muy juntos */
}


/* Estiliza la barra de desplazamiento para todo el contenedor */
.historial-container::-webkit-scrollbar {
  width: 12px; /* Ancho de la barra de desplazamiento */
}

/* Estilo para la "track" (la parte por donde se desliza el "thumb") */
.historial-container::-webkit-scrollbar-track {
  background: #34495e; /* Un tono ligeramente más claro que el fondo del contenedor */
  border-radius: 10px; /* Bordes redondeados para la track */
}

/* Estilo para el "thumb" (la parte que se mueve de la barra de desplazamiento) */
.historial-container::-webkit-scrollbar-thumb {
  background-color: #ecf0f1; /* Color de tu elección para el thumb */
  border-radius: 10px; /* Bordes redondeados para el thumb */
  border: 3px solid #34495e; /* Borde sólido con el color del fondo de la track */
}

/* Estilo para el estado "hover" del thumb */
.historial-container::-webkit-scrollbar-thumb:hover {
  background: #bdc3c7; /* Un color un poco más claro cuando se pasa el ratón por encima */
}



</style>



            <!-- DISCOVER -->
            <div class="main__discover" style="">

              <div class="main__discover-heading-container">
                <h3 class="main__discover-heading ss-heading">Historial</h3>
                <a href="#" class="ss-show"></a>
              </div>
              <div style="overflow-y: scroll; height: 200px;" class="historial-container">
                <?php
                // Asumiendo que $userId es el ID del usuario logueado
                $stmt = $conn->prepare("SELECT retiros.valor_retirar, retiros.identificador_transaccion, retiros.fecha_hora, retiros.estado, bancos_usuarios.nombre_banco, bancos_usuarios.tipo_cuenta FROM retiros INNER JOIN bancos_usuarios ON retiros.banco_id = bancos_usuarios.banco_id WHERE retiros.user_id = ? ORDER BY retiros.fecha_hora DESC");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                  echo "<div class='historial-card'>";
                  echo "<p>Banco: " . htmlspecialchars($row['nombre_banco'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Tipo de Cuenta: " . htmlspecialchars($row['tipo_cuenta'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Monto: " . htmlspecialchars($row['valor_retirar'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Identificador Transacción: " . htmlspecialchars($row['identificador_transaccion'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Estado: " . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</p>"; // Agrega esta línea para mostrar el estado
                  echo "<p>Fecha: " . htmlspecialchars($row['fecha_hora'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "</div>";
                }
                $stmt->close();
                ?>
              </div>


            </div>

            <!-- FOOTER -->
            <footer class="main__footer">

              <a href="#" class="main__footer-more ss-show">Leer normativa de www.tokenautas.com <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </span></a>

              <div class="main__info">
                <a href="https://twitter.com/AbubakerSaeed96/status/1329417170368016385" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                  </svg>
                </a>
                <a href="https://github.com/AbubakerSaeed/dashboard-ui-n20" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                  </svg>
                </a>
                <a href="https://dribbble.com/shots/14615615-Dashboard-UI" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path>
                  </svg>
                </a>

                <p class="main__cp" style="font-size: 1.4rem; text-align: center; ">
                  Copyright &copy; <a href="https://twitter.com/AbubakerSaeed96" target="_blank" rel="noreferrer noopener" class="main__info-link" style="border-bottom: 1px solid  hsla(270, 10%, 50%, .4);">2024 by</a>
                </p>

                <p class="main__cr">
                  <a href="https://activosdigitales.com.co" target="_blank" rel="noreferrer noopener">
                    <img src="./img/logoCompletoBlanco.png" alt="" height="80rem">
                  </a>
                </p>
              </div>

            </footer>

          </div>

        </main>












      </div>





































































  <!-- BANCOS REGISTRADPS-->

  <div class="body section" id="plataformas">


<!-- MAIN INICIO -->
<main class="main" id="main_inicio">

  <!-- COL-1 -->
  <div class="main__col-1">

    <!-- HEADING -->
    <div>
      <h2 class="main__heading"><span style="background: linear-gradient(to bottom, hsl(70, 6%, 21%), hsl(300, 3%, 6%)); box-shadow: 0 2px 12px hsla(247, 88%, 70%, .3)">
          <img src="./img/coheteLogoBlanco.png" alt="" height="50rem">
        </span><?php echo $_SESSION['username']; ?></h2>
      <p class="main__desc" style="font-size: 50px;">BITCOIN</p>
      <p class="main__sub" style="font-size: 25px;"><span>RED:</span> <span>TRC20</span></p>
    </div>


    <!-- LIST -->
    <div class="main__list-heading-wrap">
             <div id="johan" class="modal-bitcoin" >  <!-- OJO -->
                <div class="image-container" onmouseover="showModal('btcModal')" onmouseout="hideModal('btcModal')">
                  <?php if ($images && $images['image_path_btc']) { ?>
                    <img src="<?php echo $images['image_path_btc']; ?>" alt="Wallet BTC">
                  <?php } ?>
                </div>
       
              </div>
    </div>

    <ul class="main__list">

    <li class="main__list-item">
    <div class="main__list-item-image" style="cursor: pointer;" onclick="copiarAlPortapapeles(this)">
      <img src="./img/copiar.png" width="40px" alt="">
    </div>
    <div class="main__list-content-wrap">
      <p class="main__list-content"><?php echo $valorWalletBTC; ?></p>
      <p class="main__list-sub">Tu billetera Bitcoin</p>
    </div>
</li>

<script>
function copiarAlPortapapeles(elemento) {
    // Encuentra el elemento <p> que contiene el valor a copiar
    var contenido = elemento.closest('.main__list-item').querySelector('.main__list-content').textContent;

    // Crea un elemento input temporal, necesario para el proceso de copiado
    var inputTemporal = document.createElement("input");
    document.body.appendChild(inputTemporal);
    inputTemporal.value = contenido;
    inputTemporal.select();
    document.execCommand("copy");
    document.body.removeChild(inputTemporal);

    // Muestra un mensaje de alerta con el contenido copiado
    alert("Copiado al portapapeles: " + contenido);
}
</script>



      <div class="main__list-heading-wrap" style="display: none;">
        <h1>Para desplegar las instrucciones selecciona la plataforma o criptomoneda que deseas vendernos.</h1>
        </li>













    </ul>

  </div>

  <!-- COL-2 -->
  <div class="main__col-2">


    <!-- CROSSING -->
    <div class="main__crossing-container" style="padding: 35px;">
   
      <div class="main__crossing-current">
        <p class="main__crossing-upper">
        
        </p>
        <h3 class="main__crossing-heading" style="font-size:21px;  font-weight: bold;">
          ¡INFORMACION IMPORTANTE!
        </h3>
      </div>
    </div>



    <style>
      .cajaDisclamer1{
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        font-size: 14px;
        margin-bottom: 20px;
      }
    </style>
    <!-- DISCOVER -->
    <div class="main__discover" style="">

      <div class="main__discover-heading-container">
        <h3 class="main__discover-heading ss-heading" style="padding-bottom:20px">DESCARGO DE RESPONSABILIDAD: ANTES DE RECIBIR TUS BITCOIN NUNCA DEBES OLVIDAR TENER EN CUENTA LAS SIGUIENTES RECOMENDACIONES:</h3>
        <a href="#" class="ss-show"></a>
      </div>
   <div class="disclamerBitcoin1">
   <div class="cajaDisclamer1">
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum earum quae eligendi praesentium quis voluptates iusto quibusdam, voluptas impedit tempora non? Quas, harum. Facilis provident ullam nobis. Libero, earum nam!</p>
   </div>
   <div class="cajaDisclamer1">
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum earum quae eligendi praesentium quis voluptates iusto quibusdam, voluptas impedit tempora non? Quas, harum. Facilis provident ullam nobis. Libero, earum nam!</p>
   </div>
   </div>

    </div>

    <!-- FOOTER -->
    <footer class="main__footer">

      <a href="#" class="main__footer-more ss-show">Leer normativa de www.tokenautas.com <span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </span></a>

      <div class="main__info">
        <a href="https://twitter.com/AbubakerSaeed96/status/1329417170368016385" target="_blank" rel="noreferrer noopener" class="main__info-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
          </svg>
        </a>
        <a href="https://github.com/AbubakerSaeed/dashboard-ui-n20" target="_blank" rel="noreferrer noopener" class="main__info-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
          </svg>
        </a>
        <a href="https://dribbble.com/shots/14615615-Dashboard-UI" target="_blank" rel="noreferrer noopener" class="main__info-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path>
          </svg>
        </a>

        <p class="main__cp" style="font-size: 1.4rem; text-align: center; ">
          Copyright &copy; <a href="https://twitter.com/AbubakerSaeed96" target="_blank" rel="noreferrer noopener" class="main__info-link" style="border-bottom: 1px solid  hsla(270, 10%, 50%, .4);">2024 by</a>
        </p>

        <p class="main__cr">
          <a href="https://activosdigitales.com.co" target="_blank" rel="noreferrer noopener">
            <img src="./img/logoCompletoBlanco.png" alt="" height="80rem">
          </a>
        </p>
      </div>

    </footer>

  </div>

</main>












</div>








































































  <!-- BANCOS REGISTRADPS USDT-->

  <div class="body section" id="plataformas2">


<!-- MAIN INICIO -->
<main class="main" id="main_inicio">

  <!-- COL-1 -->
  <div class="main__col-1">

    <!-- HEADING -->
    <div>
      <h2 class="main__heading"><span style="background: linear-gradient(to bottom, hsl(70, 6%, 21%), hsl(300, 3%, 6%)); box-shadow: 0 2px 12px hsla(247, 88%, 70%, .3)">
          <img src="./img/coheteLogoBlanco.png" alt="" height="50rem">
        </span><?php echo $_SESSION['username']; ?></h2>
      <p class="main__desc" style="font-size: 50px;">TETHER</p>
      <p class="main__sub" style="font-size: 25px;"><span>RED:</span> <span>USDT666</span></p>
    </div>


    <!-- LIST -->
    <div class="main__list-heading-wrap">
             <div id="johan" class="modal-bitcoin" >  <!-- OJO -->
                <div class="image-container" onmouseover="showModal('btcModal')" onmouseout="hideModal('btcModal')">
                  <?php if ($images && $images['image_path_btc']) { ?>
                    <img src="<?php echo $images['image_path_usdt']; ?>" alt="Wallet USDT">
                  <?php } ?>
                </div>
       
              </div>
    </div>

    <ul class="main__list">

    <li class="main__list-item">
    <div class="main__list-item-image" style="cursor: pointer;" onclick="copiarAlPortapapeles(this)">
      <img src="./img/copiar.png" width="40px" alt="">
    </div>
    <div class="main__list-content-wrap">
      <p class="main__list-content"><?php echo $valorWalletBTC; ?></p>
      <p class="main__list-sub">Tu billetera Bitcoin</p>
    </div>
</li>

<script>
function copiarAlPortapapeles(elemento) {
    // Encuentra el elemento <p> que contiene el valor a copiar
    var contenido = elemento.closest('.main__list-item').querySelector('.main__list-content').textContent;

    // Crea un elemento input temporal, necesario para el proceso de copiado
    var inputTemporal = document.createElement("input");
    document.body.appendChild(inputTemporal);
    inputTemporal.value = contenido;
    inputTemporal.select();
    document.execCommand("copy");
    document.body.removeChild(inputTemporal);

    // Muestra un mensaje de alerta con el contenido copiado
    alert("Copiado al portapapeles: " + contenido);
}
</script>



      <div class="main__list-heading-wrap" style="display: none;">
        <h1>Norman aqui algo importante Lorem ipsum dolor sit amet consectetur, adipisicing elit. Placeat at ducimus quisquam voluptatum sint, unde cupiditate amet, libero eius illo animi voluptatibus vel labore porro quae delectus blanditiis</h1>
        </li>













    </ul>

  </div>

  <!-- COL-2 -->
  <div class="main__col-2">


    <!-- CROSSING -->
    <div class="main__crossing-container" style="padding: 35px;">
   
      <div class="main__crossing-current">
        <p class="main__crossing-upper">
        
        </p>
        <h3 class="main__crossing-heading" style="font-size:21px;  font-weight: bold;">
          ¡INFORMACION IMPORTANTE!
        </h3>
      </div>
    </div>



    <style>
      .cajaDisclamer1{
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        font-size: 14px;
        margin-bottom: 20px;
      }
    </style>
    <!-- DISCOVER -->
    <div class="main__discover" style="">

      <div class="main__discover-heading-container">
        <h3 class="main__discover-heading ss-heading" style="padding-bottom:20px">DESCARGO DE RESPONSABILIDAD: ANTES DE RECIBIR TUS BITCOIN NUNCA DEBES OLVIDAR TENER EN CUENTA LAS SIGUIENTES RECOMENDACIONES:</h3>
        <a href="#" class="ss-show"></a>
      </div>
   <div class="disclamerBitcoin1">
   <div class="cajaDisclamer1">
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum earum quae eligendi praesentium quis voluptates iusto quibusdam, voluptas impedit tempora non? Quas, harum. Facilis provident ullam nobis. Libero, earum nam!</p>
   </div>
   <div class="cajaDisclamer1">
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum earum quae eligendi praesentium quis voluptates iusto quibusdam, voluptas impedit tempora non? Quas, harum. Facilis provident ullam nobis. Libero, earum nam!</p>
   </div>
   </div>

    </div>

    <!-- FOOTER -->
    <footer class="main__footer">

      <a href="#" class="main__footer-more ss-show">Leer normativa de www.tokenautas.com <span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </span></a>

      <div class="main__info">
        <a href="https://twitter.com/AbubakerSaeed96/status/1329417170368016385" target="_blank" rel="noreferrer noopener" class="main__info-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
          </svg>
        </a>
        <a href="https://github.com/AbubakerSaeed/dashboard-ui-n20" target="_blank" rel="noreferrer noopener" class="main__info-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
          </svg>
        </a>
        <a href="https://dribbble.com/shots/14615615-Dashboard-UI" target="_blank" rel="noreferrer noopener" class="main__info-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path>
          </svg>
        </a>

        <p class="main__cp" style="font-size: 1.4rem; text-align: center; ">
          Copyright &copy; <a href="https://twitter.com/AbubakerSaeed96" target="_blank" rel="noreferrer noopener" class="main__info-link" style="border-bottom: 1px solid  hsla(270, 10%, 50%, .4);">2024 by</a>
        </p>

        <p class="main__cr">
          <a href="https://activosdigitales.com.co" target="_blank" rel="noreferrer noopener">
            <img src="./img/logoCompletoBlanco.png" alt="" height="80rem">
          </a>
        </p>
      </div>

    </footer>

  </div>

</main>












</div>
















































































































      <!-- HISTORIAL DE DEPOSITOS-->


      <div class="body section" id="historial-deposito">


        <!-- MAIN INICIO -->
        <main class="main" id="main_inicio">

          <!-- COL-1 -->
          <div class="main__col-1">

            <!-- HEADING -->
            <div>
              <h2 class="main__heading"><span style="background: linear-gradient(to bottom, hsl(70, 6%, 21%), hsl(300, 3%, 6%)); box-shadow: 0 2px 12px hsla(247, 88%, 70%, .3)">
                  <img src="./img/coheteLogoBlanco.png" alt="" height="50rem">
                </span><?php echo $_SESSION['username']; ?></h2>
              <p class="main__desc" style="font-size: 50px;">$<?php echo $miBilletera1; ?></p>
              <p class="main__sub" style="font-size: 25px;"><span>COP:</span> <span>Pesos Colombianos</span></p>
            </div>
            <!-- LIST -->
            <div class="main__list-heading-wrap">
              <h2 class="main__list-heading ss-heading" style="font-size: 25px;">Mi Estudio</h2>
              <a href="#" class="ss-show"></a>
            </div>

            <ul class="main__list">

              <li class="main__list-item">
                <div class="main__list-item-image">
                <img src="./spaceModels.png" width="40px" alt="">
                </div>
                <div class="main__list-content-wrap">
                  <p class="main__list-content">Space Models</p>
                  <p class="main__list-sub" style="margin-top: 5px; font-size: 10px !important">Cucuta - Bucaramanga - Medellin</p>

                </div>
              </li>

              <div class="main__list-heading-wrap">
                <h1>En esta seccion puedes agregar los bancos que necesites tener disponibles para recibir los pagos de los tokens o criptomonedas que nos vendas.</h1>
                </li>


            </ul>

          </div>
          <!-- COL-2 -->
          <div class="main__col-2">


            <!-- CROSSING -->
            <div class="main__crossing-container">
              <div class="main__crossing-image">
                <img src="https://images.unsplash.com/photo-1595064085577-7c2ef98ec311?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=70&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=80&w=70" alt="">
              </div>
              <div class="main__crossing-current">
                <p class="main__crossing-upper">
                  AÑADE TU BANCO
                </p>
                <h3 class="main__crossing-heading">
                  REGISTRAR BANCOS
                </h3>
              </div>
            </div>

            <!-- DISCOVER -->
            <div class="main__discover" style="">

              <div class="main__discover-heading-container">
                <h3 class="main__discover-heading ss-heading">VENDER TOKENS</h3>
                <a href="#" class="ss-show">Ver Todas las Plataformas</a>
              </div>
              <div style="overflow-y: scroll; height: 200px;">
                <?php
                // Asumiendo que $userId es el ID del usuario logueado
                $stmt = $conn->prepare("SELECT retiros.valor_retirar, retiros.identificador_transaccion, retiros.fecha_hora, retiros.estado, bancos_usuarios.nombre_banco, bancos_usuarios.tipo_cuenta FROM retiros INNER JOIN bancos_usuarios ON retiros.banco_id = bancos_usuarios.banco_id WHERE retiros.user_id = ? ORDER BY retiros.fecha_hora DESC");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                  echo "<div>";
                  echo "<p>Banco: " . htmlspecialchars($row['nombre_banco'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Tipo de Cuenta: " . htmlspecialchars($row['tipo_cuenta'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Monto: " . htmlspecialchars($row['valor_retirar'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Identificador Transacción: " . htmlspecialchars($row['identificador_transaccion'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "<p>Estado: " . htmlspecialchars($row['estado'], ENT_QUOTES, 'UTF-8') . "</p>"; // Agrega esta línea para mostrar el estado
                  echo "<p>Fecha: " . htmlspecialchars($row['fecha_hora'], ENT_QUOTES, 'UTF-8') . "</p>";
                  echo "</div>";
                }
                $stmt->close();
                ?>
              </div>



            </div>

            <!-- FOOTER -->
            <footer class="main__footer">

              <a href="#" class="main__footer-more ss-show">Leer normativa de www.tokenautas.com <span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </span></a>

              <div class="main__info">
                <a href="https://twitter.com/AbubakerSaeed96/status/1329417170368016385" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                  </svg>
                </a>
                <a href="https://github.com/AbubakerSaeed/dashboard-ui-n20" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                  </svg>
                </a>
                <a href="https://dribbble.com/shots/14615615-Dashboard-UI" target="_blank" rel="noreferrer noopener" class="main__info-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path>
                  </svg>
                </a>

                <p class="main__cp" style="font-size: 1.4rem; text-align: center; ">
                  Copyright &copy; <a href="https://twitter.com/AbubakerSaeed96" target="_blank" rel="noreferrer noopener" class="main__info-link" style="border-bottom: 1px solid  hsla(270, 10%, 50%, .4);">2024 by</a>
                </p>

                <p class="main__cr">
                  <a href="https://activosdigitales.com.co" target="_blank" rel="noreferrer noopener">
                    <img src="./img/logoCompletoBlanco.png" alt="" height="80rem">
                  </a>
                </p>
              </div>

            </footer>

          </div>

        </main>












      </div>







    </div>

  </main>












  </div>






  </div>

  </main>
  <!--=============== ....=============-->
  <!--=============== ....=============-->
  <!--=============== ....=============-->


  <!--=============== MAIN JS ===============-->

  <script>
    function mostrarSeccion(seccionId) {
      // Ocultar todas las secciones
      document.querySelectorAll('.section').forEach(function(section) {
        section.style.display = 'none';
      });

      // Mostrar la sección solicitada
      document.getElementById(seccionId).style.display = 'block';
    }
  </script>





  <script>
    /*=============== SHOW SIDEBAR ===============*/
    const showSidebar = (toggleId, sidebarId, mainId) => {
      const toggle = document.getElementById(toggleId),
        sidebar = document.getElementById(sidebarId),
        main = document.getElementById(mainId)

      if (toggle && sidebar && main) {
        toggle.addEventListener('click', () => {
          /* Show sidebar */
          sidebar.classList.toggle('show-sidebar')
          /* Add padding main */
          main.classList.toggle('main-pd')
        })
      }
    }
    showSidebar('header-toggle', 'sidebar', 'main')

    /*=============== LINK ACTIVE ===============*/
    const sidebarLink = document.querySelectorAll('.sidebar__link')

    function linkColor() {
      sidebarLink.forEach(l => l.classList.remove('active-link'))
      this.classList.add('active-link')
    }

    sidebarLink.forEach(l => l.addEventListener('click', linkColor))
  </script>


  <!-- JavaScript para cambiar el color del botón y generar retiro -->
  <script>
    function cambiarBotonRetirar(select) {
      if (select.value !== "") {
        document.getElementById('boton_retirar').style.backgroundColor = 'green';
      } else {
        document.getElementById('boton_retirar').style.backgroundColor = 'red';
      }
    }

    function generarRetiro() {
      var bancoSeleccionado = document.getElementById('banco_seleccionado').value;
      var cantidadRetirar = document.getElementById('cantidad_retirar').value;
      if (bancoSeleccionado === "" || cantidadRetirar === "") {
        alert("Por favor, selecciona un banco y especifica la cantidad a retirar.");
        return;
      }
      var identificador = 'TKT-' + Math.random().toString(36).substr(2, 9) + '#' + Math.random().toString(36).substr(2, 9);
      document.getElementById('identificador_transaccion').value = identificador;

      // Muestra un alerta con el identificador único
      alert("Tu orden fue generada con el ticket#: " + identificador);

      // Envía el formulario
      document.getElementById('formRetiro').submit();
    }
  </script>




  <script src="../Assets/js/main.js"></script>
  <script src="../app.js"></script>






















































































































































</body>

</html>