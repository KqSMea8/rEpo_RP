<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
/**************************************************/
$ThisPageName = 'viewGlobalAttribute.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");
require_once("classes/category.class.php");
require_once("classes/product.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number

if (class_exists(category)) {
	$objCategory=new category();
} else {
	echo "Class Not Found Error !! Category Class Not Found !";
	exit;
}

$objProduct = new product();
 

$ModuleName = 'Attribute';
$ListTitle  = 'Attributes';
$ListUrl    = "viewGlobalAttribute.php?curP=".$_GET['curP'];
 
if ($_REQUEST['edit'] && !empty($_REQUEST['edit']))
{
	$AttributeId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
	$arryAttributes = $objProduct->getGlobalAttributeById($AttributeId);

	$global_id = $arryAttributes[0]['Gaid'];
	if($global_id>0){
		$arrayOptionList= $objProduct->GetOptionList($global_id);
		$NumLine = sizeof($arrayOptionList);
	}


}

	
 

if(!empty($_GET['active_id'])){
	$_SESSION['mess_attr'] = $ModuleName.STATUS;
	$objProduct->changeGlobalAttributeStatus($_REQUEST['active_id']);

	header("location:".$ListUrl);
}




if(!empty($_GET['del_id'])){


	$_SESSION['mess_attr'] = $ModuleName.REMOVED;
	$objProduct->deleteGlobalAttribute($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}





if (is_object($objProduct)) {
		
	if ($_POST) {

		if (!empty($_POST['Gaid'])) {
			$_SESSION['mess_attr'] = $ModuleName.UPDATED;
			$objProduct->updateGlobalAttribute($_POST);
			$objProduct->AddUpdateGlobalAttOption($_POST['Gaid'],$_POST);
		} else {

			$_SESSION['mess_attr'] = $ModuleName.ADDED;
			$gaid_id = $objProduct->addGlobalAttribute($_POST);

			if($gaid_id>0){
				$objProduct->AddGlobalAttOption($gaid_id,$_POST);
			}
		}

		 
		header("location:".$ListUrl);
		exit;

	}





	if($arryAttributes[0]['Status'] != ''){
		$AttributeStatus = $arryAttributes[0]['Status'];
	}else{
		$AttributeStatus = 1;
	}
}

if($NumLine>0) $NumLine = $NumLine;else $NumLine=4;

require_once("includes/footer.php");


?>
