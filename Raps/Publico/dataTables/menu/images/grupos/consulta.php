<?php require_once('../Connections/cnn_plan_mejora.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

//
session_start(); // start session.
if(isset($_SESSION["MM_Username"])){ // verifica si existe la sesion
// si existe la sesion asignamos  el idUser de la sesion
  $idUser=$_SESSION["MM_Username"]; 
}
//echo "sesion=".$idUser;  //$_SESSION['MM_Username']
//

$rs_tablas__MMColParam = $_GET['txtbuscar'];
if ($_REQUEST['txtbuscar'] <> "") 
{
	$rs_tablas__MMColParam = $_REQUEST['txtbuscar'];
}

if (($_GET['txtbuscar'] == "F" or $_REQUEST['txtbuscar'] == "F" ) and $_REQUEST['txtbuscar'] == "") 
{	
	$rs_tablas__MMColParam = "";
}

//

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_tipo_auditoria = 10;
$pageNum_rs_tipo_auditoria = 0;
if (isset($_GET['pageNum_rs_tipo_auditoria'])) {
  $pageNum_rs_tipo_auditoria = $_GET['pageNum_rs_tipo_auditoria'];
}
$startRow_rs_tipo_auditoria = $pageNum_rs_tipo_auditoria * $maxRows_rs_tipo_auditoria;

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rs_tipo_auditoria = "SELECT * FROM grupo_noconformidades WHERE nombre_grupo LIKE '%".$rs_tablas__MMColParam."%' OR nombre_corto LIKE '%".$rs_tablas__MMColParam."%' ORDER BY nombre_corto ASC";
$query_limit_rs_tipo_auditoria = sprintf("%s LIMIT %d, %d", $query_rs_tipo_auditoria, $startRow_rs_tipo_auditoria, $maxRows_rs_tipo_auditoria);
$rs_tipo_auditoria = mysql_query($query_limit_rs_tipo_auditoria, $cnn_plan_mejora) or die(mysql_error());
$row_rs_tipo_auditoria = mysql_fetch_assoc($rs_tipo_auditoria);

//echo $query_rs_tipo_auditoria;
if (isset($_GET['totalRows_rs_tipo_auditoria'])) {
  $totalRows_rs_tipo_auditoria = $_GET['totalRows_rs_tipo_auditoria'];
} else {
  $all_rs_tipo_auditoria = mysql_query($query_rs_tipo_auditoria);
  $totalRows_rs_tipo_auditoria = mysql_num_rows($all_rs_tipo_auditoria);
}
$totalPages_rs_tipo_auditoria = ceil($totalRows_rs_tipo_auditoria/$maxRows_rs_tipo_auditoria)-1;

$queryString_rs_tipo_auditoria = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_tipo_auditoria") == false && 
        stristr($param, "totalRows_rs_tipo_auditoria") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_tipo_auditoria = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_tipo_auditoria = sprintf("&totalRows_rs_tipo_auditoria=%d%s", $totalRows_rs_tipo_auditoria, $queryString_rs_tipo_auditoria);
?>
<link rel="stylesheet" type="text/css" href="css/base.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/tablas.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/gral.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/csstabla.css" media="all"/>
<link rel="stylesheet" href="../tinybox2/style.css" />
<script src="../jquery181.js"></script>
<script type="text/javascript" src="../tinybox2/tinybox.js"></script>
<script type="text/javascript" src="ajax.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
function boton(formName,action)
{
	if (action == "buscar") 
		{ 		
		  document.form1.hfbuscar.value = "T" ;
		  if (document.form1.txtbuscar.value == "") 
		  {
		  	document.form1.hfbuscar.value = "F" ;					
		  }
		}	  
	
    action = "submit" ; 	  
	var myString = "document."+formName+"."+action+"();";
	eval(myString);	 
	}
//-->
</script>
<script language="javascript">
function borra_ta(oId, par2){
	var service = oId;
	var nomemp = par2;
	//var dataString = 'id='+service;
    var msg = confirm("Desea eliminar el Grupo: "+ nomemp +" ?")
    if ( msg ) {
		$.ajax({
			type: "GET",
			url: "delete.php",
			data: 'id='+service,
			beforeSend :function()
 			{
				$('#borraitem').html('<img src="../indicator_green.gif">');
			},
			success:function(respuesta){
 				$('#fila_'+oId).empty();
				$('#borraitem').append('<div>Se ha eliminado correctamente el Grupo: '+nomemp+'.</div>').fadeOut(2000);
				$('#fila_'+oId).remove();
				location.reload();
 			}
		});					   
	}
}

</script>

<form action="" method="get" name="form1">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr class="odd">
    <td><a href="#" onclick="TINY.box.show({iframe:'add.php',boxid:'frameless',width:1000,height:540,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})"> <img src="../acciones/img/add.png" alt="Nuevo" width="16" height="16" border="0" align="absmiddle"></a></td>
    <td>Buscar Nombre:</td>
    <td><input name="txtbuscar" type="text" id="txtbuscar" size="40" maxlength="60"></td>
    <td><a href="#" onclick="boton('form1','buscar')"><img src="lupa.jpg" alt="Buscar" width="25" height="25" border="0" align="absmiddle"></a></td>
  <td><a href="../sub_index.php"><img src="cerrar.jpg" alt="Cerrar" width="25" height="25" border="0" align="absmiddle"></a></td>
  </tr>
</table>
<br>
<div id="formulario">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <thead>
  <tr>
    <th scope="col">CODIGO</th>
    <th scope="col">NOMBRE CORTO</th>
		<th scope="col">NOMBRE</th>
    <th scope="col">ESTADO</th>
    <th scope="col" colspan="2">Acciones</th>
  </tr>
  </thead>
  <?php do { 
  $pvar = $row_rs_tipo_auditoria['id'];
  ?>
    
    <tr id="fila_<?php echo $pvar?>">
      <td scope="row"><?php echo $row_rs_tipo_auditoria['id_grupo']; ?></td>
      <td scope="row"><?php echo htmlentities($row_rs_tipo_auditoria['nombre_corto']); ?></td>
			<td scope="row"><?php echo htmlentities($row_rs_tipo_auditoria['nombre_grupo']); ?></td>
      <td scope="row"><?php echo $row_rs_tipo_auditoria['estado']; ?></td>
      <td scope="row"><a href="#" onclick="TINY.box.show({iframe:'upd.php?id=<?php echo $pvar; ?>',boxid:'frameless',width:1000,height:500,fixed:false,maskid:'blackmask',maskopacity:40,closejs:function(){closeJS()}})"  class="fuentetest3"><img src="../acciones/img/database_edit.png" alt="Editar" width="16" height="16" border="0" align="absmiddle"></a></td>
      <td scope="row"><a href="#" id="btn_<?php echo $pvar; ?>" ><img src="../acciones/img/delete.png" alt="Borrar" width="16" height="16" border="0" align="absmiddle" onclick="borra_ta('<?php echo $pvar; ?>','<?php echo $row_rs_tipo_auditoria['nombre_grupo']; ?>')"></a>
      </td>
    </tr>
    
    <?php } while ($row_rs_tipo_auditoria = mysql_fetch_assoc($rs_tipo_auditoria)); ?>
</table>

<table border="0">
  <tr class="odd">
    <td><?php if ($pageNum_rs_tipo_auditoria > 0) { // Show if not first page ?>
       <a href="<?php printf("%s?pageNum_rs_tipo_auditoria=%d%s", $currentPage, 0, $queryString_rs_tipo_auditoria); ?>"><img src="../acciones/img/resultset_first.png" border="0" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rs_tipo_auditoria > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rs_tipo_auditoria=%d%s", $currentPage, max(0, $pageNum_rs_tipo_auditoria - 1), $queryString_rs_tipo_auditoria); ?>"><img src="../acciones/img/resultset_previous.png" border="0" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rs_tipo_auditoria < $totalPages_rs_tipo_auditoria) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rs_tipo_auditoria=%d%s", $currentPage, min($totalPages_rs_tipo_auditoria, $pageNum_rs_tipo_auditoria + 1), $queryString_rs_tipo_auditoria); ?>"><img src="../acciones/img/resultset_next.png" border="0" /></a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_rs_tipo_auditoria < $totalPages_rs_tipo_auditoria) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rs_tipo_auditoria=%d%s", $currentPage, $totalPages_rs_tipo_auditoria, $queryString_rs_tipo_auditoria); ?>"><img src="../acciones/img/resultset_last.png" border="0" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<div id="borraitem"></div>

<br>
<table border="0">
  <tr class="odd">
    <td class="titcont">Registros <?php echo ($startRow_rs_tipo_auditoria + 1) ?> a <?php echo min($startRow_rs_tipo_auditoria + $maxRows_rs_tipo_auditoria, $totalRows_rs_tipo_auditoria) ?> de <?php echo $totalRows_rs_tipo_auditoria ?>
    </td>
  </tr>
</table>
</div>

<input type="hidden" name="hfbuscar" value="F">
</form>
<?php
mysql_free_result($rs_tipo_auditoria);
?>
