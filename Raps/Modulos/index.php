<?php		
	session_start();
	$_SESSION['urlPrincipalIndex'] = "/var/www/Raps/index.php";
	$_SESSION["usuario"] = 'test'; // reemplazarlo por el real
	include($_SESSION['urlPrincipalIndex']);
	$titulo = 'Bienvenido';		
	$forma = "";	
	include("/var/www/Raps/template.php");	


?>
