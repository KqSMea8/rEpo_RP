<?php
	/**************************************************/
	$ThisPageName = 'viewGlobalAttribute.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/category.class.php");
        require_once($Prefix."classes/product.class.php");
	
	$objCategory=new category();        
	$objProduct = new product();
         
	
                $ModuleName = 'Attribute';
                $ListTitle  = 'Attributes';
                $ListUrl    = "viewGlobalAttribute.php?curP=".$_GET['curP'];
       
            	if(!empty($_GET['edit']))  {
                    $AttributeId = $_GET['edit'];
                    $arryAttributes = $objProduct->getGlobalAttributeById($AttributeId);

			$global_id = $arryAttributes[0]['Gaid'];
			if(!empty($global_id))  {
				$arrayOptionList= $objProduct->GetOptionList($global_id);
				$NumLine = sizeof($arrayOptionList);
			}

                }

			
		 	 

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_attr'] = $ModuleName.STATUS;
		$objProduct->changeGlobalAttributeStatus($_REQUEST['active_id']);

		header("location:".$ListUrl);
		exit;
	}
	

	

	 if(!empty($_GET['del_id'])){
	 

                $_SESSION['mess_attr'] = $ModuleName.REMOVED;
                $objProduct->deleteGlobalAttribute($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}
		
 	
		 
		 if ($_POST) {

                            if (!empty($_POST['Gaid'])) {
                                    $_SESSION['mess_attr'] = $ModuleName.UPDATED;
                                    $objProduct->updateGlobalAttribute($_POST);
                                    $objProduct->AddUpdateGlobalAttOption($_POST['Gaid'],$_POST);
                            } else {	
                                
                                    $_SESSION['mess_attr'] = $ModuleName.ADDED;
                                  $gaid_id = $objProduct->addGlobalAttribute($_POST);	

			if($gaid_id>0){
			   $objProduct->AddGlobalAttOption($gaid_id,$_POST);	
			}				
                            }

                               
                header("location:".$ListUrl);
                exit;

		}
		

	
	
		
		if(!empty($arryAttributes[0]['Status'])){
			$AttributeStatus = $arryAttributes[0]['Status'];
		}else{
			$AttributeStatus = 1;
		}


(empty($NumLine))?($NumLine=4):("");



 require_once("../includes/footer.php"); 
 
 
 ?>
