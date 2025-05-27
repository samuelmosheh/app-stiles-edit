<?php 
    //include '../config/config.php';
    //include '../includes/funciones.php';

    requireLogin();

    $tipos = $pdo->query("SELECT id, tipo_repuesto 
    FROM tipos_repuesto ORDER BY tipo_repuesto")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="contenedor">


    <h2 class="t-2">Inventario</h2>
    <div class="filtros">
        
        <label for="tipo">Tipo de Repuesto</label>
        <select name="tipo" id="tipo" class="sl-opt">
            <option value="">Todas</option>

            <?php foreach($tipos as $tipo): ?>
            <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['tipo_repuesto']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="marca">Marcas</label>
        <select name="marca" id="marca" class="sl-opt">
            
            <option value="">TODAS</option>
        </select>

        <label for="modelo">Modelos</label>
        <select name="modelo" id="modelo" class="sl-opt">
            
            <option value="">TODOS</option>
        </select>
    </div>
    <div id="resultado_inventario" class="resultado_inventario">
                <!--- RESULTADO DEL INVENTARIO CON AJAS ---->

    </div>
    
    <div class="add_new_insumo">
        <h2 class="t2"></h2>
        
        <a href="index.php?modulo=inventario" class="add_new">Agregar nuevo Insumo</a>
    </div>
    <!--- INCLUIMOS JAVASCRIPT PARA FILTRAR --->
    
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const tipoSelect = document.getElementById('tipo');
            const marcaSelect = document.getElementById('marca');
            const modeloSelect = document.getElementById('modelo');
            const resultadoDiv = document.getElementById('resultado_inventario');
        
            // Funcion para cargar marcas segun el tipo de repuesto
            function cargarMarcas(tipo){
                fetch('ajax/obtener_marcas_tipo.php?tipo_id=' + tipo)
                .then(res=> res.json())
                .then(data => {
                    marcaSelect.innerHTML = '<option value="">TODAS</option>';
                    data.forEach(m => {
                        marcaSelect.innerHTML += `<option value="${m.id}">${m.marca}</option>`;
                    });
                    modeloSelect.innerHTML = '<option value="">TODOS</option>';
                    cargarInventario(); 
                });
            }
            // Funcion para cargar los modelos segun la marca
            function cargarModelos(marca){
                fetch('ajax/obtener_modelo.php?marca_id=' + marca)
                .then(res => res.json())
                .then(data => {
                    modeloSelect.innerHTML = '<option value="">TODOS</option>';
                    data.forEach(m => {
                        modeloSelect.innerHTML += `<option value="${m.id}">${m.modelo}</option>`;
                    });
                    cargarInventario();
                });
            }
            // Funcion para cargar el inventario segun los filtros seleccioandos
            function cargarInventario(){
                const tipo = tipoSelect.value;
                const marca = marcaSelect.value;
                const modelo = modeloSelect.value;

                const formData = new FormData();
                formData.append('tipo', tipo);
                formData.append('marca', marca);
                formData.append('modelo', modelo);

                fetch('ajax/filtrar_inventario.php',{
                    method: 'POST',
                    body: formData
                })
                .then(res=> res.text())
                .then(data=> {
                    resultadoDiv.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error al cargar inventario:');
                });

                //Actualizar la URL sin recargar la pagina
                let newUrl = window.location.protocol + "//" + window.location.host +
                window.location.pathname + '?modulo=ver_inventario&tipo=' + tipo + '&marca=' + marca +
                '&modelo=' + modelo;
                window.history.pushState({ patch: newUrl}, '', newUrl);
            }
            //Cargar marcas cuando cambia el tipo
            tipoSelect.addEventListener('change', function() {
                cargarMarcas(this.value);
                cargarInventario(); //Actualizar inventario
            });
            //Cargar modelos cuando cambia la marca
            marcaSelect.addEventListener('change', function(){
                cargarModelos(this.value);
                cargarInventario(); // Actualizar Inventario
            });
            // Cargar inventario cuando cambia el modelo
            modeloSelect.addEventListener('change', cargarInventario);

            //Cargar inventario inicial si ya hay parametros en la URL
            const urlParam = new URLSearchParams(window.location.search);
            const tipo = urlParam.get('tipo') || '';
            const marca = urlParam.get('marca') || '';
            const modelo = urlParam.get('modelo') || '';

            tipoSelect.value = tipo;
            marcaSelect.value = marca;
            modeloSelect.value = modelo;

            // cargar inventario desde los filtros
            cargarInventario();


        });
      
    </script>
</div>