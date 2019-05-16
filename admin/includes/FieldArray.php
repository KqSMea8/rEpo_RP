<?php

$RightArray='';

(empty($_GET['type']))?($_GET['type']=""):("");


if($_GET['type'] == 'Ticket'){

$ThisPageName = 'viewTicket.php?module='.$_GET['type'];
	$column = array
	  (
	  array("colum_name"=>"Ticket ID","table_name"=>"c_ticket","colum_value"=>"TicketID"),
	  array("colum_name"=>"Title","table_name"=>"c_ticket","colum_value"=>"title"),
	  array("colum_name"=>"Status","table_name"=>"c_ticket","colum_value"=>"Status"),
	  array("colum_name"=>"Priority","table_name"=>"c_ticket","colum_value"=>"priority"),
	  array("colum_name"=>"Assigned To","table_name"=>"c_ticket","colum_value"=>"AssignedTo"),
	  array("colum_name"=>"Category","table_name"=>"c_ticket","colum_value"=>"category"),
	  array("colum_name"=>"Days","table_name"=>"c_ticket","colum_value"=>"day"),
	  array("colum_name"=>"Hours","table_name"=>"c_ticket","colum_value"=>"hours"),
	  array("colum_name"=>"Description","table_name"=>"c_ticket","colum_value"=>"description"),
	  array("colum_name"=>"Solution","table_name"=>"c_ticket","colum_value"=>"solution"),
	  array("colum_name"=>"Created on","table_name"=>"c_ticket","colum_value"=>"ticketDate")
	  );

	$column2 = array
	  (
	  array("colum_name"=>"Ticket ID","table_name"=>"c_ticket","colum_value"=>"TicketID"),
	  array("colum_name"=>"Title","table_name"=>"c_ticket","colum_value"=>"title"),
	  array("colum_name"=>"Status","table_name"=>"c_ticket","colum_value"=>"Status"),
	  array("colum_name"=>"Priority","table_name"=>"c_ticket","colum_value"=>"priority"),
	   array("colum_name"=>"Assigned To","table_name"=>"c_ticket","colum_value"=>"AssignedTo"),
	  array("colum_name"=>"Category","table_name"=>"c_ticket","colum_value"=>"category"),
	  array("colum_name"=>"Days","table_name"=>"c_ticket","colum_value"=>"day"),
	  array("colum_name"=>"Hours","table_name"=>"c_ticket","colum_value"=>"hours"),
	  array("colum_name"=>"Description","table_name"=>"c_ticket","colum_value"=>"description"),
	  array("colum_name"=>"Solution","table_name"=>"c_ticket","colum_value"=>"solution")
	 
	  );

}else if($_GET['type'] == 'lead'){
$ThisPageName = 'viewLead.php?module='.$_GET['type'];
	$column = array
	  (
		array("colum_name"=>"Lead ID","table_name"=>"c_lead","colum_value"=>"leadID"),
		array("colum_name"=>"First Name","table_name"=>"c_lead","colum_value"=>"FirstName"),
		array("colum_name"=>"Last Name","table_name"=>"c_lead","colum_value"=>"LastName"),
		array("colum_name"=>"Primary Email","table_name"=>"c_lead","colum_value"=>"primary_email"),
		array("colum_name"=>"Assigned To","table_name"=>"c_lead","colum_value"=>"AssignTo"),
		array("colum_name"=>"Company","table_name"=>"c_lead","colum_value"=>"company"),
		array("colum_name"=>"Website","table_name"=>"c_lead","colum_value"=>"Website"),
		array("colum_name"=>"Title","table_name"=>"c_lead","colum_value"=>"designation"),
		array("colum_name"=>"Product","table_name"=>"c_lead","colum_value"=>"ProductID"),
		array("colum_name"=>"Product Price","table_name"=>"c_lead","colum_value"=>"product_price"),
		array("colum_name"=>"Annual Revenue","table_name"=>"c_lead","colum_value"=>"AnnualRevenue"),
		array("colum_name"=>"Lead Source","table_name"=>"c_lead","colum_value"=>"lead_source"),
		array("colum_name"=>"Number of Employees","table_name"=>"c_lead","colum_value"=>"NumEmployee"),
		array("colum_name"=>"Lead Status","table_name"=>"c_lead","colum_value"=>"lead_status"),
		array("colum_name"=>"Created Date","table_name"=>"c_lead","colum_value"=>"UpdatedDate"),
		array("colum_name"=>"Lead Date","table_name"=>"c_lead","colum_value"=>"JoiningDate"),
		array("colum_name"=>"Last Contact Date","table_name"=>"c_lead","colum_value"=>"LeadDate")
	  );

	$column2 = array
	  (
	        array("colum_name"=>"Lead ID","table_name"=>"c_lead","colum_value"=>"leadID"),
		array("colum_name"=>"First Name","table_name"=>"c_lead","colum_value"=>"FirstName"),
		array("colum_name"=>"Last Name","table_name"=>"c_lead","colum_value"=>"LastName"),
		array("colum_name"=>"Primary Email","table_name"=>"c_lead","colum_value"=>"primary_email"),
		array("colum_name"=>"Assigned To","table_name"=>"c_lead","colum_value"=>"AssignTo"),
		array("colum_name"=>"Company","table_name"=>"c_lead","colum_value"=>"company"),
		array("colum_name"=>"Website","table_name"=>"c_lead","colum_value"=>"Website"),
		array("colum_name"=>"Title","table_name"=>"c_lead","colum_value"=>"designation"),
		array("colum_name"=>"Product","table_name"=>"c_lead","colum_value"=>"ProductID"),
		array("colum_name"=>"Product Price","table_name"=>"c_lead","colum_value"=>"product_price"),
		array("colum_name"=>"Annual Revenue","table_name"=>"c_lead","colum_value"=>"AnnualRevenue"),
		array("colum_name"=>"Lead Source","table_name"=>"c_lead","colum_value"=>"lead_source"),
		array("colum_name"=>"Number of Employees","table_name"=>"c_lead","colum_value"=>"NumEmployee"),
		array("colum_name"=>"Lead Status","table_name"=>"c_lead","colum_value"=>"lead_status")
	 
	  );

}else if($_GET['type'] == 'Opportunity'){
        $ThisPageName = 'viewOpportunity.php?module='.$_GET['type'];
	$column = array
	  (
		array("colum_name"=>"Opportunity ID","table_name"=>"c_opportunity","colum_value"=>"OpportunityID"),
		array("colum_name"=>"Opportunity Name","table_name"=>"c_opportunity","colum_value"=>"OpportunityName"),
		array("colum_name"=>"Organization Name","table_name"=>"c_opportunity","colum_value"=>"OrgName"),
		array("colum_name"=>"Amount","table_name"=>"c_opportunity","colum_value"=>"Amount"),
		array("colum_name"=>"Created Date","table_name"=>"c_opportunity","colum_value"=>"AddedDate"),
		array("colum_name"=>"Expected Close Date","table_name"=>"c_opportunity","colum_value"=>"CloseDate"),
		array("colum_name"=>"Sales Stage","table_name"=>"c_opportunity","colum_value"=>"SalesStage"),
		array("colum_name"=>"Assigned To","table_name"=>"c_opportunity","colum_value"=>"AssignTo"),
		array("colum_name"=>"Customer","table_name"=>"c_opportunity","colum_value"=>"CustID"),
		array("colum_name"=>"Lead Source","table_name"=>"c_opportunity","colum_value"=>"lead_source"),
                array("colum_name"=>"Industry","table_name"=>"c_opportunity","colum_value"=>"Industry"),
		array("colum_name"=>"Next Step","table_name"=>"c_opportunity","colum_value"=>"NextStep"),
		array("colum_name"=>"Opportunity Type","table_name"=>"c_opportunity","colum_value"=>"OpportunityType"),
		array("colum_name"=>"Probability (%)","table_name"=>"c_opportunity","colum_value"=>"Probability"),
		array("colum_name"=>"Campaign Source","table_name"=>"c_opportunity","colum_value"=>"Campaign_Source"),
		array("colum_name"=>"Forecast Amount","table_name"=>"c_opportunity","colum_value"=>"forecast_amount"),
		array("colum_name"=>"Contact Name","table_name"=>"c_opportunity","colum_value"=>"ContactName"),
		array("colum_name"=>"Website","table_name"=>"c_opportunity","colum_value"=>"oppsite"),
                array("colum_name"=>"Status","table_name"=>"c_opportunity","colum_value"=>"Status"),
                array("colum_name"=>"Description","table_name"=>"c_opportunity","colum_value"=>"description")
	  );

	$column2 = array
	  (
	        array("colum_name"=>"Opportunity ID","table_name"=>"c_opportunity","colum_value"=>"OpportunityID"),
		array("colum_name"=>"Opportunity Name","table_name"=>"c_opportunity","colum_value"=>"OpportunityName"),
		array("colum_name"=>"Organization Name","table_name"=>"c_opportunity","colum_value"=>"OrgName"),
		array("colum_name"=>"Amount","table_name"=>"c_opportunity","colum_value"=>"Amount"),
		//array("colum_name"=>"Expected Close Date","table_name"=>"c_lead","colum_value"=>"CloseDate"),
		array("colum_name"=>"Sales Stage","table_name"=>"c_opportunity","colum_value"=>"SalesStage"),
		//array("colum_name"=>"Assigned To","table_name"=>"c_opportunity","colum_value"=>"AssignTo"),
		//array("colum_name"=>"Customer","table_name"=>"c_opportunity","colum_value"=>"CustID"),
		array("colum_name"=>"Lead Source","table_name"=>"c_opportunity","colum_value"=>"lead_source"),
		array("colum_name"=>"Next Step","table_name"=>"c_opportunity","colum_value"=>"NextStep"),
		array("colum_name"=>"Opportunity Type","table_name"=>"c_opportunity","colum_value"=>"OpportunityType"),
		array("colum_name"=>"Probability (%)","table_name"=>"c_opportunity","colum_value"=>"Probability"),
		array("colum_name"=>"Campaign Source","table_name"=>"c_opportunity","colum_value"=>"Campaign_Source"),
		array("colum_name"=>"Forecast Amount","table_name"=>"c_opportunity","colum_value"=>"forecast_amount"),
		array("colum_name"=>"Contact Name","table_name"=>"c_opportunity","colum_value"=>"ContactName"),
		array("colum_name"=>"Website","table_name"=>"c_opportunity","colum_value"=>"oppsite"),
                array("colum_name"=>"Status","table_name"=>"c_opportunity","colum_value"=>"Status")
	 
	  );

}else if($_GET['type'] == 'Campaign'){

        $ThisPageName = 'viewCampaign.php?module='.$_GET['type'];
	$column = array
	  (
		array("colum_name"=>"Campaign ID","table_name"=>"c_campaign","colum_value"=>"campaignID"),
		array("colum_name"=>"Campaign Name","table_name"=>"c_campaign","colum_value"=>"campaignname"),
		array("colum_name"=>"Campaign Status","table_name"=>"c_campaign","colum_value"=>"campaignstatus"),
		array("colum_name"=>"Product","table_name"=>"c_campaign","colum_value"=>"ItemName"),
		array("colum_name"=>"Created Date","table_name"=>"c_campaign","colum_value"=>"created_time"),
		array("colum_name"=>"Expected Close Date","table_name"=>"c_campaign","colum_value"=>"closingdate"),
		array("colum_name"=>"Sponsor","table_name"=>"c_campaign","colum_value"=>"sponsor"),
		array("colum_name"=>"Assigned To","table_name"=>"c_campaign","colum_value"=>"assignedTo"),
		array("colum_name"=>"Campaign Type","table_name"=>"c_campaign","colum_value"=>"campaigntype"),
		array("colum_name"=>"Target Audience","table_name"=>"c_campaign","colum_value"=>"targetaudience"),
		array("colum_name"=>"Target Size","table_name"=>"c_campaign","colum_value"=>"targetsize"),
		array("colum_name"=>"Num Sent (%)","table_name"=>"c_campaign","colum_value"=>"numsent"),
		array("colum_name"=>"Budget Cost","table_name"=>"c_campaign","colum_value"=>"budgetcost"),
		array("colum_name"=>"Expected Response","table_name"=>"c_campaign","colum_value"=>"expectedresponse"),
		array("colum_name"=>"Expected Sales Count","table_name"=>"c_campaign","colum_value"=>"expectedsalescount"),
		array("colum_name"=>"Expected ROi","table_name"=>"c_campaign","colum_value"=>"expectedroi"),
		array("colum_name"=>"Expected Revenue","table_name"=>"c_campaign","colum_value"=>"expectedrevenue"),
                array("colum_name"=>"Actual Sales Count","table_name"=>"c_campaign","colum_value"=>"actualsalescount"),
                array("colum_name"=>"Actual Response Count","table_name"=>"c_campaign","colum_value"=>"expectedresponsecount"),
                array("colum_name"=>"Actual ROI","table_name"=>"c_campaign","colum_value"=>"actualroi"),
                array("colum_name"=>"Description","table_name"=>"c_campaign","colum_value"=>"description")
	  );

	$column2 = array
	  (
	        array("colum_name"=>"Campaign ID","table_name"=>"c_campaign","colum_value"=>"campaignID"),
		array("colum_name"=>"Campaign Name","table_name"=>"c_campaign","colum_value"=>"campaignname"),
		array("colum_name"=>"Campaign Status","table_name"=>"c_campaign","colum_value"=>"campaignstatus"),
		//array("colum_name"=>"Product","table_name"=>"c_campaign","colum_value"=>"product"),
		//array("colum_name"=>"Expected Close Date","table_name"=>"c_lead","colum_value"=>"closingdate"),
		array("colum_name"=>"Sponsor","table_name"=>"c_campaign","colum_value"=>"sponsor"),
		//array("colum_name"=>"Assigned To","table_name"=>"c_campaign","colum_value"=>"assignedTo"),
		array("colum_name"=>"Campaign Type","table_name"=>"c_campaign","colum_value"=>"campaigntype"),
		array("colum_name"=>"Target Audience","table_name"=>"c_campaign","colum_value"=>"targetaudience"),
		array("colum_name"=>"Target Size","table_name"=>"c_campaign","colum_value"=>"targetsize"),
		array("colum_name"=>"Num Sent (%)","table_name"=>"c_campaign","colum_value"=>"numsent"),
		array("colum_name"=>"Budget Cost","table_name"=>"c_campaign","colum_value"=>"budgetcost"),
		array("colum_name"=>"Expected Response","table_name"=>"c_campaign","colum_value"=>"expectedresponse"),
		array("colum_name"=>"Expected Sales Count","table_name"=>"c_campaign","colum_value"=>"expectedsalescount"),
		array("colum_name"=>"Expected ROi","table_name"=>"c_campaign","colum_value"=>"expectedroi"),
		array("colum_name"=>"Expected Revenue","table_name"=>"c_campaign","colum_value"=>"expectedrevenue"),
                array("colum_name"=>"Actual Sales Count","table_name"=>"c_campaign","colum_value"=>"actualsalescount"),
                array("colum_name"=>"Actual Response Count","table_name"=>"c_campaign","colum_value"=>"expectedresponsecount"),
                array("colum_name"=>"Actual ROI","table_name"=>"c_campaign","colum_value"=>"actualroi")
	 
	  );

}else if($_GET['type'] == 'Quote'){

        $ThisPageName = 'viewQuote.php?module='.$_GET['type'];
	$column = array
	  (
		array("colum_name"=>"Quote ID","table_name"=>"c_quotes","colum_value"=>"quoteid"),
		array("colum_name"=>"Subject","table_name"=>"c_quotes","colum_value"=>"subject"),
		array("colum_name"=>"Customer Type","table_name"=>"c_quotes","colum_value"=>"CustType"),
		array("colum_name"=>"Quote Stage","table_name"=>"c_quotes","colum_value"=>"quotestage"),
		array("colum_name"=>"Carrier","table_name"=>"c_quotes","colum_value"=>"carrier"),
		array("colum_name"=>"Assigned To","table_name"=>"c_quotes","colum_value"=>"assignTo"),
		array("colum_name"=>"Created Date","table_name"=>"c_quotes","colum_value"=>"PostedDate"),
		array("colum_name"=>"Valid Till","table_name"=>"c_quotes","colum_value"=>"validtill"),
		array("colum_name"=>"Shipping","table_name"=>"c_quotes","colum_value"=>"shipping")
		
	  );

	$column2 = array
	  (
	        array("colum_name"=>"Quote ID","table_name"=>"c_quotes","colum_value"=>"quoteid"),
		array("colum_name"=>"Subject","table_name"=>"c_quotes","colum_value"=>"subject"),
		//array("colum_name"=>"Customer Type","table_name"=>"c_quotes","colum_value"=>"CustType"),
		array("colum_name"=>"Quote Stage","table_name"=>"c_quotes","colum_value"=>"quotestage"),
		array("colum_name"=>"Carrier","table_name"=>"c_quotes","colum_value"=>"carrier"),
		//array("colum_name"=>"Assigned To","table_name"=>"c_quotes","colum_value"=>"assignTo"),
		//array("colum_name"=>"Valid Till","table_name"=>"c_quotes","colum_value"=>"validtill"),
		array("colum_name"=>"Shipping","table_name"=>"c_quotes","colum_value"=>"shipping")
	 
	  );

}else if($_GET['type'] == 'Document'){

        $ThisPageName = 'viewDocument.php?module='.$_GET['type'];
	$column = array
	  (
		 array("colum_name"=>"Document ID","table_name"=>"c_document","colum_value"=>"documentID"),
		array("colum_name"=>"Title","table_name"=>"c_document","colum_value"=>"title"),
		array("colum_name"=>"Assigned To","table_name"=>"c_campaign","colum_value"=>"sponsor"),
		array("colum_name"=>"Created On","table_name"=>"c_document","colum_value"=>"validtill"),
                array("colum_name"=>"Status","table_name"=>"c_document","colum_value"=>"Status"),
		array("colum_name"=>"Download","table_name"=>"c_document","colum_value"=>"FileName"),
                array("colum_name"=>"Description","table_name"=>"c_document","colum_value"=>"description")
		
	  );

	$column2 = array
	  (
	        array("colum_name"=>"Document ID","table_name"=>"c_document","colum_value"=>"documentID"),
		array("colum_name"=>"Title","table_name"=>"c_document","colum_value"=>"title"),
		array("colum_name"=>"Assigned To","table_name"=>"c_campaign","colum_value"=>"sponsor"),
		array("colum_name"=>"Created On","table_name"=>"c_document","colum_value"=>"validtill"),
                array("colum_name"=>"Status","table_name"=>"c_document","colum_value"=>"Status"),
		array("colum_name"=>"Download","table_name"=>"c_document","colum_value"=>"FileName"),
                array("colum_name"=>"Description","table_name"=>"c_document","colum_value"=>"description")
	 
	  );

}else if($_GET['type'] == 'Activity'){

        $ThisPageName = 'viewActivity.php?module=Activity';
	$column = array
	  (
                array("colum_name"=>"Activity ID","table_name"=>"c_document","colum_value"=>"activityID"),
                array("colum_name"=>"Subject","table_name"=>"c_document","colum_value"=>"subject"),
                array("colum_name"=>"Assigned To","table_name"=>"c_campaign","colum_value"=>"assignedTo"),
                array("colum_name"=>"Start Date & Time","table_name"=>"c_document","colum_value"=>"startDate"),
                array("colum_name"=>"End Date & Time","table_name"=>"c_document","colum_value"=>"closeDate"),
                array("colum_name"=>"Status","table_name"=>"c_document","colum_value"=>"status"),
                array("colum_name"=>"Activity Type","table_name"=>"c_document","colum_value"=>"activityType"),
                array("colum_name"=>"Priority","table_name"=>"c_document","colum_value"=>"priority"),
                array("colum_name"=>"Send Notification ","table_name"=>"c_document","colum_value"=>"Notification"),
                array("colum_name"=>"Visibility","table_name"=>"c_document","colum_value"=>"visibility"),
                array("colum_name"=>"Send Reminder","table_name"=>"c_document","colum_value"=>"reminder"),
                //array("colum_name"=>"Invite Employee","table_name"=>"c_document","colum_value"=>"description"),
                array("colum_name"=>"Related Type","table_name"=>"c_document","colum_value"=>"RelatedType")
		
	  );

	$column2 = array
	  (
	        array("colum_name"=>"Activity ID","table_name"=>"c_document","colum_value"=>"activityID"),
                array("colum_name"=>"Subject","table_name"=>"c_document","colum_value"=>"subject"),
                // array("colum_name"=>"Assigned To","table_name"=>"c_campaign","colum_value"=>"assignedTo"),
                //array("colum_name"=>"Start Date & Time","table_name"=>"c_document","colum_value"=>"startDate"),
                //array("colum_name"=>"End Date & Time","table_name"=>"c_document","colum_value"=>"closeDate"),
                array("colum_name"=>"Status","table_name"=>"c_document","colum_value"=>"status"),
                array("colum_name"=>"Activity Type","table_name"=>"c_document","colum_value"=>"activityType"),
                array("colum_name"=>"Priority","table_name"=>"c_document","colum_value"=>"priority"),
                //array("colum_name"=>"Send Notification ","table_name"=>"c_document","colum_value"=>"Notification"),
                array("colum_name"=>"Visibility","table_name"=>"c_document","colum_value"=>"visibility"),
                //array("colum_name"=>"Send Reminder","table_name"=>"c_document","colum_value"=>"reminder"),
                //array("colum_name"=>"Invite Employee","table_name"=>"c_document","colum_value"=>"description"),
                array("colum_name"=>"Related Type","table_name"=>"c_document","colum_value"=>"RelatedType")
	 
	  );

}else if($_GET['type'] == 'RMA'){

        $ThisPageName = 'viewCreateRMA.php';
	$column = array
	  (
                array("colum_name"=>"Invoice Number","table_name"=>"s_order","colum_value"=>"InvoiceID"),
                array("colum_name"=>"Sku","table_name"=>"s_order","colum_value"=>"SKU"),
                array("colum_name"=>"Serial","table_name"=>"s_order","colum_value"=>"Serial"),
                array("colum_name"=>"Qty","table_name"=>"s_order","colum_value"=>"Qty"),
                array("colum_name"=>"Credit or Replacement","table_name"=>"s_order","colum_value"=>"type"),
                array("colum_name"=>"Comment","table_name"=>"s_order","colum_value"=>"comment")
             
		
	  );

	$column2 = array
	  (
	      array("colum_name"=>"Invoice Numberr","table_name"=>"s_order","colum_value"=>"InvoiceID"),
                array("colum_name"=>"Sku","table_name"=>"s_order","colum_value"=>"SKU"),
                array("colum_name"=>"Serial","table_name"=>"s_order","colum_value"=>"Serial"),
                array("colum_name"=>"Qty","table_name"=>"s_order","colum_value"=>"Qty"),
                array("colum_name"=>"Credit or Replacement","table_name"=>"s_order","colum_value"=>"type"),
                array("colum_name"=>"Comment","table_name"=>"s_order","colum_value"=>"comment")
	 
	  );

}


$adv_filter_options = array("e" => "equals",
	"n" => "not equal to",
	"s" => "starts with",
	"ew" => "ends with",
	"c" => "contains",
	"k" => "does not contain",
	"l" => "less than",
	"g" => "greater than",
	"m" => "less or equal",
	"h" => "greater or equal",
	"b" => "before",
	"a" => "after",
	"bw" => "between"
);


/********************************/
/********************************/

if($ThisPageName=='viewUsers.php'){ //done
	$RightArray = array
	(
		array("label" => "User Code",  "value" => "e.EmpCode"),
		array("label" => "Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
		array("label" => "Email",  "value" => "e.Email")
	); 
}
/*******************/
if(!empty($RightArray)){
	foreach($RightArray as $values){
		$arryRightCol[] = $values['value'];
	}
}
$arryRightOrder = array('Asc','Desc');
/*******************/
if(!empty($_GET['sortby'])){
	if(!in_array($_GET['sortby'],$arryRightCol)){
		$_GET['sortby']='';
	}
}
if(!empty($_GET['asc'])){
	if(!in_array($_GET['asc'],$arryRightOrder)){
		$_GET['asc']='';
	}
}
/*****************/
?>
