<?php
    require_once 'includes/funciones.php';
    requireLogin();
    

?>

<div class="contenedor">
            <!------ mostrar mensajes  ------>
            <?php include 'includes/mensaje.php';  ?>
            <!------ Formulario nuevo cliente  ------>
    <form action="<?php echo BASE_URL;?>procesadores/crear_cliente.php" method="POST" class="new-client">
        <h2 class="t-2">Datos de Cliente</h2>

        <div class="d-client">
            <label for="nombre">Nombre Completo</label>
            <input name="nombre" class="in-form" type="text" placeholder="Nombre">

            <label for="rut">Numero de Documento</label>
            <input name="rut" class="in-form" type="text" placeholder="Documento-Rut">

            <label for="telefono">Telefono de Contacto</label>
            <input name="telefono" class="in-form" type="text" placeholder="Telefono">

            <label for="email">Correo Electronico</label>
            <input name="email" class="in-form" type="email" placeholder="Correo Electronico">


            <input class="registrar" type="submit" value="Crear Cliente">
        </div>
    </form>
</div>