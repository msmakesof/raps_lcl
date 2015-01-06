<?php require_once('../Connections/cnn_plan_mejora.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

$colname_Recordset1 = "-1";
if (isset($_POST['usu'])) {
  $colname_Recordset1 = $_POST['usu'];
}
$cclave_Recordset1 = "-1";
if (isset($_POST['cla'])) {
  $cclave_Recordset1 = $_POST['cla'];
}
mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_Recordset1 = sprintf("SELECT usuario, clave FROM empleados WHERE usuario = %s ", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $cnn_plan_mejora) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

	if($totalRows_Recordset1 <= 0)
	{
		// Disponible
		echo $totalRows_Recordset1;
	}
	else{
		echo $totalRows_Recordset1;
	}

mysql_free_result($Recordset1);
?>