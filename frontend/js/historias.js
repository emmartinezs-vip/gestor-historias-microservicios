const URL =
    'http://localhost:8081/historias';

const formulario =
    document.getElementById('form-historia');

const tabla =
    document.getElementById('tabla-historias');

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

                        <button onclick="eliminarHistoria(${historia.id})">

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

        const data = {

            titulo:
                document.getElementById('titulo').value,

            descripcion:
                document.getElementById('descripcion').value,

            responsable:
                document.getElementById('responsable').value,

            estado:
                document.getElementById('estado').value,

            puntos:
                parseInt(
                    document.getElementById('puntos').value
                ),

            fecha_creacion:
                document.getElementById(
                    'fecha_creacion'
                ).value,

            fecha_finalizacion: null,

            sprint_id:
                parseInt(
                    document.getElementById('sprint_id').value
                )

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

                cargarHistorias();

            }

        } catch (error) {

            console.error(error);

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

            cargarHistorias();

        }

    } catch (error) {

        console.error(error);

    }

}

cargarHistorias();