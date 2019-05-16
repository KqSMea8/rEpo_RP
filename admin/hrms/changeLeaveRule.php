<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once("includes/FieldArray.php");
	$objLeave=new leave();
	$objEmployee=new employee();

	$ModuleName = "Custom Rule";	
	$RedirectUrl = "changeLeaveRule.php?emp=".$_GET['emp']."&curP=".$_GET['curP'];
	

	function getArrayName($key, $arry) {
		for ($i = 0; $i < sizeof($arry); $i++) {  
			if($arry[$i]["col_value"] == $key){
				$returnVal = $arry[$i]["col_name"];
				break;
			}			
		}
		return $returnVal;
	}




	if($_GET['emp']>0){

		$arryEmployee = $objEmployee->GetEmployeeBrief($_GET['emp']);


		if($_GET['rule_id'] && !empty($_GET['rule_id'])){			
			$objLeave->changeCustomRuleEmp($_GET['rule_id'],$_GET['emp']);
			header("location:".$RedirectUrl);
			exit;
		}

		if(!empty($arryEmployee[0]['JobType'])){
			//$arryCustomRule=$objLeave->getCustomRule('','1');
			$arryCustomRule=$objLeave->getRuleByType($arryEmployee[0]['JobType'],'');
		}


		$num=sizeof($arryCustomRule);

		$pagerLink=$objPager->getPager($arryCustomRule,$RecordsPerPage,$_GET['curP']);
		(count($arryCustomRule)>0)?($arryCustomRule=$objPager->getPageRecords()):("");

	}	

	require_once("../includes/footer.php");
?>

