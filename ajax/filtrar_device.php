<?php
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();

    
    $estados_validos = ['pendiente', 'en proceso', 'listo', 'entregado', 'devuelto'];
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
    
    $sql = "SELECT d.*, c.nombre AS cliente_nombre,
            m.marca AS nombre_marca,
            mo.modelo AS nombre_modelo
            FROM dispositivos d
            JOIN clientes c ON d.cliente_id = c.id
            LEFT JOIN marcas m ON d.marca_id = m.id
            LEFT JOIN  modelos mo ON d.modelo_id = mo.id
            WHERE 1=1";

    $params = [];


    if (!empty($estado) && in_array($estado, $estados_validos)) {
        $sql .= " AND d.estado = :estado";
        $params[':estado'] = $estado;
    }

    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error de Base de datos: " . $e->getMessage();
        exit;
    }

    if (empty($dispositivos)) {
        echo '<p>No se econtraron dispositivos.</p>';
        exit;
    }
        
    foreach ($dispositivos as $d): 
         ?>
         <div class="card-device">
             <h3 class="t-c-name"> <?= htmlspecialchars($d['cliente_nombre']) ?> </h3>
             <p><strong>Marca:</strong> <?= htmlspecialchars($d['nombre_marca']) ?></p>
             <p><strong>Modelo:</strong> <?= htmlspecialchars($d['nombre_modelo']) ?></p>
             <p><strong>estado:</strong> 
                <span class="<?= str_replace(' ', '-', $d['estado']) ?>">
                <?= htmlspecialchars($d['estado']) ?>
                </span>
            </p>
             <p><strong>Ingreso:</strong> <?= htmlspecialchars($d['fecha_ingreso']) ?></p>
             <p><strong>Cobro:</strong> <?= number_format($d['cobro_total'], 0, ',', '.') ?></p>
             <a href="<?php echo BASE_URL;?>index.php?modulo=detalle_device&id=<?= $d['id'] ?>" class="btn-detalle">Ver Detalle</a>
         </div>
        
        <?php endforeach;

?>
