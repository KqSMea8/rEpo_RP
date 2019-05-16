<?php 	
	/**************************************************/
	$HideNavigation=1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();
	$server_id=1;

	/*if($_GET["dv"]=='7'){
		$_GET["dv"] .= ',5,6';
	}*/
	
	$empid=base64_decode($_GET['id']);	
	$agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=array();
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	// agent IDs
	$saveemp=$objphone->getCallRegiUserid($server_id);	       // employee IDs
	$regisData=$objphone->getCallRegisData($server_id);
	
	
	
	
	
	if(!empty($_POST))
	{		
	
			if(!empty($_POST['duration']) AND !empty($_POST['q_time'])){
				$data=$objphone->getEmpQuota($server_id,$empid);
				if(empty($data))
				$objphone->SaveEmpQuota(array('start_date'=>date('Y-m-d h:i:s'),'user_id'=>$empid,'server_id'=>$server_id,'duration'=>$_POST['duration'],'q_time'=>$_POST['q_time']));
				else 
				  $objphone->updateEmpQuota(array('duration'=>$_POST['duration'],'q_time'=>$_POST['q_time']),array('server_id'=>$server_id,'user_id'=>$empid,'status'=>'active'));
				$_SESSION['mess_phone']='Save Successfully';
				header('Location: save_employeeQuota.php');
				exit;
			}else{
					$_SESSION['mess_phone']='Please Select Requried Fields';
			}
			header('Location: save_employeeQuota.php');
			exit;
		
	}
	unset($arryInDepartment);
	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
	if($_GET["dv"]>0){
		$arryDepartmentRec = $objConfigure->GetDepartmentInfo($_GET["dv"]);
		//$PageHeading .= ' from '.$arryDepartmentRec[0]['Department'];
	}



	/*************************/
	if($numInDept>0){
		if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
		if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$num=$objEmployee->numRows();
		if(!empty($arryEmployee)){
		foreach($arryEmployee as $k=>$value)
				$allemployeedata[$value['EmpID']]=$value;
		}
		
	}else{
		$ErrorMSG = NO_DEPARTMENT;
	}

	
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


