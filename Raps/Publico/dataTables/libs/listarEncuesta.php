<?php require_once('../../Connections/cnn_encu.php');
//require_once("../../sesion.class.php");
//$sesion = new sesion();
//$usuario = $sesion->get("usuario");
//
//if( $usuario == false )
//{	
//	header("Location: ../../index.php");		
//}
//else 
//{
		/////////  PRIVILEGIOS  ////////////
		$usuario ="";
		$colname_rs_privilegios = $usuario;
		$colname_rs_privilegios = "-1";
		if (isset($usuario)) {
			$colname_rs_privilegios = $usuario;
		}
		
		mysql_select_db($database_cnn_encu, $cnn_encu);
		$query_rs_privilegios = "SELECT year FROM anio WHERE estado = 'A';";
		$rs_privilegios = mysql_query($query_rs_privilegios, $cnn_encu) or die(mysql_error());
		$row_rs_privilegios = mysql_fetch_assoc($rs_privilegios);
		$totalRows_rs_privilegios = mysql_num_rows($rs_privilegios);
		$anio = $row_rs_privilegios['year'];
		/////////////////////

require_once('conexion.php');
$cn=  Conectarse();

$listado=  mysql_query("SELECT * FROM encuesta ORDER BY year DESC; ",$cn);
mysql_query ("SET NAMES 'utf8'");
mysql_set_charset('utf8');
?>
<script type="text/javascript" language="javascript" src="js/jslistadopaises.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script language="javascript">
function borra_ta(oId, par2){
	var service = oId;
	var nomemp = par2;
	var msg = confirm("Desea eliminar el año: "+ nomemp +" ?")
    if ( msg ) {
		$.ajax({
			type: "GET",
			url: "libs/delete_em.php",
			data: 'id='+service,
			beforeSend :function()
 			{
				$('#borraitem').html('<img src="../indicator_green.gif">');
			},
			success:function(respuesta){			
 				$('#fila_'+oId).empty();
				$('#borraitem').html('<div style="background-color:#CC0000;color:#FFFFFF;padding:12px;margin:12px;">Se ha eliminado correctamente el Año: '+nomemp+'.</div>').fadeOut(3000);
				$('#fila_'+oId).remove();
				location.reload();
 			}
		});					   
	}
}
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>ESTADO</th>
            <th>ACTIVOS</th>
            <th>AÑO</th>
            <th>CIERRE</th>
            <th>Nota M&iacute;nima</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
      <tbody>
        <?php
       while($reg=  mysql_fetch_array($listado))
       {
			$codyy = $reg['id'];	
			$estado = $reg['estado'];
			$activo = $reg['activos'];
			$anio = $reg['year'];
			$cierre = $reg['cierre'];
			$notaminima = $reg['notaminima'];			
			echo '<tr id="fila_'.$codyy.'">';
			echo '<td>';?>
			<?php //if($row_rs_privilegios['control'] =='S'){ ?>
	  	<?php //if($row_rs_privilegios['modifica'] =='Y'){ ?>
      <a href="#" onclick="TINY.box.show({iframe:'../usuarios/updencuesta.php?id=<?php echo $codyy; ?>',boxid:'frameless',width:990,height:550,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})"  class="fuentetest3"><?php echo $codyy; ?></a>
				<?php //}
			//}
			echo '</td>';
			?>
			<?php
			echo '<td>'.$estado.'</td>';
			echo '<td>'.$activo.'</td>';
			echo '<td>'.$anio.'</td>';
			echo '<td>'.$cierre.'</td>';
			echo '<td>'.$notaminima.'</td>';			
			echo "<td>";
			if($usuario == 'mks'){?>			
			<a href="#" id="btn_$codaudit"></a><img src="../acciones/img/delete.png" alt="Borrar" width="16" height="16" border="0" align="absmiddle" onclick="borra_ta('<?php echo $codaudit; ?>','<?php echo $nombre; ?>')"></a></td>
			<?php
			}
			echo '</tr>';	 
		}
        ?>
    <tbody>
    <script src="../js/jquery-1.8.3.js"></script>	
    <script src="../../menu/tooltips/jquery/js/sexy-tooltips.v1.1.jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../../menu/tooltips/jquery/js/sexy-tooltips/blue.css"/>
    <table width="250" border="0">
          <tr>
            <td>
						 <?php //if($row_rs_privilegios['control'] =='S'){ ?>
								<?php //if($row_rs_privilegios['graba'] =='Y'){ ?>										
										<a href="#" class="button white" id="a1" onclick="TINY.box.show({iframe:'../usuarios/addencuesta.php',boxid:'frameless',width:980,height:660,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})">Adicionar</a>
								 <?php //} 
								//}								
								?>
						</td>
<!--            <td><a href="del_ciu" class="button white" id="a2">Borrar</a></td>-->
            <td><a href="../default.php" class="button white" id="a3">Salir</a></td>
          </tr>
    </table>
     <script type="text/javascript">
     $(document).ready(function(){
         $('#a1').tooltip ('Crear registros a la tabla Encuesta.</p>', { width: 200, style: 'alert' });
         $('#a2').tooltip ('Borrar registros de la tabla Encuesta.', { mode: 'tr', width: 200 });
		     $('#a3').tooltip ('Salir de la opci&oacute;n de Encuesta.', { mode: 'tr', width: 200 });
			  
				 $('#a3').click(function(){
						window.location.href = '../default.php';
				 });
		 
				 $('#c').click(function(){
							//window.location.href = 'mod_ciudad.php?id=$codciu';
							var vid = $(this).attr("title");
							alert(vid);
							var $preg = $('div#preg').html('<p align="center"><img src="../../indicator_green.gif" />');
							dataString = "codid="+vid;
							$.ajax({
									type: "POST",
									url: "../mod_ta.php",
									data: dataString,
									success: function(data) {
										$('#preg').html(data);				
									}
							});			
				 });
     });
     </script>
     <div id="preg"></div>
		 <div id="borraitem"></div>
</table>
<?php 
mysql_free_result($rs_privilegios);
//} ?>