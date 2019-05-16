<?php 
    /**************************************************/
    $ThisPageName = 'callServerList.php'; $EditPage = 1; 
    /**************************************************/
    
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
    require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");
	$ModuleName = "Company";
	$objphone = new phone();
    
 

	if($_POST){
		CleanPost();
		$data_server['server_name'] = trim($_POST['serverName']);
		$data_server['server_ip'] = trim($_POST['serverIP']);
		$data_server['server_user'] = trim($_POST['serverID']);
		$data_server['server_password'] = $_POST['serverPassword'];
		$data_server['server_port'] = trim($_POST['serverPort']);
		if($_POST['Status']==1){
		$data_server['status'] = 'Active';
		}else{
		$data_server['status'] = 'Deactive';	
		}
		if(!empty($_GET['edit'])){
		$objphone->update('call_server', $data_server, array('id'=>$_GET['edit']));	
		$_SESSION['mess_server'] = 'Update successfully';
		}else{
		$objphone->insert('call_server', $data_server);
		$_SESSION['mess_server'] = 'Added successfully';
		}
		
		header('Location: callServerList.php');
	    exit;
	}

	 
  
        if(empty($_POST) && !empty($_GET['edit'])){
		$callServer = $objphone->ListServer(array('id'=>$_GET['edit']));
		$server_name = $callServer[0]->server_name;
		$server_ip = $callServer[0]->server_ip;
		$server_user = $callServer[0]->server_user;
 		$server_password = $callServer[0]->server_password;
		$server_port = $callServer[0]->server_port;
 	
	}else{
		$server_name = '';
		$server_ip = '';
		$server_user = '';
		$server_password = '';
		$server_port = '';
	}

	require_once("includes/footer.php"); 

?>


