<?php
    include_once '../config/config.php';
    include_once '../includes/funciones.php';

    requireLogin();

    if (isset($_POST['tipo_repuesto'])) {
        $tipo_repuesto = trim($_POST['tipo_repuesto']);

        if (empty($tipo_repuesto)) {
            $_SESSION['error'] = 'El campo no debe estar vacio.';
            header('Location: ' . BASE_URL . 'index.php?modulo=tipo_repuesto');
            exit;
        }
        if (strlen($tipo_repuesto) < 3) {
            $_SESSION['error'] = 'El nombre no debe ser menor de 3 caracteres.';
            header('Location: ' . BASE_URL . 'index.php?modulo=tipo_repuesto');
            exit;
        }  

        $stmt = $pdo->prepare("INSERT INTO tipos_repuesto(tipo_repuesto) 
                                VALUES (:tipo_repuesto)");

        $ejecutado = $stmt->execute([':tipo_repuesto' => $tipo_repuesto]);

        if ($ejecutado) {
            $_SESSION['exito'] = 'Tipo de repuesto creado exitosamente';
            header('Location: ' . BASE_URL . 'index.php?modulo=tipo_repuesto');
            exit;
        } else {
            $_SESSION['error'] = 'Error al crear el tipo de repuesto.';
            header('Location: ' . BASE_URL . 'index.php?modulo=tipo_repuesto');
            exit;
        }

    } else {
        $_SESSION['error'] = 'El tipo de repuesto no debe estar vacio.';
            header('Location: ' . BASE_URL . 'index.php?modulo=tipo_repuesto');
            exit;
    }




?>