<?php 
	require_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/finance.class.php");
        require_once($Prefix . "classes/filter.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
        include_once("includes/FieldArray.php");
	$objPurchase = new purchase();
        $objFilter = new filter();
	$objCommon = new common();
        $objReport = new report();
        $objBankAccount = new BankAccount();
	 (empty($_GET['module'])) ? ($_GET['module'] = "PoInvoice") : ("");
	$ModuleName = "Invoice Entry";
	$RedirectURL = "viewVendorInvoiceEntry.php";

	$AccountPayable = $objCommon->getSettingVariable('AccountPayable');
	$InventoryAP = $objCommon->getSettingVariable('InventoryAR');
	$FreightExpense = $objCommon->getSettingVariable('FreightExpense');
	$CostOfGoods = $objCommon->getSettingVariable('CostOfGoods');

	$ErrorGlAccount='';
	//if($Config['TrackInventory']==1){
		if(empty($AccountPayable) || empty($InventoryAP) || empty($FreightExpense) || empty($CostOfGoods)){
			$ErrorGlAccount  = SELECT_GL_AP_ALL;
		}
	/*}else{
		if(empty($AccountPayable) || empty($InventoryAP)){
			$ErrorGlAccount  = SELECT_GL_AP_ALL;
		}
	}*/

	
	if($AccountPayable>0 && ($AccountPayable == $InventoryAP || $AccountPayable == $CostOfGoods)){
		$ErrorGlAccount  = SAME_GL_SELECTED_AP;
	}

/*******CODE FOR POST TO GL************************/
if(!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {
	CleanPost();
	if(!empty($ErrorGlAccount)){
		$_SESSION['mess_invoice']  = $ErrorGlAccount;
	}else{
		$arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];
		$arryPostData['PaymentType'] = 'Vendor Invoice Entry';
		$arryPostData['AccountPayable'] = $AccountPayable;
		$arryPostData['InventoryAP'] = $InventoryAP;
		$arryPostData['FreightExpense'] = $FreightExpense;
		$arryPostData['CostOfGoods'] = $CostOfGoods;

		foreach($_POST['posttogl'] as $tempID){			
			$arryDt = explode("#",$tempID);			
			$OrderID = (int)$arryDt[0];
			$AdjID = (int)$arryDt[1];			
			if($AdjID>0){
				$objBankAccount->AdjustmentPost($AdjID,$_POST['PostToGLDate']); 
			}
			if($OrderID>0){
				$objBankAccount->TransferFundPost($OrderID,$AccountPayable); //if exists
				$NotPostedInvoiceID = $objReport->PoInvoicePostToGL($OrderID,$arryPostData);
			}
				
		}
		 
		/*if($NotPostedInvoiceID!=''){
			$_SESSION['mess_invoice'] = INVOICE_PO_NOT_POSTED;
		}else{
			$_SESSION['mess_invoice'] = INVOICE_POSTED_TO_GL_AACOUNT;
		}*/
		$_SESSION['mess_invoice'] = INVOICE_POSTED_TO_GL_AACOUNT;
	}
	header("Location:" . $RedirectURL);
	exit;
}
/********END CODE***********************************/

      
/*********************Custom Filter ************/        
  if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}
        
        
/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "" ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
    
    
    
if (!empty($_GET["customview"]) ) {

    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");
       

        foreach ($arryQuery as $colRul) {
            
            
                if ($colRul['columnname'] == 'InvoicePaid') {
                   
      
                       if(strtolower($colRul['value'])=='paid' ){
                          $colRul['value'] = 1; 
				//$colRule .= " and o.InvoicePaid='1'"; 
			}else if(strtolower($colRul['value'])=='unpaid' ){
                            $colRul['value'] = '';
				//$colRule .= " and o.InvoicePaid!='1' and o.InvoicePaid!='2'";
			}else {
                            $colRul['value'] = 2;
				//$colRule .= " and o.InvoicePaid='2' ";
			}
                       
                 }elseif($colRul['columnname'] == 'EntryType'){
                     
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
       
    }
}

/****************************End Custom Filter****************************************/
    
  
	/*************************/
	$_GET['InvoiceEntry']=1;	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryInvoice=$objPurchase->ListInvoice($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPurchase->ListInvoice($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);



 
 	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly



	require_once("../includes/footer.php"); 	
?>


