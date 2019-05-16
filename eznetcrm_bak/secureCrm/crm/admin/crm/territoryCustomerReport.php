<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/territory.class.php");
	
         $ModuleName = 'Territory';
	 $objTerritory=new territory();
         
        
         
         if($_GET['country'] > 0 && $_GET['TerritoryList']){
             
             $arryLocation = $objTerritory->getCityIDByTerritory($_GET['TerritoryList'],$_GET['country']);
             
                 if(!empty($arryLocation[0]['city'])){
             
                        $arryCustomer = $objTerritory->getCustomerByTerritory($arryLocation[0]['city'],'','');
                 }else if(!empty($arryLocation[0]['state'])){ 
                     
                     $arryCustomer = $objTerritory->getCustomerByTerritory('',$arryLocation[0]['state'],'');
                 }else{
                     $arryCustomer = $objTerritory->getCustomerByTerritory('','',$arryLocation[0]['country']);
                 }
             
             $num=$objTerritory->numRows();   
         }
         
         
        $googleMarkup = $Config['Url'].'admin/images/markerGreen.png';
         
         
        
         
	  

  
  require_once("../includes/footer.php");
  
?>
