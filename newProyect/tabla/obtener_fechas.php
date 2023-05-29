<?php
$conexion = mysqli_connect('localhost', 'root', '', 'fadama');

// Obtener las fechas de tu base de datos
$sql = "SELECT DISTINCT DATE(fecha) AS fecha FROM parking ORDER BY fecha ASC";
$resultado = mysqli_query($conexion, $sql);

$opciones = '';
while ($fila = mysqli_fetch_assoc($resultado)) {
    $fecha = $fila['fecha'];
    $opciones .= "<option value=\"$fecha\">$fecha</option>";
}
echo $opciones;

mysqli_close($conexion);
?>
