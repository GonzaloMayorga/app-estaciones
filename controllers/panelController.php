<?php 
	$tpl = new Chess('views/panelView.html');

	$tpl->printToScreen();

	if (!isset($_SESSION[APP_NAME])) {
		header('Location: login');
	}

 ?>