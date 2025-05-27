<?php
    // Incluimos la conecxion 

    require_once '../config/config.php';

    // Incluimos funciones
    require_once '../includes/funciones.php';

    // Verificamos que se hayas enviado el formulario correctamente

    if (isset($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['rol'])) {
        

        // obtenemos los datos del formulario

        $nombre = trim($_POST['nombre']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $rol = $_POST['rol'];   // admin, tecnico  etc 
        $fechareg = date("Y-m-d H:i:s");

          //validacion no campos vacios
          if (empty($nombre) || empty($email) || empty($password) || empty($rol) ) {
            $_SESSION['error'] = '<p>Todos los campos son obligatorios.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit();
        }
        
        if (strlen($nombre) < 3) {
            $_SESSION['error'] = '<p>El nombre es muy corto.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit();
            
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = '<p>Correo electronico no valido.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit();
            
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[\W]/', $password)) {
            $_SESSION['error'] = '<p>La contraseña debe tener al menos un caracter en mayusculas y un simbolo.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit();
            
        }


        //verificamos si el correo ya existe 

        $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->execute(['email']);
        $resultado = $check->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $_SESSION['error'] = '<p>Ya, existe un usuario con ese correo.</p>';
            header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
            exit;
        }

        //encriptacion de la contraseña 

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //insertas nuevo usuario

        $stmt = $pdo->prepare("INSERT INTO usuarios(nombre, email, password, rol, fecha_registro) 
        VALUES (:nombre, :email, :password, :rol, :fecha)");
       
        $ejecutado = $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':password' => $passwordHash,
            ':rol' => $rol,
            ':fecha' => $fechareg
        ]);

        if ($ejecutado) {
            $_SESSION['exito'] = '<p>Usuario creado Correctamente.</p>';
        } else {
            $_SESSION['error'] = '<p>Error al crear el usuario</p>';
        }

        header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
    } else {
        $_SESSION['error'] = 'Faltan datos en el formulario';
        header('Location: ' . BASE_URL . 'index.php?modulo=usuarios');
        exit;
    }

?>