<?  
	/*****************************************/
		// Call Dashboard Start
	/*****************************************/
	$getcallsetting=$objphone->GetcallSetting();
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();

	$area_code = $objphone->CountryCodebyCompanyId($_SESSION['CmpID'],'front'); 
	$server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);


     $server_id =$objphone->server_id="";
	if(count($server_data)>0){
	$server_id	= $getcallsetting[0]->server_id;
	$objphone->server_id	= $server_data[0]->server_ip;
    }



	$Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();

	$calldetail = $objphone->getCallUserDetail($server_id, $_SESSION['AdminID'],$_SESSION['AdminType']);
	$CountryCodeEmp = $objphone->CountryCodebyEmp($_SESSION['AdminID']);
	      	
	
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

	unset($_GET['Department']); unset($_GET['Division']); //uset as set on top Sales Commission Report

	$Config['AllCallUser']=0;
	$_GET['Status']=1;	
	$arryEmployee =  $objphone->GetEmployeeListByIds($_GET,$saveemp);
	$num6         = $objphone->numRows();
	 
	$Config['AllCallUser']=1;
	$arryCallUser = $objphone->GetEmployeeListByIds($_GET,$saveemp);
	$numCallUser  = $objphone->numRows();

	$empid=0;
	$arryAdmin=array();
	if($_SESSION['AdminType'] == "admin"){
	$empid=isset($_GET['empId']);
	
 		$arryAdmin['EmpID']='admin-'.$_SESSION['AdminID'];
		$arryAdmin['EmpCode']='admin';
		$arryAdmin['UserName']=$_SESSION['DisplayName'];
		$arryAdmin['Email']=isset($_SESSION['Email']);
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
 	 
	/*****************************************/
		// Call Dashboard End
	/*****************************************/
?>
