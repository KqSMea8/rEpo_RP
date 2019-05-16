<?php 
include ('../includes/function.php');

/**************************************************************/
$ThisPageName = 'Login '; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;

	include ('includes/header.php');

	require_once("../../classes/company.class.php");
	require_once("../../classes/admin.class.php");
	require_once("../../classes/rsl.class.php");
	
	//require_once("../../classes/user.class.php");
	//require_once("../../classes/configure.class.php");
	
	//require_once("../../includes/browser_detection.php");
	
	//$objConfig=new admin();
	//$objCompany=new company();
	$objReseller = new rs();
	
	if($_POST) { 
		
		CleanPost();
		
		$_POST['CmpID'] = $CmpID = $objReseller->getDefaultCompany(); 
		
		if(empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			$LoginEmail = mysql_real_escape_string($_POST['LoginEmail']); 
			$LoginPassword = mysql_real_escape_string($_POST['LoginPassword']);
			
			if(empty($mess) && $CmpID>0){ 
				
				$ArryCompany = $objReseller->ValidateSeller($LoginEmail, $LoginPassword, $CmpID);	
				if($ArryCompany[0]['RsID']>0){ 
					session_regenerate_id(); 
					$_SESSION['CrmRsID'] = $ArryCompany[0]['RsID'];
					$_SESSION['CrmCmpID'] = $CmpID;  
					$_SESSION['CrmDisplayName'] = $ArryCompany[0]['FullName'];
					$_SESSION['CrmAdminEmail'] = $ArryCompany[0]['Email'];					
					$_SESSION['CrmAdminPassword'] = $ArryCompany[0]['Password'];								
					$ValidLogin = 1;
				}

			}
			
			
			
			/********************/  

			if($ValidLogin==1 && $_SESSION['CrmRsID']>0){ 
				if(!empty($_POST['ContinueUrl'])){
					$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
					echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
					exit;
				}else{
					echo '<script>location.href="dashboard.php";</script>';
					exit;
				}
			}else{
				if(empty($mess))
					$mess = INVALID_EMAIL_PASSWORD;
			}
			/********************/
			
			
		}
		
	}else{
		session_destroy();	
		ob_end_flush();		
	}

include ('includes/footer.php');
?>