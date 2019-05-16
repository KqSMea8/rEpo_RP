<?php	

/**************************************************/
$module = "Lead"; $EditPage = 1;
$ThisPageName = 'viewLead.php?module=lead'; 		
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/territory.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/function.class.php");
require_once('../php-excel-reader/excel_reader2.php');
require_once('../php-excel-reader/SpreadsheetReader.php');
require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');


require_once($Prefix."classes/field.class.php");
$objField = new field();


$objLead=new lead();
$objTerritory=new territory();
$objEmployee=new employee();
$objFunction=new functions();
$RedirectURL = $ThisPageName;



if($_GET['by']=="indiamart"){

	//$url= 'http://'.$_SERVER['HTTP_HOST'].'/erp/cron/indiaMartApi.php';
	//$response = file_get_contents($url);
	$pid = exec('php /var/www/html/erp/cron/indiaMartApi.php > /dev/null & echo $!;', $output, $return);
	
	if ($pid) {
			$statusPID = true;
			$objConfig->removePID('crm','addLead');
			$objConfig->setPID('crm','addLead',$pid);
		} else {
			$statusPID = false;
		}


}








include_once("../includes/footer.php"); 
?>
