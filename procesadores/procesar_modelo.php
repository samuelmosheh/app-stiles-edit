<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);    
    
    
    include_once '../config/config.php';
    include_once '../includes/funciones.php';

    requireLogin();

    if (isset($_POST['marca_id'], $_POST['modelo'])) {
        $marca_id = trim($_POST['marca_id']);
        $modelo = trim($_POST['modelo']);

        if (empty($marca_id) || empty($modelo)) {
            $_SESSION['error'] = '<Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . 'index.php?modulo=modelo');
            exit();
        }
        if (strlen($modelo) < 1) {
            $_SESSION['error'] = '<p>El nombre es muy corto.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=modelo');
            exit();
        }
        $stmt = $pdo->prepare("INSERT INTO modelos(marca_id, modelo) 
                                VALUES (:marca_id, :modelo)");
        $ejecutado = $stmt->execute([
            ':marca_id' => $marca_id,
            ':modelo' => $modelo
        ]);
        if ($ejecutado) {
            $_SESSION['exito'] = 'Modelo creado exitosamente';
            header('Location: ' . BASE_URL . 'index.php?modulo=modelo');
            exit;
        } else {
            $_SESSION['error'] = 'Error al crear el modelo.';
            header('Location: ' . BASE_URL . 'index.php?modulo=modelo');
            exit;
        }


    }else {
        $_SESSION['error'] = 'Debe Seleccionar una Marca y Escribir el nombre del modelo.';
        header('Location: ' . BASE_URL . 'index.php?modulo=modelo');
        exit;
    }



?>