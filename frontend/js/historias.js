const URL =
    'http://localhost:8001/historias';

const formulario =
    document.getElementById('form-historia');

const tabla =
    document.getElementById('tabla-historias');

    const btnSubmit = document.getElementById('btn-submit');
    const btnCancelar = document.getElementById('btn-cancelar');

async function cargarHistorias() {

    try {

        const respuesta =
            await fetch(URL);

        const historias =
            await respuesta.json();

        tabla.innerHTML = '';

        historias.forEach(historia => {

            tabla.innerHTML += `

                <tr>

                    <td>${historia.id}</td>

                    <td>${historia.titulo}</td>

                    <td>${historia.responsable}</td>

                    <td>${historia.estado}</td>

                    <td>${historia.puntos}</td>

                    <td>${historia.sprint_id}</td>

                    <td>
                        <button onclick="prepararEdicion(${historia.id}, '${historia.titulo}', '${historia.descripcion}', '${historia.responsable}', '${historia.estado}', ${historia.puntos}, '${historia.fecha_creacion}', '${historia.fecha_finalizacion}', ${historia.sprint_id})">
                            Editar
                        </button>
                        <button onclick="eliminarHistoria(${historia.id})">
                            Eliminar
                        </button>
                    </td>

                </tr>

            `;

        });

    } catch (error) {
        console.error(error);
        alert('Error al cargar las historias.');
    }

}

async function cargarSprintsEnSelect() {

    try {

        const respuesta = await fetch('http://localhost:8000/sprints');
        const sprints = await respuesta.json();
        const select = document.getElementById('sprint_id');

        // Limpia opciones anteriores excepto la primera
        select.innerHTML = '<option value="">-- Selecciona un Sprint --</option>';

        sprints.forEach(sprint => {
            select.innerHTML += `<option value="${sprint.id}">${sprint.nombre}</option>`;
        });

    } catch (error) {
        console.error(error);
        alert('Error al cargar los sprints.');
    }

}

function prepararEdicion(id, titulo, descripcion, responsable, estado, puntos, fechaCreacion, fechaFinalizacion, sprintId) {

    document.getElementById('historia_id_editar').value = id;
    document.getElementById('titulo').value = titulo;
    document.getElementById('descripcion').value = descripcion;
    document.getElementById('responsable').value = responsable;
    document.getElementById('estado').value = estado;
    document.getElementById('puntos').value = puntos;
    document.getElementById('fecha_creacion').value = fechaCreacion;
    document.getElementById('fecha_finalizacion').value = fechaFinalizacion || '';
    document.getElementById('sprint_id').value = sprintId;

    btnSubmit.textContent = 'Guardar Cambios';
    btnCancelar.style.display = 'inline-block';

    formulario.scrollIntoView({ behavior: 'smooth' });

}

function cancelarEdicion() {

    formulario.reset();
    document.getElementById('historia_id_editar').value = '';

    btnSubmit.textContent = 'Crear Historia';
    btnCancelar.style.display = 'none';

}

formulario.addEventListener(
    'submit',
    async function (event) {

        event.preventDefault();

        const data = {
            titulo: document.getElementById('titulo').value,
            descripcion: document.getElementById('descripcion').value,
            responsable: document.getElementById('responsable').value,
            estado: document.getElementById('estado').value,
            puntos: parseInt(document.getElementById('puntos').value),
            fecha_creacion: document.getElementById('fecha_creacion').value,
            fecha_finalizacion: document.getElementById('fecha_finalizacion').value || null,
            sprint_id: parseInt(document.getElementById('sprint_id').value)
        };

        const idEditar = document.getElementById('historia_id_editar').value;
        const esEdicion = idEditar !== '';
        const metodo = esEdicion ? 'PUT' : 'POST';
        const endpoint = esEdicion ? `${URL}/${idEditar}` : URL;

        try {

                const respuesta = await fetch(endpoint, {
                    method: metodo,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (respuesta.ok) {
                    alert(esEdicion ? 'Historia actualizada.' : 'Historia creada.');
                    cancelarEdicion();
                    cargarHistorias();
                } else {
                    alert('Error al guardar la historia.');
                }

            } catch (error) {
                console.error(error);
                alert('No se pudo conectar con el servidor.');
            }
    }
);

async function eliminarHistoria(id) {

    const confirmar =
        confirm('¿Eliminar historia?');

    if (!confirmar) {

        return;

    }

    try {

        const respuesta =
            await fetch(`${URL}/${id}`, {

                method: 'DELETE'

            });

            if (respuesta.ok) {
                alert('Historia eliminada.');
                cargarHistorias();
            } else {
                alert('Error al eliminar la historia.');
            }
            } catch (error) {
                console.error(error);
                alert('No se pudo conectar con el servidor.');
            }

    

}

cargarSprintsEnSelect();
cargarHistorias();