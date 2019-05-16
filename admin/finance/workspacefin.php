<?php   $Config['DefaultMenu']=5507;
	require_once("../includes/header.php");

  require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");        

	
    $objSale = new sale();
  	$objEmployee=new employee();
#echo $Config['CurrentDepID']; exit;
	$_SESSION['WorkspaceFin']=1;
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
