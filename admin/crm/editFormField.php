<?php 
	/**************************************************/
	$ThisPageName = 'viewMenus.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/webcms.class.php");
	
 	$webcmsObj=new webcms();

                 $FieldId= isset($_GET['edit'])?$_GET['edit']:"";	
                 $CustomerID=  $_GET['CustomerID'];
                  if ($FieldId && !empty($FieldId)) {$ModuleTitle = "Edit Form Field";}else{$ModuleTitle = "Add Form Field";}
                        $ModuleName = 'Form Field ';
                        $ListTitle  = 'Form Field';
                        $ListUrl    = "viewFormFields.php?curP=".$_GET['curP']."&CustomerID=".$CustomerID;
                       
               
                    if (!empty($FieldId)) 
                    {
                        $arryFormField= $webcmsObj->getFormFieldById($FieldId);
                   }else{
				$arryFormField = $objConfigure->GetDefaultArrayValue('web_forms_fields');
			}
					
					
					/****************Create Tree Array for Menu****************/
					//$MainParentArr = $webcmsObj->getParentMenus();
					
					$arryForms= $webcmsObj->getForms($CustomerID);
					
					$FieldArray= array('Textbox','Dropdown','Checkbox','Textarea','Radio','Email','File');
					 
                  if(!empty($_GET['active_id'])){
					$_SESSION['mess_Page'] = $ModuleName.STATUS;
					$webcmsObj->changeFormFieldStatus($_GET['active_id']);
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
		

	
	
		
		if(!empty($arryFormField) && $arryFormField[0]['Status'] == "No"){
			$FieldStatus = "No";
		}else{
			$FieldStatus = "Yes";
		}
                
                              
}



 require_once("../includes/footer.php"); 
 
 
 ?>
