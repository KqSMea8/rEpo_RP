<?php 
	if($_GET['pop']==1)	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; 
	/**************************************************/
	
	    include_once("includes/header.php");
	    require_once("../classes/territory.class.php");
	    require_once("../classes/company.class.php");
	    require_once("../classes/employee.class.php");
		require_once("../classes/region.class.php");
	    
	$objRegion=new region();
	$objEmployee=new employee();
	$objTerritory=new territory();
	$objCompany=new company();
	
	require_once("userInfoConnection.php");
	
	
	$ModuleName = "Employee";
	$RedirectURL = "viewEmployee.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	$EditUrl = "editEmployee.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vEmployee.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&cmp=".$_GET["cmp"]."&tab="; 


	if (!empty($_GET['view'])) {
		$arryEmployee = $objEmployee->GetEmployee($_GET['view'],'');
		$EmpID   = $_REQUEST['view'];	
		
		if($arryEmployee[0]['Supervisor']>0){
			$arrySupervisor = $objEmployee->GetEmployeeBrief($arryEmployee[0]['Supervisor']);
		}

		if(substr_count("5,6,7", $arryEmployee[0]['Division'])==0){
			$Config['SalesCommission']=0;
		}
		
		if($arryEmployee[0]['EmpID']<=0){
			header("Location:".$RedirectURL);
			exit;
		}



		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}



	if($_GET['tab']=='emergency'){
		$SubHeading = 'Emergency Contacts';
	}else if($_GET['tab']=='role'){
		$SubHeading = 'Role/Permission';
	}else if($_GET['tab']=='exit'){
		$SubHeading = 'Employee Exit';
	}else if($_GET['tab']=='employment'){
		$SubHeading = 'Employment History';
	}else if($_GET['tab']=='id'){
		$SubHeading = 'ID Proof';
	}else if($_GET['tab']=='sales'){
		$SubHeading = 'Sales Commission';
	}else if($_GET['tab']=='territory'){
		$SubHeading = 'Territory';
	}else if($_GET['tab']=='account'){
		$SubHeading = 'Account / Login Details';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Details";
	}
	
	$Config['DateFormat']='j M, Y';

	require_once("includes/footer.php"); 	 
?>


