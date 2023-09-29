<?php
session_start();
if (isset($_GET["user_email_logout"])) {
    if (isset($_SESSION['user_email'])) {
        unset($_SESSION['user_email']);
    }
}

if (isset($_SESSION['user_email'])) {
    header("Location: index.php");
    die();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js "></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css " rel="stylesheet">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <div style="text-align: center;">
                                <h3>Bienvenido a CompetencIA</h3>
                            </div>

                            <br>
                            <form id="form">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="text" name="user_email" required placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="user_pass" required placeholder="Password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--blue m-b-20" style="background-color: black;text-align: center;">Ingresar</button>
                                <div class="social-login-content">
                                    <div class="social-button">
                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">Ingresar con tu cuenta de Grupo WOL</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Main JS-->
    <script src="js/main.js"></script>

    <script>
        $("#form").on("submit", function(e) {
            e.preventDefault();
            var response = '';
            const form = $(e.target);
            Swal.fire({
                title: "Cargando",
                html: "Espere un momento...",
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: 'POST',
                url: 'model.php',
                data: $('form').serialize(),
                success: function(data) {
                    Swal.close();
                    swal.fire("¡Iniciando sesión!", "Estamos iniciando sesión en la plataforma", "success");

                    window.location.replace("index.php");
                },

                error: function() {
                    Swal.close();
                    Swal.fire(
                        'Error',
                        'Los datos ingresados no son válidos, intenta nuevamente.',
                        'error',
                    )
                }
            });


        });
    </script>


</body>

</html>
<!-- end document-->