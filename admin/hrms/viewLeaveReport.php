<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/leave.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	include_once("includes/FieldArray.php");
	$objCommon=new common();
	$objLeave=new leave();
	$objEmployee=new employee();
	$Show='';
	(empty($_GET['ltype']))?($_GET['ltype']=""):("");
	(empty($_GET['ExistingEmployee']))?($_GET['ExistingEmployee']=""):("");

	if(!empty($_GET['s'])){
		$Show=1;
		if($_GET['emp']>0){
			$arryEmp=$objEmployee->GetEmployeeBrief($_GET['emp']);
			/**************************/
			if($arryEmp[0]['LeaveAccrual']==1){ 
				$arryFinalLeave = $objLeave->getAccrualLeave($arryEmp);
				//echo '<pre>';print_r($arryFinalLeave);exit;
				$LeaveEntitle = 0; $LeaveBalance = 0;
				foreach($arryFinalLeave as $key=>$values){
					$EntitleDays = 	$values;
					$ApprovedLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Approved','Taken'",$key);
					$Balance = 0;
			
					$Balance = $EntitleDays - $ApprovedLeave;

					$LeaveEntitle += $EntitleDays;
					$LeaveBalance += $Balance;
		
				}				
	
			}
			/**************************/

			
		




			$arryLeave = $objCommon->GetAttributeByValue($_GET['ltype'],'LeaveType');
		}else{
			$arryEmployee = $objEmployee->GetEmployeeList($_GET);

			$num=$objEmployee->numRows();

			$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
			(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");

		}
	}



	$arryLeaveType = $objCommon->GetAttributeValue('LeaveType','');

	require_once("../includes/footer.php");
?>

