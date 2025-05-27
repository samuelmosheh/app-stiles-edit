<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once '../config/config.php';
    include_once '../includes/funciones.php';

    

    requireLogin();
    

    if (isset($_POST['tipo_repuesto_id'], $_POST['marca_id'],
        $_POST['modelo_id'], $_POST['descripcion'], $_POST['stock'],
        $_POST['precio_compra'], $_POST['precio_venta'])) {
        
        $tipo = (int) $_POST['tipo_repuesto_id'];
        $marca = (int) $_POST['marca_id'];
        $modelo = (int) $_POST['modelo_id'];
        $descripcion = trim($_POST['descripcion']);
        $stock = (int) $_POST['stock'];
        $precio_compra = floatval($_POST['precio_compra']);
        $precio_venta = floatval($_POST['precio_venta']);
        $agregado_por = $_SESSION['usuario_id'];
        $fecha = date("Y-m-d H:i:s");

        if (empty($tipo) || empty($marca) || empty($modelo)|| empty($descripcion)|| empty($stock)|| 
            empty($precio_compra)|| empty($precio_venta)) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: ' . BASE_URL . 'index.php?modulo=inventario');
            exit();
        }
        
        $stmt = $pdo->prepare("INSERT INTO inventario(tipo_repuesto_id, marca_id, modelo_id, descripcion, stock, precio_compra, precio_venta, fecha_ingreso, agregado_por)
                  VALUES (:tipo, :marca, :modelo, :descripcion, :stock, :precio_compra, :precio_venta, :fecha, :agregado_por)");
        
        $ejecutado = $stmt->execute([
            ':tipo' => $tipo,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':descripcion' => $descripcion,
            ':stock' => $stock,
            ':precio_compra' => $precio_compra,
            ':precio_venta' => $precio_venta,
            ':fecha' => $fecha,
            ':agregado_por' => $agregado_por
        ]);
        if ($ejecutado) {
            $_SESSION['exito'] = 'Insumo agregado Correctamente.';
            header('Location: ' . BASE_URL . 'index.php?modulo=inventario');
            exit;
        } else {
            $_SESSION['error'] = 'Error al agregar el insumo.';
            header('Location: ' . BASE_URL . 'index.php?modulo=inventario');
            exit;
        }


    } else {
         $_SESSION['error'] = 'Todos los campos son obligatorios.';
        header('Location: ' . BASE_URL . 'index.php?modulo=inventario');
        exit;
    }










?>