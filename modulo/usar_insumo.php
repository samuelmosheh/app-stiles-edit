

     <h2 class="t-2">Usar Insumo en Dispositivo</h2>
    <input type="hidden" name="dispositivo_id" value="<?= $d['id'] ?>">

    <form action="<?php echo BASE_URL; ?>procesadores/procesar_usar_insumo.php" class="insumo-use" method="POST">

        <div>
            <label for="tipo">Tipo de Insumo: </label>
            <select id="tipo_id" name="tipo" class="sl-opt">
                <option value="">Seleccione un tipo de Insumo</option>
                <?php
                    $tipos = $pdo->query("SELECT id, tipo_repuesto 
                                        FROM tipos_repuesto 
                                        ORDER BY tipo_repuesto")
                                        ->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($tipos as $t){
                        echo "<option value='{$t['id']}'>{$t['tipo_repuesto']}</option>";
                    }
                ?>
            </select>
        </div>
                    <!-- Solo si NO estás en modo reparación -->
        
        <?php if (!$modo_reparacion): ?>
            <label for="marca_id">Marca:</label>
            <select id="marca_id" name="marca_id" required>
            <option value="">Seleccione marca</option>
        <?php
            $marcas = $pdo->query("SELECT id, marca FROM marcas ORDER BY marca")->fetchAll();
            foreach ($marcas as $m) {
                echo "<option value='{$m['id']}'>{$m['marca']}</option>";
            }
        ?>
            </select>

             <label for="modelo_id">Modelo:</label>
            <select id="modelo_id" name="modelo_id" required>
                <option value="">Seleccione modelo</option>
            </select>
        <?php endif; ?>
        
        <!-- Selector de insumos filtrados -->
            <label for="insumo_id">Insumo:</label>
            <select id="insumo_id" name="insumo_id" required>
                <option value="">Seleccione un insumo</option>
            </select>

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
    <script>
<?php if (!$modo_reparacion): ?>
// Cargar modelos al seleccionar marca
document.getElementById('marca_id').addEventListener('change', function () {
    const marcaId = this.value;
    fetch('modulos/ajax/obtener_modelos.php?marca_id=' + marcaId)
        .then(res => res.json())
        .then(data => {
            const modeloSelect = document.getElementById('modelo_id');
            modeloSelect.innerHTML = '<option value="">Seleccione modelo</option>';
            data.forEach(m => {
                modeloSelect.innerHTML += `<option value="${m.id}">${m.modelo}</option>`;
            });
        });
});
<?php endif; ?>

function cargarInsumos() {
    const tipoId = document.getElementById('tipo_id').value;
    const marcaId = <?= $modo_reparacion ? $marca_id : "document.getElementById('marca_id').value" ?>;
    const modeloId = <?= $modo_reparacion ? $modelo_id : "document.getElementById('modelo_id').value" ?>;

    if (tipoId && marcaId && modeloId) {
        const url = `modulos/ajax/obtener_insumos.php?tipo_id=${tipoId}&marca_id=${marcaId}&modelo_id=${modeloId}`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                const insumoSelect = document.getElementById('insumo_id');
                insumoSelect.innerHTML = '<option value="">Seleccione insumo</option>';
                data.forEach(i => {
                    insumoSelect.innerHTML += `<option value="${i.id}">${i.descripcion} (${i.stock} disponibles)</option>`;
                });
            });
    }
}

document.getElementById('tipo_id').addEventListener('change', cargarInsumos);
<?php if (!$modo_reparacion): ?>
document.getElementById('modelo_id').addEventListener('change', cargarInsumos);
<?php endif; ?>
</script>