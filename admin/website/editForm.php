<?php 
	/**************************************************/
	$ThisPageName = 'viewForms.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
    if (class_exists('cms')) {
	  	$webcmsObj=new webcms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $FormId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($FormId && !empty($FormId)) {$ModuleTitle = "Edit Form";}else{$ModuleTitle = "Add Form";}
                        $ModuleName = 'Form ';
                        $ListTitle  = 'Forms';
                        $ListUrl    = "viewForms.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($FormId)) 
                    {
                        $arryForm = $webcmsObj->getFormById($FormId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
	
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeFormStatus($_REQUEST['active_id']);
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
