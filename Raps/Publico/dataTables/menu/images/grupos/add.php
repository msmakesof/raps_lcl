<?php require_once('../Connections/cnn_plan_mejora.php'); ?>
<script src="../js/jquery-1.8.3.js"></script>	
<?php
//session_start(); // start session.
//if(isset($_SESSION["MM_Username"])){ // verifica si existe la sesion
//// si existe la sesion asignamos  el idUser de la sesion
//  $idUser=$_SESSION["MM_Username"]; //
//}

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  	$insertSQL = sprintf("INSERT INTO grupo_noconformidades (id_grupo, nombre_corto, nombre_grupo, estado, dueno) VALUES (%s, %s, %s, %s, %s)",
			 GetSQLValueString($_POST['id_grupo'], "int"),
			 GetSQLValueString($_POST['nombre_corto'], "text"),
			 GetSQLValueString($_POST['nombre_grupo'], "text"),
			 GetSQLValueString($_POST['estado'], "text"),
			 GetSQLValueString($_POST['procesos'], "text"));

   mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
   $Result1 = mysql_query($insertSQL, $cnn_plan_mejora) or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function(){
    $("#mjx").css({ color: "#FFFFFF", background: "#CC0000", font: "Verdana", size: 11}).html("<p><div align='center'>REGISTRO HA SIDO GRABADO correctamente!!!</div></p>").fadeOut(3000);
});

</script>
<?php
}

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_cargos = "SELECT * FROM grupo_noconformidades ORDER BY nombre_grupo ASC";
$rs_cargos = mysql_query($query_rs_cargos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_cargos = mysql_fetch_assoc($rs_cargos);
$totalRows_rs_cargos = mysql_num_rows($rs_cargos);

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
//$query_rs_procesos = "SELECT * FROM procesos WHERE tipo = 'D' ORDER BY proceso ASC";
$query_rs_procesos = "SELECT procesos.* FROM procesos JOIN procesosxannio ON procesosxannio.annio = '2014' AND procesos.abr2 = procesosxannio.abr2 WHERE estado = 'A' AND tipo IN ('D','S','R','C') ORDER BY proceso ASC";
$rs_procesos = mysql_query($query_rs_procesos, $cnn_plan_mejora) or die(mysql_error());
$row_rs_procesos = mysql_fetch_assoc($rs_procesos);
$totalRows_rs_procesos = mysql_num_rows($rs_procesos);

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_estados = "SELECT * FROM estados ORDER BY nombre_estados ASC";
$rs_estados = mysql_query($query_rs_estados, $cnn_plan_mejora) or die(mysql_error());
$row_rs_estados = mysql_fetch_assoc($rs_estados);
$totalRows_rs_estados = mysql_num_rows($rs_estados);
?>
<!DOCTYPE html>
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
$(document).ready(function() {
	//alert(7);	
		var $preg = $('div#id_grupod').html('<p><img src=indicator.gif" />');
				dataString = ""; //"guia="+xguia+"&tn="+xtiponov;
				$.ajax({
				type: "POST",
				url: "../vefguia.php",
				data: dataString,
				success: function(data) {
						$('#id_grupod').html(data);				
				}
		});	
});
</script>
<script language="JavaScript" type="text/JavaScript">
function graba(formName,action)
{
	if (document.form1.id_grupo.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Código.");
		return;
	}
	if (document.form1.nombre_corto.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Nombre Corto.");
		return;
	}
	if (document.form1.nombre_grupo.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Nombre Grupo.");
		return;
	}
	if (document.form1.estado.value == "")
	{
		alert("ATENCION: Debe ingresar informacion en el campo Estado.");
		return;
	}

	form1.MM_insert.value = "form1" ;		
  action = "submit" ; 	  
	var myString = "document."+formName+"."+action+"();";
	eval(myString);		
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
    <div class="kfder"><span class="txts">MODULO DE PLAN DE MANEJO - Creando Empleados.</span></div>
       
 </div>
 </div>
 
 <div id="cuerpox">
 <table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="titheaders">ID GRUPO</td>
    <td align="left">
      <!--<input name="id_grupo" type="text" id="id_grupo" value="<?php //echo $grp_sigue?>" size="20" maxlength="20" readonly="readonly" />-->
			<div id='id_grupod'></div>
    </td>
  </tr>
  <tr>
    <td class="titheaders">NOMBRE CORTO</td>
    <td align="left"><textarea name="nombre_corto" cols="60" rows="4" id="nombre_corto"></textarea>
    </td>
  </tr>
 
  <tr>
    <td class="titheaders">NOMBRE GRUPO</td>
    <td align="left"><textarea name="nombre_grupo" cols="60" rows="4" id="nombre_grupo"></textarea>
    </td>
  </tr>
 
  <tr>
    <td class="titheaders">ESTADO</td>
    <td align="left">
      <select name="estado" id="estado">
      	<option value="">Selecione ...</option>
      	<option value="">--------------</option>
      	<?php
do {  
?>
      	<option value="<?php echo $row_rs_estados['cod_estados']?>"><?php echo $row_rs_estados['nombre_estados']?></option>
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
  	<td class="titheaders">PROCESO DUEÑO</td>
  	<td align="left"><label for="procesos"></label>
  		<select name="procesos" id="procesos">
  			<option value="">Seleccione.........</option>
  			<option value="">--------------------</option>
  			<?php
do {  
?>
  			<option value="<?php echo $row_rs_procesos['abr2']?>"><?php echo $row_rs_procesos['proceson']?></option>
  			<?php
} while ($row_rs_procesos = mysql_fetch_assoc($rs_procesos));
  $rows = mysql_num_rows($rs_procesos);
  if($rows > 0) {
      mysql_data_seek($rs_procesos, 0);
	  $row_rs_procesos = mysql_fetch_assoc($rs_procesos);
  }
?>
			</select></td>
  	</tr>
  </table>
<br><div id="mjx"></div>
 <table width="200" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td align="center">
       <input type="button" name="grabar" id="grabar" value="Grabar" onclick="graba('form1','submit')"/>
     </td>
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
<input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rs_cargos);
mysql_free_result($rs_estados);
mysql_free_result($rs_procesos);
?>