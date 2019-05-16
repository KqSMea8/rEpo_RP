<?
class leave extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function leave(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	/*********** Leave Period *********/
	/*********************************/

	function GetLeavePeriod(){
		$strSQLQuery ="select LeaveStart,LeaveEnd from location where locationID='".$_SESSION['locationID']."'";
		return $this->query($strSQLQuery, 1);
	}

	function UpdateLeavePeriod($arryDetails){
		extract($arryDetails);
		(!$ConfigID)?($ConfigID=1):(""); 
		$strSQL = "update location set LeaveStart='".stripslashes($LeaveStart)."', LeaveEnd='".stripslashes($LeaveEnd)."' where locationID='".$_SESSION['locationID']."'"; 
		$this->query($strSQL, 0);
		return 1; 
	}

	/********** Holiday Management *************/
	/*******************************************/

	function addHoliday($arryDetails)  
	{
		@extract($arryDetails);	
		$sql = "insert into h_holiday(locationID, heading, holidayDate, Status) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($holidayDate)."', '".$Status."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateHoliday($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update h_holiday set heading='".addslashes($heading)."', holidayDate = '".addslashes($holidayDate)."', Status = '".$Status."'  where holidayID = '".$holidayID."'"; 
		$rs = $this->query($sql,0);
			
		return true;
	}

	function getHoliday($id=0,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and holidayID = '".mysql_real_escape_string($id)."'"):(" and locationID=".$_SESSION['locationID']);
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from h_holiday ".$sql." order by holidayDate Asc" ; 
		return $this->query($sql, 1);
	}

	function changeHolidayStatus($holidayID)
	{
		if(!empty($holidayID)){
			$sql= "select * from h_holiday where holidayID='".$holidayID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update h_holiday set Status='".$Status."' where holidayID='".$holidayID."'";
				$this->query($sql,0);
			}		
		}

		return true;

	}

	function deleteHoliday($holidayID)
	{
		if(!empty($holidayID)){
			$sql = "delete from h_holiday where holidayID = '".mysql_real_escape_string($holidayID)."'";
			$rs = $this->query($sql,0);
		}

		return true;
	}
	

	function isHolidayExists($heading,$holidayID)
	{

		$strSQLQuery ="select * from h_holiday where LCASE(heading)='".strtolower(trim($heading))."' and locationID=".$_SESSION['locationID'];

		$strSQLQuery .= (!empty($holidayID))?(" and holidayID != '".$holidayID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['holidayID'])) {
			return true;
		} else {
			return false;
		}

	}

	function isHolidayDateExists($holidayDate,$holidayID)
	{

		$strSQLQuery ="select * from h_holiday where holidayDate='".trim($holidayDate)."' and locationID=".$_SESSION['locationID'];

		$strSQLQuery .= (!empty($holidayID))?(" and holidayID != '".$holidayID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['holidayID'])) {
			return true;
		} else {
			return false;
		}

	}


	function UploadHoliday($arryHoliday)  
	{
		global $Config;
		$objConfigure=new configure();
		$Count=0;
		foreach($arryHoliday as $key=>$values){				
				
					$heading = mysql_real_escape_string(strip_tags($values['heading']));
					$tempDate = mysql_real_escape_string(strip_tags($values['holidayDate']));
					$holidayDate = $objConfigure->ExcelToPHPDate($tempDate);
					


					if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/",$holidayDate))
					{
						$ValidDate = 1;
					}else{
						$ValidDate = 0;
					}

				//echo $holidayDate.'<br>'.$ValidDate;exit;	
					if(!empty($heading) && !empty($holidayDate) && $ValidDate==1){
						
						$sql = "select holidayID from h_holiday where  holidayDate='".$holidayDate."' and locationID=".$_SESSION['locationID'];
						$arryRow = $this->query($sql, 1);
						if(!empty($arryRow[0]['holidayID'])) {
							$sql = "update h_holiday set heading='".addslashes($heading)."' where holidayID = ".$arryRow[0]['holidayID']; 
						}else{
							$sql = "insert into h_holiday(locationID, heading, holidayDate, Status) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($holidayDate)."', '1')";
						}
						//echo $sql.'<br><br>';
						$this->query($sql, 0);

						$Count++;


					} //end if


				
				
			


		} //end foreach



		return $Count;

	}



	 

	/********** Entitlement Management *********/
	/*******************************************/
	function  ListEntitlement($id=0,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where e.EntID='".$id."'"):(" where em.locationID=".$_SESSION['locationID']);

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (em.EmpCode like '%".$SearchKey."%'  or em.UserName like '%".$SearchKey."%' or em.JobTitle like '%".$SearchKey."%' or em.JobType like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.LeaveType like '%".$SearchKey."%') " ):("");		
			}
			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by em.UserName asc, e.LeaveType asc ");

			$strSQLQuery = "select e.*,em.EmpCode,em.UserName,em.JobType,em.JobTitle,em.Email,d.Department from h_entitlement e inner join h_employee em on e.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
				
	}	

	function getEntitlement($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and e.EntID = '".mysql_real_escape_string($id)."'"):(" and em.locationID=".$_SESSION['locationID']);
		$sql = "select e.*,em.UserName,em.JobTitle,em.Email,em.JobType,d.Department from h_entitlement e inner join h_employee em on e.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID".$sql." order by e.EntID Asc" ; 
		return $this->query($sql, 1);
	}

	function deleteEntitlement($EntID){
		if(!empty($EntID)){
			$sql = "delete from h_entitlement where EntID = '".mysql_real_escape_string($EntID)."'";
			$rs = $this->query($sql,0);
		}
		return true;
	}

	function deleteEntitlementMulti($EntIDs)
	{
		if(!empty($EntIDs)){
			$sql = "delete from h_entitlement where EntID in ( ".$EntIDs.")";
			$rs = $this->query($sql,0);
		}

		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function addEntitlementOld($arryDetails)  
	{ 
		@extract($arryDetails);	
		foreach($arryDetails["EmpID"] as $MainEmpID){	
			$sql ="select EntID from h_entitlement where EmpID='".trim($MainEmpID)."' and LCASE(LeaveType)='".strtolower(trim($LeaveType))."' ";
			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['EntID'])) {
				$sql = "update h_entitlement set Days = '".$Days."' where EntID = ".$arryRow[0]['EntID']; 
			}else{
				$sql = "insert into h_entitlement( EmpID, LeaveStart, LeaveEnd, LeaveType, Days) values('".$MainEmpID."', '".$LeaveStart."', '".$LeaveEnd."', '".addslashes($LeaveType)."', '".$Days."')";
			}
			$this->query($sql,0);
		}
		return true;

	}

	function addEntitlement($arryDetails)  
	{ 
		$objCommon=new common();
		$arryLeaveType = $objCommon->GetAttributeValue('LeaveType','');
		
		@extract($arryDetails);	

		foreach($arryDetails["EmpID"] as $MainEmpID){
			for($i=0;$i<sizeof($arryLeaveType);$i++) {	
				$LeaveType = stripslashes($arryLeaveType[$i]['attribute_value']);
				$NumDay = $Days[$i];
				if($NumDay!=''){
					$sql ="select EntID from h_entitlement where EmpID='".trim($MainEmpID)."' and LCASE(LeaveType)='".strtolower(trim($LeaveType))."' ";
					$arryRow = $this->query($sql, 1);
					if (!empty($arryRow[0]['EntID'])) {
						$sql = "update h_entitlement set Days = '".$NumDay."' where EntID = ".$arryRow[0]['EntID']; 
					}else{
						$sql = "insert into h_entitlement( EmpID, LeaveStart, LeaveEnd, LeaveType, Days) values('".$MainEmpID."', '".$LeaveStart."', '".$LeaveEnd."', '".addslashes($LeaveType)."', '".$NumDay."')";
					}
					$this->query($sql,0);
				}
			}
		}
		
		return true;

	}
	
	function updateEntitlement($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($EntID)){
			$sql = "update h_entitlement set LeaveStart='".$LeaveStart."', LeaveEnd = '".$LeaveEnd."', Days = '".$Days."'  where EntID = '".$EntID."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;
	}

	function isEntitlementExists($EmpID,$LeaveType,$EntID)
	{
		$strSQLQuery ="select EntID from h_entitlement where EmpID='".trim($EmpID)."' and LCASE(LeaveType)='".strtolower(trim($LeaveType))."' ";
		
		$strSQLQuery .= (!empty($EntID))?(" and EntID != '".$EntID."'"):("");
		//echo $strSQLQuery; exit;
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['EntID'])) {
			return true;
		} else {
			return false;
		}

	}

	/********** Leave Management *********/
	/*******************************************/
	function  ListLeave($Department,$SearchKey,$SortBy,$FromDate,$ToDate,$AscDesc){
			$strAddQuery = " where em.locationID=".$_SESSION['locationID'];
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($Department))?(" and em.Department='".$Department."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (em.EmpCode like '%".$SearchKey."%'  or em.UserName like '%".$SearchKey."%' or em.JobTitle like '%".$SearchKey."%' or d.Department like '%".$SearchKey."%'  or l.LeaveType like '%".$SearchKey."%' or l.Status like '%".$SearchKey."%' or l.Days like '%".$SearchKey."%' or l.Comment like '%".$SearchKey."%') " ):("");			
			}

			
			$strAddQuery .= (!empty($FromDate))?(" and ( l.FromDate>='".$FromDate."' or  l.ToDate>='".$FromDate."')"):("");
			$strAddQuery .= (!empty($ToDate))?(" and (l.FromDate<='".$ToDate."' or  l.ToDate<='".$ToDate."')"):("");


			if($_SESSION['AdminType']!='admin'){
				//$strAddQuery .= "  and em.Supervisor=".$_SESSION['AdminID'];
			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by l.FromDate Desc ");


			$strSQLQuery = "select l.*, em.EmpCode, em.UserName,em.Email,em.JobTitle,d.Department,e2.UserName as SupervisorName from `h_leave` l inner join h_employee em on l.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID left outer join h_employee e2 on em.Supervisor=e2.EmpID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
				
	}	



	function LeaveApplied($SearchKey,$SortBy,$FromDate,$ToDate,$AscDesc){
			$strAddQuery = " where em.locationID=".$_SESSION['locationID']." and e2.EmpID='".$_SESSION['AdminID']."'";
			$SearchKey   = strtolower(trim($SearchKey));

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (em.EmpCode like '%".$SearchKey."%'  or em.UserName like '%".$SearchKey."%' or em.JobTitle like '%".$SearchKey."%' or d.Department like '%".$SearchKey."%'  or l.LeaveType like '%".$SearchKey."%' or l.Status like '%".$SearchKey."%' or l.Days like '%".$SearchKey."%' or l.Comment like '%".$SearchKey."%') " ):("");			
			}

			
			$strAddQuery .= (!empty($FromDate))?(" and ( l.FromDate>='".$FromDate."' or  l.ToDate>='".$FromDate."')"):("");
			$strAddQuery .= (!empty($ToDate))?(" and (l.FromDate<='".$ToDate."' or  l.ToDate<='".$ToDate."')"):("");


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by l.FromDate Desc ");

			$strSQLQuery = "select l.*, em.EmpCode, em.UserName,em.Email,em.JobTitle,d.Department,e2.UserName as SupervisorName from `h_leave` l inner join h_employee em on l.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID left outer join h_employee e2 on em.Supervisor=e2.EmpID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
				
	}

	function GetLeaveByDepartment($Department){

			global $Config;

			$strAddQuery = " where em.locationID=".$_SESSION['locationID'];			
			$strAddQuery .= (!empty($Department))?(" and em.Department='".$Department."' "):("");
			$strAddQuery .= ($Config['LeaveApplyToMe']==1)?(" and l.EmpID!='".$_SESSION['AdminID']."' "):("");

			
			$strAddQuery .= " order by l.FromDate Desc ";

			 $strSQLQuery = "select l.*, em.EmpCode, em.UserName,em.Email,em.JobTitle,d.Department,e2.UserName as SupervisorName from `h_leave` l inner join h_employee em on l.EmpID=em.EmpID inner join  h_department d on em.Department=d.depID left outer join h_employee e2 on em.Supervisor=e2.EmpID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
				
	}


	function CheckLeaveApproval($LeaveID,$EmpID){

		$strSQLQuery = "select appID, Status from `h_leave_approval` where LeaveID='".$LeaveID."' and EmpID='".$EmpID."'   ";		
	
		return $this->query($strSQLQuery, 1);	
				
	}

	function GetLeaveApproval($LeaveID){

		$strSQLQuery = "select a.*,e.UserName from `h_leave_approval` a inner join h_employee e on a.EmpID=e.EmpID where a.LeaveID='".$LeaveID."'  ";		
	
		return $this->query($strSQLQuery, 1);	
				
	}

	function getLeave($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and l.LeaveID = '".mysql_real_escape_string($id)."'"):(" and em.locationID=".$_SESSION['locationID']);
		$sql = "select l.*,em.EmpCode,em.UserName,em.Email,em.Supervisor,em.JobTitle,d.depID, d.Department from `h_leave` l inner join h_employee em on l.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID".$sql." order by l.FromDate Desc" ; 
		return $this->query($sql, 1);
	}
	function getEmpLeave($EmpID){
		$sql = " where 1";
		$sql .= (!empty($EmpID))?(" and em.EmpID = '".mysql_real_escape_string($EmpID)."'"):("");
		$sql = "select l.*,em.EmpCode,em.UserName,em.Email,d.Department from `h_leave` l inner join h_employee em on l.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID".$sql." order by l.FromDate Desc" ; 
		return $this->query($sql, 1);
	}


	function deleteLeave($LeaveID){
		if(!empty($LeaveID)){
			$sql = "delete from `h_leave` where LeaveID = '".mysql_real_escape_string($LeaveID)."'";
			$rs = $this->query($sql,0);
		}
		return true;
	}

	function addLeave($arryDetails)  
	{ 
		global $Config;

		@extract($arryDetails);	
		$ApplyDate = $Config['TodayDate'];
		$sql = "insert into `h_leave`(EmpID, LeaveType, LeaveStart, LeaveEnd, Days, FromDate, ToDate, FromDateHalf, ToDateHalf, Comment, ApplyDate, Status) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".mysql_real_escape_string(strip_tags($LeaveType))."', '".mysql_real_escape_string(strip_tags($LeaveStart))."', '".mysql_real_escape_string(strip_tags($LeaveEnd))."', '".mysql_real_escape_string(strip_tags($Days))."', '".mysql_real_escape_string(strip_tags($FromDate))."', '".mysql_real_escape_string(strip_tags($ToDate))."', '".mysql_real_escape_string(strip_tags($FromDateHalf))."', '".mysql_real_escape_string(strip_tags($ToDateHalf))."', '".mysql_real_escape_string(strip_tags($Comment))."', '".mysql_real_escape_string(strip_tags($ApplyDate))."', '".mysql_real_escape_string(strip_tags($Status))."')"; 
		$this->query($sql, 0);
		$LeaveID = $this->lastInsertId();
		return $LeaveID;
	}

	function updateLeave($arryDetails)
	{
		@extract($arryDetails);	
		if(!empty($LeaveID)){
			$sql = "update `h_leave` set LeaveStart='".mysql_real_escape_string(strip_tags($LeaveStart))."', LeaveEnd = '".mysql_real_escape_string(strip_tags($LeaveEnd))."',  Days = '".mysql_real_escape_string(strip_tags($Days))."', LeaveType = '".mysql_real_escape_string(strip_tags($LeaveType))."', FromDate = '".mysql_real_escape_string(strip_tags($FromDate))."', ToDate = '".mysql_real_escape_string(strip_tags($ToDate))."', Comment = '".mysql_real_escape_string(strip_tags($Comment))."', FromDateHalf = '".mysql_real_escape_string(strip_tags($FromDateHalf))."', ToDateHalf = '".mysql_real_escape_string(strip_tags($ToDateHalf))."', Status = '".mysql_real_escape_string(strip_tags($Status))."'  where LeaveID = '".mysql_real_escape_string($LeaveID)."'"; 
			$rs = $this->query($sql,0);
		}
			
		return true;
	}

	function isLeaveExists($EmpID,$LeaveType,$LeaveID)
	{

		$strSQLQuery ="select LeaveID from `h_leave` where EmpID='".trim($EmpID)."' and LCASE(LeaveType)='".strtolower(trim($LeaveType))."' ";
		
		$strSQLQuery .= (!empty($LeaveID))?(" and LeaveID != '".$LeaveID."'"):("");
		//echo $strSQLQuery; exit;
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['LeaveID'])) {
			return true;
		} else {
			return false;
		}

	}

	function getLeaveEntitle($EmpID,$LeaveType){
		if(!empty($EmpID)){
			$sql = "select sum(Days) as TotalLeave from h_entitlement where EmpID='".mysql_real_escape_string($EmpID)."'" ; 
			if(!empty($LeaveType)) $sql .= " and LeaveType='".$LeaveType."'";
			$arryRow = $this->query($sql, 1);
		}
		
		$TotalLeave = $arryRow[0]['TotalLeave'];
		if($TotalLeave<=0) $TotalLeave = 0;
		return $TotalLeave;
	}
	
	function getLeaveBalance($EmpID,$LeaveType){

		if(!empty($EmpID)){
			$strSQLQuery = "select e.EmpID,e.JobType, e.JoiningDate,e.LeaveAccrual,e.ProbationPeriod,e.EligibilityPeriod,e.ProbationUnit,e.EligibilityUnit from h_employee e where  e.EmpID=".mysql_real_escape_string($EmpID)." ";
			$arryEmp = $this->query($strSQLQuery, 1);
			if($arryEmp[0]['LeaveAccrual']==1){ 
				$arryFinalLeave = $this->getAccrualLeave($arryEmp);
				$LeaveEntitle=0;
				foreach($arryFinalLeave as $key=>$values){
					if($LeaveType==$key){
						$LeaveEntitle = $values;
						break;
					}			  	
				}

			}else{
				$sql = "select sum(Days) as TotalLeave from h_entitlement where EmpID='".mysql_real_escape_string($EmpID)."'" ; 
				if(!empty($LeaveType)) $sql .= " and LeaveType='".$LeaveType."'";
				$arryRow = $this->query($sql, 1);
				$LeaveEntitle = $arryRow[0]['TotalLeave'];
			}
			
			$sql2 = "select sum(Days) as LeaveTaken from `h_leave` where Status in ('Taken','Approved') and EmpID='".$EmpID."'" ; 
			if(!empty($LeaveType)) $sql2 .= " and LeaveType='".$LeaveType."'";
			$arryRow2 = $this->query($sql2, 1);
			$LeaveTaken = $arryRow2[0]['LeaveTaken'];

			$Bal = $LeaveEntitle - $LeaveTaken;
		}
				
		if($Bal<=0) $Bal = 0;
		return $Bal;
	}

	function getLeaveByStatus($EmpID,$Status,$LeaveType){
		if(!empty($EmpID)){
			$sql = "select sum(Days) as LeaveTaken from `h_leave` where Status in (".$Status.") and EmpID='".$EmpID."'" ; 
			if(!empty($LeaveType)) $sql .= " and LeaveType='".$LeaveType."'";
			$arryRow = $this->query($sql, 1);
		}
		
		$Bal = $arryRow[0]['LeaveTaken'];
		if($Bal<=0) $Bal = 0;
		return $Bal;
	}

	function getLeaveByMonthOld($EmpID,$Year,$Month,$Status,$LeaveType){
		if(!empty($EmpID)){
			$AddSql = '';
			
			$MonthStart = $Year.'-'.$Month.'-01';
			$MonthEnd = date('Y-m-t', strtotime($MonthStart));

			$AddSql .= " and FromDate<='".$MonthEnd."' ";
		
			if(!empty($LeaveType)) $AddSql .= " and LeaveType='".$LeaveType."'";
		
			$sql = "select Datediff(if(ToDate>'$MonthEnd','$MonthEnd',ToDate),if(FromDate<'$MonthStart','$MonthStart',FromDate))+1 as LeaveTaken from `h_leave` where Status in (".$Status.") and EmpID=".$EmpID.$AddSql." having LeaveTaken>0" ; 

			$arryRow = $this->query($sql, 1);
			$TotalLeaveTaken = 0;
			foreach($arryRow as $key=>$values){
				$TotalLeaveTaken += $values['LeaveTaken'];
			}
			return $TotalLeaveTaken;
		}
	}


	function getLeaveByMonth($EmpID,$Year,$Month,$Status,$LeaveType){
		if(!empty($EmpID)){
			$AddSql = '';
			
			$MonthStart = $Year.'-'.$Month.'-01';
			$MonthEnd = date('Y-m-t', strtotime($MonthStart));

			if(!empty($LeaveType)) $AddSql .= " and LeaveType='".$LeaveType."'";
		
			#$sql = "select Datediff(if(ToDate>'$MonthEnd','$MonthEnd',ToDate),if(FromDate<'$MonthStart','$MonthStart',FromDate))+1 as LeaveTaken from `h_leave` where Status in (".$Status.") and EmpID=".$EmpID.$AddSql." having LeaveTaken>0" ; 
			$sql = "select FromDate, ToDate, FromDateHalf, ToDateHalf,  if(ToDate>'$MonthEnd','$MonthEnd', ToDate) as ToD, if(FromDate<'$MonthStart','$MonthStart',FromDate) as FromD from `h_leave` where Status in (".$Status.") and EmpID=".$EmpID." having FromD<='".$MonthEnd."' and ToD>='".$MonthStart."' " ; 

			$arryRow = $this->query($sql, 1);
			//echo '<pre>'; print_r($arryRow); exit;
			$TotalLeaveTaken = 0;


			foreach($arryRow as $key=>$values){

				$i=$values["FromD"];

				
				if($values['FromDate'] == $values['ToDate'] && $values['FromDateHalf'] == 1 && $values['ToDateHalf'] == 1){
					#$TotalLeaveTaken = $TotalLeaveTaken;
				}else{
					if($values['FromDateHalf'] == 1){
						$TotalLeaveTaken = $TotalLeaveTaken - 0.5;
					}
					if($values['ToDateHalf'] == 1){
						$TotalLeaveTaken = $TotalLeaveTaken - 0.5;
					}
				}

				/*****************************/
				while($i<=$values["ToD"]){

					$sql_holi= "select holidayID from h_holiday where holidayDate='".$i."'";
					$rs_holi = $this->query($sql_holi);


					$Din = date("l",strtotime($i));
					#if($Din!="Sunday" && empty($rs_holi[0]['holidayID'])){
					if(empty($rs_holi[0]['holidayID'])){
						$TotalLeaveTaken++;
					}


					$DateAry = explode("-",$i);
					$i = date('Y-m-d', mktime(0, 0, 0, $DateAry[1], $DateAry[2]+1, $DateAry[0]));
					
				}
				/*****************************/
				
				
				$arry[] = $TotalLeaveTaken;
			}



			return $TotalLeaveTaken;
		}
	}





	function sendLeaveEmail($LeaveID)
	{
			global $Config;	
			$LeaveID = mysql_real_escape_string($LeaveID);
			if($LeaveID>0){
				$arryRow = $this->getLeave($LeaveID); 

				if($arryRow[0]['EmpID']!=$arryRow[0]['Supervisor']){
					$sql = "select Email from h_employee where EmpID='".$arryRow[0]['Supervisor']."'" ; 
					$arrySupervisor = $this->query($sql, 1);
				}
				if($arryRow[0]['depID']>0){
					$objCommon=new common();					 
					$arryHead =  $objCommon->getAllHead($arryRow[0]['depID']); 
				}


				$FromHalf = ($arryRow[0]['FromDateHalf']==1)?("[Half Day]"):("");
				$ToHalf = ($arryRow[0]['ToDateHalf']==1)?("[Half Day]"):("");

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."leave.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[LeaveType]",$arryRow[0]['LeaveType'],$contents);
				$contents = str_replace("[FromDate]",date("j M Y", strtotime($arryRow[0]['FromDate'])),$contents);
				$contents = str_replace("[ToDate]",date("j M Y", strtotime($arryRow[0]['ToDate'])),$contents);
				$contents = str_replace("[Comment]",$arryRow[0]['Comment'],$contents);
				$contents = str_replace("[FromHalf]",$FromHalf,$contents);
				$contents = str_replace("[ToHalf]",$ToHalf,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Leave Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/

				$contents = file_get_contents($htmlPrefix."leave_admin.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[LeaveType]",$arryRow[0]['LeaveType'],$contents);
				$contents = str_replace("[FromDate]",date("j M Y", strtotime($arryRow[0]['FromDate'])),$contents);
				$contents = str_replace("[ToDate]",date("j M Y", strtotime($arryRow[0]['ToDate'])),$contents);
				$contents = str_replace("[Comment]",$arryRow[0]['Comment'],$contents);
				$contents = str_replace("[FromHalf]",$FromHalf,$contents);
				$contents = str_replace("[ToHalf]",$ToHalf,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				/*if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}*/
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}

				foreach($arryHead as $key2=>$values2){
					$mail->AddCC($values2['Email']);

				}
			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Leave Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}

	/**************************************/

	function getShortLeave($EmpID=0,$year,$month)
		{
			if(!empty($EmpID)){
				$sql = "";
				if(!empty($year) && !empty($month)){
					$startDate = $year.'-'.$month.'-01';
					$endDate = $year.'-'.$month.'-31';
					$sql .= " and a.attDate>='".$startDate."' and a.attDate<='".$endDate."'";
				}

				$sql = "select count(a.StID) as TotalShortLeave from h_shortleave a inner join h_employee e on a.EmpID=e.EmpID where a.EmpID = '".mysql_real_escape_string($EmpID)."' ".$sql; 
				$arryRow = $this->query($sql, 1);
				return $arryRow[0]['TotalShortLeave'];
			}
		}


		/********** Compensation Leave *********/
		/************************************************/
		function  ListComp($arryDetails){
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID=".$_SESSION['locationID']);

			$strAddQuery .= (!empty($SuppID))?(" and e2.EmpID ='".mysql_real_escape_string($SuppID)."'"):("");
		
			$strAddQuery .= (!empty($FromDate))?(" and s.WorkingDate>='".mysql_real_escape_string($FromDate)."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and s.WorkingDate<='".mysql_real_escape_string($ToDate)."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%' or  d.Department like '%".$SearchKey."%' or s.Status like '%".$SearchKey."%' ) " ):("");			
			}			

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.CompID desc ");

			$strSQLQuery = "select s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_compensation s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID left outer join h_employee e2 on e.Supervisor=e2.EmpID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getComp($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.CompID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_compensation s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery." order by s.CompID desc";		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getActiveComp($EmpID,$Year,$Month){
			if(!empty($EmpID)){
				if(!empty($Year) && !empty($Month)){
					$startDate = $Year.'-'.$Month.'-01';
					$endDate = $Year.'-'.$Month.'-31';
					$addsql .= " and s.WorkingDate>='".mysql_real_escape_string($startDate)."' and s.WorkingDate<='".mysql_real_escape_string($endDate)."'";
				}
				
				$strSQLQuery = "select CompID from h_compensation s inner join h_employee e on s.EmpID=e.EmpID where s.EmpID='".mysql_real_escape_string($EmpID)."' and s.Approved='1' and s.Compensated!='1' and s.Status!='Closed' ".$addsql." order by s.CompID desc";	
				return $this->query($strSQLQuery, 1);	
			}
					
		}

		function paidComp($CompIDs){
			if(!empty($CompIDs)){
				$sql = "update h_compensation set Compensated='1', Status='Closed' where CompID in (".$CompIDs.")";
				$this->query($sql,0);
			}
			return true;
		}

		function deleteComp($CompID){
			if(!empty($CompID)){
				$sql = "delete from h_compensation where CompID = '".mysql_real_escape_string($CompID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}

		function ApproveSuppComp($CompID){
			if(!empty($CompID)){
				$sql = "update h_compensation set SupApproval='1' where CompID = '".mysql_real_escape_string($CompID)."'";
			
				$rs = $this->query($sql,0);
			}
			return true;
		}



		function addComp($arryDetails){ 
			global $Config;
			@extract($arryDetails);	 

			switch($Approved){
				case '1': $Status = 'Process'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}


			$sql = "insert into h_compensation(EmpID, WorkingDate, Hours, ApplyDate, Approved, updatedDate,Status,Comment) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".mysql_real_escape_string(strip_tags($WorkingDate))."', '".mysql_real_escape_string(strip_tags($Hours))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Approved))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Status))."', '".mysql_real_escape_string(strip_tags($Comment))."')";

			$this->query($sql, 0);
			$CompID = $this->lastInsertId();

			return $CompID;
		}

		

		function updateComp($arryDetails){
			global $Config;
			@extract($arryDetails);	

			switch($Approved){
				case '1': $Status = 'Process'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}

			if(!empty($CompID)){
				$sql = "update h_compensation set Approved='".mysql_real_escape_string(strip_tags($Approved))."', Status='".mysql_real_escape_string(strip_tags($Status))."', Comment='".mysql_real_escape_string(strip_tags($Comment))."',  updatedDate = '".$Config['TodayDate']."'  where CompID = '".mysql_real_escape_string($CompID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}


		function sendCompEmail($CompID)
		{
			global $Config;	
			$CompID = mysql_real_escape_string($CompID);
			if($CompID>0){
				$arryRow = $this->getComp($CompID,''); 

				if($arryRow[0]['SupApproval'] == '1'){
				   $SupervisorApproval = 'Yes';
				}else{
					$SupervisorApproval = 'Pending';
				}


				$Comment = (!empty($arryRow[0]['Comment']))?(nl2br(stripslashes($arryRow[0]['Comment']))):(NOT_SPECIFIED);

				if($arryRow[0]['EmpID']!=$arryRow[0]['Supervisor']){
					$sql = "select Email from h_employee where EmpID='".$arryRow[0]['Supervisor']."'" ; 
					$arrySupervisor = $this->query($sql, 1);
				}
				if($arryRow[0]['Approved']==1){
					$arryRow[0]['Status'] = 'Approved';
				}

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."comp.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[WorkingDate]",date($Config["DateFormat"].", l", strtotime($arryRow[0]['WorkingDate'])),$contents);
				$contents = str_replace("[Hours]",$arryRow[0]['Hours'],$contents);
				$contents = str_replace("[SupervisorApproval]",$SupervisorApproval,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date($Config["DateFormat"], strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Compensation Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/
				$contents = file_get_contents($htmlPrefix."comp_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[WorkingDate]",date($Config["DateFormat"].", l", strtotime($arryRow[0]['WorkingDate'])),$contents);
				$contents = str_replace("[Hours]",$arryRow[0]['Hours'],$contents);
				$contents = str_replace("[SupervisorApproval]",$SupervisorApproval,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date($Config["DateFormat"], strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Compensation Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arrySupervisor[0]['Email'].$Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}
	

		function AuthorizeLeave($LeaveID,$Authorize)
		{
			global $Config;	
			$LeaveID = mysql_real_escape_string($LeaveID);
			if($LeaveID>0){
							
				if($Authorize==1){
					$AppStatus = 'Approved';
									
				}else if($Authorize==2){
					$AppStatus = 'Rejected';						
				}
				$sql = "insert into h_leave_approval(LeaveID, EmpID, Status,UpdatedDate) values('".$LeaveID."', '".addslashes($_SESSION['AdminID'])."', '".$AppStatus."', '".$Config['TodayDate']."')";
	
				$this->query($sql, 0);

				$arryRow = $this->getLeave($LeaveID); 

				if($arryRow[0]['depID']>0){
					$objCommon=new common();					 
					$arryHead =  $objCommon->getAllHead($arryRow[0]['depID']); 
				}

				
				/**********************/	
				$htmlPrefix = $Config['EmailTemplateFolder'];
				$contents = file_get_contents($htmlPrefix."leave_app.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[LeaveType]",$arryRow[0]['LeaveType'],$contents);
				$contents = str_replace("[AppStatus]",strtolower($AppStatus),$contents);
				$contents = str_replace("[AppBy]", $_SESSION['UserName'] ,$contents);
				$contents = str_replace("[FromDate]",date("j M Y", strtotime($arryRow[0]['FromDate'])),$contents);
				$contents = str_replace("[ToDate]",date("j M Y", strtotime($arryRow[0]['ToDate'])),$contents);
				$contents = str_replace("[Comment]",$arryRow[0]['Comment'],$contents);
				$contents = str_replace("[FromHalf]",$FromHalf,$contents);
				$contents = str_replace("[ToHalf]",$ToHalf,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				/*if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}*/
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}

				foreach($arryHead as $key2=>$values2){
					$mail->AddCC($values2['Email']);
				}
			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Leave has been ".strtolower($AppStatus)." by ".$_SESSION['UserName'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $mail->Subject.$Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/
				/***************************/
				$sqlc = "select count(appID) as TotalApproved from `h_leave_approval` where LeaveID='".$LeaveID."'  and Status='Approved'  ";		
	
				$arryApp = $this->query($sqlc, 1);

				if($arryApp[0]['TotalApproved']>=$Config['LeaveApprovalCheck']){
					$sql = "update `h_leave` set Status = 'Approved'  where LeaveID = '".$LeaveID."'";
					$rs = $this->query($sql,0);

					$this->sendLeaveEmail($LeaveID);
				}
				/***************************/	
				/***************************/

			}

			return 1;
		}

		



		////////////Custom Rule Management ///// 

		function addCustomRule($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	

			$sql = "insert into h_leave_rule (locationID, Heading, Detail, Status, JobType, RuleOn, RuleOpp, RuleValue,Date,LeaveAllowed,RuleUnit) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($Heading)."', '".mysql_real_escape_string($Detail)."', '".$Status."', '".mysql_real_escape_string($JobType)."', '".mysql_real_escape_string($RuleOn)."', '".mysql_real_escape_string($RuleOpp)."', '".mysql_real_escape_string($RuleValue)."', '".$Config['TodayDate']."', '".mysql_real_escape_string($LeaveAllowed)."', '".mysql_real_escape_string($RuleUnit)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateCustomRule($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($RuleID)){  
				$sql = "update h_leave_rule set Heading = '".mysql_real_escape_string($Heading)."', Detail = '".mysql_real_escape_string($Detail)."', JobType = '".mysql_real_escape_string($JobType)."' , RuleOn = '".mysql_real_escape_string($RuleOn)."', RuleOpp = '".mysql_real_escape_string($RuleOpp)."', RuleValue = '".mysql_real_escape_string($RuleValue)."', Status = '".$Status."' , LeaveAllowed = '".mysql_real_escape_string($LeaveAllowed)."', RuleUnit = '".mysql_real_escape_string($RuleUnit)."' where RuleID = '".mysql_real_escape_string($RuleID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getCustomRule($id=0,$Status=0)
		{
			$sql = " where locationID=".$_SESSION['locationID'];
			$sql .= (!empty($id))?(" and RuleID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_leave_rule ".$sql." order by JobType asc, Heading asc";
			return $this->query($sql, 1);
		}

		function changeCustomRuleStatus($RuleID)
		{
			if(!empty($RuleID)){
				$sql="select * from h_leave_rule where RuleID='".mysql_real_escape_string($RuleID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_leave_rule set Status='$Status' where RuleID='".mysql_real_escape_string($RuleID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function changeCustomRuleEmp($RuleID,$EmpID)
		{
			if(!empty($RuleID) && !empty($EmpID)){
				$sql="select ID from h_leaverule_deny where RuleID='".mysql_real_escape_string($RuleID)."'  and EmpID='".mysql_real_escape_string($EmpID)."' ";
				$rs = $this->query($sql);
			
				if($rs[0]['ID']>0){				
					$sql = "delete from h_leaverule_deny where ID = '".$rs[0]['ID']."'";
					$this->query($sql,0);
				}else{
					$sql = "insert into h_leaverule_deny (RuleID, EmpID) values('".mysql_real_escape_string($RuleID)."', '".mysql_real_escape_string($EmpID)."')";		
					$this->query($sql, 0);
				}				
					
			}

			return true;

		}

		function isCustomRuleDenied($RuleID,$EmpID)
		{
			if(!empty($RuleID) && !empty($EmpID)){
				$strSQLQuery ="select ID from h_leaverule_deny where RuleID='".$RuleID."' and EmpID='".$EmpID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['ID'])) {
					return true;
				} else {
					return false;
				}
			}

		}


		function deleteCustomRule($RuleID)
		{
			if(!empty($RuleID)){
				$sql = "delete from h_leave_rule where RuleID = '".mysql_real_escape_string($RuleID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isCustomRuleNameExists($Heading,$RuleID)
		{

			$strSQLQuery ="select RuleID from h_leave_rule where locationID='".$_SESSION['locationID']."' and LCASE(Heading)='".strtolower(trim($Heading))."'";

			$strSQLQuery .= (!empty($RuleID))?(" and RuleID != '".$RuleID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['RuleID'])) {
				return true;
			} else {
				return false;
			}


		}

		function isCustomRuleExists($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery ="select RuleID from h_leave_rule where locationID='".$_SESSION['locationID']."' and RuleOn='".trim($LeaveRuleColumn)."' and RuleOpp='".trim($RuleOpp)."' and RuleValue='".trim($RuleValue)."'";

			$strSQLQuery .= (!empty($editID))?(" and RuleID != '".$editID."'"):("");
			//echo $strSQLQuery;exit;

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['RuleID'])) {
				return true;
			} else {
				return false;
			}


		}
		

		function getRuleByType($JobType,$EmpID=0)
		{
			if(!empty($EmpID)){
				/*$sql = "select d.RuleID from h_leaverule_deny d where d.EmpID = '".mysql_real_escape_string($EmpID)."'  "; 
				$arryRuleDeny = $this->query($sql, 1);
				$RuleIDDeny = implode(",",$arryRuleDeny);*/
				$strAddQuery .= " and r.RuleID not in (select d.RuleID from h_leaverule_deny d where d.EmpID = '".$EmpID."') ";
			}

			$sql = "select r.* from h_leave_rule r  where r.locationID='".$_SESSION['locationID']."' and r.Status=1 and r.JobType='".mysql_real_escape_string($JobType)."' ".$strAddQuery." ";
			

			return $this->query($sql, 1);
		}



		function getWorkingHourDay($EmpID,$FromDate,$ToDate)
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



		/********************************************/
		/********************************************/
		function getMaxKey($arryFirst){
			$max = max($arryFirst);
			if(isset($max)){
				for($i=0;$i<sizeof($arryFirst);$i++){
					if($arryFirst[$i]==$max){
						$MaxFirst = $i;
					}
				}
			}
			
			return $MaxFirst;
		}



		function getAccrualLeave($arryEmp){			




			if($arryEmp[0]['LeaveAccrual']==1){       
	$Y = date("Y");
        $FromDate = $Y."-01-01"; $ToDate = $Y."-12-31";
	if($arryEmp[0]['JoiningDate'] > $FromDate){
		$FromDate = $arryEmp[0]['JoiningDate'];
	}

	//$FromDate = "2014-06-01"; $ToDate = "2014-06-30"; //temporary
	$JoiningDate = $arryEmp[0]['JoiningDate'];
	$ProbationPeriod = $arryEmp[0]['ProbationPeriod'];
	$EligibilityPeriod = $arryEmp[0]['EligibilityPeriod'];	
	$ProbationUnit = $arryEmp[0]['ProbationUnit'];
	$EligibilityUnit = $arryEmp[0]['EligibilityUnit'];	

	$JobType = $arryEmp[0]['JobType'];

	$arryWorkDt = $this->getWorkingHourDay($arryEmp[0]['EmpID'],$FromDate,$ToDate);
	$HrsWorked = $arryWorkDt['HrsWorked'];
	$DaysWorked = $arryWorkDt['DaysWorked'];
	$CalendarDays = (strtotime($ToDate) - strtotime($FromDate))/(24*3600) + 1;
	$EmploymentPeriod = (strtotime(date('Y-m-d')) - strtotime($arryEmp[0]['JoiningDate']))/(24*3600) + 1;
	$EmploymentUnit = 'Days';


	if(!empty($JobType)){
		$arryCustomRule=$this->getRuleByType($JobType,$arryEmp[0]['EmpID']);

//echo '<pre>';print_r($arryCustomRule);exit;

		if(sizeof($arryCustomRule)>0){
			foreach($arryCustomRule as $key=>$values){
				#echo $values['RuleOn'].' '.$RuleOpp.' '.$values['RuleValue'].' : '.$values['LeaveAllowed'].'<br>';

				$RuleID = $values['RuleID'];
				$RuleOnArry = explode("#", $values['RuleOn']);
				$RuleOppArry = explode("#", $values['RuleOpp']);
				$RuleValueArry = explode("#", $values['RuleValue']);
				$RuleUnitArry = explode("#", $values['RuleUnit']);
				$NumRule = sizeof($RuleOnArry);
				$NumRuleTrue = 0;
				for($i=0;$i<$NumRule;$i++){
				/////////////
				$RuleOn = $RuleOnArry[$i];
				$RuleUnit = $RuleUnitArry[$i];
				$RuleValue = $RuleValueArry[$i];
				$RuleOpp = $RuleOppArry[$i];
				
				switch($RuleOn){
				    case 'P': //Probation Period
					
					if($ProbationUnit!=$RuleUnit){
						if($ProbationUnit!='Hrs') $ProbationPeriod=$ProbationPeriod*24;
						else if($RuleUnit!='Hrs') $RuleValue=$RuleValue*24;
					}
					
					if($RuleOpp=='E'){	
						if($ProbationPeriod==$RuleValue){
							$NumRuleTrue++; 
						}
					}else if($RuleOpp=='G'){	
						if($ProbationPeriod>$RuleValue){
							$NumRuleTrue++; 

						}
					}else if($RuleOpp=='GE'){	
						if($ProbationPeriod>=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='L'){	
						if($ProbationPeriod<$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='LE'){	
						if($ProbationPeriod<=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='NE'){	
						if($ProbationPeriod!=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}
					break;



				/*
				case 'E': //Eligibility Period

					if($EligibilityUnit!=$RuleUnit){
						if($EligibilityUnit!='Hrs') $EligibilityPeriod=$EligibilityPeriod*24;
						else if($RuleUnit!='Hrs') $RuleValue=$RuleValue*24;
					}
					
					if($RuleOpp=='E'){	
						if($EligibilityPeriod==$RuleValue){
							$NumRuleTrue++;
							
						}
					}else if($RuleOpp=='G'){	
						if($EligibilityPeriod>$RuleValue){
							$NumRuleTrue++;
							
						}
					}else if($RuleOpp=='GE'){	
						if($EligibilityPeriod>=$RuleValue){
							$NumRuleTrue++;
							
						}
					}else if($RuleOpp=='L'){	
						if($EligibilityPeriod<$RuleValue){
							$NumRuleTrue++;
							
						}
					}else if($RuleOpp=='LE'){	
						if($EligibilityPeriod<=$RuleValue){
							$NumRuleTrue++;
							
						}
					}else if($RuleOpp=='NE'){	
						if($EligibilityPeriod!=$RuleValue){
							$NumRuleTrue++;
							
						}
					}
					break;
				*/

				case 'E': //Employment Period

					if($EmploymentUnit!=$RuleUnit){
						if($EmploymentUnit!='Hrs') $EmploymentPeriod=$EmploymentPeriod*24;
						else if($RuleUnit!='Hrs') $RuleValue=$RuleValue*24;
					}
					
					if($RuleOpp=='E'){	
						if($EmploymentPeriod==$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='G'){	
						if($EmploymentPeriod>$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='GE'){	
						if($EmploymentPeriod>=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='L'){	
						if($EmploymentPeriod<$RuleValue){
							$NumRuleTrue++; 

							
						}
					}else if($RuleOpp=='LE'){	
						if($EmploymentPeriod<=$RuleValue){

							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='NE'){	
						if($EmploymentPeriod!=$RuleValue){

							$NumRuleTrue++; 
							
						}
					}

					break;
			

				case 'J': //Joining Date
					
					if($RuleOpp=='E'){	
						if($JoiningDate==$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='G'){	
						if($JoiningDate>$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='GE'){	
						if($JoiningDate>=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='L'){	
						if($JoiningDate<$RuleValue){
							$NumRuleTrue++; 

							
						}
					}else if($RuleOpp=='LE'){	
						if($JoiningDate<=$RuleValue){

							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='NE'){	
						if($JoiningDate!=$RuleValue){

							$NumRuleTrue++; 
							
						}
					}

					break;


				 case 'H': //HrsWorked
					if($RuleOpp=='E'){	
						if($HrsWorked==$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='G'){	
						if($HrsWorked>$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='GE'){	
						if($HrsWorked>=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='L'){	
						if($HrsWorked<$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='LE'){	
						if($HrsWorked<=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='NE'){	
						if($HrsWorked!=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}
					break;

				 case 'D': //DaysWorked
					if($RuleOpp=='E'){	
						if($DaysWorked==$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='G'){	
						if($DaysWorked>$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='GE'){	
						if($DaysWorked>=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='L'){	
						if($DaysWorked<$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='LE'){	
						if($DaysWorked<=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='NE'){	
						if($DaysWorked!=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}
					break;

				  case 'C': //CalendarDays
					if($RuleOpp=='E'){	
						if($CalendarDays==$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='G'){	
						if($CalendarDays>$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='GE'){	
						if($CalendarDays>=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='L'){	
						if($CalendarDays<$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='LE'){	
						if($CalendarDays<=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}else if($RuleOpp=='NE'){	
						if($CalendarDays!=$RuleValue){
							$NumRuleTrue++; 
							
						}
					}
					break;



				 
				}//end switch
			

				///////////////////
				}//end for

				


				if($NumRuleTrue == $NumRule){
					$LeaveAllowedTotal[] = $values['LeaveAllowed'].'@'.$values['RuleValue'];
					
				}
	
				


			}
			/************/

			//echo '<pre>'; print_r($LeaveAllowedTotal); 

			if(sizeof($LeaveAllowedTotal)>0){
				$MainIndex = 0;							
				for($i=0;$i<sizeof($LeaveAllowedTotal);$i++){					
					$LeaArry = explode("@", $LeaveAllowedTotal[$i]); //main value
					$LeaArrytttt = explode("#", $LeaArry[1]);				
					
					
					$arry1[] = $LeaArrytttt[0];	
					$arry2[] = $LeaArrytttt[1];	
					$arry3[] = $LeaArrytttt[2];	
					$arry4[] = $LeaArrytttt[3];	
					$arry5[] = $LeaArrytttt[4];					
				}

				unset($max);
				$max1 = $this->getMaxKey($arry1); if(isset($max1)) $max[]= $max1;
				$max2 = $this->getMaxKey($arry2); if(isset($max2)) $max[]= $max2;
				$max3 = $this->getMaxKey($arry3); if(isset($max3)) $max[]= $max3;
				$max4 = $this->getMaxKey($arry4); if(isset($max4)) $max[]= $max4;
				$max5 = $this->getMaxKey($arry5); if(isset($max5)) $max[]= $max5;
					
				$max = array_unique($max);
				//print_r($max);				

				if(sizeof($max) == 1){
					$MainIndex = $max[0];
				}
				//echo $MainIndex;exit;
			}
			
			$LeavvsssArry = explode("@", $LeaveAllowedTotal[$MainIndex]);
			$LeaveAllowed = $LeavvsssArry[0];
			/************/
		}
	}
}
/************************************/
			


			if(!empty($LeaveAllowed)){	
				$LeaveAllowedArry = explode("#", $LeaveAllowed);
				foreach($LeaveAllowedArry as $val){
					$innerArry = explode(":", $val);
					$arryFinalLeave[$innerArry[0]] = $innerArry[1];
				}
			}


		 return $arryFinalLeave;
			
		}








		/********************************************/
		/********************************************/


}
?>
