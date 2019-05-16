<?php   $Config['DefaultMenu']=195;
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/quote.class.php");
	require_once($Prefix."classes/employee.class.php");        
	require_once($Prefix."classes/event.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	require_once($Prefix."classes/crm.class.php");
	$objCommon=new common();  
	$objphone=new phone();  
	$objLead=new lead();
	$objQuote=new quote();
	$objActivity=new activity();
  	$objEmployee=new employee();

	$_SESSION['WorkspaceCRM']=1;
	$OptionArray = array("Top","Daily","Weekly","Monthly","Yearly");

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
