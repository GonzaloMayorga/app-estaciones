<?php 
	define('HOST', 'localhost');
	define('USER', 'alumno'); // Nro de carnet
	define('PASS', 'alumno'); // clave de usuario
	define('DB', 'julio');

function query($sentence){
       	$db = new mysqli(HOST, USER, PASS, DB);
        $response = $db->query($sentence);
        if($response !== true){
            $result = $response->fetch_all(MYSQLI_ASSOC);
            return $result;
        }
        return -3;
    }
	
	
	var_dump(query($sql = "SELECT `ubicacion`, `apodo`, `visitas` FROM `estaciones`"));



 ?>