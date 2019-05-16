<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix . "classes/filter.class.php");
	require_once($Prefix."classes/card.class.php");
	$ModuleName = "Sales";
	$objSale = new sale();
	$objFilter = new filter();
        $objCard = new card();        
	(!$_GET['module'])?($_GET['module']='Order'):(""); 
	$module = $_GET['module'];
	$ModuleDepName="Sales";
	$ModuleName = "Sales ".$_GET['module'];
     
	$ViewUrl = "viewPicking.php";
	$AddUrl = "editPicking.php";
	$EditUrl = "editPicking.php?curP=".$_GET['curP'];
	$ViewUrl = "vPicking.php?&curP=".$_GET['curP'];
	//$SendUrl = "sendSO.php?module=".$module."&curP=".$_GET['curP'];

	$RedirectURL = "viewPicking.php";

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";
	}elseif($_GET['module']=='Invoice'){	
		$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	}else{
		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
	}

	(empty($_GET['Droplist']))?($_GET['Droplist']=""):("");


	/*************************/
        
	include_once("includes/FieldArray.php");
        
/*********************Custom Filter ************/        
  if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}
 /**************Row color functionality************************/       
 if($_POST) {
	CleanPost();
    if(sizeof($_POST['OrderID'] > 0)) {
        $Order = implode(",", $_POST['OrderID']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
						if($_POST['RowColor']=='None') $_POST['RowColor']='';
						$_SESSION['mess_Sale'] = ROW_HIGHLIGHTED;
						$objSale->setRowColorSale($Order,$_POST['RowColor']);
header("location:".$RedirectUrl);
 
       //exit;
        }
      
       
    }
}       
/***************************************/  
/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if(!empty($arryDefult[0]['setdefault']) && empty($_GET['customview']) ){ 
    
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
	$colValue = $colRule = '';
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");
       

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
   	/*********Get Sales*************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
//$_GET['Picking']  = '1';
$_GET['CREDIT_APP'] = 'Credit Approved';
$_GET['Status'] = 'Open';
	//$_GET['Approved'] = '1';

	//$_GET['InvoiceID'] = 'Order';	
$_GET['module'] = 'Order';
 
//if($Config['batchmgmt']==1){
	$arrySale=$objSale->ListSalePick($_GET); //updated by bhoodev 29feb//
$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListSalePick($_GET);//updated by chetan 29feb//
$num=$arryCount[0]['NumCount'];
/*}else{
$arrySale=$objSale->ListSaleOrdersOnly($_GET); //updated by bhoodev 29feb//
$Config['GetNumRecords'] = 1;
        $arryCount=$objSale->ListSaleOrdersOnly($_GET);//updated by chetan 29feb//
$num=$arryCount[0]['NumCount'];
}*/
	/*******Count Records**********/	
	
		
//$num=count($arrySale);

	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	/******************************/
 $queryCommentKey=$objConfig->isHavingComment();         
	require_once("../includes/footer.php"); 	
?>


