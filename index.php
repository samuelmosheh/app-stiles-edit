<?php

include 'config/config.php';
include 'includes/header.php';
include 'includes/menu.php';

    //inicia la sesion si aun no hay una iniciada

    $modulo = isset($_GET['modulo']) ? $_GET['modulo'] : 'dashbd';
    $modulo = basename($modulo);
    $ruta = "modulo/{$modulo}.php";

    if (file_exists($ruta)) {
        include $ruta;

    } else {
        echo "<p>Modulo no encontrado.</p>";
    }

    include 'includes/footer.php';
?>