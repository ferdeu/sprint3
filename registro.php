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
  <link rel="stylesheet" href="./css/reg.css">

</head>

<body>
  <header>
    <a href="./index.php">
    <div class="logo"><img src="img/logo-home2.png" alt="logotipo" class="logo1">
      </a>
    </div>
  </header>

  <h1>Registrate</h1>

  <form class="login" action="" method="post" enctype="multipart/form-data">
		<?php if($existeUsuario): ?>
			<p>
				<span>Error: El email ingresado (<?= $_POST['email'] ?>) ya existe en la base de datos. Por favor use un email diferente.</span>
			</p>
		<?php endif; ?>

			<div><label for="nombre">Nombre</label>
			<input type="text" name="nombre" class="input_text" value="<?= $nombre ?>" required >
			<?php if($error && !$nombre):?>
				<span>Ingrese su nombre</span>
			<?php endif; ?>
      </div>

			<div><label for="apellido">Apellido</label>
				<input type="text" name="apellido" class="input_text" value="<?= $apellido ?>" required >
  			<?php if($error && !$apellido):?>
  				<span>Ingrese su Apellido</span>
  			<?php endif; ?>
      </div>

			<div><label for="edad">Edad</label>
				<input type="text" name="edad" class="input_text" value="<?= $edad ?>" required >
				<?php if($error && !$edad):?>
					<span>Ingrese su Edad</span>
				<?php endif; ?>
			</div>

      <div><label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?= $email ?>" required>
  			<?php if($error && !$email):?>
  				<span>Ingrese su email</span>
  			<?php endif; ?>
      </div>

      <div><label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>
        <?php if($error && !$password):?>
  				<span>Ingrese su password</span>
  			<?php endif; ?>
      </div>

			<div><label for="confirmarpassword">Confirmar Contraseña</label>
				<input type="password" name="confirmarpassword" id="confirmarpassword" required>
				<?php if(($error && !$confirmarpassword) || ($password != $confirmarpassword)):?>
				<span>Las contraseñas no coinciden</span>
				<?php endif; ?>
			</div>


     <div><label for="imagenperfil">Foto de Perfil</label>
        <input type="file" name="imagenperfil">
        <?php  if($error && !$existeFile):?>
          <span>Ingrese su foto de perfil</span>
        <?php endif; ?>
      </div>

      <div class="actions">
        <input type="submit" name="registro" value="Registrarse">
				<a href="/forgot">Olvidé mi contraseña</a>
      </div>
  </form>


  <footer>
    <ul>
      <li><a href="./index.php"><h5>Home</i></h5></a></li>
      <li><a href="./presupuestos.php"><h5>Presupuestos</i></h5></a></li>
      <li><a href="./login.php"><h5>Login</i></h5></a></li>
      <li><a href="./faq.php"><h5>FAQ</i></h5></a></li>
    </ul>
  </footer>
</body>

</html>
