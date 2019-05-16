<?php 

if($ThisPageName=='viewUserLog.php'){ //done
	$RightArray = array
	(
		array("label" => "User Name",  "value" => "e.UserName"),
		array("label" => "Email",  "value" => "e.Email"),		
        	array("label" => "IP Address",  "value" => "u.LoginIP")
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


/*************************************/
/*************************************/








?>

