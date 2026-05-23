const URL_REPORTE =
    'http://localhost:8081/historias/reporte/general';

const URL_RESPONSABLES =
    'http://localhost:8081/historias/reporte/responsables';

async function cargarReporte() {

    try {

        // REPORTE GENERAL
        const respuestaGeneral =
            await fetch(URL_REPORTE);

        const reporteGeneral =
            await respuestaGeneral.json();

        mostrarReporteGeneral(reporteGeneral);

        // REPORTE RESPONSABLES
        const respuestaResponsables =
            await fetch(URL_RESPONSABLES);

        const reporteResponsables =
            await respuestaResponsables.json();

        mostrarReporteResponsables(
            reporteResponsables
        );

    } catch (error) {

        console.error(error);

    }

}

function mostrarReporteGeneral(reporte) {

    const tabla =
        document.getElementById('tabla-reportes');

    tabla.innerHTML = '';

    reporte.forEach(item => {

        tabla.innerHTML += `

            <tr>

                <td>${item.estado}</td>

                <td>${item.cantidad}</td>

            </tr>

        `;

    });

}

function mostrarReporteResponsables(reporte) {

    const tabla =
        document.getElementById('tabla-responsables');

    tabla.innerHTML = '';

    reporte.forEach(item => {

        tabla.innerHTML += `

            <tr>

                <td>${item.responsable}</td>

                <td>${item.nuevas}</td>

                <td>${item.finalizadas}</td>

                <td>${item.impedimentos}</td>

            </tr>

        `;

    });

}

cargarReporte();