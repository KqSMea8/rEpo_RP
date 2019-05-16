<?php

class configure extends dbClass {

    ///////  Attribute Management //////

    function GetAttributeValue($attribute_name, $OrderBy) {

        $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and v.Status='1' and locationID='" . $_SESSION['locationID']."'") : ("");

        $OrderSql = (!empty($OrderBy)) ? (" order by v." . $OrderBy . " asc") : (" order by v.value_id asc");

        $strSQLQuery = "select v.* from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery . $OrderSql;

        return $this->query($strSQLQuery, 1);
    }

    function GetAttributeByValue($attribute_value, $attribute_name) {

        $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and locationID='" . $_SESSION['locationID']."'") : ("");

        $strSQLFeaturedQuery .= (!empty($attribute_value)) ? (" and v.attribute_value like '" . $attribute_value . "%'") : ("");

        $strSQLQuery = "select v.attribute_value from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery;

        return $this->query($strSQLQuery, 1);
    }

    function GetCrmAttribute($attribute_name, $OrderBy) {

        $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and v.Status='1'") : ("");

        $OrderSql = (!empty($OrderBy)) ? (" order by v." . $OrderBy . " asc") : (" order by v.value_id asc");

        $strSQLQuery = "select v.* from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery . $OrderSql;

        return $this->query($strSQLQuery, 1);
    }

    function getAllCrmAttribute($id = 0, $attribute_id, $Status = 0) {
        $sql = " where 1 ";
        $sql .= (!empty($id)) ? (" and value_id = '" . $id . "'") : ("");
        $sql .= (!empty($attribute_id)) ? (" and attribute_id = '" . $attribute_id . "'") : ("");
        $sql .= (!empty($Status) && $Status == 1) ? (" and Status = '" . $Status . "'") : ("");

        $sql = "select * from attribute_value " . $sql . " order by value_id asc";

        return $this->query($sql, 1);
    }

    function GetFixedAttribute($attribute_name, $OrderBy) {

        $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and v.Status='1' ") : ("");

        $OrderSql = (!empty($OrderBy)) ? (" order by v." . $OrderBy . " asc") : (" order by v.value_id asc");

        $strSQLQuery = "select v.* from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery . $OrderSql;

        return $this->query($strSQLQuery, 1);
    }

    function AllAttributes($id) {
        $strSQLQuery = " where 1 ";
        $strSQLQuery .= (!empty($id)) ? (" and attribute_id in(" . $id . ")") : ("");

        $strSQLQuery = "select * from attribute " . $strSQLQuery . " order by attribute_id Asc";

        return $this->query($strSQLQuery, 1);
    }

    function addAttribute($arryAtt) {
        @extract($arryAtt);
        $sql = "insert into attribute_value (attribute_value,attribute_id,Status,locationID) values('" . addslashes($attribute_value) . "','" . $attribute_id . "','" . $Status . "','" . $_SESSION['locationID'] . "')";
        $rs = $this->query($sql, 0);
        $lastInsertId = $this->lastInsertId();

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function updateAttribute($arryAtt) {
        @extract($arryAtt);
        $sql = "update attribute_value set attribute_value = '" . addslashes($attribute_value) . "',attribute_id = '" . $attribute_id . "',Status = '" . $Status . "'  where value_id = '" . $value_id . "'";
        $rs = $this->query($sql, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function getAttribute($id = 0, $attribute_id, $Status = 0) {
        $sql = " where 1 ";
        $sql .= (!empty($id)) ? (" and value_id = '" . $id . "'") : (" and locationID='" . $_SESSION['locationID']."'");
        $sql .= (!empty($attribute_id)) ? (" and attribute_id = '" . $attribute_id . "'") : ("");
        $sql .= (!empty($Status) && $Status == 1) ? (" and Status = '" . $Status . "'") : ("");

        $sql = "select * from attribute_value " . $sql . " order by value_id asc";

        return $this->query($sql, 1);
    }

    function countAttributes() {
        $sql = "select sum(1) as NumAttribute from attribute_value where Status='1'";
        return $this->query($sql, 1);
    }

    function changeAttributeStatus($value_id) {
        if (!empty($value_id)) {
            $sql = "select value_id,Status from attribute_value where value_id='" . $value_id . "'";
            $rs = $this->query($sql);
            if (sizeof($rs)) {
                if ($rs[0]['Status'] == 1)
                    $Status = 0;
                else
                    $Status = 1;

                $sql = "update attribute_value set Status='$Status' where value_id='" . mysql_real_escape_string($value_id) . "'";
                $this->query($sql, 0);
            }
        }
        return true;
    }

    function deleteAttribute($id) {
        if (!empty($id)) {
            $sql = "delete from attribute_value where value_id = '" . mysql_real_escape_string($id) . "'";
            $rs = $this->query($sql, 0);
        }

        return true;
    }

    function isAttributeExists($attribute_value, $attribute_id, $value_id) {

        $strSQLQuery = "select value_id from attribute_value where LCASE(attribute_value)='" . strtolower(trim($attribute_value)) . "' and locationID='" . $_SESSION['locationID']."'";

        $strSQLQuery .= (!empty($attribute_id)) ? (" and attribute_id = '" . $attribute_id . "'") : ("");
        $strSQLQuery .= (!empty($value_id)) ? (" and value_id != '" . $value_id . "'") : ("");
        //echo $strSQLQuery; exit;
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['value_id'])) {
            return true;
        } else {
            return false;
        }
    }

    function GetAttribValue($attribute_name, $OrderBy) {

        $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and v.Status='1' ") : ("");

        $OrderSql = (!empty($OrderBy)) ? (" order by v." . $OrderBy . " asc") : (" order by v.value_id asc");

        $strSQLQuery = "select v.* from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery . $OrderSql;

        return $this->query($strSQLQuery, 1);
    }

    function GetAttribFinance($attribute_name, $OrderBy) {

	if($attribute_name=='PaymentMethod'){
		/*$strSQLQuery = "select m.methodName as attribute_value from f_method m where m.Status=1 order by m.methodName asc";
		 return $this->query($strSQLQuery, 1);*/
	}else{
		 $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and v.Status='1' ") : ("");
		$OrderSql = (!empty($OrderBy)) ? (" order by v." . $OrderBy . " asc") : (" order by v.value_id asc");
		$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery . $OrderSql;
		
		 return $this->query($strSQLQuery, 1);
	}

       
    }

    function GetTerm($termID, $Status) {

        $strAddQuery = " where Deleted='0' ";
        $strAddQuery .= (!empty($termID)) ? (" and termID='" . $termID . "'") : ("");
        $strAddQuery .= ($Status > 0) ? (" and Status='" . $Status . "'") : ("");

        $strSQLQuery = "select * from f_term  " . $strAddQuery . " order by termName Asc";

        return $this->query($strSQLQuery, 1);
    }

    ////////////Attribute Management End ///// 
    function GetSubDepartment($Division) {
        global $Config;
	$addsql='';	
        if (!empty($Division))
            $addsql .= " and Division in (" . $Division . ")";
        if (!empty($Config['CmpDepartment']))
            $addsql .= " and Division in (" . $Config['CmpDepartment'] . ")";
        $sql = "select depID,Department from h_department where Status='1' " . $addsql . " order by Department asc";
        return $this->query($sql, 1);
    }

    function GetDepartment() {
        global $Config;
	  $addsql='';
        if (!empty($Config['CmpDepartment']))
            $addsql = " and depID in (" . $Config['CmpDepartment'] . ")";
        $sql = "select * from department where Status='1' " . $addsql . " order by depID asc";
        return $this->query($sql, 1);
    }

    function GetDepartmentInfo($depID) {
        if (!empty($depID))
            $addsql = " and d.depID='" . mysql_real_escape_string($depID) . "' ";
        $sql = "select d.*,e.EmpID, e.UserName,e.Email from department d left outer join h_employee e on (d.depID=e.Department and e.DeptHead='1' and e.locationID='" . mysql_real_escape_string($_SESSION['locationID']) . "') where 1 " . $addsql . " order by d.Department asc ";

        //echo $sql; exit;
        return $this->query($sql, 1);
    }

    function GetDepartmentList() {
        global $Config;
        if (!empty($Config['CmpDepartment']))
            $addsql = " and depID in (" . $Config['CmpDepartment'] . ")";
        $addsql .= (!empty($Config['SortBy'])) ? (" order by " . $Config['SortBy'] . " ") : (" order by depID asc ");
        $sql = "select * from department where Status='1' " . $addsql;
        return $this->query($sql, 1);
    }

    function GetSubDepartmentInfo($depID) {
        if (!empty($depID))
            $addsql = " and d.depID='" . $depID . "' ";
        $sql = "select d.*,e.EmpID, e.UserName,e.Email from h_department d left outer join h_employee e on (d.depID=e.Department and e.DeptHead='1' and e.locationID='" . $_SESSION['locationID'] . "') where 1 " . $addsql . " order by d.depID asc ";
        return $this->query($sql, 1);
    }

    function GetCurrentDepartment($Link) {
        global $Config;
        $Link = mysql_real_escape_string(strip_tags($Link));
        $sql = "select d.* from department d where 1 ";
        //if(!empty($Config['DeptFolder']))
        $sql .= " and LCASE(d.Department)='" . strtolower($Config['DeptFolder']) . "'";

        $rs = $this->query($sql);

        if (empty($rs[0]["Department"])) {
            /*             * *Code BY sachin** */
            $sqlnew = ($Config['ModuleDepName'] == 'SalesRMA') ? (" and d.Department='Sales'") : ("");
            /*             * *Code BY sachin** */
            $sql1 = "select d.* from  admin_modules a1 inner join admin_modules a2 on a1.Parent=a2.ModuleID  inner join department d on a2.depID=d.depID where a1.Link='" . $Link . "'  and  d.Status='1' " . $sqlnew;
            $rs = $this->query($sql1);

            /* if(empty($rs[0]["Department"])){
              $sql = "select d.*,Email from  admin_modules a1 inner join admin_modules a2 on a1.Parent=a2.ModuleID inner join admin_modules a3 on a2.Parent=a3.ModuleID inner join department d on a3.depID=d.depID left outer join  h_employee e on d.EmpID=e.EmpID where a1.Link='".$Link."' ";
              $rs = $this->query($sql);

              } */
        }


        return $rs;
    }

    function GetDashboardIcon($depID, $Status = 0, $Display = 0) {
        $sql = " ";
        $sql .= (!empty($depID)) ? (" and i.depID = '" . $depID . "'") : ("");
        $sql .= (!empty($Status) && $Status == 1) ? (" and i.Status = '" . $Status . "'") : ("");
        $sql .= (!empty($Display) && $Display == 1) ? (" and i.Display = '" . $Display . "'") : ("");

        $sql = "select i.* from dashboard_icon i inner join admin_modules m on i.ModuleID=m.ModuleID where m.Status='1' " . $sql . " Order by Case When i.OrderBy>0 Then 0 Else 1 End,i.OrderBy,i.IconID";
        return $this->query($sql, 1);
    }

    function DashboardIcon($depID) {
        global $Config;

	$joinsql='';
        if ($_SESSION['AdminType'] == "admin") {
            $wheresql = " and i.`Default`='0' ";
        } else {

            $strSQLQuery = "select IconID from dashboard_icon where `Default`='1' and Status='1' and Display='1'  ";
            $rs = $this->query($strSQLQuery);
            $DefaultIcon = '';
            if (sizeof($rs) > 0) {
                foreach ($rs as $key => $values) {
                    $DefaultIcon .= $values['IconID'] . ',';
                }
                $DefaultIcon = rtrim($DefaultIcon, ",");
            }

            if (!empty($DefaultIcon)) {
                $wheresql = " and (i.IconID in(" . $DefaultIcon . ") or i.IconID in( select distinct(i.IconID) from dashboard_icon i inner join permission p on i.ModuleID =p.ModuleID and i.EditPage<=p.ModifyLabel where p.UserID='" . $_SESSION['UserID'] . "'))";
            } else {
                $joinsql = "inner join permission p on (i.ModuleID =m.ModuleID and i.EditPage<=p.ModifyLabel and p.UserID='" . $_SESSION['UserID'] . "')";
            }
        }


        $sql = "select i.* from dashboard_icon i " . $joinsql . " inner join admin_modules m on i.ModuleID=m.ModuleID where m.Status='1' and i.Status='1' and i.Display='1' and i.depID='" . $depID . "' " . $wheresql . " Order by Case When i.OrderBy>0 Then 0 Else 1 End,i.OrderBy,i.IconID ";


        return $this->query($sql, 1);
    }


function DashboardIconNew($depID) {
        global $Config;

	$joinsql=$wheresql='';
        if ($_SESSION['AdminType'] == "admin") {
            $wheresql = " and i.`Default`='0' ";
        } else {


  	if($Config['HideDefaultIcon']!=1){
            $strSQLQuery = "select IconID from dashboard_icon where `Default`='1' and Status='1' and Display='1'  ";
            $rs = $this->query($strSQLQuery);
            $DefaultIcon = '';
            if (sizeof($rs) > 0) {
                foreach ($rs as $key => $values) {
                    $DefaultIcon .= $values['IconID'] . ',';
                }
                $DefaultIcon = rtrim($DefaultIcon, ",");
            }
	} 


 		 
            if (!empty($DefaultIcon)) {
                 $wheresql = " and (i.IconID in(" . $DefaultIcon . ") or i.IconID in( select distinct(i.IconID) from dashboard_icon i inner join admin_modules m on i.ModuleID=m.ModuleID inner join permission p on m.ModuleID =p.ModuleID where p.UserID='" . $_SESSION['UserID'] . "' and CASE WHEN i.EditPage>0 THEN  (i.EditPage=p.AddLabel OR i.EditPage=p.FullLabel) ELSE 1 END = 1 ))";
	 

            } else {
                $joinsql = "inner join permission p on (i.ModuleID =p.ModuleID and p.UserID='" . $_SESSION['UserID'] . "')";
            }
        }


         $sql = "select distinct(i.IconID),i.* from dashboard_icon i " . $joinsql . " inner join admin_modules m on i.ModuleID=m.ModuleID  where m.Status='1' and i.Status='1' and i.Display='1' and i.depID='" . $depID . "' " . $wheresql . " Order by Case When i.OrderBy>0 Then 0 Else 1 End,i.OrderBy,i.IconID ";


        return $this->query($sql, 1);
    }


function DashboardIconRoleGroupNew($depID,$GroupID=0) {
        global $Config;

	 $joinsql ='';
        if ($_SESSION['AdminType'] == "admin") {
            $wheresql = " and i.`Default`='0' ";
        } else {

	  if($Config['HideDefaultIcon']!=1){
            $strSQLQuery = "select IconID from dashboard_icon where `Default`='1' and Status='1' and Display='1'  ";
            $rs = $this->query($strSQLQuery);
            $DefaultIcon = '';
            if (sizeof($rs) > 0) {
                foreach ($rs as $key => $values) {
                    $DefaultIcon .= $values['IconID'] . ',';
                }
                $DefaultIcon = rtrim($DefaultIcon, ",");
            }
	}


            if (!empty($DefaultIcon)) {
                $wheresql = " and (i.IconID in(" . $DefaultIcon . ") or i.IconID in( select distinct(i.IconID) from dashboard_icon i inner join admin_modules m on i.ModuleID=m.ModuleID inner join permission_group p on m.ModuleID =p.ModuleID where p.GroupID='" . $GroupID . "' and CASE WHEN i.EditPage>0 THEN  (i.EditPage=p.AddLabel OR i.EditPage=p.FullLabel) ELSE 1 END = 1 ))";
            } else {
                $joinsql = "inner join permission_group p on (i.ModuleID =p.ModuleID and p.GroupID='" . $GroupID . "')";
            }
        }


        $sql = "select distinct(i.IconID),i.* from dashboard_icon i " . $joinsql . " inner join admin_modules m on i.ModuleID=m.ModuleID   where m.Status='1' and i.Status='1' and i.Display='1' and i.depID='" . $depID . "' " . $wheresql . " Order by Case When i.OrderBy>0 Then 0 Else 1 End,i.OrderBy,i.IconID ";

	//echo $sql;exit;
        return $this->query($sql, 1);
    }


    function updateDashboardSettings($arryDetails) {
        @extract($arryDetails);

        if ($numModule > 0) {
            $sql = "update dashboard_icon set Display='0' where depID = '" . $Department . "'";
            $rs = $this->query($sql, 0);
            foreach ($arryDetails['IconID'] as $IconID) {

                if ($IconID > 0) {
                    $sql = "update dashboard_icon set Display='1' where IconID = '" . $IconID . "'";
                    $rs = $this->query($sql, 0);
                }
            }
        }


        return true;
    }

    //////////// Location Start  ///// 

    function GetLocationData($id = 0, $Status = 0) {
	global $Config;
        $sql = " where 1";
        $sql .= (!empty($id)) ? (" and l.locationID = '" . mysql_real_escape_string($id) . "'") : ("");
        $sql .= (!empty($Status) && $Status == 1) ? (" and l.Status = '" . $Status . "'") : ("");

        $sql = "select l.*,c.code as CountryCode, s.code as StateCode from ".$_SESSION['CmpDatabase'].".location l inner join ".$Config['DbMain'].".country c on  l.country_id =  c.country_id left outer join ".$Config['DbMain'].".state s on  l.state_id =  s.state_id " . $sql . " order by l.locationID Asc";
        return $this->query($sql, 1);
    }

    function GetLocation($id = 0, $Status = 0) {
        $sql = " where 1";
        $sql .= (!empty($id)) ? (" and locationID = '" . mysql_real_escape_string($id) . "'") : ("");
        $sql .= (!empty($Status) && $Status == 1) ? (" and Status = '" . $Status . "'") : ("");

        $sql = "select * from location " . $sql . " order by locationID Asc";
        return $this->query($sql, 1);
    }

    function addLocation($arryDetails) {
        @extract($arryDetails);

        if (!empty($TimezonePlusMinus))
            $Timezone = $TimezonePlusMinus . $Timezone;


        $sql = "insert into location (Address, currency_id, country_id, state_id, city_id, Country, State, City, ZipCode, Status, Timezone, EIN, VAT, CST, TRN) values('" . addslashes($Address) . "', '" . addslashes($currency_id) . "', '" . addslashes($country_id) . "', '" . addslashes($state_id) . "', '" . addslashes($city_id) . "', '" . addslashes($Country) . "', '" . addslashes($State) . "', '" . addslashes($City) . "', '" . addslashes($ZipCode) . "', '" . $Status . "', '" . addslashes($Timezone) . "', '" . addslashes($EIN) . "', '" . addslashes($VAT) . "', '" . addslashes($CST) . "', '" . addslashes($TRN) . "')";

        $this->query($sql, 0);
        $lastInsertId = $this->lastInsertId();
        return $lastInsertId;
    }

    function updateLocation($arryDetails) {
        @extract($arryDetails);
        if (!empty($locationID)) {
            if (!empty($TimezonePlusMinus))
                $Timezone = $TimezonePlusMinus . $Timezone;

             $sql = "update location set Address='" . addslashes($Address) . "', currency_id = '" . addslashes($currency_id) . "', country_id = '" . addslashes($country_id) . "', state_id = '" . addslashes($state_id) . "', city_id = '" . addslashes($city_id) . "', Country = '" . addslashes($Country) . "', State = '" . addslashes($State) . "', City = '" . addslashes($City) . "', ZipCode = '" . addslashes($ZipCode) . "',Status = '" . $Status . "' , Timezone = '" . addslashes($Timezone) . "' , EIN='".mysql_real_escape_string($EIN)."' ,VAT='".mysql_real_escape_string($VAT)."', CST='".mysql_real_escape_string($CST)."',TRN='".mysql_real_escape_string($TRN)."'  where locationID = '" . $locationID . "'";
            $rs = $this->query($sql, 0);
		 
        }

        return true;
    }

    function updateGlobalLocation($arryDetails) {

        @extract($arryDetails);

        $WeekEndOffVal = implode(",", $WeekEndOff);

        $locationID = mysql_real_escape_string($_SESSION['locationID']);
        if (!empty($locationID)) {

            $LunchTime = $LunchTimeHour . ':' . $LunchTimeMinute;

            $sql = "update location set WorkingHourStart='" . mysql_real_escape_string($WorkingHourStart) . "', WorkingHourEnd = '" . mysql_real_escape_string($WorkingHourEnd) . "', OvertimeFrom = '" . mysql_real_escape_string($OvertimeFrom) . "', OvertimeRate = '" . mysql_real_escape_string($OvertimeRate) . "', HalfDayHour = '" . mysql_real_escape_string($HalfDayHour) . "', FullDayHour = '" . mysql_real_escape_string($FullDayHour) . "', MaxLeaveMonth = '" . mysql_real_escape_string($MaxLeaveMonth) . "', WeekStart = '" . mysql_real_escape_string($WeekStart) . "', WeekEnd = '" . mysql_real_escape_string($WeekEnd) . "',WeekEndOff = '" . $WeekEndOffVal . "' , SalaryDate = '" . mysql_real_escape_string($SalaryDate) . "', LableLeave = '" . mysql_real_escape_string($LableLeave) . "', LableHalfDay = '" . mysql_real_escape_string($LableHalfDay) . "', MaxShortLeave = '" . mysql_real_escape_string($MaxShortLeave) . "', Advance = '" . mysql_real_escape_string($Advance) . "', Loan = '" . mysql_real_escape_string($Loan) . "', Overtime = '" . mysql_real_escape_string($Overtime) . "', Bonus = '" . mysql_real_escape_string($Bonus) . "', SL_Coming = '" . mysql_real_escape_string($SL_Coming) . "', SL_Leaving = '" . mysql_real_escape_string($SL_Leaving) . "', SL_Deduct = '" . mysql_real_escape_string($SL_Deduct) . "', ExpenseClaim = '" . mysql_real_escape_string($ExpenseClaim) . "', FlexTime = '" . mysql_real_escape_string($FlexTime) . "', ProbationTime = '" . mysql_real_escape_string($ProbationTime) . "', LeaveApprovalCheck = '" . mysql_real_escape_string($LeaveApprovalCheck) . "', LunchPunch = '" . mysql_real_escape_string($LunchPunch) . "', LunchTime = '" . mysql_real_escape_string($LunchTime) . "', ShortBreakPunch = '" . mysql_real_escape_string($ShortBreakPunch) . "', ShortBreakLimit = '" . mysql_real_escape_string($ShortBreakLimit) . "', ShortBreakTime = '" . mysql_real_escape_string($ShortBreakTime) . "', UseShift = '" . mysql_real_escape_string($UseShift) . "', LunchPaid = '" . mysql_real_escape_string($LunchPaid) . "', ShortBreakPaid = '" . mysql_real_escape_string($ShortBreakPaid) . "', WeekendCount = '" . mysql_real_escape_string($WeekendCount) . "', LeavePeriod = '" . mysql_real_escape_string($LeavePeriod) . "', PayrollStart = '" . mysql_real_escape_string($PayrollStart) . "', PayCycle = '" . mysql_real_escape_string($PayCycle) . "', PayMethod = '" . mysql_real_escape_string($PayMethod) . "', ReimRate = '" . mysql_real_escape_string($ReimRate) . "', ReimMileageGL = '" . mysql_real_escape_string($ReimMileageGL) . "', ReimMissGL = '" . mysql_real_escape_string($ReimMissGL) . "'  where locationID = '" . $locationID . "'";
            $rs = $this->query($sql, 0);

	    /*******Monthly/Hoourly*********/
            if($PayMethod == 'M') {
                $this->query("update admin_modules set Status='1' where ModuleID in (86,88)", 0);
                $this->query("update admin_modules set Status='0' where ModuleID in (1022)", 0);
            } else {
                $this->query("update admin_modules set Status='0' where ModuleID in (86,88)", 0);
                $this->query("update admin_modules set Status='1' where ModuleID in (1022)", 0);
            }
	    
	    /*******Advance*********/
            if($Advance == '1') {
                $this->query("update admin_modules set Status='1' where ModuleID in (1001, 1003)", 0);               
            }else{
                $this->query("update admin_modules set Status='0' where ModuleID in (1001, 1003)", 0);                    
            }	
	   /*******Loan*********/
            if($Loan == '1') {
                $this->query("update admin_modules set Status='1' where ModuleID in (1002, 1004)", 0);               
            }else{
                $this->query("update admin_modules set Status='0' where ModuleID in (1002, 1004)", 0);                      
            }	
	   /*******Bonus*********/
            if($Bonus == '1') {
                $this->query("update admin_modules set Status='1' where ModuleID in (1007)", 0);               
            }else{
                $this->query("update admin_modules set Status='0' where ModuleID in (1007)", 0);                      
            }	   
	   /*******Reimbursement*********/
            if($ExpenseClaim == '1') {
                $this->query("update admin_modules set Status='1' where ModuleID in (1019, 1020)", 0);               
            }else{
                $this->query("update admin_modules set Status='0' where ModuleID in (1019, 1020)", 0);               
            }
	    /********************/




        }

        return true;
    }

    function changeLocationStatus($locationID) {
        if (!empty($locationID)) {
            $sql = "select locationID,Status from location where locationID='" . mysql_real_escape_string($locationID) . "'";
            $rs = $this->query($sql);
            if (sizeof($rs)) {
                if ($rs[0]['Status'] == 1)
                    $Status = 0;
                else
                    $Status = 1;

                $sql = "update location set Status='$Status' where locationID='" . mysql_real_escape_string($locationID) . "' and locationID!='1' ";
                $this->query($sql, 0);
            }
        }

        return true;
    }

    function deleteLocation($locationID) {
        if (!empty($locationID)) {
            $sql = "delete from location where locationID = '" . mysql_real_escape_string($locationID) . "' and locationID!='1' ";
            $rs = $this->query($sql, 0);
        }

        return true;
    }

    function isLocationExists($arryDetails) {
        extract($arryDetails);

        $strSQLQuery = "select locationID from location where country_id='" . $country_id . "' ";

        if ((!empty($state_id))) {
            $strSQLQuery .= " and state_id = '" . $state_id."'";
        } else if ((!empty($State))) {
            $strSQLQuery .= " and State = '" . $State . "'";
        }
        if ((!empty($city_id))) {
            $strSQLQuery .= " and city_id = '" . $city_id."'";
        } else if ((!empty($City))) {
            $strSQLQuery .= " and City = '" . $City . "'";
        }

        $strSQLQuery .= (!empty($locationID)) ? (" and locationID != '" . $locationID . "'") : ("");
        //echo $strSQLQuery; exit;
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['locationID'])) {
            return true;
        } else {
            return false;
        }
    }

    function CountLocation() {
        $sql = "select count(locationID) as NumLocation from location";
        return $this->query($sql, 1);
    }

    function UpdatePrimaryLocation($arryDetails) {
        $sql = "select locationID from location order by locationID limit 1";
        $arryRow = $this->query($sql, 1);

        $arryDetails["Status"] = 1;

        if (!empty($arryRow[0]['locationID'])) {
            $arryDetails["locationID"] = $arryRow[0]['locationID'];
            #$this->updateLocation($arryDetails);  // No need now as integrated inside the edit company
            #$_SESSION['locationID'] = $arryRow[0]['locationID'];
        } else {
            $locationID = $this->addLocation($arryDetails);
            #$_SESSION['locationID'] = $locationID;
        }

        return true;
    }

    // For Primary Location Updation

    function UpdateLocationProfile($arryDetails) {
        extract($arryDetails);
        if (empty($locationID))
            $locationID = 1; // For Primary Location

        $strSQLQuery = "update location set Address='" . addslashes($Address) . "', country_id = '" . addslashes($country_id) . "', state_id = '" . addslashes($state_id) . "', city_id = '" . addslashes($city_id) . "', Country = '" . addslashes($Country) . "', State = '" . addslashes($State) . "', City = '" . addslashes($City) . "', ZipCode='" . addslashes($ZipCode) . "', EIN='".mysql_real_escape_string($EIN)."' ,VAT='".mysql_real_escape_string($VAT)."', CST='".mysql_real_escape_string($CST)."',TRN='".mysql_real_escape_string($TRN)."'	where locationID='" . $locationID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function UpdateLocationCurrency($arryDetails) {
        extract($arryDetails);
        if (empty($locationID))
            $locationID = 1; // For Primary Location
        if (!empty($locationID) && !empty($currency_id)) {

            $strSQLQuery = "update location set currency_id='".$currency_id."' where locationID='".$locationID."'"; 
            // $strSQLQuery = "update location set currency_id='" . $currency_id . "' where 1 ";
            $this->query($strSQLQuery, 0);
        }

        return 1;
    }

    function UpdateLocationDateTime($arryDetails) {
        extract($arryDetails);

        if (empty($locationID))
            $locationID = 1; // For Primary Location

        if (!empty($locationID) && !empty($Timezone)) {

            if (!empty($Timezone))
                $Timezone = $TimezonePlusMinus . $Timezone;

            $strSQLQuery = "update location set Timezone='" . addslashes($Timezone) . "' where locationID='" . $locationID."'";
            $this->query($strSQLQuery, 0);
        }
        return 1;
    }

    //////////// Company Location End ///// 

    function UpdateLoginTime() {
        global $Config;
        if (!empty($_SESSION['AdminID'])) {
            $sql = "select LastLogin,CurrentLogin from h_employee where EmpID='" . mysql_real_escape_string($_SESSION['AdminID']) . "'";
            $arryRow = $this->query($sql, 1);

            $sql = "update h_employee set CurrentLogin='" . $Config['TodayDate'] . "',LastLogin='" . $arryRow[0]['CurrentLogin'] . "' where EmpID='" . mysql_real_escape_string($_SESSION['AdminID']) . "'";
            $this->query($sql, 0);
        }

        return true;
    }

    function UpdateStorage($FileDestination, $OldFileSize, $DeleteFlag) {
        global $Config;
	
	if($_SESSION['CmpID']>0){
        $objConfig = new admin();
        
        $sql = "select Storage from ".$Config['DbMain'].".company where CmpID='" . $_SESSION['CmpID'] . "'";
        $arryRow = $this->query($sql, 1);

        $FileSize = (filesize($FileDestination) / 1024); //KB			
	 
		if ($FileSize > 0) {
			    if ($DeleteFlag == 1) {
				$NewStorage = $arryRow[0]['Storage'] - $FileSize;
				unlink($FileDestination);
			    } else {
		
				$NewStorage = ($arryRow[0]['Storage'] + $FileSize) - $OldFileSize;
			    }

			    if ($NewStorage < 0)
				$NewStorage = 0;
			    else
				$NewStorage = round($NewStorage, 2);
			    $sql = "update ".$Config['DbMain'].".company set Storage='" . $NewStorage . "' where CmpID='" . $_SESSION['CmpID'] . "'";
				 
			    $this->query($sql, 0);
			    
		}
        }

        return true;
    }

    //////////// Custom Field Start ///// 
    function GetCustomField($id = 0, $locationID, $depID, $Module, $Status = 0) {
        $sql = " where 1 ";
        $sql .= (!empty($depID)) ? (" and depID = '" . $depID . "'") : ("");
        $sql .= (!empty($Module)) ? (" and Module = '" . $Module . "'") : ("");
        $sql .= (!empty($id)) ? (" and FieldID = '" . $id . "'") : (" and locationID='" . $locationID . "'");
        $sql .= (!empty($Status) && $Status == 1) ? (" and Status = '" . $Status . "'") : ("");

        $sql = "select * from custom_field " . $sql . " order by OrderBy Asc";
        return $this->query($sql, 1);
    }

    function CustomValueByParent($locationID, $Parent) {
        $sql = " where 1 ";
        $sql .= (!empty($Parent)) ? (" and Parent = '" . $Parent . "'") : ("");
        $sql .= (!empty($locationID)) ? (" and locationID = '" . $locationID . "'") : ("");

        $sql = "select * from custom_field " . $sql . " order by OrderBy Asc";
        return $this->query($sql, 1);
    }

    function GetCustomFieldModule($depID) {
        $sql = "select Module from custom_field where depID='" . $depID . "' group by Module order by Module Asc ";
        return $this->query($sql, 1);
    }

    function GetFieldByID($FieldID) {
        $sql = "select * from custom_field where FieldID='" . $FieldID . "'";
        return $this->query($sql, 1);
    }

    function updateCustomFieldValue($arryDetails) {
        for ($i = 1; $i <= $arryDetails['NumField']; $i++) {

            if (!empty($arryDetails['FieldID' . $i])) {
                $Status = (!empty($arryDetails['FieldTitle' . $i])) ? ($arryDetails['Status' . $i]) : ('0');
                $sql = "update custom_field set FieldTitle='" . addslashes($arryDetails['FieldTitle' . $i]) . "', Status='" . $Status . "'  where FieldID=" . $arryDetails['FieldID' . $i];
                $this->query($sql, 0);
            } else if (!empty($arryDetails['MainFieldID' . $i])) {
                $arryField = $this->GetFieldByID($arryDetails['MainFieldID' . $i]);

                if (!empty($arryDetails['FieldTitle' . $i])) {
                    $sql = "insert into custom_field(Parent, locationID, FieldTitle, Status) values( '" . $arryDetails['MainFieldID' . $i] . "', '" . $_SESSION['locationID'] . "',  '" . addslashes($arryDetails['FieldTitle' . $i]) . "', '" . $arryDetails['Status' . $i] . "')";
                    $this->query($sql, 0);
                }
            }
        }
        return true;
    }

    function CustomFieldList($depID, $Module, $Tab) {
	$addsql ='';
        $addsql .= (!empty($Tab)) ? (" and f1.Tab = '" . $Tab . "'") : ("");

        if ($_SESSION['locationID'] == 1) {
            $sql = "select f1.FieldTitle,f1.FieldName from custom_field f1 where f1.locationID='1' and f1.Status='1' and f1.depID = '" . $depID . "' and f1.Module = '" . $Module . "' " . $addsql . " order by f1.OrderBy Asc";
        } else {
            $sql = "select f1.FieldTitle,f2.FieldName from custom_field f1 inner join custom_field f2 on f1.Parent=f2.FieldID where f1.locationID='" . $_SESSION['locationID'] . "' and f1.Status='1' and f2.depID = '" . $depID . "' and f2.Module = '" . $Module . "' " . $addsql . " order by f2.OrderBy Asc";
        }
        return $this->query($sql, 1);
    }

    //////////// Custom Field End ///// 
    //////////// Notification Start ////////////// 
    ////////////////////////////////////////////// 
    function GetNotification($notifyID, $Limit) {
        global $Config;
        $addsql = (!empty($notifyID)) ? (" and notifyID = '" . $notifyID . "'") : ("");
        $Limit = (!empty($Limit)) ? (" limit 0, " . $Limit) : ("");
        $sql = "select * from notification where locationID = '" . $_SESSION['locationID'] . "' and depID = '" . $Config['CurrentDepID'] . "' " . $addsql . " order by notifyDate desc " . $Limit;
        return $this->query($sql, 1);
    }

    function CountNotification() {
        global $Config;
        $sql = "select count(notifyID) as UnreadNotification from notification where locationID = '" . $_SESSION['locationID'] . "' and depID = '" . $Config['CurrentDepID'] . "'  and `Read`='0'";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['UnreadNotification'];
    }

    function AddNotification($arryDetails) {
        global $Config;
        extract($arryDetails);

        if ($_SESSION['AdminType'] == 'admin') {
            $CreatedBy = 'Administrator';
        } else {
            $CreatedBy = $_SESSION['UserName'];
        }

        $strSQLQuery = "insert into notification(locationID, depID, refID, refType, Name, Message, oldValue, newValue, AdminID, AdminType, CreatedBy, notifyDate) values(  '" . $_SESSION['locationID'] . "', '" . $Config['CurrentDepID'] . "', '" . mysql_real_escape_string($refID) . "', '" . mysql_real_escape_string($refType) . "' , '" . mysql_real_escape_string($Name) . "', '" . mysql_real_escape_string($Message) . "', '" . mysql_real_escape_string($oldValue) . "', '" . mysql_real_escape_string($newValue) . "', '" . $_SESSION['AdminID'] . "', '" . $_SESSION['AdminType'] . "',  '" . $CreatedBy . "',  '" . $Config['TodayDate'] . "')";

        $this->query($strSQLQuery, 0);


        $htmlPrefix = "../" . $Config['EmailTemplateFolder'];
        $contents = file_get_contents($htmlPrefix . "notification.htm");
        $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';

        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[FULLNAME]", $UserName, $contents);
        $contents = str_replace("[Message]", strip_tags($Message), $contents);
        $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);

        //$To = 'parwez.khan@sakshay.in'; 
        $To = $Config['AdminEmail'];

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($To);
        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " - " . $Subject;
        $mail->IsHTML(true);
        //echo $Config['AdminEmail'].$Subject.$contents; exit;
        $mail->Body = $contents;
        if ($Config['Online'] == '1') {
            //$mail->Send(); //turned off temporarily
        }

        return true;
    }

    function RemoveNotification($notifyID) {
        if (!empty($notifyID)) {
            $sql = "delete from notification where notifyID = '" . mysql_real_escape_string($notifyID) . "'";
            $this->query($sql, 0);
        }
        return 1;
    }

    function ReadNotification($notifyID) {
        global $Config;
        $addsql = (!empty($notifyID)) ? (" and notifyID = '" . $notifyID . "'") : ("");

        $sql = "update notification set `Read`='1' where locationID = '" . $_SESSION['locationID'] . "' and depID = '" . $Config['CurrentDepID'] . "' and `Read`='0' " . $addsql;
        $rs = $this->query($sql, 0);

        return true;
    }

    //////////// Notification End ///// 

    function GetEmpImage($id = 0) {
        $strSQLQuery = "select e.Image  from h_employee e where EmpID='" . mysql_real_escape_string($id) . "'";
        return $this->query($strSQLQuery, 1);
    }

    function GetEmpSetting($EmpID) {
        if (!empty($EmpID)) {
            $strSQLQuery = "select vUserInfo,vAllRecord  from h_employee  where EmpID='" . mysql_real_escape_string($EmpID) . "'";
            return $this->query($strSQLQuery, 1);
        }
    }

    function isUserKicked($loginID) {
        if (!empty($loginID)) {
            $strSQLQuery = "select Kicked from user_login  where loginID='" . $loginID . "'";
            $arryRow = $this->query($strSQLQuery, 1);
            return $arryRow[0]['Kicked'];
        }
    }

    //////////// Email Template Start ///// 

    function GetEmailTitle($templateID, $depID) {
        $sql = " where Status=1";
        $sql .= (!empty($depID)) ? (" and depID = '" . $depID . "'") : ("");
        $sql .= (!empty($templateID)) ? (" and templateID = '" . $templateID . "'") : ("");

        $sql = "select templateID,Title from emails " . $sql . " Order by Case When OrderBy>0 Then 0 Else 1 End,OrderBy,templateID";

        return $this->query($sql, 1);
    }

    function GetEmailTemplate($templateID, $depID) {
        $sql = " where 1";
        $sql .= (!empty($depID)) ? (" and depID = '" . $depID . "'") : ("");
        $sql .= (!empty($templateID)) ? (" and templateID = '" . $templateID . "'") : ("");

        $sql = "select * from emails " . $sql . " Order by Case When OrderBy>0 Then 0 Else 1 End,OrderBy,templateID";

        return $this->query($sql, 1);
    }

    function updateEmailTemplate($arryDetails) {
        global $Config;
        @extract($arryDetails);
        if (!empty($templateID)) {
            $sql = "update emails set Subject='" . mysql_real_escape_string(strip_tags($Subject)) . "', Content = '" . addslashes($TemplateContent) . "', UpdatedDate = '" . $Config['TodayDate'] . "' where templateID = '" . mysql_real_escape_string(strip_tags($templateID)) . "'";
            $rs = $this->query($sql, 0);
        }

        return true;
    }

    //////////// Email Template End ///// 

    function ExcelToPHPDate($dateValue = 0) {
        $myExcelBaseDate = 25569;
        //  Adjust for the spurious 29-Feb-1900 (Day 60)
        if ($dateValue < 60) {
            --$myExcelBaseDate;
        }

        // Perform conversion
        if ($dateValue >= 1) {
            $utcDays = $dateValue - $myExcelBaseDate;
            $returnValue = round($utcDays * 86400);
            if (($returnValue <= PHP_INT_MAX) && ($returnValue >= -PHP_INT_MAX)) {
                $returnValue = (integer) $returnValue;
            }
        } else {
            $hours = round($dateValue * 24);
            $mins = round($dateValue * 1440) - round($hours * 60);
            $secs = round($dateValue * 86400) - round($hours * 3600) - round($mins * 60);
            $returnValue = (integer) gmmktime($hours, $mins, $secs);
        }

        $returnValue = date("Y-m-d", $returnValue); //added by pk	
        // Return
        return $returnValue;
    }

    //////////// Record Counter Start ///// 
	
    function NumEmployee($Division=0) {
        $sql = "select count(EmpID) as NumRecord from h_employee ";
        $sql .= (!empty($Division)) ? (" where Division in (" . $Division . ")") : ("");
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumCandidate() {
        $sql = "select count(CanID) as NumRecord from h_candidate";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumHRMSDocument() {
        $sql = "select count(documentID) as NumRecord from h_document";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumAnnouncement() {
        $sql = "select count(newsID) as NumRecord from h_news";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumLead() {
        $sql = "select count(leadID) as NumRecord from c_lead where Opportunity='0'";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumOpportunity() {
        $sql = "select count(OpportunityID) as NumRecord from c_opportunity";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumTicket() {
        $sql = "select count(TicketID) as NumRecord from c_ticket";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumContact() {
        $sql = "select count(AddID) as NumRecord from s_address_book where CrmContact='1' and AddType='contact' ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumQuote() {
        $sql = "select count(quoteid) as NumRecord from c_quotes";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumEvent() {
        $sql = "select count(activityID) as NumRecord from c_activity";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumCampaign() {
        $sql = "select count(campaignID) as NumRecord from c_campaign";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumCRMDocument() {
        $sql = "select count(documentID) as NumRecord from c_document";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumItem() {
        $sql = "select count(ItemID) as NumRecord from inv_items";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumCustomer() {
        $sql = "select count(Cid) as NumRecord from s_customers";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumECOMMItem() {
        $sql = "select count(ProductID) as NumRecord from e_products";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumOrder() {
        $sql = "select count(OrderID) as NumRecord from e_orders";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumECOMMCustomer() {
        $sql = "select count(Cid) as NumRecord from e_customers where Login <> 'ExpressCheckoutUser'";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumWarehouse() {
        $sql = "select count(WID) as NumRecord from w_warehouse";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumBin() {
        $sql = "select count(binid) as NumRecord from w_binlocation";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumInbound() {
        $sql = "select count(OrderID) as NumRecord from w_order";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumOutbound() {
        $sql = "select count(id) as NumRecord from w_outbound";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumSO($Module) {
        $sql = "select count(OrderID) as NumRecord from s_order where Module='" . $Module . "' ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumPO($Module) {
        $sql = "select count(OrderID) as NumRecord from p_order where Module='" . $Module . "' ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumAccount() {
        $sql = "select count(BankAccountID) as NumRecord from f_account";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumCashReceipt() {
        $sql = "select count(p.PaymentID) as NumRecord from f_payments p left outer join s_order o on o.InvoiceID = p.InvoiceID where p.InvoiceID != '' and (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')   ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumInvoice() {
        $sql = "select count(OrderID) as NumRecord from s_order o where o.InvoiceID != '' and o.ReturnID = '' ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumPayment() {
        $sql = "select count(p.PaymentID) as NumRecord from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID where p.InvoiceID != '' and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense') ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumVendor() {
        $sql = "select count(SuppID) as NumRecord from p_supplier";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumPaymentTable() {
        $sql = "select count(p.PaymentID) as NumRecord from f_payments p inner join f_account a on p.AccountID=a.BankAccountID where p.AccountID>0";      
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }

    function NumPosVendor() {
        $sql = "select count(Cid) as NumRecord from e_customers where custType='vendorpos' ";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }
 
    function NumPosOrder() {
        $sql = "select count(SuppID) as NumRecord from p_supplier";
        $arryRow = $this->query($sql, 1);
        return $arryRow[0]['NumRecord'];
    }
    //////////// Record Counter End ///// 
    ///////////////Email Template //////////

    /*     * *********** Get Event By Bhoodev ************ */
    /*     * **************************************** */

    function GetEventDetail() {

        global $Config;

        $TodayDate = $Config['TodayDate'];
        $arryDate = explode("-", $TodayDate);
        $arryDay = explode(" ", $arryDate[2]);

        $today = date("m-d", strtotime($TodayDate));
        $tomorrow = date("m-d", mktime(0, 0, 0, $arryDate[1], $arryDay[0] + 1, $arryDate[0]));

        $sql = "SELECT EmpID,UserName,date_of_birth, CONCAT('Birthday') as EventType FROM `h_employee` WHERE Status='1' and (`date_of_birth` LIKE '%" . $today . "' or `date_of_birth` LIKE '%" . $tomorrow . "') order by Day(date_of_birth) asc";
        $arryDB = $this->query($sql, 1);


        $sql = "SELECT EmpID,UserName,JoiningDate, CONCAT('Joinning') as EventType FROM `h_employee` WHERE Status='1' and (JoiningDate LIKE '%" . $today . "' or JoiningDate LIKE '%" . $tomorrow . "') order by Day(JoiningDate) asc";
        $arryJoining = $this->query($sql, 1);


        $arryEvent = array_merge($arryDB, $arryJoining);
        return $arryEvent;
    }

    function GetTemplateContent($TemplateID = 0, $Status = 0) {
        $sql = " where 1 ";
        $sql .= (!empty($TemplateID)) ? (" and TemplateID = '" . $TemplateID . "'") : ("");
        $sql .= (!empty($Status) && $Status == 1) ? (" and Status = '" . $Status . "'") : ("");

        $sql = "select * from email_template " . $sql . " order by TemplateID asc";
        return $this->query($sql, 1);
    }

    function GetTemplateCategory($CatID) {
        global $Config;
        $sql = " where Status=1 and department = '" . $Config['CurrentDepID'] . "'";
        $sql .= (!empty($CatID)) ? (" and CatID = '" . $CatID . "'") : ("");

        $sql = "select * from email_cat " . $sql . " order by CatID asc";
        return $this->query($sql, 1);
    }

    function GetTemplateByCategory($CatID) {
        $sql = (!empty($CatID)) ? (" where CatID = '" . $CatID . "'") : ("");

        $sql = "select * from email_template " . $sql . " order by TemplateID asc";
        return $this->query($sql, 1);
    }

    function UpdateTemplateContent($arryDetails) {
        global $Config;
        extract($arryDetails);

        $sql = "update email_template set Status='" . $Status . "',Content='" . addslashes($TemplateContent) . "',subject='" . addslashes($subject) . "' where TemplateID = '" . $TemplateID . "'";

        $this->query($sql, 0);
    }

    function SendEventEmail($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (!empty($EmpID)) {
            $arryRow = $this->GetEmployeeBrief($EmpID);
            $ToName = $arryRow[0]['UserName'];
            $ToEmail = $arryRow[0]['Email'];

            if (sizeof($arryRow) > 0 && !empty($ToEmail)) {

                $contents = $TemplateContent;
                $mail = new MyMailer();
                $mail->IsMail();
                $mail->AddAddress($ToEmail);
                $mail->sender($Config['SiteName'] . " - ", $Config['AdminEmail']);
                $mail->Subject = $Config['SiteName'] . " - " . $subject;
                $mail->IsHTML(true);
                $mail->Body = $contents;

                #echo $ToEmail.$Config['AdminEmail'].$contents.$subject; exit;

                if ($Config['Online'] == '1') {
                    $mail->Send();
                }
                return 1;
            } else {
                return 0;
            }
        }
    }

    /*     * **************************************** */

    function GetEmailListId($adminId, $compId) {
        $sel_query = "select id,EmailId,name from importemaillist where AdminID='" . $adminId . "' and CompID='" . $compId . "' and status='1' and DefalultEmail='1'";
        return $this->query($sel_query, 1);
    }

    function DashboardIconRoleGroup($depID, $GroupID) {
        global $Config;


        if ($_SESSION['AdminType'] == "admin") {
            $wheresql = " and i.`Default`='0' ";
        } else {

            $strSQLQuery = "select IconID from dashboard_icon where `Default`='1' and Status='1' and Display='1'  ";
            $rs = $this->query($strSQLQuery);
            $DefaultIcon = '';
            if (sizeof($rs) > 0) {
                foreach ($rs as $key => $values) {
                    $DefaultIcon .= $values['IconID'] . ',';
                }
                $DefaultIcon = rtrim($DefaultIcon, ",");
            }

            if (!empty($DefaultIcon)) {
                $wheresql = " and (i.IconID in(" . $DefaultIcon . ") or i.IconID in( select distinct(i.IconID) from dashboard_icon i inner join permission_group p on i.ModuleID =p.ModuleID and i.EditPage<=p.ModifyLabel where p.GroupID='" . $GroupID . "'))";
            } else {
                $joinsql = "inner join permission_group p on (i.ModuleID =p.ModuleID and i.EditPage<=p.ModifyLabel and p.GroupID='" . $GroupID . "')";
            }
        }


        $sql = "select i.* from dashboard_icon i " . $joinsql . " inner join admin_modules m on i.ModuleID=m.ModuleID where m.Status='1' and i.Status='1' and i.Display='1' and i.depID='" . $depID . "' " . $wheresql . " Order by Case When i.OrderBy>0 Then 0 Else 1 End,i.OrderBy,i.IconID ";


        return $this->query($sql, 1);
    }

    function GetInventryMenuItems() {

        $sql = "select * from  admin_modules  where   ModuleID in(628,634,643,644,655,638,640,641,645,646,647,629,635,636,637,639,642,648,649,650,651,652,653,2009,2012) order by Parent,OrderBy,ModuleID asc";   //654

        return $this->query($sql, 1);
    }

    function updateInventorySettings($arryDetails) {
        @extract($arryDetails);
        global $Config;

        $sql = "update admin_modules set Status='0' where  ModuleID in(628,634,643,644,655,638,640,641,645,646,647,610,629,635,636,637,639,642,648,649,650,651,652,653,2009,2012)";
      
	//654

	 $rs = $this->query($sql, 0);

        $sqlmainmenu = "update admin_modules set Status='0' where  depID='6' and ModuleID in(601,602,603,604,605,610)";
        $rsm = $this->query($sqlmainmenu, 0);

        //$sqlmainmenu="update dashboard_icon set Status=0 where  depID=6 and ModuleID in(601,602,603,604,605,610)";

        $sqldashboard = "update dashboard_icon set Display='0' where  depID='6'";
        $rsd = $this->query($sqldashboard, 0);



        foreach ($arryDetails['IconID'] as $IconID) {


            $sql = "update admin_modules set Status='1' where ModuleID = '" . $IconID . "'";



            $rs = $this->query($sql, 0);

            $sqlCount = "select Parent from admin_modules where  Status='1' and ModuleID='" . $IconID . "'";

            $rsCount = $this->query($sqlCount);
            if (sizeof($rsCount) > 0) {

                $sqlCount1 = "select Parent from admin_modules where  Status='1' and ModuleID='" . $IconID . "'";
                $GetLink = "select Link from admin_modules where  Status='1' and ModuleID='" . $IconID . "'";

                $rsCountt = $this->query($GetLink);


                $id = mysql_result(mysql_query($sqlCount1), 0);





                $sql1 = "update admin_modules set Status='1' where ModuleID='" . $id . "' and depID='6'";


                $rsCount1 = $this->query($sql1, 0);

                $Sqla = "Update  dashboard_icon set  Display='1'  where Link= '" . $rsCountt[0]["Link"] . "' ";


                $rsCounta3 = $this->query($Sqla, 0);
            } else {

                $sqlCount2 = "select Parent from admin_modules where  Status='0' and ModuleID='" . $IconID . "'";

                $id2 = mysql_result(mysql_query($sqlCount2), 0);

                $GetLink = "select Link from admin_modules where  Status='0' and ModuleID='" . $IconID . "'";

                $rsCountt = $this->query($GetLink);
                $sql2 = "update admin_modules set Status='0' where ModuleID='" . $id2 . "' and depID='6'";

                $rsCount2 = $this->query($sql2, 0);



                $Sqla = "Update  dashboard_icon set  Display='1'  where Link= '" . $rsCountt[0]["Link"] . "' ";


                $rsCounta3 = $this->query($Sqla, 0);
            }
        }

        /*         * **************** */
        $trackSql = "select ModuleID from admin_modules where ModuleID in(602,603,604) and Status='1'";
        $arryTrack = $this->query($trackSql);
        if (!empty($arryTrack[0]['ModuleID'])) {
            $TrackInventory = 1;
        } else {
            $TrackInventory = 0;
        }

        $Config['DbName'] = $Config['DbMain'];
        $this->dbName = $Config['DbName'];
        $this->connect();
        $strSQLQuery = "update company set  TrackInventory='" . $TrackInventory . "' where CmpID='" . $_SESSION['CmpID'] . "'";
        $this->query($strSQLQuery, 0);
        /*         * ******************** */


        return true;
    }

    function GetInventrySumMenuItems() {
        $sql = " ";

        $sql = "select * from  inv_setting order by id asc";


        return $this->query($sql, 1);
    }

    function updateInventorySettingSumenu($arryDetails) {
        @extract($arryDetails);

        $sql = "update inv_setting set Status='0' ";
        $rs = $this->query($sql, 0);
        foreach ($arryDetails['IconID'] as $IconID) {

            $sql = "update inv_setting set Status='1' where id= '" . $IconID . "'";

            $rs = $this->query($sql, 0);
        }

        return true;
    }

    /*     * **************************** */

    function GetMainMenu($depID) {
        $sql = " where 1 ";
        $sql .= (!empty($depID)) ? (" and depID = '" . $depID . "'") : ("");
        //$sql .= " and `Default` = 0";
        $sql = "select * from admin_modules  " . $sql . " order by ModuleID asc";
        return $this->query($sql, 1);
    }

    function updateMenuSettings($arryDetails) {
        @extract($arryDetails);
        // print_r($arryDetails);exit;	
        $ModuleID = '';
        if ($numModule > 0) {

            foreach ($arryDetails['MainModuleID'] as $ModuleID) {

                if (in_array($ModuleID, $arryDetails['ModuleID'])) {
                    $Status = '1';
                } else {
                    $Status = '0';
                }

                /*                 * ****CRM****** */
                if ($ModuleID == '102') {
                    $ModuleID .= ',124,134';
                } else if ($ModuleID == '176') {
                    $ModuleID .= ',1051';
                } else if ($ModuleID == '104') {
                    $ModuleID .= ',130';
                } else if ($ModuleID == '136') {
                    $ModuleID .= ',153,154';
                } else if ($ModuleID == '182') {
                    $ModuleID .= ',1054';
                } else if ($ModuleID == '106') {
                    $ModuleID .= ',143';
                } 
                /*                 * *********** */

                $sql = "update admin_modules set Status='" . $Status . "' where ModuleID in(" . $ModuleID . ") ";
                $rs = $this->query($sql, 0);
            }
        }
        return true;
    }

    function getSettingVariable($settingKey) {
        $strSQLQuery = "select setting_value from settings where setting_key ='" . trim($settingKey) . "'";
        $arryRow = $this->query($strSQLQuery, 1);
        $settingValue = $arryRow[0]['setting_value'];
        return $settingValue;
    }

    function getSettingVariableAll($settingKey) {
        $strSQLQuery = "select * from settings where setting_key ='" . trim($settingKey) . "'";
        $arryRow = $this->query($strSQLQuery, 1);
        return $arryRow;
    }

   function getSettingCaption($settingKey) {
        $strSQLQuery = "select caption from settings where setting_key ='" . trim($settingKey) . "'";
        $arryRow = $this->query($strSQLQuery, 1);
        $settingValue = $arryRow[0]['caption'];
        return $settingValue;
    }

	function getDefaultAccount()
	{
		$strSQLQuery = "select BankAccountID from f_account where DefaultAccount ='1' and Status='Yes' order by BankAccountID desc limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		$BankAccountID = $arryRow[0]['BankAccountID'];	
		return $BankAccountID;
		
	}

    /*     * *********** */

    function UpdateModuleAutoID($Table, $Module, $OrderID, $ModuleIDValue) {
        if ($OrderID > 0) {
            if (!empty($ModuleIDValue)) { //update if entered in box
                /* $pattern = "/^[a-zA-Z]+(\d+)$/";
                  if(preg_match_all($pattern, $ModuleIDValue, $matches)){
                  $AutoID = filter_var($ModuleIDValue, FILTER_SANITIZE_NUMBER_INT);
                  } */
                $AutoID = filter_var($ModuleIDValue, FILTER_SANITIZE_NUMBER_INT);
                $strSQLFinal = "update " . $Table . " set AutoID='" . $AutoID . "' where OrderID='" . $OrderID . "'";
            } else { //update if blank
                if ($Table == 's_order') { //Sales
                    switch ($Module) {
                        case 'Quote':
                            $ModuleID = "QuoteID";
                            $PrefixString = 'SQ_PREFIX';
                            $StartString = 'SQ_START';
                            break;
                        case 'Order':
                            $ModuleID = "SaleID";
                            $PrefixString = 'SO_PREFIX';
                            $StartString = 'SO_START';
                            break;
                        case 'Credit':
                            $ModuleID = "CreditID";
                            $PrefixString = 'CRD_S_PREFIX';
                            $StartString = 'CRD_S_START';
                            break;
                        case 'Invoice':
                            $ModuleID = "InvoiceID";
                            $PrefixString = 'INV_S_PREFIX';
                            $StartString = 'INV_S_START';
                            break;
                        case 'RMA':
                            $ModuleID = "ReturnID";
                            $PrefixString = 'RMA_S_PREFIX';
                            $StartString = 'RMA_S_START';
                            break;
		       case 'Shipment': 
                            $ModuleID = "ShippedID";
                            $PrefixString = 'SHIP_PREFIX';
                    	    $StartString = 'SHIP_START';
                            break;
                    }
                } else if ($Table == 'p_order') {  //Purchase
                    switch ($Module) {
                        case 'Quote':
                            $ModuleID = "QuoteID";
                            $PrefixString = 'PQ_PREFIX';
                            $StartString = 'PQ_START';
                            break;
                        case 'Order':
                            $ModuleID = "PurchaseID";
                            $PrefixString = 'PO_PREFIX';
                            $StartString = 'PO_START';
                            break;
                        case 'Credit':
                            $ModuleID = "CreditID";
                            $PrefixString = 'CRD_P_PREFIX';
                            $StartString = 'CRD_P_START';
                            break;
                        case 'Receipt':
                            $ModuleID = "ReceiptID";
                            $PrefixString = 'REC_P_PREFIX';
                            $StartString = 'REC_P_START';
                            break;
                        case 'Invoice':
                            $ModuleID = "InvoiceID";
                            $PrefixString = 'INV_P_PREFIX';
                            $StartString = 'INV_P_START';
                            break;
                        case 'RMA':
                            $ModuleID = "ReturnID";
                            $PrefixString = 'RMA_P_PREFIX';
                            $StartString = 'RMA_P_START';
                            break;
                    }
                }

                $strSQL = "select max(AutoID) as MaxAutoID from " . $Table . "  where OrderID != '" . $OrderID . "' and Module='" . $Module . "'";
                $arryAuto = $this->query($strSQL, 1);


                $PrefixModule = $this->getSettingVariable($PrefixString);
                $StartNum = $this->getSettingVariable($StartString);
                $MaxAutoID = $arryAuto[0]['MaxAutoID'];
                if (empty($MaxAutoID)) {
                    $AutoID = ($StartNum != '') ? ($StartNum) : ($OrderID);
                } else {
                    $AutoID = $MaxAutoID + 1;
                }
                $ModuleIDValue = $PrefixModule . $AutoID;

                $strSQLFinal = "update " . $Table . " set AutoID='" . $AutoID . "', " . $ModuleID . "='" . $ModuleIDValue . "' where OrderID='" . $OrderID . "'";
            }
             
            $this->query($strSQLFinal, 0);
        }


        return true;
    }

    /*     * *********** */
	function UpdateModuleAutoReceiptID($Table, $Module, $ReceiptID, $ReceiptIDColumn, $ModuleIDValue) {
	
        if ($ReceiptID > 0) {
	
            if (!empty($ModuleIDValue)) { //update if entered in box                
                $AutoID = filter_var($ModuleIDValue, FILTER_SANITIZE_NUMBER_INT);
                $strSQLFinal = "update " . $Table . " set AutoID='" . $AutoID . "' where ".$ReceiptIDColumn."='" . $ReceiptID . "'";
            } else { //update if blank
                if ($Table == 'w_receipt') { //CRMA
                    $ModuleID = "ReceiptNo";
                    $PrefixString = 'RMA_C_PREFIX';
                    $StartString = 'RMA_C_START';
                } else if ($Table == 'w_receiptpo') {  //VRMA
			$ModuleID = "ReceiptNo";
                    	$PrefixString = 'RMA_V_PREFIX';
                    	$StartString = 'RMA_V_START';
                 } else if ($Table == 'w_workorder') {  //Work Order
			$ModuleID = "WON";
                    	$PrefixString = 'WO_PREFIX';
                    	$StartString = 'WO_START';
                }

                $strSQL = "select max(AutoID) as MaxAutoID from " . $Table . "  where ".$ReceiptIDColumn." != '" . $ReceiptID . "' ";
		if(!empty($Module)) $strSQL .= " and Module='" . $Module . "'";
		 
                $arryAuto = $this->query($strSQL, 1);
 

                $PrefixModule = $this->getSettingVariable($PrefixString);
                $StartNum = $this->getSettingVariable($StartString);
                $MaxAutoID = $arryAuto[0]['MaxAutoID'];
                if (empty($MaxAutoID)) {
                    $AutoID = ($StartNum != '') ? ($StartNum) : ($ReceiptID);
                } else {
                    $AutoID = $MaxAutoID + 1;
                }
                $ModuleIDValue = $PrefixModule . $AutoID;

                $strSQLFinal = "update " . $Table . " set AutoID='" . $AutoID . "', " . $ModuleID . "='" . $ModuleIDValue . "' where ".$ReceiptIDColumn."='" . $ReceiptID . "'";
            }
             //echo $strSQLFinal;die;
            $this->query($strSQLFinal, 0);
        }


        return true;
    }
    /*     * *********** */

    function EditUpdateAutoID($Table, $ModuleID, $OrderID, $ModuleIDValue) {
        if ($OrderID > 0 && !empty($ModuleID) && !empty($ModuleIDValue)) {

            $strSQL = "select " . $ModuleID . " as ModuleVal from " . $Table . "  where OrderID = '" . $OrderID . "'";
            $arryMd = $this->query($strSQL, 1);

            if ($ModuleIDValue != $arryMd[0]['ModuleVal']) { //update if entered in box
                /* $pattern = "/^[a-zA-Z]+(\d+)$/";
                  if(preg_match_all($pattern, $ModuleIDValue, $matches)){
                  $AutoID = filter_var($ModuleIDValue, FILTER_SANITIZE_NUMBER_INT);
                  } */
                $AutoID = filter_var($ModuleIDValue, FILTER_SANITIZE_NUMBER_INT);
                $strSQLFinal = "update " . $Table . " set " . $ModuleID . "='" . $ModuleIDValue . "', AutoID='" . $AutoID . "' where OrderID='" . $OrderID . "'";
                $this->query($strSQLFinal, 0);
                //echo $strSQLFinal;exit;
            }
        }
        return true;
    }

    /*     * *********** */
    /*     * *********** */

    function GetNextModuleID($Table, $Module) {
        if ($Table == 's_order') {  //Sales
            switch ($Module) {
                case 'Quote':
                    $PrefixString = 'SQ_PREFIX';
                    $StartString = 'SQ_START';
                    break;
                case 'Order':
                    $PrefixString = 'SO_PREFIX';
                    $StartString = 'SO_START';
                    break;
                case 'Credit':
                    $PrefixString = 'CRD_S_PREFIX';
                    $StartString = 'CRD_S_START';
                    break;
                case 'Invoice':
                    $PrefixString = 'INV_S_PREFIX';
                    $StartString = 'INV_S_START';
                    break;
                case 'RMA':
                    $PrefixString = 'RMA_S_PREFIX';
                    $StartString = 'RMA_S_START';
                    break;
		case 'Shipment':
                    $PrefixString = 'SHIP_PREFIX';
                    $StartString = 'SHIP_START';
                    break;
		case 'Picking':
                    $PrefixString = 'PICK_PREFIX';
                    $StartString = 'PICK_START';
                    break;
            }
        } else if ($Table == 'p_order') {  //Purchase
            switch ($Module) {
                case 'Quote':
                    $PrefixString = 'PQ_PREFIX';
                    $StartString = 'PQ_START';
                    break;
                case 'Order':
                    $PrefixString = 'PO_PREFIX';
                    $StartString = 'PO_START';
                    break;
                case 'Credit':
                    $PrefixString = 'CRD_P_PREFIX';
                    $StartString = 'CRD_P_START';
                    break;
                case 'Receipt':
                    $PrefixString = 'REC_P_PREFIX';
                    $StartString = 'REC_P_START';
                    break;
                case 'Invoice':
                    $PrefixString = 'INV_P_PREFIX';
                    $StartString = 'INV_P_START';
                    break;
                case 'RMA':
                    $PrefixString = 'RMA_P_PREFIX';
                    $StartString = 'RMA_P_START';
                    break;
            }
        } else if ($Table == 'w_receipt') {  //CRMA		 
		$PrefixString = 'RMA_C_PREFIX';
		$StartString = 'RMA_C_START';                    
	 } else if ($Table == 'w_receiptpo') {  //VRMA		 
		$PrefixString = 'RMA_V_PREFIX';
		$StartString = 'RMA_V_START';                    
	 } else if ($Table == 'w_workorder') {  //Work Order		 
		$PrefixString = 'WO_PREFIX';
		$StartString = 'WO_START'; 		          
	}

        $strSQL = "select max(AutoID) as MaxAutoID from " . $Table;
	if(!empty($Module))$strSQL .= " where Module='" . $Module . "'";
 
        $arryAuto = $this->query($strSQL, 1);

        $PrefixModule = $this->getSettingVariable($PrefixString);
        $StartNum = $this->getSettingVariable($StartString);
        $MaxAutoID = $arryAuto[0]['MaxAutoID'];
        if (empty($MaxAutoID)) {
            $AutoID = ($StartNum != '') ? ($StartNum) : ($OrderID);
        } else {
            $AutoID = $MaxAutoID + 1;
        }
        $ModuleIDValue = $PrefixModule . $AutoID;

        return $ModuleIDValue;
    }

    /*     * *********** */

    function GetShipMethodName($ShippingMethod, $ShippingMethodVal) {
	global $Config;
        if ($ShippingMethod == 'UPS') {
            $strSQLQuery = "SELECT service_type FROM ".$Config['DbMain'].".ups_service_type where service_value='" . $ShippingMethodVal . "'";
        } elseif ($ShippingMethod == 'USPS') {
            $strSQLQuery = "SELECT service_type FROM ".$Config['DbMain'].".usps_service_type where service_value='" . $ShippingMethodVal . "'";
        } elseif ($ShippingMethod == 'Fedex') {
            $strSQLQuery = "SELECT service_type FROM ".$Config['DbMain'].".fedex_service_type where service_value='" . $ShippingMethodVal . "'";
        } elseif ($ShippingMethod == 'DHL') {
            $strSQLQuery = "SELECT service_type FROM ".$Config['DbMain'].".dhl_service_type where service_value='" . $ShippingMethodVal . "'";
        }

        if (!empty($strSQLQuery)) {
            return $this->query($strSQLQuery, 1);
        }
    }


	   
/**************** Abid *************/       
function updateRestrictionMenuSettings($arryDetails) { //echo "<pre>";print_r($arryDetails);
        @extract($arryDetails);
        $ModuleID = '';
        if ($numModule > 0) {

            foreach ($arryDetails['MainModuleID'] as $ModuleID) {
//echo "<pre>";print_r($ModuleID);//}
                if (in_array($ModuleID,$arryDetails['ModuleID'])) {
                   echo  $Restricted = '1';
                } else {
                   echo  $Restricted = '0';
                }

                /*                 * ****CRM****** */
                if ($ModuleID == '102') {
                    $ModuleID .= ',124,134';
                } else if ($ModuleID == '176') {
                    $ModuleID .= ',1051';
                } else if ($ModuleID == '104') {
                    $ModuleID .= ',130';
                } else if ($ModuleID == '136') {
                    $ModuleID .= ',153,154';
                } else if ($ModuleID == '182') {
                    $ModuleID .= ',1054';
                } else if ($ModuleID == '106') {
                    $ModuleID .= ',143';
                }
                /*                 * *********** */

               $sql = "update admin_modules set Restricted='" . $Restricted . "' where ModuleID in(" . $ModuleID . ") ";
               $rs = $this->query($sql, 0);
            }
        }
        return true;
    }
/********** End By Abid ************/


	function GetSupplierVal($BankAccountID){
		$strSQLQuery = "SELECT BankAccountID,BankName,AccountName,AccountNumber FROM f_account where BankAccountID='".$BankAccountID."'";
         	return $this->query($strSQLQuery, 1);      	
		
	}


 	function updateReimLocation($arryDetails) {
		@extract($arryDetails);
		$locationID = mysql_real_escape_string($_SESSION['locationID']);
		if (!empty($locationID)) {
		   $sql = "update location set ReimRate = '" . mysql_real_escape_string($ReimRate) . "', ReimMileageGL = '" . mysql_real_escape_string($ReimMileageGL) . "', ReimMissGL = '" . mysql_real_escape_string($ReimMissGL) . "' where locationID = '" . $locationID . "'";
		  $rs = $this->query($sql, 0);
		}
		return true;
       }


/*********************************/
	    
			 function getRightMenuByDepId($depID,$Parent,$EditView)
                {   
       				if($Parent==2016) $Parent=860;//customer in crm
       				
       				 
                  $strSQLQuery = "select * from ".$_SESSION['CmpDatabase'].".admin_right_modules where Status='1' and depID='".$depID."' and Parent='".$Parent."' and EditView in (0,".$EditView.")  ORDER BY ModuleID asc, OrderBy asc";
		       	  $arryResult = $this->query($strSQLQuery, 1);
                  return $arryResult;
                  
                }
                
		 function getRightMenuByModuleId($ModuleID)
                {   
       
                  $strSQLQuery = "select * from admin_right_modules where ModuleID='".$ModuleID."'";
		       	  $arryResult = $this->query($strSQLQuery, 1);
                  return $arryResult;
                  
                }
                
                
             function updateByModuleId($ModuleID,$Module)
                {   
       
                  $strSQLQuery = "UPDATE admin_right_modules SET Module = '".$Module."' WHERE ModuleID = '".$ModuleID."'";
		       	  $arryResult = $this->query($strSQLQuery, 1);
                  return true;
                  
                }
                

		 function getRightMenuByLink($Link)
                {  
                    if(!empty($Link)){
                  $strSQLQuery = "select Module from admin_right_modules where Link='".$Link."'";
                     $arryResult = $this->query($strSQLQuery, 1);
                  return $arryResult;
                    }
                   
                
                }
                
		function updateLastViewTime(){   
			if($_SESSION['loginID']>0){
				$strSQL = "update user_login set LastViewTime='".$_SESSION['TodayDate']."' where loginID='".$_SESSION['loginID']."'";
				$this->query($strSQL, 0);
			}
			return true;

		}
		/*********************************/
		    function GetAttribFinance555($attribute_name, $OrderBy) {

			 
				 $strSQLFeaturedQuery = (!empty($attribute_name)) ? (" where a.attribute_name='" . $attribute_name . "' and v.Status='1' ") : ("");
				$OrderSql = (!empty($OrderBy)) ? (" order by v." . $OrderBy . " asc") : (" order by v.value_id asc");
				$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id " . $strSQLFeaturedQuery . $OrderSql;
			 

			return $this->query($strSQLQuery, 1);
		    }

		function MovePaymentMethod(){   			 
			$arryPaymentMethod = $this->GetAttribFinance555('PaymentMethod','');
			for($i=0;$i<sizeof($arryPaymentMethod);$i++) {
				 $strSQLQuery = "insert ignore into f_method (methodType, methodName, Status) values( '0', '".addslashes($arryPaymentMethod[$i]['attribute_value'])."', '".$arryPaymentMethod[$i]['Status']."')";

				$this->query($strSQLQuery, 0);
			}
		}

		
	   function RecurringHoliday(){ 
			global $Config;
			
			$sql = "select * from h_holiday order by holidayDate asc";
			$arryHoliday = $this->query($sql, 1);

	             	//$Config['TodayDate'] = '2016-12-31';//temp

			$TodayDateVal = $Config['TodayDate'];
			$NextDate = date("Y-m-d", strtotime($Config['TodayDate']) + 24*3600);
			$arryDay = explode("-", $NextDate);
			$Year = (int)$arryDay[0] ;
			$Month = $arryDay[1];
			 
			 if($Month == '01'){  
				   for($i=0;$i<sizeof($arryHoliday);$i++) {      
					     if($arryHoliday[$i]['Recurring'] ==1){  
						$arryHolidayDate = explode("-", $arryHoliday[$i]['holidayDate']);	
						
						$H_Month = $arryHolidayDate[1];
						$H_Day = $arryHolidayDate[2];

						$holidayDate = $Year.'-'.$H_Month.'-'.$H_Day;
					     }else{
			                         $holidayDate ='0000-00-00';
			                     }

					$sql = "update h_holiday set holidayDate = '".$holidayDate."' where holidayID = '".$arryHoliday[$i]['holidayID']."'";
					$this->query($sql,0);
				      	//echo $sql.'<br>';	
			           
			      } 
			}
			
			
			return true;
		            
		  }



	function  GetOrderDate($OrderID,$DateCol,$Table){
		if(!empty($OrderID) && !empty($DateCol) && !empty($Table) )	{		
			$strSQL = "select ".$DateCol." as OrderDate from ".$Table." where OrderID ='".$OrderID."'";
			$arrayR = $this->query($strSQL, 1);
			return $arrayR[0]["OrderDate"];
		}
	}

	function GetDefaultArrayValue($TableName){
		if(!empty($TableName)){	
			$arryTable = explode(",",$TableName);	
			if(!empty($arryTable[0])){
				foreach($arryTable as $Table){
					if(!empty($Table)){
						$ArrayFieldName = $this->GetFieldName($Table);
						foreach($ArrayFieldName as $key=>$values){
							$arryCommanField[0][$values['Field']] = "";
						}
					}
				}
				return $arryCommanField;
			}
		}
	}

	
	function GetDefaultShipVendor($name){
		$strSqlQuery="SELECT SuppCode FROM w_shipping_credential where LOWER(api_name) ='".strtolower($name)."' and defaultVal = '1'";
		$results = $this->query($strSqlQuery,1);
		if(!empty($results[0]['SuppCode'])) return $results[0]['SuppCode'];
	
	}


	function isEbayActive(){
		$strSQLQuery = "SELECT ebay_ID FROM `ebay_settings` WHERE `p_devID`!='' or s_devID!='' limit 0,1";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ebay_ID'])) {
			return true;
		} else {
			return false;
		}

	}
	function isAmazonActive(){
		$strSQLQuery = "SELECT id FROM `amazon_accounts` WHERE `merchant_id`!='' limit 0,1";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['id'])) {
			return true;
		} else {
			return false;
		}

	}




//updated on 8May2018 by chetan/saiyed//
	function GeneratePDF($PdfArray){
		global $Config;
		
		//if($Config['Online']==1){
			extract($PdfArray);
			if(!empty($ModuleDepName) && !empty($Module) && !empty($OrderColumn) && !empty($OrderID)  && !empty($TableName)){
				$addSql='';
				if($Module=="Invoice"){
					$addSql .= ", InvoiceEntry";
				}


				if(isset($ModuleID)){
				$strSQLQuery = "SELECT ".$OrderColumn.", ".$ModuleID.$addSql." FROM `".$TableName."` WHERE `".$OrderColumn."`='".$OrderID."' ";
				}else{
				$ModuleID = $OrderColumn;
				$strSQLQuery = "SELECT ".$ModuleID.$addSql." FROM `".$TableName."` WHERE `".$ModuleID."`='".$OrderID."' ";
				}
				$arryRow = $this->query($strSQLQuery, 1);
				
				if(!empty($arryRow[0][$ModuleID])){
					$ModuleIDVal = $arryRow[0][$ModuleID];
					$InvoiceEntry = $arryRow[0]["InvoiceEntry"];

					if($ModuleDepName=="SalesInvoice" && ($InvoiceEntry == "2" || $InvoiceEntry == "3")){
						$ModuleDepName = "SalesInvoiceGl";
					}
				
					/*added on 12Mar2018 by chetan*/
					if($templId!=''){
					$temp = '-temp'.$templId; 
					$PdfDestination = $UploadPrefix.'upload/'.$_SESSION['CmpID'].'/'.$dir. $ModuleDepName.'-'.$ModuleIDVal.$temp.'.pdf';
					}else{
					$PdfDestination = $UploadPrefix.'upload/pdf/'.$_SESSION['CmpID'].'/'. $ModuleDepName.'-'.$ModuleIDVal.'.pdf';
					$templId = '';
					}
					/*END*/


					//$PdfDestination = $UploadPrefix.'upload/pdf/'.$_SESSION['CmpID'].'/'. $ModuleDepName.'-'.$ModuleIDVal.'.pdf';
					$OldPdfSize=0;
					if(file_exists($PdfDestination)){
						$OldPdfSize = filesize($PdfDestination)/1024; //KB	
						unlink($PdfDestination);			 						}
					$cmd="/usr/bin/php /var/www/html/erp/admin/pdfCommon.php ".$OrderID." ".$ModuleDepName." ".$Module." ".$_SESSION['CmpID']." ".$_SESSION['CmpDatabase']." ".$templId;//added $templId on 12Mar2018 by chetan//
					//if($_SESSION['CmpID'] == '37') echo $cmd;die;
					$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);
					sleep(2);			
					$this->UpdateStorage($PdfDestination,$OldPdfSize,0);
				}
			}
		//}
		return true;
	}


	function GeneratePaidInvoicePDF(){

		#$strAdd = " and o.InvoiceID in ('INV62588' , 'INV62367') ";

		$strSQL = "select o.InvoiceID, o.OrderID, o.InvoiceEntry, o.InvoicePaid, o.PaymentTerm, o.OrderPaid from s_order o where  o.Module='Invoice' and o.Pdf='0' ".$strAdd." and (o.InvoicePaid='Paid' or (o.PaymentTerm='Credit Card' and OrderPaid='1')) order by o.OrderID ASC  ";
		$arryTop = $this->query($strSQL, 1);
		//pr($arryTop);die;
		$C=0; $Limit=100;
		foreach($arryTop as $key => $values) {			 
			$OrderID = $values['OrderID'];	
			$InvoiceID = $values['InvoiceID'];
			$InvoiceEntry = $values['InvoiceEntry'];			 
			#echo '<br>'.$values['InvoiceID'].'#'.$values['InvoicePaid'].'#'.$values['PaymentTerm'].'#'.$values['OrderPaid'];die;

			if($InvoiceEntry == "2" || $InvoiceEntry == "3"){
				$ModuleDepName = "SalesInvoiceGl";
			}else{
				$ModuleDepName = "SalesInvoice";
			}
			$PdfDestination = 'upload/pdf/'.$_SESSION['CmpID'].'/'. $ModuleDepName.'-'.$InvoiceID.'.pdf';
					
			if(file_exists($PdfDestination)){				 			 		unset($PdfArray);
				$PdfArray['InvoiceID'] = $InvoiceID;
				$PdfArray['ModuleDepName'] = $ModuleDepName;
				$PdfArray['Module'] = "Invoice";
				$PdfArray['ModuleID'] = "InvoiceID";
				$PdfArray['TableName'] =  "s_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $OrderID;	
				pr($PdfArray);	
				//if($_GET['pk']==1){			
					$this->GeneratePDF($PdfArray);
					$C++;
					$sql = "update s_order set Pdf = '1' where OrderID = '".$OrderID."'";
					$this->query($sql,0);	
				//}		
				if($C==$Limit)die;
					
			}
			
			
			 
		}
		

		echo $C.' records <br>';
	}


	function RemoveFileStorage($CmpID, $RemoveFileSize) {
		global $Config;		 	
		$sql = "select Storage from ".$Config['DbMain'].".company where CmpID='" . $CmpID . "'";	 
		 
		$arryRow = $this->query($sql, 1);	
		 
		if ($RemoveFileSize > 0) {		    		
		    $NewStorage = $arryRow[0]['Storage'] - $RemoveFileSize;
		     
		    if ($NewStorage < 0)
		        $NewStorage = 0;
		    else
		        $NewStorage = round($NewStorage, 2);
		    $sql = "update ".$Config['DbMain'].".company set Storage='" . $NewStorage . "' where CmpID='" . $CmpID . "'";			 
		    $this->query($sql, 0);
		    
		}
       	 	return true;
    	}

	function UpdateFileStorage($CmpID, $UploadFileSize) {
		global $Config;
		$objConfig = new admin();		
		$sql = "select Storage from ".$Config['DbMain'].".company where CmpID='" . $CmpID . "'";		$arryRow = $this->query($sql, 1);	
		 
		if ($UploadFileSize > 0) {		    		
		    $NewStorage = $arryRow[0]['Storage'] + $UploadFileSize;
		     
		    if ($NewStorage < 0)
		        $NewStorage = 0;
		    else
		        $NewStorage = round($NewStorage, 2);
		    $sql = "update ".$Config['DbMain'].".company set Storage='" . $NewStorage . "' where CmpID='" . $CmpID . "'";			 
		    $this->query($sql, 0);
		    
		}
       	 	return true;
    	}

}

?>
