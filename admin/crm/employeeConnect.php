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
	
	 
	# if click on the line/web phone button
	if(!empty($_GET['active_id'])){
		
		$id = $_GET['active_id'];
		$user_id = $_GET['user_id'];
		$status = $_GET['status'];
		  
		$data =  array();
		if($status=="Yes"){
			$data['is_site'] = 'No';
			$objphone->update('c_callUsers', $data, array('id'=>$id));
		}else{
			$objphone->update('c_callUsers', array('is_site'=>'No'), array('user_id'=>$user_id));
			$objphone->update('c_callUsers', array('is_site'=>'Yes'), array('id'=>$id));
           
		}
		
		$_SESSION['mess_phone']='Update successfully.';
		header('Location: employeeConnect.php');
		exit;
		
	}
	
	$agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=$saveemp=$connectUser=array();
	//$agents=$objphone->api('acl_users.php',array());	
	$adminConnect=false;
	$agents=$objphone->api('acl_extention.php',array());		
		
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	
	//$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
			$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;

			if($regisDat->type=='employee')
			$saveemp[]=$regisDat->user_id;
			else{
			$saveemp[]='admin-'.$regisDat->user_id;
			$adminConnect=true;
			    $admindata[] = array('id'=>$regisDat->id,'is_site'=>$regisDat->is_site,'UserName'=>$_SESSION['DisplayName'],'agent_id'=>$regisDat->agent_id,'user_id'=>$regisDat->user_id,'type'=>$regisDat->type);
				
			}
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
	  
		CleanPostMulti();

			if(!empty($_POST['empdata'][0]['EmpID']) AND !empty($_POST['empdata'][0]['agentID'])){
				#get secret key
				$secretKey = $objphone->api('acl_secret.php',array('extdisplay'=>$_POST['empdata'][0]['agentID']));
				
				$savesdetail=	$objphone->connectCallServer($_POST['empdata'],$server_id, $secretKey);
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
	
		$connectUser=$objphone->ConnectUserDetail(array('Status'=>1),array(),$server_id);
		
		
		if(!empty($adminConnect)){
		   $connectUser =	array_merge($connectUser,$admindata);
		}			
		
		//echo "<pre>";print_r($connectUser);die;
		
		//$secretKey = $objphone->api('acl_secret.php',array('extdisplay'=>3020));
	//echo "qweqweqqwe";print_r($secretKey);die;
		
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


