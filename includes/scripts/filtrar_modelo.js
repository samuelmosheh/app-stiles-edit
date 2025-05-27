

    document.getElementById('marca').addEventListener('change', function() {
        const marca = this.value;
        const modeloSelect = document.getElementById('modelo');

        //Limpiar modelos Anteriores 
        modeloSelect.innerHTML = '<option value="">Cargando modelos...</option>';
        
        if (marca) {
            fetch('ajax/obtener_modelo.php?marca_id=' + marca)
            .then(res => res.json())
            .then(data => {
                modeloSelect.innerHTML = '<option value="">Seleccione un modelo</option>';
                data.forEach(modelo => {
                    const option = document.createElement('option');
                    option.value = modelo.id;
                    option.textContent = modelo.modelo;
                    modeloSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error cargando modelos:', error);
                modeloSelect.innerHTML = '<option value="">Error al cargar</option>';
            });
        } else {
            modeloSelect.innerHTML = '<option value="">Seleccione una marca primero</option>';
        }
    });
