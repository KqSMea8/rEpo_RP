<?php 
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objTime=new time();
	$objEmployee=new employee();
	$objCommon=new common();

	$LunchPunchExist='';
	if(!empty($_POST["attID"])){ 
		CleanPost(); 
		$attDate = explode("-",$_POST["attDate"]);
		$RedirectUrl = 'viewAttendence.php?y='.$attDate[0].'&m='.$attDate[1].'&emp='.$_POST["MainEmpID"].'&depID='.$_POST["Department"];

		$_SESSION['mess_att'] = ATT_PUNCH_UPDATED;

		

		$objTime->updateAttendenceAdmin($_POST);

		if(sizeof($_POST['punchID'])>0){
			for($i=0;$i<sizeof($_POST['punchID']);$i++){			
				if(!empty($_POST['punchType'][$i])){
					$objTime->updateAttPunchingAdmin($_POST["attID"], $_POST["MainEmpID"], $_POST["attDate"], $_POST['punchID'][$i], $_POST['punchType'][$i],$_POST['BreakIn'][$i],$_POST['BreakOut'][$i]);					
				}			

			}
		}
	

		//header("location:".$RedirectUrl);
		echo '<script>window.parent.location.href="'.$RedirectUrl.'";</script>';
		exit;

	}


 
	
	if(!empty($_GET['att'])){
		$arryAttendence=$objTime->getAttendence('',$_GET['att'], '', '', '', '');


		$arryBreak=$objTime->getAttPunching($_GET['att'],'','');
		$numBreak=sizeof($arryBreak);		
		$arryEmployee = $objEmployee->GetEmployeeBrief($arryAttendence[0]['EmpID']);

		/*******************/
		/*******************/		
		if($arryCurrentLocation[0]['UseShift']==1){ //from shift 
			if($arryEmployee[0]['shiftID']>0){ 
				$arryShift = $objCommon->getShift($arryEmployee[0]['shiftID'],'1');
				$LunchPunch = $arryShift[0]['LunchPunch'];
			}
		}else{
			$LunchPunch = $arryCurrentLocation[0]['LunchPunch'];
		}
		
		if($LunchPunch==1){
			foreach($arryBreak as $key=>$values){
				if($values["punchType"]=='Lunch'){
					$LunchPunchExist=1; break;
				}
			}
			if($LunchPunchExist!=1){
				$arryBreak[$numBreak]['punchType']  = 'Lunch';
			}
		}		
		/*******************/
		/*******************/

	}

	if(empty($arryAttendence[0]['attDate']) ){
		exit;
	}
//pr($arryBreak);
	require_once("../includes/footer.php");
?>

