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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE grupo_noconformidades SET id_grupo=%s, nombre_corto=%s, nombre_grupo=%s, estado=%s, dueno=%s WHERE id=%s",
						 GetSQLValueString($_POST['id_grupo'], "int"),
						 GetSQLValueString($_POST['nombre_corto'], "text"),
						 GetSQLValueString($_POST['nombre_grupo'], "text"),
					   GetSQLValueString($_POST['estado'], "text"),
						 GetSQLValueString($_POST['procesos'], "text"),
             GetSQLValueString($_POST['hf_id'], "int"));

  mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
  $Result1 = mysql_query($updateSQL, $cnn_plan_mejora) or die(mysql_error());
}

$colname_rs_empleados = "-1";
if (isset($_GET['id'])) {
  $colname_rs_empleados = $_GET['id'];
}
mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_empleados = sprintf("SELECT * FROM grupo_noconformidades WHERE id = %s", GetSQLValueString($colname_rs_empleados, "int"));
$rs_empleados = mysql_query($query_rs_empleados, $cnn_plan_mejora) or die(mysql_error());
$row_rs_empleados = mysql_fetch_assoc($rs_empleados);
$totalRows_rs_empleados = mysql_num_rows($rs_empleados);

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_estados = "SELECT * FROM estados ORDER BY nombre_estados ASC";
$rs_estados = mysql_query($query_rs_estados, $cnn_plan_mejora) or die(mysql_error());
$row_rs_estados = mysql_fetch_assoc($rs_estados);
$totalRows_rs_estados = mysql_num_rows($rs_estados);

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_procesos = "SELECT procesos.* FROM procesos JOIN procesosxannio ON procesosxannio.annio = '2014' AND procesos.abr2 = procesosxannio.abr2 WHERE estado = 'A' AND tipo IN ('D','S','R','C') ORDER BY proceso ASC";
$rs_procesos = mysql_query($query_rs_procesos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_procesos = mysql_fetch_assoc($rs_procesos);
$totalRows_rs_procesos = mysql_num_rows($rs_procesos);
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
<script src="../jquery181.js"></script>

<script>
$(document).ready(function() {    
    $('#usuario').blur(function(){
		//alert("mks");
		var username = $('#id_grupo').val(); 
		var claves = $('#nombre_grupo').val();
			
        if(username == "" || claves ==""){
			$('#disponible').fadeIn(100).html('<font color="red" size="2"> Debe ingresar información en Id del Grupo y/o Nombre del Grupo.</font>');
		}
		else{
			$('#disponible').html('<img src="indicator_green.gif" alt="" />').fadeOut(0);
	        
			var dataString = 'usu='+username+"&cla="+claves;
	
			$.ajax({
				type: "POST",
				url: "verifik.php",
				data: dataString,
				success: function(data) {
					if(data==0)
					{
						
						$('#grabar').attr("disabled", false);
						$("#disponible").text('Nombre de Grupo Disponible!').show().css('color', 'green').fadeOut(7000);
						return true;						
					}
					else
					{
						$('#usuario').focus();
						$('#grabar').attr("disabled", true);	
						$("#disponible").text('Nombre de Grupo NO Disponible!').show().css('color', 'red').fadeOut(4000);      
						return false;	
					}
					
				}
			});
		}
    });
	     
});
</script>



<script language="javascript" type="text/javascript">
function grabar(p1,p2)
{
	//alert("111");	
}
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
    <div class="kfder"><span class="txts">MODULO DE PLAN DE MANEJO - Lista de Grupos.</span></div>
       
 </div>
 </div>
 
 <div id="cuerpox">
 <table width="90%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <th scope="row" class="titheaders">ID GRUPO</th>
    <td colspan="4" align="left"><label for="id_grupo"></label>
      <input name="id_grupo" type="text" id="id_grupo" value="<?php echo $row_rs_empleados['id_grupo']; ?>" size="30" />
      <div id="disponible"></div>
      </td>
  </tr>
  <tr>
    <th scope="row" class="titheaders">NOMBRE CORTO</th>
    <td colspan="4" align="left"><label for="nombre_corto"></label>
			<textarea name="nombre_corto" cols="60" rows="4" id="nombre_corto"><?php echo $row_rs_empleados['nombre_corto']; ?></textarea></td>
  </tr>
	<tr>
    <th scope="row" class="titheaders">NOMBRE GRUPO</th>
    <td colspan="4" align="left"><label for="nombre_grupo"></label>
			<textarea name="nombre_grupo" cols="60" rows="4" id="nombre_grupo"><?php echo $row_rs_empleados['nombre_grupo']; ?></textarea></td>
  </tr>
  <tr>
    <th scope="row" class="titheaders">ESTADO</th>
    <td align="left" colspan="4">
      <select name="estado" id="estado">
      	<option value="" <?php if (!(strcmp("", trim($row_rs_empleados['estado'])))) {echo "selected=\"selected\"";} ?>>Selecione ...</option>
      	<option value="" <?php if (!(strcmp("", trim($row_rs_empleados['estado'])))) {echo "selected=\"selected\"";} ?>>--------------</option>
      	<?php
do {  
?>
      	<option value="<?php echo $row_rs_estados['cod_estados']?>"<?php if (!(strcmp($row_rs_estados['cod_estados'], trim($row_rs_empleados['estado'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_estados['nombre_estados']?></option>
      	<?php
} while ($row_rs_estados = mysql_fetch_assoc($rs_estados));
  $rows = mysql_num_rows($rs_estados);
  if($rows > 0) {
      mysql_data_seek($rs_estados, 0);
	  $row_rs_estados = mysql_fetch_assoc($rs_estados);
  }
?>
			</select>
    </td>
  </tr>

  <tr>
    <th scope="row" class="titheaders">PROCESO DUEÑO</th>
    <td colspan="4">
		<select name="procesos" id="procesos">
			<option value="" <?php if (!(strcmp("", trim($row_rs_empleados['dueno'])))) {echo "selected=\"selected\"";} ?>>Seleccione.........</option>
			<option value="" <?php if (!(strcmp("", trim($row_rs_empleados['dueno'])))) {echo "selected=\"selected\"";} ?>>--------------------</option>
			<?php
do {  
?>
<option value="<?php echo $row_rs_procesos['abr']?>"<?php if (!(strcmp($row_rs_procesos['abr'], trim($row_rs_empleados['dueno'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_procesos['proceso']?></option>
			<?php
} while ($row_rs_procesos = mysql_fetch_assoc($rs_procesos));
  $rows = mysql_num_rows($rs_procesos);
  if($rows > 0) {
      mysql_data_seek($rs_procesos, 0);
	  $row_rs_procesos = mysql_fetch_assoc($rs_procesos);
  }
?>
			</select>
		
		</td>
  </tr>
  
</table>
<table width="60" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><input type="submit" name="grabar" id="grabar" value="Grabar" onclick="javascript:grabar('form1','submit')"/></td>
  </tr>
</table>

<input name="hf_id" type="hidden" value="<?php echo  $_GET['id']; ?>" />
 </div>
 
 
 <div id="" class="row">
	<div id="footer" class="span12">
 	<span>Todos los derechos reservados - Inter Rapidísimo.</span>
 	</div>
 </div> 
   
</div>  

</div>
<input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rs_empleados);
mysql_free_result($rs_estados);
mysql_free_result($rs_procesos);
?>