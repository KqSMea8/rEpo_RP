<?	session_start();

	$Prefix = "../../"; 
    	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/leave.class.php");	
	require_once($Prefix."classes/time.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/MyMailer.php");	
	require_once("language/english.php");
	$objConfig=new admin();
	$objConfigure=new configure();

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$objCompany=new company(); 
	$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
	$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
	$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
	$Config['AdminEmail'] = $arryCompany[0]['Email'];
	$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';

	CleanGet();
   

	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/


	switch($_GET['action']){
		    
	 	case 'punching':
			/*****Get Date Time from System**********/
			$arryCurrentLocation = $objConfigure->GetLocation($_SESSION['locationID'],'');
			$Config['TodayDate'] = getLocalTime($arryCurrentLocation[0]['Timezone']);
			$arryTime = explode(" ",$Config['TodayDate']);
			$Config['CurrentDate'] = $arryTime[0];
			//$Config['CurrentTime'] = $arryTime[1];
			/**********************************/
			$IntegerTime = (int) $_GET['CurrentTime'];
		
			

			if(!empty($IntegerTime)){
				$CurrentTime = $_GET['CurrentTime']; 
				$arryCurrTime = explode(":",$_GET['CurrentTime']);
				if($arryCurrTime[3]=='PM' && $arryCurrTime[0]<12)  $arryCurrTime[0] += 12;

				$Config['CurrentTime'] = $arryCurrTime[0].':'.$arryCurrTime[1].':'.$arryCurrTime[2];
				//echo $Config['CurrentTime']; exit;
			}else{
				echo 'Invalid Punch.';exit;
				
			}

			$PunchedDateTime = $Config['CurrentDate'].' '.$Config['CurrentTime'];
			$DiffInMinute = (strtotime($PunchedDateTime) - strtotime($Config['TodayDate']))/60;
			if($DiffInMinute<0){
				$DiffInMinute = str_replace("-","",$DiffInMinute);
			}
			//echo $DiffInMinute.'<br>'.$Config['TodayDate'].'<br>'.$PunchedDateTime;exit;
			if($DiffInMinute>10){
				/*$To = 'parwez.khan@vstacks.in';	
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: ".$Config['SiteName']. "<".$Config['AdminEmail'].">\r\n" .
				"X-Mailer: PHP/" . phpversion();
				$Subject = 'Invalid Punch, Trying to change system time by '.$_SESSION['UserName'];
				$contents = 'Hi,<br><br>'.$_SESSION['UserName'].' ['.$_SESSION['EmpEmail'].'] is trying for Invalid Punch by changing system time.';				
				mail($To, $Subject, $contents, $headers);
				*/

				echo 'Invalid Punch.';exit;
			}
			

			/**********************************/
			$_GET['attDate'] = $Config['CurrentDate'];
			$_GET['InTime'] = $Config['CurrentTime'];
			$_GET['OutTime'] = $Config['CurrentTime'];


			$objTime=new time();
			
			if(!empty($_GET['punchType'])){
				if($_GET['punchID']>0) {
					$objTime->updateAttPunching($_GET);
					$mess_punch = PUNCHED_IN;
				}else{
					$punchID = $objTime->addAttPunching($_GET);
					$mess_punch = ($punchID>0)?(PUNCHED_OUT):(PUNCHED_OUT_ALREADY);
				}
			}else{
				if($_GET['attID']>0) {
					$objTime->updateAttendence($_GET);
					$mess_punch = PUNCHED_OUT;
				} else {		
					$attID = $objTime->addAttendence($_GET);					 
					$mess_punch = ($attID>0)?(PUNCHED_IN):(PUNCHED_IN_ALREADY);
				}
			}
			$AjaxHtml = '<div class="redmsg" align="center"><br><br>'.$mess_punch.'</div>';
			break;
			exit;	



	    case 'punching_check':
			$objTime=new time();

			$arryPunch = $objTime->getAttPunchingLast($_GET);
			if(empty($arryPunch[0]['punchID'])) $arryPunch[0]['punchID']=0;
			echo json_encode($arryPunch[0]);exit;
			break;
			exit;


		case 'att_detail':
			$objTime=new time();
			$arryAttendence = $objTime->getAttendence($_GET['attID'], '', '', '','');

			if(sizeof($arryAttendence)>0){
				if(!empty($arryAttendence[0]["InTime"]) && !empty($arryAttendence[0]["OutTime"])){
					$Duration = strtotime($arryAttendence[0]["OutTime"]) - strtotime($arryAttendence[0]["InTime"]);
					$Duration = time_diff($Duration);
					
				}

			$AjaxHtml = ' <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
					
					<tr>
                      <td  align="right" width="45%"  class="blackbold" valign="top"> 
						Employee :
					  </td>
                      <td  align="left" valign="top">
						'.$arryAttendence[0]["UserName"].'
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Department :
					  </td>
                      <td  align="left" valign="top">
						'.$arryAttendence[0]["Department"].'
					  </td>
                    </tr>
					
					
					<tr>
                      <td  align="right"  class="blackbold">
					 Date :
					  </td>
                      <td align="left">
						'.date("d F, Y",strtotime($arryAttendence[0]["attDate"])).'
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						In Time :
					  </td>
                      <td  align="left" valign="top">
						'.$arryAttendence[0]["InTime"].'
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						In Time Comment:
					  </td>
                      <td  align="left" valign="top">
						'.stripslashes($arryAttendence[0]["InComment"]).'
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Out Time :
					  </td>
                      <td  align="left" valign="top">
						'.$arryAttendence[0]["OutTime"].'
					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Out Time Comment:
					  </td>
                      <td  align="left" valign="top">
						'.stripslashes($arryAttendence[0]["OutComment"]).'
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Duration :
					  </td>
                      <td  align="left" valign="top">
						'.$Duration.'
					  </td>
                    </tr>	
			</table>';
			}else{
				$AjaxHtml = NO_RECORD_FOUND;
			}
			break;


		          
		case 'pinpunching':
			$objEmployee=new employee();
			$objTime=new time();
			$objCommon=new common();
			/*****************************/
                        $PIN = $_GET['PIN'];
			if(!empty($PIN)){
				/*****Get Employee by PIN**********/
				$arryEmployee = $objEmployee->GetEmployeeByPin($PIN ,'1');	
			  
				if(empty($arryEmployee[0]['EmpID'])){
					echo $ErrorMSG = '<div class="redmsg">'.PIN_NOT_EXIST.'</div>';exit;
				}
				$EmpInfo = '<div class="bluemsg">Employee Code : '.$arryEmployee[0]['EmpCode'].'<br>Employee Name : '.$arryEmployee[0]['UserName'].'<br>Employee PIN : '. $PIN.'</div>';				
				/*****Get Date Time from System**********/
				$arryCurrentLocation = $objConfigure->GetLocation($_SESSION['locationID'],'');
				$Config['TodayDate'] = getLocalTime($arryCurrentLocation[0]['Timezone']);
				$arryTime = explode(" ",$Config['TodayDate']);
				$Config['CurrentDate'] = $arryTime[0];
				//$Config['CurrentTime'] = $arryTime[1];
				/**********************************/
				$IntegerTime = (int) $_GET['CurrentTime'];
				$_GET['EmpID'] = (int) $arryEmployee[0]['EmpID'];
				$EmpID = $_GET['EmpID'];


				if(!empty($IntegerTime)){
					$CurrentTime = $_GET['CurrentTime']; 
					$arryCurrTime = explode(":",$_GET['CurrentTime']);
					if($arryCurrTime[3]=='PM' && $arryCurrTime[0]<12)  $arryCurrTime[0] += 12;

					$Config['CurrentTime'] = $arryCurrTime[0].':'.$arryCurrTime[1].':'.$arryCurrTime[2];
					//echo $Config['CurrentTime']; exit;
				}else{
					echo INVALID_PUNCH_TIME;exit;
				
				}
				/*****Check for Invalid Punch**********/
				$PunchedDateTime = $Config['CurrentDate'].' '.$Config['CurrentTime'];
				$DiffInMinute = (strtotime($PunchedDateTime) - strtotime($Config['TodayDate']))/60;
				if($DiffInMinute<0){
					$DiffInMinute = str_replace("-","",$DiffInMinute);
				}
				#echo $DiffInMinute.'<br>'.$Config['TodayDate'].'<br>'.$PunchedDateTime;exit;
				if($DiffInMinute>10){				 
					echo INVALID_PUNCH_TIME;exit;
				}
			

				/**********************************/
				$_GET['attDate'] = $Config['CurrentDate'];
				$_GET['attTime'] = $Config['CurrentTime'];
				$attDate = $_GET['attDate']; 
				$attTime = $_GET['attTime']; 

				
				 		 
/*************/
if($EmpID>0 && !empty($attDate) && !empty($attTime)){
	/*****Get Global Setting Data**********/
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
			echo $ErrorMSG = '<div class="redmsg">'.NO_SHIFT_ASSIGNED_EMP.'</div>';exit;
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
	 
	if(!empty($LunchTime)){
		$arryLunchTime = explode(":",$LunchTime);
		$LunchTime = $arryLunchTime[0].' hrs '.$arryLunchTime[1].' min';
	}
	$Config['NewTimeFormat'] = str_replace(":s","",$_SESSION['TimeFormat']);
	
	/*****Get Employee Punch Data**********/

	$arryToday = $objTime->getAttendence('','', $EmpID,$attDate, '','');
	$attID = $arryToday[0]["attID"];	
	$_GET['attID'] = $attID;
	$_GET['InTime'] = $attTime;
	$_GET['OutTime'] = $attTime;
	if(empty($attID)){	 //Punch IN	 
		$attID = $objTime->addAttendence($_GET);
		$mess_punch = '<div class="greenmsg">'.PUNCHED_IN.'</div>';
	}else if(empty($arryToday[0]["OutTime"])){				
		$arryPendingOut = $objTime->getPunchingOutPending($attID, $EmpID);			
		 
		if(!empty($arryPendingOut[0]['punchID'])){ //Break Punch IN		
			$_GET['punchID'] = $arryPendingOut[0]['punchID'];		 
			$objTime->updateAttPunching($_GET);
			$PUNCHED_IN = str_replace("[PunchType]",$arryPendingOut[0]['punchType'],PUNCHED_IN_TYPE);
			$mess_punch = 'breakin#'.$arryPendingOut[0]['punchType'].'#<div class="greenmsg">'.$PUNCHED_IN.'</div>';			
		}else{
			if(!empty($_GET['punchType'])){
				
				if($_GET['punchType']=='p'){//Punch OUT
					$objTime->updateAttendence($_GET);
					$mess_punch = '<div class="greenmsg">'.PUNCHED_OUT.'</div>';
				}else{//Break Punch OUT					 
					if($_GET['punchType']=='l'){
						$_GET['punchType'] = 'Lunch';
					}else{
						$_GET['punchType'] = 'Short Break';
					}										 
					$punchID = $objTime->addAttPunching($_GET);
					$PUNCHED_OUT = str_replace("[PunchType]",$_GET['punchType'],PUNCHED_OUT_TYPE);
					$mess_punch = '<div class="greenmsg">'.$PUNCHED_OUT.'</div>';
				}
			}else{
				/*****PunchType Dropdown**********/
				$TotalShortBreak = $objTime->getPunchingCount($attID, $EmpID, 'Short Break');	
				$TotalLunch = $objTime->getPunchingCount($attID, $EmpID, 'Lunch');	
				 
				if($LunchPunch==1 && $TotalLunch!=1 && $TotalLunch<=0){
					$LunchBtnShown=1;
					$arryPendingOut[0]['punchType'] = 'Lunch';				
				}
				if($ShortBreakPunch==1 && $TotalShortBreak<$ShortBreakLimit){
					$ShortBtnShown=1;
					if($LunchBtnShown!=1){
						$arryPendingOut[0]['punchType'] = 'Short Break';
					 }
				}
				if($LunchBtnShown==1 || $ShortBtnShown==1){
					$punchTypeDrop = 'dropdown#<select name="punchTypeDrop" id="punchTypeDrop" class="inputbox"   onchange="Javascript:SetPageHead()">';		
					if($LunchBtnShown==1){ $punchTypeDrop .= '<option value="l">Lunch Out</option>';}
					if($ShortBtnShown==1){$punchTypeDrop .= '<option value="s">Short Break Out</option>';}
					$punchTypeDrop .= '<option value="p" >Punch Out</option>';		
					$punchTypeDrop .= '</select>';
					echo $punchTypeDrop;exit;

				}else{ //Punch OUT
					$objTime->updateAttendence($_GET);
					$mess_punch = 'punchout#<div class="greenmsg">'.PUNCHED_OUT.'</div>';
				}
			}

		}
		
		
		
	}else{ //Punch Out Already
		$mess_punch = '<div class="redmsg">'.PUNCHED_OUT_ALREADY.'</div>';
	}

	 	  
	
}
/*************/

				
			}
 
			$AjaxHtml =   $mess_punch.$EmpInfo;
			
			break;
			exit;	



	}



	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
	

?>
