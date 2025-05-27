<?php
    if (isset($_SESSION['exito'])):

?>
<div class="exito"><p><?php echo $_SESSION['exito']; unset($_SESSION['exito']); ?></p></div>
<?php endif;?>

<?php
    if (isset($_SESSION['error'])):

?>

<div class="error">
    <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
</div>
<?php endif; ?>