<?php require_once('conexion.php');
$cn=  Conectarse();
$listado=  mysql_query("SELECT * FROM tipodocumento ORDER BY nom_tipodocto",$cn);
?>
<script type="text/javascript" language="javascript" src="js/jslistadopaises.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>NOMBRE</th>
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
			$codigo = mb_convert_encoding($reg['cod_tipodocto'], "UTF-8");
			$id =$reg['id'];
			echo '<tr>';
			echo '<td>';
			echo "<a href='javascript:void(0)' id='c' title='$id'>".$codigo."</a></td>";
			echo '<td>'.$reg['nom_tipodocto'].'</td>';
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
         $('#a1').tooltip ('Crear registros a la tabla Tipo Documento.</p>', { width: 200, style: 'alert' });
         $('#a2').tooltip ('Borrar registros de la tabla Tipo Documento.', { mode: 'tr', width: 200 });
		 $('#a3').tooltip ('Salir de la opci&oacute;n de Tipo Documento.', { mode: 'tr', width: 200 });
			  
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
				url: "../mod_tipodoctos.php",
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
