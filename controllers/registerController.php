<?php 
	$tpl = new Chess('views/registerView.html');	

	
	
	if (isset($_POST['btn'])) {
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$confirmPass = $_POST['confirmPass'];

		if($pass != $confirmPass){
			echo "<h1>Las contraseñas no coinciden</h1>";
		}else{
		$register = new User($email);
		
		$result = $register->add($pass,$email);
		$token_action = $register->token_action($email);
		$notify = new EmailEngine();
		if($result["errno"] == 200){
			$notify->send("$email","Registro completado","Bienvenido a app estacion
				<a href=".URL_WEB."validate/".$token_action.">'Click aqui para activar su usuario'</a>");
			$_SESSION[APP_NAME] = array("email" => $email);

			}
			$tpl->assign("RESULT_REGISTER", $result["error"]);
		}
		
	}




$tpl->printToScreen();

 ?>