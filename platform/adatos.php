<?php
session_start();

$datos_anunciantes = false;
$datos_marcas = false;
$datos_categorias = false;
$datos_productos = false;
$datos_version = false;
$datos_tipodemedio = false;
$datos_medios = false;
$ultima_act = false;
$data_totales = false;


function ActualizarDatos($force = false)
{
    global $datos_anunciantes;
    global $datos_marcas;
    global $datos_categorias;
    global $datos_productos;
    global $datos_version;
    global $datos_tipodemedio;
    global $datos_medios;
    global $ultima_act;
    global $data_totales;

    if ($force == false) {
        $endpoint = "http://app:7000/backend/totales"; //

        // Realizar solicitud GET al endpoint
        if (isset($_COOKIE['totales'])) {
            $data_totales = json_decode($_COOKIE['totales'], true); // Obtener los datos guardados de la cookie
        } else {
            // Realizar solicitud GET al endpoint
            $response = file_get_contents($endpoint);

            if ($response) {
                $data_totales = json_decode($response, true); // Convertir la respuesta JSON en un arreglo asociativo

                // Guardar los datos en una cookie válida por 1 día
                setcookie('totales', json_encode($data_totales), time() + (24 * 60 * 60));
            } else {
                $data_totales = false;
            }
        }


        if (isset($_SESSION['ultima_act']) && isset($_SESSION['datos_marcas']) && isset($_SESSION['datos_categorias'])) {
            $datos_anunciantes = $_SESSION['datos_anunciantes'];
            $datos_marcas = $_SESSION['datos_marcas'];
            $datos_categorias = $_SESSION['datos_categorias'];
            $datos_productos = $_SESSION['datos_productos'];
            $datos_version = $_SESSION['datos_version'];
            $datos_tipodemedio = $_SESSION['datos_tipodemedio'];
            $datos_medios = $_SESSION['datos_medios'];
            $ultima_act = $_SESSION['ultima_act'];
        } else {
            $anunciante = "http://app:7000/backend/anunciantes";
            $marcas = "http://app:7000/backend/marcas";
            $categos = "http://app:7000/backend/categorias";
            $producto = "http://app:7000/backend/productos"; //
            $version = "http://app:7000/backend/version"; //
            $tipomedio = "http://app:7000/backend/tipomedio"; //
            $medios = "http://app:7000/backend/medios"; //


            // Realizar solicitud GET al endpoint para obtener los datos
            $response_anunciantes = file_get_contents($anunciante);
            $response_marcas = file_get_contents($marcas);
            $response_categos = file_get_contents($categos);
            $response_producto = file_get_contents($producto);
            $response_version = file_get_contents($version);
            $response_tipodemedio = file_get_contents($tipomedio);
            $response_medios = file_get_contents($medios);


            // Verificar si se obtuvo respuesta y decodificar el JSON
            if ($response_anunciantes && $response_marcas && $response_categos && $response_producto && $response_version && $response_tipodemedio && $response_medios) {
                $datos_anunciantes = json_decode($response_anunciantes, true);
                $datos_marcas = json_decode($response_marcas, true);
                $datos_categorias = json_decode($response_categos, true);
                $datos_productos = json_decode($response_producto, true);
                $datos_version = json_decode($response_version, true);
                $datos_tipodemedio = json_decode($response_tipodemedio, true);
                $datos_medios = json_decode($response_medios, true);
                $ultima_act = date('Y-m-d H:i:s');

                // Guardar los datos en la sesión
                $_SESSION['datos_anunciantes'] = $datos_anunciantes;
                $_SESSION['datos_marcas'] = $datos_marcas;
                $_SESSION['datos_categorias'] = $datos_categorias;
                $_SESSION['datos_productos'] = $datos_productos;
                $_SESSION['datos_version'] = $datos_version;
                $_SESSION['datos_tipodemedio'] = $datos_tipodemedio;
                $_SESSION['datos_medios'] = $datos_medios;
                $_SESSION['ultima_act'] = $ultima_act;
            } else {
                $datos_anunciantes = false;
                $datos_marcas = false;
                $datos_categorias = false;
                $datos_productos = false;
                $datos_version = false;
                $datos_tipodemedio = false;
                $datos_medios = false;
                $ultima_act = false;
            }
        }
    } else {
        $anunciante = "http://app:7000/backend/anunciantes";
        $marcas = "http://app:7000/backend/marcas";
        $categos = "http://app:7000/backend/categorias";
        $producto = "http://app:7000/backend/productos"; //
        $version = "http://app:7000/backend/version"; //
        $tipomedio = "http://app:7000/backend/tipomedio"; //
        $medios = "http://app:7000/backend/medios"; //


        // Realizar solicitud GET al endpoint para obtener los datos
        $response_anunciantes = file_get_contents($anunciante);
        $response_marcas = file_get_contents($marcas);
        $response_categos = file_get_contents($categos);
        $response_producto = file_get_contents($producto);
        $response_version = file_get_contents($version);
        $response_tipodemedio = file_get_contents($tipomedio);
        $response_medios = file_get_contents($medios);


        // Verificar si se obtuvo respuesta y decodificar el JSON
        if ($response_anunciantes && $response_marcas && $response_categos && $response_producto && $response_version && $response_tipodemedio && $response_medios) {
            $datos_anunciantes = json_decode($response_anunciantes, true);
            $datos_marcas = json_decode($response_marcas, true);
            $datos_categorias = json_decode($response_categos, true);
            $datos_productos = json_decode($response_producto, true);
            $datos_version = json_decode($response_version, true);
            $datos_tipodemedio = json_decode($response_tipodemedio, true);
            $datos_medios = json_decode($response_medios, true);
            $ultima_act = date('Y-m-d H:i:s');

            // Guardar los datos en la sesión
            $_SESSION['datos_anunciantes'] = $datos_anunciantes;
            $_SESSION['datos_marcas'] = $datos_marcas;
            $_SESSION['datos_categorias'] = $datos_categorias;
            $_SESSION['datos_productos'] = $datos_productos;
            $_SESSION['datos_version'] = $datos_version;
            $_SESSION['datos_tipodemedio'] = $datos_tipodemedio;
            $_SESSION['datos_medios'] = $datos_medios;
            $_SESSION['ultima_act'] = $ultima_act;
        } else {
            $datos_anunciantes = false;
            $datos_marcas = false;
            $datos_categorias = false;
            $datos_productos = false;
            $datos_version = false;
            $datos_tipodemedio = false;
            $datos_medios = false;
            $ultima_act = false;
        }
    }
}


if (isset($_GET['actualizar'])) {
    ActualizarDatos(true);
} else {
    ActualizarDatos();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Inicio - CompetencIA</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="images/icon/logo.png" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>Inicio</a>
                        </li>
                        <li>
                            <a href="chart.html">
                                <i class="fas fa-chart-bar"></i>Gráficas & Estadisticas</a>
                        </li>
                        <li>
                            <a href="table.html">
                                <i class="fas fa-table"></i>Reporte Diario</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>Inicio</a>

                        </li>
                        <li>
                            <a href="/rdiario.php">
                                <i class="fas fa-table"></i>Reporte Diario</a>
                        </li>
                        <li class="active">
                            <a href="/adatos.php">
                                <i class="fas fa-refresh"></i>Actualizar Datos</a>
                        </li>
                        <li>
                            <a href="/login.php">
                                <i class="fas fa-power-off"></i>Cerrar Sesión</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <!-- HEADER DESKTOP-->
                        <div class="col-lg-12">
                            <?php
                            if ($ultima_act != false) {
                                echo "<div class='alert alert-dark' role='alert'>
       Última actualización de datos: <strong> $ultima_act </strong>
    </div>";
                            } else {
                                ActualizarDatos(true);
                            }
                            ?>
                            <div>
                                <a href="/adatos.php?actualizar">
                                    <button id="payment-button" class="btn btn-lg btn-dark btn-block">
                                        <i class="fas fa-refresh"></i>&nbsp;
                                        <span id="payment-button-amount">Actualizar datos</span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                    </button>
                                </a>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Últimos datos registrados:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="custom-tab">

                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link small active" id="custom-nav-home-tab" data-toggle="tab" href="#custom-nav-home" role="tab" aria-controls="custom-nav-home" aria-selected="true">Categorias <span class="badge badge-primary"><?php echo $data_totales['categorias'] ?></span></a>
                                                <a class="nav-item nav-link small" id="custom-nav-profile-tab" data-toggle="tab" href="#custom-nav-profile" role="tab" aria-controls="custom-nav-profile" aria-selected="false">Anunciantes <span class="badge badge-primary"><?php echo $data_totales['anunciantes'] ?></a>
                                                <a class="nav-item nav-link small" id="custom-nav-contact-tab" data-toggle="tab" href="#custom-nav-contact" role="tab" aria-controls="custom-nav-contact" aria-selected="false">Marcas <span class="badge badge-primary"><?php echo $data_totales['marcas'] ?></a>
                                                <a class="nav-item nav-link small" id="custom-nav-productos-tab" data-toggle="tab" href="#custom-nav-productos" role="tab" aria-controls="custom-nav-productos" aria-selected="false">Productos <span class="badge badge-primary"><?php echo $data_totales['productos'] ?></a>
                                                <a class="nav-item nav-link small" id="custom-nav-version-tab" data-toggle="tab" href="#custom-nav-version" role="tab" aria-controls="custom-nav-version" aria-selected="false">Version <span class="badge badge-primary"><?php echo $data_totales['version'] ?></a>
                                                <a class="nav-item nav-link small" id="custom-nav-tmedio-tab" data-toggle="tab" href="#custom-nav-tmedio" role="tab" aria-controls="custom-nav-tmedio" aria-selected="false">Medios <span class="badge badge-primary"><?php echo $data_totales['medios'] ?></a>
                                            </div>
                                        </nav>
                                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="custom-nav-home" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                                <ul>
                                                    <?php foreach ($datos_categorias as $opcion) { ?>
                                                        <ol><?php echo $opcion; ?></ol>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-profile" role="tabpanel" aria-labelledby="custom-nav-profile-tab">
                                                <ul>
                                                    <?php foreach ($datos_anunciantes as $opcion) { ?>
                                                        <ol><?php echo $opcion; ?></ol>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-contact" role="tabpanel" aria-labelledby="custom-nav-contact-tab">
                                                <ul>
                                                    <?php foreach ($datos_marcas as $opcion) { ?>
                                                        <ol><?php echo $opcion; ?></ol>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-productos" role="tabpanel" aria-labelledby="custom-nav-productos-tab">
                                                <ul>
                                                    <?php foreach ($datos_productos as $opcion) { ?>
                                                        <ol><?php echo $opcion; ?></ol>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-version" role="tabpanel" aria-labelledby="custom-nav-version-tab">
                                                <ul>
                                                    <?php foreach ($datos_version as $opcion) { ?>
                                                        <ol><?php echo $opcion; ?></ol>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-tmedio" role="tabpanel" aria-labelledby="custom-nav-tmedio-tab">
                                                <ul>
                                                    <?php foreach ($datos_medios as $opcion) { ?>
                                                        <ol><?php echo $opcion; ?></ol>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

<script>
    $(document).ready(function() {
        $('#excelForm').on('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario normal

            // Enviar la solicitud POST al endpoint
            $.post($(this).attr('action'), $(this).serialize(), function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Descargar el archivo generado
                    window.location.href = response.fileUrl;
                } else {
                    // Mostrar mensaje de error
                    alert('Error al generar el archivo');
                }
            });
        });
    });
</script>
</body>

</html>

</html>
<!-- end document-->