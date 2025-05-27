<?php

session_start();

require_once '../config/config.php';
require_once '../includes/funciones.php';


//verificar si el formulario fue enviado mediante POST


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Recibir y sanitizar los datos ingresados por el usuario
    $email = trim($_POST['email']);
    $passwordE = $_POST['password'];

    //consulta para obtener al usuairo segun el email ingresado

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    //vericar si el usuario existe
    if ($usuario) {
        if ($usuario['activo'] == 0) {
            $_SESSION['error_login'] = '<p>Tu cuenta está deshabilitada. Contacta con el administrador.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=login');
            exit;
        }
        $hashGuardado = $usuario['password'];

        // Verificar si la contraseña coincida

        if (password_verify($passwordE, $hashGuardado)) {

            //Crear Secion
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            $_SESSION['logueado'] = true;
    
            // Redirigir al dashboard

            header('Location: ' . BASE_URL . 'index.php?modulo=dashbd');
            exit;
        } else {

             //Contraseña Incorrecta
            $_SESSION['error_login'] = "<p>Contraseña Incorrecta.</p>";
            header('Location: ' . BASE_URL . 'index.php?modulo=login');
            exit;

         }
    } else {

        //Usuario no encontrado 
        $_SESSION['error_login'] = "<p>Usuario no encontrado.</p>";
        header('Location: ' . BASE_URL . 'index.php?modulo=login');
        exit;


     }

} else {
    //Acceso indevido al script
    header('Location: ' . BASE_URL . 'index.php?modulo=login');
    exit;
 }

?>