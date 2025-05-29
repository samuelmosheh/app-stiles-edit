<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();

    header('Content-Type: application/json');

    $tipo_id = $_GET['tipo_id'] ?? null;
    $marca_id = $_GET['marca_id'] ?? null;
    $modelo_id = $_GET['modelo_id'] ?? null;

    $query = "SELECT id, descripcion, stock 
    FROM inventario
    WHERE stock > 0";

    $params = [];

    if ($tipo_id) {
        $query .= " AND tipo_repuesto_id = ?";
        $params [] = $tipo_id;
    }
    if ($marca_id) {
        $query .= " AND marca_id = ?";
        $params [] = $marca_id;
    }
     if ($modelo_id) {
        $query .= " AND modelo_id= ?";
        $params [] = $modelo_id;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));






?>