<?php require_once('../../Connections/cnn_plan_mejora.php');
require_once("../../sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("usuario");

if( $usuario == false )
{	
	header("Location: ../../index.php");		
}
else 
{
		/////////  PRIVILEGIOS  ////////////
		$colname_rs_privilegios = $usuario;
		$colname_rs_privilegios = "-1";
		if (isset($usuario)) {
			$colname_rs_privilegios = $usuario;
		}
		
		mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
		$query_rs_privilegios = "SELECT nombreEmp, cod_suc, control, graba, modifica, consulta, borra FROM empleados WHERE usuario = '$colname_rs_privilegios';";
		$rs_privilegios = mysql_query($query_rs_privilegios, $cnn_plan_mejora) or die(mysql_error());
		$row_rs_privilegios = mysql_fetch_assoc($rs_privilegios);
		$totalRows_rs_privilegios = mysql_num_rows($rs_privilegios);
		/////////////////////

require_once('conexion.php');
$cn=  Conectarse();

$listado=  mysql_query("SELECT listachqxtipoaudit.nombre_lc, tipo_auditoria.nom_ti_audit, auditoria.nombre_auditoria, listachqxtipoaudit.id_listacheq, listachqxtipoaudit.objetivo, listachqxtipoaudit.tipo_auditoria, listachqxtipoaudit.id_auditoria FROM listachqxtipoaudit JOIN tipo_auditoria ON tipo_auditoria.cod_ti_audit = listachqxtipoaudit.tipo_auditoria JOIN auditoria ON auditoria.id = listachqxtipoaudit.id_auditoria ORDER BY tipo_auditoria.nom_ti_audit, auditoria.nombre_auditoria, listachqxtipoaudit.nombre_lc ASC",$cn);
mysql_query ("SET NAMES 'utf8'");
mysql_set_charset('utf8');

?>
<script type="text/javascript" language="javascript" src="js/jslistadopaises.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script language="javascript">
function borra_ta(oId, par2){
	var service = oId;
	var nomemp = par2;
    var msg = confirm("Desea eliminar el nombre de la Lista de Chequeo: "+ nomemp + " - "+ service+" ?")
    if ( msg ) {
		$.ajax({
			type: "GET",
			url: "libs/delete_lc.php",
			data: 'id='+service,
			beforeSend :function()
 			{
				$('#borraitem').html('<img src="../indicator_green.gif">');
			},
			success:function(respuesta){			
 				$('#fila_'+oId).empty();
				$('#borraitem').html('<div style="background-color:#CC0000;color:#FFFFFF;padding:12px;margin:12px;">Se ha eliminado correctamente la Lista de Chequeo: '+nomemp+'.</div>').fadeOut(3000);
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
            <th>NRO</th>
            <th>TIPO FUENTE</th>
            <th>NOMBRE FUENTE</th>
            <th>NOMBRE LISTA</th>
            <th>OBJETIVO</th>
            <th>DETALLE</th>
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
	   $i=0;
	   $codaudit = "";
       while($reg=  mysql_fetch_array($listado))
       {
			if(isset($reg['id'])){
			$codaudit = $reg['id'];}
			$nombre = $reg['nom_ti_audit'];
			$v_tipo_audit = $reg['tipo_auditoria'];
			$v_audit = $reg['id_auditoria'];
			$v_lc = $reg['id_listacheq'];
			$i++;
			echo '<tr id="fila_'.$codaudit.'">';
			echo '<td>';
			?>
			<?php if($row_rs_privilegios['control'] =='S'){ ?>
	  	<?php if($row_rs_privilegios['modifica'] =='Y'){ ?>
      <a href="#" onclick="TINY.box.show({iframe:'../acciones/upd_lc.php?ta=<?php echo $v_tipo_audit; ?>&au=<?php echo $v_audit; ?>&lc=<?php echo $v_lc; ?>',boxid:'frameless',width:998,height:890,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})"  class="fuentetest3"><?php echo $i; ?></a>
				<?php }
			}
			echo '</td>';
			echo '<td>'.$nombre.'</td>';
			echo '<td>'.$reg['nombre_auditoria'].'</td>';
			echo '<td>'.$reg['nombre_lc'].'</td>';
			echo '<td>'.$reg['objetivo'].'</td>';						
			if($row_rs_privilegios['consulta'] =='Y'){	
			echo '<td>';
			?>	
			<a href="../acciones/detallado.php?idta=<?php echo $v_tipo_audit; ?>&idaudi=<?php echo $v_audit; ?>&idlc=<?php echo $v_lc; ?>" class="fuentetest3"><img src="../imagesaacion.jpg" width="25" height="25" border="0" align="absmiddle" />Ver Lista Detallada...</a>
			<?php
			echo '</td>';
			}
			echo '<td>';						
			?>			
			<a href="#" id="btn_$codaudit"></a><img src="../acciones/img/delete.png" alt="Borrar" width="16" height="16" border="0" align="absmiddle" onclick="borra_ta('<?php echo $v_lc; ?>','<?php echo $nombre; ?>')"></a></td>
			<?php 
			echo '</td>';
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
						 <?php if($row_rs_privilegios['control'] =='S'){ ?>
								<?php if($row_rs_privilegios['graba'] =='Y'){ ?>										
										<a href="#" class="button white" id="a1" onclick="TINY.box.show({iframe:'../acciones/add.php',boxid:'frameless',width:1010,height:870,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})">Adicionar</a>
								 <?php } 
								}								
								?>
						</td>
<!--            <td><a href="del_ciu" class="button white" id="a2">Borrar</a></td>-->
            <td><a href="../sub_index.php" class="button white" id="a3">Salir</a></td>
          </tr>
    </table>
     <script type="text/javascript">
     $(document).ready(function(){
         $('#a1').tooltip ('Crear registros a la tabla Lista de Chequeo.</p>', { width: 200, style: 'alert' });
         $('#a2').tooltip ('Borrar registros de la tabla Lista de Chequeo.', { mode: 'tr', width: 200 });
		     $('#a3').tooltip ('Salir de la opci&oacute;n de Lista de Chequeo.', { mode: 'tr', width: 200 });
			  
				 $('#a3').click(function(){
						window.location.href = '../../sub_menu.php';
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
} ?>