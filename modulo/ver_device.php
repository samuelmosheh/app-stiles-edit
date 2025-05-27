<?php 
    //include_once '../config/config.php';
    //include_once '../includes/funciones.php';

    requireLogin();


   

?>
<div class="contenedor">

    
        <?php include 'includes/mensaje.php'; ?>

        <form action="" id="filtro-estado" method="GET">
            <h2 class="t-2">Dispositivos</h2>

            <div class="filtros">
                <label for="estado">Filtrar por Estado</label>
                <select name="estado" id="estado" class="sl-opt">
                    <option value="">Todos</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en proceso">En Proceso</option>
                    <option value="listo">Listo</option>
                    <option value="entregado">Entregado</option>
                    <option value="devuelto">Devuelto</option>
                </select>

                <a href="<?php echo BASE_URL;?>index.php?modulo=dispositivos" class="btn-add">Agregar un nuevo Dispositivo</a>
            </div>
        </form>
    

    <div class="list-devices" id="list-devices">
        
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const estadoSelect = document.getElementById("estado");
        const contenedor = document.getElementById("list-devices");

        function cargarDevices(){
            const estado = estadoSelect.value;

            const formData = new FormData();
            formData.append("estado", estado);

            fetch("ajax/filtrar_device.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text() )
            .then(data => {
            contenedor.innerHTML = data;
        })
        .catch(error => {
            contenedor.innerHTML = "Error al Mostrar los Dispositivos.";
            console.error(error);
        });
        }

        cargarDevices();

        estadoSelect.addEventListener("change", cargarDevices);
    });

</script>