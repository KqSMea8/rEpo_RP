<?php

include_once("../includes/header.php");
require_once($Prefix . "classes/rma.purchase.class.php");
$objPurchase = new purchase();
include_once("includes/FieldArray.php");

$RedirectURL = "viewRma.php";
$ModuleName = "RMA";
$module = $ModuleName;
$ModuleDepName = 'Purchase' . $ModuleName;
$SendUrl = "sendRMA.php?module=".$ModuleName."&curP=".$_GET['curP'];
(empty($_GET['po']))?($_GET['po']=""):("");
(empty($_GET['FPostedDate']))?($_GET['FPostedDate']=""):("");
(empty($_GET['TPostedDate']))?($_GET['TPostedDate']=""):("");
(empty($_GET['FOrderDate']))?($_GET['FOrderDate']=""):("");
(empty($_GET['TOrderDate']))?($_GET['TOrderDate']=""):("");
$FPostedDate=$TPostedDate=$FOrderDate=$TOrderDate='';
if (!empty($_GET['po'])) {
    $MainModuleName = "RMA for PO Number : " . $_GET['po'];
    $RedirectURL = "viewRma.php?po=" . $_GET['po'];
}

$MailSend='';
/**************Row color functionality added by nisha************************/       
 if($_POST) {
	CleanPost();
    if(sizeof($_POST['OrderID'] > 0)) {
        $Order = implode(",", $_POST['OrderID']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
						if($_POST['RowColor']=='None') $_POST['RowColor']='';
						$_SESSION['mess_return'] = ROW_HIGHLIGHTED;
						$objPurchase->setRowColorPurchase($Order,$_POST['RowColor']);
header("location:".$RedirectUrl);
 
       //exit;
        }
      
       
    }
}       
/**************end row color code*************************/ 
/* * ********************** */
$Config['RecordsPerPage'] = $RecordsPerPage;
$arryReturn = $objPurchase->ListReturnRMA($_GET);
/* * *****Count Records********* */
$Config['GetNumRecords'] = 1;
$arryCount = $objPurchase->ListReturnRMA($_GET);
$num = $arryCount[0]['NumCount'];

$pagerLink = $objPager->getPaging($num, $RecordsPerPage, $_GET['curP']);

/* * ********************** */


//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

require_once("../includes/footer.php");
?>


