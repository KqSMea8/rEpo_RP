<?php
/**************************************************/
$ThisPageName = 'viewassignWebsite.php'; $EditPage = 1;
/**************************************************/

include_once("../includes/header.php");
 
require_once($Prefix."classes/webcms.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(cms)) {
	$webcmsObj=new webcms();

} else {
	echo "Class Not Found Error !! CMS Class Not Found !";
	exit;
}

$ModuleTitle = "Assign Website";
$ModuleName = 'Assign Website';
$ListTitle  = 'Assign Website';
$ListUrl    = "viewassignWebsite.php?curP=".$_GET['curP'];
 
 

	
	
/****************Create Tree Array for Menu****************/
	
$CustomersArray = $webcmsObj->getCustomers();




if(!empty($_GET['del_id'])){
	 
	$_SESSION['mess_Page'] = $ModuleName.REMOVED;
	$webcmsObj->unassignCustomer($_GET['del_id'],$_GET['cust_id']);
	header("location:".$ListUrl);
	exit;
}


$SubHeading = 'Assign';
if (is_object($webcmsObj)) {
		
	if ($_POST) {
		$allowedWebsite=$webcmsObj->totalAllowedSites();
		$assigndWebsite=$webcmsObj->totalAssignedSites();
		if($allowedWebsite>$assigndWebsite){
			$_SESSION['mess_Page'] = $ModuleName.ADDED;
			$lastShipId = $webcmsObj->assignCustomer($_POST);
		}else{
			$_SESSION['mess_Page'] = 'You can not assign more than '.$allowedWebsite.' Website';
		}
		
		header("location:".$ListUrl);

		exit;
			
	}








}



require_once("../includes/footer.php");


?>
