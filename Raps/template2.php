<?php
	include("/var/www/Raps/index.php");
?>
<!DOCTYPE html> 
<html> 
<head> 
<title>Probando bootstrap</title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head> 
<body style='background-image: url("<?php echo urlInicialImagenes();?>/prospero_fondo.png");'> 
	<div class="navbar navbar-inverse">         
        <ul class="nav navbar-nav"> 
        	<li><a href='#'><img src="<?php echo urlInicialImagenes();?>/prospero_icono.png" width="30px" style="margin-top: -10%"></a></li> 			
        	<?php         	        	        	
        	$conexion = crearConexion();        	
    	   	/*$sql="call SP_consulta_menus(1,0);";
		   	$menus=mysql_query($sql, $conexion) or die('Error en el query: '.mysql_errno($conexion).' - '.mysql_error($conexion));			   
		   	/*while($reg=@mysql_fetch_assoc($menus)){
		      	echo print_r($reg,true);			      
		      	foreach($reg as $campo=>$valor){
		         	echo "\t$campo = ".utf8_decode($valor)."\r";
		      	}			      
		   	}					
		   	*/
		   	//$consulta="call SP_consulta_menus(1,0);";
			$consulta = "SELECT * FROM menus WHERE idModulos = 1 AND idMenusPadre is NULL";
			$menus=mysql_query($consulta, $conexion) or die("Problemas en el select para cargar el menu:".mysql_error());
			
			while ($menu=mysql_fetch_array($menus))
			{
				if($menu['url'] != '#')
				{
					echo "<li><a href='".$menu['url']."'>".$menu['detalle']."</a></li> ";			
				}
				else
				{
					echo "<li class='dropdown'> ";
    				echo "	<a class='dropdown-toggle' href='#' data-toggle='dropdown' >".$menu['detalle']." <b class='caret'></b></a> ";
		        	echo "	<ul class='dropdown-menu'> ";
		        	$consulta = "SELECT * FROM menus WHERE idMenusPadre = ".$menu['idMenus']." ORDER BY orden";
					$submenus=mysql_query($consulta, $conexion) or die("Problemas en el select para cargar el menu:".mysql_error());
					while ($submenu=mysql_fetch_array($submenus))
					{
		        		echo "	<li><a href='".$submenu['url']."'>".$submenu['detalle']."</a></li> ";
		        	}
		        	echo "	</ul>";
		        	echo "</li>";
				}

			}	
			mysql_free_result($conexion);
			cerrarConexion($conexion);
			?>                        
        </ul> 

	</div>
	<br>
	<div class="container">
		<div id='titulo_forma'>
			<div style = 'float: left'><?php echo $titulo; ?></div>
			<div style = 'float: right'><a href="javascript:window.history.back();" class="enlaceNaranja">Cancelar</a></div>	
		</div>	
		<div id='forma'>
			<br>
			<?php echo $forma; ?>			
		</div>		
	</div>	
</body>	
<footer class="footer">
	<div class="navbar navbar-fixed-bottom" style="background-color: #000E16">
  		<div  style="text-align: center;margin-top:0.7%">
    		<p class="text-muted">INTER RAPID&Iacute;SIMO S.A - Carrera 30 No. 7- 45 - PBX: 560 5000 - Bogot&aacute; Colombia - Copyright &#169; 2014</p>
  		</div>
	</div>  		
</footer>
 
</html>