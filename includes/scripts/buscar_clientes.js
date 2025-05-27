document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('busqueda');
    const contenedorResultados = document.getElementById('resultados-clientes');

    inputBusqueda.addEventListener('input', () => {
        const termino = inputBusqueda.value.trim();

        if (termino.length < 2) {
            contenedorResultados.innerHTML = '';
            return;
        }

        fetch(`ajax/buscar_clientes_ajax.php?q=${encodeURIComponent(termino)}`)
            .then(res => res.json())
            .then(data => {
                contenedorResultados.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(cliente => {
                        const div = document.createElement('div');
                        div.classList.add('cliente-sugerencia');
                        div.textContent = `${cliente.nombre} | ${cliente.rut} | ${cliente.email}`;
                        div.addEventListener('click', () => {
                            window.location.href = `index.php?modulo=dispositivos&cliente_id=${cliente.id}`;
                        });
                        contenedorResultados.appendChild(div);
                    });
                } else {
                    contenedorResultados.innerHTML = '<div class="no-result">Sin resultados</div>';
                }
            })
            .catch(err => {
                console.error('Error en búsqueda:', err);
            });
    });
});