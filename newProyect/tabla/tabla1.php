<?php require "navbar.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <hr>
    <h3 class="subtitulo text-center">
        Días más transitados
    </h3>
    <hr>
    <table border="1" id="tabla-resultados-day" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Espacios Ocupados</th>
                    <th scope="col">Total de Espacios</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    <div class="espacio"></div>
    <hr>
    <h3 class="subtitulo text-center">
        Días menos transitados
    </h3>
    <hr>

        <table border="1" id="tabla-resultados-min" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Espacios Ocupados</th>
                    <th scope="col">Total de Espacios</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <script>
            $(document).ready(function() {

                cargarResultadosday();
                });

            function cargarResultadosday() {
                $.ajax({
                    url: 'obtener_dias.php',
                    type: 'GET',
                    success: function(response) {
                        $('#tabla-resultados-day tbody').html(response);
                    },
                    error: function() {
                        $('#tabla-resultados-day tbody').html('<tr><td colspan="4">Error al cargar los resultados</td></tr>');
                    }
                });
            }



            $(document).ready(function() {

cargarResultadosdaymin();
});

function cargarResultadosdaymin() {
$.ajax({
    url: 'obtener_diasmin.php',
    type: 'GET',
    success: function(response) {
        $('#tabla-resultados-min tbody').html(response);
    },
    error: function() {
        $('#tabla-resultados-min tbody').html('<tr><td colspan="4">Error al cargar los resultados</td></tr>');
    }
});
}
        </script>
        </div>


































        <script>
            $(document).ready(function() {
                $.ajax({
                    url: 'obtener_datos.php',
                    dataType: 'json',
                    success: function(datos) {
                        const tabla = new gridjs.Grid({
                            columns: ['id', 'fecha', 'espacios_ocupados', 'total_de_espacios'],
                            data: datos,
                            pagination: {
                                enabled: true,
                                limit: 5
                            },
                            search: true,
                            sort: true,
                            language: {
                                search: {
                                    placeholder: 'Buscar...'
                                },
                                pagination: {
                                    previous: 'Anterior',
                                    next: 'Siguiente',
                                    showing: 'Mostrando',
                                    results: () => 'Filas',
                                    to: 'a'
                                }
                            }
                        }).render(document.getElementById('tabla'));
                    },
                    error: function() {
                        alert('Error al obtener los datos');
                    }
                });
        
            
        
            });



            
        </script>



    <script>
            var select = document.getElementById('fechas');
            var canvas = document.getElementById('grafica');
            var grafica;

            // Función para actualizar la gráfica
            function actualizarGrafica() {
                var fechaSeleccionada = select.value;

                // Obtener los datos para la fecha seleccionada
                fetch('obtener_datos_grafico.php?fecha=' + encodeURIComponent(fechaSeleccionada))
                    .then(response => response.json())
                    .then(data => {
                        // Preparar los datos para la gráfica
                        var labels = data.labels;
                        var valores = data.data;

                        // Si ya hay una instancia de la gráfica, destruirla
                        if (grafica) {
                            grafica.destroy();
                        }

                        // Configurar la nueva gráfica con los nuevos datos
                        var ctx = canvas.getContext('2d');
                        grafica = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Espacios ocupados',
                                    data: valores,
                                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                    borderColor: 'rgba(0, 123, 255, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos:', error);
                    });
            }

            // Obtener las fechas disponibles
            fetch('obtener_fechas.php')
                .then(response => response.json())
                .then(data => {
                    // Actualizar las opciones del select con las fechas obtenidas
                    select.innerHTML = '';
                    data.forEach(fecha => {
                        var option = document.createElement('option');
                        option.value = fecha;
                        option.textContent = fecha;
                        select.appendChild(option);
                    });

                    // Actualizar la gráfica con la primera fecha
                    actualizarGrafica();
                })
                .catch(error => {
                    console.error('Error al obtener las fechas:', error);
                });

            // Agregar el evento "change" al select
            select.addEventListener('change', actualizarGrafica);
        </script>
</body>
</html>