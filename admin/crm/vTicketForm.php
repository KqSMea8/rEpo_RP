<?php 
/**************************************************/
$ThisPageName = 'TicketForm.php'; $HideNavigation = 1;
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
$objLead = new lead();

$arryLeadForm = $objLead->GetLeadWebForm($_GET['formid']);

require_once("../includes/footer.php"); 
?>

