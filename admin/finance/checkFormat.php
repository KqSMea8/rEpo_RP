<?php 
	$HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	$objReport = new report();
	$objSupplier=new supplier();
	$objTransaction=new transaction();
	$SuppCode   = $_GET['SuppCode'];
	$TransactionID   = $_GET['TransactionID'];
 
	if(!empty($TransactionID)){
		/*****************/
		$_GET['PaymentType'] = 'Purchase';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
		//$_GET['Chk'] = $arryTransaction[0]['CheckNumber'];
		//$_GET['Date'] = $arryTransaction[0]['PaymentDate'];		
		/*****************/
		$arryTemplate = $objReport->GetCheckTemplate();	
		$arryTransactionData = $objTransaction->ListSessionTransaction('AP',$TransactionID ,''); 
		$SuppCode = $arryTransactionData[0]['SuppCode'];
		//$_GET['Amt'] = $arryTransactionData[0]['Amount'];
		/*****************/
		if(!empty($SuppCode)){
			$arrySupplier = $objSupplier->GetSupplier('',$SuppCode,'');			
			if(empty($arrySupplier[0]['SuppID'])){
				$ErrorMsg = NOT_EXIST_SUPP;
			}else{
				$Currency = stripslashes($arrySupplier[0]["Currency"]);
				$country_id = $arrySupplier[0]['country_id'];
				$CountryName = stripslashes($arrySupplier[0]["Country"]);
				$StateName = stripslashes($arrySupplier[0]['State']);
				$CityName = stripslashes($arrySupplier[0]['City']);
				$Address = '';
				if(!empty($arrySupplier[0]['Address'])) $Address .=  stripslashes($arrySupplier[0]['Address']).'<br>';		   
				if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';		   
				if(!empty($StateName) && !empty($country_id)){
					$StateCode = $objRegion->GetStateCodeByName($country_id,$StateName);
					if(!empty($StateCode)) $Address .= $StateCode.',<br>';
					else $Address .= $StateName.',<br>';			   
				}	   
				if(!empty($CountryName)) $Address .= $CountryName;		   
				if(!empty($arrySupplier[0]['ZipCode'])) $Address .= ' - '. $arrySupplier[0]['ZipCode'];	

				$VendorAddress = (!empty($Address))?($Address):('');

			}
		}
		/*****************/
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}        

	$CheckFormat = $_GET['frm'];
 	$Config['DateFormat'] = 'm/d/Y';
	$ToolbalShown='';
	require_once("../includes/footer.php"); 	
?>



