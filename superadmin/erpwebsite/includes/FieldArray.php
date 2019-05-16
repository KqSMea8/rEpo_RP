<?php 
if($ThisPageName=='viewCompany.php'){
	$RightArray = array
	(
		array("label" => "Company Name",  "value" => "c.CompanyName"),
		array("label" => "Company ID",  "value" => "c.CmpID"),
		array("label" => "Display Name",  "value" => "c.DisplayName"),
		array("label" => "Email",  "value" => "c.Email"),
		array("label" => "Package",  "value" => "c.PaymentPlan")
	); 
}else if($ThisPageName=='paymentHistory.php'){
	$RightArray = array
	(
		array("label" => "Company Name",  "value" => "c.CompanyName"),
		array("label" => "Company ID",  "value" => "c.CmpID"),
		array("label" => "Display Name",  "value" => "c.DisplayName")
		
	); 

}else if($ThisPageName=='orderHistory.php'){
	$RightArray = array
	(
		array("label" => "Reseller Name",  "value" => "r.FullName"),
		array("label" => "Company Name",  "value" => "c.CompanyName"),
		array("label" => "Company ID",  "value" => "c.CmpID"),
		array("label" => "Display Name",  "value" => "c.DisplayName")
	); 

}else if($ThisPageName=='viewReseller.php'){
	$RightArray = array
	(
		array("label" => "Reseller Name",  "value" => "r.FullName"),
		array("label" => "Reseller ID",  "value" => "r.RsID"),
		array("label" => "Email",  "value" => "r.Email"),
		array("label" => "Company Name",  "value" => "r.CompanyName")
	); 
}



/*******************/
foreach($RightArray as $values){
	$arryRightCol[] = $values['value'];
}

$arryRightOrder = array('Asc','Desc');
/*******************/
if(!in_array($_GET['sortby'],$arryRightCol)){
	$_GET['sortby']='';
}
if(!in_array($_GET['asc'],$arryRightOrder)){
	$_GET['asc']='';
}
/*****************/



?>
