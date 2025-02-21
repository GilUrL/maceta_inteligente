$(document).ready(function () {
    // Iniciar la actualización automática cada 2 segundos
    setInterval(updateStatus, 2000);
});

function obtenerDatosReales(callback) {
    $.ajax({
        url: "http://localhost/maceta/api/",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ peticion: "ObtenerLecturasDHT" }),
        dataType: "json",
        success: function (respuesta) {
            if (respuesta.estado) {
                const horaActual = new Date();
                const hora = horaActual.toLocaleTimeString();
                respuesta.Datos.hora = hora; 
                callback(respuesta.Datos);
            } else {
                console.error("Mensaje de error:", respuesta.msg);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los datos:", xhr.responseText);
        }
    });
}



function updateStatus() {
    obtenerDatosReales(function (datos) {
        const humedad = datos.humedad;
        const temperatura = datos.temperatura;
        const hora = datos.hora; 

        document.getElementById('estado-humedad').textContent = humedad + '%';
        document.getElementById('estado-temperatura').textContent = temperatura + '°C';
        document.getElementById('estado-hora').textContent = 'Última actualización: ' + hora; 

        humidityChart.data.datasets[0].data = [humedad, 100 - humedad];
        humidityChart.update();

        temperatureChart.data.datasets[0].data = [temperatura, 40 - temperatura];
        temperatureChart.update();
    });
}

function createChart(canvasId, label, color) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [label, 'Restante'],
            datasets: [{
                data: [50, 50],
                backgroundColor: [color, '#222'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
}

const humidityChart = createChart('soilMoistureChart', 'Humedad', '#0ff');
const temperatureChart = createChart('temperatureChart', 'Temperatura', '#f00');