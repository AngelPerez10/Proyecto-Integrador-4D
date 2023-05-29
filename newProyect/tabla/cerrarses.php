<?php
    // Iniciar sesión
	session_start();

	// Destruir sesión
	session_destroy();

	// Redirigir a la página de inicio de sesión
	header("refresh:0; url=index.php");
	exit;
?>  