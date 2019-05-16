<?php
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/employee.class.php");        
	require_once($Prefix."classes/event.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objphone=new phone();  
	$objLead=new lead();
	$objQuote=new quote();
	$objActivity=new activity();
  	$objEmployee=new employee();
	$ModuleName = "Dashboard";
	
	if(empty($_SESSION['WorkspaceCRM']) && $arryCompany[0]['Department']!=5){ //not standalone crm
		$arryDefaultScreen = $objConfig->getDefaultScreen();		
		if($arryDefaultScreen[0]['Status']=='1'){		
			header('location:workspace.php?locationID='.$_GET['locationID']);
			exit;
		}
	}


	/********************/
	if($_SESSION['AdminType'] == "employee" ) { 
		$NumDeptModules = sizeof($arrayDeptModules) - 1;   // -1 for Default Menu Workspace
		//echo sizeof($arryMainMenu) .'=='. $NumDeptModules;
 		if(sizeof($arryMainMenu) >= $NumDeptModules){
			$Config['FullPermission'] = 1;
		}
	}
	//if($_GET[d]) echo $Config['FullPermission'];
	/********************/
	require_once("../includes/footer.php"); 
?>
