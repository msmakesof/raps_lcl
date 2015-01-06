<?php require_once('../../Connections/cnn_cargo.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	 echo $_POST['cg_final'];
	 if($_POST['cg_final'] > 0)
	 {
		 for($i=1;$i<=$_POST['cg_final'];$i++){
  				$insertSQL = sprintf("INSERT INTO stock_guias (cod_aer, g_inicial, descripcion, estado) VALUES (%s, %s, %s, 'A')",
				 GetSQLValueString($_POST['aerolinea'], "text"),
				 GetSQLValueString($i, "int"),
				 GetSQLValueString($_POST['descripcion'], "text"));

		   		mysql_select_db($database_cnn_cargo, $cnn_cargo);
		   		$Result1 = mysql_query($insertSQL, $cnn_cargo) or die(mysql_error());
	 	 }
	 }
}

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_aerol = "SELECT * FROM aerolineas ORDER BY nom_aerolinea ASC";
$rs_aerol = mysql_query($query_rs_aerol, $cnn_cargo) or die(mysql_error());
$row_rs_aerol = mysql_fetch_assoc($rs_aerol);
$totalRows_rs_aerol = mysql_num_rows($rs_aerol);
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Stock de Guias</title>
<link rel="stylesheet" type="text/css" href="../../css/base.css">

<link rel="stylesheet" type="text/css" href="../../css/tabla.css"/>
<link rel="stylesheet" type="text/css" href="../../css/jquery.ui.css"/>
<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-timepicker-addon.css"/>


<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap-responsive.css">
<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">

<script type="text/javascript" src="../../js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../js/jquery.numeric.js"></script>

<script type="text/javascript" src="../../varios/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="../../varios/jqwidgets/jqxdata.js"></script> 
<script type="text/javascript" src="../../varios/jqwidgets/jqxcombobox.js"></script>

<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>


<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" >
$(document).ready(function() {		 
	 $("#g_inicial").numeric();
	 $("#cg_final").numeric();
	 
	  // busca la ultima guia disponible de la aerol
	  $('#aerolinea').change(function() {
	      var xcodaer = $('#aerolinea').val(); 
	      var $preg = $('div#preg').html('<p><img src="../js/imagenes/loading_black_small.gif" />');
		  //alert(xcodaer);
			dataString = "codaer="+xcodaer;
			$.ajax({
				type: "POST",
				url: "vefguia.php",
				data: dataString,
				success: function(data) {
					//alert(data);
					$('#preg').html('<input name="g_inicial" type="text" id="g_inicial" size="12" maxlength="15" value="'+data+'" />');	
					$('#descripcion').html('Generado automaticamente');
				}
			});
	  });	
	 
	 $("#salir").click(function(){
		window.location.replace("../stock_g.php");
	 });
});
</script>
<script type="text/javascript" >
function graba(formName,action)
{
	 var graba = "ok";
	 if(document.getElementById("aerolinea").value=="")	 
	 {alert("Debe Seleccionar una Aerolinea.");	graba = "n"; return; }
	 
	 if(document.getElementById("g_inicial").value=="")	 
	 {alert("Debe Digitar un Nro. Inicial.");	graba = "n"; return; }

	 if(document.getElementById("cg_final").value=="")	 
	 {alert("Debe Digitar una Cantidad de Guias a Generar.");	graba = "n"; return;}

	 if(document.getElementById("cg_final").value <=0)	 
	 {alert("Debe Digitar una Cantidad de Guias a generar Mayor que cero.");	graba = "n"; return;}
	 
	 if(graba != "ok"){document.form1.MM_insert.value = ""; action = "" ; }
	 
	 var myString = "document."+formName+"."+action+"();";
  	eval(myString);	
}
</script>
<style>
body {
	width: 80%;
	float: left;/*    font-family: 'trebuchet MS', 'Lucida sans', Arial;
    font-size: 14px;
    color: #444;*/
	height: auto;
	margin-left: 55px;
}
</style>
</head>
<body>
<div align="center">
<div class="konsul">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
    <div id="divimgs7">
        <!--<div id="encab">-->
            <div id="logo1"><img src="../../images/rubi_logo1.png"></div>
            <!--<div id="logo1"><img src="../images/header1.png"></div> -->   
        <!--</div>-->
    	<br>

   		<table class="mtable bordered">
       <thead>
        <tr>
            <th colspan="2" align="center">MODIFICAR STOCK GUIAS</th>        
        </tr>
        </thead>	
        <tr>
            <td>Aerol&iacute;nea</td>
            <td><label for="aerolinea"></label>
                <select name="aerolinea" id="aerolinea">
                <option value="">Seleccione</option>
              <option value="">-------------</option>
              <?php
    do {  
    ?>
              <option value="<?php echo $row_rs_aerol['cod_aerolinea']?>"><?php echo $row_rs_aerol['nom_aerolinea']?></option>
    <?php
    } while ($row_rs_aerol = mysql_fetch_assoc($rs_aerol));
      $rows = mysql_num_rows($rs_aerol);
      if($rows > 0) {
          mysql_data_seek($rs_aerol, 0);
          $row_rs_aerol = mysql_fetch_assoc($rs_aerol);
      }
    ?>
            </select></td>
        </tr>	
        <tr>
            <td>Nro. Gu&iacute;a Inicial</td>
            <td><label for="g_inicial"></label>
            <div id="preg"><input name="g_inicial" type="text" id="g_inicial" size="12" maxlength="15" /></div></td>
        </tr>
        <tr>
            <td>Cantidad de Gu&iacute;as</td>
            <td><label for="cg_final"></label>
            <input name="cg_final" type="text" id="cg_final" size="10" maxlength="15" /></td>	
        <tr>
            <td>Descripci&oacute;n</td>
            <td><label for="descripcion"></label>
                <textarea name="descripcion" id="descripcion" cols="45" rows="5"></textarea></td>
        </tr>
    </table>
    <br>
        <input name="generar" type="button" value="Generar" class="btn btn-primary" onClick="graba('form1','submit')"/>
         <input type="button" name="salir" id="salir" class="btn btn-danger" value=" Salir "/>
        <input name="hf_graba" type="hidden" value="n" />
        <input type="hidden" name="MM_insert" value="form1" />
</div>
</form>

</div>
</div>
</body>
</html>
<?php
mysql_free_result($rs_aerol);
?>
