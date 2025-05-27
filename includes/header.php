<?php
 require_once 'includes/funciones.php';
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'Phonerepair-cl'; ?></title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
</head>
<body>
    <header class="head-menu">
        <h1 class="t-header">Phone Repair.cl</h1>
            <div class="header-right">
            <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                <span class="us-name">Hola, <strong><?= htmlspecialchars($_SESSION['usuario_nombre'])?></strong></span>
                <?php endif; ?>
            </div>

        <input type="checkbox" id="menu-bt" class="menu-bt">
        <label for="menu-bt" class="icon-th-list"></label>
       