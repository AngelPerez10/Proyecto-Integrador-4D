<?php session_start();
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Comprobamos si ya han sido enviado los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') { //comprobamos si los datos se han enviado
	$adminUser = filter_var(strtolower($_POST['adminUser']), FILTER_SANITIZE_STRING);
	$adminPass = $_POST['adminPass'];
	$adminPass = hash('sha512', $adminPass);

	// Nos conectamos a la base de datos
												//tabla de la db    //el usuario ingresado              //contrasena ingresada coincida con la tabla
	$statement = $conexion->prepare('SELECT * FROM administrador WHERE adminUser = :adminUser AND adminPass = :adminPass');
	$statement->execute(array(
			':adminUser' => $adminUser,//placeholder adminUser
			':adminPass' => $adminPass //placeholder password
		));

	$resultado = $statement->fetch(); //fetch devuelve el resultado
	if ($resultado !== false) {
		$_SESSION['adminUser'] = $adminUser;
		header('Location: home.php');
	} else {
		$errores = '<li>Datos incorrectos</li>';
	}
}


require 'index.php';



?>