<?

class activity extends dbClass {

    var $tables;

    // consturctor 
    function activity() {
        global $configTables;
        $this->tables = $configTables;
        $this->dbClass();
    }

    function addActivity($arryDetails) {
        global $Config;
        @extract($arryDetails);
        $arryAsign = explode(":", $assignedTo);
        
        
         if($Config['CronEntry']==1){ //cron entry
				$EntryType = 'one_time';
                                $AssignUser = $assignedTo;
                                $activity_type = $activityType;
                        
			}else{

                                if ($assign == 'User') {
                                    $AssignUser = $AssignToUser;
                                    $AssignType = $assign;
                                } else {
                                    $arryAsign = explode(":", $AssignToGroup);
                                    $AssignUser = $arryAsign[0];
                                    $AssignType = $assign;
                                    $GroupID = $arryAsign[1];
                                }
                       
                        }

        if ($EntryType == 'one_time') {
            $EntryDate = 0;
            $EntryFrom = '';
            $EntryTo = '';
            $EntryInterval = '';
            $EntryMonth = '';
            $EntryWeekly = '';
        }
        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
        if($EntryInterval == 'daily'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
        
        $sql = "insert into c_activity  (subject, title, created_by, created_id, description, startDate, startTime, closeDate, closeTime, status, activityType, location, priority, visibility, Notification, reminder, parent_type, parentID, assignedTo, AssignType, GroupID, RelatedType, LeadID, OpprtunityID, CampaignID, TicketID, QuoteID, add_date, CustID, EntryType,EntryFrom,EntryTo,EntryDate,EntryInterval,EntryMonth,EntryWeekly) values( '" . addslashes($subject) . "', '" . addslashes($title) . "','" . addslashes($created_by) . "','" . addslashes($created_id) . "','" . addslashes($description) . "', '" . $startDate . "','" . $startTime . "','" . $closeDate . "','" . $closeTime . "','" . $status . "','" . $activityType . "', '" . $location . "', '" . addslashes($priority) . "', '" . addslashes($visibility) . "','" . $Notification . "','" . $reminder . "','" . $parent_type . "','" . $parentID . "','" . $AssignUser . "','" . $AssignType . "','" . $GroupID . "','" . $RelatedType . "','" . $LeadID . "','" . $OpprtunityID . "', '" . $CampaignID . "', '" . $TicketID . "', '" . $QuoteID . "','" . $Config['TodayDate'] . "' , '" . $CustID . "' , '" . $EntryType . "', '" . $EntryFrom . "', '" . $EntryTo . "', '" . $EntryDate . "','" . $EntryInterval . "','" . $EntryMonth . "','".$EntryWeekly."')";
       
        $this->query($sql, 0);
        $lastInsertId = $this->lastInsertId();


        return $lastInsertId;
    }

    function updateDragActivity($arryDetails) {
        @extract($arryDetails);

        //print_r($arryDetails);

        $start = explode(' ', $start);
        $end = explode(' ', $end);

        $sql = "update c_activity set startDate = '" . $start[0] . "',
		startTime = '" . $start[1] . "',
		closeDate = '" . $end[0] . "',
		closeTime = '" . $end[1] . "'
		where activityID = " . $id;
        $rs = $this->query($sql, 0);
    }

    function updateActivity($arryDetails) {
        @extract($arryDetails);


        if ($assign == 'User') {
            $AssignUser = $AssignToUser;
            $AssignType = $assign;
        } else {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignUser = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }

        if ($EntryType == 'one_time') {
            $EntryDate = 0;
            $EntryFrom = '';
            $EntryTo = '';
            $EntryInterval = '';
            $EntryMonth = '';
        }
        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
        if($EntryInterval == 'daily'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

        $sql = "update c_activity set EntryType='" . $EntryType . "',
                   EntryInterval='" . $EntryInterval . "',  
                  EntryMonth='" . $EntryMonth . "',
                 EntryWeekly='" . $EntryWeekly . "',     
                 EntryFrom='" . $EntryFrom . "',
                 EntryTo='" . $EntryTo . "',
                 EntryDate='" . $EntryDate . "',
                subject = '" . addslashes($subject) . "', 
		title = '" . addslashes($title) . "', 
		description = '" . addslashes($description) . "',
		assignedTo  = '" . $AssignUser . "',
		AssignType  = '" . $AssignType . "',
		GroupID  = '" . $GroupID . "',
		startDate = '" . $startDate . "',
		startTime = '" . $startTime . "',
		closeDate = '" . $closeDate . "',
		closeTime = '" . $closeTime . "',
		status = '" . addslashes($event_status) . "',
		activityType = '" . addslashes($activityType) . "',
		location = '" . addslashes($location) . "',
		priority = '" . addslashes($priority) . "',
		visibility = '" . addslashes($visibility) . "',
		Notification = '" . addslashes($Notification) . "',
		RelatedType  = '" . addslashes($RelatedType) . "',

		LeadID = '" . $LeadID . "',
		OpprtunityID = '" . $OpprtunityID . "',
		CampaignID = '" . $CampaignID . "',
		TicketID = '" . $TicketID . "',
		QuoteID = '" . $QuoteID . "',
		reminder = '" . addslashes($reminder) . "',
		CustID='" . addslashes($CustID) . "'

		where activityID = " . $activityID;
        $rs = $this->query($sql, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function addActivityEmp($arryDetails) {

        extract($arryDetails);
        $sql = "delete from c_activity_emp where activityID =" . $_POST['activityID'];
        $rs = $this->query($sql, 0);
        $arryEmpID = explode(',', $EmpID);
        for ($i = 0; $i < sizeof($arryEmpID); $i++) {
            $sql = "insert into c_activity_emp( EmpID, activityID) values('" . $arryEmpID[$i] . "', '" . $_POST['activityID'] . "')";
            $rs = $this->query($sql, 0);
        }

        return 1;
    }

    function addAssignEmp($arryDetails) {

        extract($arryDetails);
        $sql = "delete from c_assign_emp where activityID ='" . $_POST['activityID'] . "'";
        $rs = $this->query($sql, 0);
        $arryEmpID = explode(',', $assignedTo);
        for ($i = 0; $i < sizeof($arryEmpID); $i++) {
            $sql = "insert into c_assign_emp( EmpID, activityID) values('" . $arryEmpID[$i] . "', '" . $_POST['activityID'] . "')";
            $rs = $this->query($sql, 0);
        }

        return 1;
    }

    function getActivityEmp($id = 0) {
        $sql = " where 1";
        $sql .= (!empty($id)) ? (" and activityID = '" . $id . "'") : ("");
        $sql = "select EmpID from c_activity_emp " . $sql . " order by EmpID Asc";
        return $this->query($sql, 1);
    }

    function getActivityEmp2($id = 0) {
        $sql = " where 1";
        $sql .= (!empty($id)) ? (" and e.activityID = '" . $id . "'") : ("");
        $sql = "select e.*,em.UserName,em.Email,d.Department ,em.JobTitle,em.Image  from c_activity_emp e inner join h_employee em on e.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID" . $sql . " order by e.activityID Asc";
        return $this->query($sql, 1);
    }

    function getAssignEmp($id = 0) {
        $sql = " where 1";
        $sql .= (!empty($id)) ? (" and e.activityID = " . $id) : ("");
        $sql = "select e.*,em.UserName,em.Email,d.Department ,em.JobTitle,em.Image  from c_assign_emp e inner join h_employee em on e.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID" . $sql . " order by e.activityID Asc";
        return $this->query($sql, 1);
    }

    function GetActivity($activityID, $Limit) {
        $sql = " where 1 ";
        $sql .= (!empty($activityID)) ? (" and activityID = '" . $activityID . "'") : ("");

        $sql = "select * from c_activity   " . $sql;



        return $this->query($sql, 1);
    }

    function getUpActivity($Limit) {
        $sql = " where  e.startDate>=now() ";

        $sql = "select e.*, from c_activity e  " . $sql . " order by e.startDate asc";

        $sql .= (!empty($Limit)) ? (" limit 0," . $Limit) : ("");

        return $this->query($sql, 1);
    }

    function changeActivityStatus($activityID) {
        $sql = "select * from c_activity where activityID=" . $activityID;
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update c_activity set Status='$Status' where activityID=" . $activityID;
            $this->query($sql, 0);
        }
        if ($Status == 1 && $rs[0]['Status'] != 1) {
            $this->ActivityActiveEmail($activityID);
        }
        return true;
    }

    function deleteActivity($activityID) {


        $sql = "delete from c_activity where activityID = " . $activityID;
        $rs = $this->query($sql, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function SendEmailToAdmin($activityID) {
        global $Config;

        $arryActivity = $this->GetActivity($activityID, '');
        if ($arryActivity[0]['created_by'] = 'Admin') {
            $CreateBy = "Administrator";
        } else {
            $CreateBy = "User";
        }



        //$ActivityTitle = GetActivityTitle($arryActivity[0]);
        $contents = file_get_contents($Config['EmailTemplateFolder'] . "newevent.htm");
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[SUBJECT]", $arryActivity[0]['subject'], $contents);
        $contents = str_replace("[STARTDATE]", $arryActivity[0]['startDate'], $contents);
        $contents = str_replace("[STARTTIME]", $arryActivity[0]['startTime'], $contents);
        $contents = str_replace("[CLOSEDATE]", $arryActivity[0]['closeDate'], $contents);
        $contents = str_replace("[CLOSETIME]", $arryActivity[0]['closeTime'], $contents);
        $contents = str_replace("[startDate]", $arryActivity[0]['startDate'], $contents);
        $contents = str_replace("[STATUS]", $arryActivity[0]['status'], $contents);
        $contents = str_replace("[ACTTYPE]", $arryActivity[0]['activityType'], $contents);
        $contents = str_replace("[PRIORITY]", $arryActivity[0]['priority'], $contents);
        $contents = str_replace("[CREATED]", $CreateBy, $contents);
//$contents = str_replace("[ADDDATE]",$arryActivity[0]['add_date'],$contents);
        //$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editActivity.php?edit='.$activityID."&cat=".$arryActivity[0]['cat_id'], $contents);

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($Config['AdminEmail']);
        $mail->sender($arryActivity[0]['ContributorName'], $arryActivity[0]['ContributorEmail']);
        $mail->Subject = $Config['SiteName'] . " - New event has been posted ";
        $mail->IsHTML(true);

        //echo $Config['AdminEmail'].$arryActivity[0]['ContributorEmail'].$contents; exit;

        $mail->Body = $contents;
        if ($Config['DbUser'] != 'root') {
            $mail->Send();
        }

        return 1;
    }

    function ActivityActiveEmail($activityID) {
        global $Config;

        $arryActivity = $this->getActivity($activityID, '', '', '', '');
        $contents = file_get_contents("../" . $Config['EmailTemplateFolder'] . "activenewevent.htm");
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[FULLNAME]", $arryActivity[0]['ContributorName'], $contents);
        $contents = str_replace("[Email]", $arryActivity[0]['ContributorEmail'], $contents);
        $contents = str_replace("[activityID]", $arryActivity[0]['activityID'], $contents);
        $contents = str_replace("[ActivityTitle]", $arryActivity[0]['heading'], $contents);
        $contents = str_replace("[type]", $arryActivity[0]['type'], $contents);
        $contents = str_replace("[startDate]", $arryActivity[0]['startDate'], $contents);
        $contents = str_replace("[endDate]", $arryActivity[0]['endDate'], $contents);
        $contents = str_replace("[EVENT_URL]", $Config['Url'] . 'events.html?eId=' . $activityID, $contents);



        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($arryActivity[0]['ContributorEmail']);
        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " - Your event has been approved ";
        $mail->IsHTML(true);

        //echo $Config['AdminEmail'].$arryActivity[0]['Email'].$contents; exit;

        $mail->Body = $contents;
        if ($Config['DbUser'] != 'root') {
            $mail->Send();
        }


        return 1;
    }

    function ListActivity($id = 0, $parent_type, $parentID, $SearchKey, $SortBy, $AscDesc) {
        global $Config;
        $strAddQuery = ' where 1 ';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" and e.activityID=" . $id) : ("");
        //$strAddQuery .= (!empty($cat_id))?(" and cat_id=".$cat_id):("");
        $strAddQuery .= (!empty($parent_type)) ? (" and e.parent_type='" . $parent_type . "' ") : ("");
        $strAddQuery .= (!empty($parentID)) ? (" and e.parentID=" . $parentID) : ("");


        if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " = '" . $SearchKey . "')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (e.subject like '%" . $SearchKey . "%'  or e.activityID like '%" . $SearchKey . "%'     or e.activityType like '%" . $SearchKey . "%'  or e.status like '%" . $SearchKey . "%' or e.startDate like '%" . $SearchKey . "%' or e.closeDate like '%" . $SearchKey . "%')") : ("");
        }


#$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (e.assignedTo like '%".$_SESSION['AdminID']."%' OR e.created_id='".$_SESSION['AdminID']."') "):("");


        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",e.assignedTo) OR e.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : ("  order by e.startDate ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc ");

        $strSQLQuery = "select e.*,u.Role,u.UserName as created from c_activity  e  left outer join  h_employee u on u.EmpID=e.created_id" . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function GetActivityList($arryDetails) {
        global $Config;
        $arryTime = explode(" ", $Config['TodayDate']);

        extract($arryDetails);

        $strAddQuery = ' where 1 ';
        $SearchKey = strtolower(trim($key));
        $strAddQuery .= (!empty($id)) ? (" and e.activityID=" . $id) : ("");
        //$strAddQuery .= (!empty($cat_id))?(" and cat_id=".$cat_id):("");
        $strAddQuery .= (!empty($parent_type)) ? (" and e.parent_type='" . $parent_type . "' ") : ("");
        $strAddQuery .= (!empty($parentID)) ? (" and e.parentID=" . $parentID) : ("");
	$strAddQuery .= (!empty($FromDate))?(" and e.StartDate>='".$FromDate."'"):("");
	$strAddQuery .= (!empty($ToDate))?(" and e.StartDate<='".$ToDate."'"):("");


	if($tab=='todays'){
		$strAddQuery .= " and e.StartDate='".$arryTime[0]."'";
		$sortby = ' e.startDate desc, e.startTime asc';
           	$asc = '';
	}else if($tab=='upcoming'){
		$strAddQuery .= " and e.StartDate>'".$arryTime[0]."'";
		$sortby = ' e.startDate,e.startTime, e.closeDate';
           	$asc = 'asc';
	}




        if ($sortby != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " = '" . $SearchKey . "')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (e.subject like '%" . $SearchKey . "%'  or e.activityID like '%" . $SearchKey . "%'    or e.activityType like '%" . $SearchKey . "%'  or e.status like '%" . $SearchKey . "%' or e.priority like '%" . $SearchKey . "%' or e.status like '%" . $SearchKey . "%')") : ("");
        }


        #$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (e.assignedTo like '%".$_SESSION['AdminID']."%' OR e.created_id='".$_SESSION['AdminID']."') "):("");

        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",e.assignedTo) OR e.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        if ($st == 1) {
            $TodayDate = $Config['TodayDate'];
            $arryTime = explode(" ", $TodayDate);
            $TodayDate = $arryTime[0];

            $strAddQuery .= " and e.closeDate>='" . $TodayDate . "' ";

            $sortby = ' e.startDate,e.startTime, e.closeDate';
            $asc = 'asc';
        }

        $strAddQuery .= (!empty($CustID)) ? (" and e.CustID='" . $CustID . "'") : ("");
        $strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ".$asc) : ("  order by e.startDate desc, e.startTime desc,e.activityID desc ");

        $strSQLQuery = "select e.*,u.Role,u.UserName as created from c_activity  e  left outer join  h_employee u on u.EmpID=e.created_id" . $strAddQuery;

       //echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    function UpdateImage($imageName, $activityID) {
        $strSQLQuery = "update c_activity set Image='" . $imageName . "' where activityID=" . $activityID;
        return $this->query($strSQLQuery, 0);
    }

    function UpdatePdf($Pdf, $activityID) {
        $strSQLQuery = "update c_activity set Pdf='" . $Pdf . "' where activityID=" . $activityID;
        return $this->query($strSQLQuery, 0);
    }

    function isEventExists($subject, $activityID, $Type) {

        $strSQLQuery = "select * from c_activity where LCASE(subject)='" . strtolower(trim($subject)) . "'";

        $strSQLQuery .= (!empty($activityID)) ? (" and activityID != " . $activityID) : ("");
        $strSQLQuery .= (!empty($cat_id)) ? (" and activityType = " . $Type) : ("");

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['activityID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isEventDateExists($startDate, $closeDate, $closeTime, $startTime, $activityID, $Type) {

        $strSQLQuery = "select * from c_activity where startDate <= '" . $startDate . "'";
        $strSQLQuery .= (!empty($closeDate)) ? (" and closeDate <= '" . $closeDate . "'") : ("");
        //$strSQLQuery .= (!empty($closeTime))?(" and closeTime = '".$closeTime."'"):("");
        //$strSQLQuery .= (!empty($startTime))?(" and startTime = '".$startTime."'"):("");

        $strSQLQuery .= (!empty($activityID)) ? (" and activityID != " . $activityID) : ("");
        $strSQLQuery .= (!empty($Type)) ? (" and activityType = '" . $Type . "'") : ("");

        //echo $strSQLQuery;

        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['activityID'])) {
            return true;
        } else {
            return false;
        }
    }

    function GetAssignee($arrayDetail) {
        $strSQLQuery = "select EmpID,UserName,Email from h_employee where EmpID in (" . $arrayDetail . ")";
        return $this->query($strSQLQuery, 1);
    }

    function GetNumActivityYear($Type, $startDate, $closeDate) {

        $strSQLQuery = "select count(activityID) as TotalActivity from c_activity where 1 ";
        $strSQLQuery .= (!empty($Type)) ? (" and activityType = '" . $Type . "'") : ("");
        $strSQLQuery .= (!empty($startDate)) ? (" and startDate <= '" . $startDate . "'") : ("");
        $strSQLQuery .= (!empty($closeDate)) ? (" and closeDate <= '" . $closeDate . "'") : ("");
        $strSQLQuery .= " order by startDate desc";

        /* if(!empty($Year)){
          $DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
          $strSQLQuery .= " and JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR ExitDate>'".$DateEnd."')";
          //$strSQLQuery .= " and JoiningDate<='".$DateEnd."' ";
          } */
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetActivityDeshboard($Type) {
        global $Config;

        $arryTime = explode(" ", $Config['TodayDate']);

        $strSQLQuery = "select subject,activityID,activityType,startDate,closeDate,closeTime,startTime from c_activity where status not in ('Held','Not Held') ";


        #$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (assignedTo like '%".$_SESSION['AdminID']."%'   OR   created_id='".$_SESSION['AdminID']."') "):("");

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",assignedTo) OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");



        $strSQLQuery .= (!empty($Type)) ? (" and activityType = '" . $Type . "'") : ("");

        $strSQLQuery .= " and startDate =  '" . $arryTime[0] . "'  ";
        $strSQLQuery .= " and startTime >  '" . $arryTime[1] . "'  ";
        $strSQLQuery .= " order by startDate asc limit 0,20";

        return $this->query($strSQLQuery, 1);
    }

    function CountActivity($Type) {
        global $Config;
        $arryTime = explode(" ", $Config['TodayDate']);

        $strSQLQuery = "select COUNT(activityID) as totalAct from c_activity where status not in ('Held','Not Held') ";

        #$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (assignedTo like '%".$_SESSION['AdminID']."%'   OR   created_id='".$_SESSION['AdminID']."') "):("");

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",assignedTo) OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");


        $strSQLQuery .= (!empty($Type)) ? (" and activityType = '" . $Type . "'") : ("");

        $strSQLQuery .= " and startDate =  '" . $arryTime[0] . "'  ";
        $strSQLQuery .= " and startTime >  '" . $arryTime[1] . "'  ";
        $strSQLQuery .= " order by startDate asc limit 0,20";

        $arryRow = $this->query($strSQLQuery, 1);

        if ($arryRow[0]['totalAct'] > 0) {
            return $arryRow[0]['totalAct'];
        } else {
            return 0;
        }
    }

    function CustomActivity($selectCol, $condition) {
        global $Config;
        $strSQLQuery = "select * from c_activity where 1 " . $condition . "";
        #$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (AssignedTo like '%".$_SESSION['AdminID']."%' OR created_id='".$_SESSION['AdminID']."') "):("");
        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",assignedTo) OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");

	$strSQLQuery .= "  order by startDate desc, startTime desc";
       
        return $this->query($strSQLQuery, 1);
    }
    
    /****************Recurring Function Satrt************************************/  
       function RecurringActivity(){       
          global $Config;
	  $Config['CronEntry']=1;
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);

	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));

	  $strSQLQuery = "select c.* from c_activity c where c.EntryType ='recurring' and c.EntryFrom<='".$arryDate[0]."' and c.EntryTo>='".$arryDate[0]."' ";
          $arryActivity = $this->myquery($strSQLQuery, 1);
                  
          //echo "=>".$strSQLQuery;exit;
          /*echo "<pre>";
          print_r($arryActivity);
          exit;*/
	
	  foreach($arryActivity as $value){
		$OrderFlag=0;
               
		switch($value['EntryInterval']){
                    
                        case 'daily':
                            $OrderFlag=1;
                            break;
                       case 'weekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>5)){
					$OrderFlag=1;
				}
				break;
                    
			case 'biweekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($value['EntryDate']==$Day){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month){
					$OrderFlag=1;
				}
				break;		
		
		}
		

		if($OrderFlag==1){
			//echo $value['activityID'].'<br>';
                        
                       
			$NumLine = 0;
                        
                        if($value['activityID'] > 0){
                           $arryInviteEmployee = $this->getActivityEmp($value['activityID']);
                        }
                        
                        
			$NumLine = sizeof($arryInviteEmployee);
                        
                        
                        
			if($value['activityID'] > 0){		
                            
                           
				$activityID = $this->AddActivity($value);
                                $this->AddRecurringInviteEmployee($activityID,$arryInviteEmployee);
                                
				$strSQL = "update c_activity set LastRecurringEntry ='" . $Config['TodayDate'] . "' where activityID='" . $value['activityID'] . "'";
				$this->myquery($strSQL, 0);
		
			}


		}


	  }
       	  return true;
   }
   
   function AddRecurringInviteEmployee($activityID, $arryDetails){
		global $Config;
		extract($arryDetails);

                        
		 foreach($arryDetails as $values){

			if(!empty($values['EmpID'])) {			          

			        $sql = "insert into c_activity_emp( EmpID, activityID) values('" .$values['EmpID']. "', '" .$activityID. "')";
				$this->query($sql, 0);	

			}
		}

                        
		return true;

	}
        


     function NextPrevActivity555($activityID,$startDate,$startTime,$Next) {
		global $Config;
		if($activityID>0){			
			 $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",e.assignedTo) OR e.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
	
			if($Next==1){
				$operator = "<="; $asc = 'desc';
			}else{
				$operator = ">=";  $asc = 'asc';
			}

			$Second = $activityID; //substr($activityID,-2,2);
			$startTime = strtotime($startTime) + $Second;
			$startTimeNew = date('h:i:s', $startTime);

			$startDateTime = $startDate.' '.$startTimeNew;
			$strSQLQuery = "select e.activityID, ADDTIME(CONCAT(CONCAT(e.startDate,' '),e.startTime), e.activityID) as MainTime from c_activity e where e.activityID!='".$activityID."'  ". $strAddQuery. " having MainTime ".$operator." '" . $startDateTime . "' order by e.startDate ".$asc.",e.startTime ".$asc.",e.activityID ".$asc."  limit 0,1";
			echo $strSQLQuery;

			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow[0]['activityID'];
		}
	}  

       function NextPrevActivity($activityID,$startDate,$startTime,$Next) {
		global $Config;
		if($activityID>0){			
			 $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",e.assignedTo) OR e.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
	
			if($Next==1){
				$operator = "<="; $asc = 'desc';
			}else{
				$operator = ">=";  $asc = 'asc';
			}
			
			$startDateTime = $startDate.' '.$startTime;
			$strSQLQuery = "select e.activityID, CONCAT(CONCAT(e.startDate,' '),e.startTime) as MainTime from c_activity e where e.activityID!='".$activityID."'  ". $strAddQuery. " having 

(CASE WHEN MainTime  = '".$startDateTime."' 
        THEN e.activityID ".$operator." '".$activityID."'  
        ELSE MainTime ".$operator." '" . $startDateTime . "' END 

) order by e.startDate ".$asc.",e.startTime ".$asc.",e.activityID ".$asc."  limit 0,1";
			//echo $strSQLQuery;

			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow[0]['activityID'];
		}
	}            


}

?>
