<?php require_once('conexion.php');
$cn=  Conectarse();
$listado=  mysql_query("SELECT monedas.*, paises.nombre as nompais FROM monedas JOIN paises ON paises.iata = monedas.cod_pais ORDER BY mon_nombre",$cn);
?>
<script type="text/javascript" language="javascript" src="js/jslistadopaises.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>NOMBRE MONEDA</th>
            <th>ISO</th>
            <th>PAIS</th>
            <th>OBSERVACION</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>        
        </tr>
    </tfoot>
      <tbody>
        <?php
       while($reg=  mysql_fetch_array($listado))
       {
			$codigo = mb_convert_encoding($reg['codigo'], "UTF-8");
			$codealfa = mb_convert_encoding($reg['code_alfa'], "UTF-8");
			echo '<tr>';
			echo '<td>';
			echo "<a href='javascript:void(0)' id='c' title='$codigo'>".$codealfa."</a></td>";
			echo '<td>'.mb_convert_encoding($reg['mon_nombre'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['code_num'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['nompais'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['observacion'], "UTF-8").'</td>';
			echo '</tr>';	 
		}
        ?>
    <tbody>
    <script src="../js/jquery-1.8.3.js"></script>
    <script src="../menu/tooltips/jquery/js/sexy-tooltips.v1.1.jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../menu/tooltips/jquery/js/sexy-tooltips/blue.css"/>
    <table width="250" border="0">
          <tr>
            <td><a href="add_ciu" id="a1"><img src="../menu/images/report_add.png" width="32" height="32" border="0" /></a></td>
            <td><a href="del_ciu" id="a2"><img src="../menu/images/report_delete.png" width="32" height="32" border="0" /></a></td>
            <td><a href="javascript:void(0)" id="a3"><img src="../menu/images/salir.png" width="32" height="32" border="0" /></a></td>
          </tr>
    </table>
     <script type="text/javascript">
     $(document).ready(function(){
         $('#a1').tooltip ('Crear registros a la tabla Paises.</p>', { width: 200, style: 'alert' });
         $('#a2').tooltip ('Borrar registros de la tabla Paises.', { mode: 'tr', width: 200 });
		 $('#a3').tooltip ('Salir de la opci&oacute;n de Paises.', { mode: 'tr', width: 200 });
			  
		 $('#a3').click(function(){
		 	 window.location.href = '../menu.php';
		 });
		 
		 $('#c').click(function(){
		 	//window.location.href = 'mod_ciudad.php?id=$codciu';
			var vid = $(this).attr("title");
			alert(vid);
			var $preg = $('div#preg').html('<p align="center"><img src="../cargando1.gif" />');
			dataString = "codid="+vid;
			$.ajax({
				type: "POST",
				url: "../mod_monedas.php",
				data: dataString,
				success: function(data) {
					$('#preg').html(data);				
				}
			});
			
			
		 });
     });
     </script>
     <div id="preg"></div>
</table>
