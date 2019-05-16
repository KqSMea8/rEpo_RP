<?php
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/employee.class.php");        
	require_once($Prefix."classes/event.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objphone=new phone();    
	$objEmployee=new employee();
	$ModuleName = "Dashboard";

	$getcallsetting=$objphone->GetcallSetting();
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();

	$area_code = $objphone->CountryCodebyCompanyId($_SESSION['CmpID'],'front'); 
	$server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
	$server_id	= $getcallsetting[0]->server_id;
	$objphone->server_id	= $server_data[0]->server_ip;
	$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();

	$calldetail = $objphone->getCallUserDetail($server_id, $_SESSION['AdminID'],$_SESSION['AdminType']);
	$CountryCodeEmp = $objphone->CountryCodebyEmp($_SESSION['AdminID']);
	      	
	
	$objLead=new lead();
	$objQuote=new quote();
	$objActivity=new activity();



/**************My New Lead*************/

      $arryMyLead=$objLead->GetDashboardLead();
	  $num1=$objLead->numRows();

 /**************End New Ticket*************/
$arryTicket=$objLead->GetDashboardTicket();

	  $num2=$objLead->numRows();
 /**************Top Opportunities*************/

      $arryTopOpp=$objLead->GetDashboardOpportunity();
     
	  $num3=$objLead->numRows();

 /**************End New Opportunities*************/
$arryCompaign=$objLead->GetDashboardCompaign();


	  $num4=$objLead->numRows();

$arryQuote=$objQuote->GetDashboardQuote();


	  $num5=$objQuote->numRows();

 /************************************/

$arryActivity=$objActivity->GetActivityDeshboard();


	  $num6=$objActivity->numRows();
	  
	
	  /******************For Call******************/
	  $agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=$allcalldetail=$empQuota=array();
	$agents=$objphone->api('acl_users.php',array());	
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
			$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;
		}
	}
	
	if(!empty($agents)){
		foreach($agents as $agen){	
			$AnameByAid[$agen[0]]=$agen[2];
			$allagentdata[$agen[0]]=$agen;
		}	
	}
	  $_GET['Status']=1;
	  
	
	  $arryEmployee =  $objphone->GetEmployeeListByIds($_GET,$saveemp);
	  
	  
	
	  $num6         =	$objphone->numRows();
	  
	//  $arryEmployee=$objEmployee->GetEmployeeList($_GET);
	//  $num6=$objEmployee->numRows();

	//$pagerLink=$objPager->getPager($arryEmployee,10,$_GET['curP']);
//	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	$empid=0;
	$arryAdmin=array();
	if($_SESSION['AdminType'] == "admin"){
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
	else
	$empid=$_SESSION['AdminID'];
	if(!empty($empid)){
	$url='acl_cdr.php';
			  $extesion=!empty($allagentdata[$AgentByEmp[$empid]][3])?$allagentdata[$AgentByEmp[$empid]][3]:0;
	if(!empty($extesion))
			 $allcalldetail=$objphone->api($url,array('extension'=>$extesion));		

			 
		$empQuota =	$objphone->getEmpQuota($server_id,$empid);	
		
	}
 	 


	 

	require_once("../includes/footer.php"); 
?>
