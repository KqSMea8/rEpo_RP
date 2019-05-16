<?php 
    /**************************************************/
    $ThisPageName = 'ErpUpgradePackages.php'; $EditPage = 1; 
    /**************************************************/
    
    
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/user.class.php");
	require_once("../classes/cmp.class.php");
	
    	$objCmp=new cmp();
	$objCompany=new company();
	$objUser=new user();
	 
	$pack_id = $_GET['pack_id'];
	if(!empty($_GET['pack_id'])){
		$arrayPkj=$objCmp->getPackagesById($_GET['pack_id']);
	}
	
	if(!empty($_GET['cmp'])){		 
		$arrayCurrentOrder = $objCmp->GetCurrentOrder($_GET['cmp']);
	}
	$Deduction = 0; $DaysLeft=0;
	if(!empty($arrayCurrentOrder[0]['OrderID'])){
		// $arrayCurrentOrder[0]['TotalAmount'];
		$TimeSec = strtotime($arrayCurrentOrder[0]['EndDate']) - strtotime($arrayCurrentOrder[0]['StartDate']);
		$Days = round($TimeSec)/ (24*3600);
		$OneDayPrice = $arrayCurrentOrder[0]['TotalAmount']/$Days;

		$TimeLeft = strtotime($arrayCurrentOrder[0]['EndDate']) - strtotime(date('Y-m-d'));
		$DaysLeft = round($TimeLeft)/ (24*3600);
		if($DaysLeft>0 && $OneDayPrice>0){
			$Deduction = round($DaysLeft*$OneDayPrice);
		}

	}
	
	


	if(!empty($_GET['cmp'])){
		$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');
		$CmpID   = $arryCompany[0]['CmpID'];
		$RedirectUrl = 'ErpUiewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'];	
		
		
	}

	
	$viewAll = 'ErpViewPackageLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'];
	require_once("includes/footer.php"); 	 
?>


