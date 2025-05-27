<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    require_once 'includes/funciones.php';
    requireLogin();
   

?>
<div class="contenedor">
    <?php  require_once 'includes/mensaje.php'; ?>
    <form class="search-client" method="POST" onsubmit="return false">
        <h2 class="t-2">Buscar Cliente</h2>
        
        <div class="d-search">
            <label for="busqueda">Rut o Correo del cliente</label>
            <input id="busqueda" 
                    name="busqueda" 
                    type="text" 
                    class="in-form" 
                    placeholder="Ej: 12345678-9 o correo@ejemplo.com" 
                    autocomplete="off">
        </div>
        <div id="resultados-clientes" class="autocomplete-results"></div>
    </form>
</div>

<script src="<?php echo BASE_URL; ?>includes/scripts/buscar_clientes.js"></script>