<?php
    require_once '../config/config.php';
    require_once '../includes/funciones.php';
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $busqueda = trim($_POST['busqueda'] ?? '');

        if (empty($busqueda)) {
            $_SESSION['error'] = "Debe ingresar un RUT o correo.";
            header('Location: ' . BASE_URL . 'index.php?modulo=buscar_cliente');
            exit;
        }
        try {

            $stmt = $pdo->prepare("SELECT id FROM clientes WHERE rut = :busqueda OR email = :busqueda LIMIT 1");
            $stmt->execute([':busqueda' => $busqueda]);

            $cliente = $stmt->feTch();

            if ($cliente) {
                $cliente_id = $cliente['id'];
                header('Location: ' . BASE_URL . 'index.php?modulo=dispositivos&cliente_id=' . $cliente_id);
                exit;
            } else {
                $_SESSION['error'] = "Cliente no Encontrado";
                header('Location: ' . BASE_URL . 'index.php?modulo=buscar_cliente');
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error al buscar cliente: " . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?modulo=buscar_cliente');
            exit;
        }

    } else {
        $_SESSION['error'] = "Acceso no permitido.";
        header('Location: ' . BASE_URL . 'index.php?modulo=login');
        exit;
    }

?>  