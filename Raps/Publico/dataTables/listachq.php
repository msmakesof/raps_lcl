<?php require_once('../Connections/cnn_plan_mejora.php'); ?>
<?php
require_once("../sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("usuario");
if( $usuario == false )
{	
	header("Location: ../index.php");		
}
else 
{

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
/////////  PRIVILEGIOS  ////////////
$colname_rs_privilegios = $usuario;
$colname_rs_privilegios = "-1";
if (isset($usuario)) {
  $colname_rs_privilegios = $usuario;
}
mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_privilegios = sprintf("SELECT nombreEmp, cod_suc, control, graba, modifica, consulta, borra FROM empleados WHERE usuario = %s", GetSQLValueString($colname_rs_privilegios, "text"));
$rs_privilegios = mysql_query($query_rs_privilegios, $cnn_plan_mejora) or die(mysql_error());
$row_rs_privilegios = mysql_fetch_assoc($rs_privilegios);
$totalRows_rs_privilegios = mysql_num_rows($rs_privilegios);
/////////////////////
?>
<!DOCTYPE html>
<html>
    <head>
        <title>.::: Consulta de Lista de Chequeo</title>
        <meta charset="utf-8">
        <!--    ESTILO GENERAL   -->
        <link type="text/css" href="css/style.css" rel="stylesheet" />			
				<link rel="stylesheet" type="text/css" href="../css/base.css">
				
				<link rel="stylesheet" href="../tinybox2/style.css" />		
				<script type="text/javascript" src="../tinybox2/tinybox.js"></script>
        <!--    ESTILO GENERAL    -->
        <!--    JQUERY   -->
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcioneslc.js"></script>
        <!--    JQUERY    -->
        <!--    FORMATO DE TABLAS    -->
        <link type="text/css" href="css/demo_table.css" rel="stylesheet" />
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
        <!--    FORMATO DE TABLAS    -->
    </head>
    <body>
    <div class="consul">
        <div id="divimgs1" style="background-color: #000">
             <div id="logo1"><img src="../imgs/logo.jpg" width="222" height="59" /></div>     
        </div>        
        <header class="gradient">
          <h2>LISTA DE CHEQUEO</h2>
        </header>
				<div align="center" style="clear:both;padding:8px;margin-bottom:5px;height:14px;">			
					 <div style="float:left;width:20%;font-family:Verdana, Geneva, sans-serif;font-size:11;color:#36C;font-weight:bold">
					 	Acciones rápidas:
				</div>
					 <div style="float:left;width:20%;font-family:Verdana, Geneva, sans-serif;font-size:11;color:#36C;">
					 <?php if($row_rs_privilegios['control'] =='S'){ ?>
						<?php if($row_rs_privilegios['graba'] =='Y'){ ?>
						<a href="#" onclick="TINY.box.show({iframe:'../acciones/add.php',boxid:'frameless',width:1010,height:870,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})" id="creaudita" class="fuentetest3"><img src="../imgs/lista.jpg" width="30" height="30" border="0" align="absmiddle" />  Crear Nombre</a>
						<?php } 
					}
					?>
					 </div>
					 <div style="float:left;width:20%;font-family:Verdana, Geneva, sans-serif;font-size:11;color:#36C;">
					  <?php if($row_rs_privilegios['control'] =='S'){ ?>
    <?php if($row_rs_privilegios['graba'] =='Y'){ ?>
    <a href="../acciones/indeX7.php" id="btnneuvo" class="fuentetest3" ><img src="../imgs/lista.jpg" width="30" height="30" border="0" align="absmiddle" /> Importar Lista</a>
    <?php } 
	}
	?></div>
					 <div style="float:left;width:20%;font-family:Verdana, Geneva, sans-serif;font-size:11;color:#36C;">
				 <?php if($row_rs_privilegios['control'] =='S'){ ?>
    <?php if($row_rs_privilegios['graba'] =='Y'){ ?>
    <a href="#" onclick="TINY.box.show({iframe:'../acciones/asignar.php',boxid:'frameless',width:1010,height:600,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})" id="creaudita" class="fuentetest3"><img src="../imgs/lista.jpg" width="30" height="30" border="0" align="absmiddle" /> Lista de Chequeo Manual</a>
    <?php } 
	}
	?>
					 </div>
					 <div style="float:left;width:20%;font-family:Verdana, Geneva, sans-serif;font-size:11;color:#36C;">
    <a href="../sub_index.php">Salir</a>
					 </div>
				</div>
    
        <article id="contenido"></article>
				
        <footer>
            &copy; INTERRAPIDISMO 2014
        </footer>
    </div>   
</body>
</html>
<?php 
mysql_free_result($rs_privilegios);
}
?>