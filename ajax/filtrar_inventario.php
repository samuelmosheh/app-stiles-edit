<?php
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();


    $tipo_id = isset($_POST['tipo']) ? (int) $_POST['tipo'] : null;
    $marca_id = isset($_POST['marca']) ? (int) $_POST['marca'] : null;
    $modelo_id = isset($_POST['modelo']) ? (int) $_POST['modelo'] : null;
   

    $sql = "SELECT i.*, m.marca AS nombre_marca, mo.modelo AS nombre_modelo, 
    t.tipo_repuesto AS nombre_tipo
    FROM inventario i
    JOIN marcas m ON i.marca_id = m.id
    JOIN modelos mo ON i.modelo_id = mo.id
    JOIN tipos_repuesto t ON i.tipo_repuesto_id = t.id
    WHERE 1=1";

    $params =[];

    if ($tipo_id) {
        $sql .= " AND i.tipo_repuesto_id = :tipo_id";
        $params[':tipo_id'] = $tipo_id;
    }
    if ($marca_id) {
        $sql .= " AND i.marca_id = :marca_id";
        $params[':marca_id'] = $marca_id;
    }
     if ($modelo_id) {
        $sql .= " AND i.modelo_id = :modelo_id";
        $params[':modelo_id'] = $modelo_id;
    }
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
        exit;
    }

    

    if (count($resultados) === 0) {
        echo '<p>No se econtraron resultados.</p>';
    } else {
        echo '<table class="table-result">';
        echo '<tr><th>Tipo</th><th>Marca</th><th>Modelo</th><th>Descripción</th><th>Stock</th><th>Precio Venta</th></tr>';

        foreach ($resultados as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['nombre_tipo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre_marca']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre_modelo']) . '</td>';
            echo '<td>' . htmlspecialchars($row['descripcion']) . '</td>';
            echo '<td>' . $row['stock'] . '</td>';
            echo '<td>' . number_format($row['precio_venta'], 0, ',', '.') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }


?>