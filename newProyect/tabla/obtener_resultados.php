<?php
$conexion = mysqli_connect('localhost', 'root', '', 'fadama');

$fecha = $_GET['fecha'];

if ($fecha) {
    $fecha = urldecode($fecha); // Decodificar la fecha codificada en la URL
    $sql = "SELECT * FROM parking WHERE DATE(fecha) = '$fecha'";
} else {
    $sql = "SELECT * FROM parking";
}

$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    while ($mostrar = mysqli_fetch_array($resultado)) {
        echo "<tr>";
        echo "<td>" . $mostrar['idpark'] . "</td>";
        echo "<td>" . $mostrar['fecha'] . "</td>";
        echo "<td>" . $mostrar['esocupados'] . "</td>";
        echo "<td>" . $mostrar['estotal'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
}

mysqli_close($conexion);
?>
