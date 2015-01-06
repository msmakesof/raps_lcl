<?php require_once('conexion.php');
$cn=  Conectarse();
$listado=  mysql_query("SELECT  max(aerolineas.nom_aerolinea) nom_aerolinea, stock_guias.cod_aer, MIN(stock_guias.g_inicial) menor, MAX(stock_guias.g_inicial) mayor, COUNT(DISTINCT dispon.g_inicial) activos, MIN(sigue.g_inicial) as guia_sigue FROM stock_guias JOIN aerolineas ON aerolineas.cod_aerolinea = stock_guias.cod_aer JOIN stock_guias dispon ON dispon.cod_aer = stock_guias.cod_aer AND dispon.estado ='A'
JOIN stock_guias sigue ON sigue.cod_aer = stock_guias.cod_aer AND sigue.estado ='A' GROUP BY stock_guias.cod_aer",$cn);
echo mysql_error();
?>
<script type="text/javascript" language="javascript" src="js/jslistadopaises.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
    <thead>
        <tr>
            <th>CODIGO</th>
            <th>AEROLINEA</th>
            <th>DESDE</th>
            <th>HASTA</th>
            <th>Cant. GUIAS USADAS</th>
            <th>No. GUIA DISPONIBLE</th>
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
       while($reg=  mysql_fetch_assoc($listado))
       {
			$codigo = mb_convert_encoding($reg['cod_aer'], "UTF-8");
			echo '<tr>';
			echo '<td>';
			//echo "<a href='javascript:void(0)' id='c' title='$codigo'>".$codigo."</a></td>";
			echo "<a href='class/mod_stock_guias.php?id=$codigo' id='c' title='$codigo'>".$codigo."</a></td>";
			echo '<td>'.mb_convert_encoding($reg['nom_aerolinea'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['menor'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['mayor'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['activos'], "UTF-8").'</td>';
			echo '<td>'.mb_convert_encoding($reg['guia_sigue'], "UTF-8").'</td>';			
			echo '</tr>';	 
		}
        ?>
    <tbody>
    <script src="../js/jquery-1.8.3.js"></script>
    <script src="../menu/tooltips/jquery/js/sexy-tooltips.v1.1.jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../menu/tooltips/jquery/js/sexy-tooltips/blue.css"/>
    <table width="250" border="0">
          <tr>
            <td><a href="../tablas/stock_guias.php" id="a1"><img src="../menu/images/report_add.png" width="32" height="32" border="0" /></a></td>
            <td><a href="del_ciu" id="a2"><img src="../menu/images/report_delete.png" width="32" height="32" border="0" /></a></td>
            <td><a href="javascript:void(0)" id="a3"><img src="../menu/images/salir.png" width="32" height="32" border="0" /></a></td>
          </tr>
    </table>
     <script type="text/javascript">
     $(document).ready(function(){
         $('#a1').tooltip ('Crear registros a la tabla stock Guias.</p>', { width: 200, style: 'alert' });
         $('#a2').tooltip ('Borrar registros de la tabla stock Guias.', { mode: 'tr', width: 200 });
		 $('#a3').tooltip ('Salir de la opci&oacute;n de stock Guias.', { mode: 'tr', width: 200 });
			  
		 $('#a3').click(function(){
		 	 window.location.href = '../menu.php';
		 });
		 
//		// $('#c').click(function(){
//		 	//window.location.href = 'mod_ciudad.php?id=$codciu';
//			var vid = $(this).attr("title");
//			alert(vid);
//			var $preg = $('div#preg').html('<p align="center"><img src="../cargando1.gif" />');
//			dataString = "codid="+vid;
//			$.ajax({
//				type: "POST",
//				url: "class/mod_stock_guias.php",
//				data: dataString,
//				success: function(data) {
//					$('#preg').html(data);				
//				}
//			});			
//		 });
     });
     </script>
     <div id="preg"></div>
</table>
