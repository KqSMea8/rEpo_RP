<?
	if(!empty($_GET['del_id'])){
		$_SESSION['mess_leave'] = LEAVE_REMOVED;
		$objLeave->deleteLeave($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		/********************************/
		CleanPost();  
		/********************************/
		
		if(!isset($_POST["FromDateHalf"])) $_POST["FromDateHalf"] = '';
		if(!isset($_POST["ToDateHalf"])) $_POST["ToDateHalf"] = '';

		if(empty($_POST["LeaveType"]) || empty($_POST["FromDate"]) || empty($_POST["ToDate"])){
			$ErrorMsg = '<div class=redmsg>'.ENTER_MANDATORY_FIELDS.'</div>';
		}else{

			if($_SESSION['AdminType'] != "admin" && $arryLeave[0]['EmpID']>0) {
				$_POST["EmpID"] = $arryLeave[0]['EmpID'];
			}

			if(empty($_POST["Status"])) $_POST["Status"] = 'Pending';

			$arryEmployeeDt = $objEmployee->GetEmployee($_POST["EmpID"],'');
			/**************************************/
			/***********   WeekendCount ***********/

			if($arryCurrentLocation[0]['UseShift']==1 && $arryEmployeeDt[0]['shiftID']>0){ //from shift
				$arryShift = $objCommon->getShift($arryEmployeeDt[0]['shiftID'],'1');
				$WeekendCount = $arryShift[0]['WeekendCount'];
				$WeekStart = $arryShift[0]['WeekStart'];
				$WeekEnd = $arryShift[0]['WeekEnd'];
			}else{ 
				$WeekendCount = $arryCurrentLocation[0]['WeekendCount'];
				$WeekStart = $arryCurrentLocation[0]['WeekStart'];
				$WeekEnd = $arryCurrentLocation[0]['WeekEnd'];
			}
			//echo $WeekendCount.'-'.$WeekStart.':'.$WeekEnd;exit;
			if($WeekendCount!=1 && $WeekStart!='' && $WeekEnd!=''){
				$WeekEndArry = GetWeekEndNum($WeekStart,$WeekEnd);
			}
			//print_r($WeekEndArry);
			/***************************************************************/
			/************Getting Num Day between from and to date ***********/
			#$NumDay = (strtotime($_POST['ToDate']) - strtotime($_POST['FromDate']))/(24*3600) + 1;

			$NumDay = 0;
			if($_POST['FromDate'] == $_POST['ToDate'] && $_POST['FromDateHalf'] == 1 && $_POST['ToDateHalf'] == 1){
				//$NumDay = $NumDay;
				$NumDay = $NumDay - 0.5;
			}else{

				if($_POST['FromDateHalf'] == 1){
					$NumDay = $NumDay - 0.5;
				}
				if($_POST['ToDateHalf'] == 1){
					$NumDay = $NumDay - 0.5;
				}

			}

			$i = $_POST['FromDate'];
			while($i<=$_POST['ToDate']){

				#$sql_holi= "select holidayID from h_holiday where holidayDate='".$i."' and Status=1";
				$sql_holi ="select holidayID from h_holiday where Status='1' and CASE WHEN holidayDateTo > 0 THEN ('".$i."' BETWEEN holidayDate and holidayDateTo) ElSE holidayDate='".$i."' END  ";
				$rs_holi = $objLeave->query($sql_holi);
			
				$DinNo = date("w",strtotime($i));
				if(!in_array($DinNo, $WeekEndArry)&& empty($rs_holi[0]['holidayID'])){
					$NumDay++;
				}
				$DateAry = explode("-",$i);
				$i = date('Y-m-d', mktime(0, 0, 0, $DateAry[1], $DateAry[2]+1, $DateAry[0]));				
			}
 			//echo $NumDay; die;

			if($NumDay<0) $NumDay=0;
			$_POST["Days"] = $NumDay;

			
			/***********************************/
			$_POST['LastBalance'] = $objLeave->getLeaveBalance($_POST['EmpID'],$_POST['LeaveType']);
			

			if(!empty($_POST['LeaveID'])) {
				$LeaveID = $_POST['LeaveID'];
				$objLeave->updateLeave($_POST);
				$_SESSION['mess_leave'] = LEAVE_UPDATED;
			} else {		
				$LeaveID = $objLeave->addLeave($_POST);
				if($arryLeave[0]['EmpID']>0){
					$_SESSION['mess_leave'] = LEAVE_APPLIED;
				}else{
					$_SESSION['mess_leave'] = LEAVE_ADDED;
				}
			}
		
			if($_POST['OldStatus']!=$_POST['Status']){
				$objLeave->sendLeaveEmail($LeaveID);
			}


			header("location:".$RedirectUrl);
			exit;
		}

		
	}
	
	if(isset($_GET['edit']) && $_GET['edit'] >0){
		$arryLeave = $objLeave->getLeave($_GET['edit']);
		$PageHeading = 'Edit Leave for Employee: '.stripslashes($arryLeave[0]['UserName']);
		if($arryLeave[0]['LeaveStart']>0) $LeaveStart = $arryLeave[0]['LeaveStart'];
		if($arryLeave[0]['LeaveEnd']>0) $LeaveEnd = $arryLeave[0]['LeaveEnd'];



		if($_SESSION['AdminType'] != "admin" && $_SESSION['AdminID'] == $arryLeave[0]['EmpID']){
			$HideStatus = 'style="display:none"';
		}






	}else{
		
		if($_GET['d']>0){
			$_GET['Department'] = $_GET['d']; 
			$_GET['Status'] = '1'; 
			$_GET['ExistingEmployee'] = '1';
			$arryEmployee = $objEmployee->GetEmployeeList($_GET);
			$numEmp = sizeof($arryEmployee);
		}

		$arryLeavePeriod = $objLeave->GetLeavePeriod();
		if($arryLeavePeriod[0]['LeaveStart']>0) $LeaveStart = $arryLeavePeriod[0]['LeaveStart'];
		if($arryLeavePeriod[0]['LeaveEnd']>0) $LeaveEnd = $arryLeavePeriod[0]['LeaveEnd'];



		if($_SESSION['AdminType'] != "admin"){
			$HideStatus = 'style="display:none"';
		}

	}


	


	$arryLeaveType = $objCommon->GetAttributeValue('LeaveType','');
	$arryLeaveStatus = $objCommon->GetFixedAttribute('LeaveStatus','');

?>
