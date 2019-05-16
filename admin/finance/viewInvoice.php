<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix . "classes/filter.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/item.class.php");
	include_once("includes/FieldArray.php");

	$ModuleName = "Sales";
	$objSale = new sale();
	$objFilter = new filter();
	$objCommon = new common();
	$objReport = new report();
	$objBankAccount = new BankAccount();
	$objItem=new items();
	$objTransaction=new transaction();
	$_GET['module'] = "Invoice";
	$ModuleName = "Sales Invoice";
	$ModuleDepName = "SalesInvoice";
	$ViewUrl = "viewInvoice.php";
	$AddUrl = "editInvoice.php";
	$EditUrl = "editInvoice.php?curP=".$_GET['curP'];
	$SendUrl = "sendInvoice.php?curP=".$_GET['curP'];
	$ViewUrl = "vInvoice.php?curP=".$_GET['curP'];
	$RedirectURL = "viewInvoice.php";
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	/*************************/
        
	$AccountReceivable = $objCommon->getSettingVariable('AccountReceivable');
	$InventoryAR = $objCommon->getSettingVariable('InventoryAR');
	$FreightAR = $objCommon->getSettingVariable('FreightAR');
	$SalesAccount = $objCommon->getSettingVariable('Sales');
	$CostOfGoods = $objCommon->getSettingVariable('CostOfGoods');
	//$RevenueAccount = $objCommon->getSettingVariable('RevenueAccount');
	$SalesTaxAccount = $objCommon->getSettingVariable('SalesTaxAccount');
	

	$ErrorGlAccount='';
	//if($Config['TrackInventory']==1){
		if(empty($AccountReceivable) || empty($InventoryAR) || empty($SalesAccount) || empty($CostOfGoods)){
			$ErrorGlAccount  = SELECT_GL_AR_ALL;
		}
	/*}else{
		if(empty($AccountReceivable) || empty($SalesAccount)){
			$ErrorGlAccount  = SELECT_GL_AR_ALL;
		}
	}*/

	
	if($AccountReceivable>0 && $AccountReceivable == $SalesAccount){
		$ErrorGlAccount  = SAME_GL_SELECTED_AR;
	}


	

 	$_SESSION['NumPosted']  = 0;

/**************Row color functionality added by nisha************************/       
 if($_POST) {
	CleanPost();
		
    if(sizeof($_POST['posttogl'] > 0)) {

        $OrderID = implode(",", $_POST['posttogl']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
            //print_r($_POST); exit;
			if($_POST['RowColor']=='None') $_POST['RowColor']='';
			$_SESSION['mess_Invoice'] = ROW_HIGHLIGHTED;
			$objSale->setRowColorSale($OrderID,$_POST['RowColor']);
			header("location:".$RedirectURL);
 
       //exit;
        }
      
       
    }
}       
/***************highlight row color code ends here************************/  

/*******POS Cash Receipt and Journal************************
if(!empty($_GET['PK345453464364234324'])) {	

	if(!empty($ErrorGlAccount)){
		echo $ErrorGlAccount; die;
	}else{		 
		if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
			$arryPostData['PosFlag'] = 1;		 
		} 
		//$arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];		
		$arryPostData['AccountReceivable'] = $AccountReceivable;
		$arryPostData['InventoryAR'] = $InventoryAR;
		$arryPostData['FreightAR'] = $FreightAR;
		$arryPostData['SalesAccount'] = $SalesAccount;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		//$arryPostData['RevenueAccount'] = $RevenueAccount;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
				
		#$objReport->CronInvoicePostToGL($arryPostData);
		#$objReport->UpdateRefNoForActualFreight();
		#$objConfigure->GeneratePaidInvoicePDF();
		#$objReport->CostOfGoodPostToGL($arryPostData);
	 
		//$objReport->CreateAPForActualFreight345345($arryPostData);

		echo 'done';  

	}	
	
	exit;
}
/********END CODE***********************************/



 


/*******CODE FOR POST TO GL************************/
if(!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {	

    	CleanPost();
	unset($_SESSION['mess_post_error']);
	if(!empty($ErrorGlAccount)){
		$_SESSION['mess_Invoice']  = $ErrorGlAccount;
	}else{
		if(empty($arryCompany[0]['Department']) || in_array("2",$arryCmpDepartment)){
			$arryPostData['EcommFlag'] = 1;		 
		}
		if(empty($arryCompany[0]['Department']) || in_array("12",$arryCmpDepartment)){
			$arryPostData['PosFlag'] = 1;		 
		}
		$arryPostData['HostbillActive'] = $objConfig->isHostbillActive();		

		$arryPostData['PostToGLDate'] = $_POST['PostToGLDate'];		
		$arryPostData['AccountReceivable'] = $AccountReceivable;
		$arryPostData['InventoryAR'] = $InventoryAR;
		$arryPostData['FreightAR'] = $FreightAR;
		$arryPostData['SalesAccount'] = $SalesAccount;
		$arryPostData['CostOfGoods'] = $CostOfGoods;
		//$arryPostData['RevenueAccount'] = $RevenueAccount;
		$arryPostData['SalesTaxAccount'] = $SalesTaxAccount;
		$arryPostData['ShippingCareerVal'] = $arryCompany[0]['ShippingCareerVal'];
		
		/*****************
		$arryAtt = $objConfigure->GetAttribValue('ShippingMethod','attribute_value');
		$shipCareerArr=array();
		foreach($arryAtt as $arryAttVal){	 
			$shipCareerArr[]=$arryAttVal['attribute_value'];
		}
		$arrOtherCareer = array_diff($shipCareerArr, array("DHL", "Fedex","UPS","USPS","Customer Pickup"));
		$OtherCareer = implode(',', $arrOtherCareer);
		$arryPostData['ShippingCareerOther'] = $OtherCareer;
		/********************/
 



		$NumToPost = sizeof($_POST['posttogl']);
		foreach($_POST['posttogl'] as $OrderID){
			$objReport->SoInvoicePostToGL($OrderID,$arryPostData);

			/*************/
			if(!empty($_SESSION['mess_post_error'])){				
				$_SESSION['mess_Invoice'] = $_SESSION['mess_post_error'];
				unset($_SESSION['mess_post_error']);
				header("Location:" . $RedirectURL);
				exit;
			}
			/*************/

		}

		if($NumToPost == $_SESSION['NumPosted']){
			$_SESSION['mess_Invoice'] = INVOICE_POSTED_TO_GL_AACOUNT;			
		}else{
			$_SESSION['mess_Invoice'] = $_SESSION['NumPosted'].' '.INVOICE_POSTED_TO_GL_NUM;
		}

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

if(!empty($arryDefult[0]['setdefault']) && $_GET['customview'] == "" ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
    
    
    
if (!empty($_GET["customview"]) ) {
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
       
	$colRule='';
        foreach ($arryQuery as $colRul) {
            
                if ($colRul['columnname'] == 'Status') {

                        if (strtolower($colRul['value']) == strtolower(ST_CLR_CREDIT)) {
                        
                               $colRul['value'] = 'Completed';
                        } else if (strtolower($colRul['value'])== strtolower(ST_TAX_APP_HOLD)) {
                               $colRul['value'] = 'Open';
                                if ($colRul['comparator'] == 'e') {
                                $colRule  .= " and o.tax_auths = 'Yes'  ";
                                }else{
                                    
                                    $colRule  .= " and o.tax_auths != 'Yes'  ";
                                }
                        } else if (strtolower($colRul['value'])== strtolower(ST_CREDIT_HOLD)) {
                               $colRul['value'] = 'Open';
                               
                                if ($colRul['comparator'] == 'n') {
                                $colRule  .= " and o.tax_auths != 'No'";
                                }else{
                                    
                                    $colRule  .= " and o.tax_auths  = 'No'";
                                }
                               
                               
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
       // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/****************************End Custom Filter****************************************/
    
if($Config['batchmgmt']==1){
			$_GET['batchOn'] =1;
}   
        





   	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arrySale=$objSale->ListARInvoice($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListARInvoice($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);     


	$queryCommentKey=$objConfig->isHavingComment(); 
	$arrCommentOrderID = explode(',', $queryCommentKey[0]['commentedIds']);   

	require_once("../includes/footer.php"); 	
?>


