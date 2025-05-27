<?php
    require 'config.php';

    if ($pdo) {
        echo "conexión exitosa";
    }else {
        echo "Error al conectar";
    }
?>