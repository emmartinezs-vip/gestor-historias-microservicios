const URL =
    'http://localhost:8000/sprints';

const formulario =
    document.getElementById('form-sprint');

const tabla =
    document.getElementById('tabla-sprints');

const btnSubmit = document.getElementById('btn-submit');
const btnCancelar = document.getElementById('btn-cancelar');

async function cargarSprints() {

    try {

        const respuesta =
            await fetch(URL);

        const sprints =
            await respuesta.json();

        tabla.innerHTML = '';

        sprints.forEach(sprint => {

            tabla.innerHTML += `

                <tr>

                    <td>${sprint.id}</td>

                    <td>${sprint.nombre}</td>

                    <td>${sprint.fecha_inicio}</td>

                    <td>${sprint.fecha_fin}</td>

                    <td>

                        <button onclick="prepararEdicion(${sprint.id}, '${sprint.nombre}', '${sprint.fecha_inicio}', '${sprint.fecha_fin}')">
                            Editar
                        </button>
                        <button onclick="eliminarSprint(${sprint.id})">
                            Eliminar
                        </button>

                    </td>

                </tr>

            `;

        });

    } catch (error) {
        console.error(error);
        alert('Error al cargar los sprints.');
    }

}

function prepararEdicion(id, nombre, fechaInicio, fechaFin) {

    document.getElementById('sprint_id_editar').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('fecha_inicio').value = fechaInicio;
    document.getElementById('fecha_fin').value = fechaFin;

    btnSubmit.textContent = 'Guardar Cambios';
    btnCancelar.style.display = 'inline-block';

    formulario.scrollIntoView({ behavior: 'smooth' });

}

function cancelarEdicion() {

    formulario.reset();
    document.getElementById('sprint_id_editar').value = '';

    btnSubmit.textContent = 'Crear Sprint';
    btnCancelar.style.display = 'none';

}


formulario.addEventListener(
    'submit',
    async function (event) {

        event.preventDefault();

        const fechaInicio =
            document.getElementById(
                'fecha_inicio'
            ).value;

        const fechaFin =
            document.getElementById(
                'fecha_fin'
            ).value;

        if (fechaFin < fechaInicio) {

            alert(
                'La fecha final no puede ser menor a la inicial'
            );

            return;

        }

        const data = {
            nombre: document.getElementById('nombre').value,
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin
        };

        const idEditar = document.getElementById('sprint_id_editar').value;
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
                alert(esEdicion ? 'Sprint actualizado.' : 'Sprint creado.');
                cancelarEdicion();
                cargarSprints();
            } else {
                alert('Error al guardar el sprint.');
            }

        } catch (error) {
            console.error(error);
            alert('No se pudo conectar con el servidor.');
        }

    }
);

async function eliminarSprint(id) {

    const confirmar =
        confirm('¿Eliminar sprint?');

    if (!confirmar) {

        return;

    }

    try {

        const respuesta =
            await fetch(`${URL}/${id}`, {

                method: 'DELETE'

            });

        if (respuesta.ok) {
            alert('Sprint eliminado.');
            cargarSprints();
        } else {
            alert('Error al eliminar el sprint.');
        }
        } catch (error) {
            console.error(error);
            alert('No se pudo conectar con el servidor.');
        }

}

cargarSprints();