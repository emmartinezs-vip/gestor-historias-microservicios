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

    if (sprints.length === 0) {
    contenedor.innerHTML = '<p>No hay sprints creados.</p>';
    return;
    }

    sprints.forEach(sprint => {

        const historiasSprint = historias.filter(
            historia => historia.sprint_id == sprint.id
        );

        let htmlHistorias = '';

        if (historiasSprint.length === 0) {
            htmlHistorias = '<p>No hay historias en este sprint.</p>';
        }

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
            <strong>Puntos:</strong>
            ${historia.puntos}
        </p>

        <p><strong>Estado:</strong></p>
        <select onchange="cambiarEstado(${historia.id}, this.value)">
            <option value="nueva"       ${historia.estado === 'nueva'        ? 'selected' : ''}>Nueva</option>
            <option value="activa"      ${historia.estado === 'activa'       ? 'selected' : ''}>Activa</option>
            <option value="finalizada"  ${historia.estado === 'finalizada'   ? 'selected' : ''}>Finalizada</option>
            <option value="impedimento" ${historia.estado === 'impedimento'  ? 'selected' : ''}>Impedimento</option>
        </select>

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

async function cambiarEstado(id, nuevoEstado) {

    try {

        // Primero obtenemos la historia completa
        const respuestaGet = await fetch(`http://localhost:8001/historias/${id}`);
        const historia = await respuestaGet.json();

        // Actualizamos solo el estado
        historia.estado = nuevoEstado;

        // Enviamos la historia completa con el nuevo estado
        const respuesta = await fetch(`http://localhost:8001/historias/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(historia)
        });

        if (respuesta.ok) {
            alert(`Estado actualizado a "${nuevoEstado}".`);
            cargarTablero();
        } else {
            alert('Error al actualizar el estado.');
        }

    } catch (error) {
        console.error(error);
        alert('No se pudo conectar con el servidor.');
    }

}

cargarTablero();