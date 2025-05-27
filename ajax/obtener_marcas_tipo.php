<?php
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();


    //DEFINIR QUE LA RESPUESTA SERA EN FORMATO JSON
    header('Content-Type: application/json');

    // Obtinene el  tipo_id desde la URL (por GET), y lo convierte a entero
    $tipo_id = isset($_GET['tipo_id']) ? intval($_GET['tipo_id']) : 0;

    //si el tipo_id no es valido (es cero), devuelve un array vacio
    if ($tipo_id === 0) {
        echo json_encode([]);
        exit;
    }

    // Consulta SQL que obtiene todas las marcas distintas 
    // que existen en el inventario para el tipo de repuesto seleccionado
    
    $sql = "SELECT DISTINCT m.id, m.marca FROM inventario i 
    JOIN marcas m ON i.marca_id = m.id 
    WHERE i.tipo_repuesto_id = :tipo_id 
    ORDER BY m.marca ASC";



    //  prepara la consulta para prevenir inyecciones SQL
    $stmt = $pdo->prepare($sql);
    //Ejecuta la consulta con el parametro tipo_id
    $stmt->execute([':tipo_id' => $tipo_id]);
    //Obtiene todos los resultados como un array asociativo
    $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devuelve los datos como JSON
    echo json_encode($marcas);
?>