<?php 
	$tpl = new Chess('views/validateView.html');	
	
	$_SECTION = explode("/", $_SERVER["REQUEST_URI"]);

	unset($_SECTION[0]);

	$_SECTION = array_values($_SECTION);

	$token_action = $_SECTION[4];

	$getToken = new User('capo@gmail.com');
	$active = $getToken->validate_token($token_action);
	if ($active["errno"] == 405) {
		echo $active["error"];
		echo '<a href="https://mattprofe.com.ar/alumno/3897/app-estacion/login">Volver al login</a>';
	}
	$email = $getToken->getEmaiByToken($token_action);
	$notify = new EmailEngine();
	$notify->send("$email", "usuario activo", "El usuario fue activado correctamente dentro de app-estacion");
	//header("Location: https://mattprofe.com.ar/alumno/3897/app-estacion/login");
	$tpl->printToScreen();
 ?>