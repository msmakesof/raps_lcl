<?php require_once('../../Connections/cnn_cargo.php'); session_start(); ?>
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
  $insertSQL = sprintf("INSERT INTO usuarios (nom_tabla, nom_tabla_ext) VALUES (%s, %s)",
                       GetSQLValueString($_POST['nom_tabla'], "text"),
                       GetSQLValueString($_POST['nom_tabla_ext'], "text"));

  mysql_select_db($database_cnn_cargo, $cnn_cargo);
  $Result1 = mysql_query($insertSQL, $cnn_cargo) or die(mysql_error());

  $insertGoTo = "../tipousuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
        <title>.::.  OPC:  Creación de Tipos Usuarios     .::.</title>
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
	<div class="mhead">
        <div class="content" align="center">        
            <p>
                <div class="anuncio mks" align="left"><?php echo "Bienvenido: ".strtoupper($_SESSION['nombresusu']) ?></div>
                <div class="anuncio mks" align="left"><?php echo "Tr&aacute;fico: ".strtoupper($row_rs_ttrafico['nom_trafico']) ?></div>
        <div class="anuncio mks" align="left">CREACION DE TIPOS USUARIOS</div>
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
                <th> Nombre Tabla </th>
                <td><input name="nom_tabla" id="nom_tabla" type="text" size="70" maxlength="70" class="span5"><span class="obliga">*</span>
                <div id="msj_clave"></div>
                </td>
                </tr>
                <tr>
                <th> Nombre Tabla Externo </th>
                <td>
                <input name="nom_tabla_ext" id="nom_tabla_ext" type="text" size="70" maxlength="70" class="span5"><span class="obliga">*</span>
                <div id="msj_clave1"></div>
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
						window.location.replace("../tipousuario.php");
					});
					
					$('#nom_tabla').focusout( function(){
						if($('#nom_tabla').val()!= ""){
							$.ajax({
								type: "POST",
								url: "val_tusu.php",
								data: "id="+$('#nom_tabla').val(),
								beforeSend: function(){
								  $('#msj_clave').html('<img src="../../indicator_green.gif"/> verificando');
								},
								success: function(data){
									$('#msj_clave').fadeIn(1000).html(data);
								}
							});
						}
						else {
						$("#nom_tabla").focus();}
						
					});
					
					$('#nom_tabla_ext').focusout( function(){
							if($('#nom_tabla_ext').val()!= ""){
								$.ajax({
									type: "POST",
									url: "val_tusu_ext.php",
									data: "id_ext="+$('#nom_tabla_ext').val(),
									beforeSend: function(){
									  $('#msj_clave1').html('<img src="../../indicator_green.gif"/> verificando');
									},
									success: function(data){
										$('#msj_clave1').fadeIn(1000).html(data);
									}
								});
							}
						});

					
                });
            </script>
<script language="JavaScript" type="text/JavaScript">
				function graba(formName,action)
				{
			
					if (document.form1.nom_tabla.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Nombre de Tabla.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
					
					if (document.form1.nom_tabla_ext.value == "")
					{
						alert("ATENCION: Debe ingresar información en el campo Nombre de Tabla Externa.");
						document.form1.hf_graba.value = "n" ;
						return;
					}
					
					if(document.form1.hf_graba.value == "n")
					{
						action = "" ;
						document.form1.MM_insert.value = "" ;
					}
					else
					{
					 	document.form1.MM_insert.value = "form1" ;
						action = "submit" ; 
					} 
						
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
  mysql_free_result($rs_ttrafico);
}
?>
