<?php 
include("../Connections/cnn_plan_mejora.php");
session_start(); // start session.
if(isset($_SESSION["MM_Username"])){ // verifica si existe la sesion
// si existe la sesion asignamos  el idUser de la sesion
  $idUser=$_SESSION["MM_Username"]; 
}
//echo "sesion=".$idUser;  //$_SESSION['MM_Username'];

//$host="localhost"; // Host name //$username="root"; // Mysql username $password=""; // Mysql password $db_name="sifi"; // Database name
//$con = mysql_connect($host,$username,$password)   or die(mysql_error());
//mysql_select_db($db_name, $con)  or die(mysql_error());

//$hostname_cnn_plan_mejora = "localhost";
//$database_cnn_plan_mejora = "sifi";
//$username_cnn_plan_mejora = "root";
//$password_cnn_plan_mejora = "";

$con = mysql_connect($hostname_cnn_plan_mejora,$username_cnn_plan_mejora,$password_cnn_plan_mejora)   or die(mysql_error());
mysql_select_db($database_cnn_plan_mejora, $con)  or die(mysql_error());


$q = strtolower($_GET["id"]);
if (!$q) return;

$sql = "DELETE FROM empleados WHERE cod_emp = '$q'";
//echo $sql;
$rsd = mysql_query($sql);
?>