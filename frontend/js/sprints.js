const URL =
    'http://localhost:8080/sprints';

const formulario =
    document.getElementById('form-sprint');

const tabla =
    document.getElementById('tabla-sprints');

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

                        <button onclick="eliminarSprint(${sprint.id})">

                            Eliminar

                        </button>

                    </td>

                </tr>

            `;

        });

    } catch (error) {

        console.error(error);

    }

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

            nombre:
                document.getElementById('nombre').value,

            fecha_inicio: fechaInicio,

            fecha_fin: fechaFin

        };

        try {

            const respuesta =
                await fetch(URL, {

                    method: 'POST',

                    headers: {

                        'Content-Type':
                            'application/json'

                    },

                    body: JSON.stringify(data)

                });

            if (respuesta.ok) {

                formulario.reset();

                cargarSprints();

            }

        } catch (error) {

            console.error(error);

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

            cargarSprints();

        }

    } catch (error) {

        console.error(error);

    }

}

cargarSprints();