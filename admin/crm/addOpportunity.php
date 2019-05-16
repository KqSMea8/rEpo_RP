<?php $FancyBox=1;
 /**************************************************/
    $ThisPageName = 'viewOpportunity.php?module=Opportunity'; $EditPage = 1; $HideNavigation = 1;
    /**************************************************/
   
	  require_once("../includes/header.php");
        require_once($Prefix."classes/lead.class.php");
        require_once($Prefix."classes/region.class.php");
		require_once($Prefix."classes/employee.class.php");
		require_once($Prefix."classes/crm.class.php");
		
	
	
	$ModuleName = "Opportunity";
	$RedirectURL = "viewOpportunity.php?curP=".$_GET['curP']."&module=Opportunity";
	


	$objLead=new lead();
	$objRegion=new region();
	$objEmployee=new employee();
		$objCommon=new common();
	
	
	
	
	 if ($_POST) {
			 CleanPost(); 
					
						$ImageId = $objLead->AddOpportunity($_POST); 
						$_SESSION['mess_opp'] = OPP_ADDED;

						if(!empty($ImageId)){
						$objLead->UpdateCreater($_POST,"c_opportunity","OpportunityID",$ImageId);
					
						}
				

				echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;
				
					//header("Location:".$RedirectURL);
					exit;
				


				
			
		}
		

	
		$OpportunityStatus = 1;
	$arryDepartment = $objConfigure->GetDepartment();
	$arryEmployee = $objEmployee->GetEmployeeBrief('');
	$arryOppType = $objCommon->GetCrmAttribute('Type','');
	$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	$arryIndustry = $objCommon->GetCrmAttribute('Industry','');
	$arrySalesStage = $objCommon->GetCrmAttribute('SalesStage','');
	//print_r($arrySalesStage);




/*******************************************/

	//$arryCountry = $objRegion->getCountry('','');

	require_once("../includes/footer.php"); 
?>


