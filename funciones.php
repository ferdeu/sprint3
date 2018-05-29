<?php

	function existeParametro($nombre, $arrayDonde) {
		return array_key_exists($nombre, $arrayDonde);
	}

	function existeFileSinError($nombre) {
		if (existeParametro($nombre, $_FILES) && $_FILES[$nombre]['error'] === UPLOAD_ERR_OK) {
			return true;
		}
		return false;
	}

	function traerValorDeParametro($nombre, $arrayDonde, $default = null) {
		if (existeParametro($nombre, $arrayDonde) && !empty($arrayDonde[$nombre])) {
			return $arrayDonde[$nombre];
		}

		return $default;
	}


	function guardarArchivoSubido($nombreDelInputFile, $nombreTargetFile, $carpetaTarget) {
		if (array_key_exists($nombreDelInputFile, $_FILES)) {
			$file = $_FILES[$nombreDelInputFile];

			$nombre = $file['name'];
			$tmp = $file['tmp_name'];
			$ext = pathinfo($nombre, PATHINFO_EXTENSION);

			if(!file_exists($carpetaTarget)) {
				$old = umask(0);
				mkdir($carpetaTarget, 0777);
				umask($old);
			}

			$date = new DateTime();
			$urlcompleta = $carpetaTarget . $nombreTargetFile .$date->getTimestamp()."." . $ext;
			move_uploaded_file($tmp, $urlcompleta);
			return $urlcompleta;
		}
	}




?>
