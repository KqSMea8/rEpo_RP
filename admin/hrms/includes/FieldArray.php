<?php 
$RightArray='';

if($ThisPageName=='viewEmployee.php'){
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "e.EmpCode"),
		array("label" => "Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
		array("label" => "Email",  "value" => "e.Email"),
		array("label" => "Department",  "value" => "d.Department")
	); 
}else if($ThisPageName=='viewLeave.php'){
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "em.EmpCode"),
		array("label" => "Employee Name",  "value" => "em.UserName"),
		array("label" => "Designation",  "value" => "em.JobTitle"),
		array("label" => "Department",  "value" => "d.Department"),
		array("label" => "Leave Type",  "value" => "l.LeaveType"),
		array("label" => "Days",  "value" => "l.Days"),
		array("label" => "Comment",  "value" => "l.Comment"),
		array("label" => "Status",  "value" => "l.Status")
	); 
}else if($ThisPageName=='viewEntitlement.php'){
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "em.EmpCode"),
		array("label" => "Employee Name",  "value" => "em.UserName"),
		array("label" => "Department",  "value" => "d.Department"),
		array("label" => "Designation",  "value" => "em.JobTitle"),
		array("label" => "Job Type",  "value" => "em.JobType"),
		array("label" => "LeaveType",  "value" => "e.LeaveType")
	); 
}else if($ThisPageName=='viewVacancy.php'){
	$RightArray = array
	(
		array("label" => "Job Title",  "value" => "v.JobTitle"),
		array("label" => "Vacancy Name",  "value" => "v.Name"),
		array("label" => "Department",  "value" => "d.Department"),
		array("label" => "Hiring Manager",  "value" => "e.UserName"),
		array("label" => "No of Position",  "value" => "v.NumPosition"),
		array("label" => "Hired",  "value" => "v.Hired"),
		array("label" => "Status",  "value" => "v.Status")
	); 
}else if(strpos($ThisPageName,'Candidate.php')>0){
	$RightArray = array
	(
		array("label" => "Candidate Name",  "value" => "c.UserName"),
		array("label" => "Email",  "value" => "c.Email"),
		array("label" => "Contact Number",  "value" => "c.Mobile"),
		array("label" => "Vacancy",  "value" => "v.Name")
	); 
}else if($ThisPageName=='viewSalary.php'){
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "e.EmpCode"),
		array("label" => "Employee Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle")	
	); 
}else if($ThisPageName=='viewDeclaration.php'){
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "e.EmpCode"),
		array("label" => "Employee Name",  "value" => "e.UserName"),
		array("label" => "Department",  "value" => "d.Department"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
		array("label" => "Year",  "value" => "s.Year")	
	); 
}else if($ThisPageName=='viewAdvance.php' || $ThisPageName=='viewLoan.php' || $ThisPageName=='viewBonus.php'){
	$RightArray = array
	(
		array("label" => "Emp Code",  "value" => "e.EmpCode"),
		array("label" => "Employee Name",  "value" => "e.UserName"),
		array("label" => "Department",  "value" => "d.Department")
	); 
}else if($ThisPageName=='viewKra.php'){
	$RightArray = array
	(
		array("label" => "KRA Title",  "value" => "heading"),
		array("label" => "Job Title",  "value" => "JobTitle"),
		array("label" => "Minimum Rating",  "value" => "MinRating"),
		array("label" => "Maximum Rating",  "value" => "MaxRating"),
		array("label" => "Status",  "value" => "Status")	
	); 
}else if($ThisPageName=='viewReview.php'){
	$RightArray = array
	(
		array("label" => "Employee",  "value" => "e.UserName"),
		array("label" => "Job Title",  "value" => "e.JobTitle"),
		array("label" => "Reviewer",  "value" => "e2.UserName"),
		array("label" => "Status",  "value" => "r.Status")	
	); 
}else if($ThisPageName=='viewTraining.php'){
	$RightArray = array
	(
		array("label" => "Training ID",  "value" => "t.trainingID"),
		array("label" => "Course Name",  "value" => "t.CourseName"),
		array("label" => "Company",  "value" => "t.Company"),
		array("label" => "Coordinator",  "value" => "e.UserName")	
	); 
}else if($ThisPageName=='viewNews.php'){
	$RightArray = array
	(
		array("label" => "Heading",  "value" => "heading"),
		array("label" => "Detail",  "value" => "detail")	
	); 
}else if($ThisPageName=='viewDocument.php'){
	$RightArray = array
	(
		array("label" => "Document Title",  "value" => "heading"),
		array("label" => "Description",  "value" => "detail"),	
		array("label" => "Publish",  "value" => "publish")
	); 
}else if($ThisPageName=='viewAsset.php'){
	$RightArray = array
	(
		array("label" => "Tag ID",  "value" => "a.TagID"),
		array("label" => "Serial Number",  "value" => "a.SerialNumber"),	
		array("label" => "Asset Name",  "value" => "a.AssetName"),
		array("label" => "Model",  "value" => "a.Model"),
		array("label" => "Assigned To",  "value" => "e.UserName")
	); 
}else if($ThisPageName=='viewAssignAsset.php'){
	$RightArray = array
	(
		array("label" => "Asset Name",  "value" => "a.AssetName"),
		array("label" => "Assigned To",  "value" => "a.EmpName")
	); 
}else if($ThisPageName=='viewDirectory.php'){
	$RightArray = array
	(
		array("label" => "Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
		array("label" => "Department",  "value" => "d.Department"),
		array("label" => "Mobile",  "value" => "e.Mobile"),
		array("label" => "Email",  "value" => "e.Email")
		
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


$PayCycleArray = array("Daily","Weekly","Bi-Weekly","Semi-Monthly","Monthly");

$RuleOn = array
(
	array("col_name" => "Probation Period",  "col_value" => "P"),
	array("col_name" => "Employment Period",  "col_value" => "E"),
	array("col_name" => "Joining Date",  "col_value" => "J"),
	array("col_name" => "Hrs Worked",  "col_value" => "H"),
	array("col_name" => "Days Worked",  "col_value" => "D"),
	array("col_name" => "Calendar Days",  "col_value" => "C")
); 

$RuleOpp = array
(
	array("col_name" => "Equal to",  "col_value" => "E", "col_opt" => "="),
	array("col_name" => "Greater than",  "col_value" => "G", "col_opt" => ">"),
	array("col_name" => "Greater equal to",  "col_value" => "GE", "col_opt" => ">="),
	array("col_name" => "Less than",  "col_value" => "L", "col_opt" => "<"),
	array("col_name" => "Less equal to",  "col_value" => "LE", "col_opt" => "<="),
	array("col_name" => "Not equal to",  "col_value" => "NE", "col_opt" => "!=")
);

(empty($_GET['type']))?($_GET['type']=""):(""); 


if ($_GET['type'] == 'hrms') {
   
    $column = array
        (        
         array("colum_name" => "Employee Number", "colum_value" => "EmpCode" ),
        array("colum_name" => "Employee Name", "colum_value" => "UserName"),
        array("colum_name" => "Job Title", "colum_value" => "JobTitle"),
        array("colum_name" => "Department", "colum_value" => "Department"),   
       // array("colum_name" => "Date", "colum_value" => "attDate")
        //array("colum_name" => "In time", "colum_value" => "InTime"),
        //array("colum_name" => "Out time", "colum_value" => "OutTime"),
        //array("colum_name" => "In Comment", "colum_value" => "InComment"),
        //array("colum_name" => "Out Comment", "colum_value" => "OutComment"),
        //array("colum_name" => "Breaks", "colum_value" => "breaks"),
        //array("colum_name" => "Duration", "colum_value" => "Duration")
        //array("colum_name" => "Overtime", "colum_value" => "lead_source")

    );

  
} 

?>
