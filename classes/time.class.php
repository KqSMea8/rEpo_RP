<?
class time extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function time(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	/********** Attendence Management *************/
	/*******************************************/

	function addAttendence($arryDetails)  
	{

		@extract($arryDetails);	

		 (empty($shiftID))?($shiftID=""):(""); 

		/*************************/
		$strLoc = "select WorkingHourStart, WorkingHourEnd, UseShift,SL_Coming, SL_Leaving, FlexTime from location where locationID='".$_SESSION['locationID']."'";
		$arryLocation = $this->query($strLoc, 1);	
		/*************************/
		if($arryLocation[0]['UseShift']==1){		
			$strSQL = "select e.EmpID, e.shiftID, s.WorkingHourStart, s.WorkingHourEnd, s.SL_Coming, s.SL_Leaving, s.FlexTime from h_employee e inner join h_shift s on e.shiftID=s.shiftID where e.EmpID='".$EmpID."'";
			$arryEmp = $this->query($strSQL, 1);
			if(!empty($arryEmp[0]['WorkingHourStart'])){
				$WorkingHourStart = $arryEmp[0]['WorkingHourStart'];
				$WorkingHourEnd = $arryEmp[0]['WorkingHourEnd'];
				$shiftID = $arryEmp[0]['shiftID'];
				$SL_Coming = $arryEmp[0]['SL_Coming'];
				$SL_Leaving = $arryEmp[0]['SL_Leaving'];
				$FlexTime = $arryEmp[0]['FlexTime'];
			}
		}else{
			$WorkingHourStart = $arryLocation[0]['WorkingHourStart'];
			$WorkingHourEnd = $arryLocation[0]['WorkingHourEnd'];
			$SL_Coming = $arryLocation[0]['SL_Coming'];
			$SL_Leaving = $arryLocation[0]['SL_Leaving'];
			$FlexTime = $arryLocation[0]['FlexTime'];
		}


		if(!empty($SL_Coming))$SL_Coming .= ':00';
		if(!empty($SL_Leaving))$SL_Leaving .= ':00';
		/*************************/

		$UpdatedDate = $attDate." ".$InTime;
		$ipaddress = GetIPAddress(); 


		$strAtt = "select attID from h_attendence where EmpID='".$EmpID."' and attDate='".$attDate."' ";
		$arryAtt = $this->query($strAtt, 1);

		if(empty($arryAtt[0]['attID'])){
			$sql = "insert into h_attendence(EmpID, attDate, InTime, InComment, UpdatedDate,WorkingHourStart,WorkingHourEnd,shiftID, SL_Coming, SL_Leaving, FlexTime, ipaddress ) values('".$EmpID."', '".$attDate."', '".$InTime."', '".addslashes(strip_tags($InComment))."', '".$UpdatedDate."', '".addslashes($WorkingHourStart)."', '".addslashes($WorkingHourEnd)."', '".addslashes($shiftID)."', '".$SL_Coming."', '".$SL_Leaving."', '".$FlexTime."' , '".$ipaddress."')"; 		
			$this->query($sql, 0);
			$attID = $this->lastInsertId();
		}



		return $attID;

	} 


	function updateAttendence($arryDetails)
	{
		@extract($arryDetails);	
		global $Config;

		if(!empty($attID)){
			$AddSql = '';

			$UpdatedDate = $attDate." ".$OutTime;

			$sql = "update h_attendence set OutTime='".$OutTime."', OutComment = '".addslashes(strip_tags($OutComment))."', UpdatedDate='".$UpdatedDate."' ".$AddSql."  where attID = '".mysql_real_escape_string($attID)."'"; 
			$rs = $this->query($sql,0);

			/*********************/
			$this->updateAttOtherThings($arryDetails);	
			/*********************/

		}
			
		return true;
	}


	function updateAttendenceAdmin($arryDetails)
	{
		global $Config;

		@extract($arryDetails);	

		if(!empty($attID)){
			$AddSql = '';
			if($InTime!='') $AddSql .= " , InTime='".$InTime."' ";
			 $AddSql .= " , OutTime='".$OutTime."' ";
			$sql = "update h_attendence set UpdatedDate='".$Config['TodayDate']."' ".$AddSql."  where attID = '".mysql_real_escape_string($attID)."'"; 
			$rs = $this->query($sql,0);

			/*********************/
			if($OutTime!=''){
				$this->updateAttOtherThings($arryDetails);
			}	
			/*********************/		

		}
			
		return true;
	}


	function updateAttOtherThings($arryDetails)
	{
		global $Config;
		@extract($arryDetails);	
		/****************************/
		$sqlatt = "select a.*,e.Overtime from h_attendence a inner join h_employee e on a.EmpID=e.EmpID where a.attID = '".mysql_real_escape_string($attID)."' "; 
		$arryAtten = $this->query($sqlatt, 1);
		$EmpID = $arryAtten[0]['EmpID'];
		//echo '<pre>';print_r($arryAtten);exit;
		/****************************/
		$strLoc = "select WorkingHourStart, WorkingHourEnd, UseShift, HalfDayHour, Overtime, OvertimeRate, LunchPaid, ShortBreakPaid from location where locationID='".$_SESSION['locationID']."'";
		$arryLocation = $this->query($strLoc, 1);
		if($arryLocation[0]['UseShift']==1){		
			$strSQL = "select e.shiftID, s.WorkingHourStart, s.WorkingHourEnd,s.LunchPaid,s.ShortBreakPaid from h_employee e inner join h_shift s on e.shiftID=s.shiftID where e.EmpID='".$arryAtten[0]['EmpID']."'";
			$arryEmp = $this->query($strSQL, 1);
			if(!empty($arryEmp[0]['WorkingHourStart'])){
				$WorkingHourStart = $arryEmp[0]['WorkingHourStart'];
				$WorkingHourEnd = $arryEmp[0]['WorkingHourEnd'];
				$LunchPaid = $arryEmp[0]['LunchPaid'];
				$ShortBreakPaid = $arryEmp[0]['ShortBreakPaid'];	
			}
		}else{
			$WorkingHourStart = $arryLocation[0]['WorkingHourStart'];
			$WorkingHourEnd = $arryLocation[0]['WorkingHourEnd'];
			$LunchPaid = $arryLocation[0]['LunchPaid'];
			$ShortBreakPaid = $arryLocation[0]['ShortBreakPaid'];		
		}

		$EmpWorkingHour = $this->GetTimeDifference($arryAtten[0]['InTime'],$arryAtten[0]['OutTime'],1);
		$WorkingHour = $this->GetTimeDifference($WorkingHourStart,$WorkingHourEnd,1);

		/****************************/
		/****************************/
		//Auto entry for leave for less hours
//echo $EmpWorkingHour.'='.$arryLocation[0]['HalfDayHour'];exit;
		if($EmpWorkingHour<$arryLocation[0]['HalfDayHour']){
			$arryLeaveType = $this->GetAttributeInner('LeaveType','');
			$strLeave = "select LeaveID from `h_leave` where EmpID='".$EmpID."' and (FromDate>='".$attDate."' or ToDate>='".$attDate."') ";
			$arryLeave = $this->query($strLeave, 1);
			if(empty($arryLeave[0]['LeaveID'])){
				$sql = "insert into `h_leave`(EmpID, LeaveType, Days, FromDate, ToDate, ApplyDate, Status) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".$arryLeaveType[0]['attribute_value']."', '1', '".mysql_real_escape_string(strip_tags($attDate))."', '".mysql_real_escape_string(strip_tags($attDate))."', '".mysql_real_escape_string(strip_tags($attDate))."', 'Taken')"; 
				$this->query($sql, 0);
			}
		}
		
		/******************************************/
		/************* Overtime Entry *************
		if($EmpWorkingHour>0 && $arryLocation[0]['Overtime']==1 && $arryAtten[0]['Overtime']==1){
			
			/****************			
			$BreakType = '';
			if($LunchPaid!=1) $BreakType .= "'Lunch',";
			if($ShortBreakPaid!=1) $BreakType .= "'Short Break',";
			$BreakType =rtrim($BreakType,",");
			if(!empty($BreakType)){
				$arryBreakTime=$this->getBreakTime($attID,$BreakType);
				foreach($arryBreakTime as $keytime=>$valuestime){		
					$BreakTime += ConvertToSecond($valuestime['TimeDuration']);
				}
				$BreakTime = $BreakTime/3600;
	
			}
		


			if($EmpWorkingHour > $WorkingHour){
				$Hours = $EmpWorkingHour - $WorkingHour - $BreakTime;
				$OvDate = $attDate;	
				$HoursRate = round($Hours*$arryLocation[0]['OvertimeRate'],2);

				$sql = "select OvID from h_overtime where EmpID='".$EmpID."' and OvDate='".$OvDate."'";
				$arryRow = $this->query($sql, 1);
				if(!empty($arryRow[0]['OvID'])) {
					 $sql = "update h_overtime set attID='".$attID."', WorkingHourStart='".$WorkingHourStart."', WorkingHourEnd='".$WorkingHourEnd."', Hours='".$Hours."',InTime='".$arryAtten[0]['InTime']."', OutTime='".$arryAtten[0]['OutTime']."', OvRate = '".$arryLocation[0]['OvertimeRate']."',HoursRate = '".$HoursRate."', UpdatedDate='".$Config['TodayDate']."' where OvID = ".$arryRow[0]['OvID']; 
				}else{
					$sql = "insert into h_overtime(EmpID, attID, OvDate, WorkingHourStart, WorkingHourEnd, Hours, OvRate, HoursRate, UpdatedDate, InTime, OutTime) values('".$EmpID."', '".$attID."', '".$OvDate."', '".$WorkingHourStart."', '".$WorkingHourEnd."', '".$Hours."', '".$arryLocation[0]['OvertimeRate']."', '".$HoursRate."', '".$Config['TodayDate']."', '".$arryAtten[0]['InTime']."', '".$arryAtten[0]['OutTime']."')";
				}
				$this->query($sql, 0);
			}
		

		}
	
		/*****************************************/		
		return true;

	}



	function  GetAttributeInner($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' and locationID='".$_SESSION['locationID']."'"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}



	function getAttendence($depID,$attID=0,$EmpID=0,$attDate,$year,$month){

		global $Config;

		/**************/
		$attDate = DefaultDateFormat($attDate);
		/**************/

		$sql = " where 1";
		$sql .= (!empty($attID))?(" and a.attID = '".mysql_real_escape_string($attID)."'"):("");
		$sql .= ($EmpID>0)?(" and a.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
		$sql .= (!empty($depID))?(" and d.depID = '".mysql_real_escape_string($depID)."'"):("");
		$sql .= (!empty($attDate))?(" and a.attDate = '".mysql_real_escape_string($attDate)."'"):("");
		

		if($_GET['fby']=='Date'){
			$startDate = $_GET['f'];
			$endDate = $_GET['t'];

			/**************/
			$startDate = DefaultDateFormat($startDate);
			$endDate = DefaultDateFormat($endDate);		 
			/**************/

			$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";	

		}else if(!empty($year) && !empty($month)){
			$startDate = $year.'-'.$month.'-01';
			$endDate = $year.'-'.$month.'-31';
			$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";
		}

		$sql .= " order by e.UserName asc, a.attDate Asc ";

		if($Config['GetNumRecords']==1){
			$Columns = " count(a.attID) as NumCount ";				
		}else{				
			$Columns = "  a.*,TIMEDIFF(a.OutTime,a.InTime) as TimeDuration, s.shiftName,s.LunchPaid,s.ShortBreakPaid, e.EmpCode, e.UserName,e.JobTitle, d.Department ";
			if($Config['RecordsPerPage']>0){
				$sql .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
	
		}

		$sql = "select ".$Columns." from h_attendence a inner join h_employee e on a.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID left outer join  h_shift s on e.shiftID=s.shiftID ".$sql; 

		return $this->query($sql, 1);
	}


	function getHrsWorked($EmpID,$FromDate,$ToDate)
	{
		$sql = "select a.* from h_attendence a inner join h_employee e on a.EmpID=e.EmpID where a.EmpID = '".mysql_real_escape_string($EmpID)."' and a.attDate>='".mysql_real_escape_string($FromDate)."' and a.attDate<='".mysql_real_escape_string($ToDate)."'  "; 
		$arryAtten = $this->query($sql, 1);
		$num=sizeof($arryAtten);
		$TotalDuration=0;
		foreach($arryAtten as $key=>$values){
			$Duration = 0;
			if(!empty($values["InTime"]) && !empty($values["OutTime"])){
				$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
				if($Duration<0) $Duration=0;
				$TotalDuration += $Duration;		
			}
		}
		
		if($TotalDuration>0){
			$TotalDuration = round($TotalDuration / 3600,2);
		}
		$arryWork['HrsWorked'] = $TotalDuration;
		$arryWork['DaysWorked'] = $num;
		return $arryWork;
	}


	function deleteAttendence($attID)
	{
		if(!empty($attID)){
			$sql = "delete from h_attendence where attID in ( ".$attID.")";
			$this->query($sql,0);
			$sql2 = "delete from  h_overtime where attID in ( ".$attID.")";
			$this->query($sql2,0);
			$sql3 = "delete from h_att_punching where attID in ( ".$attID.")";
			$this->query($sql3,0);
		}

		return true;

	}	

	function UploadAttendanceOld($arryAttendance,$Year,$Month)  
	{
		global $Config;
		$Count=0;
		foreach($arryAttendance as $key=>$values){
			
			$strSQL = "select EmpID from h_employee where EmpCode='".$values["EmpCode"]."' and locationID='".$_SESSION['locationID']."'";
			$arryEmp = $this->query($strSQL, 1);
			$EmpID = $arryEmp[0]['EmpID'];
			if($EmpID>0){
				
				for($i=1;$i<=31;$i++){
					$InTime = $values['InTime'][$i];
					$InComment = $values['InComment'][$i];
					$OutTime = $values['OutTime'][$i];
					$OutComment = $values['OutComment'][$i];
					if(!empty($InTime) || !empty($InComment) || !empty($OutTime) || !empty($OutComment) ){
						$d = $i;
						if($d<10) $d = '0'.$d;
						$attDate = $Year.'-'.$Month.'-'.$d;
						#echo $EmpID.' '.$attDate.' '.$InTime.' '.$OutTime;exit;

						$sql = "select attID from h_attendence where EmpID='".$EmpID."' and attDate='".$attDate."'";
						$arryRow = $this->query($sql, 1);
						if(!empty($arryRow[0]['attID'])) {
							$sql = "update h_attendence set attDate='".$attDate."',InTime='".$InTime."', OutTime='".$OutTime."', InComment='".addslashes(strip_tags($InComment))."', OutComment = '".addslashes(strip_tags($OutComment))."', UpdatedDate='".$Config['TodayDate']."' where attID = '".$arryRow[0]['attID']."'"; 
						}else{
							$sql = "insert into h_attendence(EmpID, attDate, InTime, OutTime, InComment, OutComment, UpdatedDate) values('".$EmpID."', '".$attDate."', '".$InTime."', '".$OutTime."', '".addslashes(strip_tags($InComment))."', '".addslashes(strip_tags($OutComment))."', '".$Config['TodayDate']."')";
						}
						//echo $sql.'<br><br>';
						$this->query($sql, 0);

						$Count++;


					} //end if


				} //end for	
				
				
			} //end if


		} //end foreach



		return $Count;

	}







	function UploadAttendanceOld2($arryAttendance,$Year,$Month)  
	{
		global $Config;
		$Count=0;
		
		foreach($arryAttendance as $key=>$values){
			
			$strSQL = "select EmpID from h_employee where EmpCode='".$values["EmpCode"]."' and locationID='".$_SESSION['locationID']."'";
			$arryEmp = $this->query($strSQL, 1);
			$EmpID = $arryEmp[0]['EmpID'];
			if($EmpID>0){
				
				for($i=1;$i<=31;$i++){
					$InTime = $values['InTime'][$i];
					$InComment = $values['InComment'][$i];
					$OutTime = $values['OutTime'][$i];
					$OutComment = $values['OutComment'][$i];
					if(!empty($InTime) || !empty($InComment) || !empty($OutTime) || !empty($OutComment) ){
						$d = $i;
						if($d<10) $d = '0'.$d;
						$attDate = $Year.'-'.$Month.'-'.$d;
						#echo $EmpID.' '.$attDate.' '.$InTime.' '.$OutTime;exit;

						$sql = "select attID from h_attendence where EmpID='".$EmpID."' and attDate='".$attDate."'";
						$arryRow = $this->query($sql, 1);
						if(!empty($arryRow[0]['attID'])) {
							$sql = "update h_attendence set attDate='".$attDate."',InTime='".$InTime."', OutTime='".$OutTime."', InComment='".addslashes(strip_tags($InComment))."', OutComment = '".addslashes(strip_tags($OutComment))."', UpdatedDate='".$Config['TodayDate']."' where attID = '".$arryRow[0]['attID']."'"; 
							$this->query($sql, 0);
							$attID = $arryRow[0]['attID'];
						}else{
							$sql = "insert into h_attendence(EmpID, attDate, InTime, OutTime, InComment, OutComment, UpdatedDate) values('".$EmpID."', '".$attDate."', '".$InTime."', '".$OutTime."', '".addslashes(strip_tags($InComment))."', '".addslashes(strip_tags($OutComment))."', '".$Config['TodayDate']."')";
							$this->query($sql, 0);
							$attID = $this->lastInsertId();
					   }						

						/******************************************/
						$EmpWorkingHour = $this->GetTimeDifference($InTime,$OutTime,1);
						/************* Overtime Entry *************/
						if($EmpWorkingHour>0 && $Config['Overtime']==1 && !empty($Config['WorkingHour']) && !empty($OutTime)){
							
							if($EmpWorkingHour > $Config['WorkingHour']){
								$Hours = $EmpWorkingHour - $Config['WorkingHour'];
								$OvDate = $attDate;
								$StartTime = $InTime;
								$EndTime = $OutTime;
								$HoursRate = round($Hours*$Config['OvertimeRate'],2);

								$sql = "select OvID from h_overtime where EmpID='".$EmpID."' and OvDate='".$OvDate."'";
								$arryRow = $this->query($sql, 1);
								if(!empty($arryRow[0]['OvID'])) {
									$sql = "update h_overtime set attID='".$attID."', WorkingHourStart='".$Config['WorkingHourStart']."', WorkingHourEnd='".$Config['WorkingHourEnd']."', Hours='".$Hours."',InTime='".$InTime."', OutTime='".$OutTime."', OvRate = '".$Config['OvertimeRate']."',HoursRate = '".$HoursRate."', UpdatedDate='".$Config['TodayDate']."' where OvID = '".$arryRow[0]['OvID']."'"; 
								}else{
									$sql = "insert into h_overtime(EmpID, attID, OvDate, WorkingHourStart, WorkingHourEnd, Hours, OvRate, HoursRate, UpdatedDate, InTime, OutTime) values('".$EmpID."', '".$attID."', '".$OvDate."', '".$Config['WorkingHourStart']."', '".$Config['WorkingHourEnd']."', '".$Hours."', '".$Config['OvertimeRate']."', '".$HoursRate."', '".$Config['TodayDate']."', '".$InTime."', '".$OutTime."')";
								}
								$this->query($sql, 0);
							}
							

						}
						/*****************************************/
						/************* Leave Entry *************/
						$LeaveEntry = ''; $Days=0; $ShortLeave=0;
						if($InComment == $Config['LableLeave'] || $OutComment == $Config['LableLeave'] || ($EmpWorkingHour>0 && $EmpWorkingHour < $Config['HalfDayHour'])){
							$LeaveEntry = 1; //full leave
							$Days = 1;							
							$FromDateHalf=0;
						}else if($EmpWorkingHour > 0 && $EmpWorkingHour < $Config['FullDayHour']){
							$LeaveEntry = 1; //half leave
							$Days = 0.5;
							$FromDateHalf=1;
						}else if((!empty($InTime) && strtotime($InTime) > strtotime($Config['SL_Coming']) ) || (!empty($OutTime) && strtotime($OutTime) < strtotime($Config['SL_Leaving']))){
							$ShortLeave = 1; //short leave
						}
						

						if($LeaveEntry==1){	//Full Day & Half Day Leave Entry
							$sql = "select LeaveID from h_leave where EmpID='".$EmpID."' and FromDate<='".$attDate."' and ToDate>='".$attDate."'";
							$arryRow = $this->query($sql, 1);							
							if(!empty($arryRow[0]['LeaveID'])) {
								// update not working now								
							}else{
								$sql = "insert into `h_leave`(EmpID, LeaveType, Days, FromDate, ToDate, FromDateHalf, ApplyDate, Status) values('".$EmpID."', 'Casual', '".$Days."', '".$attDate."', '".$attDate."', '".$FromDateHalf."', '".$attDate."', 'Taken')"; 
								//echo $sql; exit;
								$this->query($sql, 0);
							}

						}else if($ShortLeave==1){	 //Short Leave Entry
								$sql = "select StID from h_shortleave where EmpID='".$EmpID."' and attDate='".$attDate."'";
								$arryRow = $this->query($sql, 1);
								if(!empty($arryRow[0]['StID'])) {
									$sql = "update h_shortleave set attID='".$attID."', WorkingHourStart='".$Config['WorkingHourStart']."', WorkingHourEnd='".$Config['WorkingHourEnd']."',InTime='".$InTime."', OutTime='".$OutTime."', UpdatedDate='".$Config['TodayDate']."' where StID = '".$arryRow[0]['StID']."'"; 
								}else{
									$sql = "insert into h_shortleave(EmpID, attID, attDate, WorkingHourStart, WorkingHourEnd,  UpdatedDate, InTime, OutTime) values('".$EmpID."', '".$attID."', '".$attDate."', '".$Config['WorkingHourStart']."', '".$Config['WorkingHourEnd']."', '".$Config['TodayDate']."', '".$InTime."', '".$OutTime."')";
								}
								$this->query($sql, 0);


						}

						/*****************************************/


						$Count++;


					} //end if


				} //end for	
				
				
			} //end if


		} //end foreach



		return $Count;

	}



	/*************************************/
	/*************************************/

	function UploadAttendance($arryAttendance,$Year,$Month)  
	{
		global $Config;
		$Count=0;
		
		foreach($arryAttendance as $key=>$values){
			
			$WorkingHourStart = $Config['WorkingHourStart'];
			$WorkingHourEnd = $Config['WorkingHourEnd'];

			$strSQL = "select e.EmpID,s.shiftID,WorkingHourStart,WorkingHourEnd,SL_Coming,SL_Leaving from h_employee e left outer join h_shift s on e.shiftID=s.shiftID where e.EmpCode='".$values["EmpCode"]."' and e.locationID='".$_SESSION['locationID']."'";
			$arryEmp = $this->query($strSQL, 1);
			$EmpID = $arryEmp[0]['EmpID'];


			if($EmpID>0){

				$ShiftWorkingHour = 0;
				if(!empty($arryEmp[0]['WorkingHourStart']) && !empty($arryEmp[0]['WorkingHourEnd'])){

					$WorkingHourStart = $arryEmp[0]['WorkingHourStart'];
					$WorkingHourEnd = $arryEmp[0]['WorkingHourEnd'];

					$ShiftWorkingHour = $this->GetTimeDifference($arryEmp[0]['WorkingHourStart'],$arryEmp[0]['WorkingHourEnd'],1);
				}
				$WorkingHour = ($ShiftWorkingHour>0)?($ShiftWorkingHour):($Config['WorkingHour']);
				$SL_Coming = (!empty($arryEmp[0]['SL_Coming']))?($arryEmp[0]['SL_Coming']):($Config['SL_Coming']);
				$SL_Leaving = (!empty($arryEmp[0]['SL_Leaving']))?($arryEmp[0]['SL_Leaving']):($Config['SL_Leaving']);

				
				for($i=1;$i<=31;$i++){
					$InTime = $values['InTime'][$i];
					$InComment = $values['InComment'][$i];
					$OutTime = $values['OutTime'][$i];
					$OutComment = $values['OutComment'][$i];
					if(!empty($InTime) || !empty($InComment) || !empty($OutTime) || !empty($OutComment) ){
						$d = $i;
						if($d<10) $d = '0'.$d;
						$attDate = $Year.'-'.$Month.'-'.$d;
						#echo $EmpID.' '.$attDate.' '.$InTime.' '.$OutTime;exit;

						$sql = "select attID from h_attendence where EmpID='".$EmpID."' and attDate='".$attDate."'";
						$arryRow = $this->query($sql, 1);
						if(!empty($arryRow[0]['attID'])) {
							$sql = "update h_attendence set attDate='".$attDate."',InTime='".$InTime."', OutTime='".$OutTime."', InComment='".addslashes(strip_tags($InComment))."', OutComment = '".addslashes(strip_tags($OutComment))."', UpdatedDate='".$Config['TodayDate']."' where attID = '".$arryRow[0]['attID']."'"; 
							$this->query($sql, 0);
							$attID = $arryRow[0]['attID'];
						}else{
							$sql = "insert into h_attendence(EmpID, attDate, InTime, OutTime, InComment, OutComment, UpdatedDate, WorkingHourStart, WorkingHourEnd) values('".$EmpID."', '".$attDate."', '".$InTime."', '".$OutTime."', '".addslashes(strip_tags($InComment))."', '".addslashes(strip_tags($OutComment))."', '".$Config['TodayDate']."' , '".addslashes($WorkingHourStart)."', '".addslashes($WorkingHourEnd)."' )";
							$this->query($sql, 0);
							$attID = $this->lastInsertId();
					   }						

						/******************************************/
						$EmpWorkingHour = $this->GetTimeDifference($InTime,$OutTime,1);
						/************* Overtime Entry *************/
						if($EmpWorkingHour>0 && $Config['Overtime']==1 && !empty($WorkingHour) && !empty($OutTime)){
							
							if($EmpWorkingHour > $WorkingHour){
								$Hours = $EmpWorkingHour - $WorkingHour;
								$OvDate = $attDate;
								$StartTime = $InTime;
								$EndTime = $OutTime;
								$HoursRate = round($Hours*$Config['OvertimeRate'],2);

								$sql = "select OvID from h_overtime where EmpID='".$EmpID."' and OvDate='".$OvDate."'";
								$arryRow = $this->query($sql, 1);
								if(!empty($arryRow[0]['OvID'])) {
									$sql = "update h_overtime set attID='".$attID."', WorkingHourStart='".$Config['WorkingHourStart']."', WorkingHourEnd='".$Config['WorkingHourEnd']."', Hours='".$Hours."',InTime='".$InTime."', OutTime='".$OutTime."', OvRate = '".$Config['OvertimeRate']."',HoursRate = '".$HoursRate."', UpdatedDate='".$Config['TodayDate']."' where OvID = '".$arryRow[0]['OvID']."'"; 
								}else{
									$sql = "insert into h_overtime(EmpID, attID, OvDate, WorkingHourStart, WorkingHourEnd, Hours, OvRate, HoursRate, UpdatedDate, InTime, OutTime) values('".$EmpID."', '".$attID."', '".$OvDate."', '".$Config['WorkingHourStart']."', '".$Config['WorkingHourEnd']."', '".$Hours."', '".$Config['OvertimeRate']."', '".$HoursRate."', '".$Config['TodayDate']."', '".$InTime."', '".$OutTime."')";
								}
								$this->query($sql, 0);
							}
							

						}
						/*****************************************/
						/************* Leave Entry *************/
						$LeaveEntry = ''; $Days=0; $ShortLeave=0;
						if($InComment == $Config['LableLeave'] || $OutComment == $Config['LableLeave'] || ($EmpWorkingHour>0 && $EmpWorkingHour < $Config['HalfDayHour'])){
							$LeaveEntry = 1; //full leave
							$Days = 1;							
							$FromDateHalf=0;
						}else if($EmpWorkingHour > 0 && $EmpWorkingHour < $Config['FullDayHour']){
							$LeaveEntry = 1; //half leave
							$Days = 0.5;
							$FromDateHalf=1;
						}else if((!empty($InTime) && strtotime($InTime) > strtotime($SL_Coming) ) || (!empty($OutTime) && strtotime($OutTime) < strtotime($SL_Leaving))){
							$ShortLeave = 1; //short leave
						}
						

						if($LeaveEntry==1){	//Full Day & Half Day Leave Entry
							$sql = "select LeaveID from h_leave where EmpID='".$EmpID."' and FromDate<='".$attDate."' and ToDate>='".$attDate."'";
							$arryRow = $this->query($sql, 1);							
							if(!empty($arryRow[0]['LeaveID'])) {
								// update not working now								
							}else{
								$sql = "insert into `h_leave`(EmpID, LeaveType, Days, FromDate, ToDate, FromDateHalf, ApplyDate, Status) values('".$EmpID."', 'Casual', '".$Days."', '".$attDate."', '".$attDate."', '".$FromDateHalf."', '".$attDate."', 'Taken')"; 
								//echo $sql; exit;
								$this->query($sql, 0);
							}

						}else if($ShortLeave==1){	 //Short Leave Entry
								$sql = "select StID from h_shortleave where EmpID='".$EmpID."' and attDate='".$attDate."'";
								$arryRow = $this->query($sql, 1);
								if(!empty($arryRow[0]['StID'])) {
									$sql = "update h_shortleave set attID='".$attID."', WorkingHourStart='".$Config['WorkingHourStart']."', WorkingHourEnd='".$Config['WorkingHourEnd']."',InTime='".$InTime."', OutTime='".$OutTime."', UpdatedDate='".$Config['TodayDate']."' where StID = '".$arryRow[0]['StID']."'"; 
								}else{
									$sql = "insert into h_shortleave(EmpID, attID, attDate, WorkingHourStart, WorkingHourEnd,  UpdatedDate, InTime, OutTime) values('".$EmpID."', '".$attID."', '".$attDate."', '".$Config['WorkingHourStart']."', '".$Config['WorkingHourEnd']."', '".$Config['TodayDate']."', '".$InTime."', '".$OutTime."')";
								}
								$this->query($sql, 0);


						}

						/*****************************************/


						$Count++;


					} //end if


				} //end for	
				
				
			} //end if


		} //end foreach



		return $Count;

	}


	/*************************************/
	/*************************************/


	function GetTimeDifference($start,$end,$integer=0){
		$s = strtotime($end) - strtotime($start);
		$m=0;$hr=0;$d=0; $td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			$td = "$d day"; if($d>1) $td .= "s";
			if($d<3){
				if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		//if($s>0) $td .=  " $s sec";
		
		if($integer==1){
			$Hour=$Minute='';
			$FinalArry = explode(",",$td);
			if(!empty($FinalArry[0]))$Hour = (int)$FinalArry[0]; 
			if(!empty($FinalArry[1]))$Minute = (int)$FinalArry[1];
			$Minute = round($Minute/60,2);
			$FinalDuration = ($Minute>0)?($Hour+$Minute):($Hour);
			$td = $FinalDuration;
		}
		

		return $td;
	}


	/********** Timesheet Management *********/
	/*******************************************/

	function AddTimesheet($arryDetails)  
	{
		@extract($arryDetails);	

		$strSQLQuery ="select tmID from h_timesheet where EmpID='".mysql_real_escape_string($EmpID)."' and FromDate='".$FromDate."' and ToDate='".$ToDate."'";
		$arryRow = $this->query($strSQLQuery, 1);
		if(!empty($arryRow[0]['tmID'])) {
			$tmID = $arryRow[0]['tmID'];
		}else {
			$sql = "insert into h_timesheet(EmpID, tmDate, FromDate, ToDate) values('".$EmpID."', '".$tmDate."', '".$FromDate."', '".$ToDate."')"; 
			$this->query($sql, 0);
			$tmID = $this->lastInsertId();
		}		

		$sql2 = "insert into h_timesheet_detail(tmID, Project, Activity, Time1, Time2, Time3, Time4, Time5, Time6, Time7) values('".$tmID."', '".addslashes($Project)."', '".addslashes($Activity)."', '".$Time1."', '".$Time2."', '".$Time3."', '".$Time4."', '".$Time5."', '".$Time6."', '".$Time7."')"; 
		$this->query($sql2, 0);

		return true;

	}

	function getTimesheetPeriod($tmID=0,$EmpID=0)
	{
		$sql = " where 1";
		$sql .= (!empty($tmID))?(" and t.tmID = '".$tmID."'"):("");
		$sql .= ($EmpID>0)?(" and t.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".$_SESSION['locationID']."'");

		$sql = "select t.*,e.UserName,d.Department from h_timesheet t inner join h_employee e on t.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID ".$sql." order by t.FromDate Desc, tmID asc " ; 
		return $this->query($sql, 1);
	}

	function getTimesheet($detID=0,$EmpID=0,$tmID=0)
	{
		$sql = " where 1";
		$sql .= (!empty($detID))?(" and td.detID = '".mysql_real_escape_string($detID)."'"):("");
		$sql .= (!empty($tmID))?(" and td.tmID = '".mysql_real_escape_string($tmID)."'"):("");
		$sql .= ($EmpID>0)?(" and t.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".$_SESSION['locationID']."'");

		$sql = "select td.*,t.FromDate,t.ToDate, e.UserName,d.Department from h_timesheet_detail td inner join h_timesheet t on td.tmID=t.tmID inner join h_employee e on t.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID ".$sql." order by td.detID asc " ; 
		return $this->query($sql, 1);
	}
	
	/********** Overtime Management *********/
	function getOvertime55($depID,$OvID=0,$EmpID=0,$OvDate,$year,$month)
	{
		$sql = " where 1";
		$sql .= (!empty($OvID))?(" and a.OvID = '".mysql_real_escape_string($OvID)."'"):("");
		$sql .= ($EmpID>0)?(" and a.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
		$sql .= (!empty($depID))?(" and d.depID = '".mysql_real_escape_string($depID)."'"):("");
		$sql .= (!empty($OvDate))?(" and a.OvDate = '".mysql_real_escape_string($OvDate)."'"):("");

		if($_GET['fby']=='Date'){
			$startDate = $_GET['f'];
			$endDate = $_GET['t'];
			$sql .= " and a.OvDate>='".mysql_real_escape_string($startDate)."' and a.OvDate<='".mysql_real_escape_string($endDate)."'";	

		}else if(!empty($year) && !empty($month)){
			$startDate = $year.'-'.$month.'-01';
			$endDate = $year.'-'.$month.'-31';
			$sql .= " and a.OvDate>='".mysql_real_escape_string($startDate)."' and a.OvDate<='".mysql_real_escape_string($endDate)."'";
		}


		  $sql = "select a.*, TIMEDIFF(a.OutTime,a.InTime) as TimeDuration, e.EmpCode, e.UserName,e.JobTitle, d.Department,s.shiftName from h_overtime a inner join h_employee e on a.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID left outer join  h_shift s on e.shiftID=s.shiftID ".$sql." order by e.UserName asc, a.OvDate Asc "; 
		return $this->query($sql, 1);
	}
	
	function getOvertime($depID,$OvID=0,$EmpID=0,$attDate,$year,$month)
	{
		global $Config;

		$sql = "";
		$sql .= ($EmpID>0)?(" and a.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
		$sql .= (!empty($depID))?(" and d.depID = '".mysql_real_escape_string($depID)."'"):("");
		$sql .= (!empty($attDate))?(" and a.attDate = '".mysql_real_escape_string($attDate)."'"):("");
		if($_GET['fby']=='Date'){
			$startDate = $_GET['f'];
			$endDate = $_GET['t'];

			/**************/
			$startDate = DefaultDateFormat($startDate);
			$endDate = DefaultDateFormat($endDate);		 
			/**************/


			$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";	

		}else if(!empty($year) && !empty($month)){
			$startDate = $year.'-'.$month.'-01';
			$endDate = $year.'-'.$month.'-31';
			$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";
		}


		 $sql = "select a.*,TIMEDIFF(a.OutTime,a.InTime) as TimeDuration, TIMEDIFF(a.WorkingHourEnd,a.WorkingHourStart) as WorkingDuration, e.EmpCode, e.UserName,e.JobTitle, d.Department, s.shiftName ,s.LunchPaid, s.ShortBreakPaid from h_attendence a inner join h_employee e on a.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID left outer join  h_shift s on e.shiftID=s.shiftID where a.OutTime!=''   and e.Overtime='1'  ".$sql." 
HAVING TimeDuration>WorkingDuration
order by e.UserName asc, a.attDate Asc "; 


		return $this->query($sql, 1);
	}




	function deleteOvertime($OvID)
	{
		if(!empty($OvID)){
			$sql = "delete from h_overtime where OvID in ( ".$OvID.")";
			$rs = $this->query($sql,0);
		}

		return true;

	}

	function getTotalOvertime($EmpID=0,$year,$month)
	{
		if(!empty($EmpID)){
			$sql = "";
			if(!empty($year) && !empty($month)){
				$startDate = $year.'-'.$month.'-01';
				$endDate = $year.'-'.$month.'-31';
				$sql .= " and a.OvDate>='".mysql_real_escape_string($startDate)."' and a.OvDate<='".mysql_real_escape_string($endDate)."'";
			}

			$sql = "select sum(a.Hours) as TotalHour, sum(a.HoursRate) as TotalHoursRate  from h_overtime a inner join h_employee e on a.EmpID=e.EmpID where a.EmpID = '".mysql_real_escape_string($EmpID)."' ".$sql; 
			return $this->query($sql, 1);
		}
	}

	function getOvertimeByDate($attID,$EmpID,$OvDate)
	{
		if(!empty($EmpID)){
			$sql .= (!empty($attID))?(" and a.attID = '".mysql_real_escape_string($attID)."'"):("");
			$sql .= (!empty($OvDate))?(" and a.OvDate = '".mysql_real_escape_string($OvDate)."'"):("");
			
			$sql = "select Hours  from h_overtime a inner join h_employee e on a.EmpID=e.EmpID where a.EmpID = '".mysql_real_escape_string($EmpID)."' ".$sql; 
			return $this->query($sql, 1);
		}
	}
	/*****************************************/
	/********** ShortLeave Management *********/
	function getShortLeave555($depID,$StID=0,$EmpID=0,$attDate,$year,$month)
	{
		$sql = " where 1";
		$sql .= (!empty($StID))?(" and a.StID = '".mysql_real_escape_string($StID)."'"):("");
		$sql .= ($EmpID>0)?(" and a.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
		$sql .= (!empty($depID))?(" and d.depID = '".mysql_real_escape_string($depID)."'"):("");
		$sql .= (!empty($attDate))?(" and a.attDate = '".mysql_real_escape_string($attDate)."'"):("");
		if(!empty($year) && !empty($month)){
			$startDate = $year.'-'.$month.'-01';
			$endDate = $year.'-'.$month.'-31';
			$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";
		}


		$sql = "select a.*,e.EmpCode, e.UserName,e.JobTitle, d.Department from h_shortleave a inner join h_employee e on a.EmpID=e.EmpID inner join  h_department d on e.Department=d.depID ".$sql." order by e.UserName asc, a.attDate Asc "; 
		return $this->query($sql, 1);
	}

	function getShortLeave($depID,$EmpID=0,$attDate,$year,$month)
	{
		global $Config;
		if(empty($Config['FullDayHour'])) $Config['FullDayHour']=5;
		$Config['FullDayHour']= $Config['FullDayHour']*3600;

		$sql = "";
		$sql .= ($EmpID>0)?(" and a.EmpID = '".mysql_real_escape_string($EmpID)."'"):(" and e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
		$sql .= (!empty($depID))?(" and d.depID = '".mysql_real_escape_string($depID)."'"):("");
		$sql .= (!empty($attDate))?(" and a.attDate = '".mysql_real_escape_string($attDate)."'"):("");
		if(!empty($year) && !empty($month)){
			$startDate = $year.'-'.$month.'-01';
			$endDate = $year.'-'.$month.'-31';
			$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";
		}

//having (a.FlexTime='1' and WorkingDuration>TimeDuration) 

		$sql = "select a.*,TIMEDIFF(a.OutTime,a.InTime) as TimeDuration, TIMEDIFF(a.WorkingHourEnd,a.WorkingHourStart) as WorkingDuration, e.EmpCode, e.UserName,e.JobTitle, d.Department from h_attendence a inner join h_employee e on a.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID where (a.SL_Coming!='' OR a.SL_Leaving!='') and (a.InTime>a.SL_Coming OR (a.OutTime<a.SL_Leaving and a.OutTime!=''))      ".$sql." 
HAVING 1=CASE WHEN (a.FlexTime='1' and a.OutTime!='') THEN (WorkingDuration>TimeDuration and TIME_TO_SEC(TimeDuration)>".$Config['FullDayHour'].") ELSE 1 END
order by e.UserName asc, a.attDate Asc "; 
		return $this->query($sql, 1);
	}

	function deleteShortLeave($StID)
	{
		if(!empty($StID)){
			$sql = "delete from h_shortleave where StID in ( ".$StID.")";
			$rs = $this->query($sql,0);
		}

		return true;

	}

	function getShortLeave55($EmpID=0,$year,$month)
	{
		if(!empty($EmpID)){
			$sql = "";
			if(!empty($year) && !empty($month)){
				$startDate = $year.'-'.$month.'-01';
				$endDate = $year.'-'.$month.'-31';
				$sql .= " and a.attDate>='".mysql_real_escape_string($startDate)."' and a.attDate<='".mysql_real_escape_string($endDate)."'";
			}

			$sql = "select count(a.StID) as TotalShortLeave from h_shortleave a inner join h_employee e on a.EmpID=e.EmpID where a.EmpID = '".mysql_real_escape_string($EmpID)."' ".$sql; 
			return $this->query($sql, 1);
		}
	}

	/*****************************************/
	/************* Punching Start ************/
	function getAttPunchingLast($arryDetails)
	{
		extract($arryDetails);
		if($EmpID>0 && $attID>0 && $punchType!=''){

		 $addsql = ($punchType!='Lunch')?(" and p.OutTime='' "):("");

		 $sql = "select p.* from h_att_punching p inner join h_attendence a on p.attID=a.attID inner join h_employee e on p.EmpID=e.EmpID  where p.punchType='".mysql_real_escape_string($punchType)."'  and p.attID='".mysql_real_escape_string($attID)."' and p.EmpID='".mysql_real_escape_string($EmpID)."' ".$addsql." order by p.punchID desc limit 0,1" ;
		return $this->query($sql, 1);
		}
	}

	function getLastPunch($EmpID,$attID)
	{
 
		if($EmpID>0 && $attID>0){
		 $sql = "select p.* from h_att_punching p inner join h_attendence a on p.attID=a.attID inner join h_employee e on p.EmpID=e.EmpID  where p.attID='".mysql_real_escape_string($attID)."' and p.EmpID='".mysql_real_escape_string($EmpID)."'  order by p.punchID desc limit 0,1" ;
		return $this->query($sql, 1);
		}
	}

	function getPunchingOutPending($attID, $EmpID)
	{
 
		if($EmpID>0 && $attID>0){
		 $sql = "select p.* from h_att_punching p inner join h_attendence a on p.attID=a.attID inner join h_employee e on p.EmpID=e.EmpID  where p.InTime!='' and p.OutTime='' and  p.attID='".mysql_real_escape_string($attID)."' and p.EmpID='".mysql_real_escape_string($EmpID)."' order by p.punchID desc limit 0,1" ;
		return $this->query($sql, 1);
		}
	}


	function getPunchingCount($attID, $EmpID, $punchType)
	{
		if($EmpID>0 && $attID>0){
		$sql = "select count(p.punchID) as TotalPunch from h_att_punching p inner join h_attendence a on p.attID=a.attID inner join h_employee e on p.EmpID=e.EmpID  where p.InTime!='' and p.OutTime!='' and  p.punchType='".mysql_real_escape_string($punchType)."' and  p.attID='".mysql_real_escape_string($attID)."' and p.EmpID='".mysql_real_escape_string($EmpID)."' " ;
		$arryRow = $this->query($sql, 1);
		return $arryRow[0]['TotalPunch'];
		}
	}

	function getAttPunching($attID,$EmpID,$punchDate)
	{
		$addsql = " where 1";
		$addsql .= (!empty($attID))?(" and p.attID = '".mysql_real_escape_string($attID)."'"):("");
		$addsql .= (!empty($EmpID))?(" and p.EmpID = '".mysql_real_escape_string($EmpID)."'"):("");
		$addsql .= (!empty($punchDate))?(" and p.punchDate = '".$punchDate."'"):("");

		$sql = "select p.*,TIMEDIFF(p.OutTime,p.InTime) as TimeDuration from h_att_punching p inner join h_attendence a on p.attID=a.attID inner join h_employee e on p.EmpID=e.EmpID  ".$addsql." order by p.punchID asc" ;
		return $this->query($sql, 1);
		
	}

	function addAttPunching($arryDetails)  
	{
		@extract($arryDetails);	
			

		$InTime = $OutTime; $InComment = $OutComment; //set

		$UpdatedDate = $attDate." ".$InTime;
		
		
		$strAtt = "select punchID from h_att_punching where attID='".$attID."' and EmpID='".$EmpID."' and punchType='".$punchType."' and punchDate='".$attDate."' and OutTime<=0 "; 
		$arryAtt = $this->query($strAtt, 1);
		

		if(empty($arryAtt[0]['punchID'])){
			$sql = "insert into h_att_punching(attID, EmpID, punchType, punchDate, InTime, InComment, UpdatedDate ) values('".mysql_real_escape_string($attID)."', '".mysql_real_escape_string($EmpID)."', '".mysql_real_escape_string($punchType)."', '".$attDate."', '".$InTime."', '".addslashes(strip_tags($InComment))."', '".$UpdatedDate."')";

			$this->query($sql, 0);
			$punchID = $this->lastInsertId();
		}

		return $punchID;

	}

	function updateAttPunching($arryDetails)
	{
		@extract($arryDetails);	

		if(!empty($punchID)){

			$UpdatedDate = $attDate." ".$OutTime;

			$sql = "update h_att_punching set OutTime='".$InTime."', OutComment = '".addslashes(strip_tags($InComment))."', UpdatedDate='".$UpdatedDate."' where punchID = '".mysql_real_escape_string($punchID)."'";
			$rs = $this->query($sql,0);

		}
			
		return true;
	}

 	
	function updateAttPunchingAdmin($attID , $EmpID, $attDate, $punchID, $punchType ,$InTimeVal , $OutTimeVal)
	{
		global $Config;
		
		$InTime=''; if(ConvertToSecond($InTimeVal)>0){$InTime = $InTimeVal; }
		$OutTime=''; if(ConvertToSecond($OutTimeVal)>0){$OutTime = $OutTimeVal;}

		if(!empty($punchID)){	
			if(!empty($InTime)){	
				$sql = "update h_att_punching set UpdatedDate='".$Config['TodayDate']."', InTime='".$InTime."' , OutTime='".$OutTime."'  where punchID = '".mysql_real_escape_string($punchID)."'";				
			}else{
				$sql = "delete from h_att_punching where punchID='".mysql_real_escape_string($punchID)."'"; 				
			}
			$this->query($sql, 0);
			 
		}else{
			if(!empty($InTime)){	
				$sql = "insert into h_att_punching(attID, EmpID, punchType, punchDate, InTime, OutTime, UpdatedDate ) values('".mysql_real_escape_string($attID)."', '".mysql_real_escape_string($EmpID)."', '".mysql_real_escape_string($punchType)."', '".$attDate."', '".$InTime."', '".$OutTime."', '".$Config['TodayDate']."')";	
				$this->query($sql, 0);	
			}	 
			 
		}
		
		
		return true;
	}

 


	function getBreakTime($attID,$punchType)
	{	
		if($attID>0 && $punchType!=''){
		  $sql = "select TIMEDIFF(p.OutTime,p.InTime) as TimeDuration from h_att_punching p  where p.punchType in (".$punchType.")  and p.attID='".mysql_real_escape_string($attID)."'  order by p.punchID desc " ;
		return $this->query($sql, 1);
		}
	}
	/*****************************************/
	/************** Punching End *************/

	function GetEmpWorkingHour($EmpID)
	{	
		/*************************/
		$strLoc = "select * from location where locationID='".$_SESSION['locationID']."'";
		$arryLocation = $this->query($strLoc, 1);	
		/*************************/
		$WorkingHourStart = $arryLocation[0]['WorkingHourStart'];
		$WorkingHourEnd = $arryLocation[0]['WorkingHourEnd'];	
		$LunchTimeInSecond=0;
		$ShortBreakSecond=0;
		if($arryLocation[0]['LunchPaid']!=1){
			$LunchTimeInSecond = ConvertToSecond($arryLocation[0]['LunchTime']);
		}
		if($arryLocation[0]['ShortBreakPaid']!=1){ 
			$ShortBreakSecond = $arryLocation[0]['ShortBreakLimit']*$arryLocation[0]['ShortBreakTime']*60;
		}
		

		if($arryLocation[0]['UseShift']==1){		
			$strSQL = "select s.* from h_employee e inner join h_shift s on e.shiftID=s.shiftID where e.EmpID='".$EmpID."'";
			$arryEmp = $this->query($strSQL, 1);
			if(!empty($arryEmp[0]['WorkingHourStart'])){
				$WorkingHourStart = $arryEmp[0]['WorkingHourStart'];
				$WorkingHourEnd = $arryEmp[0]['WorkingHourEnd'];				
			}
			$LunchTimeInSecond=0;
			$ShortBreakSecond=0;
			if($arryEmp[0]['LunchPaid']!=1){
				$LunchTimeInSecond = ConvertToSecond($arryEmp[0]['LunchTime']);
			}
			if($arryEmp[0]['ShortBreakPaid']!=1){ 
				$ShortBreakSecond = $arryEmp[0]['ShortBreakLimit']*$arryEmp[0]['ShortBreakTime']*60;
			}
		}


		if(!empty($WorkingHourStart) && !empty($WorkingHourEnd)){
			$HourToDeduct = round(($LunchTimeInSecond+$ShortBreakSecond)/3600,2);
			$WorkingHour = $this->GetTimeDifference($WorkingHourStart,$WorkingHourEnd,1) - $HourToDeduct;
			
		}

		return $WorkingHour;

	}
		


}
?>
