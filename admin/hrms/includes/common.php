<?
/*****Variable Define & Default Array for empty edit********/
/****************************/  
(empty($_GET['Department']))?($_GET['Department']=""):("");
(empty($_GET['d']))?($_GET['d']=""):("");	
(empty($_GET['depID']))?($_GET['depID']=""):("");
(empty($_GET['emp']))?($_GET['emp']=""):("");
(empty($_GET['dv']))?($_GET['dv']=""):("");
(empty($_GET['dt']))?($_GET['dt']=""):("");
(empty($_GET['CustomReport']))?($_GET['CustomReport']=""):("");
(empty($EmpDisplay))?($EmpDisplay=""):("");
(empty($YearStart))?($YearStart=""):("");
(empty($YearEnd))?($YearEnd=""):("");
$HideStatus=$HideFlag=$Address='';
  
 //echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){
	switch ($MainModuleID) {
		case '52': 
			$arryEmployee = $objConfigure->GetDefaultArrayValue('h_employee');
			$ArryEmergency = $objConfigure->GetDefaultArrayValue('h_emergency');
			break;		 
		case '70': 
			$arryLeave = $objConfigure->GetDefaultArrayValue('h_leave'); 				break;
		case '71': 
			$arryDocument = $objConfigure->GetDefaultArrayValue('h_document'); 				break;
		case '75': 
			$arryLeave = $objConfigure->GetDefaultArrayValue('h_leave'); 				break;
		case '72': 
			$arryNews = $objConfigure->GetDefaultArrayValue('h_news'); 				break;	
		case '73': 
			$arryHoliday = $objConfigure->GetDefaultArrayValue('h_holiday'); 				break;		
		case '69': 
			$arryVacancy = $objConfigure->GetDefaultArrayValue('h_vacancy'); 				break;
		case '77': 
			$arryCandidate = $objConfigure->GetDefaultArrayValue('h_candidate'); 				break;
		case '2021':
			$arrayReport = $objConfigure->GetDefaultArrayValue('h_report_rule'); 				 
			break;
		case '84':
			$arryKra = $objConfigure->GetDefaultArrayValue('h_kra'); 				break;
		case '85':
			$arryReview = $objConfigure->GetDefaultArrayValue('h_review');
 				break;
		case '86':
			$arryHead = $objConfigure->GetDefaultArrayValue('h_pay_head'); 				break;
		case '1001':
			$arryAdvance = $objConfigure->GetDefaultArrayValue('h_advance'); 				break;
		case '1003': 
			$arryAdvance = $objConfigure->GetDefaultArrayValue('h_advance'); 				break;
		case '1002':
			$arryLoan = $objConfigure->GetDefaultArrayValue('h_loan'); 				break;
		case '1007':
			$arryBonus = $objConfigure->GetDefaultArrayValue('h_bonus'); 				break;
		case '1019':
			$arryReimbursement = $objConfigure->GetDefaultArrayValue('h_reimbursement');

			$arryReimbursementItem = $objConfigure->GetDefaultArrayValue('h_reimbursement_item');
			break;
		case '1020':  
			$arryReimbursement = $objConfigure->GetDefaultArrayValue('h_reimbursement');
			$arryReimbursementItem = $objConfigure->GetDefaultArrayValue('h_reimbursement_item');
			break;
		case '2020':  
			$arryCustomRule = $objConfigure->GetDefaultArrayValue('h_leave_rule');
			break;
		case '94':
			$arryTraining = $objConfigure->GetDefaultArrayValue('h_training'); 				break;
		case '96':
			$arryAsset = $objConfigure->GetDefaultArrayValue('h_asset'); 				break;	
		case '87':
			$arrySalary = $objConfigure->GetDefaultArrayValue('h_salary'); 				break;	
		case '1018':
			$arryShift = $objConfigure->GetDefaultArrayValue('h_shift');
  			break;
		case '2007':
			$arryTier = $objConfigure->GetDefaultArrayValue('h_tier');
  			break;
		case '2010':
			$arryTier = $objConfigure->GetDefaultArrayValue('h_spiff'); 
  			break;
		case '2018':
			$arryBenefit = $objConfigure->GetDefaultArrayValue('h_benefit'); 
  			break;
		case '2024':
			$arryTaxDeduction = $objConfigure->GetDefaultArrayValue('h_taxdeduction');
			$arryBracket = $objConfigure->GetDefaultArrayValue('h_tax_bracket');
			$arryBracketLine =  $objConfigure->GetDefaultArrayValue('h_tax_bracket_line');
  			break;

		case '2060':
			$arryDeduction = $objConfigure->GetDefaultArrayValue('h_deduction'); 
  			break;
		case '2061':
			$arryDeductionRule = $objConfigure->GetDefaultArrayValue('h_deduction_rule'); 
  			break;


		 	
	}
	 
}

/****************************/
/****************************/


?>
