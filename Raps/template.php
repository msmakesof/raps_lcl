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
    	    $consulta = "SELECT * FROM menus WHERE idModulos = 1 AND idMenusPadre is NULL";
			$menus=mysql_query($consulta, $conexion) or die("Problemas en el select para cargar el menu principal:".mysql_error());
			
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
					$submenus=mysql_query($consulta, $conexion) or die("Problemas en el select para cargar el menu interno:".mysql_error());
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
	<div class="container" 	>
		<div id='titulo_forma'>
			<div style = 'float: left'><?php echo $titulo; ?></div>
			<div style = 'float: right' class="input-group input-group-sm">
				<select id='limitPaginador' name='limitPaginador' onchange='filtrarBusqueda()' class="form-control">		
					<option value= '10'>10</option>
					<option value= '20'>20</option>
					<option value= '30'>30</option>
					<option value= '40'>40</option>
					<option value= '50'>50</option>
					<option value= '60'>60</option>
					<option value= '70'>70</option>
					<option value= '80'>80</option>
					<option value= '90'>90</option>
					<option value= '10'>100</option>
				</select>
			</div>
			<div id='txtBusqueda' class="input-group input-group-sm"><input type="text" class="form-control" autofocus placeholder="Buscar" name="search" id="searchID" onkeyup='filtrarBusqueda()'><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span></div>			
		</div>	
		<div id='forma'>
			<input type='hidden' id ='ordenPaginador' name= 'ordenPaginador'>
			<br>			
			<?php echo $forma;  ?>	
			<div id="mensaje" class="freeow freeow-top-right"></div>	
			<div id="dialog-confirm" title="Confirmaci&oacute;n">  				
			</div>
			<?php 
				session_start();
				if(isset($_SESSION['mensaje']) && $_SESSION['mensaje'] != '')
				{
					echo "<script>".$_SESSION['mensaje']."</script>";				
					unset($_SESSION['mensaje']); 
				}				
			?>										
		</div>		
	</div>	
</body>	
<br>
<br>
<footer class="footer">
	<div class="navbar navbar-fixed-bottom" style="background-color: #000E16; color:#67696A">
  		<div  style="text-align: center;margin-top:0.7%">
            <?php         	        	        	
        	$conexion = crearConexion();        	
    	    $consulta = "SELECT cn_empresa, cn_direccion, cn_telefono, cn_ciudadpais, cn_derechos FROM configuracion WHERE cn_estado = 1 ;";
			$piepagina=mysql_query($consulta, $conexion) or die("Problemas en la consulta para cargar el pie de pagina:".mysql_error());
			while($pp = mysql_fetch_array($piepagina))
			{
				echo $pp['cn_empresa']." - ".$pp['cn_direccion']." - ".$pp['cn_telefono']." - ".$pp['cn_ciudadpais']." - ".$pp['cn_derechos'];
			}	
			cerrarConexion($conexion);		
			?>
            <p class="text-muted"></p>
  		</div>
	</div>  		
</footer>
 
</html>