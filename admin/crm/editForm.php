<?php 
	/**************************************************/
	$ThisPageName = 'viewForms.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	 
	  	$webcmsObj=new webcms();
	 
                 $FormId = isset($_GET['edit'])?$_GET['edit']:"";	
                 $CustomerID=  $_GET['CustomerID'];
                  if ($FormId && !empty($FormId)) {$ModuleTitle = "Edit Form";}else{$ModuleTitle = "Add Form";}
                        $ModuleName = 'Form ';
                        $ListTitle  = 'Forms';
                        $ListUrl    = "viewForms.php?curP=".$_GET['curP']."&CustomerID=".$CustomerID;
                       
               
                    if (!empty($FormId)) 
                    {
                        $arryForm = $webcmsObj->getFormById($FormId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
	
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeFormStatus($_GET['active_id']);
					header("location:".$ListUrl);
				 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $webcmsObj->deleteForm($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		

	$SubHeading = 'Form';
 	if (is_object($webcmsObj)) {	
		 
		 if ($_POST) {
		
	 					$postArray=$_POST;
						
								
						if (!empty($FormId)) {
								
								$_SESSION['mess_Page'] = $ModuleName.UPDATED;					
								$webcmsObj->updateForm($postArray);
								
								header("location:".$ListUrl);
								
						} else {		
								$_SESSION['mess_Page'] = $ModuleName.ADDED;
								$lastShipId = $webcmsObj->addForm($postArray);	
							   header("location:".$ListUrl);
						}

						exit;
			
		}
		

	
	
		
		if(!empty($arryForm) && $arryForm[0]['Status'] == "No"){
			$MenuStatus = "No";
		}else{
			$MenuStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
