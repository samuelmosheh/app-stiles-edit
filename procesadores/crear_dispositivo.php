<?php
    include_once '../config/config.php';
    include_once '../includes/funciones.php';

    requireLogin();

    // Verificar que el usuario esta autenticado
    if (isset($_POST['cliente_id'], $_POST['marca_id'], $_POST['modelo_id'], $_POST['imei_serie'], $_POST['falla_report'], $_POST['fecha_entrega'], $_POST['cobro_total'])) {
        
        $cliente_id = trim($_POST['cliente_id']);
        $marca = trim($_POST['marca_id']);
        $modelo = trim($_POST['modelo_id']);
        $imei_serie = trim($_POST['imei_serie']);
        $falla_report = trim($_POST['falla_report']);
        $fecha_entrega = trim($_POST['fecha_entrega']);
        $cobro_total = trim($_POST['cobro_total']);
        $estado = 'pendiente';
        $creado_por = $_SESSION['usuario_id'];
        $fecha_ingreso = date("Y-m-d H:i:s");

        if (empty($cliente_id) || empty($marca) || empty($modelo) || empty($falla_report) || empty($fecha_entrega) || empty($cobro_total)) {
            $_SESSION['error'] = 'Ingrese los campos obligatoros.';
            header('Location: ' . BASE_URL . 'index.php?modulo=dispositivos&cliente_id=' . urlencode($cliente_id));
            exit;
        }
        try {
            $sql = "INSERT INTO dispositivos (cliente_id, marca_id, modelo_id, imei_serie, falla_report, estado, fecha_ingreso, fecha_entrega, cobro_total, creado_por) 
                                     VALUES (:cliente_id, :marca, :modelo, :imei_serie, :falla_report, :estado, :fecha_ingreso, :fecha_entrega, :cobro_total, :creado_por)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':marca' => $marca,
                ':modelo' => $modelo,   
                ':imei_serie' => $imei_serie,
                ':falla_report' => $falla_report,
                ':estado' => $estado,
                ':fecha_ingreso' => $fecha_ingreso,
                ':fecha_entrega' => $fecha_entrega,
                ':cobro_total' => $cobro_total,
                ':creado_por' => $creado_por
            
            ]);

            unset($_SESSION['cliente_id_actual']);

            $_SESSION['exito'] = "Dispositivo Creado correctamente.";
            header('Location: ' . BASE_URL . 'index.php?modulo=ver_device');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error al registrar el dispositivo:" . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?modulo=dispositivos&cliente_id=' . urlencode($cliente_id));
            exit;
        }
        

    }else {
        $_SESSION['error'] = 'Faltan Datos Necesarios.';
            header('Location: ' . BASE_URL . 'index.php?modulo=dispositivos&cliente_id=' . urlencode($cliente_id));
            exit;
    }






?>