<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/crm.class.php");
include_once("includes/FieldArray.php");
$ModuleName = "Ticket";
$objLead = new lead();
$objGroup = new group();
$objCommon = new common();
$objFilter = new filter();
$colRule = '';

$RedirectUrl = "viewTicket.php?curP=".$_GET['curP']."&module=".$_GET['module'];

/***********************/
if($_POST) {
	CleanPost();
    if(sizeof($_POST['TicketID'] > 0)) {
        $tickets = implode(",", $_POST['TicketID']);	 

        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_ticket'] = ROW_HIGHLIGHTED;
		$objLead->setRowColorTicket($tickets,$_POST['RowColor']);
        }      
        header("location:" . $RedirectUrl);
        exit;
    }
}
/***********************/


if($_GET['module']=='flag'){
	//$Config['vAllRecord']=1;
	 $Config['flag']=1;
	
}else{$Config['flag']=0;}




if (isset($_GET['parent_type']) && isset($_GET['parentID'])) {

    $AddUrl = "editTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&curP=" . $_GET["curP"];
    $vTicket = "vTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&view=";
    $editTicket = "editTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&edit=";
    $DelTicket = "editTicket.php?module=" . $_GET["module"] . "&parent_type=" . $_GET['parent_type'] . "&parentID=" . $_GET['parentID'] . "&del_id=";
} else {
    $AddUrl = "editTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $ViewUrl = "viewTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"];
    $vTicket = "vTicket.php?module=" . $_GET["module"] . "&view=";
    $editTicket = "editTicket.php?module=" . $_GET["module"] . "&edit=";
    $DelTicket = "editTicket.php?module=" . $_GET["module"] . "&curP=" . $_GET["curP"] . "&del_id=";
}

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewTicket.php?module=Ticket");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ((!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1) && $_GET['customview'] == "") {

    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0) {

    $_GET['customview'] = $_GET['customview'];
} else {

    $_GET["customview"] = 'All';
}
//if ($_GET["customview"] == 'All') {
    //$arryTicket = $objLead->ListTicket($_GET);
//} else {
if (!empty($_GET["customview"])  ) { 
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);
#echo $arryfilter[0]['status']; exit;
    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"]);
    $arryQuery = $objFilter->getFileter($_GET["customview"]);
    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul) {
	$colRul['columnname'] = 't.'.$colRul['columnname'];
            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'AssignedTo' || $colRul['columnname'] =='ticketDate') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }
            if ($colRul['comparator'] == 'n') {
                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignedTo') {
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
        //$arryTicket = $objLead->CustomTicket($colValue, $colRule);
    }
}

//By rajan 23Dec//
$Config['rule'] = $colRule;
//$arryTicket = $objLead->ListTicket($_GET);     //BY Rajan 23 dec

//End//
//num = $objLead->numRows();
//$pagerLink = $objPager->getPager($arryTicket, $RecordsPerPage, $_GET['curP']);
//(count($arryTicket) > 0) ? ($arryTicket = $objPager->getPageRecords()) : ("");

$Config['rows'] = (isset($_GET['rows']) && $_GET['rows']!='') ? $_GET['rows'] :''; // By Rajan 19 Jan 2016
/******Get Ticket Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryTicket = $objLead->ListTicket($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objLead->ListTicket($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	





$arryTicketStatus = $objCommon->GetCrmAttribute('TicketStatus', '');

// Added by karishma for editable field on 14 Jan 2016
//echo '<pre>';
//print_r($tableFielsDes);
$CustomFieldLists=$objLead->getCustomField('Ticket');
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
			}else{
			$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text');		
			}
			
		}
		
	}
}

$FieldTypeArray['AssignedTo']='multiselect';
$FieldEditableArray['AssignedTo']='1';
//$FieldEditableArray['LandlineNumber']='0';

$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 14 Jan 2016

require_once("../includes/footer.php");
?>


