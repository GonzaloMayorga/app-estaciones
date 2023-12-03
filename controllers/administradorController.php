<?php  
	$tpl = new Chess('views/administradorView.html');
	if($_SESSION[APP_NAME]['email'] != 'admin-estacion@gmail.com'){
		header("Location: panel");
	}		
	$users = new User('');
	$clients = new trackerModel();
	$cantU = $users->getUsers();
	$cantC = $clients->getClients();
	$tpl->assign("CANTU", $cantU);
	$tpl->assign("CANTC", $cantC);
	$tpl->printToScreen();
?>