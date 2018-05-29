<?php

require_once 'Database.php';
require_once 'Modelo.php';

class Usuario extends Modelo {
  public $id;
  public $nombre;
  public $apellido;
  public $email;
  public $password;
  public $edad;
  public $avatar;

  public $fillable = ['nombre', 'apellido', 'email', 'password', 'edad', 'avatar', ];
  public static $table = 'usuarios';

}



 ?>
