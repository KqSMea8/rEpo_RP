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
	require_once($Prefix."classes/training.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/tax.class.php");
	require_once($Prefix."classes/configure.class.php");	
	require_once($Prefix."classes/payroll.class.php");
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



	/*if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}*/


	switch($_GET['action']){

	case 'working_duration':
			if($_GET['WorkingHourStart']!='' && $_GET['WorkingHourEnd']!=''){
				$Duration = strtotime($_GET['WorkingHourEnd']) - strtotime($_GET['WorkingHourStart']);
				if($Duration<0){
					$FinalDuration=0; $Duration=0;
				}else{
					$FinalDuration = time_diff($Duration);
				}
				$arryDuration["DurationHtml"] = $FinalDuration; 
				$arryDuration["Duration"] = $Duration; 
				echo json_encode($arryDuration);exit;
			}
			break;
			exit;	
	
	case 'delete_file':
			if($_GET['file_path']!=''){
				$objConfigure->UpdateStorage($_GET['file_path'],0,1);
				unlink($_GET['file_path']);
				echo "1";
			}else{
				echo "0";
			}
			break;
			exit;
	case 'currency':
			$objRegion=new region();
			$arryCurrency = $objRegion->getCurrency($_GET['currency_id'],'');
			echo $StoreCurrency = $arryCurrency[0]['symbol_left'].$arryCurrency[0]['symbol_right'];
			break;
			exit;			
	case 'state':
			$objRegion=new region();
			if($_GET['country_id']>0){
				$arryState = $objRegion->getStateByCountry($_GET['country_id']);
			}
			
				$AjaxHtml  = '<select name="state_id" class="inputbox" id="state_id"  onchange="Javascript: SetMainStateId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}

				$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id']);
				
				for($i=0;$i<sizeof($arryState);$i++) {
				
					$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
				}

				$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
				if($_GET['other']==1){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				}else if(sizeof($arryState)<=0){
					$AjaxHtml  .= '<option value="">No state found.</option>';
				}

				$AjaxHtml  .= '</select>';
			
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_state_id" id="ajax_state_id" value="'.$StateSelected.'">';
							
			break;
			
			
	case 'city':
			$objRegion=new region();
			if($_GET['state_id']>0){
				$arryCity = $objRegion->getCityByState($_GET['state_id']);
			}

				$AjaxHtml  = '<select name="city_id" class="inputbox" id="city_id" onchange="Javascript: SetMainCityId();">';
				
				if($_GET['select']==1){
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}


				$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id']);
				
				for($i=0;$i<sizeof($arryCity);$i++) {
				
					$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");
					
					$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.htmlentities($arryCity[$i]['name'], ENT_IGNORE).'</option>';
					
				}

				$Selected = ($_GET['current_city'] == '0')?(" Selected"):("");
				if($_GET['other']==1){
					$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
				}else if(sizeof($arryCity)<=0){
					$AjaxHtml  .= '<option value="">No city found.</option>';
				}

				$AjaxHtml  .= '</select>';
			
				
			$AjaxHtml  .= '<input type="hidden" name="ajax_city_id" id="ajax_city_id" value="'.$CitySelected.'">';
							
			break;


	case 'zipSearch':		
		$objRegion=new region();
		if(!empty($_GET['city_id'])){
			$arryZipcode = $objRegion->getZipCodeByCity($_GET['city_id']);
			for($i=0;$i<sizeof($arryZipcode);$i++) {
				$AjaxHtml .= '<li onclick="set_zip(\''.stripslashes($arryZipcode[$i]['zip_code']).'\')">'.stripslashes($arryZipcode[$i]['zip_code']).'</li>';
			}

		}
		break;








								
	}
	

	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}


	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/




	switch($_GET['action']){
		case 'emp_list':
			$objEmployee=new employee();
			$arryEmployee = $objEmployee->GetEmployeeList($_GET);
			$num = sizeof($arryEmployee);

			if($_GET['OnChangeFlag']==1){
				$onChange = 'onChange="Javascript:SetEmpID();"';
			}

			$AjaxHtml  = '<select name="EmpID" class="inputbox" id="EmpID" '.$onChange.'>';
			
			if($num>0){
				if($_GET['All']==1){
					$AjaxHtml  .= '<option value="">--- All ---</option>';
				}else{
					$AjaxHtml  .= '<option value="">--- Select Employee ---</option>';
				}
				for($i=0;$i<$num;$i++) {
					$Selected = ($_GET['OldEmpID'] == $arryEmployee[$i]['EmpID'])?(" Selected"):("");
					$AjaxHtml  .= '<option value="'.$arryEmployee[$i]['EmpID'].'" '.$Selected.'>'.stripslashes($arryEmployee[$i]['UserName']).'</option>';
				}

		    }else{
				$AjaxHtml  .= '<option value="">'.NO_EMPLOYEE.'</option>';
			}

			$AjaxHtml  .= '</select>';			

			break;
			exit;	



	
		case 'dept_list':
			$arrySubDepartment = $objConfigure->GetSubDepartment($_GET['Division']);
			$num = sizeof($arrySubDepartment);

			if($_GET['OnChangeFlag']==1){
				//$onChange = 'onChange="Javascript:SetDeptID();"';
			}

			$AjaxHtml  = '<select name="depID" class="inputbox" id="depID" '.$onChange.'>';
			
			if($num>0){
				if($_GET['All']==1){
					$AjaxHtml  .= '<option value="">--- All ---</option>';
				}else{
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				}
				for($i=0;$i<$num;$i++) {
					$Selected = ($_GET['OldDeptID'] == $arrySubDepartment[$i]['depID'])?(" Selected"):("");
					$AjaxHtml  .= '<option value="'.$arrySubDepartment[$i]['depID'].'" '.$Selected.'>'.stripslashes($arrySubDepartment[$i]['Department']).'</option>';
				}

		    }else{
				$AjaxHtml  .= '<option value="">'.NO_DEPARTMENT.'</option>';
			}

			$AjaxHtml  .= '</select>';			

			break;
			exit;
		case 'leave_balance':
			$objLeave=new leave();
			$TotalLeave = $objLeave->getLeaveBalance($_GET['EmpID'],$_GET['LeaveType']);
			echo $TotalLeave;
			break;
			exit;	
			
		case 'emp_salary':
			$objPayroll=new payroll();
			$arrySalary  = $objPayroll->getSalary('',$_GET['EmpID']);
			if(!empty($arrySalary[0]['NetSalary'])){
				echo $arrySalary[0]['NetSalary'];
			}else{
				echo '0';
			}
			break;
			exit;		

	      case 'punching_bak':
			/*************************/
			$arryCurrentLocation = $objConfigure->GetLocation($_SESSION['locationID'],'');
			$Config['TodayDate'] = getLocalTime($arryCurrentLocation[0]['Timezone']);
			$arryTime = explode(" ",$Config['TodayDate']);
			$Config['CurrentDate'] = $arryTime[0];
			$Config['CurrentTime'] = $arryTime[1];
			/*************************/
			
			$objTime=new time();
			
			if(!empty($_GET['punchType'])){
				if($_GET['punchID']>0) {
					$objTime->updateAttPunching($_GET);
					$mess_punch = PUNCHED_IN;
				}else{
					$objTime->addAttPunching($_GET);
					$mess_punch = PUNCHED_OUT;
				}
			}else{
				if($_GET['attID']>0) {
					$objTime->updateAttendence($_GET);
					$mess_punch = PUNCHED_OUT;
				} else {		
					$objTime->addAttendence($_GET);
					$mess_punch = PUNCHED_IN;
				}
			}
			$AjaxHtml = '<div class="redmsg" align="center"><br><br>'.$mess_punch.'</div>';
			break;
			exit;


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
				echo 'Invalid Punch.';
				exit;
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
					$objTime->addAttPunching($_GET);
					$mess_punch = PUNCHED_OUT;
				}
			}else{
				if($_GET['attID']>0) {
					$objTime->updateAttendence($_GET);
					$mess_punch = PUNCHED_OUT;
				} else {		
					$objTime->addAttendence($_GET);
					$mess_punch = PUNCHED_IN;
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


		 case 'timesheet_form':

			$arryWeek = GetWeek($_GET['tmDate'],"Y-m-d");

			$AjaxHtml = ' <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Timsheet for Date :
					  </td>
                      <td  align="left" valign="top">
						'.date("d F, Y",strtotime($_GET['tmDate'])).'&nbsp; &nbsp;&nbsp;<a href="Javascript:ResetForm();"><B>[Change]</B></a>
					  </td>
                    </tr>
					<tr>
                      <td  align="right" width="45%"  class="blackbold" valign="top"> 
						Project Name :
					  </td>
                      <td  align="left" valign="top">
						<input name="Project" type="text" class="inputbox" id="Project" value="'.stripslashes($arryTiimesheet[0]['Project']).'"  maxlength="30" />
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Activity :
					  </td>
                      <td  align="left" valign="top">
						<input name="Activity" type="text" class="inputbox" id="Activity" value="'.stripslashes($arryTiimesheet[0]['Activity']).'"  maxlength="40" />
					  </td>
                    </tr>';
			for($i=1;$i<=7;$i++){
				$TimeHour = "TimeHour".$i; $TimeMinute = "TimeMinute".$i;
				$AjaxHtml .= '<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						'.date("D, d F",strtotime($arryWeek[$i])).' :
						</td>
                      <td  align="left" valign="top">
						<input name="'.$TimeHour.'" type="text" class="textbox" id="'.$TimeHour.'" value="" size="1"  maxlength="2" onkeypress="return isNumberKey(event);"/> hr  &nbsp;&nbsp;&nbsp;&nbsp;<input name="'.$TimeMinute.'" type="text" class="textbox" id="'.$TimeMinute.'" value="" size="1"  maxlength="2" onkeypress="return isNumberKey(event);"/> min
					  </td>
                    </tr>';
			}

			/*$AjaxHtml .= '<tr>
			<td  align="left" valign="top"></td>
				<td align="left" valign="top">
					<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit " />
				  </td>
		  </tr>';*/

			$AjaxHtml .= '</table>';
			$AjaxHtml .= '<input type="hidden" name="FromDate" id="FromDate" value="'.$arryWeek[1].'" ><input type="hidden" name="ToDate" id="ToDate" value="'.$arryWeek[7].'" >';
			
			break;

	 case 'timesheet_add':
			$objTime=new time();
			if($objTime->AddTimesheet($_GET)){
				echo "1";
			}else{
				echo "0";
			}

			//echo '<pre>';print_r($_GET);
			exit;
			
			
			break;
	 case 'request_salary_slip':
			$objEmployee=new employee();
			if($objEmployee->RequestSalarySlip($_GET)){
				echo '<br><br><br>'.REQUEST_SLIP_SEND;
			}else{
				echo '<br><br><br>'.REQUEST_FAILED;
			}
			exit;
			
			break;




	case 'employment_detail':
			$objEmployee=new employee();
			$ArryEmployment = $objEmployee->GetEmploymentDetail($_GET['EmpID'],$_GET['employmentID']);

			if($ArryEmployment[0]["ToDate"]<=0) $ArryEmployment[0]["ToDate"]='';
			$AjaxHtml = '<input type="hidden" id="ajaxEmployerName" value="'.stripslashes($ArryEmployment[0]["EmployerName"]).'">
			<input type="hidden" id="ajaxDesignation" value="'.stripslashes($ArryEmployment[0]["Designation"]).'">
			<input type="hidden" id="ajaxFromDate" value="'.stripslashes($ArryEmployment[0]["FromDate"]).'">
			<input type="hidden" id="ajaxToDate" value="'.stripslashes($ArryEmployment[0]["ToDate"]).'">
			<input type="hidden" id="ajaxJobProfile" value="'.stripslashes($ArryEmployment[0]["JobProfile"]).'">
			';
			break;
			exit;		

	case 'family_detail':
			$objEmployee=new employee();
			$ArryFamily = $objEmployee->GetFamilyDetail($_GET['EmpID'],$_GET['familyID']);

			$AjaxHtml = '<input type="hidden" id="ajaxName" value="'.stripslashes($ArryFamily[0]["Name"]).'">
			<input type="hidden" id="ajaxRelation" value="'.stripslashes($ArryFamily[0]["Relation"]).'">
			<input type="hidden" id="ajaxAge" value="'.stripslashes($ArryFamily[0]["Age"]).'">
			<input type="hidden" id="ajaxDependent" value="'.stripslashes($ArryFamily[0]["Dependent"]).'">
			';
			break;
			exit;		
	case 'emergency_contact':
			$objEmployee=new employee();
			$ArryEmergency = $objEmployee->GetEmergencyDetail($_GET['EmpID'],$_GET['contactID']);

			$AjaxHtml = '<input type="hidden" id="ajaxName" value="'.stripslashes($ArryEmergency[0]["Name"]).'">
			<input type="hidden" id="ajaxRelation" value="'.stripslashes($ArryEmergency[0]["Relation"]).'">
			<input type="hidden" id="ajaxAddress" value="'.stripslashes($ArryEmergency[0]["Address"]).'">
			<input type="hidden" id="ajaxMobile" value="'.stripslashes($ArryEmergency[0]["Mobile"]).'">
			<input type="hidden" id="ajaxHomePhone" value="'.stripslashes($ArryEmergency[0]["HomePhone"]).'">
			<input type="hidden" id="ajaxWorkPhone" value="'.stripslashes($ArryEmergency[0]["WorkPhone"]).'">
			';
			break;
			exit;

	case 'EmpturnoverBar':
			$AjaxHtml = '<div class="bar_chart" ><h2>Year: '.$_GET['Year'].'</h2><img src="barTurn.php?Year='.$_GET['Year'].'" ></div>';
			break;
			
	case 'EmpturnoverRange':
			$AjaxHtml = '<div class="bar_chart" ><h2>Year: '.$_GET['FromYear'].' - '.$_GET['ToYear'].'</h2><img src="barTurn.php?FromYear='.$_GET['FromYear'].'&ToYear='.$_GET['ToYear'].'" ></div>';
			break;

	case 'training_list':
			$objTraining=new training();
			$arryTrainingAll = $objTraining->TrainingListing($_GET["k"],1);
			$numTraining = $objTraining->numRows();

			$AjaxHtml = '';
			
			if($numTraining>0){
				$AjaxHtml .= '<table '.$table_bg.'>
				<tr align="left"  >
				 <td width="8%" class="head1" align="center">Select</td>
				  <td width="10%" class="head1" >Training ID</td>
				  <td width="18%"  class="head1" >Course Name</td>
				  <td width="18%" class="head1" >Company</td>
				  <td class="head1" >Coordinator</td>
				   <td width="10%" class="head1" >Department</td>
				  <td width="10%" class="head1"  align="center">Training Date</td>
				</tr>';

				
				$flag=true;
				$Line=0;
				foreach($arryTrainingAll as $key=>$values){
				$flag=!$flag;
				$bgcolor=($_GET['t']==$values["trainingID"])?("#f2f2f2"):("#ffffff");
				$Line++;

				#$trainingDate = ($values['trainingDate']>0)?(date($_SESSION["DateFormat"], strtotime($values['trainingDate']))):('');

				$AjaxHtml .= '<tr align="left"  bgcolor="'.$bgcolor.'">
				  <td height="20" align="center"><a href="?t='.$values["trainingID"].'" onclick="Javascript:SetTraining();" class="red_bt">Select</a></td>
				   <td>'.$values["trainingID"].'</td>
				 <td>'.stripslashes($values["CourseName"]).'</td>
				  <td>'.stripslashes($values["Company"]).'</td>
				 <td>'.stripslashes($values['CoordinatorName']).' </td>
				 <td align="left">'.$values['Department'].'</td> 
				 <td align="center">'.$values['trainingDate'].'</td> 
				</tr>';

				 } // foreach end //
			  
				 $AjaxHtml .= '</table>';

			 }else{
				$AjaxHtml .= '<div class="redmsg" align="center"><br><br>'.NO_TRAINING.'</div>';
			 }

			break;


	case 'training_feedback':
			$objTraining=new training();
			if(!empty($_GET['Feedback'])) {
				$objTraining->UpdateParticipantFeedback($_GET);
				echo '<div class="message" style="padding-top:50px;" >'.PARTICIPANT_FEEDBACK_UPDATED.'</div>'; exit;
			}


			$arryParticipant = $objTraining->GetParticipant($_GET["partID"],'');
			$num = $objTraining->numRows();
			
			if($num==1){
				$AjaxHtml = '<table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>
                      <td align="right" width="25%" class="blackbold">
					 Training ID :
					  </td>
                      <td align="left" >
						'.$arryParticipant[0]['trainingID'].'
					  </td>
                    </tr>
					<tr>
                      <td  align="right"  class="blackbold">
					 Employee :
					  </td>
                      <td align="left" >
						'.stripslashes($arryParticipant[0]['UserName']).', '.stripslashes($arryParticipant[0]['JobTitle']).' ['.stripslashes($arryParticipant[0]["Department"]).']
					  </td>
                    </tr>
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Feedback :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						 <textarea name="AjaxFeedback" type="text" class="bigbox" id="AjaxFeedback" maxlength="300">'.stripslashes($arryParticipant[0]['Feedback']).'</textarea>	
					  </td>
                    </tr> 
					</table>';
			}else{
				$AjaxHtml = '<div class="redmsg" align="center"><br><br>'.NO_PARTICIPANT.'</div>';
			}

			$AjaxHtml .= '<input type="hidden" name="numParticipant" id="numParticipant" value="'.$num.'">';

			break;

 		case 'TaxBracket':
			$objTax=new tax();
			if($_GET['filingID']>0 && $_GET['Year']>0){
				$arryTaxBracket = $objTax->getTaxBracket('', $_GET['Year']);
				$num = sizeof($arryTaxBracket);
				$filingID = $_GET['filingID'];

				//echo '<pre>';	echo $_GET['filingID'].print_r($arryTaxBracket);exit;
				$AjaxHtml  = '<select name="bracketID" class="inputbox" id="bracketID" >';
			
				if($num>0){				
					$AjaxHtml  .= '<option value="">--- Select ---</option>';
				
					for($i=0;$i<$num;$i++) {
						$Selected = ($_GET['OldbracketID'] == $arryTaxBracket[$i]['bracketID'])?(" Selected"):("");					

					unset($FilingValArray);
					$FilingValArray = explode("#",$arryTaxBracket[$i]['Filing'.$filingID]);

					$From = number_format($FilingValArray['0']);
					$To = number_format($FilingValArray['1']);
					if($To>0){	
						$FinalVal = $From.' - '.$To;
					}else{
						$FinalVal = 'over '.$From;
					}					

					$AjaxHtml  .= '<option value="'.$arryTaxBracket[$i]['bracketID'].'" '.$Selected.'>'.$FinalVal.'</option>';
					}

				}else{
					$AjaxHtml  .= '<option value="">No record found</option>';
				}

				$AjaxHtml  .= '</select>';
			}
			
			
			break;


	}



	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}
	

?>
