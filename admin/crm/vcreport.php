<?php 
/************************************************* */
if(isset($_GET['menu']))
{
    //$ThisPageName = 'vcreport.php?view='.$_GET['view'].'&menu=1&curP=1';
	$ThisPageName = 'viewCustomReports.php';
}else{

    $ThisPageName = 'viewCustomReports.php';
}
$EditPage = 1;
/* * *********************************************** */

include_once("../includes/header.php");
require_once($Prefix."classes/custom_reports.class.php");
require_once($Prefix . "classes/field.class.php");
require_once($Prefix . "classes/sales.customer.class.php");
require_once($Prefix."classes/item.class.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/region.class.php");

$objcusreport = new customreports();
$objItems     =   new items();
$objLead      =   new lead();
$objCustomer = new Customer();
$objregion  = new region(); 
$GLOBALS['useMainDB'] = $Config;
$RedirectURL  =  "viewCustomReports.php?curP=" . $_GET['curP'];

if ( strval($_GET['view']) != strval(intval($_GET['view'])) )
 {
	header('location:viewCustomReports.php');
 }else{
$Viewdata = $objcusreport->GetReportLists($_GET['view']);
$Viewdata = $Viewdata[0];

$fetchRes = $objcusreport->setFormat($Viewdata);
$reportdata = $objcusreport->generateReportData($fetchRes);
}
//echo "<pre/>";print_r($reportdata);
require_once("../includes/footer.php"); 	

?>
