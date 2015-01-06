<?php require_once('conexion.php');
$cn=  Conectarse();
$listado=  mysql_query("SELECT solicitudDocumento.*, ingresoDocumento.detalle as ndetalle FROM solicitudDocumento,ingresoDocumento WHERE solicitudDocumento.ingreso_id = ingresoDocumento.id",$cn);
echo mysql_error();
?>
<script type="text/javascript" language="javascript" src="js/jslistadopaises.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<title>.:::       OPC:   Gestion de Solicitud DOcumento.   :::</title><table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
    <thead>
        <tr>
            <th># ORDEN</th>            
            <th>NOMBRE SERIE - SUBSERIE</th>
            <th>CODIGO</th>
            <th>FECHA INICIAL</th>
            <th>FECHA FINAL</th>
            <th>CONSERVACION</th>            
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>        
        </tr>
    </tfoot>
      <tbody>
        <?php
       while($reg=  mysql_fetch_assoc($listado)){
			$idusu = mb_convert_encoding($reg['id'], "UTF-8");
			$id = mb_convert_encoding($reg['id'], "UTF-8");
			$conservacion = $reg['conservacion'];
			if($conservacion == "C"){
                            $conservaciondet = "CAJA";
                        }else if($conservacion == "F"){
                            $conservaciondet = "FOLIO";
                        }else if($conservacion == "T"){
                            $conservaciondet = "TOMO";
                        }else{
                            $conservaciondet = "OTRO";
                        }
                        echo '<tr>';
			echo '<td>';
			//echo "<a href='javascript:void(0)' id='c' title='$idusu'>".$idusu."</a></td>";
			echo "<a href='class/mod_solicitudDocumento_cl.php?codid=$id' id='c' title='$idusu'>".$idusu."</a></td>";			
			echo '<td>'.mb_convert_encoding($reg['descripcion'], "UTF-8").' '.mb_convert_encoding($reg['descripcion'], "UTF-8").'</td>';			
			echo '<td>'.mb_convert_encoding($reg['ndetalle'], "UTF-8").'</td>';
                        echo '<td>'.mb_convert_encoding($reg['fecini'], "UTF-8").'</td>';
                        echo '<td>'.mb_convert_encoding($reg['fecfin'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($conservaciondet, "UTF-8").'</td>';
                        echo '<td>'.mb_convert_encoding($reg['estado'], "UTF-8").'</td>';
			echo '</tr>';	 
		}
        ?>
    <tbody>
    <script src="../js/jquery-1.8.3.js"></script>
    <script src="../menu/tooltips/jquery/js/sexy-tooltips.v1.1.jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../menu/tooltips/jquery/js/sexy-tooltips/blue.css"/>
    <table width="250" border="0">
          <tr>
            <td><a href="class/add_solicitudDocumento_cl.php" id="a1"><img src="../menu/images/report_add.png" width="32" height="32" border="0" /></a></td>
            <td><a href="del_usuario" id="a2"><img src="../menu/images/report_delete.png" width="32" height="32" border="0" /></a></td>
            <td><a href="javascript:void(0)" id="a3"><img src="../menu/images/salir.png" width="32" height="32" border="0" /></a></td>
          </tr>
    </table>
     <script type="text/javascript">
     $(document).ready(function(){
         $('#a1').tooltip ('Crear registros a la tabla Solicitud Documento.</p>', { width: 200, style: 'alert' });
         $('#a2').tooltip ('Borrar registros de la tabla Solicitud Documento.', { mode: 'tr', width: 200 });
		 $('#a3').tooltip ('Salir de la opci&oacute;n de Solicitud Documento.', { mode: 'tr', width: 200 });
			  
		 $('#a3').click(function(){
		 	 window.location.href = '../menu.php';
		 });
		 
//		 $('#c').click(function(){
//		 	//window.location.href = 'mod_ciudad.php?id=$codciu';
//			var vid = $(this).attr("title");
//			alert(vid);
//			var $preg = $('div#preg').html('<p align="center"><img src="../cargando1.gif" />');
//			dataString = "codid="+vid;
//			$.ajax({
//				type: "POST",
//				url: "../mod_usuario_cl.php",
//				data: dataString,
//				success: function(data) {
//					//$('#preg').html(data);
//					window.location.href = 'mod_usuario_cl.php';   //?id=$codciu';
//				}
//			});
//		 });
     });
     </script>
     <div id="preg"></div>
</table>
