<?php

include_once("../includes/header.php");
require_once($Prefix."classes/finance.class.php");
require_once($Prefix . "classes/purchase.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix."classes/finance.transaction.class.php");
require_once($Prefix."classes/finance.account.class.php");

include_once("includes/FieldArray.php");
$objFilter = new filter();
$objCommon = new common();
$objTransaction=new transaction();
$objPurchase = new purchase();
$objBankAccount = new BankAccount();

$ModuleName = "Credit Memo";
$ModuleDepName = "PurchaseCreditMemo";//bysachin
$_GET['module'] = "PoNote";

$AddUrl = "editPoCreditNote.php";
$EditUrl = "editPoCreditNote.php?curP=" . $_GET['curP'];
$ViewUrl = "vPoCreditNote.php?curP=" . $_GET['curP'];
 $SendUrl = "sendCreditMemo.php?curP=".$_GET['curP'];
$RedirectURL = "viewPoCreditNote.php?curP=".$_GET['curP'];
/* * *******************Custom Filter *********** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:" . $ThisPageName);
    exit;
}




/******************************/              

  	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');
	$InventoryAP = $objCommon->getSettingVariable('InventoryAR');
	$FreightExpense = $objCommon->getSettingVariable('FreightExpense');
	$CostOfGoods = $objCommon->getSettingVariable('CostOfGoods');
	$PurchaseReturn = $objCommon->getSettingVariable('ApReturn');
	$SalesTaxAccount = $objCommon->getSettingVariable('SalesTaxAccount');
	$ApRestocking  = $objCommon->getSettingVariable('ApRestocking');

	$ErrorGlAccount='';	 
	if(empty($AccountPayable) || empty($InventoryAP) || empty($FreightExpense)  || empty($CostOfGoods) || empty($ApRestocking)  ){
		// || empty($PurchaseReturn
		$ErrorGlAccount  = SELECT_GL_AP_ALL;
	}
	 
	
	if($AccountPayable>0 && ($AccountPayable == $InventoryAP)){
		$ErrorGlAccount  = SAME_GL_SELECTED_AP;
	}	

 
/********************
if($_GET['PK_to_GL']=='43545645643734737347'){  	 
	if(!empty($ErrorGlAccount)){
		$_SESSION['mess_credit']  = $ErrorGlAccount;
	}else{	
		$arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];
		$arryPostData['AccountPayable'] = $AccountPayable;
		$arryPostData['InventoryAP'] = $InventoryAP;
		$arryPostData['FreightExpense'] = $FreightExpense;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		$arryPostData['PurchaseReturn'] = $PurchaseReturn;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;

		$objTransaction->CreditCardGLVendorDataUpdate($arryPostData);		
	}
	 
	exit;
}
/********************/


/*******CODE FOR POST TO GL************************/
if(!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {
    	CleanPost();
 
	if(!empty($ErrorGlAccount)){
		$_SESSION['mess_credit']  = $ErrorGlAccount;
	}else{
		$arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];
		$arryPostData['AccountPayable'] = $AccountPayable;
		$arryPostData['InventoryAP'] = $InventoryAP;
		$arryPostData['FreightExpense'] = $FreightExpense;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		$arryPostData['PurchaseReturn'] = $PurchaseReturn;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
		$arryPostData['ApRestocking'] = $ApRestocking;

		foreach ($_POST['posttogl'] as $OrderID){
			$objTransaction->APCreditMemoPostToGL($OrderID,$arryPostData);
		}
		$_SESSION['mess_credit'] = CREDIT_MEMO_POSTED_TO_GL_AACOUNT;
	}
	header("Location:" . $RedirectURL);
	exit;
}
/********END CODE***********************************/ 






/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if (!empty($arryDefult[0]['setdefault']) && $_GET['customview'] == "") {

    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {
    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}



if (!empty($_GET["customview"])) {
    #$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);


    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
	$colValue=$colRule='';
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");


        foreach ($arryQuery as $colRul) {

            if ($colRul['columnname'] == 'Approved') {

                if (strtolower($colRul['value']) == "yes") {

                    $colRul['value'] = 1;
                } else{
                    $colRul['value'] = 0; 
                }
            } elseif ($colRul['columnname'] == 'EntryType') {

                $colRul['value'] = str_replace(" ", "_", strtolower($colRul['value']));
            }

            if ($colRul['comparator'] == 'e') {

                $comparator = '=';
                $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'in') {
                $comparator = 'in';

                $arrVal = explode(",", $colRul['value']);

                $FinalVal = '';
                foreach ($arrVal as $tempVal) {
                    $FinalVal .= "'" . trim($tempVal) . "',";
                }
                $FinalVal = rtrim($FinalVal, ",");
                $setValue = trim($FinalVal);

                $colRule .= $colRul['column_condition'] . " o." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");

        $_GET['rule'] = $colRule;
        // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/* * **************************End Custom Filter*************************************** */


	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPurchase = $objPurchase->ListCreditNote($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPurchase->ListCreditNote($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	




//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

require_once("../includes/footer.php");
?>


