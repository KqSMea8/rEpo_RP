<?php 	
	/**************************************************/
	$ThisPageName = 'callAddGroup.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();
	
			
			 $getcallsetting=$objphone->GetcallSetting();
		 	 $Config['DbName'] = $Config['DbMain'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 $server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
			 $server_id	= $getcallsetting[0]->server_id;
			 $objphone->server_id	= $server_data[0]->server_ip;
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();

	/*if($_GET["dv"]=='7'){
		$_GET["dv"] .= ',5,6';
	}*/
	
	$agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=$saveemp=array();
	//$agents=$objphone->api('acl_users.php',array());	
		
	$agents=$objphone->api('acl_extention.php',array());	
		
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	//$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
			$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;

			if($regisDat->type=='employee')
			$saveemp[]=$regisDat->user_id;
			else
			$saveemp[]='admin-'.$regisDat->user_id;
		}
	}
	
	if(!empty($agents)){
		foreach($agents as $agen){	
			$AnameByAid[$agen[0]]=$agen[1];
			$allagentdata[$agen[0]]=$agen;
		}	
	}
	$PageHeading = 'CRM Employee';
	if(!empty($_GET['del_id'])){
		$delId=base64_decode($_GET['del_id']);	
		$objphone->delete('c_callUsers',array('id'=>$delId));
		header('Location: employeeConnect.php');
		exit;
	}
	
	if(!empty($_POST))
	{			
			if(!empty($_POST['empdata'][0]['EmpID']) AND !empty($_POST['empdata'][0]['agentID'])){
				$savesdetail=	$objphone->connectCallServer($_POST['empdata'],$server_id);
				$_SESSION['mess_phone']='Save Successfully';
			}else{
					$_SESSION['mess_phone']='Please select required fields.';
			}
			header('Location: employeeConnect.php');
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
	$arryEmployee=array();
	$arryAdmin=array();
	if($numInDept>0){
		if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
		if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
		$_GET['Status']=1;
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$num=$objEmployee->numRows();
	}else{
		$ErrorMSG = NO_DEPARTMENT;
	}
	
 		$arryAdmin['EmpID']='admin-'.$_SESSION['AdminID'];
		$arryAdmin['EmpCode']='admin';
		$arryAdmin['UserName']=$_SESSION['DisplayName'];
		$arryAdmin['Email']=$_SESSION['Email'];
		$arryAdmin['JobTitle']='admin';
		$arryAdmin['Department']='admin';
				
		if(!empty($arryAdmin)){		
			array_unshift($arryEmployee,$arryAdmin);
			$num=$num+1;
		}		
		
		
		if(!empty($arryEmployee)){
				foreach($arryEmployee as $k=>$value){
				if($value['EmpCode']!='admin')
					$allemployeedata[$value['EmpID']]=$value;
				else
				$allemployeedata[$value['EmpID']]=$value;
				}
		}
		
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


