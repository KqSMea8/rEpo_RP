<?php  $FancyBox=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	include_once("includes/FieldArray.php");
	$ModuleName = "Document";
	$objLead=new lead();
	
	if((isset($_GET['parent_type']) && $_GET['parent_type']!='') && (isset($_GET['parentID']) && $_GET['parentID']!='')){
	

	$AddUrl = "editDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$ViewUrl = "viewDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	//$AddUrl = "editDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	
		//echo $AddUrl;  exit;
	}else{
	$AddUrl = "editDocument.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	$ViewUrl = "viewDocument.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
	}
	$arryFolder = $objLead->GetDocumentFolderName(); 
	$Config['rows'] = (isset($_GET['rows'])) ? $_GET['rows'] :'';  


/******Get Document Records***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$parent_type = (isset($_GET['parent_type'])) ? $_GET['parent_type'] :''; 
	$parentID = (isset($_GET['parentID'])) ? $_GET['parentID'] :''; 
	$arryDocument=$objLead->ListDocument('',$parent_type,$parentID,$_GET['key'],$_GET['sortby'],$_GET['asc']);
	/**********Count Document Records**************/	
	$Config['GetNumRecords'] = 1;
    $arryCount=$objLead->ListDocument('',$parent_type,$parentID,$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/*************************/	




  


// Added by karishma for editable field on 21 Jan 2016

$CustomFieldLists=$objLead->getCustomField('Document');
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

$FieldTypeArray['AssignTo']='multiselect';
$FieldEditableArray['AssignTo']='1';
//$FieldEditableArray['LandlineNumber']='0';

$SelectboxEditableArray['Currency']=array('selecttbl'=>'Currency','selectfield'=>'Currency','selectfieldType'=>'text');
	require_once("../includes/footer.php"); 	 
?>


