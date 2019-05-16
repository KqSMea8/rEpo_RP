<?php

$FancyBox = 1;
include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/crm.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/group.class.php");
include_once("includes/FieldArray.php");
$ModuleName = "Opportunity";
$objLead = new lead();
$objCommon = new common();
$objFilter = new filter();
$objGroup = new group();
$RedirectUrl = "viewOpportunity.php?curP=" . $_GET['curP'] . "&module=".$_GET['module'];
$colRule = '';
/***********************/

if($_POST) {
	CleanPost();
    if(sizeof($_POST['OpportunityID'] > 0)) {
        $opportunity = implode(",", $_POST['OpportunityID']);	 

        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_opp'] = ROW_HIGHLIGHTED;
		$objLead->setRowColorOpp($opportunity,$_POST['RowColor']);
        }      
        header("location:" . $RedirectUrl);
        exit;
    }
}

/* * ******************************************** */


/* * ******************************************** */
if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewOpportunity.php?module=Opportunity");
    exit;
}

/* * *******************Set Defult *********** */
$arryDefult = $objFilter->getDefultView($_GET['module']);

if ((!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1) && $_GET['customview'] == "" && $_GET['key']=='') {
    $Config['DefaultActive'] = 1;	
    $_GET['customview'] = $arryDefult[0]['cvid'];
} elseif ($_GET['customview'] != "All" && $_GET['customview'] > 0 && $_GET['key']=='') {
    $_GET['customview'] = $_GET['customview'];
} else {
    $_GET["customview"] = 'All';
}
/*************************************/
$Config['flag'] = 0;
if($_GET['module']=='flag'){
	//$Config['vAllRecord']=1;
	 $Config['flag']=1;
	
}
/*************************************/
//if ($_GET["customview"] == 'All') {
    $arryOpportunity = $objLead->ListOpportunity('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
//} else {

if (!empty($_GET["customview"])  ) { 
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);

   if (!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1) {
	$Config['DefaultActive'] = 1;
   }




    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);

$colValue = $colRule = '';
    if (!empty($arryColVal)) {
        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul) {
            
             //CODE EDIT FOR DECODE
            
          if($colRul['columnname'] == 'Amount')
            {
                $colRul['columnname'] = "DECODE(o.Amount,'". $Config['EncryptKey']."')";
                
                
            }
            
           else if($colRul['columnname'] == 'forecast_amount')
            {
                $colRul['columnname'] = "DECODE(o.forecast_amount,'". $Config['EncryptKey']."')";
                
                
            }
            
            else{
                
                $colRul['columnname'] = 'o.'.$colRul['columnname'];
            }
            
             //END CODE DECODE

            if ($colRul['comparator'] == 'e') {
                if ($colRul['columnname'] == 'o.AssignTo' || $colRul['columnname'] == 'o.AddedDate' || $colRul['columnname'] == 'o.CloseDate') {
                    $comparator = 'like';
                    $colRule .= $colRul['column_condition'] . "  " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                }elseif ($colRul['columnname'] == 'Status') {
			
                    $comparator = '=';
                   if( ucfirst($colRul['value']) == "Active"){ $colv = 1; }else{ $colv = 0; unset($Config['DefaultActive']);}
                   $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colv) . "'   ";
                   
                    //$colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colv) . "%'   ";
                }  else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                
                 
                
            }

            if ($colRul['comparator'] == 'n') {

                $comparator = '!=';
                if ($colRul['columnname'] == 'o.AssignTo' || $colRul['columnname'] == 'o.AddedDate' || $colRul['columnname'] == 'o.CloseDate') {
                    $comparator = 'not like';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                }elseif ($colRul['columnname'] == 'Status') {
                    $comparator = '!=';
                   if( ucfirst($colRul['value']) == "Active"){ $colv = 1; }else{ $colv = 0;}
                   $colRule .= $colRul['column_condition'] . "  " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colv) . "'   ";
                   
                    //$colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colv) . "%'   ";
                } else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                }
                //$colRule .= $colRul['column_condition']." ".$colRul['columnname']." ".$comparator." '".mysql_real_escape_string($colRul['value'])."'   ";
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . "  " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . "  " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
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

                $colRule .= $colRul['column_condition'] . "  " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");
        #echo $colRule;
        //$arryOpportunity = $objLead->CustomOpprotunity($colValue, $colRule);
    }
}




/* * ******************************************* */

//By rajan 23Dec//
$Config['rule'] = $colRule;
$Config['rows'] = (isset($_GET['rows']) && $_GET['rows']!='') ? $_GET['rows'] :''; // By Rajan 19 Jan 2016
//$arryOpportunity = $objLead->ListOpportunity('', $_GET['key'], $_GET['sortby'], $_GET['asc']); // By Rajan 23 dec

//End//

//$num = $objLead->numRows();

//$pagerLink = $objPager->getPager($arryOpportunity, $RecordsPerPage, $_GET['curP']);
//(count($arryOpportunity) > 0) ? ($arryOpportunity = $objPager->getPageRecords()) : ("");



/******Get opportunity Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryOpportunity = $objLead->ListOpportunity('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
	/**********Count Records**************/	
	$Config['GetNumRecords'] = 1;
    $arryCount=$objLead->ListOpportunity('', $_GET['key'], $_GET['sortby'], $_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
/*************************/	




$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
// Added by karishma for editable field on 14 Jan 2016
//echo '<pre>';
//print_r($tableFielsDes);
$CustomFieldLists=$objLead->getCustomField('Opportunity');
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

$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 14 Jan 2016

require_once("../includes/footer.php");
?>


