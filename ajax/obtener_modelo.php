<?php
    require_once '../config/config.php';
    require_once '../includes/funciones.php';

    //requireLogin();
    
    //DEFINIR QUE LA RESPUESTA SERA EN FORMATO JSON
    header('Content-Type: application/json');

    //obtener el marca id desde la URL (por GET), y lo canvierte a entero
    $marca_id = isset($_GET['marca_id']) ? intval($_GET['marca_id']) : 0;

   // si el marca_id no es valido (es cero), devuelve array vacio

   if ($marca_id === 0) {
    echo json_encode([]);
    exit;
   }

   // consulta SQL que ubtine los modelos que pertenecen a la marca seleccionada

   $sql = "SELECT id, modelo 
   FROM modelos WHERE marca_id = :marca_id ORDER BY modelo ASC";

   // prepara la consulta
   $stmt = $pdo->prepare($sql);

   // ejecuta la consulta con el marca_id como parametro 
   $stmt->execute([':marca_id' => $marca_id]);

   // obtiene los modelos encontrados como array asociativo
   $modelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // devuelve los resultados cpmo JSON 
   echo json_encode($modelos);


?>