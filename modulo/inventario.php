<?php
    require_once 'includes/funciones.php';
    requireLogin();
   

    $tipos = $pdo->query("SELECT id, tipo_repuesto FROM tipos_repuesto ORDER BY tipo_repuesto")->fetchAll(PDO::FETCH_ASSOC);
    $marcas = $pdo->query("SELECT id, marca FROM marcas ORDER BY marca")->fetchAll(PDO::FETCH_ASSOC);
   // $modelos = $pdo->query("SELECT id, marca_id, modelo FROM modelos ORDER BY modelo")->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="contenedor">
     <?php include 'includes/mensaje.php'; ?>
    <form action="<?php echo BASE_URL; ?>procesadores/procesar_nuevo_insumo.php" class="new-insumo" method="POST">
        <h2 class="t-2">Agregar Insumo al Inventario</h2>
        <div class="d-insumo">

            <label for="tipo_repuesto_id">Tipo de Repuesto</label>
            <select name="tipo_repuesto_id" id="" class="sl-opt" required>
                <option value="">Seleccionar</option>
                <?php foreach ($tipos as $tipo_repuesto): ?>
                    <option value="<?= $tipo_repuesto['id']; ?>"><?= htmlspecialchars($tipo_repuesto['tipo_repuesto']);?></option>
                    <?php endforeach; ?>
            </select>

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



            <label for="descripcion">Agregue una pequeña descripcion</label>
            <input name="descripcion" type="text" class="in-form" placeholder="Describa el insumo">

            <label for="stock">Stock / Cantidad</label>
            <input name="stock" type="number" min="0" class="in-form" placeholder="Introdusca aqui la cantidad" required>

            <label for="precio_compra">Precio de Compra</label>
            <input name="precio_compra" type="number" step="0.01" min="0" class="in-form" placeholder="">

            <label for="precio_venta">Precio de Venta</label>
            <input name="precio_venta" type="number" step="0.01" min="0" class="in-form" placeholder="">

            <input type="submit" class="registrar" value="Guardar Insumo">
        </div>
    </form>
    <div class="add_new_tmm">
        <h2 class="t-2"></h2>
        <a href="index.php?modulo=tipo_repuesto" class="add_new">Nuevo Tipo de Insumo</a>
        <a href="index.php?modulo=marca" class="add_new">Nueva Marca</a>
        <a href="index.php?modulo=modelo" class="add_new">Nuevo Modelo</a>
    </div>
</div>

<script src="<?php echo BASE_URL; ?>includes/scripts/filtrar_modelo.js"></script>
