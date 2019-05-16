<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();
	$objLeave=new leave();
	$objEmployee=new employee();
	$objTime=new time();

	$arryLeave=$objLeave->getEmpLeave($_SESSION['AdminID']);
	$num=sizeof($arryLeave);



	$arryEmp=$objEmployee->GetEmployeeBrief($_SESSION['AdminID']);
	if($arryEmp[0]['LeaveAccrual']==1){ 
		$arryFinalLeave = $objLeave->getAccrualLeave($arryEmp);
		//echo '<pre>';print_r($arryFinalLeave);exit;
		$LeaveEntitle = 0; $LeaveBalance = 0;
		foreach($arryFinalLeave as $key=>$values){
			$EntitleDays = 	$values;
			$ApprovedLeave = $objLeave->getLeaveByStatus($_SESSION['AdminID'],"'Approved','Taken'",$key);
			$Balance = 0;
			$Balance = $EntitleDays - $ApprovedLeave;

			$LeaveEntitle += $EntitleDays;
			$LeaveBalance += $Balance;
			
		}
		
		//$LeaveBalance = $objLeave->getLeaveBalance($_SESSION['AdminID'],''); //not needed
		
	}else{
		$LeaveEntitle = $objLeave->getLeaveEntitle($_SESSION['AdminID'],'');
		$LeaveBalance = $objLeave->getLeaveBalance($_SESSION['AdminID'],'');
	}

	 $IsDeptHead = $objCommon->IsDeptHead($_SESSION['AdminID']);

	require_once("../includes/footer.php");
?>

