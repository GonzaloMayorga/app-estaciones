<?php 
	
	$tpl = new Chess('views/detalleView.html');

	$_SECTION = explode("/", $_SERVER["REQUEST_URI"]);

	unset($_SECTION[0]);

	$_SECTION = array_values($_SECTION);

	$chipId = $_SECTION[4];

	$tpl->assign("CHIPID", $chipId);
	$tpl->printToScreen();

 ?>