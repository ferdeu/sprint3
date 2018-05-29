<?php

require_once('Usuario.php');

class Session {

	protected static $instancia;

	private function __construct() {

	}

	public static function getInstancia() {
		if (self::$instancia) {
			return self::$instancia;
		}
		return self::$instancia = new self();
	}

	public function loginUsuario(Usuario $usuario) {
		$_SESSION['usuario'] = serialize($usuario);
	}

	public function logoutUsuario() {
		session_destroy();
	}

	public function estaLogeado() {
		return (!empty($_SESSION['usuario']));
	}

	public function getUsuario() {
		if ($this->estaLogeado()) {
			return unserialize($_SESSION['usuario']);
		}
		return False;
	}


}
