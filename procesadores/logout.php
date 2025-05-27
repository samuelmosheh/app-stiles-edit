<?php
    include_once '../config/config.php';
    // Archivo procesar logout
    //este sscrip desrtruye la sesion del usuario y lo redirecciona al login

    session_start();            //Inicia la sesion para poder destruirla.
    session_unset();            //elimina todas las variables de sesion.
    session_destroy();          //Destruye la sesion.

    //Redirige al login de la app.
    header('Location: ' . BASE_URL . 'index.php?modulo=login');
    exit;




?>