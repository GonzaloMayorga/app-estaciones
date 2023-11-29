<?php 
	$tpl = new Chess('views/blockedView.html');	
	error_reporting(0);
	$_SECTION = explode("/", $_SERVER["REQUEST_URI"]);

	unset($_SECTION[0]);

	$_SECTION = array_values($_SECTION);

	$token_action = $_SECTION[4];

	$getToken = new User('capo@gmail.com');
	$blocked = $getToken->blocked_token($token_action);
	if ($blocked["errno"] == 407) {
		echo $blocked["error"];
	}else{
		$email = $getToken->getEmaiByToken($token_action);
		$notify = new EmailEngine();
		$notify->send("$email", "usuario bloqueado", "El usuario fue bloqueado correctamente
			<br>
			<a href='https://mattprofe.com.ar/alumno/3897/app-estacion/reset/".$token_action."'>Click aquí para cambiar contraseña</a>");
		echo '<h1>Usuario bloqueado exitosamente, revise su correo electronico</h1>';
	}
	$tpl->printToScreen();
 ?>