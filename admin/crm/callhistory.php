<?php 
	$HideNavigation=1;
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
	$agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=$allcalldetail=$empQuota=array();
	$agents=$objphone->api('acl_extention.php',array());	
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
//	$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
		if($regisDat->type=='employee'){		
			$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;
		}elseif($regisDat->type=='admin'){
			$AgentByEmp['admin-'.$regisDat->user_id]=$regisDat->agent_id;
		}
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
	
	
	
	//$empid=!empty($_GET['empId'])?$_GET['empId']:0;
	
	$empid=$_GET['empId'];
	if (strpos($empid,'admin-') !== false) {
		$explode_empid =   explode("admin-",$empid);
	   $user_type = 'admin'; 	
       $empid = (int) $explode_empid[1];
    }else{
	   $user_type = 'employee'; 	
       $empid = (int) $empid;
		
	}
	
	
	
	if(!empty($empid)){
	$url='acl_cdr.php';
	$paramFiltro=array();
		  
	if(!empty($_GET['startDate'])){
         $url .= '?date_start='.$_GET['startDate'];
	}
	if(!empty($_GET['endDate'])){
	      $url .= '&date_end='.$_GET['endDate'];
	}
	
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
		 
		$empQuota =	$objphone->getEmpQuota($server_id,$empid);	
	}
	
	require_once("../includes/footer.php"); 	 
?>


