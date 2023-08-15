<?php
$endpoint = "http://app:7000/backend/totales"; //

// Realizar solicitud GET al endpoint
if (isset($_COOKIE['totales'])) {
    $data = json_decode($_COOKIE['totales'], true); // Obtener los datos guardados de la cookie
} else {
    // Realizar solicitud GET al endpoint
    $response = file_get_contents($endpoint);

    if ($response) {
        $data = json_decode($response, true); // Convertir la respuesta JSON en un arreglo asociativo

        // Guardar los datos en una cookie válida por 1 día
        setcookie('totales', json_encode($data), time() + (24 * 60 * 60));
    } else {
        $data = false;
    }
}

$top50 = "http://app:7000/backend/etl?page=1&per_page=50"; //

// Realizar solicitud GET al endpoint
$response = file_get_contents($top50);

if ($response) {
    $datos_top_50 = json_decode($response, true); // Convertir la respuesta JSON en un arreglo asociativo
} else {
    $datos_top_50 = false;
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
                        <li class="active has-sub">
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>Inicio</a>

                        </li>
                        <li>
                            <a href="/rdiario.php">
                                <i class="fas fa-table"></i>Reporte Diario</a>
                        </li>
                        <li>
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

            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-12">
                                <?php
                                if ($datos_top_50 != false) {
                                    echo "<div class='alert alert-dark' role='alert'>
        Estado del sistema: 🟢 Activo
    </div>";
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>
        Estado del sistema: 🔴 Inactivo, por favor no uses la plataforma y escribe a soporte@wol.group
    </div>";
    $data = false;
                                }
                                ?>


                                <hr>
                                <br>
                                <div class="overview-wrap">
                                    <h2 class="title-1">Resumen de datos</h2>
                                </div>
                            </div>
                        </div>
                        <?php

                        if ($data) {
                            echo "                        <div class='row m-t-25'>
    <div class='col-sm-6 col-lg-3 '>
        <div class='overview-item overview-item' style='background-color:black'>
            <div class='overview__inner'>
                <div class='overview-box clearfix'>
                    <div class='text'>
                        <h2>" . $data['marcas'] . "</h2>
                        <span>Marcas</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class='col-sm-6 col-lg-3'>
    <div class='overview-item overview-item' style='background-color:black'>
    <div class='overview__inner'>
                <div class='overview-box clearfix'>
                    <div class='text'>
                        <h2>" . $data['categorias'] . "</h2>
                        <span>Categorias</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-sm-6 col-lg-3'>
    <div class='overview-item overview-item' style='background-color:black'>
    <div class='overview__inner'>
                <div class='overview-box clearfix'>
                    <div class='text'>
                        <h2>" . $data['anunciantes'] . "</h2>
                        <span>Anunciantes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-sm-6 col-lg-3'>
    <div class='overview-item overview-item' style='background-color:black'>
    <div class='overview__inner'>
                <div class='overview-box clearfix'>
                    <div class='text'>
                        <h2>" . $data['productos'] . "</h2>
                        <span>Productos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";
                        } else {
                            echo "<p>No hay resultados</p>";
                        }
                        ?>
                        <hr>
                        <br>
                        <div class="row">


                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">Últimos 50 registros de competencia</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Sector</th>
                                                <th>Anunciante</th>
                                                <th>Aviso</th>
                                                <th>Categoria</th>
                                                <th>Marca</th>
                                                <th>Medio</th>
                                                <th>Version</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($datos_top_50 as $item) { ?>
                                                <tr>
                                                    <td><?php echo $item['FECHA']; ?></td>

                                                    <td><?php echo $item['SECTOR']; ?></td>
                                                    <td><?php echo $item['ANUNCIANTE']; ?></td>
                                                    <td><?php echo $item['AVISO']; ?></td>
                                                    <td><?php echo $item['CATEGORIA']; ?></td>
                                                    <td><?php echo $item['MARCA']; ?></td>
                                                    <td><?php echo $item['MEDIO']; ?></td>
                                                    <td><?php echo $item['VERSION']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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

</html>
<!-- end document-->