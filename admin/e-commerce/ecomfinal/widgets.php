<?php 
 	include_once("includes/header.php");
	require_once("classes/theme.class.php");
        
	 $themeObj=new theme();
	
	 if (is_object($themeObj)) {
	 	$arryWidgets=$themeObj->GetWidgets();
		$num=$themeObj->numRows();
		//$pagerLink=$objPager->getPager($arryWidgets,$RecordsPerPage,$_GET['curP']);
		//(count($arryWidgets)>0)?($arryWidgets=$objPager->getPageRecords()):(""); 

       }
  
  require_once("includes/footer.php");
  
?>
