<?php

 requireLogin();




?>






     <h2 class="t-2">Usar Insumo en Dispositivo</h2>
    <input type="hidden" name="dispositivo_id" value="<?= $d['id'] ?>">

    <form action="<?php echo BASE_URL;?>procesadores/procesar_usar_insumo.php" class="insumo-use" method="POST">

        <div>
            <label for="tipo">Tipo de Insumo: </label>
            <select id="tipo" name="tipo" class="sl-opt">
                <option value=""></option>
            </select>
        </div>

        <div>
            <label for="">Insumo: </label>
            <select id="" name="" class="sl-opt">
                <option value=""></option>
            </select>
        </div>
        <div>
            <label for="cantidad">Cantidad a Usar: </label>
            <input type="number" name="cantidad" id="cantidad">
        </div>
        <div><label for="uso">Tipo de Uso: </label>
            <select name="uso" id="uso">
                <option value="reparacion">Reparacion</option>
                <option value="venta">Venta</option>
                <option value="garantia">Garantia</option>
                <option value="otro">Otro</option>
            </select>
        </div>
        <div>
            <label for="">Observación: </label>
            <textarea name="" id="" rows="3"></textarea>
        </div>

        <button type="submit">Usar Insumo</button>
    </form>