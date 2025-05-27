<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);    

    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();

    //verificar id del usuario

    if (!isset($_SESSION['usuario_id'])) {
        $_SESSION['error'] = "Debe iniciar sesión para registrar un cliente y tener permisos de administrador,";
        header('Location: ' . BASE_URL . 'index.php?modulo=login');
        exit;
    }

    // verificar que se esten enviando los datos correctamente
    if (isset($_POST['nombre'], $_POST['rut'], $_POST['telefono'], $_POST['email'])) {

        //obtenemos los datos del formulario
        $nombre = trim($_POST['nombre']);
        $rut = trim($_POST['rut']);
        $telefono = trim($_POST['telefono']);
        $email = trim($_POST['email']);
        $creado_por = $_SESSION['usuario_id'];
        $fechareg = date("Y-m-d H.i:s");


        //Validacion no campos vacios
        if (empty($nombre) || empty($rut) || empty($telefono) || empty($email)) {
            $_SESSION['error'] = 'Todos los Campos son obligatorios.';
            header('Location: ' . BASE_URL . 'index.php?modulo=clientes');
            exit;
        }
        if (strlen($nombre) <3) {
            $_SESSION['error'] = 'El nombre es muy corto.';
            header('Location: ' . BASE_URL . 'index.php?modulo=clientes');
            exit;
        }
        try {
            //$pdo = conectar();

            //Verificar ue el Rut o email no existen e la base de datos
            $stmt = $pdo->prepare("SELECT id FROM clientes WHERE rut = :rut OR email = :email");
            $stmt->execute(['rut' => $rut, 'email' => $email]);

            if ($stmt->fetch()) {
                $_SESSION['error'] = "Ya existe un Cliente con los mismos datos, Verfique el Rut y el Correo.";
                header('Location: ' . BASE_URL . 'index.php?modulo=clientes');
                exit;
            }
            //insertar Cliente
            $insert = $pdo->prepare("INSERT INTO clientes (nombre, rut ,telefono, email, creado_por, fecha_registro) 
            VALUES (:nombre, :rut, :telefono, :email, :creado_por, :fecha_registro)");

            $insert->execute([
                ':nombre' => $nombre,
                ':rut' => $rut,
                ':telefono' => $telefono,
                ':email' => $email,
                ':creado_por' => $creado_por,
                ':fecha_registro' => $fechareg
            
            ]);

            //obtener el ID del cliente recien Registrado
            $cliente_id = $pdo->lastInsertId();

            $_SESSION['exito'] = "Cliente registrado correctamente.";
            header('Location: ' . BASE_URL . 'index.php?modulo=dispositivos&cliente_id=' . urlencode($cliente_id));
            exit;
        }catch (PDOException $e) {
            $_SESSION['error'] = "Error al registrar el Cliente: " . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?modulo=clientes');
            exit;
        }

    } else{
        $_SESSION['error'] = 'Faltan datos en el formulario';
        header('Location: ' . BASE_URL . 'index.php?modulo=clientes');
        exit;
    }

    
?>