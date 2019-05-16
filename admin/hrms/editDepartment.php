<?php
	/**************************************************/
	$ThisPageName = 'viewDepartment.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();
	$objCommon=new common();

	$HideRow='';
	if(sizeof($arryDepartment)==1){
		$_GET['d']=$arryDepartment[0]['depID'];	
		$HideRow = 'Style="display:none;"';
	}
	$ModuleName = "Department";
	
	$RedirectUrl = "viewDepartment.php?d=".$_GET['d']."&curP=".$_GET['curP'];

	if(empty($_GET['d'])){
		header("location: ".$RedirectUrl);
		exit;
	}

	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_dept'] = DEPT_REMOVED;
		$objCommon->deleteDepartment($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_dept'] = DEPT_STATUS_CHANGED;
		$objCommon->changeDepartmentStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if ($_POST) {
		CleanPost(); 
		if(!empty($_POST['depID'])) {
			$objCommon->updateDepartment($_POST);
			//if($_POST["EmpID"]>0 && $_POST["EmpID"] != $_POST["OldEmpID"]){
			
			$objEmployee->UpdateDeptHead($_POST["depID"],$_POST["EmpID"],1);
			$objEmployee->UpdateOtherHead($_POST["depID"],$_POST["EmpID1"],$_POST["EmpID2"]);
			
			$ImageId = $_POST['depID'];
			$_SESSION['mess_dept'] = DEPT_UPDATED;
		}else {		
			$ImageId = $objCommon->addDepartment($_POST);
			$_SESSION['mess_dept'] = DEPT_ADDED;
		}		
		
		$RedirectUrl = "viewDepartment.php?d=".$_POST['Division']."&curP=".$_GET['curP'];

		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryDept = $objCommon->getDepartment($_GET['edit'],'','');
		$Status   = $arryDept[0]['Status'];
		$arryOtherHead = $objCommon->getOtherHead($_GET['edit'],'');

	}else{
		$arryDept[0]['Department']='';
	}	


 	$_SESSION['CmpDepartment'] = $Config['CmpDepartment'];

	require_once("../includes/footer.php"); 
 
 ?>
