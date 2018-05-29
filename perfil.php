<?php

require_once ('./include.php');

if ($session->getUsuario()){
$usuario = Usuario::findByCampoString('email', $session->getUsuario()->email);
} else {
	header("Location: login.php");
	exit;
}

$error = false;
$error_msg = null;
$existeFile = null;

if (existeParametro('actualizarDatos', $_POST)) {
	$existeFile = existeFileSinError('imagenperfil');
	$usuario->nombre = traerValorDeParametro('nombre',$_POST);
	$usuario->apellido = traerValorDeParametro('apellido',$_POST);
	$usuario->edad = traerValorDeParametro('edad',$_POST);
	if ($existeFile){
		$usuario->avatar = guardarArchivoSubido('imagenperfil', 'imagen_perfil_','./avatar/');
	}
	$usuario->save();
}

if (existeParametro('actualizarPassword', $_POST)) {
if(traerValorDeParametro('passwordNuevo',$_POST) == traerValorDeParametro('confirmarPasswordNuevo',$_POST)){
			if(password_verify(traerValorDeParametro('password',$_POST), $usuario->password)){
					$usuario->password = password_hash(traerValorDeParametro('passwordNuevo',$_POST),PASSWORD_DEFAULT);
					$usuario->save();
				} else {
					$error = true;
					$error_msg = 'Error: Password incorrecto. Los datos no fueron modificados.';
				}
			} else {
				$error = true;
				$error_msg = 'Error: Las nuevas contraseñas no coindiden.';
			}
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BudgetFork - Perfil Usuario</title>

<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
<link rel="stylesheet" href="./css/style.css">
</head>
<body>

	<header>
    <a href="./index.php">
    <div class="logo"><img src="img/logo-home2.png" alt="logotipo" class="logo1">
    </div>
	 </a>
		<nav>
      <li><a href="./recetas.php">Recetas</a></li>
      <li><a href="./preguntas.php">FAQ</a></li>
      <li><a href="./logout.php">Cerrar Sesion</a></li>
		</nav>
	</header>

	<section class="hero">
    <div class="background-image" style="background-image: url(img/back.jpg);"></div>
	</section>

	<section class="perfil">
	<h1>Bienvenido: <?= $usuario->apellido . ", " . $usuario->nombre ?></h1>
	<p><?= $usuario->email ?></p>

	<img src="<?= $usuario->avatar ?>" style="max-width: 200px;">

	<form method="post" enctype="multipart/form-data">

		<p>Datos de mi cuenta: </p>

		<div>
			<label for="nombre">Nombre:</label><br>
			<input type="text" name="nombre" value="<?= $usuario->nombre ?>">
		</div>

		<div>
			<label for="apellido">Apellido:</label><br>
			<input type="text" name="apellido" value="<?= $usuario->apellido ?>">
		</div>

		<div>
			<label for="edad">Edad:</label><br>
			<input type="text" name="edad" value="<?= $usuario->edad ?>">
		</div>

		<div><label for="imagenperfil">Nueva Imagen</label><br>
			 <input type="file" name="imagenperfil">
		 </div>

		<p>
			<input type="submit" name="actualizarDatos" value="Actualizar Datos">
		</p>
		</form>


		<form method="post" enctype="multipart/form-data">

		<?php if($error): ?>
		<span> <?= $error_msg ?> </span>
		<?php endif; ?>

		<div>
			<label for="password">Password Anterior:</label><br>
			<input type="password" name="password">
		</div>
		<div>
			<label for="passwordNuevo">Nuevo Password:</label><br>
			<input type="password" name="passwordNuevo">
		</div>
		<div>
			<label for="confirmarPasswordNuevo">Confirmar Password:</label><br>
			<input type="password" name="confirmarPasswordNuevo">
		</div>
		<p>
			<input type="submit" name="actualizarPassword" value="Cambiar Contraseña">
		</p>

	</form>
	</section>

</body>
</html>
