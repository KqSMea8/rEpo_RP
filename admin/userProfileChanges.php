<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();

			
			if($_GET['view']>0) {
	
				$arryEmployeeChange = $objEmployee->getEmployeeChanges($_GET['view'],'');
			
			}else{
				$ErrorExist=1;
				$ErrorMsg = INVALID_REQUEST;
				
			}			
			/*******************************************/	

	require_once("includes/footer.php");  
?>
