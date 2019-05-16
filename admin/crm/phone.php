<?php 	/**************************************************/
	$ThisPageName = 'call.php'; 
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
			 $server_ip= $objphone->server_id	= $server_data[0]->server_ip;
			 $Config['DbName'] = $Config['DbMain'].'_'.$_SESSION['DisplayName'];
			 $objConfig->dbName = $Config['DbName'];
			 $objConfig->connect();
			 $usertype='employee';
			 if(!empty($_SESSION['AdminType']) AND $_SESSION['AdminType']=='admin'){
			 	$usertype='admin';			 
			 }	 
			
		$calldetail=$objphone->getCallUserDetail($server_id,$_SESSION['AdminID'],$usertype);
		$callExt=$CallName='';
		if(!empty($calldetail)){
			$callExt=$calldetail[0]->agent_id;
			if($_SESSION['AdminType']=='admin'){
				$CallName=$_SESSION['UserName'];
			}elseif($_SESSION['AdminType']=='employee'){
				$CallName=$_SESSION['UserName'];			
			}
			
		}
		
	?>
<?php require_once("../includes/footer.php"); 	
?>