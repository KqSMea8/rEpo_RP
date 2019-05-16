<?php
/**************************************************/
$ThisPageName = 'viewSubscriber.php'; $EditPage = 1;
/**************************************************/

include_once("includes/header.php");
 
require_once("classes/customer.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(Customer)) {
	$cmsCustomer = new Customer();
} else {
	echo "Class Not Found Error !! Customer Class Not Found !";
	exit;
}
$EmailId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
$ModuleTitle = "Edit Subscriber";
$ModuleName = 'Subscriber';
$ListTitle  = 'Subscriber';
$ListUrl    = "viewSubscriber.php?curP=".$_GET['curP'];
 
 
if (!empty($EmailId))
{
	$arrySubcriber = $cmsCustomer->getSubcriberById($EmailId);
	if($arrySubcriber[0]['Status'] == "No"){
		$SubcriberStatus = "No";
	}else{
		$SubcriberStatus = "Yes";
	}
}

	
 
if(!empty($_GET['active_id'])){
	$_SESSION['mess_Subscriber'] = $ModuleName.STATUS;
	$cmsCustomer->changeSubcriberStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['del_id'])){

	$_SESSION['mess_Subscriber'] = $ModuleName.REMOVED;
	$cmsCustomer->deleteSubcriber($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}



if (is_object($cmsCustomer)) {

	if ($_POST) {

		if (!empty($EmailId)) {
			$_SESSION['mess_Subscriber'] = $ModuleName.UPDATED;
			$cmsCustomer->updateSubcriber($_POST);
			header("location:".$ListUrl);
		}

		exit;

	}

	 
}



require_once("includes/footer.php");


?>
