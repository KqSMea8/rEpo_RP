<?php
	/**************************************************/
	$ThisPageName = 'viewLeaveRule.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once("includes/FieldArray.php");
	$objLeave=new leave();
	$objEmployee=new employee();
	$objCommon=new common();

	$RedirectUrl ="viewLeaveRule.php?curP=".$_GET['curP'];
	$ModuleName = "Custom Rule";	

	function getOperator($key, $arry) {
		for ($i = 0; $i < sizeof($arry); $i++) {  
			if($arry[$i]["col_value"] == $key){
				$returnVal = $arry[$i]["col_opt"];
				break;
			}			
		}
		return $returnVal;
	}



	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_rule'] = CUST_RULE_REMOVED;
		$objLeave->deleteCustomRule($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_rule'] = CUST_RULE_STATUS_CHANGED;
		$objLeave->changeCustomRuleStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST){
		CleanPost(); 
		/*********Days************/
		for($i=0;$i<sizeof($_POST['Days']);$i++){
		 	if($_POST['Days'][$i]>0){
				$LeaveAllowed .= $_POST['LeaveType'][$i].':'.$_POST['Days'][$i].'#';
			}
		}
		$_POST['LeaveAllowed'] = rtrim($LeaveAllowed,"#");
		/*********RuleOn*************/
		$RuleOnVal = ''; $RuleOppVal = ''; $RuleValueVal = ''; $RuleUnitVal = '';
		for($i=0;$i<sizeof($_POST['RuleOn']);$i++){
		 	if(!empty($_POST['RuleOn'][$i])){
				$RuleOnVal .= $_POST['RuleOn'][$i].'#';
				$RuleOppVal .= $_POST['RuleOpp'][$i].'#';
				$RuleValueVal .= $_POST['RuleValue'][$i].'#';
				$RuleUnitVal .= $_POST['RuleUnit'][$i].'#';
			}
		}
		$_POST['RuleOn'] = rtrim($RuleOnVal,"#");
		$_POST['RuleOpp'] = rtrim($RuleOppVal,"#");
		$_POST['RuleValue'] = rtrim($RuleValueVal,"#");
		$_POST['RuleUnit'] = rtrim($RuleUnitVal,"#");


		if(!empty($_POST['RuleID'])) {
			$objLeave->updateCustomRule($_POST);
			$_SESSION['mess_rule'] = CUST_RULE_UPDATED;
		}else{		
			$objLeave->addCustomRule($_POST);
			$_SESSION['mess_rule'] = CUST_RULE_ADDED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryCustomRule = $objLeave->getCustomRule($_GET['edit'],'');
		$Status   = $arryCustomRule[0]['Status'];
	}

	$arryJobType = $objCommon->GetAttributeValue('JobType','');
	$arryLeaveType = $objCommon->GetAttributeValue('LeaveType','');

	
	$NumLine=5;

	require_once("../includes/footer.php"); 

?>
