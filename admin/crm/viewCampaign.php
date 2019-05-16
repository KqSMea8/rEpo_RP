<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/filter.class.php");
include_once("includes/FieldArray.php");

$ModuleName = "Campaign";
$objLead = new lead();
$objFilter = new filter();
$colRule = '';
/* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewCampaign.php?module=Campaign");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if(!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1 && $_GET['customview'] == "") {

    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}
//if ($_GET["customview"] == 'All') {
    //$arryCampaign = $objLead->ListCampaign('', $_GET['key'], $_GET['sortby'], $_GET['closingdate'], $_GET['asc'], $_GET['search_Status']);
//} else {
 if (!empty($_GET["customview"])  ) {
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

            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'assignedTo') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . "  c. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'assignedTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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

                $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        //$arryCampaign = $objLead->CustomCampaign($colValue, $colRule);
    }
}



/* * ******************************************** */



//By rajan 23Dec//
//$Config['Col'] = $columnname;
$Config['rows'] = (isset($_GET['rows']) ? $_GET['rows'] :''); //By chetan 25dec//
$Config['rule'] = $colRule;

//End//

/******Get Campaign Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$closingdate = (isset($_GET['closingdate'])) ? $_GET['closingdate'] :'';
	$search_Status = (isset($_GET['search_Status'])) ? $_GET['search_Status'] :'';
	$arryCampaign = $objLead->ListCampaign('', $_GET['key'], $_GET['sortby'], $closingdate, $_GET['asc'], $search_Status);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
    $arryCount = $objLead->ListCampaign('', $_GET['key'], $_GET['sortby'], $closingdate, $_GET['asc'], $search_Status);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	



// Added by karishma for editable field on 21 Jan 2016
//echo '<pre>';
//print_r($tableFielsDes);
$CustomFieldLists=$objLead->getCustomField('Campaign');
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

			if($val['fieldname']=='country_id' || $val['fieldname']=='product'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'int');
			}else{
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text');
			}

		}

	}
}

$FieldTypeArray['assignedTo']='multiselect';
$FieldEditableArray['assignedTo']='1';
//$FieldEditableArray['LandlineNumber']='0';

$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 21 Jan 2016

require_once("../includes/footer.php");
?>


