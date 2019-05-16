<?php 
 $RightArray='';                        
if($SelfPage=='viewItem.php'){
	$RightArray = array
	(
		array("label" => "Sku",  "value" => "p1.Sku"),
		array("label" => "Item Description",  "value" => "p1.description"),
		//array("label" => "Track Inventory",  "value" => "p1.non_inventory"),
		//array("label" => "Valuation Method",  "value" => "p1.evaluationType"),
		//array("label" => "Item Type",  "value" => "p1.itemType"),
	//	array("label" => "Qty on Hand",  "value" => "p1.qty_on_hand"),
		//array("label" => "Status",  "value" => "p1.Status")
	); 
}else if($ThisPageName=='viewCategory.php'){
	$RightArray = array
	(
		array("label" => "Category Name",  "value" => "c1.Name"),
		array("label" => "Status",  "value" => "c1.Status")
	); 
}else if($ThisPageName=='viewSerial.php'){     
	$RightArray = array
	(
				array("label" => "Item Sku",  "value" => "s.Sku"),
		//array("label" => "Warehouse Name",  "value" => "w.warehouse_name"),
				array("label" => "Serial Number",  "value" => "s.serialNumber"),
				array("label" => "Customer",  "value" => "o.CustomerName"),
				array("label" => "Customer Invoice",  "value" => "s.serialNumber"),
				array("label" => "Vendor",  "value" => "o.InvoiceID"),
				array("label" => "Vendor Invoice",  "value" => "pinv.InvoiceID"),
				array("label" => "Status",  "value" => "s.UsedSerial")
	); 
}else if($ThisPageName=='viewAdjustment.php'){
	$RightArray = array
	(
		array("label" => "Adjustment No",  "value" => "a.adjustNo"),
		array("label" => "Status",  "value" => "a.Status"),
     array("label" => "Sku",  "value" => "ast.sku")
	); 
}else if($ThisPageName=='viewTransfer.php'){
	$RightArray = array
	(    
		array("label" => "Transfer No",  "value" => "t.transferNo"),
		array("label" => "Status",  "value" => "t.Status")
	); 
}else if($ThisPageName=='viewBOM.php'){                     

	$RightArray = array(
		array("label" => "BOM No",  "value" => "b.Sku"),
		array("label" => "Description",  "value" => "b.description"),
		array("label" => "Bill With Option",  "value" => "b.bill_option")
	); 
}else if($ThisPageName=='viewAssemble.php'){
	$RightArray = array
	(
		array("label" => "Assemble No",  "value" => "a.asm_code"),
		array("label" => "Warehouse",  "value" => "w.warehouse_name"),
		array("label" => "Item Sku",  "value" => "a.Sku"),
		array("label" => "Item Description",  "value" => "i.description"),
		array("label" => "Status",  "value" => "a.Status")
	); 
}else if($ThisPageName=='viewDisassembly.php'){
	$RightArray = array
	(
		array("label" => "Bill Number",  "value" => "a.Sku"),
		array("label" => "Disassemble No",  "value" => "a.DsmCode"),
		array("label" => "Warehouse",  "value" => "w.warehouse_name"),
		array("label" => "Item Description",  "value" => "i.description"),
		array("label" => "Status",  "value" => "a.Status")
	); 
}else if($ThisPageName=='viewCondition.php'){
	$RightArray = array
	(
		array("label" => "Condition Name",  "value" => "c1.Name"),
		array("label" => "Status",  "value" => "c1.Status")
	); 
}else if($ThisPageName=='viewUser.php'){ //done
	$RightArray = array
	(
		array("label" => "User Code",  "value" => "e.EmpCode"),
		array("label" => "Name",  "value" => "e.UserName"),
		array("label" => "Designation",  "value" => "e.JobTitle"),
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
