<?php

    require_once 'includes/funciones.php';
    requireLogin();

 
?>

<div class="contenedor">
        <!--- Mostrar mensaje de error -->
        <?php include 'includes/mensaje.php'; ?>


        <!-----  Formulario nuevo usuario   --->

        <form action="<?php echo BASE_URL; ?>procesadores/crear_usuario.php" method="POST" class="new-user">
            <h2 class="t-2">Nuevo Usuario</h2>
            
            <div class="d-trabajador">
                <label for="nombre">Nombre</label>
                <input name="nombre" type="text" class="in-form" required>

                <label for="email">Correo electronico</label>
                <input name="email" type="email" class="in-form" required>

                <label for="password">Contraseña</label>
                <input name="password" type="password" class="in-form" required>
                
                <select class="sl-opt" name="rol" id="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="tecnico">Técnico</option>
                    <option value="recepcionista">recepcionista</option>
                </select>

                <input type="submit" value="Registrar" class="registrar">
            </div>
        </form>
        <?php
            include 'usuarios_creados.php';
        ?>
</div>