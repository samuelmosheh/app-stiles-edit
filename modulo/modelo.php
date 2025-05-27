<?php
    require_once 'includes/funciones.php';
    requireLogin();
   $stmt = $pdo->query("SELECT * FROM marcas ORDER BY marca");
   $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="contenedor">
        <?php include 'includes/mensaje.php'; ?>
    <form action="<?php echo BASE_URL; ?>procesadores/procesar_modelo.php" class="new-model" method="POST">
        <h2 class="t-2">Agregar Modelo</h2>
        <div class="d-model">

            <label for="marca_id">Seleccione una Marca</label>
            
            <select name="marca_id" id="" class="sl-opt" required>
                <option value="">Seleccionar</option>
                <?php foreach ($marcas as $marca): ?>
                <option value="<?= $marca['id'];?>"><?= htmlspecialchars($marca['marca']); ?></option>
                <?php endforeach;?>
            </select>

            <label for="modelo">Nombre del Modelo</label>
            <input name="modelo" type="text" class="in-form" palceholder="ingrese el modelo">
            <input type="submit" class="registrar" value="Agregar Modelo">
        </div>
    </form>
</div>