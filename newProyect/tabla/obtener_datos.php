<?php
$conexion = mysqli_connect('localhost', 'root', '', 'fadama');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

$sql = "SELECT idpark, fecha, esocupados, estotal FROM parking";
$resultado = mysqli_query($conexion, $sql);
if (!$resultado) {
    die('Error de consulta: ' . mysqli_error($conexion));
}

$datos = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $datos[] = array(
        'id' => $fila['idpark'],
        'fecha' => $fila['fecha'],
        'espacios_ocupados' => $fila['esocupados'],
        'total_de_espacios' => $fila['estotal']
    );
}



mysqli_close($conexion);

header('Content-Type: application/json');
echo json_encode($datos);
?>
