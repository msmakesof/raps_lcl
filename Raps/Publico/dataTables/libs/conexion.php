<?php
function Conectarse(){
	include("../../../Connections/cnn_encu.php");
	$servidor = $hostname_cnn_encu;
	$basededatos = $database_cnn_encu;
	$usuario = $username_cnn_encu;
	$clave = $password_cnn_encu;
	$cn = mysql_connect($servidor,$usuario,$clave) or die ("Error conectando a la base de datos");
	mysql_select_db($basededatos ,$cn) or die("Error seleccionando la Base de datos");
	mysql_query ("SET NAMES 'utf8'");
	return $cn;
	}
?>