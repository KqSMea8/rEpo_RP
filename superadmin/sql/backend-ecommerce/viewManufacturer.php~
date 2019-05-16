<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/manufacturer.class.php");
        
                   

	  $objManufacturer=new Manufacturer();
	  $LevelManufacturer = 1;
	  
	 if (is_object($objManufacturer)) {
	 	$arryManufacturer=$objManufacturer->getManufacturer($id,$status,$_GET['key'],$_GET['sortby'],$_GET['asc']);
             
		$num=$objManufacturer->numRows();
	

  }
  
  require_once("../includes/footer.php");
  
?>
