<?php
//ini_set('display_errors', '1');
$FancyBox = 1;

include_once("../includes/header.php");
require_once($Prefix . "classes/lead.class.php");
require_once($Prefix . "classes/group.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once($Prefix . "classes/field.class.php");
include_once("language/en_lead.php");
include_once("includes/FieldArray.php");

require_once($Prefix . "classes/crm.class.php"); //By Rajan 22 dec

$objCommon = new common();		
$objField = new field();	//By Rajan  22 Dec	
$ModuleName = "Lead";
$objLead = new lead();
$objFilter = new filter();
$objGroup = new group();

$RedirectUrl = "viewLead.php?curP=" . $_GET['curP'] . "&module=".$_GET['module'];
$colRule = ''; 
/***********************/
$Config['Junk']=0;
$MoveTitle = 'Move to Junk';
if($_GET['module']=='junk'){
	$Config['vAllRecord']=1;
	$Config['Junk']=1;
	$MoveTitle = 'Move to Lead';
}
$Config['flag'] = 0;
if($_GET['module']=='flag'){
	//$Config['vAllRecord']=1;
  $Config['flag']=1;

}
/***********************/

if($_POST['sync_indiamart'] && $_POST['indiamart']== 'indiamart' ){

    $pid = exec('php /var/www/html/erp/cron/indiaMartApi.php > /dev/null & echo $!;', $output, $return);

    //pr($output,1);
    if ($pid) {
        $statusPID = true;
        $objConfig->removePID('crm','addLead');
        $objConfig->setPID('crm','addLead',$pid);
    } else {
        $statusPID = false;
    }

    


}




if($_POST) {
	CleanPost();
    if(sizeof($_POST['leadID'] > 0)) {
        $lead = implode(",", $_POST['leadID']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
          if($_POST['RowColor']=='None') $_POST['RowColor']='';
          $_SESSION['mess_lead'] = ROW_HIGHLIGHTED;
          $objLead->setRowColorLead($lead,$_POST['RowColor']);
      }else if(isset($_POST['MoveToFolder']) && !empty($_POST['MoveToFolder'])){
          if($_POST['MoveToFolder']=='None' || $_POST['MoveToFolder']=='lead') $_POST['MoveToFolder']=0;
          $_SESSION['mess_lead'] = 'Selected row(s) has been Move to selected folder successfully.';
          $objLead->moveToFolder($lead,$_POST['MoveToFolder']);
      }else if(!empty($_POST['MoveButton'])){
          if($Config['Junk']==1){
           $_SESSION['mess_lead'] = LEAD_MOVE_MANAGE;
           $objLead->moveToJunkLead($lead,0);
       }else{
           $_SESSION['mess_lead'] = LEAD_MOVE_JUNK;
           $objLead->moveToJunkLead($lead,1);
       }
   }else if(!empty($_POST['DeleteButton'])){
      $_SESSION['mess_lead'] = LEAD_REMOVE_MULTIPLE;
      $objLead->deleteLead($lead);
  }	

  header("location:" . $RedirectUrl);
  exit;
}
}

/* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewLead.php?module=lead");
    exit;
}


/*********************Set Defult ************/
$arryDefult = $objFilter->getDefultView($_GET['module']);

if((!empty($arryDefult) && $arryDefult[0]['setdefault'] == 1) && $_GET['customview'] == "" ){ 

  $_GET['customview']=  $arryDefult[0]['cvid']; 

}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){

    $_GET['customview'] = $_GET['customview'];
    
}else{

  $_GET["customview"] = 'All';  
}




if (!empty($_GET["customview"]) && $_GET["customview"]!='All' ) {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);

    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);
/*added by bhoodev
 foreach ($arryColVal as $key => $Col) {  //close by chetan 24Jan2018//
$columnname .= 'l.'.$Col['colvalue'].',';
}*/ 

$colValue =$colRule='';
if (!empty($arryColVal)) {
    foreach ($arryColVal as $colVal) {
        $colValue .= $colVal['colvalue'] . ",";
    }
    $colValue = rtrim($colValue, ",");

    foreach ($arryQuery as $colRul) {

             //CODE EDIT FOR DECODE

        if($colRul['columnname'] == 'AnnualRevenue')
        {
          $colRul['columnname'] = "DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."')";


      }

      else{

          $colRul['columnname'] = 'l.'.$colRul['columnname'];

      }

             //END CODE DECODE

      if ($colRul['comparator'] == 'e') {
        if ($colRul['columnname'] == 'l.AssignTo'  || $colRul['columnname'] == 'l.JoiningDate') {
            $comparator = 'like';
            $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
        } else {
            $comparator = '=';
            $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
        }
    }

    if ($colRul['comparator'] == 'n') {

        $comparator = '!=';
        if ($colRul['columnname'] == 'AssignTo') {
            $comparator = 'not like';
            $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
        } else {
            $comparator = '!=';
            $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
        }

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



}
}



/* * ******************************************** */

//$Config['RecordsPerPage'] = $RecordsPerPage;
//By rajan 23Dec//
//$Config['Col'] = $columnname; //close by chetan 24Jan2017//
$Config['tab']  = ($_GET['tab']!='') ? $_GET['tab'] :'';
$Config['rows'] = (isset($_GET['rows']) && $_GET['rows']!='') ? $_GET['rows'] :''; //By chetan 25dec//
$Config['rule'] = $colRule;




//End//



/******Get Lead Records***********/	
$Config['RecordsPerPage'] = $RecordsPerPage;
//edit by ali vstacks 

$arryLead = $objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc'], $_GET['FromDate'],$_GET['ToDate'] );
//End//
$Config['GetNumRecords'] = 1;
$arryCount=$objLead->ListLead('', $_GET['key'], $_GET['sortby'], $_GET['asc'], $_GET['FromDate'],$_GET['ToDate']);
//ali edit end
$num=$arryCount[0]['NumCount'];	
$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
/*************************/	




if (empty($_GET["customview"]) || $_GET["customview"]=='All' ) {
    $LeadHeaderArry = array('company','primary_email','AssignTo','LandlineNumber','Status','LeadDate');
    foreach($LeadHeaderArry as $LeadHeader)
    {
        $LeadCusFldArr[] = $objField->GetCustomfieldByFieldName($LeadHeader,'*');
    }
}






// Added by karishma for editable field on 7 Jan 2016

$CustomFieldLists=$objLead->getCustomField('Lead');
$FieldTypeArray=array();
$FieldEditableArray=array();
$SelectboxEditableArray=array();
$labelArray = array('LeadSource'=>'lead_source','LeadStatus'=>'lead_status','LeadIndustry'=>'Industry','SalesStage'=>'SalesStage','Type'=>'OpportunityType',
    'TicketStatus'=> 'Status','Priority'=>'priority','TicketCategory'=>'category','PaymentMethod'=>'PaymentMethod',
    'ShippingMethod'=>'carrier','ActivityStatus'=> 'status','ActivityType'=>'activityType','expectedresponse'=>'expectedresponse','campaigntype'=>'campaigntype','campaignstatus'=>'campaignstatus');

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

$FieldTypeArray['AssignTo']='multiselect';
$FieldEditableArray['AssignTo']='1';
$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');

// end by karishma for editable field on 7 Jan 2016






require_once("../includes/footer.php");
?>
