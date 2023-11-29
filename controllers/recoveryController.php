<?php 
	
	$tpl = new Chess('views/recoveryView.html');	

	if(isset($_POST['btn'])) {
		$email = $_POST['email'];

		$loged = new User($email);
		$notify = new EmailEngine();
		$result = $loged->searchUser($email);
		$token_action = $loged->token_action($email);
		$notify->send("$email","Recuperacion de cuenta","Se le informa que se inicio el proceso de restablecimiento de contraseña <br>
			<a href='https://mattprofe.com.ar/alumno/3897/app-estacion/reset/".$token_action."'>Click Aqui para restablecer contraseña</a>");
		$tpl->assign("RESULT_ERROR", $result["error"]);
	}

	$tpl->printToScreen();


 ?>