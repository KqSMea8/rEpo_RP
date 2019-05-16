<?php 
$RightArray='';

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
}else if($ThisPageName=='viewHelp.php'){
	$RightArray = array
	(
		array("label" => "Heading",  "value" => "w.Heading"),
		array("label" => "Category Name",  "value" => "c.CategoryName")
	); 
}else if($ThisPageName=='viewSecurityQuestion.php'){
	$OptionArray = array
	(
		array("label" => "Employee Name",  "value" => "UserName#h_employee"),
		array("label" => "Gender",  "value" => "Gender#h_employee"),
		array("label" => "Employee Code",  "value" => "EmpCode#h_employee"),
		array("label" => "Date of Birth",  "value" => "date_of_birth#h_employee"),
		array("label" => "Mobile Number",  "value" => "Mobile#h_employee"),
		array("label" => "Emergency Mobile Number",  "value" => "Mobile#h_emergency"),
		
		array("label" => "Marital Status",  "value" => "MaritalStatus#h_employee"),
		array("label" => "Nationality",  "value" => "Nationality#h_employee"),
		array("label" => "Blood Group",  "value" => "BloodGroup#h_employee"),
		array("label" => "UnderGraduate Qualification",  "value" => "UnderGraduate#h_employee"),
		array("label" => "ID Type",  "value" => "ImmigrationType#h_employee"),
		array("label" => "ID Expiry Date",  "value" => "ImmigrationExp#h_employee")
	); 
}
  
					 


/*******************/
if(!empty($RightArray)){
	foreach($RightArray as $values){
		$arryRightCol[] = $values['value'];
	}

	$arryRightOrder = array('Asc','Desc');
}
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
