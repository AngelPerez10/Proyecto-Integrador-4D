<?php
$conexion = mysqli_connect('localhost', 'root', '', 'fadama');

$sql = "SELECT idpark,fecha,estotal, MAX(esocupados) AS max_esocupados
        FROM parking
        GROUP BY fecha
        ORDER BY max_esocupados DESC
        LIMIT 5";

$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    while ($mostrar = mysqli_fetch_array($resultado)) {
        echo "<tr>";
        echo "<td>" . $mostrar['idpark'] . "</td>";
        echo "<td>" . $mostrar['fecha'] . "</td>";
        echo "<td>" . $mostrar['max_esocupados'] . "</td>";
        echo "<td>" . $mostrar['estotal'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No se encontraron resultados</td></tr>";
}

mysqli_close($conexion);
?>
