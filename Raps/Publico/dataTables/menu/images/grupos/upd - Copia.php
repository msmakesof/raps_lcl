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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_rs_tipo_auditoria = "-1";
if (isset($_GET['id'])) {
  $colname_rs_tipo_auditoria = $_GET['id'];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE empleados SET usuario=%s, clave=%s, graba=%s, modifica=%s, consulta=%s, borra=%s WHERE cod_emp=%s",
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString(isset($_POST['graba']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modifica']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['consulta']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['borra']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_GET['id'], "text"));

  mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
  $Result1 = mysql_query($updateSQL, $cnn_plan_mejora) or die(mysql_error());
  
  echo $updateSQL;
}
//
session_start(); // start session.
if(isset($_SESSION["MM_Username"])){ // verifica si existe la sesion
// si existe la sesion asignamos  el idUser de la sesion
  $idUser=$_SESSION["MM_Username"]; 
}
//echo "sesion=".$idUser;  //$_SESSION['MM_Username']
//


mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_tipo_auditoria = sprintf("SELECT empleados.*, cen_costos.nombre_cen_costos, cargos.nom_car FROM empleados LEFT JOIN cen_costos ON cen_costos.codigo_cen_costos = empleados.cod_suc LEFT JOIN cargos ON cargos.cod_car = empleados.cod_car WHERE cod_emp = %s", GetSQLValueString($colname_rs_tipo_auditoria, "text"));
$rs_tipo_auditoria = mysql_query($query_rs_tipo_auditoria, $cnn_plan_mejora) or die(mysql_error());
$row_rs_tipo_auditoria = mysql_fetch_assoc($rs_tipo_auditoria);
$totalRows_rs_tipo_auditoria = mysql_num_rows($rs_tipo_auditoria);
//echo $query_rs_tipo_auditoria;

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_cargos = "SELECT * FROM cargos ORDER BY nom_car ASC";
$rs_cargos = mysql_query($query_rs_cargos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_cargos = mysql_fetch_assoc($rs_cargos);
$totalRows_rs_cargos = mysql_num_rows($rs_cargos);

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_cen_costos = "SELECT * FROM cen_costos ORDER BY nombre_cen_costos ASC";
$rs_cen_costos = mysql_query($query_rs_cen_costos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_cen_costos = mysql_fetch_assoc($rs_cen_costos);
$totalRows_rs_cen_costos = mysql_num_rows($rs_cen_costos);
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
  <script src="../html5.js"></script>
<![endif]—>

<style>
  body { padding-top: 60px; }
</style>
<link rel="stylesheet" type="text/css" href="css/base.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/tablas.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/gral.css" media="all"/>

<script src="../jquery181.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function graba(formName,action)
{
	alert("mks");
	if (document.form1.usuario.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Usuario.");
		return;
	}

	if (document.form1.clave.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Clave.");
		return;
	}

	document.form1.MM_update.value = "form1" ;
		
    action = "submit" ; 	  
	var myString = "document."+formName+"."+action+"();";
	eval(myString);		
	}
//-->
</script>

</head>
<body>
 <form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
<div align="center">

<div class="container" id="general">
 <div id="" class="row">
  <div id="encabezado" class="span12">
	<div class="span2">&nbsp;</div>
    <div class="kfizq" id="logo"><img src="../imgs/logo.jpg" width="222" height="59" /></div>    
    <div class="kfder"><span class="txts">MODULO DE PLAN DE MANEJO - Administrador de Usuarios.</span></div>
       
 </div>
 </div>
 
 <div id="cuerpox">
 <table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col" class="titheaders">CODIGO</th>
    <th colspan="4" align="left" scope="col"><span class="titcont"><?php echo $row_rs_tipo_auditoria['cod_emp']; ?></span></th>
  </tr>
  <tr>
    <td height="26" class="titheaders">NOMBRE</td>
    <td colspan="4" align="left" scope="col"><span class="titcont"><?php echo $row_rs_tipo_auditoria['nombreEmp']; ?></span></td>
  </tr>

  <tr>
    <td height="26" class="titheaders">SUCURSAL</td>
    <td colspan="4" align="left" scope="col"><span class="titcont"><?php echo $row_rs_tipo_auditoria['nombre_cen_costos']; ?></span></td>
  </tr>

  <tr>
    <td height="26" class="titheaders">CARGO</td>
    <td colspan="4" align="left" scope="col"><span class="titcont"><?php echo $row_rs_tipo_auditoria['nom_car']; ?></span></td>
  </tr>
  
    <tr>
    <td height="26" class="titheaders">USUARIO</td>
    <td colspan="4" scope="col"><span class="titcont"><input name="usuario" type="text" id="usuario" value="<?php echo $row_rs_tipo_auditoria['usuario']; ?>" size="60" maxlength="80" />
    </span><span class="obligatxt">*</span></td>
  </tr>
    <tr>
    <td height="26" class="titheaders">CLAVE</td>
    <td colspan="4" scope="col"><span class="titcont"><input name="clave" type="text" id="clave" value="<?php echo $row_rs_tipo_auditoria['clave']; ?>" size="60" maxlength="80" />
    </span>
      <span class="obligatxt">*</span></td>
  </tr>
    <tr>
      <td height="26" class="titheaders">PERMISOS</td>
      <td scope="col"><input <?php if (!(strcmp($row_rs_tipo_auditoria['graba'],"Y"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="graba" id="graba" />
        <label for="graba">Graba</label></td>
      <td scope="col"><input <?php if (!(strcmp($row_rs_tipo_auditoria['consulta'],"Y"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="consulta" id="consulta" />
        Consulta</label></td>
      <td scope="col"><input <?php if (!(strcmp($row_rs_tipo_auditoria['modifica'],"Y"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="modifica" id="modifica" />
        Modifica</label></td>
      <td scope="col"><input <?php if (!(strcmp($row_rs_tipo_auditoria['borra'],"Y"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="borra" id="borra" />
        Borra</label></td>
    </tr>
 </table>
<br>
 <table width="200" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td align="center">
       <input type="button" name="grabar" id="grabar" value="Grabar" onclick="graba('form1','submit')" />
     </td>
     </tr>
 </table>
 <p>&nbsp;</p>
 </div>
 
 
 <div id="" class="row">
	<div id="footer" class="span12">
 	<span>Todos los derechos reservados - Inter Rapidísimo.</span>
 	</div>
 </div> 
   
</div>  

</div>
<input type="hidden" name="hfbuscar" value="F">
<input type="hidden" name="hf_ta" value="<?php echo $row_rs_tipo_auditoria['cod_emp']; ?>">
<input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rs_tipo_auditoria);

mysql_free_result($rs_cargos);

mysql_free_result($rs_cen_costos);
?>
