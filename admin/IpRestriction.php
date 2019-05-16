<?php	
	/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/

	include("includes/header.php");

	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();


	$RedirectUrl = "IpRestriction.php";
	
	if($_POST){		
		CleanPost();		 
		$objCompany->UpdateIpRestriction($_POST,$_SESSION['CmpID']);		
		$_SESSION['mess_ip'] = IP_SUBMIT_MSG;
		header("location:".$RedirectUrl);
		exit;
	}
	
	 
	include("includes/footer.php");
?>
