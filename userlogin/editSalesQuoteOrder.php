<?php
/**************************************************/
$ThisPageName = 'viewSalesQuoteOrder.php'; $EditPage = 1;$SetFullPage = 1;
/**************************************************/
include_once("includes/header.php");
require_once($Prefix."classes/item.class.php");
$objItem=new items();

 
(empty($MaxOrderQty))?($MaxOrderQty='1000'):(""); 

$_GET['CustID'] = $_SESSION['UserData']['CustID'];
$_GET['ExclusiveItem'] = $ExclusiveItem;
$_GET['Status'] = 1;

/*******Get Vendor Records**************/	
$Config['RecordsPerPage'] = $RecordsPerPage;
$arryProduct=$objItem->GetItemsCust($_GET);
/***********Count Records****************/	
$Config['GetNumRecords'] = 1;
$arryCount=$objItem->GetItemsCust($_GET);
$num=$arryCount[0]['NumCount'];	
$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
/****************************************/
require_once("includes/footer.php");
?>


