<?php
	/**************************************************/
        $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
	 
	$objReport = new report();

	$depID = 8;
	$ModuleName = 'Period End Setting';
	$ListUrl = "periodEndSetting.php";  
        

	function getMonthOption($MinMonth,$val){
		$Month_String='';		
		if($val==$MinMonth){
			$month = date('F', mktime(0,0,0,$val, 1, date('Y')));
			$Month_String .= '<option value="'.$val.'" > '.$month.' </option>';
		}
		return $Month_String;
	}



	if(!empty($_GET['active_id'])){		
		$objReport->changePeriodStatus($_GET['active_id']);		
		$ListUrl = "periodEndSetting.php";  
		header("location:".$ListUrl);
		exit;
	}

	if(!empty($_GET['CloseYear'])){
		$_SESSION['mess_setting'] = PERIOD_YEAR_CLOSED;
		$objReport->AddUpdatePeriodYear($_GET['CloseYear'],'Closed');
		
		$ListUrl = "periodEndSetting.php";  
		header("location:".$ListUrl);
		exit;
	}


	if(!empty($_GET['OpenYear'])){
		if($objReport->isNextYearClosed($_GET['OpenYear'])){
			//next year closed
		}else{
			$_SESSION['mess_setting'] = PERIOD_YEAR_OPENED;
			$objReport->AddUpdatePeriodYear($_GET['OpenYear'],'Open');	
		}
		$ListUrl = "periodEndSetting.php";  
		header("location:".$ListUrl);
		exit;
	}



	if(!empty($_POST)){	 
		CleanPost();
		if(!empty($_POST['PrevYearClose'])){ 
			$_SESSION['mess_setting'] = PERIOD_YEAR_CLOSED;
			$objReport->AddUpdatePeriodYear($_POST['PrevYearClose'],'Closed');
		}else{	 
			$_SESSION['mess_setting'] = PERIOD_UPDATED;
			$objReport->AddUpdatePeriodSetting($_POST);
		}
		header("location:".$ListUrl);
		exit;
	}     
               
        

	$ARCurrentPeriod =  $objReport->getCurrentPeriodDate('AR'); 
	$APCurrentPeriod =  $objReport->getCurrentPeriodDate('AP'); 
	$GLCurrentPeriod =  $objReport->getCurrentPeriodDate('GL');
	$INVCurrentPeriod =  $objReport->getCurrentPeriodDate('INV'); 

	$FiscalYearStartDate = $objReport->getSettingVar('FiscalYearStartDate');
	$FiscalYearEndDate = $objReport->getSettingVar('FiscalYearEndDate');
	
	$PrevMonth='';
	$PrevYear='';
	$PrevPeriodModule='';
	(empty($_GET['PeriodYear']))?($_GET['PeriodYear']=""):(""); 
	(empty($_GET['PeriodMonth']))?($_GET['PeriodMonth']=""):(""); 
	(empty($_GET['PeriodModule']))?($_GET['PeriodModule']=""):(""); 

	if($FiscalYearStartDate == "" || $FiscalYearEndDate == "") {
		$ErrorMsg  = SETUP_FISCAL_YEAR;
	}else{
		$arryFiscal = explode("-",$FiscalYearStartDate);
		$CurrentYearFiscal =  $arryFiscal[0];
		$CurrentMonthFiscal =  $arryFiscal[1];

		$arryARPeriod = explode("-",$ARCurrentPeriod); 
		$arryAPPeriod = explode("-",$APCurrentPeriod);
		$arryGLPeriod = explode("-",$GLCurrentPeriod);
		$arryINVPeriod = explode("-",$INVCurrentPeriod);

		//if all dates are same
		if($ARCurrentPeriod==$APCurrentPeriod && $GLCurrentPeriod==$INVCurrentPeriod && $ARCurrentPeriod==$INVCurrentPeriod){	
			//get previous year to close
			$PrevPeriod = date('Y-m-d', mktime(0, 0, 0, $arryARPeriod[1]-1, 1, $arryARPeriod[0]));
			$arryPrevPeriod = explode("-",$PrevPeriod); 
			$PrevMonth = $arryPrevPeriod[1];
			$PrevYear = $arryPrevPeriod[0];

			$PrevYearStatus = $objReport->GetPeriodYearStatus($PrevYear);
 			$PeriodMonthExist = $objReport->isPeriodMonthExist($PrevYear);

		}
		$MinMonth = min($arryARPeriod[1],$arryAPPeriod[1],$arryGLPeriod[1],$arryINVPeriod[1]);
		 
	}  



	

 	require_once("../includes/footer.php"); 
 ?>
