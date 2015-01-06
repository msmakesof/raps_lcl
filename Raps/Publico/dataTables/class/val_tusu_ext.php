<?php require_once('../../Connections/cnn_cargo.php'); ?>

<?php	
if($_REQUEST) {
	$usr_ext = $_REQUEST['id_ext'];
	//Busco si el usuario es interno
	mysql_select_db($database_cnn_cargo, $cnn_cargo);
		$query_Recordset1 = "SELECT nom_tabla_ext FROM tablas WHERE nom_tabla_ext ='".$usr_ext."'";
		$Recordset1 = mysql_query($query_Recordset1, $cnn_cargo) or die(mysql_error());
		$row_Recordset1 = mysql_fetch_assoc($Recordset1);
		$totalRows_Recordset1 = mysql_num_rows($Recordset1);
	
	//echo $query_Recordset1;
	//Si existe al menos una fila		
	if($totalRows_Recordset1 > 0){
		echo '<script language="javascript">';
		echo '$(document).ready(function() {';
		echo '$("#Errorx").css({ color: "#FF0000"});';
		echo '$("#usuario").focus();';
		echo '});';
		echo '</script>';			
		echo '<div id="Errorx">Nombre de Tabla Extendida No Disponible, digite un Nombre de Tabla diferente.<img src="../../no_ok.jpeg" width="32" height="32"></div>';
	}
	else{
		echo '<script language="javascript">';
		echo '$(document).ready(function() {';
		echo '$("#Successx").css({ color: "#009933"});';
		echo '});';
		echo '</script>';
		echo '<div id="Successx">Nombre de Tabla Disponible<img src="../../ok.jpeg" width="32" height="32"></div>';
	}

mysql_free_result($Recordset1);
}
?>	