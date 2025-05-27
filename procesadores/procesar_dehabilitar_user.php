<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();

    // valida

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = $_POST['usuario_id'] ?? null;
        $nuevo_estado = $_POST['nuevo_estado'] ?? null;
        $usuario_actual = $_SESSION['usuario_id'] ?? null;


        //Validaciones Basicas
        if (!$usuario_id || !is_numeric($nuevo_estado)) {
            $_SESSION['error'] = 'Datos inválidos para cambiar estado.';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit;
        }
        // Prevenir que un usuario se deshabiliteel usuario a si mismo
        if ($usuario_id == $usuario_actual) {
            $_SESSION['error'] = 'No puedes modificar tu propio estado.';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit;
        }

        try{
            //Actualizar estado
            $stmt = $pdo->prepare("UPDATE usuarios SET activo = ? WHERE id = ?");
            $stmt->execute([$nuevo_estado, $usuario_id]);

            //Mensaje segun estado
            if ($nuevo_estado == 0) {
                $_SESSION['exito'] = 'Usuario deshabilitado correctamente.';
                header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
                exit;

            } else {
                $_SESSION['exito'] = 'Usuario reactivado correctamente.';
                header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
                exit;
            }

        }   catch (PDOException $e){
            $_SESSION['error'] = 'Error al cambiar el estado del usuario: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit;
        }

        header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
        exit;


    }
































?>