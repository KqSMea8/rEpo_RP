<?php 
	/**************************************************/
	$ThisPageName = 'viewForms.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(cms)) {
	  	$webcmsObj=new webcms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $Added_no = isset($_REQUEST['view'])?$_REQUEST['view']:"";	
                 $formId = isset($_REQUEST['formId'])?$_REQUEST['formId']:"";	
                 $CustomerID=  $_REQUEST['CustomerID'];
                  if ($Added_no && !empty($Added_no)) {$ModuleTitle = "View Form Data";}
                        $ModuleName = 'Form Data';
                        $ListTitle  = 'Form Data';
                        $ListUrl    = "viewFormData.php?CustomerID=".$CustomerID;
                       
               
                    if (!empty($Added_no)) 
                    {
                        
                        $arryFormField = $webcmsObj->getFormFieldData($formId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
	
					 
                  
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $webcmsObj->deleteFormData($_GET['del_id'],$formId);
                                header("location:".$ListUrl);
                                exit;
	}
		

	$SubHeading = 'Form Data';
 	if (is_object($webcmsObj)) {	
		/* 
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
			
		}*/
		

	
	
		
		
                
                              
}



 require_once("includes/footer.php"); 
 
 
 ?>