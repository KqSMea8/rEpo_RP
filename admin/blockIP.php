<?php	
	include("includes/header.php");

	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();


	$RedirectUrl = "BlockIP.php";
	
	if($_POST){	
		CleanPost();	
		$objCompany->UpdateIpDetail($_POST,$_SESSION['CmpID']);		
		$_SESSION['mess_ip'] = IP_SUBMIT_MSG;
		header("location:".$RedirectUrl);
		exit;
	}
	
	//$results = $objIP->GetData();
	
	include("includes/footer.php");
?>
