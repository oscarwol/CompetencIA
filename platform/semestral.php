<?php
session_start();

if  (! isset($_SESSION['user_email'])) {
    header("Location: login.php");
    die();
  }

if (isset($_SESSION['ultima_act']) && isset($_SESSION['datos_marcas']) && isset($_SESSION['datos_clientes']) && isset($_SESSION['datos_categorias'])) {
    $datos_clientes = $_SESSION['datos_clientes'];
    $datos_anunciantes = $_SESSION['datos_anunciantes'];
    $datos_marcas = $_SESSION['datos_marcas'];
    $datos_categorias = $_SESSION['datos_categorias'];
    $datos_productos = $_SESSION['datos_productos'];
    $datos_version = $_SESSION['datos_version'];
    $datos_tipodemedio = $_SESSION['datos_tipodemedio'];
    $datos_medios = $_SESSION['datos_medios'];
    $ultima_act = $_SESSION['ultima_act'];
} else {
    header("Location: adatos.php");
    die();
}



?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js "></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css " rel="stylesheet">
    <!-- Title Page-->
    <title>Generar Reporte Semestral - CompetencIA</title>

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
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="text-align: center" role="document">
            <br>
            <br>
            <h1>Generando Reporte...</h1>
            <br>
            <br>
            <div class="progress mb-3">
                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
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
                        <li class="">
                            <a href="/rdiario.php">
                                <i class="fas fa-table"></i>Reporte Mensual</a>
                        </li>
                        <li class="">
                            <a href="/quarter.php">
                                <i class="fas fa-table"></i>Reporte Cuatrimestral</a>
                        </li>
                        <li class="active">
                            <a href="">
                                <i class="fas fa-table"></i>Reporte Semestral</a>
                        </li>
                        <li>
                            <a href="/adatos.php">
                                <i class="fas fa-refresh"></i>Actualizar Datos</a>
                        </li>
                        <li>
                            <a href="/login.php?user_email_logout">
                                <i class="fas fa-power-off"></i>Cerrar Sesión</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                if ($ultima_act != false) {
                                    echo "<div class='alert alert-dark' role='alert'>
       Última actualización de datos: <strong> $ultima_act </strong>
    </div>";
                                } else {
                                    echo "<div class='alert alert-danger' role='alert'>
        Estado del sistema: 🔴 Inactivo, por favor no uses la plataforma y escribe a soporte@wol.group
    </div>";
                                    $data = false;
                                }
                                ?>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Generacion de Reportes</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" id="excelForm" method="post" class="form-horizontal">

                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Cliente:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select required name="cliente" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todos los clientes</option>
                                                        <?php foreach ($datos_clientes as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                            </div>



                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Categoría:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="categoria" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todas las Categorías</option>
                                                        <?php foreach ($datos_categorias as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Anunciante:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="anunciante" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todos los anunciantes</option>
                                                        <?php foreach ($datos_anunciantes as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Marca:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="marca" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todas las marcas</option>
                                                        <?php foreach ($datos_marcas as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Producto:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="producto" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todos los Productos</option>

                                                        <?php foreach ($datos_productos as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Tipo de medio:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="tipodemedio" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todos los tipos de medios</option>

                                                        <?php foreach ($datos_tipodemedio as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Medio:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="medio" class="selectpicker" data-live-search="true">
                                                        <option selected value="">Todos los medios</option>

                                                        <?php foreach ($datos_medios as $opcion) { ?>
                                                            <option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>





                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Mes de reporte:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="fecha_inicio_semestral" class="selectpicker" required>
                                                        <option selected value="">Todos los Semestres (6 meses):</option>
                                                        <option value="1">Semestre 1</option>
                                                        <option value="2">Semestre 2</option>
                                                    </select>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="selectSm" class=" form-control-label">Año de reporte:</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="fecha_inicio_anio" class="selectpicker" required>
                                                        <option selected value="">Todos los años</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                    </select>
                                                    </select>

                                                
                                                </div>
                                            </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-dark btn-lg">
                                            <i class="fa fa-dot-circle-o"></i> Generar Reporte
                                        </button>
                                    </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                        <!-- HEADER DESKTOP-->



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
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>

    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>




</body>

<script>
    $('#excelForm').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario normal
        var formData = new FormData(this); // crear un objeto FormData con los datos del formulario
        enviarInfo(formData); // llamar a la función enviarPDF con el objeto FormData
    });

    function enviarInfo(formData) {
        $('#mediumModal').modal('show');
        $('.page-wrapper').addClass('blur-effect');
        $.ajax({
            //dev: 
            //url: 'http://localhost/backend/excel',
            
            url: 'https://cia.informesgrupowol.com/backend/excel',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhrFields: {
                responseType: 'blob' // Especifica que la respuesta será un objeto Blob
            },
            success: function(data, textStatus, xhr) {
                var filename = '';
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) {
                        filename = matches[1].replace(/['"]/g, '');
                    }
                }
                console.log(disposition);
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                var today = new Date();
                var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                a.download = filename !== '' ? filename : 'reporte_competencia_' + date + '.xlsx';
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

                swal.fire("¡Reporte Generado!", "El reporte se generó exitosamente y se descargó como un archivo de Excel (xlsx)<br><br> Nombre:  <strong>" + 'reporte_competencia_' + date + '.xlsx</strong>', "success");
            },
            error: function(jqXHR, textStatus, errorMessage) {
                swal.fire("Error al generar reporte", "No se encontraron datos para generar este reporte", "error");
            },
            complete: function() {
                // Elimina el efecto de desenfoque de la página
                $('.page-wrapper').removeClass('blur-effect');
                $('#mediumModal').modal('hide');
            }
        });
    }
</script>

<style>
    .blur-effect {
        filter: blur(5px);
        /* Aplica el desenfoque */
        pointer-events: none;
        /* Evita que los elementos sean interactivos */
    }
</style>

</body>

</html>

</html>
<!-- end document-->