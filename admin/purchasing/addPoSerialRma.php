<?php

/* * *********************************************** 
$ThisPageName = 'editRma.php';
/* * *********************************************** */
$HideNavigation = 1;


include_once("../includes/header.php");
require_once($Prefix."classes/rma.purchase.class.php");
require_once($Prefix."classes/purchasing.class.php");
	
$objPurchase=new purchase();

(empty($_GET['total']))?($_GET['total']=""):(""); 
(empty($_GET['SerialValue']))?($_GET['SerialValue']=""):(""); 
 

if(!empty($_GET['sku'])){
	$sku=$_GET['sku'];
	$orderid=$_GET['OrderID'];
	$condition=$_GET['condition'];
	//$arrySerialNumber = $_GET['SerialValue'];
	$Config['Cond']=$condition;



$checkProduct=$objConfig->IsItemSku($_GET['sku']);

		
		if(empty($checkProduct))
		{
		$arryAlias = $objConfig->IsItemAliasSku($_GET['sku']);
			if(count($arryAlias))
			{
					$mainSku = $arryAlias[0]['sku'];		
			}
		}else{

$mainSku = $_GET['sku'];
}

    $arrySerialNumber = $objPurchase->selectSerialNumberForItembyID($_GET['OrderID'],$_GET['item_id'],$mainSku);

			if(sizeof($arrySerialNumber)>1){
					foreach($arrySerialNumber as $Servalues){
					    $arrySerialNumber[0]['SerialNumbers'] .= $Servalues['SerialNumbers'].',';
					}
			$arrySerialNumber[0]['SerialNumbers'] = rtrim($arrySerialNumber[0]['SerialNumbers']);
			}
#echo $arrySerialNumber[0]['SerialNumbers']; exit;
if($arrySerialNumber[0]['SerialNumbers']!=''){
    $allserials = explode(",",$arrySerialNumber[0]['SerialNumbers']);
}else{

 $allserials = '';
}
   

    /********** RAM serals*********/

$craditsOrdeIDS=$objPurchase->getOrderIDByMode($orderid,'Credit');
$orderidArray = array();
if(!empty($craditsOrdeIDS)){
	foreach ($craditsOrdeIDS as $valCredit){
		$orderidArray[]=$valCredit['OrderID'];
	}
}

$craditserials=$objPurchase->GetOrderItembyOrderIDAndSKU($orderidArray,$mainSku,$condition);
 
$creditserial=array();
if(!empty($craditserials)){
	foreach($craditserials as $craditserialsvalue){
if($craditserialsvalue['SerialNumbers']!=''){
	$creditserial[]=trim($craditserialsvalue['SerialNumbers']);
}
	}
if(!empty($creditserial)){
	$creditserial= implode(',',$creditserial);
	$creditserial=explode(',',$creditserial);
}else{
$creditserial = '';
}
}



/*********************************/
if(!empty($allserials) ||  !empty($creditserial)){
  $allserials=array_diff($allserials,$creditserial); 
}else{

$allserials = '';
}

    
   
    
   
    
$serialValue=$objPurchase->getSerialDetails($mainSku,$condition,$allserials,$_GET['WID']);


//if($_GET['sr']==1){
//echo "<pre>";
//print_r($serialValue);
//}


}





require_once("../includes/footer.php");
?>
