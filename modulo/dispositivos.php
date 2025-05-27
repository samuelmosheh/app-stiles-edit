<?php
    require_once 'includes/funciones.php';
    requireLogin();

    $cliente_id = $_GET['cliente_id'] ?? $_SESSION['cliente_id_actual'] ?? null;

    $stmt = $pdo->query("SELECT * FROM marcas ORDER BY marca");
    $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<div class="contenedor">
    <?php include 'includes/mensaje.php'; ?>

    <form action="<?php echo BASE_URL;?>procesadores/crear_dispositivo.php" method="POST" class="new-mobil">
        <h2 class="t-2">Crear un nuevo dispositivo</h2>
        <div class="d-device">
            <?php if ($cliente_id): ?>
                <input type="hidden" name="cliente_id" value="<?=htmlspecialchars($cliente_id) ?>">
                <?php endif; ?>

            <label for="marca_id">Marca:</label>
            <select name="marca_id" id="marca" class="sl-opt" required>
                <option value="">Seleccione una marca</option>
                <?php foreach ($marcas as $marca): ?>
                    <option value="<?= $marca['id']; ?>"><?= htmlspecialchars($marca['marca']);?></option>
                    <?php endforeach; ?>
            </select>

            <label for="modelo_id">Modelo</label>
            <select name="modelo_id" id="modelo" class="sl-opt" required>
               <option value="">Seleccione un modelo</option>
                
            </select>
            
            <label for="imei_serie">Imei / Serie</label>
            <input name="imei_serie" type="text" class="in-form" placeholder="Numero de Serie">
            
            <label for="falla_report">Falla Reportada</label>
            <textarea name="falla_report" id="" class="text-area" placeholder="Describa la falla reportada."></textarea>
            
            <label for="fecha_entrega">Fecha Estimada de Entrega</label>
            <input type="datetime-local" name="fecha_entrega" class="in-form">

            <label for="cobro_total">Cobro Total (CLP)</label>
            <input name="cobro_total" type="number" step="100" class="in-form" placeholder="Monto Cobrado">
            
            <input type="submit" class="registrar" value="Registrar Dispositivo">
        </div>
        <div class="d-device">
                 <a href="<?php echo BASE_URL;?>index.php?modulo=buscar_cliente" class="btn-add">Agrear a Cliente Existente</a>
           
        </div>
    </form>
</div>

<script src="<?php echo BASE_URL; ?>includes/scripts/filtrar_modelo.js"></script>