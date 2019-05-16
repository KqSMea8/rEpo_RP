<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/territory.class.php");
        require_once($Prefix . "classes/lead.class.php");
	
         $ModuleName = 'Territory';
	 $objTerritory=new territory();
         $objLead = new lead();
        
         
         if($_GET['country'] > 0 && $_GET['TerritoryList']){
             
             $arryLocation = $objTerritory->getCityIDByTerritory($_GET['TerritoryList'],$_GET['country']);
             
                 if(!empty($arryLocation[0]['city'])){
             
                        $arryLead = $objTerritory->getLeadByTerritory($arryLocation[0]['city'],'','');
                 }else if(!empty($arryLocation[0]['state'])){ 
                     
                     $arryLead = $objTerritory->getLeadByTerritory('',$arryLocation[0]['state'],'');
                 }else{
                     $arryLead = $objTerritory->getLeadByTerritory('','',$arryLocation[0]['country']);
                 }
                 
                 
                 $pl = 0;
                 foreach($arryLead as $values){
                     
                     if($values['CountryName'] != '' && $values['CityName'] != '' && $values['StateName'] != '' && $pl == 0){
                            
                            $PrimaryLocation[] = $values; 
                            
                             $pl++;
                     }
                 }
                 
                
                 
                
                 
                
             
             $num=$objTerritory->numRows();   
         }
         
        
         
         
        $googleMarkup = $Config['Url'].'admin/images/markerGreen.png';
         
         
        
         
	  

  
  require_once("../includes/footer.php");
  
?>
