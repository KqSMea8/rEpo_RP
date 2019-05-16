<?php
$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/event.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/lead.class.php");
include_once("includes/FieldArray.php");
$ModuleName = $_GET['module'];
$objActivity = new activity();
$objCommon = new common();
$objFilter = new filter();
$objLead = new lead();
$colRule = '';
$RedirectUrl = "viewActivity.php?curP=".$_GET['curP']."&module=".$_GET['module'];

/***********************/
if($_POST) {
	CleanPost();
    if(sizeof($_POST['activityID'] > 0)) {
        $activity = implode(",", $_POST['activityID']);	 

        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_activity'] = ROW_HIGHLIGHTED;
		$objActivity->setRowColorActivity($activity,$_POST['RowColor']);
        }      
        header("location:" . $RedirectUrl);
        exit;
    }
}
/***********************/

//($_GET['st'] == '') ? ($_GET['st'] = 1) : ("");

(isset($_GET['mode']) && $_GET['mode'] == '') ? ($_GET['mode'] = "Event") : ("");


if((isset($_GET['parent_type']) && $_GET['parent_type']!= '') && (isset($_GET['parentID']) && $_GET['parentID']!= '')) {

    $AddUrl = "editActivity.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewActivity.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    //$AddUrl = "editActivity.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
    //echo $AddUrl;  exit;
} else {
    $AddUrl = "editActivity.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewActivity.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
}

/* * ************************************************************ */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewActivity.php?module=Activity");
    exit;
}

/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if((!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1) && $_GET['customview'] == "" && $_GET['key'] == "" && $_GET['FromDate'] == "" && $_GET['ToDate'] == ""){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0 && $_GET['key'] == "" && $_GET['FromDate'] == "" && $_GET['ToDate'] == ""){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}
 
/*********************Set Defult ************/
//if ($_GET["customview"] == 'All' ) {
    
    //$arryActivity = $objActivity->GetActivityList($_GET);
    
//} else {
    if(!empty($_GET["customview"])) {
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

$colRul['columnname']  = "e".$colRul['columnname'] ;

            if ($colRul['comparator'] == 'e') {  //echo $colRul['value'];exit;
                if ($colRul['columnname'] == 'e.AssignTo' || $colRul['columnname'] == 'e.assignTo' || $colRul['columnname'] == 'e.assignedTo' || $colRul['columnname'] == 'e.created_id') {
                    $comparator = 'like';


                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'e.AssignTo' || $colRul['columnname'] == 'e.assignTo' || $colRul['columnname'] == 'e.assignedTo' || $colRul['columnname'] == 'e.created_id') {
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
        //$arryActivity = $objActivity->CustomActivity($colValue, $colRule);
    }
}
/* * *********************************************************** */





$Config['rule'] = $colRule;       // By Rajan 23 dec
$Config['rows'] = (isset($_GET['rows']) && $_GET['rows']!='') ? $_GET['rows'] :''; 


/******Get Ticket Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryActivity = $objActivity->GetActivityList($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objActivity->GetActivityList($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	



// Added by karishma for editable field on 18 Jan 2016

$CustomFieldLists=$objLead->getCustomField('Calendar');
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
			$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldid'],'selectfieldType'=>'text');	
			
		}else{
			
			if($val['fieldname']=='country_id'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'int');	
			}elseif($val['fieldname']=='startDate'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text','relatedField'=>'startTime');	
			}elseif($val['fieldname']=='closeDate'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text','relatedField'=>'closeTime');	
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
