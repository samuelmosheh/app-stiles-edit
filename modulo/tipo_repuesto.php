<?php
    require_once 'includes/funciones.php';
    requireLogin();
   

?>
<div class="contenedor">
    <?php include 'includes/mensaje.php'; ?>
    <form action="<?php echo BASE_URL;?>procesadores/procesar_tipo_repuesto.php" class="new-tipo" method="POST">
        <h2 class="t-2">Nombre del tipo de repuesto.</h2>
        <div class="d-tipo-repuesto">
            <label for="tipo_repuesto">Agrega un tipo de repuesto</label>
            <input name="tipo_repuesto" type="text" class="in-form" required>
            <input type="submit" class="registrar" value="Agregar tipo">
        </div>
    </form>
</div>