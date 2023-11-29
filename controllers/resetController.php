<?php 
	$tpl = new Chess('views/resetView.html');	

	$_SECTION = explode("/", $_SERVER["REQUEST_URI"]);

	unset($_SECTION[0]);

	$_SECTION = array_values($_SECTION);

	$token_action = $_SECTION[4];

	$user = new User('capo@gmail.com');
	$notify = new EmailEngine();
	$getEmail = $user->getEmaiByToken($token_action);
	if ($getEmail == null) {
		echo "<h1>El token no es valido</h1>";
		die();
	}
	if (isset($_POST['boton'])) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			$user->newPass($getEmail,$_POST['pass1']);
			$notify->send("$getEmail","Contraseña restablecida","Detalles: Ip:".IP." SO and Browser:".SOBrow."
					<a href='".URL_WEB."blocked/".$token_action."'>No fui yo bloquear cuenta</a>");
			header("Location: https://mattprofe.com.ar/alumno/3897/app-estacion/login");
		}else{
			echo "<h1>Repetir Contraseña</h1>";
		}
	}

	$tpl->printToScreen();

 ?>