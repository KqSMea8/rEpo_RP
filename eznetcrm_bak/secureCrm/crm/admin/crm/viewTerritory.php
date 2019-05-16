<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/territory.class.php");
	

	 	
            $cat_title = 'Territory';
            $DelMessage = ALL_PRODUCT_AND_SUBCAT_DELETE;
	
	
	  $objTerritory=new territory();
	  $LevelTerritory = 1;
	  
	 if (is_object($objTerritory)) {
             
                //$arryCategoriesAndSubcategories=$objTerritory->ListAllCategoriesAndSubcategories();
	 	$arryTerritory=$objTerritory->ListTerritories($ParentID,$_GET['key'],$_GET['sortby'],$_GET['asc']);
               
		$num=$objTerritory->numRows();
                
		if($ParentID > 0){
			$LevelTerritory = 2;

			$arrayParentTerritory = $objTerritory->GetTerritoryNameByID($ParentID);
			
			$ParentTerritory  = ' &raquo; '.stripslashes($arrayParentTerritory[0]['Name']);
	
			if($arrayParentTerritory[0]['ParentID']>0){
				$LevelTerritory = 3;

				$BackParentID = $arrayParentTerritory[0]['ParentID'];
				$arrayMainParentTerritory = $objTerritory->GetTerritoryNameByID($arrayParentTerritory[0]['ParentID']);
				$MainParentTerritory  = ' &raquo; '.stripslashes($arrayMainParentTerritory[0]['Name']);
				
				
				if($arrayMainParentTerritory[0]['ParentID']>0){
					$LevelTerritory = 4;
									
					$arrayMainRootParentTerritory = $objTerritory->GetTerritoryNameByID($arrayMainParentTerritory[0]['ParentID']);
					$MainParentTerritory  = ' &raquo; '.stripslashes($arrayMainRootParentTerritory[0]['Name']).$MainParentTerritory;


					if($arrayMainRootParentTerritory[0]['ParentID']>0){
						$LevelTerritory = 5;
										
						$arrayLastParentTerritory = $objTerritory->GetTerritoryNameByID($arrayMainRootParentTerritory[0]['ParentID']);
						$MainParentTerritory  = ' &raquo; '.stripslashes($arrayLastParentTerritory[0]['Name']).$MainParentTerritory;
					}



				}
				
				
			}			
			
		}

  }
  
  require_once("../includes/footer.php");
  
?>
