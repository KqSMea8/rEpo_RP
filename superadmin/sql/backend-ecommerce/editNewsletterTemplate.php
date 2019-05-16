<?php
/**************************************************/
$ThisPageName = 'viewNewsletterTemplate.php'; $EditPage = 1;
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
$TemplateId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
$ModuleTitle = "Edit Newsletter Template";
$ModuleName = 'Newsletter Template';
$ListTitle  = 'Newsletter Template';
$ListUrl    = "viewNewsletterTemplate.php?curP=".$_GET['curP'];
 
 
if (!empty($TemplateId))
{
	$arryNewsletterTemplate = $cmsCustomer->getNewsletterTemplateById($TemplateId);
	if($arryNewsletterTemplate[0]['Status'] == "No"){
		$TemplateStatus = "No";
	}else{
		$TemplateStatus = "Yes";
	}
}

	
 
if(!empty($_GET['active_id'])){
	$_SESSION['mess_template'] = $ModuleName.STATUS;
	$cmsCustomer->changeNewsletterTemplateStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['del_id'])){

	$_SESSION['mess_template'] = $ModuleName.REMOVED;
	$cmsCustomer->deleteNewsletterTemplate($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}



if (is_object($cmsCustomer)) {

	if ($_POST) {

		if (!empty($TemplateId)) {
			$_SESSION['mess_template'] = $ModuleName.UPDATED;
			$cmsCustomer->updateNewsletterTemplate($_POST);
			header("location:".$ListUrl);
		}
		else
		{
			$_SESSION['mess_template'] = $ModuleName.ADDED;
			$cmsCustomer->addNewsletterTemplate($_POST);
			header("location:".$ListUrl);
		}

		exit;

	}

	 
}



require_once("includes/footer.php");


?>
