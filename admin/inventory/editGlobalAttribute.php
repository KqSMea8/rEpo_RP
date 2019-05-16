<?php
	/**************************************************/
	$ThisPageName = 'viewGlobalAttribute.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/inv_category.class.php");
        require_once($Prefix."classes/item.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
        
          if (class_exists(category)) {
	  	$objCategory=new category();
	} else {
  		echo "Class Not Found Error !! Category Class Not Found !";
		exit;
  	}
        
      $objItem = new items();
         
	
                $ModuleName = 'Attribute';
                $ListTitle  = 'Attributes';
                $ListUrl    = "viewGlobalAttribute.php?curP=".$_GET['curP'];
       
            if ($_REQUEST['edit'] && !empty($_REQUEST['edit'])) 
                {
                    $AttributeId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
                    $arryAttributes = $objItem->getGlobalAttributeById($AttributeId);

		$global_id = $arryAttributes[0]['Gaid'];
		if($global_id>0){
		$arrayOptionList= $objItem->GetOptionList($global_id);
		$NumLine = sizeof($arrayOptionList);
		}


                }

			
		 	 

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_attr'] = $ModuleName.STATUS;
		$objItem->changeGlobalAttributeStatus($_REQUEST['active_id']);

		header("location:".$ListUrl);
	}
	

	

	 if(!empty($_GET['del_id'])){
	 

                $_SESSION['mess_attr'] = $ModuleName.REMOVED;
                $objItem->deleteGlobalAttribute($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}
		

        
        

 	if (is_object($objItem)) {	
		 
		 if ($_POST) {

                            if (!empty($_POST['Gaid'])) {
                                    $_SESSION['mess_attr'] = $ModuleName.UPDATED;
                                    $objItem->updateGlobalAttribute($_POST);
                                    $objItem->AddUpdateGlobalAttOption($_POST['Gaid'],$_POST);
																		$gaid_id=$_POST['Gaid'];
                            } else {	
                                
                                    $_SESSION['mess_attr'] = $ModuleName.ADDED;
                                  $gaid_id = $objItem->addGlobalAttribute($_POST);	

			if($gaid_id>0){
			   $objItem->AddGlobalAttOption($gaid_id,$_POST);	
			}

			
				
                            }
								// for Company to Company Sync by karishma || 4 march 2016
		if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
				$Companys = $objCompany->SelectAutomaticSyncCompany();
				for($count=0;$count<count($Companys);$count++){
					$CmpID=$Companys[$count]['CmpID'];
					$objCompany->syncInventoryCompany($CmpID,$gaid_id,'setting','global attributes');

				}
			}
			
			// end
                               
                header("location:".$ListUrl);
                exit;

		}
		

	
	
		
		if($arryAttributes[0]['Status'] != ''){
			$AttributeStatus = $arryAttributes[0]['Status'];
		}else{
			$AttributeStatus = 1;
		}
}


if($NumLine >0) $NumLine  = $NumLine ;else $NumLine =2;

 require_once("../includes/footer.php"); 
 
 
 ?>
