<?php 
/**************************************************/
$ThisPageName = 'viewCreateRMA.php'; $HideNavigation = 1;
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/rma.sales.class.php");
$objRmaSale = new rmasale();

$arryLeadForm = $objRmaSale->GetRmaWebForm($_GET['formid']);

require_once("../includes/footer.php"); 
?>

