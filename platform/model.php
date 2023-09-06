<?php
session_start();

function verificar_login_usuario($email, $pass)
{
    if ($email == "admin" && $pass == "admin") {
        $_SESSION['user_email'] = $_POST["user_email"];
        header("Location: index.php");
        die();
    } else {
        $status = http_response_code(400);
        echo "Fallo en el login "; //Mensaje test, no se registro

    }
}

if (isset($_POST["user_email"]) && isset($_POST["user_pass"])) {
    verificar_login_usuario($_POST["user_email"], $_POST["user_pass"]);
}


?>