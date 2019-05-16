<?php
/**************************************************/
$ThisPageName = 'viewTax.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");

require_once("classes/cartsettings.class.php");
require_once("classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(cartsettings)) {
	$objcartsettings=new Cartsettings();
} else {
	echo "Class Not Found Error !! Cart Settings Class Not Found !";
	exit;
}
$TaxId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
if ($TaxId && !empty($TaxId)) {$ModuleTitle = "Edit Tax";}else{$ModuleTitle = "Add Tax";}
$ModuleName = 'Tax';
$ListTitle  = 'Tax';
$ListUrl    = "viewTax.php?curP=".$_GET['curP'];


$arryTaxClasses =$objcartsettings->getClasses();
if ($TaxId && !empty($TaxId))
{
	$arryTax = $objcartsettings->getTaxById($TaxId);
	$UserLevelID = $arryTax[0]['UserLevel'];
	$UserLevelID = explode(",",$UserLevelID);
	foreach($UserLevelID as $useLevel)
	{
		$arrayUserLevelID[] = $useLevel;
	}
}

	
 
if(!empty($_GET['active_id'])){
	$_SESSION['mess_tax'] = $ModuleName.STATUS;
	$objcartsettings->changeTaxStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['del_id'])){
	 
	$_SESSION['mess_tax'] = $ModuleName.REMOVED;
	$objcartsettings->deleteTax($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}



if (is_object($objcartsettings)) {
		
	if ($_POST) {

		if (!empty($TaxId)) {
			$_SESSION['mess_tax'] = $ModuleName.UPDATED;
			$objcartsettings->updateTax($_POST);
			header("location:".$ListUrl);
		} else {
			$_SESSION['mess_tax'] = $ModuleName.ADDED;
			$lastShipId = $objcartsettings->addTax($_POST);
			header("location:".$ListUrl);
		}

		exit;
			
	}





	if($arryTax[0]['Status'] == "No"){
		$TaxStatus = "No";
	}else{
		$TaxStatus = "Yes";
	}

	$Userlevel =  $arryTax[0]['UserLevel'];
	$UserlevelExp = explode(",",$Userlevel);
	$SimpleUser = $UserlevelExp[0];
	$Wholesalers = $UserlevelExp[1];


}

$objCustomer = new Customer();
$arryCustomerGroups =$objCustomer->getCustomerGroups();

require_once("includes/footer.php");


?>