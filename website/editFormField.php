<?php 
	/**************************************************/
	$ThisPageName = 'viewMenus.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(cms)) {
	  	$webcmsObj=new webcms();
	} else {
  		echo "Class Not Found Error !! CMS Class Not Found !";
		exit;
  	}
                 $FieldId= isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                  if ($FieldId && !empty($FieldId)) {$ModuleTitle = "Edit Form Field";}else{$ModuleTitle = "Add Form Field";}
                        $ModuleName = 'Form Field ';
                        $ListTitle  = 'Form Field';
                        $ListUrl    = "viewFormFields.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($FieldId)) 
                    {
                        $arryFormField= $webcmsObj->getFormFieldById($FieldId);
                    }
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
					
					$arryForms= $webcmsObj->getForms();
					
					$FieldArray= array('Textbox','Dropdown','Checkbox','Textarea','Radio','Email','File');
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeFormFieldStatus($_REQUEST['active_id']);
					header("location:".$ListUrl);
				 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_Page'] = $ModuleName.REMOVED;
                                $webcmsObj->deleteFormField($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		

	$SubHeading = 'Form Field';
 	if (is_object($webcmsObj)) {	
		 
		 if ($_POST) {
		
	 					
						if (!empty($FieldId)) {
							
								$_SESSION['mess_Page'] = $ModuleName.UPDATED;					
								$webcmsObj->updateFormField($_POST);
								
								header("location:".$ListUrl);
								
						} else {		
								$_SESSION['mess_Page'] = $ModuleName.ADDED;
								$lastShipId = $webcmsObj->addFormField($_POST);	
							   header("location:".$ListUrl);
						}

						exit;
			
		}
		

	
	
		
		if($arryFormField[0]['Status'] == "No"){
			$FieldStatus = "No";
		}else{
			$FieldStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
