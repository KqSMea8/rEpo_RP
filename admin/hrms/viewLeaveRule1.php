<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once("includes/FieldArray.php");
	$objLeave=new leave();
	$objEmployee=new employee();

	$ModuleName = "Custom Rule";	
	$RedirectUrl = "viewLeaveRule.php?curP=".$_GET['curP'];
	

	function getArrayName($key, $arry) {
		for ($i = 0; $i < sizeof($arry); $i++) {  
			if($arry[$i]["col_value"] == $key){
				$returnVal = $arry[$i]["col_name"];
				break;
			}			
		}
		return $returnVal;
	}


	$arryCustomRule=$objLeave->getCustomRule('','');
	$num=sizeof($arryCustomRule);

	$pagerLink=$objPager->getPager($arryCustomRule,$RecordsPerPage,$_GET['curP']);
	(count($arryCustomRule)>0)?($arryCustomRule=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php");
?>

