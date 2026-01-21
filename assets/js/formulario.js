function agregarFila() {
    var tbody = document.getElementById('cuerpo-tabla');
    var fila = document.createElement('tr');
    fila.style.animation = "fadeIn 0.5s";
    fila.innerHTML = `
                <td><input type="date" class="form-control form-control-sm border-0 bg-light" name="fechas[]" required></td>
                <td><input type="time" class="form-control form-control-sm border-0 bg-light" name="h_inicio[]" required></td>
                <td><input type="time" class="form-control form-control-sm border-0 bg-light" name="h_fin[]" required></td>
                <td class="text-center">
                    <button type="button" onclick="eliminarFila(this)" class="btn btn-link text-danger p-0 border-0">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                </td>
            `;
    tbody.appendChild(fila);
}

function eliminarFila(boton) {
    var fila = boton.parentNode.parentNode;
    fila.remove();
}

document.querySelector('form').addEventListener('submit', function(e) {
    const ahora = new Date();
    const fechas = document.getElementsByName('fechas[]');
    const horasInicio = document.getElementsByName('h_inicio[]');
    const horasFin = document.getElementsByName('h_fin[]');

    for (let i = 0; i < fechas.length; i++) {
        if (fechas[i].value) {

            const fechaInicio = new Date(fechas[i].value + 'T' + horasInicio[i].value);

            if (fechaInicio < ahora) {
                e.preventDefault();
                alert('Error: La fecha u hora de inicio ya ha pasado.');
                fechas[i].focus();
                return;
            }

            const horaInicioVal = horasInicio[i].value;
            const horaFinVal = horasFin[i].value;

            if (horaFinVal <= horaInicioVal) {
                e.preventDefault();
                alert('Error en la hora de fin: La hora de finalización debe ser posterior a la hora de inicio.');
                horasFin[i].focus();
                return;
            }
        }
    }
});

//evitar elegir fechas pasadas en el calendario
window.onload = function() {
    const hoy = new Date().toISOString().split('T')[0];
    const inputsFecha = document.getElementsByName('fechas[]');
    inputsFecha.forEach(input => {
        input.setAttribute('min', hoy);
    });
}