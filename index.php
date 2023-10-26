<?php 

	include 'lib/chess.php';
	include 'env.php';

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
	
	//var_dump($section);
	include "controllers/{$section}Controller.php";

 ?>