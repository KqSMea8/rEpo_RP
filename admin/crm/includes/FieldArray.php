<?php 
$RightArray='';

 
if($SelfPage=='viewLead.php'){ //done
	$RightArray = array
	(
		array("label" => "Lead Name",  "value" => "l.FirstName"),
		array("label" => "Company",  "value" => "l.company"),		
        	array("label" => "Primary Email",  "value" => "l.primary_email"),
		array("label" => "Sales Person",  "value" => "e.UserName"),
		array("label" => "Phone",  "value" => "l.LandlineNumber"),
		array("label" => "Status",  "value" => "l.lead_status")
	); 
}else if($SelfPage=='viewOpportunity.php'){ //done
	$RightArray = array
	(
		array("label" => "Opportunity Name",  "value" => "o.OpportunityName"),
		array("label" => "Sales Stage",  "value" => "o.SalesStage"),
		array("label" => "Lead Source",  "value" => "o.lead_source"),	
		array("label" => "Phone",  "value" => "l.LandlineNumber"),	
		array("label" => "Status",  "value" => "o.Status")
	); 
}else if($SelfPage=='viewTicket.php'){ //done
	$RightArray = array
	(
		array("label" => "Title",  "value" => "t.title"),
		array("label" => "Status",  "value" => "t.Status")
	); 
}else if($ThisPageName=='viewContact.php?module=contact'){ //done
	$RightArray = array
	(
		array("label" => "First Name",  "value" => "c.FirstName"),
		array("label" => "Last Name",  "value" => "c.LastName"),
		array("label" => "Email",  "value" => "c.Email"),
		array("label" => "Title",  "value" => "c.Title"),
		array("label" => "Assign To ",  "value" => "e.UserName"),
		array("label" => "Status",  "value" => "c.Status")
	); 
}else if($ThisPageName=='viewQuote.php?module=Quote'){ //done
	$RightArray = array
	(
		array("label" => "Subject",  "value" => "q.subject"),
		array("label" => "Quote Stage",  "value" => "q.quotestage")
	); 
}else if($ThisPageName=='viewActivity.php?module=Activity'){ //done
	$RightArray = array
	(
		array("label" => "Title",  "value" => "e.subject"),
		array("label" => "Activity Type",  "value" => "e.activityType"),
		array("label" => "Priority",  "value" => "e.priority"),
		array("label" => "Status",  "value" => "e.status")
	); 
}else if($ThisPageName=='viewDocument.php?module=Document'){ //done
	$RightArray = array
	(
		array("label" => "Title",  "value" => "d.title"),
		array("label" => "Status",  "value" => "d.Status")
	); 
}else if($ThisPageName=='viewCampaign.php?module=Campaign'){ //done
	$RightArray = array
	(
		array("label" => "Campaign Name",  "value" => "c.campaignname"),
		array("label" => "Campaign Type",  "value" => "c.campaigntype"),
		array("label" => "Campaign Status",  "value" => "c.campaignstatus"),
		array("label" => "Expected Revenue",  "value" => "c.expectedrevenue")
	); 
}else if($ThisPageName=='viewCustomer.php'){ //done
	$RightArray = array
	(
		array("label" => "Customer Code",  "value" => "c1.CustCode"),
		array("label" => "Customer",  "value" => "c1.FullName"),
		array("label" => "Email Address", "value" => "c1.Email"),
		array("label" => "Country",  "value" => "ab.CountryName"),
		array("label" => "State",  "value" => "ab.StateName"),
		array("label" => "Phone", "value" => "c1.Landline"),
		array("label" => "Status",  "value" => "c1.Status")
	); 
}else if($ThisPageName=='viewGroup.php'){ //done
	$RightArray = array
	(
		array("label" => "Group Name",  "value" => "group_name"),
		array("label" => "Status",  "value" => "Status")
	); 
}else if($ThisPageName=='chatlist.php'){ //done
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "e.EmpCode"),
		array("label" => "Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
		array("label" => "Email",  "value" => "e.Email"),
		array("label" => "Department",  "value" => "d.Department")
	); 
}else if($ThisPageName=='viewUser.php'){ //done
	$RightArray = array
	(
		array("label" => "User Code",  "value" => "e.EmpCode"),
		array("label" => "Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
		array("label" => "Email",  "value" => "e.Email")
	); 
}else if($ThisPageName=='viewItem.php'){ //done
	$RightArray = array
	(
		array("label" => "SKU",  "value" => "p1.Sku"),
		array("label" => "Item Name",  "value" => "p1.description"),
		array("label" => "Price",  "value" => "p1.sell_price"),
		array("label" => "Qty on Hand",  "value" => "p1.qty_on_hand"),
		array("label" => "Status",  "value" => "p1.Status")
	); 
}else if($ThisPageName=='viewImportedEmails.php' || $ThisPageName=='draftList.php' || 
        $ThisPageName=='sentEmails.php' || $ThisPageName=='spamEmail.php' || $ThisPageName=='trashEmail.php'){ //done
	$RightArray = array
	(
		array("label" => "Email",  "value" => "email"),
		array("label" => "Subject",  "value" => "subject"),
		array("label" => "Email Content",  "value" => "content")
	); 
}





$arryRightCol ='';

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


/*************************************/
/*************************************/




















(empty($_GET['type']))?($_GET['type']=""):(""); 





 if ($_GET['type'] == 'lead') {
   
    $column = array
        (        
        array("colum_name" => "First Name", "colum_value" => "FirstName" ),
        array("colum_name" => "Last Name", "colum_value" => "LastName"),
        array("colum_name" => "Company Name", "colum_value" => "company"),
        array("colum_name" => "Primary Email", "colum_value" => "primary_email"),   
        array("colum_name" => "Title", "colum_value" => "designation"),
        array("colum_name" => "Product", "colum_value" => "ProductID"),
        array("colum_name" => "Product Price", "colum_value" => "product_price"),
        array("colum_name" => "Website", "colum_value" => "Website"),
        array("colum_name" => "Industry", "colum_value" => "Industry"),
        array("colum_name" => "Annual Revenue [".$Config['Currency']."]", "colum_value" => "AnnualRevenue"),
        array("colum_name" => "Number of Employees", "colum_value" => "NumEmployee"),
        array("colum_name" => "Lead Source", "colum_value" => "lead_source"),        
        array("colum_name" => "Lead Status", "colum_value" => "lead_status"),
        array("colum_name" => "Address", "colum_value" => "Address"),
        array("colum_name" => "Zip Code", "colum_value" => "ZipCode"),
        array("colum_name" => "Landline Number", "colum_value" => "LandlineNumber"),
        array("colum_name" => "Mobile", "colum_value" => "Mobile"),
        array("colum_name" => "Description", "colum_value" => "description")
    );

  
} 
?>

