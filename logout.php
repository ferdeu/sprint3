<?php

require_once ('./include.php');

	if ($session->getUsuario()) {
		$session->logoutUsuario();
		header("Location: index.php");
		exit;
	}


?>
