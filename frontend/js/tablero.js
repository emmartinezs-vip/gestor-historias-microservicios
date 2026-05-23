const URL_SPRINTS = 'http://localhost:8000/sprints';

const URL_HISTORIAS = 'http://localhost:8001/historias';

async function cargarTablero() {

    try {

        const respuestaSprints = await fetch(URL_SPRINTS);

        const sprints = await respuestaSprints.json();

        const respuestaHistorias = await fetch(URL_HISTORIAS);

        const historias = await respuestaHistorias.json();

        mostrarTablero(sprints, historias);

    } catch (error) {

        console.error('Error:', error);

    }

}

function mostrarTablero(sprints, historias) {

    const contenedor = document.getElementById('tablero');

    contenedor.innerHTML = '';

    sprints.forEach(sprint => {

        const historiasSprint = historias.filter(
            historia => historia.sprint_id == sprint.id
        );

        let htmlHistorias = '';

        historiasSprint.forEach(historia => {

            htmlHistorias += `
                <div class="historia">

                    <h3>${historia.titulo}</h3>

                    <p>${historia.descripcion}</p>

                    <p>
                        <strong>Responsable:</strong>
                        ${historia.responsable}
                    </p>

                   <p>
    <strong>Estado:</strong>

    <span class="estado ${historia.estado}">
        ${historia.estado}
    </span>
</p>

                </div>
            `;

        });

        contenedor.innerHTML += `

            <div class="sprint">

                <h2>${sprint.nombre}</h2>

                <p>
                    ${sprint.fecha_inicio}
                    -
                    ${sprint.fecha_fin}
                </p>

                ${htmlHistorias}

            </div>

        `;

    });

}

cargarTablero();