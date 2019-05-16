<?php

class report extends dbClass {

    //constructor
    function report() {
        $this->dbClass();
    }

    function ListReportRule($id = 0, $SearchKey, $SortBy, $AscDesc) {
        global $Config;
        $strAddQuery = "where 1";
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" and reportID='" . $id . "'") : ("  ");

	/*$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",l.AssignTo) OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");*/


        if ($SortBy == 'reportID') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (reportID = '" . $SearchKey . "')") : ("");
        } else if ($SortBy == 'title') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (title like '%" . $SearchKey . "%' )") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
               
                $strAddQuery .= (!empty($SearchKey)) ? (" and  title like '%" . $SearchKey . "%'   ) " ) : ("");
            }
        }
        
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by reportID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : ("desc");

        $strSQLQuery = "select * from h_report_rule " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

   

   

   

    function GetReportRule($reportID) {
        
        global $Config;
       
        $strSQLQuery = "select * from h_report_rule   ";
        $strSQLQuery .= (!empty($reportID)) ? (" where reportID='" . $reportID . "'") : (" where 1 ");
        
        return $this->query($strSQLQuery, 1);
        
    }

   

    

   


    function AddReportRule($arryDetails) {
        $objConfigure = new configure();
        global $Config;

        extract($arryDetails);

       $strSQLQuery = "insert into h_report_rule (title,ReportRule,reportAllColumn,FromDate,ToDate,Status,DurationCheck,BreakCheck ,PunchCheck ,DurationFormat ) values( '".mysql_real_escape_string($FormTitle)."','".mysql_real_escape_string($ReportRule)."','".mysql_real_escape_string($reportAllColumn)."','".mysql_real_escape_string($FromDate)."','".mysql_real_escape_string($ToDate)."','".mysql_real_escape_string($Status)."','".mysql_real_escape_string($DurationCheck)."', '".mysql_real_escape_string($BreakCheck)."', '".mysql_real_escape_string($PunchCheck)."', '".mysql_real_escape_string($DurationFormat)."')";
$this->query($strSQLQuery, 0);




        $reporID = $this->lastInsertId();



        return $reporID;
    }

    function UpdateReportRule($arryDetails) {
       
        global $Config;

        extract($arryDetails);

        $strSQLQuery = "update h_report_rule set title='".mysql_real_escape_string(strip_tags($FormTitle))."',  ReportRule='".addslashes($ReportRule)."',reportAllColumn='".mysql_real_escape_string($reportAllColumn)."',FromDate='".mysql_real_escape_string($FromDate)."',ToDate='".mysql_real_escape_string($ToDate)."',Status='".addslashes($Status)."',DurationCheck ='".mysql_real_escape_string($DurationCheck)."',BreakCheck ='".mysql_real_escape_string($BreakCheck)."',PunchCheck ='".mysql_real_escape_string($PunchCheck)."',DurationFormat ='".mysql_real_escape_string($DurationFormat)."'  where reportID='".mysql_real_escape_string($reportID)."'" ;
$this->query($strSQLQuery, 0);	

       

        return 1;
    }

function getAttendenceReport($attDate,$startDate,$endDate)
	{
		$sql = " where e.ExistingEmployee='1' and e.JoiningDate<='".$endDate."'";
		//e.Status='1' and 
		if(!empty($_GET['shiftID'])){
			$sql .= " and e.shiftID='".mysql_real_escape_string($_GET['shiftID'])."' ";	
		}

		$sql = "select a.*,TIMEDIFF(a.OutTime,a.InTime) as TimeDuration, TIMEDIFF(a.WorkingHourEnd,a.WorkingHourStart) as WorkingDuration, TIMEDIFF(s.WorkingHourEnd,s.WorkingHourStart) as ShiftDuration, s.shiftName, s.LunchPaid,s.LunchTime, s.ShortBreakPaid, s.ShortBreakLimit, s.ShortBreakTime, s.OvertimePeriod,s.OvertimeHourWeek, s.PayCycle, e.EmpID as EmpID, e.EmpCode, e.UserName, e.JobTitle, e.Overtime, e.Exempt, e.JoiningDate, d.Department, sal.PayRate, sal.HourRate 
from h_employee e  
inner join h_attendence a on (e.EmpID=a.EmpID and a.attDate>='".$startDate."' and a.attDate<='".$endDate."')
left outer join  h_department d on e.Department=d.depID 
left outer join  h_shift s on e.shiftID=s.shiftID 
left outer join  h_salary sal on e.EmpID=sal.EmpID 
".$sql." order by e.UserName asc "; 
	
		return $this->query($sql, 1);
	}

   

    function RemoveReport($reportID) {

        $strSQLQuery = "delete from h_report_rule where reportID='" . $reportID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

   
    function changeReportStatus($reportID) {
        $sql = "select * from h_report_rule where reportID='" . $reportID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update h_report_rule set Status='$Status' where reportID='" . $reportID . "'";
            $this->query($sql, 0);

            return true;
        }
    }

   

    function isReportExists($reportTitle, $reportID = 0) {
        $strSQLQuery = (!empty($reportID)) ? (" and reportID != '" . $leadID."'") : ("");
        $strSQLQuery = "select leadID from h_report_rule where  LCASE(title)='" . strtolower(trim($reportTitle)) . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['reportID'])) {
            return true;
        } else {
            return false;
        }
    }

  

 
    function GetLeadWebForm($formID) {
        global $Config;
        $strSQLQuery = "select * from c_lead_form where formID='".$formID."' ";
        return $this->query($strSQLQuery, 1);
    }    
        
        
    /***********************/
    
    
    
    
    
    
    
}

?>
