<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/territory.class.php");
	
	$objTerritory=new territory();
         
	$objCustomer=new Customer();
	$objSale = new sale();

	 
	$ViewUrl = "salesTerritory.php";
	$RedirectURL = "salesTerritory.php";
        
        if($_GET['TerritoryID']  > 0){
             
             $arryLocation = $objTerritory->getTerritoryLocation($_GET['TerritoryID']);
             
           
             foreach($arryLocation as $values){
                 if(!empty($values['city'])){
                     
                     $CustomerCity .= $values['city'].',';
                     
                 }else if(!empty($values['state'])){ 
                     
                     $CustomerState .= $values['state'].',';
                     
                 }else{
                    
                     $CustomerCountry .= $values['country'].',';
                 }
             }   
                 
              
            
             
             if(!empty($CustomerCity)){
             
                      
                       $CustomerCity = rtrim($CustomerCity,',');
                       
                       $arryCustomerCity = $objTerritory->getCustomerByTerritory($CustomerCity,'','');
                       
                 }
                 if(!empty($CustomerState)){ 
                   
                     $CustomerState = rtrim($CustomerState,',');
                    
                     $arryCustomerState = $objTerritory->getCustomerByTerritory('',$CustomerState,'');
                 }
                 if(!empty($CustomerCountry)){ 
                     
                      $CustomerCountry = rtrim($CustomerCountry,',');
                      $arryCustomerCountry = $objTerritory->getCustomerByTerritory('','',$CustomerCountry);
                     
                      
                 }
                 
                 
                 if(sizeof($arryCustomerCity) > 0){
                     
                     $arryCustomer = $arryCustomerCity;
                 }
                 
                 if(sizeof($arryCustomerState) > 0){
                     
                     $arryCustomer = $arryCustomerState;
                 }
                 
                 if(sizeof($arryCustomerCountry) > 0){
                     
                     $arryCustomer = $arryCustomerCountry;
                 }
                 
                 if(sizeof($arryCustomerCity) > 0 && sizeof($arryCustomerState) > 0){
                     
                     $arryCustomer = array_merge($arryCustomerCity,$arryCustomerState);
                 }
                 if(sizeof($arryCustomerState) > 0 && sizeof($arryCustomerCountry) > 0){
                     
                     $arryCustomer = array_merge($arryCustomerState,$arryCustomerCountry);
                 }
                 
                 if(sizeof($arryCustomerCity) > 0 && sizeof($arryCustomerCountry) > 0){
                     
                     $arryCustomer = array_merge($arryCustomerCity,$arryCustomerCountry);
                 }
                 
                 if(sizeof($arryCustomerCity) > 0 && sizeof($arryCustomerState) > 0 && sizeof($arryCustomerCountry) > 0){
                     
                     $arryCustomerCityState = array_merge($arryCustomerCity,$arryCustomerState);
                     $arryCustomer = array_merge($arryCustomerCityState,$arryCustomerCountry);
                 }
                
                 
              
                 $CustCode = '';
                
                  foreach($arryCustomer as $value){
                     
                      
                     $CustCode .= "'".$value['CustCode']."',";
                 }
                    
                 
                 
               $CustCode = rtrim($CustCode,','); 
               
            //echo "=>".$CustCode;exit;
             
             //$num=$objTerritory->numRows();   
         }

	$arrySale = $objTerritory->SalesReportTerritory($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$CustCode,$_GET['s'],$_GET['st']);
       
	$num=$objTerritory->numRows();
	
	 
	//$totalOrderAmnt = $objSale->getCustomerOrderedAmount($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$_GET['st']);;
	
     
	//$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	//(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


