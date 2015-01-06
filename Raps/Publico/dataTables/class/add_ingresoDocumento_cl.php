<?php require_once('../../Connections/cnn_cargo.php'); session_start();
require_once('../libs/conexion.php');

?>
<?php 
//echo "f.......".$_SESSION['autenticado']."<br>"; 
//&& isset($_SESSION['uid']))
if ( !isset($_SESSION['autenticado']) && $_SESSION['autenticado'] != 'SI' )
{
?>	
    
	<form name="formulario" method="post" action="../../index.php"  enctype="multipart/form-data">
	<input type="hidden" name="msg_error" value="2">
	</form>
	<script type="text/javascript"> 
	alert("bye...");
		document.formulario.submit();
	</script>
<?php
}
else {
?>
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
  $insertSQL = sprintf("INSERT INTO ingresoDocumento (id, detalle, departamento_id, conservacion, nota, estado) VALUES (0, %s, %s, %s, %s, 'A')",
                GetSQLValueString($_POST['detalle'], "text"),
                GetSQLValueString($_POST['departamento_id'], "text"),
                GetSQLValueString($_POST['conservacion'], "text"),
                GetSQLValueString($_POST['nota'], "text"));


  mysql_select_db($database_cnn_cargo, $cnn_cargo);
  $Result1 = mysql_query($insertSQL, $cnn_cargo) or die(mysql_error());
  
  $cn=  Conectarse();
  $listado=  mysql_query("SELECT max(id) as id FROM ingresoDocumento ",$cn);
  while($regmax=  mysql_fetch_assoc($listado)){
    $id = $regmax['id'];
  }
  $uploaddir = 'C:/xampp/tmp/imagenDocumento/';
  $uploadfile = $uploaddir.$id.'_' . basename($_FILES['userfile']['name']);
  
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $insertSQL = sprintf("INSERT INTO imagenesDocumento (id, path, estado) VALUES (0, %s, 'A')",
        GetSQLValueString($uploaddir.$id.'_' . basename($_FILES['userfile']['name']), "text"));
        mysql_select_db($database_cnn_cargo, $cnn_cargo);
        $Result1 = mysql_query($insertSQL, $cnn_cargo) or die(mysql_error());

  }
  $insertGoTo = "../ingresoDocumento.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_tipodocto = "SELECT * FROM tipodocumento ORDER BY nom_tipodocto ASC";
$rs_tipodocto = mysql_query($query_rs_tipodocto, $cnn_cargo) or die(mysql_error());
$row_rs_tipodocto = mysql_fetch_assoc($rs_tipodocto);
$totalRows_rs_tipodocto = mysql_num_rows($rs_tipodocto);

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_dependencia = "SELECT * FROM dependencias ORDER BY nom_dependencia ASC";
$rs_dependencia = mysql_query($query_rs_dependencia, $cnn_cargo) or die(mysql_error());
$row_rs_dependencia = mysql_fetch_assoc($rs_dependencia);
$totalRows_rs_dependencia = mysql_num_rows($rs_dependencia);

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_cargo = "SELECT * FROM cargos ORDER BY nom_cargo ASC";
$rs_cargo = mysql_query($query_rs_cargo, $cnn_cargo) or die(mysql_error());
$row_rs_cargo = mysql_fetch_assoc($rs_cargo);
$totalRows_rs_cargo = mysql_num_rows($rs_cargo);

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_tipousuario = "SELECT * FROM tipousuario ORDER BY nom_tipousuario ASC";
$rs_tipousuario = mysql_query($query_rs_tipousuario, $cnn_cargo) or die(mysql_error());
$row_rs_tipousuario = mysql_fetch_assoc($rs_tipousuario);
$totalRows_rs_tipousuario = mysql_num_rows($rs_tipousuario);

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_respuesta = "SELECT * FROM respuesta ORDER BY nom_respuesta ASC";
$rs_respuesta = mysql_query($query_rs_respuesta, $cnn_cargo) or die(mysql_error());
$row_rs_respuesta = mysql_fetch_assoc($rs_respuesta);
$totalRows_rs_respuesta = mysql_num_rows($rs_respuesta);

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_ttrafico = "SELECT * FROM tipotrafico WHERE cod_trafico ='".$_SESSION['tipotrafico']."' ";
$rs_ttrafico = mysql_query($query_rs_ttrafico, $cnn_cargo) or die(mysql_error());
$row_rs_ttrafico = mysql_fetch_assoc($rs_ttrafico);
$totalRows_rs_ttrafico = mysql_num_rows($rs_ttrafico);
?>	
    <!DOCTYPE html>
    <!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
    <!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
    <!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
    <!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <title>.::.  OPC:  Creación de Usuarios     .::.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../../bootstrap/css/redondeo.css">
        
        <link rel="stylesheet" type="text/css" href="../../base_base.css"/>
        <link rel="stylesheet" href="../../imenu/css/style_base.css" type="text/css" media="screen"/>
     
        <style>
        body{
	font-family:Arial;
	background-image: url(../../images/fondo-mapa.jpg);
        }
        .content{
        width:940px;
        clear: both;
        margin-left: 1px;  /*posicion del menu*/
                }
                span.reference{
                    position:fixed;
                    left:10px;
                    bottom:10px;
                    font-size:12px;
                }
                span.reference a{
                    color:#aaa;
                    text-transform:uppercase;
                    text-decoration:none;
                    text-shadow:1px 1px 1px #000;
                    margin-right:30px;
                }
                span.reference a:hover{
                    color:#ddd;
                }
                ul.sdt_menu{
                    margin-top:100px;
                }
                h1.title{
                    text-indent:-9000px;
                    background:transparent url(../../imenu/title.png) no-repeat top left;
                    width:633px;
                    height:69px;
                }
            </style>
    </head>
    
    <body>
<div align="center">
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1"  enctype="multipart/form-data">
	<div class="mhead">
        <div class="content" align="center">        
            <p>
                <div class="anuncio mks" align="left"><?php echo "Bienvenido: ".strtoupper($_SESSION['nombresusu']) ?></div>
                <div class="anuncio mks" align="left"><?php echo "Tr&aacute;fico: ".strtoupper($row_rs_ttrafico['nom_trafico']) ?></div>
        <div class="anuncio mks" align="left">CREACION DE INGRESO DOCUMENTO</div>
            </p>               
		</div>
    </div>    
        <div align="center">
        	<div class="logindexa">
      		<!--      <hr>-->
			<!--                <div class="xlogindexa">-->
                <table class="table table-bordered" title="Usuarios" summary="Test Table" > 
               <!-- <caption></caption> -->
                <tbody>
                <tr> 
                    <th> Detalle </th>
                    <td>
                        <input name="detalle" type="text" id="detalle" maxlength="20">
                    </td>               
                </tr>
                <tr> 
                    <th> Departamento </th>
                    <td>
                        <?php
                            $cn=  Conectarse();
                            $listado=  mysql_query("SELECT * FROM departamento ",$cn);
                            echo  "<select id='departamento_id' name='departamento_id'>";
                            while($regdep=  mysql_fetch_assoc($listado)){
                                
                                    echo "<option value=".$regdep['id'].">".$regdep['detalle']."</option>";
                                
                                
                            }
                            echo  "</select>";
                        ?>
                    </td>               
                </tr>
                <tr> 
                    <th> Conservaci&oacute;n </th>
                    <td>
                        <select id='conservacion' name='conservacion'>
                            <option value="C">CAJA</option>
                            <option value="F">FOLIO</option>
                            <option value="T">TOMO</option>
                            <option value="O">OTRO</option>
                        </select>
                    </td>               
                </tr>                
                <tr> 
                    <th> Nota </th>
                    <td>
                        <textarea name="nota" id="nota"></textarea>
                    </td>               
                </tr>
                <tr> 
                    <th> Archivo</th>
                    <td>
                        <input name="userfile" type="file" />
                    </td>               
                </tr>
                
                </tbody>
                </table>
                
               <div id="mk" align="center">
                 <input type="button" name="grabar" id="grabar" class="btn btn-primary" value="Grabar" onClick="graba('form1','submit')"/>
                 <input type="button" name="salir" id="salir" class="btn btn-danger" value=" Salir "/></td>
               </div>  
                <!--</div>-->
    		</div>
    </div>
            <!-- The JavaScript -->
  <script type="text/javascript" src="../../js/jquery-1.8.3.js"></script>
  <script type="text/javascript" src="../../imenu/jquery.easing.1.3.js"></script>
  <script src="../js/jquery.numeric.js"></script>
<script type="text/javascript">
                $(function() {
                    /**
                    * for each menu element, on mouseenter, 
                    * we enlarge the image, and show both sdt_active span and 
                    * sdt_wrap span. If the element has a sub menu (sdt_box),
                    * then we slide it - if the element is the last one in the menu
                    * we slide it to the left, otherwise to the right
                    */
                    $('#sdt_menu > li').bind('mouseenter',function(){
                        var $elem = $(this);
                        $elem.find('img')
                             .stop(true)
                             .animate({
                                'width':'170px',
                                'height':'170px',
                                'left':'0px'
                             },400,'easeOutBack')
                             .andSelf()
                             .find('.sdt_wrap')
                             .stop(true)
                             .animate({'top':'140px'},500,'easeOutBack')
                             .andSelf()
                             .find('.sdt_active')
                             .stop(true)
                             .animate({'height':'170px'},300,function(){
                            var $sub_menu = $elem.find('.sdt_box');
                            if($sub_menu.length){
                                var left = '170px';
                                if($elem.parent().children().length == $elem.index()+1)
                                    left = '-170px';
                                $sub_menu.show().animate({'left':left},200);
                            }	
                        });
                    }).bind('mouseleave',function(){
                        var $elem = $(this);
                        var $sub_menu = $elem.find('.sdt_box');
                        if($sub_menu.length)
                            $sub_menu.hide().css('left','0px');
                        
                        $elem.find('.sdt_active')
                             .stop(true)
                             .animate({'height':'0px'},300)
                             .andSelf().find('img')
                             .stop(true)
                             .animate({
                                'width':'0px',
                                'height':'0px',
                                'left':'85px'},400)
                             .andSelf()
                             .find('.sdt_wrap')
                             .stop(true)
                             .animate({'top':'25px'},500);
                    });
					
					$("#salir").click(function(){
						window.location.replace("../ingresoDocumento.php");
					});
					
					$('input#id_usuario').numeric();
					
					$('#id_usuario').focusout( function(){
						if($('#id_usuario').val()!= ""){
							$.ajax({
								type: "POST",
								url: "val_id.php",
								data: "id="+$('#id_usuario').val(),
								beforeSend: function(){
								  $('#msj_clave').html('<img src="../../indicator_green.gif"/> verificando');
								},
								success: function(data){
									$('#msj_clave').fadeIn(1000).html(data);
								}
							});
						}
						else {
						$("#id_usuario").focus();}
						
					});
					
					$('#usuario').focusout( function(){
						if($('#usuario').val()!= ""){
							$.ajax({
								type: "POST",
								url: "val_usu.php",
								data: "id="+$('#usuario').val(),
								beforeSend: function(){
								  $('#msj_usu').html('<img src="../../indicator_green.gif"/> verificando');
								},
								success: function(data){
									$('#msj_usu').fadeIn(1000).html(data);
								}
							});
						}
					});

					  // Validar email
					   function validar_email(valor)
						{
							// creamos nuestra regla con expresiones regulares.
							var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
							// utilizamos test para comprobar si el parametro valor cumple la regla
							if(filter.test(valor))
								return true;
							else
								return false;
						}
						
						// cuando dejamos el input de email
						$("#email").blur(function()
						{
							if($("#email").val() == '')
							{
								$('#tableromail').html("Ingrese un Correo Electronico.");
								$("#email").focus();			
							}
																
							else if(validar_email($("#email").val()))
							{
								$('#tableromail').html("<span class='alert-success'>El Correo Electronico es valido.</span>");
							}else
							{
								$('#tableromail').html("<span class='alert-danger'>El Correo Electronico NO es valido.</span>");
								$("#email").focus();
							}
						}); 
					
                });
            </script>
            
            <script language="JavaScript" type="text/JavaScript">
				function graba(formName,action)
				{
					
					 	document.form1.MM_insert.value = "form1" ;
						action = "submit" ; 
					 
						
					var myString = "document."+formName+"."+action+"();";
					eval(myString);	
				}
            </script>

<!--<p>&nbsp;</p>
            <hr>                        
          <p align="center">&copy; AGENTE DE CARGA 2013</p>-->
          <input name="hf_graba" type="hidden" value="s">
          <input type="hidden" name="MM_insert" value="form1">
</form>    
    </div>    
    </body>
    </html>
<?php
mysql_free_result($rs_tipodocto);

mysql_free_result($rs_dependencia);

mysql_free_result($rs_cargo);

mysql_free_result($rs_tipousuario);

mysql_free_result($rs_respuesta);

mysql_free_result($rs_ttrafico);

}
?>
