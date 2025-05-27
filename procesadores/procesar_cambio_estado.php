<?php
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();

    // validar que se envio el id

    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        $_SESSION['error'] = 'ID de dispositivo inválido.';
        header('Location: ' . BASE_URL . 'index.php?modulo=ver_devices');
        exit;
    }

    $id = (int)$_POST['id'];

    //Procesar cambio de estado si se envio el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_estado'])) {
        $nuevo_estado = trim($_POST['nuevo_estado']);
        $estados_validos = ['pendiente', 'en proceso', 'listo', 'entregado', 'devuelto'];


        if (in_array($nuevo_estado, $estados_validos)) {
            try {
                $sql_update = "UPDATE dispositivos SET estado = :estado WHERE id = :id";
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->execute([':estado' => $nuevo_estado, ':id' => $id]);

                $_SESSION['exito'] = 'Estado actualizado correctamente.';
                header('Location: ' . BASE_URL . 'index.php?modulo=detalle_device&id=' . $id);
                exit;
            } catch (PDOException $e) {
                $_SESSION['error'] = 'Error al actualizar estado: ' . $e->getMessage();
                header('Location: ' . BASE_URL . 'index.php?modulo=detalle_device&id=' . $id);
                exit;
            }
        } else {
                $_SESSION['error'] = 'Estado inválido.' . $e->getMessage();
                header('Location: ' . BASE_URL . 'index.php?modulo=detalle_device&id=' . $id);
                exit;
        }

    }



?>