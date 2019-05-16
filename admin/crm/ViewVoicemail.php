<?php 	
if(!empty($_GET['custompopup'])){
$HideNavigation=1;
$ModifyLabel=1;
	/**************************************************/
	$ThisPageName = 'ViewVoicemail.php'; 
	/**************************************************/
}

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
		if($_REQUEST['action']=='download'){
			
			$data = $objphone->api("acl_voicemail.php?action=download&ext=".$_REQUEST['ext']."&name=".$_REQUEST['name'], array());	
			die;
		}
	
		if($_REQUEST['action']=='delete'){
		 $fromdate = date('Y-m-d', strtotime($_REQUEST['from']));
		 $todate =  date('Y-m-d', strtotime($_REQUEST['to']));
		
		 $data = $objphone->api("acl_voicemail.php?action=delete&ext=".$_REQUEST['ext']."&name=".$_REQUEST['name'], array());	
		 if($data->success){
			 $_SESSION['mess_phone'] = $data->success;
		 }else{
			 $_SESSION['mess_phone'] = $data->error;
		 }
	
        $voiceCall = $objphone->api("acl_voicemail.php?action=display_record&fromdate=".$fromdate."&todate=".$todate, array());	
    
	
		if($voiceCall->success){
		 $regisData = $voiceCall->result;
		 header('Location: ViewVoicemail.php?from='.$_REQUEST['from'].'&to='.$_REQUEST['to']);
		 exit;
		}
		 
	}
	if(!empty($_REQUEST['from'])){
		$fromdate = date('Y-m-d', strtotime($_REQUEST['from']));
		$todate =  date('Y-m-d', strtotime($_REQUEST['to']));
		$search = '1';
	}else{
		$search =  '0';
		$fromdate = date("Y-m-d");
		$todate = date("Y-m-d");
	}
	$url="acl_voicemail.php?action=display_record&fromdate=".$fromdate."&todate=".$todate."&search=".$search;	
	
	//echo "<pre>";print_r($_SESSION);die;
	
	
	
	    if(!empty($_GET['empId'])){
			
			$empid = base64_decode($_GET['empId']);
			if (strpos($empid,'admin-') !== false) {
			$explode_empid =   explode("admin-",$empid);
			$user_type = 'admin'; 	
			$empid = (int) $explode_empid[1];
			}else{
			$user_type = 'employee'; 	
			$empid = (int) $empid;

			}	
			
		$regisData = array();
 		$extensions =  $objphone->getEmpExtenstion($empid,$user_type);
		$results =  array();
		$extension_array = array();
		foreach($extensions as $ext){
	      $url .="&ext=".$ext->agent_id;
	      $voiceCall = $objphone->api($url, array());	
			  if($voiceCall->success){
				 $regisData = array_merge($regisData,$voiceCall->result);
				 	 
			  } 
		}  
		}else{
	       $regisData =array();
	    }	
	
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


