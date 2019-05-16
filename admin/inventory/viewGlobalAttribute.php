<?php 
 	 include_once("../includes/header.php");
	 require_once($Prefix."classes/item.class.php");
          
	 $objItem =new items();
	 
	 if (is_object($objItem)) 
             {
             
	 	$arryGlobalAttributes = $objItem->getGlobalAttributes();
		$num = $objItem->numRows();
	    }
  
  require_once("../includes/footer.php");
  
?>
