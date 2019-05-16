<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'myAttendence.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$objTime=new time();
	$objEmployee=new employee();

	$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');	


	/*************************/
	if($arryCompany[0]['PunchingBlock']==1){
		$Ipaddress = GetIPAddress();
	 	$AllAllowedIP = array();

		if(!empty($arryCompany[0]['PunchingIP'])){
			$PunchingIP = explode(",",$arryCompany[0]['PunchingIP']);
			$AllAllowedIP = $PunchingIP;
		} 
		/************PunchingIPRange******************/ 
		#$arryCompany[0]['PunchingIPRange'] ='127.0.0.2-127.0.0.5';	
		if(!empty($arryCompany[0]['PunchingIPRange'])){				
			$IPRangeArray = explode("#",$arryCompany[0]['PunchingIPRange']);
 
			foreach($IPRangeArray as $IPRange){
				$IPArray = explode("-",$IPRange);
				$FromIP = trim($IPArray[0]);
				$ToIP = trim($IPArray[1]);
				$FromIPArray = explode(".",$FromIP);
				$ToIPArray = explode(".",$ToIP);
				//pr($FromIPArray); pr($ToIPArray);
				$lastFrom = $FromIPArray[sizeof($FromIPArray)-1];
				$lastTo = $ToIPArray[sizeof($ToIPArray)-1];

				if($lastTo >= $lastFrom){ //last to greater than last from
					array_pop($FromIPArray); array_pop($ToIPArray);
 
					$FromIPLeft = trim(implode(".",$FromIPArray));
					$ToIPLeft = trim(implode(".",$ToIPArray));
		 			if($FromIPLeft==$ToIPLeft){ //First three are same
 
						for($i=$lastFrom;$i<=$lastTo;$i++){
							$ips = ltrim($i,'0');
							$IPValue = $FromIPLeft.".".$ips;
							$AllAllowedIP[] = $IPValue;
							if($ips<10){
								$ips='0'.$ips;
								$IPValue = $FromIPLeft.".".$ips;
								$AllAllowedIP[] = $IPValue;
							} 
						}
					}
				}
			
			
			}
		}
 
		if(!empty($AllAllowedIP)){ 

			if(!empty($_GET['pk'])){echo $Ipaddress; pr($AllAllowedIP);}
			
			if(!in_array($Ipaddress,$AllAllowedIP)){
				$ErrorMSG = BLOCKED_MSG;
			}
		} 		 		
		 
	}

	/***************************/		
	if(empty($arryEmployee[0]['EmpID'])){
		$ErrorMSG = EMP_NOT_EXIST;
	}else if(empty($arryEmployee[0]['ExistingEmployee'])){
		$ErrorMSG = NOT_EXIST_EMPLOYEE;
	}
	/***************************/	


	if(empty($ErrorMSG)){
	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$Config['TodayDate']);
	$TodayDate = $arryTime[0];


	$InTimeHead = 'In Time';
	$OutTimeHead = 'Out Time';

	$arryToday = $objTime->getAttendence('','', $_SESSION['AdminID'],$TodayDate, '','');
	if(empty($arryToday[0]["attID"])){
		$PuchType = "In";
		$PunchingTitle = "Punch ".$PuchType; 
		$HideUnwanted = 'Style="display:none;"';
	}else if(empty($arryToday[0]["OutTime"])){
		$PuchType = "Out";
		$PunchingTitle = "Punch ".$PuchType; 
		$arryPendingOut = $objTime->getPunchingOutPending($arryToday[0]["attID"], $_SESSION['AdminID']);
		if(!empty($arryPendingOut[0]['punchID'])){
			$PunchingTitle = $arryPendingOut[0]['punchType']." In"; 
			$arryToday[0]["InTime"] = $arryPendingOut[0]['InTime'];	
			$arryToday[0]["InComment"] = $arryPendingOut[0]['InComment'];
			$InTimeHead = 'Out Time';
			$OutTimeHead = 'In Time';
			$PuchType = "In";
		}

		$TotalShortBreak = $objTime->getPunchingCount($arryToday[0]["attID"], $_SESSION['AdminID'],'Short Break');	

		$TotalLunch = $objTime->getPunchingCount($arryToday[0]["attID"], $_SESSION['AdminID'],'Lunch');	
		$HideUnwanted = 'Style="display:none;"';
	}else{
		$PuchType = "Done";
		$PunchingTitle = "Punch ".$PuchType; 
	}

	$HideComments = 'Style="display:none;"';
	
	/***************************/
	
	/***************************/
	if($arryCurrentLocation[0]['UseShift']==1){ //from shift 
		if($arryEmployee[0]['shiftID']>0){
			$arryShift = $objCommon->getShift($arryEmployee[0]['shiftID'],'1');
			$shiftName = $arryShift[0]['shiftName'];
			$ShortBreakLimit = $arryShift[0]['ShortBreakLimit'];
			$WorkingHourStart = $arryShift[0]['WorkingHourStart'];
			$WorkingHourEnd = $arryShift[0]['WorkingHourEnd'];
			$FlexTime = $arryShift[0]['FlexTime'];
			$LunchTime = $arryShift[0]['LunchTime'];
			$LunchPunch = $arryShift[0]['LunchPunch'];
			$ShortBreakPunch = $arryShift[0]['ShortBreakPunch'];
			$ShortBreakTime = $arryShift[0]['ShortBreakTime'];
		}
			
		if(empty($arryShift[0]['shiftID'])){
			$ErrorMSG = NO_SHIFT_ASSIGNED;
		}
	}else{ //from location 
		$ShortBreakLimit = $arryCurrentLocation[0]['ShortBreakLimit'];
		$WorkingHourStart = $arryCurrentLocation[0]['WorkingHourStart'];
		$WorkingHourEnd = $arryCurrentLocation[0]['WorkingHourEnd'];
		$FlexTime = $arryCurrentLocation[0]['FlexTime'];
		$LunchTime = $arryCurrentLocation[0]['LunchTime'];
		$LunchPunch = $arryCurrentLocation[0]['LunchPunch'];
		$ShortBreakPunch = $arryCurrentLocation[0]['ShortBreakPunch'];
		$ShortBreakTime = $arryCurrentLocation[0]['ShortBreakTime'];
	}
	/***************************/		
	if(!empty($LunchTime)){
		$arryLunchTime = explode(":",$LunchTime);
		$LunchTimeDisplay = $arryLunchTime[0].' hrs '.$arryLunchTime[1].' min';
	}
	
	$Config['NewTimeFormat'] = str_replace(":s","",$Config['TimeFormat']);

	}



	/***Alert message for punch out after break exceeds******
 	if($Config['CurrentDepID'] == 1 && $_SESSION['AdminType'] == "employee" ){
		$arryTime = explode(" ",$Config['TodayDate']);
		$arryTodayAtt = $objTime->getAttendence('','', $_SESSION['AdminID'],$arryTime[0], '','');

		if(!empty($arryTodayAtt[0]["attID"])){
		  $arryLastPunch = $objTime->getLastPunch($_SESSION['AdminID'],$arryTodayAtt[0]["attID"]);

		if($arryCurrentLocation[0]['UseShift']==1){  
			$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
			if($arryEmployee[0]['shiftID']>0){
				$arryShift = $objCommon->getShift($arryEmployee[0]['shiftID'],'1');		 
				$LunchTime = $arryShift[0]['LunchTime']; 
				$ShortBreakTime = $arryShift[0]['ShortBreakTime'];		
			}		
		}else{  			 
			$LunchTime = $arryCurrentLocation[0]['LunchTime'];
			$ShortBreakTime = $arryCurrentLocation[0]['ShortBreakTime'];	
		}
 
		if($arryLastPunch[0]['punchType']=="Lunch"){
			$BreakTimeDefined = ConvertToSecond($LunchTime)/60;
		}else{
			$BreakTimeDefined = $ShortBreakTime;
		}
 
		if(!empty($arryLastPunch[0]['punchType']) && !empty($arryLastPunch[0]['InTime']) && empty($arryLastPunch[0]['OutTime'])){  
		$MaxBreakTime3 = strtotime($arryLastPunch[0]['InTime']) + ($BreakTimeDefined*60);
		$MaxBreakTime = date("H:i:s",$MaxBreakTime3);

 		


		$BreakTakenMinute  = (strtotime($arryTime[1])) - (strtotime($arryLastPunch[0]['InTime'])) ;
	 	 $BreakTakenMinute = round($BreakTakenMinute / 60,2); 

			if(!empty($BreakTakenMinute) && $BreakTakenMinute>$BreakTimeDefined ){			 
				echo '<div class="redmsg" align="center">Please punch out first</div>'; 
			}
		}
		}
	}
	/*************/	
	require_once("../includes/footer.php"); 	 
?>


