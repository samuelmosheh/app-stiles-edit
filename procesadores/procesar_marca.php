<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);    


    include_once '../config/config.php';
    include_once '../includes/funciones.php';

    requireLogin();

    if (isset($_POST['marca'])) {
        $marca = trim($_POST['marca']);

        if (empty($marca)) {
            $_SESSION['error'] = 'El campo no debe estar vacio.';
            header('Location: ' . BASE_URL . 'index.php?modulo=marca');
            exit;
        }
        if (strlen($marca) < 3) {
            $_SESSION['error'] = 'El nombre no debe ser menor de 3 caracteres.';
            header('Location: ' . BASE_URL . 'index.php?modulo=marca');
            exit;
        }  

        $stmt = $pdo->prepare("INSERT INTO marcas(marca) 
                                VALUES (:marca)");

        $ejecutado = $stmt->execute([':marca' => $marca]);

        if ($ejecutado) {
            $_SESSION['exito'] = 'Marca creada exitosamente';
            header('Location: ' . BASE_URL . 'index.php?modulo=modelo');
            exit;
        } else {
            $_SESSION['error'] = 'Error al crear la marca.';
            header('Location: ' . BASE_URL . 'index.php?modulo=marca');
            exit;
        }

    } else {
        $_SESSION['error'] = 'El nombre de la marca no debe estar vacio.';
            header('Location: ' . BASE_URL . 'index.php?modulo=marca');
            exit;
    }


?>