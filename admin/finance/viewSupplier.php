<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
        require_once($Prefix . "classes/filter.class.php");
        include_once("includes/FieldArray.php");
	$ModuleName = "Vendor";
	$objSupplier=new supplier();
         $objFilter = new filter();
/**********************************************/
 (empty($_GET['module'])) ? ($_GET['module'] = "Vendor") : ("");                    
/*********************Custom Filter ************/        
  if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:".$ThisPageName);
    exit;
}
  /**************Row color functionality added by nisha************************/       
 if($_POST) {
	CleanPost();
    if(sizeof($_POST['SuppID'] > 0)) {
        $SuppId = implode(",", $_POST['SuppID']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
						if($_POST['RowColor']=='None') $_POST['RowColor']='';
						$_SESSION['mess_supplier'] = ROW_HIGHLIGHTED;
						$objSupplier->setRowColorSupplier($SuppId,$_POST['RowColor']);
			$RedirectURL = "viewSupplier.php?curP=".$_GET['curP'];
header("location:".$RedirectURL);
 
       //exit;
        }
      
       
    }
}       
/********************end row color*******************/        
        
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

	$colValue=$colRul=$colRule='';
    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");
       

        foreach ($arryQuery as $colRul) {
            
               /* if ($colRul['columnname'] == 'Status') {

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
                     
                 }*/

            if ($colRul['comparator'] == 'e') {
               
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " s. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
               
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " s." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
               
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }



            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " s." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " s." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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

                $colRule .= $colRul['column_condition'] . " s." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        
        $_GET['rule'] = $colRule;
       // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/****************************End Custom Filter****************************************/
   
	
	/*******Get Vendor Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$Config['addTp'] = 'billing';
	$arrySupplier=$objSupplier->ListSupplier($_GET);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objSupplier->ListSupplier($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/
 
	require_once("../includes/footer.php"); 	
?>


