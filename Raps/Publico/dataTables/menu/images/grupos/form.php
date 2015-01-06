<?php require_once('../Connections/cnn_plan_mejora.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_cnn_plan_mejora = new KT_connection($cnn_plan_mejora, $database_cnn_plan_mejora);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nom_ti_audit", true, "text", "", "", "", "Debe digitar un Nombre.");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an update transaction instance
$upd_tipo_auditoria = new tNG_update($conn_cnn_plan_mejora);
$tNGs->addTransaction($upd_tipo_auditoria);
// Register triggers
$upd_tipo_auditoria->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_tipo_auditoria->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_tipo_auditoria->registerTrigger("END", "Trigger_Default_Redirect", 99, "index.php");
// Add columns
$upd_tipo_auditoria->setTable("tipo_auditoria");
$upd_tipo_auditoria->addColumn("nom_ti_audit", "STRING_TYPE", "POST", "nom_ti_audit");
$upd_tipo_auditoria->setPrimaryKey("cod_ti_audit", "NUMERIC_TYPE", "GET", "cod_ti_audit");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstipo_auditoria = $tNGs->getRecordset("tipo_auditoria");
$row_rstipo_auditoria = mysql_fetch_assoc($rstipo_auditoria);
$totalRows_rstipo_auditoria = mysql_num_rows($rstipo_auditoria);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="nom_ti_audit">Nom_ti_audit:</label></td>
      <td><input type="text" name="nom_ti_audit" id="nom_ti_audit" value="<?php echo KT_escapeAttribute($row_rstipo_auditoria['nom_ti_audit']); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("nom_ti_audit");?> <?php echo $tNGs->displayFieldError("tipo_auditoria", "nom_ti_audit"); ?></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Actualizar registro" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>