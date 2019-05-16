<?php


    /**************************************************/
	//$ThisPageName = 'viewAdjustment.php'; 
	/**************************************************/
	//$HideNavigation = 1;
	
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	
	

	$objItem= new items();
	
       
                     
	
 	if (is_object($objItem)) {
            
                if ($_POST) {
                    CleanPost();
                     
                   if (!empty($_POST['prefixID'])) {
					//$_SESSION['mess_product'] = $MSG[23];
					$objItem->updatePrefix($_POST);
					$ImageId = $_POST['prefixID'];
					$_SESSION['mess_prefix'] = 'Prefixs'.UPDATED;
					//if($_POST['Status']==1 && $_POST['OldStatus']!=1 && $_POST['PostedByID']>1 ){
						//$objItem->ItemActiveEmail($_POST['ItemID']);
					//}
					
					
					
				} else {	
					
					 // if($objLead->isEmailExists($_POST['Email'],'')){
					//$_SESSION['mess_lead'] = "Serial Number Already Exit in our Database ";
					//}else{

					//$_SESSION['mess_'] = 'Prefix'.UPDATE;
					$ImageId = $objItem->AddSerialNumber($_POST);
				}

			

				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
                                  
                                $EditRedirectURL = "editPrefixes.php";
					header("Location:".$EditRedirectURL);
					exit;
				}
				
				
			
		}
		

		$arryPrifix=$objItem->getPrefix(1);
                
                
                //print_r($arryPrefix);
				
		
}

	
	
	
	require_once("../includes/footer.php"); 
	
?>
