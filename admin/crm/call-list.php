<?php 
	//$HideNavigation=1;
	$ThisPageName = 'call-list.php'; 
	if(empty($_GET['export'])){
	include_once("../includes/header.php");
	}
	
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
	$agents=$empDetailByid=$saveagents=$AgentByEmp=$empByAgent=$AnameByAid=$allagentdata=$allemployeedata=$allcalldetail=$empQuota=array();
	$agents=$objphone->api('acl_extention.php',array());	
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	//$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	$saveemp=array();

	$showadmin=0;  // for show admin in select box
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
			if($regisDat->type=='employee'){
					$saveemp[]	= $regisDat->user_id;
				$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;
				$empByAgent[$regisDat->agent_id]=$regisDat->user_id;
			}elseif($regisDat->type=='admin'){
				$showadmin=1;
				$AgentByEmp['admin-'.$regisDat->user_id]=$regisDat->agent_id;
				$empByAgent[$regisDat->agent_id]='admin-'.$regisDat->user_id;
			}			
		}
	}
	
	/************************* Start Get Employee****************************/
	  $_GET['Status']=1; 
	  $arryEmployee =  $objphone->GetEmployeeListByIds($_GET,$saveemp);	
	  $num6         =	$objphone->numRows();
	  $arryAdmin=array();
	  if($_SESSION['AdminType'] == "admin" AND !empty($showadmin)){
		$empid=$_GET['empId'];		
	 		$arryAdmin['EmpID']='admin-'.$_SESSION['AdminID'];
			$arryAdmin['EmpCode']='admin';
			$arryAdmin['UserName']=$_SESSION['DisplayName'];
			$arryAdmin['Email']=$_SESSION['Email'];
			$arryAdmin['JobTitle']='admin';
			$arryAdmin['Department']='admin';			
			if(!empty($arryAdmin)){		
				array_unshift($arryEmployee,$arryAdmin);
				$num6=$num6+1;
			}
		}	
		if(!empty($arryEmployee)){
		foreach($arryEmployee as $emp){
			$empDetailByid[$emp['EmpID']]=$emp['UserName'];		
		}
		
		}
	 /************************* End ****************************/
	  
	  
	/************************* Start Get Agent****************************/
	if(!empty($agents)){
		foreach($agents as $agen){	
			$AnameByAid[$agen[0]]=$agen[1];
			$allagentdata[$agen[0]]=$agen;
		}	
	}
	 /************************* End ****************************/	
	$empId=!empty($_GET['empId'])?$_GET['empId']:0;		
	
	$url='acl_cdr.php?1=1';
	$paramFiltro=array();
	 		
	if(!empty($_GET['from'])){
         $url .= '&date_start='.date('Y-m-d',strtotime($_GET['from']));
	}
	if(!empty($_GET['to'])){
	      $url .= '&date_end='.date('Y-m-d',strtotime($_GET['to']));
	}
	

	
    $empid = base64_decode($_GET['empId']);
	if (strpos($empid,'admin-') !== false) {
		$explode_empid =   explode("admin-",$empid);
	   $user_type = 'admin'; 	
       $empid = (int) $explode_empid[1];
    }else{
	   $user_type = 'employee'; 	
       $empid = (int) $empid;
		
	}
	
	
	if(!empty($empid)){
		
		$extensions =  $objphone->getEmpExtenstion($empid,$user_type);
		
		
		$results =  array();
		$extension_array = array();
		foreach($extensions as $ext){
			
			 $extension_array[] = $ext->agent_id;
			 $url .= '&extension='.$ext->agent_id;
			 $allcalldetailBond=$objphone->api($url);
				if(count($allcalldetailBond)>0){
				 $total = $total+ $allcalldetailBond->total;	
				 $results = array_merge($results, $allcalldetailBond->cdrs);
				
				 } 
		}
		
		
		
	
		//$paramFiltro['extension']=$extesion;	
	//echo urlencode($url);
	
	 //if(!empty($_GET['from']) AND !empty($_GET['to']) AND !empty($_GET['uid'])){
	//	$allcalldetailBond=$objphone->api($url);
	 //}
		$empQuota =	$objphone->getEmpQuota($server_id,$empid);	
		
	}	

	require_once("../includes/footer.php"); 	 
?>


