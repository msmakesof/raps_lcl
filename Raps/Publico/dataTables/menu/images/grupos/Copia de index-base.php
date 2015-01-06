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

$colname_rs_empleados = "-1";
if (isset($_GET['id'])) {
  $colname_rs_empleados = $_GET['id'];
}
mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_empleados = sprintf("SELECT * FROM empleados WHERE cod_emp = %s", GetSQLValueString($colname_rs_empleados, "text"));
$rs_empleados = mysql_query($query_rs_empleados, $cnn_plan_mejora) or die(mysql_error());
$row_rs_empleados = mysql_fetch_assoc($rs_empleados);
$totalRows_rs_empleados = mysql_num_rows($rs_empleados);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..::: Inter Rapidísimo   -  Plan de Mejoramiento.   :::..</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content='IE=9' http-equiv='X-UA-Compatible'/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!—[if lt IE 9]>
  <script src="html5.js"></script>
<![endif]—>

<style>
  body { padding-top: 60px; }
</style>
<link rel="stylesheet" type="text/css" href="css/base.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/tablas.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/gral.css" media="all"/>


<script src="jquery181.js"></script>

</head>
<body>
 <form ACTION="" METHOD="POST" name="form1">
<div align="center">

<div class="container" id="general">
 <div id="" class="row">
  <div id="encabezado" class="span12">
	<div class="span2">&nbsp;</div>
    <div class="kfizq" id="logo"><img src="../imgs/logo.jpg" width="222" height="59" /></div>    
    <div class="kfder"><span class="txts">MODULO DE PLAN DE MANEJO - Lista de Auditor&iacute;as.</span></div>
       
 </div>
 </div>
 
 <div id="cuerpox">
 <table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="row">CODIGO</th>
    <td colspan="4"><?php echo $row_rs_empleados['cod_emp']; ?></td>
  </tr>
  <tr>
    <th scope="row">NOMBRE</th>
    <td colspan="4"><?php echo $row_rs_empleados['nombreEmp']; ?></td>
  </tr>
  <tr>
    <th scope="row">SUCURSAL</th>
    <td colspan="4"><?php echo $row_rs_empleados['cod_suc']; ?></td>
  </tr>
  <tr>
    <th scope="row">CARGO</th>
    <td colspan="4"><?php echo $row_rs_empleados['cod_car']; ?></td>
  </tr>
  <tr>
    <th scope="row">USUARIO</th>
    <td colspan="4"><label for="usuario"></label>
      <input name="usuario" type="text" id="usuario" size="30" /></td>
  </tr>
  <tr>
    <th scope="row">CLAVE</th>
    <td colspan="4"><label for="clave"></label>
      <input name="clave" type="text" id="clave" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <th scope="row">PERMISOS</th>
    <td><input type="checkbox" name="graba" id="graba" />
      <label for="graba">Graba</label></td>
    <td><input type="checkbox" name="modifica" id="modifica" />
      <label for="modifica">Modifica</label></td>
    <td><input type="checkbox" name="consulta" id="consulta" />
      <label for="consulta">Consulta</label></td>
    <td><input type="checkbox" name="borra" id="borra" />
      <label for="borra">Borra</label></td>
  </tr>
  <tr>
    <th scope="row">&nbsp;</th>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>

 
 
 </div>
 
 
 <div id="" class="row">
	<div id="footer" class="span12">
 	<span>Todos los derechos reservados - Inter Rapidísimo.</span>
 	</div>
 </div> 
   
</div>  

</div>

</form>
</body>
</html>
<?php
mysql_free_result($rs_empleados);
?>
