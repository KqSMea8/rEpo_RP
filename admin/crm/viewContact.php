<?php 
	include_once("../includes/header.php");
	//require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix . "classes/filter.class.php");
 require_once($Prefix . "classes/lead.class.php");
	include_once("includes/FieldArray.php");
        $objFilter = new filter();
        (empty($_GET['module'])) ? ($_GET['module'] = "Contact") : ("");
	$ModuleName = "Contact";
	//$objContact=new contact();
	$objCustomer=new Customer(); 
$objLead = new lead();



$RedirectUrl = "viewContact.php?curP=".$_GET['curP']."&module=".$_GET['module'];
$colRule = '';
$colValue = ''; 
/***********************/
if($_POST) {
	CleanPost();
    if(sizeof($_POST['AddID'] > 0)) {
        $contacts = implode(",", $_POST['AddID']);	 

        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_contact'] = ROW_HIGHLIGHTED;
		$objCustomer->setRowColorContact($contacts,$_POST['RowColor']);
        }      
        header("location:" . $RedirectUrl);
        exit;
    }
}
/***********************/









/* * *******************Custom Filter *********** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:" . $ThisPageName);
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



if (!empty($_GET["customview"])) {
    #$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc']);


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

                $comparator = '=';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'AssignTo') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                } else if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }


            if ($colRul['comparator'] == 'l') {
                $comparator = '<';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c. " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
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
                if ($colRul['columnname'] == 'AccountName') {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                } else {
                    $colRule .= $colRul['column_condition'] . " c." . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
                }
            }
        }
        $colRule = rtrim($colRule, "  and");

        $_GET['rule'] = $colRule;
        // $arryLead = $objLead->CustomLead($colValue, $colRule);
    }
}

/* * **************************End Custom Filter*************************************** */





$Config['rows'] = (isset($_GET['rows']) && $_GET['rows']!='') ? $_GET['rows'] :''; // By Rajan 19 Jan 2016


	/******Get Contact Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryContact=$objCustomer->ListCrmContact($_GET);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCustomer->ListCrmContact($_GET);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	


// Added by karishma for editable field on 18 Jan 2016

$CustomFieldLists=$objLead->getCustomField('Contact');
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
			}elseif($val['fieldname']=='CustID'){
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'int');	
			}else{
				$SelectboxEditableArray[$val['fieldname']]=array('selecttbl'=>'attribute','selectfield'=>$val['fieldname'],'selectfieldType'=>'text');
			}
				
		}

	}
}

$FieldTypeArray['AssignTo']='multiselect';
$FieldEditableArray['AssignTo']='1';
//$FieldEditableArray['LandlineNumber']='0';
//echo '<pre>';
///print_r($FieldTypeArray);

$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 18 Jan 2016

	require_once("../includes/footer.php"); 	 
?>


