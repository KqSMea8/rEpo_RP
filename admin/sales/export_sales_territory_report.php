<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/sales.quote.order.class.php");
require_once($Prefix."classes/territory.class.php");
	
$objTerritory=new territory();

$objSale = new sale();
$module = 'Order';
$ModuleName = "Sale".$_GET['module'];
$ModuleIDTitle = "SO Number"; $ModuleID= "SaleID";

/*************************/

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


$arrySale=$objTerritory->SalesReportTerritory($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$CustCode,$_GET['s'],$_GET['st']);
$num=$objTerritory->numRows();

/*$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");*/
/*************************/
$territoryReport = "Territory_Report";
$filename = $territoryReport."_".date('d-m-Y').".xls";
if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	 
        $header = "".$module." Date\t".$ModuleIDTitle."\tCustomer\tSales Person\tAmount\tCurrency\tStatus\tApproved";

	$data = '';
	foreach($arrySale as $key=>$values){
	$ddate = $module.'Date';
		 $OrderDate = ($values[$ddate]>0)?(date($Config['DateFormat'], strtotime($values[$ddate]))):("");
		 $Approved = ($values['Approved']==1)?("Yes"):("No");

		
                
                $line = $OrderDate."\t".$values[$ModuleID]."\t".stripslashes($values["CustomerName"])."\t".stripslashes($values["SalesPerson"])."\t".$values['TotalAmount']."\t".$values['CustomerCurrency']."\t".stripslashes($values["Status"])."\t".$Approved."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

