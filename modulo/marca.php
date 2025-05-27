<?php
    require_once 'includes/funciones.php';
    requireLogin();
   
?>

<div class="contenedor">
    <?php include 'includes/mensaje.php'; ?>
    <form action="<?php echo BASE_URL;?>procesadores/procesar_marca.php" class="new-marca" method="POST">
        <h2 class="t-2">Nombre de la marca</h2>
        <div class="d-marca">
            <label for="marca">Marca</label>
            <input name="marca" type="text" class="in-form">
            <input type="submit" class="registrar" value="Agregar Marca">
        </div>
    </form>
</div>