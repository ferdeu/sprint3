<?php

session_start();

require_once('./clases/Session.php');
require_once('./clases/Usuario.php');
require_once('./clases/DatabaseFactory.php');
require_once('./clases/DBMySQL.php');
require_once('./clases/DBJSON.php');
require_once('./funciones.php');

DatabaseFactory::$db_type = "DBMySQL";
// DatabaseFactory::$db_type = "DBJSON";
$session = Session::getInstancia();

?>
