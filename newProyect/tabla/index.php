<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="estilosLogReg.css">
	<title>Iniciar Sesion</title>
</head>

<body>
	<div class="formulario">
		<h1 class="titulo">Login</h1>
		<form name="login" action="loginAdmin.php" method="POST">
			<div class="username">
				<input class="usuario" type="text" name="adminUser" placeholder="Admin">
			</div>
			<div class="username">
				<input class="password_btn" type="password" name="adminPass" placeholder="Password">
			</div>
			<input type="submit" value="Iniciar">
			<!-- Comprobamos si la variable errores esta seteada, si es asi mostramos los errores -->
			<!--Comentario para agregar un commit simple-->
			<?php if(!empty($errores)): ?>
				<div class="error">
					<ul>
						<?php echo $errores; ?>
					</ul>
				</div>
			<?php endif; ?>
		</form>
	</div>
</body>
</html>