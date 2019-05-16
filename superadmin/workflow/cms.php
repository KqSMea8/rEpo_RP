<?php
include_once("includes/header.php");
	require_once("classes/cms.class.php");
	
	 $ModuleName = "Cms";
	 $objelement=new cms();	 
	 $arryPages=$objelement->getPages();
	  $num=$objelement->num_rows; 
	  $pagerLink=$objPager->getPager($arryElement,$RecordsPerPage);
	require_once("includes/footer.php"); 
?>


	
	