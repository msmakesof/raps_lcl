<?php   
   //Opcion para llamar la funcion paginador desde ajax

   if($_GET['opc'] == 1)
   {     
      //include_once("../../../Raps/Modulos/Generales/models/lineas.php"); 
      //$a = estadoDetalle('1');
      //echo $a;
      echo $_SESSION['urlPrincipalIndex'];
      $tabla = $_POST['tabla'];
      $condicion = $_POST['condicion'];
      $pos = $_POST['pos'];      
      $campos = explode(',',substr($_POST['campos'], 0,-1));
      $tamano = explode(',',substr($_POST['tamano'], 0,-1));
      $titulos = explode(',',substr($_POST['titulos'], 0,-1));
      $llamadoFunciones = explode(',',substr($_POST['llamadoFunciones'], 0,-1));
      $order = $_POST['order'];
      $limit = $_POST['limit'];
      $tipo = $_POST['tipo'];

      if($condicion != '')
      {
         $condiciones = '';
         for($i=0 ; $i < count($campos); $i++)
         {
            $condiciones .=  " ".$campos[$i]." LIKE '%".$condicion."%' OR";
         }
         $condicion = substr($condiciones, 0, -2);
      }         
      $HTML = paginador($tabla,$condicion,$pos,$campos,$tamano,$titulos,$llamadoFunciones,$order,$limit);            
      echo json_encode($HTML);
   }
   else if($_GET['opc'] == 2)
   {   
      $tabla = $_POST['tabla'];
      $campoPrimario = $_POST['campoPrimario'];
      $valor = $_POST['valor'];
      $conexion = crearConexion();   
      $sql = "SELECT estado FROM ".$tabla." WHERE ".$campoPrimario." = '".$valor."'";
      $resultado=mysql_query($sql, $conexion) or die("Problemas en el select para consultar estado: ".mysql_error());
      while ($resul=mysql_fetch_array($resultado))
      {
         $estado = $resul['estado'];
      }
      if($estado == 0)
      {
         $estado = 1;
      }
      else
      {
         $estado = 0;
      }        
      $sql = "UPDATE ".$tabla." SET estado = '".$estado."' WHERE ".$campoPrimario." = '".$valor."'";      
      $registros=mysql_query($sql,$conexion) or die("Problemas en el select: ".mysql_error());            
      cerrarConexion($conexion);
      echo json_encode("");
   }
   else if($_GET['opc'] == 3)
   {   
      $tabla = $_POST['tabla'];
      $campoPrimario = $_POST['campoPrimario'];
      $campos = substr($_POST['campos'],0,-1);
      $valor = $_POST['valor'];
      $respuestaValores = "";
      $conexion = crearConexion();   
      $sql = "SELECT ".$campos." FROM ".$tabla." WHERE ".$campoPrimario." = '".$valor."'";
      $resultado=mysql_query($sql, $conexion) or die("Problemas en el select para consultar estado: ".mysql_error());
      $campos = explode(',', $campos);
      while ($resul=mysql_fetch_array($resultado))
      {
         for($reg_campos=0;$reg_campos < count($campos);$reg_campos++)
         {                        
            $campo = $campos[$reg_campos];                        
            $respuestaValores .= $resul[$campo].",";
         }
      }
	   $respuestaValores = utf8_encode(substr($respuestaValores,0,-1));
      cerrarConexion($conexion);
      echo json_encode($respuestaValores);
   }

   function mensajes($message, $estado)
   {
      if($estado == 0)
      {
         $title = 'Confirmaci&oacute;n';
         $estado = 'confirmacion';
      }
      else if($estado == 1)
      {
         $title = 'Advertencia';
         $estado = '';
      }
      else
      {
         $title = 'Error';
         $estado = 'error';
      }
      $js  = "";      
      $js .= "opts = {};";      
      $js .= "opts.classes = [$('#freeow-style').val()];";         
      $js .= "opts.classes.push('".$estado."');";        
      $js .= "$('#mensaje').freeow('".$title."', '".$message."', opts);";
      return $js;
   }

   function crearConexion()
   {
      //$hostname = "localhost";
	  $hostname = "172.20.10.103";
      $database = "raps";
      $username = "root";
      $password = "1nt3rr4p1d1s1m0";

      $conexion = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 
      mysql_select_db($database,$conexion);
      return $conexion;
   }

   function cerrarConexion($conexion)
   {
      mysql_close($conexion);
   }

   function urlInicial()
   {
   		$url = "/Raps/";
   		return $url;	
   }

   function urlInicialImagenes()
   {   		
   		$url = "/Raps/Publico/Imagenes";
   		return $url;	
   }

   function urlModulos()
   {        
         $url = "/var/www/Raps/Modulos/";
         return $url;   
   }
   function urlModulosRelativa()
   {        
         $url = "/Raps/Modulos/";
         return $url;   
   }
   
   //function formaDetalle($campos,$tipos,$tamano,$span,$url,$llamadoFunciones)
   function formaDetalle($campos,$tipos,$span,$url,$llamadoFunciones)
   {      
      $HTML = '';      
      $HTML .= "  <form id='idForma' class='form-horizontal' action='".$url."' method='post'>";
      $HTML .= "     <table width='100%' id='tablaCampos'>";
      $HTML .= "        <tr>";
      for($i=0;$i < count($campos);$i++)
      {
         //$HTML .= "<td width='".$tamano[$i]."%'>";
		 $HTML .= "<td>";
         if($tipos[$i] == 'text')
         {
            //$HTML .= "<div class='form-group tamano_campo' >";      
			$HTML .= "<div class='col-xs-$span[$i]'>";      
            $HTML .= "  <input type='text' class='form-control input-sm' id = '".$campos[$i]."' name = '".$campos[$i]."' placeholder='".$campos[$i]."'>";
            $HTML .= "</div>";      
         }
         else if($tipos[$i] == 'hidden')
         {            
            $HTML .= "  <input type='hidden' class='form-control' id = '".$campos[$i]."' name = '".$campos[$i]."'>";         
         }
         else if($tipos[$i] == 'select')
         {
            $funcion = call_user_func($llamadoFunciones[$i]);                     
            //$HTML .= "<div class='form-group tamano_campo' >";      
			$HTML .= "<div class='col-xs-".$span[$i]."'>";        
            $HTML .= "  <select  class='form-control input-sm' id = '".$campos[$i]."' name = '".$campos[$i]."'>".$funcion."</select>";
            $HTML .= "</div>";
         }                        
         $HTML .= "</td>";            
      }
      $HTML .= "<td width='10%'>";
      //$HTML .= "    <div class='form-group tamano_campo' align='right'>";
	  $HTML .= "    <div class='form-group col-xs-3' align='right'>";
      $HTML .= "       <button type='button' class='botonAzul' onclick='guardarForma()' style='padding-right:5px'>Guardar</button>"; 
      $HTML .= "    </div>";
      $HTML .= "</td>";
      $HTML .= "        </tr>";
      $HTML .= "  </form>";

      return $HTML;
   }

   function paginador($tabla,$condicion,$pos,$campos,$tamano,$titulos,$llamadoFunciones,$order,$limit)
   {         
      $HTML ="";
      $conexion = crearConexion();
      $url = basename($_SERVER ["PHP_SELF"]);
      if($limit == '')
      {
         $limit = 10;
      }
      $cantidad_registros = $limit;   
      if ($pos != '')
      {
         $inicial=$pos;
      }
      else
      {
         $inicial=1;
      }
      $registros=mysql_query("select count(*) as cantidad  from ".$tabla." ".$condicion,$conexion);      
      $cantidad=0;
      while ($rows=mysql_fetch_array($registros))
      {
         $cantidad=$rows['cantidad'];
      }
      if($cantidad_registros > $cantidad)
      {
         $cantidad_registros = $cantidad + 1;
      }
      $inicial_consulta = ($inicial-1) * $cantidad_registros;      
      
      $HTML .="<table  id='tablePaginador' class='table table-condensed table-hover'>";            
      $HTML .="   <tr>";      
      for($reg_campos=0;$reg_campos < count($titulos);$reg_campos++)
      {
         $campo = ucfirst($titulos[$reg_campos]);
         $campoSql = ucfirst($campos[$reg_campos]);
         $color = "#000";
         if($order == $campoSql)
         {
            $color = "#E67143";
         }
         $HTML .="   <th width = ".$tamano[$reg_campos]."% style='cursor: pointer;color: $color' onclick='ordenarBusqueda(\"$campoSql\")'><b>".$campo."&nbsp;&#9660;</b></th>";      
      }  
      $HTML .="   <th>&nbsp;</th>";
      $HTML .="   <th>&nbsp;</th>";
      $HTML .="   </tr>";      
           
      $total = (int) ($cantidad/$cantidad_registros);
      $total_residuo = $cantidad%$cantidad_registros;
      if($total_residuo !=0)
      {
         $total++;
      }      
      if($condicion != '')
      {
         $condicion = " WHERE " .$condicion;
      }      
      if($order == '')
      {         
         $order = '1 DESC';
      }           
      $select = "SELECT * FROM $tabla  $condicion ORDER BY $order";   
      $select .= " LIMIT $inicial_consulta, $cantidad_registros";                              
      $consulta = mysql_query($select, $conexion) or die("Problemas al consultar: ".mysql_error().$select);      
      $cantidad_existente=0;      
      while ($rows=mysql_fetch_array($consulta))
      {
         $HTML .="<tr>";
         for($reg_campos=0;$reg_campos < count($campos);$reg_campos++)
         {                        
            $campo = $campos[$reg_campos];            
            if($llamadoFunciones[$reg_campos] != '')
            {                                          
               $funcion = trim($llamadoFunciones[$reg_campos]);
               $contenido = call_user_func($funcion,$rows[$campo]);
               //MIENTRAS SE ENCUENTRA LA FORMA DE LLAMAR LA FUNCION DE OTRO ARCHIVO CON UN LLAMADO AJAX
               $contenido = $rows[$campo];
            }
            else
            {
               $contenido = $rows[$campo];
            }
            if($reg_campos==0)
            {
               $id=$rows[$campo];
               $campoPrimario=$campo;
            }
            $HTML .="<td>".$contenido."</td>";
         } 
         $HTML .= "  <td width='10%'>";                  
         $HTML .= "       <button type='button' class='botonAzul' onclick='modificarRegistro(\"".$campoPrimario."\",".$id.")'><span class='glyphicon glyphicon-pencil'></span></button>";          
         $HTML .= "       <button type='button' class='botonNaranja' onclick='cambiarEstado(\"".$campoPrimario."\",".$id.")'><span class='glyphicon glyphicon-trash'></span></button>";       
         $HTML .= "  </td>";         
         $HTML .="</tr>";
         $cantidad_existente++;
      }  
      if($cantidad_registros > $cantidad_existente)
      {
         for($r=$cantidad_existente;$r < $cantidad_registros;$r++)
         {
            $cols = count($campos) + 2;
            $HTML .="<tr><td colspan='".$cols."'>&nbsp;</td></tr>";
         }
      }
      $HTML .="</table>";     
      $HTML .="<div>";
      $HTML .="<ul class='pagination'>";      
      if($inicial == 1)
      {
         $HTML .="<li class='disabled'><a href='#'>&laquo;</a></li>";
         $HTML .="<li class='disabled'><a href='#'><b>Primero</b></a></li>";
      }      
      else
      {
         $HTML .="<li><a href='$url?pos=".($inicial-1)."'><b>&laquo;</b></a></li>";
         $HTML .="<li><a href='$url?pos=1'><b>Primero</b></a></li>";
      }
      for($k=1; $k <= $total; $k++)
      {
         if($inicial == $k)
         {
            $HTML .="<li><a href='#'><b>".$k."</b></a></li>";
         }
         else
         {
            $HTML .="<li><a href='$url?pos=$k'>".$k."</a></li>";
         }
      }
      if($inicial == $total)
      {
         $HTML .="<li class='disabled'><a href='#'><b>&Uacute;ltimo</b></a></li>";
         $HTML .="<li class='disabled'><a href='#'><b>&raquo;</b></a></li>";
      }
      else
      {
         $HTML .="<li><a href='$url?pos=".($total)."'><b>&Uacute;ltimo</b></a></li>";
         $HTML .="<li><a href='$url?pos=".($inicial+1)."'><b>&raquo;</b></a></li>";
      }
      $HTML .="</ul>";
      $HTML .="</div>";
      $conexion = cerrarConexion($conexion);
      return $HTML;
   }
   
   if (!function_exists("validarCadena")) {
		function validarCadena($valor, $tipo, $valorDefinido = "", $valorNoDefinido = "") 
		{
		  	if (PHP_VERSION < 6) {
				$valor = get_magic_quotes_gpc() ? stripslashes($valor) : $valor;
		  	}
		
		  	$valor = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($valor) : mysql_escape_string($valor);
		
		  switch ($tipo) {
			case "text":
			  $valor = ($valor != "") ? "'" . $valor . "'" : "NULL";
			  break;    
			case "long":
			case "int":
			  $valor = ($valor != "") ? intval($valor) : "NULL";
			  break;
			case "double":
			  $valor = ($valor != "") ? doubleval($valor) : "NULL";
			  break;
			case "date":
			  $valor = ($valor != "") ? "'" . $valor . "'" : "NULL";
			  break;
			case "defined":
			  $valor = ($valor != "") ? $valorDefinido : $valorNoDefinido;
			  break;
		  }
		  return $valor;
		}
	}
	
	// función de gestión de errores	
	function capErr($noerr,$txterr,$tabla,$archivo,$linea)
	{		
//		if (!(error_reporting() & $errno)) {
//			// Este código de error no está incluido en error_reporting
//			return;
//		}
//	 
//		switch ($errno) {
//			case E_USER_ERROR:
//				echo "<b>Mi ERROR</b> [$errno] $errstr<br />\n";
//				echo "  Error fatal en la l&iacute;nea $errline en el archivo $errfile";
//				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
//				echo "Abortando...<br />\n";
//				exit(1);
//				break;
//		 
//			case E_USER_WARNING:
//				echo "<b>Mi WARNING</b> [$errno] $errstr<br />\n";
//				break;
//		 
//			case E_USER_NOTICE:
//				echo "<b>Mi NOTICE</b> [$errno] $errstr<br />\n";
//				break;
//		 
//			default:
//				echo "Tipo de error desconocido: [$errno] $errstr<br />\n";
//				break;
//		} 
	  $conexion = crearConexion();
	  $txterr = str_replace("'","^",$txterr);
	  $sql = "INSERT INTO auditoria (idAuditoria, tablaAuditoria, errorNo, errorAuditoria, archivoAuditoria, lineaAuditoria, fechaAuditoria, usuarioAuditoria) VALUES (0,'$tabla', $noerr, '$txterr','$archivo', $linea,'".date("Y-m-d H:i:s")."','".$_SESSION["usuario"]."')";	
      $registros=mysql_query($sql,$conexion) or die("Problemas en el insertar: ".mysql_error());            
      cerrarConexion($conexion);		
		//return true; //$sql;
		errgraba();
		//mensajes("Error.....",4);
	}
?>