<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
        require_once($Prefix . "classes/filter.class.php");
	$ModuleName = "Purchase";
	$objPurchase = new purchase();
         $objFilter = new filter();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];

	/**************/
	$ModuleArray = array('Quote','Order'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		header("location:home.php");die;		 
	}
	/**************/

	$ModuleName = "Purchase ".$_GET['module'];
 	$ModuleDepName="Purchase";

	$ViewUrl = "viewPO.php?module=".$module;
	$AddUrl = "editPO.php?module=".$module;
	$EditUrl = "editPO.php?module=".$module."&curP=".$_GET['curP'];
	$ViewUrl = "vPO.php?module=".$module."&curP=".$_GET['curP'];
	$SendUrl = "sendPO.php?module=".$module."&curP=".$_GET['curP'];
	$RedirectURL = "viewPO.php?module=".$module;

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";
	}else{
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID";
	}
        
     include_once("includes/FieldArray.php");

        /*********************Custom Filter ************/        
  if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}

if(!empty($_GET['cOrder'])){
	    $location = $_SERVER['HTTP_REFERER']; 
		$orderId = $_GET['cOrder'];	 
		$poClose = $objPurchase->poCloseStatusUpdate($orderId);	 		   
		$_SESSION['mess_purchase'] = 'PO '.MODULE_STATUS_CHANGED;
		header('Location: '.$location);	 die;	   
	}
        
   /**************Row color functionality added by nisha************************/       
 if($_POST) {
	CleanPost();
    if(sizeof($_POST['OrderID'] > 0)) {
        $Order = implode(",", $_POST['OrderID']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
						if($_POST['RowColor']=='None') $_POST['RowColor']='';
						$_SESSION['mess_purchase'] = ROW_HIGHLIGHTED;
						$objPurchase->setRowColorPurchase($Order,$_POST['RowColor']);
header("location:".$RedirectUrl);
 
       //exit;
        }
      
       
    }
}       
/**************end row color functionality*************************/       
/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);
if(!empty($arryDefult[0]['cvid'])){
	if($arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "" ){     
	  $_GET['customview']=  $arryDefult[0]['cvid'];    
	}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){    
	    $_GET['customview'] = $_GET['customview'];    
	} 
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
       

        foreach ($arryQuery as $colRul) {
            
               

            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " o. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
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
 
        $TotalInvoice=0;
        /*********Get Purchases*********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryPurchase=$objPurchase->ListPurchase($_GET);
	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objPurchase->ListPurchase($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);        
	/******************************/
	 $queryCommentKey=$objConfig->isHavingComment(); 
 
	require_once("../includes/footer.php"); 	
?>


