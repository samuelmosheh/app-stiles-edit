<?php
    $stmt = $pdo->query("SELECT id, nombre, email, rol, fecha_registro, activo FROM usuarios ORDER BY id DESC");
    $usuarios = $stmt ->fetchAll(PDO::FETCH_ASSOC);

    $usuario_actual = $_SESSION['usuario_id'] ?? null;
?>

<div class="uss-exist">
     <h2 class="t-2">Lista de Usuario Existentes</h2>
        <?php include 'includes/mensaje.php'; ?>
    
    <div class="card-container">
        <?php foreach ($usuarios as $usuario): ?>
            <div class="user-card">
                <h3 class="t-c-name"><?= htmlspecialchars($usuario['nombre']) ?></h3>
                <p><strong>Id: </strong><?= htmlspecialchars($usuario['id'])?></p>
                <p><strong>Email: </strong><?= htmlspecialchars($usuario['email'])?></p>
                <p><strong>Rol: </strong><?= htmlspecialchars($usuario['rol'])?></p>
                <p><strong>Registrado: </strong><?= $usuario['fecha_registro']?></p>
            
                <?php if ($usuario['id'] != $usuario_actual): ?>
                <form method="POST" action="<?php echo BASE_URL;?>procesadores/procesar_dehabilitar_user.php" class="delete-uss">
                    <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
                    <input type="hidden" name="nuevo_estado" value="<?= $usuario['activo'] ? 0 : 1 ?>">
                    <label for="disable-user">Deshabilitar Usuario</label>
                    <button id="disable-user" class="<?= $usuario['activo'] ? 'disable-user' : 'enable-user' ?>" type="submit">

                        <?= $usuario['activo'] ? 'Deshabilitar' : 'Reacticar' ?>

                    </button>
                </form>
                <?php else: ?>
                    <p>No puedes modificar tu propio estado.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>

</div>