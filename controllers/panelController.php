<?php 
	$tpl = new Chess('views/panelView.html');

<<<<<<< HEAD
	$tpl->printToScreen();

	if (!isset($_SESSION[APP_NAME])) {
		header('Location: login');
	}

=======

	$tpl->printToScreen();

>>>>>>> 7cb22113204c5abd52be4282efb2abc19374cc86
 ?>