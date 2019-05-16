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
    
  
  
    if(empty($_POST) && !empty($_REQUEST['edit'])){
		  $CountryCode = $objphone->ListCountryCode(array('country_id'=>$_REQUEST['edit']));
	}

	if($_POST){
		//$data_server['name'] = trim($_POST['name']);
		$data_server['isd_code'] = trim($_POST['code']);
		$data_server['isd_prefix'] = trim($_POST['isd_prefix']);
		if($_POST['Status']==1){
		$data_server['isd_status'] = 'Active';
		}else{
		$data_server['isd_status'] = 'Deactive';	
		}
		if(!empty($_REQUEST['edit'])){
		$objphone->update('country', $data_server, array('country_id'=>$_REQUEST['edit']));	
		$_SESSION['mess_server'] = 'Update successfully';
		header("Location: countryCodeList.php?curP={$_REQUEST['curP']}&ch={$_REQUEST['ch']}");
	    exit;
		}else{
		//$objphone->insert('country', $data_server);
		//$_SESSION['mess_server'] = 'Added successfully';
		header("Location: countryCodeList.php");
	    exit;
		}
		
		
	}

	require_once("includes/footer.php"); 

?>


