<?php

class DBJSON {

  public function find($id, $table, $class)
  {
    $usuarios = json_decode(file_get_contents("$table.json"),true);
		if (is_null($usuarios)) {
			$usuarios = ['usuarios' => []];
		}
		$existe = false;
		$usuarioEncontrado = null;
    if ($usuarios){
  		foreach ($usuarios['usuarios'] as $indice => $usuario) {
  			if ($usuario['id'] == $id) {
  				$existe = true;
  				$usuarioEncontrado = $usuario;
  			}
  		}
    }
    $model = new $class([]);
    $model->toModel($usuarioEncontrado);
    return $model;
  }

  public function findByCampoString($campo, $valorcampo, $table, $class)
  {
    $usuarios = json_decode(file_get_contents("$table.json"),true);
		if (is_null($usuarios)) {
			$usuarios = ['usuarios' => []];
		}
		$existe = false;
		$usuarioEncontrado = null;
    if ($usuarios){
  		foreach ($usuarios['usuarios'] as $indice => $usuario) {
  			if ($usuario[$campo] == $valorcampo) {
  				$existe = true;
  				$usuarioEncontrado = $usuario;
  			}
  		}
    }

    $model = new $class([]);
    $model->toModel($usuarioEncontrado);
    return $model;
  }

  public function save($table, $model)
  {
    $usuarios = json_decode(file_get_contents("$table.json"),true);
    if (is_null($usuarios)) {
      $usuarios = ['usuarios' => []];
    }
      $usuarios['usuarios'][] = $model;
    file_put_contents('usuarios.json', json_encode($usuarios,JSON_PRETTY_PRINT));
  }

}
