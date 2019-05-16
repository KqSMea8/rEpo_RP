<?php
	/**************************************************/
	$ThisPageName = 'viewTax.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/region.class.php");
	$objTax=new tax();

       $objRegion=new region();

	$ModuleName = 'Tax';

	$RedirectURL    = "viewTax.php?curP=".$_GET['curP'];
            


        
     		
    // Status Update tax into database	 
	 	 
	if(!empty($_GET['active_id'])){
		
		$objTax->changeTaxStatus($_GET['active_id']);
                $_SESSION['mess_tax'] = TAX_STATUS;
		header("location:".$RedirectURL);
	}

     // delete tax into database
	 
	if(!empty($_GET['del_id'])){
		
		$objTax->deleteTax($_GET['del_id']);
                $_SESSION['mess_tax'] = TAX_REMOVED;
		header("location:".$RedirectURL);
		exit;
	}
		


	
	// Add,Update tax into database	 
	 if ($_POST) {
			 CleanPost();
	            if (!empty($_POST['taxId'])) {
	                    $_SESSION['mess_tax'] = TAX_UPDATED;
	                    $objTax->updateTax($_POST);
	                    header("location:".$RedirectURL);
	            } else {		
	                    
	                    $lastShipId = $objTax->addTax($_POST);
                            $_SESSION['mess_tax'] = TAX_ADDED;	
	                   header("location:".$RedirectURL);
	            }

	            exit;
		
	}
		

	
		if(!empty($_GET['edit'])){
		  
		     $arryTax = $objTax->getTaxById($_GET['edit']);

			if($arryTax[0]['Status']=='' || $arryTax[0]['Status'] == 'No'){
			$TaxStatus = "No";
			}else{
				$TaxStatus = "Yes";
			}

		 }else{
			$TaxStatus = "Yes";
		}
	
	
		
		
                
		  
           $arryTaxClasses =$objTax->getClasses();

/*******Connecting to main database********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
if($arryTax[0]['Coid']>0){
$arryCountryName = $objRegion->GetCountryName($arryTax[0]['Coid']);
$CountryName = stripslashes($arryCountryName[0]["name"]);
}

if(!empty($arryTax[0]['Stid'])) {
$arryState = $objRegion->getStateName($arryTax[0]['Stid']);
$StateName = stripslashes($arryState[0]["name"]);
}


 require_once("../includes/footer.php"); 
 
 
 ?>
