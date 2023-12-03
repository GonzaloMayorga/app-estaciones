<?php 
	$tpl = new Chess('views/panelView.html');

	$cliente = new trackerModel();
	//$cliente->captureClientInfo();
	//var_dump($cliente);
	//$cliente->Api();
	$tpl->printToScreen();
 ?>