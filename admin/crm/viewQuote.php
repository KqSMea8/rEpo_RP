<?php

$FancyBox = 1;

include_once("../includes/header.php");
require_once($Prefix . "classes/quote.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/lead.class.php");
include_once("includes/FieldArray.php");

$ModuleName = $_GET['module'];
$objQuote = new quote();
$objFilter = new filter();
$objLead = new lead();


$RedirectUrl = "viewQuote.php?curP=".$_GET['curP']."&module=".$_GET['module'];
$colRule = '';
/***********************/
if($_POST) {
	CleanPost();
    if(sizeof($_POST['quoteid'] > 0)) {
        $quotes = implode(",", $_POST['quoteid']);	 

        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_quote'] = ROW_HIGHLIGHTED;
		$objQuote->setRowColorQuote($quotes,$_POST['RowColor']);
        }      
        header("location:" . $RedirectUrl);
        exit;
    }
}
/***********************/

if ((isset($_GET['parent_type']) && $_GET['parent_type'] != '') && (isset($_GET['parent_type']) && $_GET['parentID'] != '')) {

    $AddUrl = "editQuote.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewQuote.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
} else {
    $AddUrl = "editQuote.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewQuote.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
}
$SendUrl = "sendSO.php?module=" . $ModuleName . "&curP=" . $_GET['curP'];



/*if ($_GET['search_Status'] != 'All' && $_GET['sortby'] == '' && empty($_GET['search'])) {
    //$_GET['key'] = 'Created';
    //$_GET['sortby'] = 'q.quotestage';
}*/



/* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewQuote.php?module=Quote");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if((!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1) && $_GET['customview'] == "") {
#$objFilter->deleteFilter($arryDefult[0]['cvid']);
    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}
//if ($_GET["customview"] == 'All') {
    //$arryQuote = $objQuote->ListQuote('', $_GET['parent_type'], $_GET['parentID'], $_GET['key'], $_GET['sortby'], $_GET['asc']);
//} else {
if(!empty($_GET["customview"])) {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);

    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);


    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul) {
						$colRul['columnname'] = "q".$colRul['columnname'];
            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'q.AssignTo' || $colRul['columnname'] == 'q.assignTo' || $colRul['columnname'] == 'q.assignedTo') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'q.AssignedTo' || $colRul['columnname'] == 'q.assignTo' || $colRul['columnname'] == 'q.assignedTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        //$arryQuote = $objQuote->CustomQuote($colValue, $colRule);
    }
}



/* * ******************************************** */
$Config['rule'] = $colRule;       // By Rajan 23 dec
$Config['rows'] = (isset($_GET['rows']) && $_GET['rows']!='') ? $_GET['rows'] :''; // By Rajan 20 Jan 2016


/******Get Ticket Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryQuote = $objQuote->ListQuote('', '', '', $_GET['key'], $_GET['sortby'], $_GET['asc']);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objQuote->ListQuote('', '', '', $_GET['key'], $_GET['sortby'], $_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	



// Added by karishma for editable field on 18 Jan 2016

$CustomFieldLists=$objLead->getCustomField('Quotes');
$FieldTypeArray=array();
$FieldEditableArray=array();
$SelectboxEditableArray=array();
$labelArray = array('LeadSource'=>'lead_source','LeadStatus'=>'lead_status','LeadIndustry'=>'Industry','SalesStage'=>'SalesStage','Type'=>'OpportunityType',
    'TicketStatus'=> 'Status','Priority'=>'priority','TicketCategory'=>'category','PaymentMethod'=>'PaymentMethod',
    'ShippingMethod'=>'carrier','ActivityStatus'=> 'status','ActivityType'=>'activityType','expectedresponse'=>'expectedresponse','campaigntype'=>'campaigntype','campaignstatus'=>'campaignstatus');

//print_r($CustomFieldLists);
foreach($CustomFieldLists as $val){
	$FieldTypeArray[$val['fieldname']]=$val['type'];
	$FieldEditableArray[$val['fieldname']]=1;
	$key=array_search($val['fieldname'], $labelArray);
	
	if(false !== $key){
		$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$key,'selectfieldType'=>'text');
	}else{ 
		if($val['dropvalue']!='' && $val['dropvalue']!='0'){
		if($val['fieldname']=='CustType'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldid'],'selectfieldType'=>'int');	
			}else{
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldid'],'selectfieldType'=>'text');	
			}
			
			
		}else{
			
			if($val['fieldname']=='country_id'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'int');	
			}else{
			$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text');		
			}
			
		}
		
	}
}

$FieldTypeArray['AssignedTo']='multiselect';
$FieldEditableArray['AssignedTo']='1';
$FieldTypeArray['TotalAmount']='number';
$FieldEditableArray['TotalAmount']='1';
//$FieldEditableArray['LandlineNumber']='0';
//echo '<pre>';
//print_r($FieldTypeArray);
$SelectboxEditableArray['CustomerCurrency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 18 Jan 2016


require_once("../includes/footer.php");
?>
