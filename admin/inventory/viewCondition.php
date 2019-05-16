<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/inv.condition.class.php");
	include_once("includes/FieldArray.php");

	 	
            $cat_title = 'Condition';
            $DelMessage = ALL_PRODUCT_AND_SUBCAT_DELETE;
	
	
	  $objCondition=new condition();
	  $LevelCondition = 1;


	  
	 if (is_object($objCondition)) {
             
                //$arryCategoriesAndSubcategories=$objCondition->ListAllCategoriesAndSubcategories();
	 	$arryCondition=$objCondition->ListCondition($ParentID,$_GET['key'],$_GET['sortby'],$_GET['asc']);
              
		$num=$objCondition->numRows();
                
		if($ParentID > 0){
			$LevelCondition = 2;

			$arrayParentCondition = $objCondition->GetConditionNameByID($ParentID);
			
			$ParentCondition  = ' &raquo; '.stripslashes($arrayParentCondition[0]['Name']);
	
			if($arrayParentCondition[0]['ParentID']>0){
				$LevelCondition = 3;

				$BackParentID = $arrayParentCondition[0]['ParentID'];
				$arrayMainParentCondition = $objCondition->GetConditionNameByID($arrayParentCondition[0]['ParentID']);
				$MainParentCondition  = ' &raquo; '.stripslashes($arrayMainParentCondition[0]['Name']);
				
				
				if($arrayMainParentCondition[0]['ParentID']>0){
					$LevelCondition = 4;
									
					$arrayMainRootParentCondition = $objCondition->GetConditionNameByID($arrayMainParentCondition[0]['ParentID']);
					$MainParentCondition  = ' &raquo; '.stripslashes($arrayMainRootParentCondition[0]['Name']).$MainParentCondition;


					if($arrayMainRootParentCondition[0]['ParentID']>0){
						$LevelCondition = 5;
										
						$arrayLastParentCategory = $objCondition->GetConditionNameByID($arrayMainRootParentCondition[0]['ParentID']);
						$MainParentCondition  = ' &raquo; '.stripslashes($arrayLastParentCategory[0]['Name']).$MainParentCondition;
					}



				}
				
				
			}			
			
		}

  }
  
  require_once("../includes/footer.php");
  
?>
