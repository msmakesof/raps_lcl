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

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_cen_costos = "SELECT * FROM cen_costos ORDER BY nombre_cen_costos ASC";
$rs_cen_costos = mysql_query($query_rs_cen_costos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_cen_costos = mysql_fetch_assoc($rs_cen_costos);
$totalRows_rs_cen_costos = mysql_num_rows($rs_cen_costos);

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_cargos = "SELECT * FROM cargos ORDER BY nom_car ASC";
$rs_cargos = mysql_query($query_rs_cargos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_cargos = mysql_fetch_assoc($rs_cargos);
$totalRows_rs_cargos = mysql_num_rows($rs_cargos);

//
session_start(); // start session.
if(isset($_SESSION["MM_Username"])){ // verifica si existe la sesion
// si existe la sesion asignamos  el idUser de la sesion
  $idUser=$_SESSION["MM_Username"]; 
}
//echo "sesion=".$idUser;  //$_SESSION['MM_Username']
//

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO empleados (cod_emp, nombreEmp, cod_suc, cod_car, usuario, clave) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod_emp'], "int"),
					   GetSQLValueString($_POST['nombreEmp'], "text"),
					   GetSQLValueString($_POST['cod_suc'], "text"),
					   GetSQLValueString($_POST['cod_car'], "text"),
					   GetSQLValueString($_POST['usuario'], "text"),
					   GetSQLValueString($_POST['clave'], "text"));

  mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
  $Result1 = mysql_query($insertSQL, $cnn_plan_mejora) or die(mysql_error());

//  $insertGoTo = "index.php";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
//    $insertGoTo .= $_SERVER['QUERY_STRING'];
//  }
//  header(sprintf("Location: %s", $insertGoTo));
}

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
<script language="JavaScript" type="text/JavaScript">
<!--
function graba(formName,action)
{
	if (document.form1.cod_emp.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Código.");
		return;
	}
	if (document.form1.nombreEmp.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Nombre.");
		return;
	}
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
	form1.MM_insert.value = "form1" ;
		
    action = "submit" ; 	  
	var myString = "document."+formName+"."+action+"();";
	eval(myString);	
	
	}
//-->
</script>


</head>
<body>
 <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
<div align="center">

<div class="container" id="general">
 <div id="" class="row">
  <div id="encabezado" class="span12">
	<div class="span2">&nbsp;</div>
    <div class="kfizq" id="logo"><img src="../imgs/logo.jpg" width="222" height="59" /></div>    
    <div class="kfder"><span class="txts">MODULO DE PLAN DE MANEJO - Creando Empleados.</span></div>
       
 </div>
 </div>
 
 <div id="cuerpox">
 <table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="titheaders">CODIGO</td>
    <td class="titcont">
      <input name="cod_emp" type="text" id="cod_emp" value="<?php echo $row_rs_tipo_auditoria['cod_emp']; ?>" size="20" maxlength="20" />
    </td>
  </tr>
  <tr>
    <td class="titheaders">NOMBRE</td>
    <td class="titcont">
      <input name="nombreEmp" type="text" id="nombreEmp" value="<?php echo $row_rs_tipo_auditoria['nombreEmp']; ?>" size="60" maxlength="80" />
    </td>
  </tr>
    <tr>
    <td class="titheaders">SUCURSAL</td>
    <td class="titcont">
      <select name="cod_suc" id="cod_suc">
        <option value="">Seleccione</option>
        <option value="">........................</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rs_cen_costos['codigo_cen_costos']?>"><?php echo $row_rs_cen_costos['nombre_cen_costos']?></option>
        <?php
} while ($row_rs_cen_costos = mysql_fetch_assoc($rs_cen_costos));
  $rows = mysql_num_rows($rs_cen_costos);
  if($rows > 0) {
      mysql_data_seek($rs_cen_costos, 0);
	  $row_rs_cen_costos = mysql_fetch_assoc($rs_cen_costos);
  }
?>
      </select>
    </td>
  </tr>
  <tr>
  	<td class="titheaders">CARGO</td>
    <td class="titcont"><select name="cod_car">
      <option value="">Seleccione</option>
      <option value="value">---------</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rs_cargos['cod_car']?>"><?php echo $row_rs_cargos['nom_car']?></option>
      <?php
} while ($row_rs_cargos = mysql_fetch_assoc($rs_cargos));
  $rows = mysql_num_rows($rs_cargos);
  if($rows > 0) {
      mysql_data_seek($rs_cargos, 0);
	  $row_rs_cargos = mysql_fetch_assoc($rs_cargos);
  }
?>
    </select>
    </td></tr>
  <tr>
    <td class="titheaders">USUARIO</td>
    <td class="titcont">
      <input name="usuario" type="text" id="usuario" value="" size="60" maxlength="80" />
    </td>
  </tr>
  <tr>
    <td class="titheaders">CLAVE</td>
    <td class="titcont">
      <input name="clave" type="password" id="clave" value="" size="30" maxlength="30" />
    </td>
  </tr>

</table>
<br>
 <table width="200" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td align="center">
       <input type="button" name="grabar" id="grabar" value="Grabar" onclick="graba('form1','submit')"/>
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
<input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rs_cen_costos);

mysql_free_result($rs_cargos);
?>
