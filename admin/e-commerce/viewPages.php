<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/cms.class.php");
        
	  $cmsObj=new cms();
	  
	 if (is_object($cmsObj)) {
	 	$arryPages=$cmsObj->getPages();
		$num=$cmsObj->numRows();
	

                          }
  
  require_once("../includes/footer.php");
  
?>
