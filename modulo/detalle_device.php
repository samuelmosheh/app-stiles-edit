<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
   
    //require_once '../config/config.php';
    //require_once '../includes/funciones.php';

    requireLogin();

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error'] = 'ID de dispositivo inválido.';
        header('Location: ' . BASE_URL . 'index.php?modulo=ver_devices');
        exit;
    }

    $id = (int)$_GET['id'];
  
    //  Obtener informacion del dispositivo

    try {
    
        $sql = "SELECT d.*, c.nombre AS cliente_nombre,
                m.marca AS nombre_marca,
                mo.modelo AS nombre_modelo,
                u.nombre AS usuario_nombre
                FROM dispositivos d
                JOIN clientes c ON d.cliente_id = c.id
                JOIN marcas m ON d.marca_id = m.id
                JOIN modelos mo ON d.modelo_id = mo.id
                LEFT JOIN usuarios u ON d.creado_por = u.id
                WHERE d.id = :id
                LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $d = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$d) {
            $_SESSION['error'] = "Dispositivo no encontrado.";
            header('Location: ' . BASE_URL . 'index.php?modulo=ver_devices');
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al actualizar estado: ' . $e->getMessage();
        header('Location: ' . BASE_URL . 'index.php?modulo=ver_device');
        exit;
    }

?>

<div class="contenedor">
     <?php include_once 'includes/mensaje.php'; ?>
     <h2 class="t-2">Detalle del Dispositivo</h2>


    <div class="list-devices" id="list-devices">
            <div class="card-device">
                <h3 class="t-c-name"> <?= htmlspecialchars($d['cliente_nombre']) ?> </h3>
                <p><strong>Marca:</strong> <?= htmlspecialchars($d['nombre_marca']) ?></p>
                <p><strong>Modelo:</strong> <?= htmlspecialchars($d['nombre_modelo']) ?></p>
                <p><strong>IMEI / Serie:</strong> <?= htmlspecialchars($d['imei_serie']) ?></p>
                <p><strong>Falla Reportada:</strong> <?= htmlspecialchars($d['falla_report']) ?></p>
                <p><strong>estado:</strong> 
                    <span class="<?= str_replace(' ', '-', $d['estado']) ?>">
                    <?= htmlspecialchars($d['estado']) ?>
                    </span>
                </p>
                <p><strong>Ingreso:</strong> <?= htmlspecialchars($d['fecha_ingreso']) ?></p>
                <p><strong>Entrega:</strong> <?= htmlspecialchars($d['fecha_entrega']) ?></p>
                <p><strong>Registrado por:</strong> <?= htmlspecialchars($d['usuario_nombre'] ?? 'desconocido') ?></p>
                <p><strong>Cobro:</strong> <?= number_format($d['cobro_total'], 0, ',', '.') ?></p>
            </div>
            <form action="<?php echo BASE_URL;?>procesadores/procesar_cambio_estado.php" method="POST" class="update-estado">
                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                <label for="nuevo_estado">Cambiar Estado</label>
                <select name="nuevo_estado" id="nuevo_estado" class="sl-opt">
                    <option value="" <?= $d['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="en proceso" <?= $d['estado'] == 'en proceso' ? 'selected' : '' ?>>En Proceso</option>
                    <option value="listo" <?= $d['estado'] == 'listo' ? 'selected' : '' ?>>Listo</option>
                    <option value="entregado" <?= $d['estado'] == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                    <option value="devuelto" <?= $d['estado'] == 'devuelto' ? 'selected' : '' ?>>Devuelto</option>
                </select>
                <input type="submit" value="Cambiar" class="registrar">
            </form>
            
    </div>
</div>