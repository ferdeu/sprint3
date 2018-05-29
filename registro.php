<?php

require_once ('./include.php');

if($session->estaLogeado()) {
	header("Location: perfil.php");
	exit;
}

$existeUsuario = false;
$error = false;
$nombre = traerValorDeParametro('nombre',$_POST);
$apellido = traerValorDeParametro('apellido',$_POST);
$edad = traerValorDeParametro('edad',$_POST);
$email = traerValorDeParametro('email',$_POST);
$password = traerValorDeParametro('password',$_POST);
$confirmarpassword = traerValorDeParametro('confirmarpassword',$_POST);
$existeFile = existeFileSinError('imagenperfil');


	if (existeParametro('registro', $_POST)) {
			$usuario = New Usuario($_POST);
			$existeUsuario = Usuario::findByCampoString('email', $_POST['email']);
				if (!$existeUsuario->email){
					$existeUsuario = false;
					if($password == $confirmarpassword){
							if ($existeFile){
								$usuario->avatar = guardarArchivoSubido('imagenperfil', 'imagen_perfil_','./avatar/');
							}
						$usuario->password = password_hash($usuario->password,PASSWORD_DEFAULT);
						$usuario->save();
						$session->loginUsuario($usuario);
						header("Location: index.php");
						exit;
					} else {
						$error = true;
					}
				} else {
					$existeUsuario = true;
					$error = true;
				}
	}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BudgetFork</title>

	<link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
  <link rel="stylesheet" href="./css/estilo.css">

</head>

<body>
  <form class="login" action="" method="post" enctype="multipart/form-data">
		<div class="imgcontainer"><a href="./index.php">
			<img src="img/logo-home2.png" alt="Avatar" class="avatar"></a>
		</div>
		  <h1>Registrate!</h1>
		<?php if($existeUsuario): ?>
			<p>
				<span>Error: El email ingresado (<?= $_POST['email'] ?>) ya existe en la base de datos. Por favor use un email diferente.</span>
			</p>
		<?php endif; ?>
		<div class="container">
			<div><label for="nombre"><b>Nombre<b/></label>
			<input type="text" name="nombre" class="input_text" value="<?= $nombre ?>" required >
			<?php if($error && !$nombre):?>
				<span>Ingrese su nombre</span>
			<?php endif; ?>
      </div>

			<div><label for="apellido"><b>Apellido</b></label>
				<input type="text" name="apellido" class="input_text" value="<?= $apellido ?>" required >
  			<?php if($error && !$apellido):?>
  				<span>Ingrese su Apellido</span>
  			<?php endif; ?>
      </div>

			<div><label for="edad"><b>Edad</b></label>
				<input type="text" name="edad" class="input_text" value="<?= $edad ?>" required >
				<?php if($error && !$edad):?>
					<span>Ingrese su Edad</span>
				<?php endif; ?>
			</div>

      <div><label for="email"><b>Email</b></label>
        <input type="text" name="email" id="email" value="<?= $email ?>" required>
  			<?php if($error && !$email):?>
  				<span>Ingrese su email</span>
  			<?php endif; ?>
      </div>

      <div><label for="password"><b>Contraseña</b></label>
        <input type="password" name="password" id="password" required>
        <?php if($error && !$password):?>
  				<span>Ingrese su password</span>
  			<?php endif; ?>
      </div>

			<div><label for="confirmarpassword"><b>Confirmar Contraseña</b></label>
				<input type="password" name="confirmarpassword" id="confirmarpassword" required>
				<?php if(($error && !$confirmarpassword) || ($password != $confirmarpassword)):?>
				<span>Las contraseñas no coinciden</span>
				<?php endif; ?>
			</div>


     <div style="padding: 2% 0;"><label for="imagenperfil"><b>Foto de Perfil</b></label>
        <input type="file" name="imagenperfil">
        <?php  if($error && !$existeFile):?>
          <span>Ingrese su foto de perfil</span>
        <?php endif; ?>
      </div>
			<a href="/forgot" style="text-decoration: none;">Olvidé mi contraseña</b>
      <div class="actions">
        <button type="submit" name="registro" value="Registrarse">Registrarse</button>
      </div>
			<div class="container" style="background-color:#f1f1f1">
			<footer>
					<li><a href="./index.php" style="text-decoration:none;color:black"><h5>Home</i></h5></a></li>
			</footer>
			</div>
		</div>
  </form>
</body>
</html>
