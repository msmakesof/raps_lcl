<?php require_once('../../Connections/cnn_cargo.php'); 
session_start(); ?>
<?php 
//echo "f.......".$_SESSION['autenticado']."<br>"; 
//&& isset($_SESSION['uid']))
if ( !isset($_SESSION['autenticado']) && $_SESSION['autenticado'] != 'SI' )
{
?>	
	<form name="formulario" method="post" action="../../index.php">
	<input type="hidden" name="msg_error" value="2">
	</form>
	<script type="text/javascript"> 
	alert("bye...");
		document.formulario.submit();
	</script>
<?php
}
else {
	$vcodid = $_GET['codid'];
	$upd= "";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET id_usuario=%s, usuario=%s, clave=%s, nombres=%s, apellidos=%s, tipodocumento=%s, dependencia=%s, cargo=%s, tipousuario=%s, cambiaclave=%s, control=%s, email=%s, tipotrafico=%s, estado=%s, graba=%s, consulta=%s, modifica=%s, borra=%s WHERE id=%s",
                       GetSQLValueString($_POST['id_usuario'], "text"),
					   GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['apellidos'], "text"),
                       GetSQLValueString($_POST['tipodocumento'], "text"),
                       GetSQLValueString($_POST['dependencia'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['tipousuario'], "text"),
                       GetSQLValueString($_POST['cambiaclave'], "text"),
                       GetSQLValueString($_POST['control'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['tipotrafico'], "text"),
					   GetSQLValueString(isset($_POST['estado']) ? "true" : "", "defined","'Y'","'N'"),
					   GetSQLValueString(isset($_POST['graba']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modifica']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['consulta']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['borra']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($vcodid, "int"));

  mysql_select_db($database_cnn_cargo, $cnn_cargo);
  $Result1 = mysql_query($updateSQL, $cnn_cargo) or die(mysql_error());

   $upd= "s";
}

$colname_rs_usuarios = "-1";
if (isset($vcodid)){	
  $colname_rs_usuarios = $vcodid;
}

mysql_select_db($database_cnn_cargo, $cnn_cargo);
$query_rs_usuarios = sprintf("SELECT * FROM usuarios WHERE id= %s", GetSQLValueString($colname_rs_usuarios, "int"));
$rs_usuarios = mysql_query($query_rs_usuarios, $cnn_cargo) or die(mysql_error());
$row_rs_usuarios = mysql_fetch_assoc($rs_usuarios);
$totalRows_rs_usuarios = mysql_num_rows($rs_usuarios);

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
			width:920px;
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
	<div class="mhead">
        <div class="content" align="center">        
            <p>
                <div class="anuncio mks" align="left"><?php echo "Bienvenido: ".strtoupper($_SESSION['nombresusu']) ?></div>
                <div class="anuncio mks" align="left"><?php echo "Tr&aacute;fico: ".strtoupper($row_rs_ttrafico['nom_trafico']) ?></div>
   		        <div class="anuncio mks" align="left">MODIFICACION DE USUARIOS</div>                
            </p>               
		</div>
    </div>    
        <div align="center">
        	<div class="logindexa">
            <div align="center"><div class="anuncio mks" align="center" id="msj"></div></div>
      		<!--      <hr>-->
			<!--                <div class="xlogindexa">-->
                <table class="table table-bordered" title="Usuarios" summary="Test Table" > 
               <!-- <caption></caption> -->
                <tbody>
                <tr>
                <th> Tipo de Documento </th>
                <td><select name="tipodocumento" id="tipodocumento">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['tipodocumento'])))) {echo "selected=\"selected\"";} ?>>Seleccione uno....</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['tipodocumento'])))) {echo "selected=\"selected\"";} ?>>----------------------</option>
                  <?php
do {  
?>
<option value="<?php echo $row_rs_tipodocto['id']?>"<?php if (!(strcmp($row_rs_tipodocto['id'], trim($row_rs_usuarios['tipodocumento'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_tipodocto['nom_tipodocto']?></option>
                  <?php
} while ($row_rs_tipodocto = mysql_fetch_assoc($rs_tipodocto));
  $rows = mysql_num_rows($rs_tipodocto);
  if($rows > 0) {
      mysql_data_seek($rs_tipodocto, 0);
	  $row_rs_tipodocto = mysql_fetch_assoc($rs_tipodocto);
  }
?>
                </select></td>
                </tr>

                <tr> 
                <th> Identificaci&oacute;n </th>
                <td>
                <div>
                    <input name="id_usuario" type="text" id="id_usuario" value="<?php echo $row_rs_usuarios['id_usuario']; ?>" maxlength="20">
                    <span class="obliga">*</span>Digite sólo números<div id="msj_clave"></div>
                </div>
      			</td>               
                </tr> 
                 
                <tr> 
                <th> Usuario </th>
                    <td><input name="usuario" type="text" id="usuario" value="<?php echo $row_rs_usuarios['usuario']; ?>" size="40" maxlength="40">
                    <span class="obliga">*</span><div id="msj_usu"></div>
                    </td>                    
                </tr> 
                <tr> 
                <th> Clave </th>
                <td><input name="clave" type="password" id="clave" value="<?php echo $row_rs_usuarios['clave']; ?>" size="40" maxlength="40"></td>
                </tr>
                <tr>
                <th> Nombres </th>
                <td><input name="nombres" type="text" class="span5" id="nombres" value="<?php echo $row_rs_usuarios['nombres']; ?>" size="60" maxlength="60"><span class="obliga">*</span></td>
                </tr>
                <tr>
                <th> Apellidos </th>
                <td><input name="apellidos" type="text" class="span5" id="apellidos" value="<?php echo $row_rs_usuarios['apellidos']; ?>" size="60" maxlength="60"><span class="obliga">*</span></td>
                </tr>
                <tr>
                <th> Grupo </th>
                <td><select name="dependencia" id="dependencia">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['dependencia'])))) {echo "selected=\"selected\"";} ?>>Seleccione uno...</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['dependencia'])))) {echo "selected=\"selected\"";} ?>>-------------------</option>
                  <?php
do {  
?>
<option value="<?php echo $row_rs_dependencia['cod_dependencia']?>"<?php if (!(strcmp($row_rs_dependencia['cod_dependencia'], trim($row_rs_usuarios['dependencia'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_dependencia['nom_dependencia']?></option>
                  <?php
} while ($row_rs_dependencia = mysql_fetch_assoc($rs_dependencia));
  $rows = mysql_num_rows($rs_dependencia);
  if($rows > 0) {
      mysql_data_seek($rs_dependencia, 0);
	  $row_rs_dependencia = mysql_fetch_assoc($rs_dependencia);
  }
?>
                </select></td>
                </tr>
                <tr>
                <th> Cargo </th>
                <td><select name="cargo" id="cargo">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['cargo'])))) {echo "selected=\"selected\"";} ?>>Seleccione uno...</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['cargo'])))) {echo "selected=\"selected\"";} ?>>---------------------</option>
                  <?php
do {  
?>
<option value="<?php echo $row_rs_cargo['id_cargo']?>"<?php if (!(strcmp($row_rs_cargo['id_cargo'], trim($row_rs_usuarios['cargo'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_cargo['nom_cargo']?></option>
                  <?php
} while ($row_rs_cargo = mysql_fetch_assoc($rs_cargo));
  $rows = mysql_num_rows($rs_cargo);
  if($rows > 0) {
      mysql_data_seek($rs_cargo, 0);
	  $row_rs_cargo = mysql_fetch_assoc($rs_cargo);
  }
?>
                </select></td>
                </tr>
                <tr>
                <th> Email </th>
                <td><input name="email" type="text" class="span6" id="email" value="<?php echo $row_rs_usuarios['email']; ?>" size="80" maxlength="80"><span class="obliga">*</span><div id="tableromail"></div>
                </td>
                </tr>
                <tr>
                <th> Tipo Usuario </th>
                <td><select name="tipousuario" id="tipousuario">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['tipousuario'])))) {echo "selected=\"selected\"";} ?>>Seleccione uno....</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['tipousuario'])))) {echo "selected=\"selected\"";} ?>>-----------------</option>
                  <?php
do {  
?>
<option value="<?php echo $row_rs_tipousuario['cod_tipousuario']?>"<?php if (!(strcmp($row_rs_tipousuario['cod_tipousuario'], trim($row_rs_usuarios['tipousuario'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_tipousuario['nom_tipousuario']?></option>
                  <?php
} while ($row_rs_tipousuario = mysql_fetch_assoc($rs_tipousuario));
  $rows = mysql_num_rows($rs_tipousuario);
  if($rows > 0) {
      mysql_data_seek($rs_tipousuario, 0);
	  $row_rs_tipousuario = mysql_fetch_assoc($rs_tipousuario);
  }
?>
                </select><span class="obliga">*</span></td>
                </tr>
                
                <tr>
                <th> Tipo de Tr&aacute;fico </th>
                <td><select name="tipotrafico" id="tipotrafico">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['tipotrafico'])))) {echo "selected=\"selected\"";} ?>>Selecicone uno...</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['tipotrafico'])))) {echo "selected=\"selected\"";} ?>>----------------</option>
                  <?php
do {  
?>
<option value="<?php echo $row_rs_ttrafico['cod_trafico']?>"<?php if (!(strcmp($row_rs_ttrafico['cod_trafico'], trim($row_rs_usuarios['tipotrafico'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_ttrafico['nom_trafico']?></option>
                  <?php
} while ($row_rs_ttrafico = mysql_fetch_assoc($rs_ttrafico));
  $rows = mysql_num_rows($rs_ttrafico);
  if($rows > 0) {
      mysql_data_seek($rs_ttrafico, 0);
	  $row_rs_ttrafico = mysql_fetch_assoc($rs_ttrafico);
  }
?>
                </select><span class="obliga">*</span>
                </td>
                </tr>
                <tr>
                <th> Cambia Clave </th>
                <td><select name="cambiaclave" id="cambiaclave" class="span2">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['cambiaclave'])))) {echo "selected=\"selected\"";} ?>>Seleccione uno....</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['cambiaclave'])))) {echo "selected=\"selected\"";} ?>>------------------</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rs_respuesta['cod_respuesta']?>"<?php if (!(strcmp($row_rs_respuesta['cod_respuesta'], trim($row_rs_usuarios['cambiaclave'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_respuesta['nom_respuesta']?></option>
                  <?php
} while ($row_rs_respuesta = mysql_fetch_assoc($rs_respuesta));
  $rows = mysql_num_rows($rs_respuesta);
  if($rows > 0) {
      mysql_data_seek($rs_respuesta, 0);
	  $row_rs_respuesta = mysql_fetch_assoc($rs_respuesta);
  }
?>
                </select></td>
                </tr>
                <tr>
                <th> Control </th>
                <td><select name="control" class="span2" id="control">
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['control'])))) {echo "selected=\"selected\"";} ?>>Seleccione uno....</option>
                  <option value="" <?php if (!(strcmp("", trim($row_rs_usuarios['control'])))) {echo "selected=\"selected\"";} ?>>----------------</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rs_respuesta['cod_respuesta']?>"<?php if (!(strcmp($row_rs_respuesta['cod_respuesta'], trim($row_rs_usuarios['control'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_respuesta['nom_respuesta']?></option>
                  <?php
} while ($row_rs_respuesta = mysql_fetch_assoc($rs_respuesta));
  $rows = mysql_num_rows($rs_respuesta);
  if($rows > 0) {
      mysql_data_seek($rs_respuesta, 0);
	  $row_rs_respuesta = mysql_fetch_assoc($rs_respuesta);
  }
?>
                </select>
                </td>
                </tr>
                
                               <tr>
                	<td>ACTIVO</td>
                    <td align="left" colspan="4"><input name="activo" type="checkbox" id="activo" value="0" />                    
                    </td>
                </tr>
  			<tr>
    		<td>PERMISOS</td>
            <td>
               
                <div style="float:left;font-size:11px; font-family:Verdana;width:100px">
                <label for="graba">Graba</label><input  name="graba" type="checkbox" id="graba" <?php if (!(strcmp($row_rs_usuarios['graba'],"Y"))) {echo "checked=\"checked\"";} ?> value="<?php echo $row_rs_usuarios['graba']; ?>" />
                </div>
                
                <div style="float:left;font-size:11px; font-family:Verdana;width:100px">  
                <label for="modifica">Modifica</label><input name="modifica" type="checkbox" id="modifica" <?php if (!(strcmp($row_rs_usuarios['modifica'],"Y"))) {echo "checked=\"checked\"";} ?> value="<?php echo $row_rs_usuarios['modifica']; ?>" />
                </div>
                <div style="float:left;font-size:11px; font-family:Verdana;width:100px">  
                <label for="consulta">Consulta</label><input  name="consulta" type="checkbox" id="consulta" <?php if (!(strcmp($row_rs_usuarios['consulta'],"Y"))) {echo "checked=\"checked\"";} ?> value="<?php echo $row_rs_usuarios['consulta']; ?>" />
                </div>  
                <div style="float:left;font-size:11px; font-family:Verdana;width:100px">
                <label for="borra">Borra</label><input  name="borra" type="checkbox" id="borra" <?php if (!(strcmp($row_rs_usuarios['borra'],"Y"))) {echo "checked=\"checked\"";} ?> value="<?php echo $row_rs_usuarios['borra']; ?>" />                  
                  </div>
                         
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
              <script language="JavaScript" type="text/JavaScript">
				function graba(formName,action)
				{
					if (document.form1.id_usuario.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo identificacion del Usuario.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
					
					if (document.form1.usuario.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Usuario.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
				
					if (document.form1.nombres.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Nombres.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
					
					if (document.form1.apellidos.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Apellidos.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
					
					if (document.form1.email.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Email.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
					
					if (document.form1.tipousuario.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Tipo Usuario.");
						document.form1.hf_graba.value = "n" ;
						return;
					}

					if (document.form1.tipotrafico.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Tipo Trafico.");
						document.form1.hf_graba.value = "n" ;
						return;
					}

					if(document.form1.hf_graba.value == "n")
					{
						action = "" ;
						document.form1.MM_update.value = "" ;
					}
					else
					{
					 	document.form1.MM_update.value = "form1" ;
						action = "submit" ; 
					} 
						
					var myString = "document."+formName+"."+action+"();";
					eval(myString);	
				}
              </script>
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
					$("#msj").hide();
					
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
					
					$("#salir").live("click", function(e){											   
						window.location.replace("../usuario.php");
					});
					
					$('input#id_usuario').numeric();
					
					$('#id_usuario').focusout( function(){
						if($('#id_usuario').val()!= ""){
							$.ajax({
								type: "POST",
								url: "val_id_upd.php",
								data: "idusu="+$('#id_usuario').val()+"&id=<?php echo $vcodid ?>",
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
								url: "val_usu_upd.php",
								data: "usu="+$('#usuario').val()+"&id=<?php echo $vcodid ?>",
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
						})
						
						var upd = "<?php echo $upd?>";
			            if(upd == "s"){
  						  $("#msj").html("<input type='button'  name='salir' id='salir' class='btn btn-warning' value='Registro Actualizado' />");
						  $("#msj").fadeIn(2500).fadeOut(2000);
						}
						else {$("#msj").hide();}
					
                });
            </script>
              
              
  <!--<p>&nbsp;</p>
            <hr>                        
          <p align="center">&copy; AGENTE DE CARGA 2013</p>-->
              <input name="hf_graba" type="hidden" value="s">
              <input type="hidden" name="MM_update" id="MM_update" value="">
            
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

mysql_free_result($rs_usuarios);

}
?>
