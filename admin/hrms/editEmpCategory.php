<?php
	/**************************************************/
	$ThisPageName = 'viewEmpCategory.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$RedirectUrl ="viewEmpCategory.php";
	$ModuleName = 'Category';	
	if(!empty($_GET['del_id'])){
		if($_GET['del_id']>4){
			$_SESSION['mess_cat'] = EMP_CATEGORY_REMOVED;
			$objCommon->deleteEmpCategory($_GET['del_id']);
		}
		header("location:".$RedirectUrl);
		exit;
	}
   	if(!empty($_GET['active_id'])){
		$_SESSION['mess_cat'] = EMP_CATEGORY_STATUS_CHANGED;
		$objCommon->changeEmpCategoryStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	if($_POST){	
		CleanPost(); 
		if (!empty($_POST['value_id'])){
			$objCommon->updateEmpCategory($_POST);
			$_SESSION['mess_cat'] = EMP_CATEGORY_UPDATED;
		}else{
			$objCommon->addEmpCategory($_POST);
			$_SESSION['mess_cat'] = EMP_CATEGORY_ADDED;
		}			
		header("location:".$RedirectUrl);
		exit;		
	}
	
	
        $catName=''; $Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryCategory = $objCommon->getEmpCategoryDt($_GET['edit'],'');	
		$catName = stripslashes($arryCategory[0]['catName']);
		$Status   = $arryCategory[0]['Status'];
	} 
	require_once("../includes/footer.php");  
?>
