<?php		
	include("../../models/lineas.php");
	include ("../../../../conexion.php");

	$titulo = 'LINEAS';	
	$forma = "";
	$forma .= "<form class='form-horizontal'>";
	$forma .= "     <div class='form-group tamano_campo' >";
	$forma .= "			<label for='inputDescripcion' class='control-label'>Descripci&oacute;n</label>";
	$forma .= "			<input type='text' class='form-control' id='descripcion' name='descripcion' placeholder='Descripci&oacute;n'>";
	$forma .= "		</div>";
	$forma .= "     <div class='form-group tamano_campo' >";
	$forma .= "			<label for='inputEnviaEmail' class='control-label'>Envia Email</label>";
	$forma .= "			<select  class='form-control'>".enviaEmailHtml()."</select>";
	$forma .= "		</div>";
	$forma .= "     <div class='form-group tamano_campo' >";
	$forma .= "			<label for='inputEstado' class='control-label'>Estado</label>";
	$forma .= "			<select  class='form-control'>".estadoHtml()."</select>";
	$forma .= "		</div>";
	$forma .= "		<div class='form-group tamano_campo' align='right'>";
	$forma .= "			<button type='submit' class='botones'>Guardar</button>";	
	$forma .= "		</div>";
	$forma .= "</form>";
	include("/var/www/Raps/template.php");	
	


?>
