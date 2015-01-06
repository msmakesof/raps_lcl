<?php require_once('../../Connections/cnn_cargo.php'); ?>

<?php	
if($_REQUEST) {
    $usr = $_REQUEST['usu'];	
	$id  = $_REQUEST['id'];	
	//Busco si el usuario es interno
	mysql_select_db($database_cnn_cargo, $cnn_cargo);
	$query_Recordset1 = "SELECT usuario FROM usuarios WHERE usuario ='".$usr."' AND id <> ".$id; 
	$Recordset1 = mysql_query($query_Recordset1, $cnn_cargo) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
	
	//echo $query_Recordset1;
	//Si existe al menos una fila		
	if($totalRows_Recordset1 == 1){
		echo '<script language="javascript">';
		echo '$(document).ready(function() {';
		echo '$("#Errorx").css({ color: "#FF0000"});';
		echo '$("#usuario").focus();';
		echo '});';
		echo '</script>';			
		echo '<div id="Errorx">Usuario No Disponible, digite un Usuario diferente.<img src="../../no_ok.jpeg" width="32" height="32"></div>';
	}
	else{
		echo '<script language="javascript">';
		echo '$(document).ready(function() {';
		echo '$("#Successx").css({ color: "#009933"});';
		echo '});';
		echo '</script>';
		echo '<div id="Successx">Usuario Disponible<img src="../../ok.jpeg" width="32" height="32"></div>';
	}

mysql_free_result($Recordset1);
}
?>	