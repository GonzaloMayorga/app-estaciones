<?php 
$tpl = new Chess('views/mapView.html');
 if($_SESSION[APP_NAME]['email'] != 'admin-estacion@gmail.com'){
	header("Location: panel");
 }	

$tpl->printToScreen();
?>