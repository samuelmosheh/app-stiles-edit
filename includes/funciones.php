<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//verificar que el usuario esta logueado
function estaLogueado(){
    return isset($_SESSION['logueado']) && $_SESSION['logueado'] === true;
}

//redirige al login si no esta logueado
function requireLogin(){
    if (!estaLogueado()) {
        header('Location: ' . BASE_URL . 'index.php?modulo=login');
        exit;
    }
}

// verifica el que rol tiene el usuario

function requireRole($rol){
    if (!isset($_SESSION['usuario_rol']) ||$_SESSION['usuario_rol'] == $rol) {
        header('Location: ' . BASE_URL . 'index.php?modulo=dashbd');
        exit;
    }
}




?>