<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAssemble.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_category.class.php");
        //require_once($Prefix."classes/purchase.class.php");
		
	$objItem=new items();
	$objCategory=new category();
        //$objPurchase= new purchase();

	
         // $ViewUrl = "viewSerial.php?curP=".$_GET['curP'];
if($_GET['SerialType'] =='adjust'){

$arrySerial=$objItem->GetAdjustmentItem($_GET['adjID']);

if($arrySerial[0]['QtyType']=='Subtract'){
$serial = explode(',',$arrySerial[0]['serial_value']);
$serialPrice = explode('|',$arrySerial[0]['serialPrice']);
$serialDes = explode('|',$arrySerial[0]['serialdesc']);
}else{
//echo "Bhoodev10";
$serial = explode('|',$arrySerial[0]['serial_value']);
$serialPrice = explode('|',$arrySerial[0]['serialPrice']);
$serialDes = explode('|',$arrySerial[0]['serialdesc']);
}


}else{

$arrySerial=$objItem->GetSerialNumber('',$_GET['Sku'],$_GET['adjID'],$_GET['dismly']);
	$num=$objItem->numRows();


}
	
        
   
	$pagerLink=$objPager->getPager($arrySerial,$RecordsPerPage,$_GET['curP']);
	(count($arrySerial)>0)?($arrySerial=$objPager->getPageRecords()):(""); 
	 
          //$listAllCategory =  $objCategory->ListAllCategories();
	
		  
	require_once("../includes/footer.php"); 	
?>


