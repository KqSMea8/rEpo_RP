<? 
	require_once("includes/settings.php");
	require_once('includes/function.php');
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/license.class.php");

	$objConfig=new admin();	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}


	CleanGet();
	
	/* Checking for Company existance */
	if($_GET['Multiple'] == "1" && $_GET['DisplayName'] != ""){
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "2";
		}else{
			if($_GET['Email'] != ""){
				if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}

	/* Checking for Company existance */
	if($_GET['DisplayName'] != ""){

		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Company Email existance */
	if($_GET['Type'] == "Company" && $_GET['Email'] != ""){
		$objCompany = new company();
		if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

		/* Checking for DomainName existance */
	if($_GET['DomainName'] != ""){
		$objLicense=new license();
		if($objLicense->isDomainExists($_GET['DomainName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	


?>
