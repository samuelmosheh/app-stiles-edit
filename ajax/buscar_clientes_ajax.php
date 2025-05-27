<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    requireLogin();

    header('Content-Type: application/json');

    if (!isset($_GET['q'])|| trim($_GET['q']) === '') {
        echo json_encode([]);
        exit;

    }
    try {

        $q = trim($_GET['q']);

        $stmt = $pdo->prepare("SELECT id, nombre, rut, email 
                            FROM clientes WHERE rut 
                            LIKE :q OR email LIKE :q 
                            OR nombre LIKE :q LIMIT 10");

        $stmt->execute([':q' => '%' . $q . '%']);

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultados);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error en base de datos: ' . $e->getMessage()]);
        exit;
    }




?>