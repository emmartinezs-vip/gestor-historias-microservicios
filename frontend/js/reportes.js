const URL_HISTORIAS = 'http://localhost:8001/historias';

async function cargarReporte() {
    try {
        const respuesta = await fetch(URL_HISTORIAS);
        const historias = await respuesta.json();

        mostrarReporteGeneral(historias);
        mostrarReporteResponsables(historias);

    } catch (error) {
        console.error(error);
    }
}

function mostrarReporteGeneral(historias) {
    const tabla = document.getElementById('tabla-reportes');
    tabla.innerHTML = '';

    // Agrupar por estado y contar
    const conteo = {};
    historias.forEach(h => {
        conteo[h.estado] = (conteo[h.estado] || 0) + 1;
    });

    Object.entries(conteo).forEach(([estado, cantidad]) => {
        tabla.innerHTML += `
            <tr>
                <td>${estado}</td>
                <td>${cantidad}</td>
            </tr>
        `;
    });
}

function mostrarReporteResponsables(historias) {
    const tabla = document.getElementById('tabla-responsables');
    tabla.innerHTML = '';

    // Agrupar por responsable
    const resumen = {};
    historias.forEach(h => {
        if (!resumen[h.responsable]) {
            resumen[h.responsable] = { nuevas: 0, finalizadas: 0, impedimentos: 0 };
        }
        if (h.estado === 'nueva')        resumen[h.responsable].nuevas++;
        if (h.estado === 'finalizada')   resumen[h.responsable].finalizadas++;
        if (h.estado === 'impedimento')  resumen[h.responsable].impedimentos++;
    });

    Object.entries(resumen).forEach(([responsable, datos]) => {
        tabla.innerHTML += `
            <tr>
                <td>${responsable}</td>
                <td>${datos.nuevas}</td>
                <td>${datos.finalizadas}</td>
                <td>${datos.impedimentos}</td>
            </tr>
        `;
    });
}

cargarReporte();