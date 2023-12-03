<?php 
error_reporting(0);
	$tpl = new Chess('views/loginView.html');	
	if(isset($_POST['btn'])) {
		$email = $_POST['email'];
		$pass = $_POST['pass'];

		$loged = new User($email);
		$result = $loged->login($pass);
		if($result["errno"]==200){

			$_SESSION[APP_NAME] = array("email" => $email);
			
			$notify = new EmailEngine();
			$token = $loged->token();
			$state = $loged->userState();
			
			if($state['activo'] == '0'){
				session_unset();
				session_destroy();
				echo '<h1>Su usuario aún no
				se ha validado, revise su casilla de correo</h1>';
			}
			if($state['bloqueado'] == '1' && $state['activo'] == '1' || $state['recupero'] == '1'){
				session_unset();
				session_destroy();
				echo '<h1>Su usuario está bloqueado, revise su casilla de correo</h1>';
			}else{
				$notify->send("$email","Se inicio sesion","Detalles: Ip:".IP." SO and Browser:".SOBrow."
					<a href='".URL_WEB."blocked/".$token."'>No fui yo bloquear cuenta</a>");
				if($_POST['email'] == 'admin-estacion@gmail.com' && $_POST['pass'] == 'admin1234'){
					$_SESSION[APP_NAME] = array("email" => $email);
					header("Location: administrador");
				}else{
					header('Location: panel');
				}
			}
		}
		if($result["errno"] == 402 || $state['activo'] != 0 ){
			$_SESSION[APP_NAME] = array("email" => $email);
			$notify = new EmailEngine();
			$token = $loged->token();
			$notify->send("$email","Se intento inciar sesion","Detalles: Ip:".IP." SO and Browser:".SOBrow."
					<a href='".URL_WEB."blocked/".$token."'>No fui yo bloquear cuenta</a>");
			//var_dump($_SESSION[APP_NAME]);
		}

		$tpl->assign("RESULT_LOGIN", $result["error"]);
	}

	$tpl->printToScreen();
 ?>

 