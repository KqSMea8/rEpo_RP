<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/territory.class.php");
	
         $ModuleName = 'Territory';
	 $objTerritory=new territory();
         
         $arryTerritoryRule=$objTerritory->ListTerritoryRule($id=0,$_GET['key'],$_GET['sortby'],$_GET['asc']);
         
        $num=$objTerritory->numRows();

	 $pagerLink=$objPager->getPager($arryTerritoryRule,$RecordsPerPage,$_GET['curP']);
	 (count($arryTerritoryRule)>0)?($arryTerritoryRule=$objPager->getPageRecords()):("");
        
         
	  

  
  require_once("../includes/footer.php");
  
?>
