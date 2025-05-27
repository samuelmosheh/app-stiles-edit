<nav class="menu-nav">
    <ul class="main-menu">
        <li class="menu-it">
            <a href="index.php?modulo=dashbd" class="a-menu">Dashboard <span class="icon-chart-bar"></span></a>
        </li>
        <li class="menu-it">
            <a href="index.php?modulo=clientes" class="a-menu">Clientes <span class="icon-users"></span></a>
        </li>
        <li class="menu-it">
            <a href="index.php?modulo=ver_device" class="a-menu">Dispositivos <span class="icon-android"></span></a>
        </li>

        <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
        <li class="menu-it">
            <a href="index.php?modulo=ver_inventario" class="a-menu">Inventario <span class="icon-tag"></span></a>
        </li>
        <li class="menu-it">
            <a href="index.php?modulo=usuarios" class="a-menu">Usuarios <span class="icon-user-plus"></span></a>
        </li>
        <li class="menu-it">
            <a href="index.php?modulo=finanzas" class="a-menu">Finanzas <span class="icon-chart-bar"></span></a>
        </li>
        <?php endif; ?> 

       
        <li class="menu-it">
            <a href="<?= BASE_URL ?>procesadores/logout.php" class="a-menu">Cerrar seción <span class="icon-off-1"></span></a>
        </li>
    </ul>
</nav>
</header>