<?php

require_once 'includes/funciones.php';

if (estaLogueado()){
    header('Location: ' . BASE_URL . 'index.php?modulo=dashbd');
    exit;
}
if (isset($_SESSION['error_login'])) {
    echo "<div class='error'>" . $_SESSION['error_login'] ."</div>";
    unset($_SESSION['error_login']);
}
?>




<form action="<?php echo BASE_URL;?>procesadores/procesar_login.php" method="POST" class="form-login">
    <h2 class="t-2">Iniciar Seción</h2>
    <div class="d-login">
        <label for="email">Correo Electronico</label>
        <input name ="email" type="text" class="in-form" placeholder="Correo">
        
        <label for="password">Contraseña</label>
        <input  name="password" type="password" class="in-form" placeholder="Contraseña">

        <input type="submit" class="registrar" value="Ingresar">
    </div>
</form>