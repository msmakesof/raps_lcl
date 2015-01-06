<?php require_once('../Connections/cnn_plan_mejora.php'); ?>
<?php require_once('../Connections/cnn_plan_mejora.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_cnn_plan_mejora = new KT_connection($cnn_plan_mejora, $database_cnn_plan_mejora);

// Make unified connection variable
$conn_cnn_plan_mejora = new KT_connection($cnn_plan_mejora, $database_cnn_plan_mejora);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("cod_ti_audit", true, "numeric", "int", "", "", "Debe Digitar un código.");
$formValidation->addField("nom_ti_audit", true, "text", "", "", "", "Debe digitar un Nombre.");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand 
function Trigger_Default_ManyToMany(&$tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("lista_chequeo");
  $mtm->setPkName("id");
  $mtm->setFkName("tipo_auditoria");
  $mtm->setFkReference("mtm");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany trigger

// Start trigger
$detailValidation = new tNG_FormValidation();
$tNGs->prepareValidation($detailValidation);
// End trigger

// Start trigger
$masterValidation = new tNG_FormValidation();
$masterValidation->addField("nom_ti_audit", true, "text", "", "", "", "Debe digitar un Nombre.");
$tNGs->prepareValidation($masterValidation);
// End trigger

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

// Filter
$tfi_listtipo_auditoria1 = new TFI_TableFilter($conn_cnn_plan_mejora, "tfi_listtipo_auditoria1");
$tfi_listtipo_auditoria1->addColumn("tipo_auditoria.nom_ti_audit", "STRING_TYPE", "nom_ti_audit", "%");
$tfi_listtipo_auditoria1->Execute();

// Sorter
$tso_listtipo_auditoria1 = new TSO_TableSorter("rstipo_auditoria1", "tso_listtipo_auditoria1");
$tso_listtipo_auditoria1->addColumn("tipo_auditoria.nom_ti_audit");
$tso_listtipo_auditoria1->setDefault("tipo_auditoria.nom_ti_audit");
$tso_listtipo_auditoria1->Execute();

// Navigation
$nav_listtipo_auditoria1 = new NAV_Regular("nav_listtipo_auditoria1", "rstipo_auditoria1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rstipo_auditoria1 = $_SESSION['max_rows_nav_listtipo_auditoria1'];
$pageNum_rstipo_auditoria1 = 0;
if (isset($_GET['pageNum_rstipo_auditoria1'])) {
  $pageNum_rstipo_auditoria1 = $_GET['pageNum_rstipo_auditoria1'];
}
$startRow_rstipo_auditoria1 = $pageNum_rstipo_auditoria1 * $maxRows_rstipo_auditoria1;

// Defining List Recordset variable
$NXTFilter_rstipo_auditoria1 = "1=1";
if (isset($_SESSION['filter_tfi_listtipo_auditoria1'])) {
  $NXTFilter_rstipo_auditoria1 = $_SESSION['filter_tfi_listtipo_auditoria1'];
}
// Defining List Recordset variable
$NXTSort_rstipo_auditoria1 = "tipo_auditoria.nom_ti_audit";
if (isset($_SESSION['sorter_tso_listtipo_auditoria1'])) {
  $NXTSort_rstipo_auditoria1 = $_SESSION['sorter_tso_listtipo_auditoria1'];
}
mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);

$query_rstipo_auditoria1 = "SELECT tipo_auditoria.nom_ti_audit, tipo_auditoria.cod_ti_audit FROM tipo_auditoria WHERE {$NXTFilter_rstipo_auditoria1} ORDER BY {$NXTSort_rstipo_auditoria1}";
$query_limit_rstipo_auditoria1 = sprintf("%s LIMIT %d, %d", $query_rstipo_auditoria1, $startRow_rstipo_auditoria1, $maxRows_rstipo_auditoria1);
$rstipo_auditoria1 = mysql_query($query_limit_rstipo_auditoria1, $cnn_plan_mejora) or die(mysql_error());
$row_rstipo_auditoria1 = mysql_fetch_assoc($rstipo_auditoria1);

if (isset($_GET['totalRows_rstipo_auditoria1'])) {
  $totalRows_rstipo_auditoria1 = $_GET['totalRows_rstipo_auditoria1'];
} else {
  $all_rstipo_auditoria1 = mysql_query($query_rstipo_auditoria1);
  $totalRows_rstipo_auditoria1 = mysql_num_rows($all_rstipo_auditoria1);
}
$totalPages_rstipo_auditoria1 = ceil($totalRows_rstipo_auditoria1/$maxRows_rstipo_auditoria1)-1;
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_cnn_plan_mejora, $cnn_plan_mejora);
$query_rstipo_auditoria2 = "SELECT tipo_auditoria.cod_ti_audit, tipo_auditoria.nom_ti_audit, lista_chequeo.id FROM tipo_auditoria LEFT JOIN lista_chequeo ON (lista_chequeo.tipo_auditoria=tipo_auditoria.cod_ti_audit AND lista_chequeo.id=0123456789)";
$rstipo_auditoria2 = mysql_query($query_rstipo_auditoria2, $cnn_plan_mejora) or die(mysql_error());
$row_rstipo_auditoria2 = mysql_fetch_assoc($rstipo_auditoria2);
$totalRows_rstipo_auditoria2 = mysql_num_rows($rstipo_auditoria2);

// Make an insert transaction instance
$ins_tipo_auditoria = new tNG_insert($conn_cnn_plan_mejora);
$tNGs->addTransaction($ins_tipo_auditoria);
// Register triggers
$ins_tipo_auditoria->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_tipo_auditoria->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tipo_auditoria->registerTrigger("END", "Trigger_Default_Redirect", 99, "index.php");
$ins_tipo_auditoria->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
// Add columns
$ins_tipo_auditoria->setTable("tipo_auditoria");
$ins_tipo_auditoria->addColumn("cod_ti_audit", "NUMERIC_TYPE", "POST", "cod_ti_audit");
$ins_tipo_auditoria->addColumn("nom_ti_audit", "STRING_TYPE", "POST", "nom_ti_audit");
$ins_tipo_auditoria->setPrimaryKey("cod_ti_audit", "NUMERIC_TYPE");

// Make an insert transaction instance
$ins_tipo_auditoria1 = new tNG_insert($conn_cnn_plan_mejora);
$tNGs->addTransaction($ins_tipo_auditoria1);
// Register triggers
$ins_tipo_auditoria1->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_tipo_auditoria1->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $masterValidation);
$ins_tipo_auditoria1->registerTrigger("END", "Trigger_Default_Redirect", 99, "index.php");
$ins_tipo_auditoria1->registerTrigger("AFTER", "Trigger_LinkTransactions", 98);
$ins_tipo_auditoria1->registerTrigger("ERROR", "Trigger_LinkTransactions", 98);
// Add columns
$ins_tipo_auditoria1->setTable("tipo_auditoria");
$ins_tipo_auditoria1->addColumn("nom_ti_audit", "STRING_TYPE", "POST", "nom_ti_audit");
$ins_tipo_auditoria1->setPrimaryKey("cod_ti_audit", "NUMERIC_TYPE");

// Make an insert transaction instance
$ins_lista_chequeo = new tNG_insert($conn_cnn_plan_mejora);
$tNGs->addTransaction($ins_lista_chequeo);
// Register triggers
$ins_lista_chequeo->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", null);
$ins_lista_chequeo->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $detailValidation);
// Add columns
$ins_lista_chequeo->setTable("lista_chequeo");
$ins_lista_chequeo->addColumn("id_auditoria", "NUMERIC_TYPE", "POST", "id_auditoria");
$ins_lista_chequeo->addColumn("req_cri_nor", "STRING_TYPE", "POST", "req_cri_nor");
$ins_lista_chequeo->addColumn("pregunta", "STRING_TYPE", "POST", "pregunta");
$ins_lista_chequeo->addColumn("tipo_auditoria", "NUMERIC_TYPE", "VALUE", "");
$ins_lista_chequeo->setPrimaryKey("id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Execute all the registered transactions
$tNGs->executeTransactions();

$nav_listtipo_auditoria1->checkBoundries();

// Get the transaction recordset
$rslista_chequeo = $tNGs->getRecordset("lista_chequeo");
$row_rslista_chequeo = mysql_fetch_assoc($rslista_chequeo);
$totalRows_rslista_chequeo = mysql_num_rows($rslista_chequeo);

// Get the transaction recordset
$rstipo_auditoria = $tNGs->getRecordset("tipo_auditoria");
$row_rstipo_auditoria = mysql_fetch_assoc($rstipo_auditoria);
$totalRows_rstipo_auditoria = mysql_num_rows($rstipo_auditoria);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..::: Inter Rapidísimo   -  Plan de Mejoramiento.   :::..</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content='IE=9' http-equiv='X-UA-Compatible'/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!—[if lt IE 9]>
  <script src="html5.js"></script>
<![endif]—>

<style>
  body { padding-top: 60px; }
</style>
<link rel="stylesheet" type="text/css" href="css/base.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/tablas.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/gral.css" media="all"/>
<script type="text/javascript" src="tinybox2/tinybox.js"></script>
<script src="jquery181.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_nom_ti_audit {width:140px; overflow:hidden;}
</style>
<?php echo $tNGs->displayValidationRules();?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>
<body>
<div align="center">

<div class="container" id="general">
 <div id="" class="row">
  <div id="encabezado" class="span12">
	<div class="span2">&nbsp;</div>
    <div class="kfizq" id="logo"><img src="../imgs/logo.jpg" width="222" height="59" /></div>    
    <div class="kfder"><span class="txts">MODULO DE PLAN DE MANEJO - Lista de Tipos de Auditor&iacute;a.</span></div>
        
 </div>
 </div>
 
 <div id="cuerpox">
   <div class="KT_tng" id="listtipo_auditoria1">
     <h1> Tipo_auditoria
       <?php
  $nav_listtipo_auditoria1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
     </h1>
     <div class="KT_tnglist">
       <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
         <div class="KT_options"> <a href="<?php echo $nav_listtipo_auditoria1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
           <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listtipo_auditoria1'] == 1) {
?>
             <?php echo $_SESSION['default_max_rows_nav_listtipo_auditoria1']; ?>
             <?php 
  // else Conditional region1
  } else { ?>
             <?php echo NXT_getResource("all"); ?>
             <?php } 
  // endif Conditional region1
?>
           <?php echo NXT_getResource("records"); ?></a> &nbsp;
           &nbsp;
           <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listtipo_auditoria1'] == 1) {
?>
             <a href="<?php echo $tfi_listtipo_auditoria1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
             <?php 
  // else Conditional region2
  } else { ?>
             <a href="<?php echo $tfi_listtipo_auditoria1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
             <?php } 
  // endif Conditional region2
?>
         </div>
         <table cellpadding="2" cellspacing="0" class="KT_tngtable">
           <thead>
             <tr class="KT_row_order">
               <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
               </th>
               <th id="nom_ti_audit" class="KT_sorter KT_col_nom_ti_audit <?php echo $tso_listtipo_auditoria1->getSortIcon('tipo_auditoria.nom_ti_audit'); ?>"> <a href="<?php echo $tso_listtipo_auditoria1->getSortLink('tipo_auditoria.nom_ti_audit'); ?>">Nom_ti_audit</a></th>
               <th>&nbsp;</th>
             </tr>
             <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtipo_auditoria1'] == 1) {
?>
               <tr class="KT_row_filter">
                 <td>&nbsp;</td>
                 <td><input type="text" name="tfi_listtipo_auditoria1_nom_ti_audit" id="tfi_listtipo_auditoria1_nom_ti_audit" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtipo_auditoria1_nom_ti_audit']); ?>" size="20" maxlength="30" /></td>
                 <td><input type="submit" name="tfi_listtipo_auditoria1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
               </tr>
               <?php } 
  // endif Conditional region3
?>
           </thead>
           <tbody>
             <?php if ($totalRows_rstipo_auditoria1 == 0) { // Show if recordset empty ?>
               <tr>
                 <td colspan="3"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
               </tr>
               <?php } // Show if recordset empty ?>
             <?php if ($totalRows_rstipo_auditoria1 > 0) { // Show if recordset not empty ?>
               <?php do { 
			   $vx =  $row_rstipo_auditoria1['cod_ti_audit']; 
			   ?>
                 <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                   <td><input type="checkbox" name="kt_pk_tipo_auditoria" class="id_checkbox" value="<?php echo $row_rstipo_auditoria1['cod_ti_audit']; ?>" />
                     <input type="hidden" name="cod_ti_audit" class="id_field" value="<?php echo $row_rstipo_auditoria1['cod_ti_audit']; ?>" /></td>
                   <td><div class="KT_col_nom_ti_audit"><?php echo KT_FormatForList($row_rstipo_auditoria1['nom_ti_audit'], 20); ?></div></td>
                   <td><a class="KT_edit_link" href="form.php?cod_ti_audit=<?php echo $vx;?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                 </tr>
                 <?php } while ($row_rstipo_auditoria1 = mysql_fetch_assoc($rstipo_auditoria1)); ?>
               <?php } // Show if recordset not empty ?>
           </tbody>
         </table>
         <div class="KT_bottomnav">
           <div>
             <?php
            $nav_listtipo_auditoria1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
           </div>
         </div>
         <div class="KT_bottombuttons">
           <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a></div>
           <span>&nbsp;</span>
           <select name="no_new" id="no_new">
             <option value="1">1</option>
             <option value="3">3</option>
             <option value="6">6</option>
           </select>
           <a class="KT_additem_op_link" href="form.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a></div>
       </form>
       <?php
	echo $tNGs->getErrorMsg();
?>
       <form method="post" id="form2" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
         <table cellpadding="2" cellspacing="0" class="KT_tngtable">
           <tr>
             <td class="KT_th"><label for="cod_ti_audit">Cod_ti_audit:</label></td>
             <td><input type="text" name="cod_ti_audit" id="cod_ti_audit" value="<?php echo KT_escapeAttribute($row_rstipo_auditoria['cod_ti_audit']); ?>" size="32" />
               <?php echo $tNGs->displayFieldHint("cod_ti_audit");?> <?php echo $tNGs->displayFieldError("tipo_auditoria", "cod_ti_audit"); ?></td>
           </tr>
           <tr>
             <td class="KT_th"><label for="nom_ti_audit">Nom_ti_audit:</label></td>
             <td><input type="text" name="nom_ti_audit" id="nom_ti_audit" value="<?php echo KT_escapeAttribute($row_rstipo_auditoria['nom_ti_audit']); ?>" size="32" />
               <?php echo $tNGs->displayFieldHint("nom_ti_audit");?> <?php echo $tNGs->displayFieldError("tipo_auditoria", "nom_ti_audit"); ?></td>
           </tr>
           <tr>
             <td class="KT_th"><label>Tipo_auditoria:</label></td>
             <td><table border="0" class="KT_mtm">
               <tr>
                 <?php
  $cnt2 = 0;
?>
                 <?php
  if ($totalRows_rstipo_auditoria>0) {
    $nested_query_rstipo_auditoria2 = str_replace("123456789", $row_rstipo_auditoria['cod_ti_audit'], $query_rstipo_auditoria2);
    mysql_select_db($database_cnn_plan_mejora);
    $rstipo_auditoria2 = mysql_query($nested_query_rstipo_auditoria2, $cnn_plan_mejora) or die(mysql_error());
    $row_rstipo_auditoria2 = mysql_fetch_assoc($rstipo_auditoria2);
    $totalRows_rstipo_auditoria2 = mysql_num_rows($rstipo_auditoria2);
    $nested_sw = false;
    if (isset($row_rstipo_auditoria2) && is_array($row_rstipo_auditoria2)) {
      do { //Nested repeat
?>
                 <td><input id="mtm_<?php echo $row_rstipo_auditoria2['cod_ti_audit']; ?>" name="mtm_<?php echo $row_rstipo_auditoria2['cod_ti_audit']; ?>" type="checkbox" value="1" <?php if ($row_rstipo_auditoria2['id'] != "") {?> checked<?php }?> /></td>
                 <td><label for="mtm_<?php echo $row_rstipo_auditoria2['cod_ti_audit']; ?>"><?php echo $row_rstipo_auditoria2['nom_ti_audit']; ?></label></td>
                 <?php
	$cnt2++;
	if ($cnt2%3 == 0) {
		echo "</tr><tr>";
	}
?>
                 <?php
      } while ($row_rstipo_auditoria2 = mysql_fetch_assoc($rstipo_auditoria2)); //Nested move next
    }
  }
?>
               </tr>
             </table></td>
           </tr>
           <tr class="KT_buttons">
             <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insertar registro" /></td>
           </tr>
         </table>
       </form>
       <p>&nbsp;</p>
     </div>
     <br class="clearfixplain" />
   </div>
   <p>&nbsp;</p>
 </div>
 
 
 <div id="" class="row">
	<div id="footer" class="span12">
 	<span>Todos los derechos reservados - Inter Rapidísimo.</span>
 	</div>
 </div> 
   
</div>  

</div>

</body>
</html>
<?php
mysql_free_result($rstipo_auditoria1);

mysql_free_result($rstipo_auditoria2);
?>
