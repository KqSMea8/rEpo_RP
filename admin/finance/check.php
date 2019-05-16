<?php 
	$HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	$objReport = new report();
	$objSupplier=new supplier();
	$objTransaction=new transaction();
 	$TransactionID   = $_GET['TransactionID'];
 	
 
	if(!empty($TransactionID)){
		/*****************/
		$_GET['PaymentType'] = 'Purchase';
		$arryTransaction = $objReport->getPaymentTransaction($_GET);
		$CheckFormat = (!empty($_GET['frm']))?($_GET['frm']):($arryTransaction[0]['CheckFormat']);
		$CheckNumber = (!empty($_GET['Chk']))?($_GET['Chk']):($arryTransaction[0]['CheckNumber']);
		$PaymentDate = (!empty($_GET['Date']))?($_GET['Date']):($arryTransaction[0]['PaymentDate']);		
		/*****************/
		$arryTemplate = $objReport->GetCheckTemplate();	
		$arryTransactionData = $objTransaction->ListSessionTransaction('AP',$TransactionID ,''); 		
		//echo '<pre>';print_r($arryTransaction);exit;
		$Count=0;
		foreach($arryTransactionData as $key=>$values){
			$SuppCode = $values['SuppCode'];
			if(!empty($SuppCode)){
				$arrySupplier = $objSupplier->GetSupplier('',$SuppCode,'');
  
				$Address='';	
				$Currency = stripslashes($arrySupplier[0]["Currency"]);
				$country_id = $arrySupplier[0]['country_id'];
				$CountryName = stripslashes($arrySupplier[0]["Country"]);
				$StateName = stripslashes($arrySupplier[0]['State']);
				$CityName = stripslashes($arrySupplier[0]['City']);

				if(!empty($arrySupplier[0]['Address'])) $Address =  stripslashes($arrySupplier[0]['Address']).'<br>';		   
				if(!empty($CityName)) $Address .= htmlentities($CityName, ENT_IGNORE).', ';		   
				if(!empty($StateName) && !empty($country_id)){
					$StateCode = $objRegion->GetStateCodeByName($country_id,$StateName);
					if(!empty($StateCode)) $Address .= $StateCode.',<br>';
					else $Address .= $StateName.',<br>';			   
				}
				if(!empty($CountryName)) $Address .= $CountryName;		   
				if(!empty($arrySupplier[0]['ZipCode'])) $Address .= ' - '. $arrySupplier[0]['ZipCode'];	

				$values['VendorAddress'] = (!empty($Address))?($Address):('');			
				

				foreach($values as $k=>$val){  
					$arryVendorData[$SuppCode][$Count][$k] = $val;			
				}
				$Count++;
			}
		}
		
		if(!empty($_GET['pk']))pr($arryVendorData,1);		
		 
		
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}        

	$Config['DateFormat'] = 'm/d/Y';
	$ToolbalShown='';
 	require_once("../includes/footer.php"); 	
?>



