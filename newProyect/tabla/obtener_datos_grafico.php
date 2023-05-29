<?php
$conexion = mysqli_connect('localhost', 'root', '', 'fadama');
if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

$fecha = isset($_GET['fecha']) ? urldecode($_GET['fecha']) : null; // Verificar si se proporcionó la fecha

if ($fecha) {
    // Utilizar consultas preparadas para evitar problemas de seguridad
    $sql = "SELECT DATE_FORMAT(fecha, '%H:%i:%s') AS hora, esocupados FROM parking WHERE DATE(fecha) = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, 's', $fecha);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM parking";
    $resultado = mysqli_query($conexion, $sql);
}

if (!$resultado) {
    die('Error de consulta: ' . mysqli_error($conexion));
}

$labels = array();
$data = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $labels[] = $fila['hora']; // Obtener solo la hora de la fecha
    $data[] = $fila['esocupados'];
}

mysqli_close($conexion);

$datos_grafico = array(
    'labels' => $labels,
    'data' => $data
);

header('Content-Type: application/json');
echo json_encode($datos_grafico);
?>
