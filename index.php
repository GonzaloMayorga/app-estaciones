<?php 
<<<<<<< HEAD
	session_start();
	include 'env.php';
	include 'lib/chess.php';
	include 'models/dbAbstractModel.php';
	include 'models/userModel.php';
	include 'lib/EmailEngine.php';
	include 'lib/Mailer/src/PHPMailer.php';
	include 'lib/Mailer/src/SMTP.php';
	include 'lib/Mailer/src/Exception.php';
	
=======

	include 'lib/chess.php';
	include 'env.php';

>>>>>>> 7cb22113204c5abd52be4282efb2abc19374cc86
	$_SECTION = explode("/", $_SERVER["REQUEST_URI"]);

	unset($_SECTION[0]);

	$_SECTION = array_values($_SECTION);

	//var_dump($_SECTION);

	if($_SECTION[3]==""){
		$section = 'landing';	
	}else{
		$section = $_SECTION[3];

		if(!file_exists("controllers/{$section}Controller.php")){
			$section = 'error404';
		}
		
	}
<<<<<<< HEAD

	if(isset($_SESSION[APP_NAME])){
		if($section=='landing' || $section=='login' || $section=='register' || $section=='validate' || $section=='recovery' || $section=='reset'){
			header('Location: https://mattprofe.com.ar/alumno/3897/app-estacion/panel');
		}

	}else{ // Sesion no iniciada
		if($section=='panel' || $section=='logout' || $section=='landing' || $section=='detalle'){
			header('Location: https://mattprofe.com.ar/alumno/3897/app-estacion/login');
		}
	}
=======
>>>>>>> 7cb22113204c5abd52be4282efb2abc19374cc86
	
	//var_dump($section);
	include "controllers/{$section}Controller.php";

 ?>