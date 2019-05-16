<?php
/**************************************************/
$ThisPageName = 'viewCustomer.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");

require_once("classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(customer)) {
	$objCustomer=new Customer();
} else {
	echo "Class Not Found Error !! Cart Settings Class Not Found !";
	exit;
}


$CustId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
$ListUrl = "viewCustomer.php?curP=".$_GET['curP'];
$ListTitle = "Customers";
$ModuleTitle = "Edit Customer";
$ModuleName = "Customer";
if(!empty($CustId)){
	$arryCustomer = $objCustomer->getCustomerById($CustId);
}


if(!empty($_GET['del_id'])){
	 
	$_SESSION['mess_cust'] = $ModuleName.REMOVED;
	$objCustomer->deleteCustomer($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}

if(!empty($_GET['active_id'])){
	$_SESSION['mess_cust'] = $ModuleName.STATUS;
	$objCustomer->changeCustomerStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}




if (is_object($objCustomer)) {
		
	if ($_POST) {

		if (!empty($CustId)) {
			$_SESSION['mess_cust'] = $ModuleName.UPDATED;
			$objCustomer->updateCustomer($_POST);
			header("location:".$ListUrl);
		}

		exit;

	}

		
}

$arryCustomerGroups =$objCustomer->getCustomerGroups();


require_once("includes/footer.php");


?>
