<?php

class lead extends dbClass {

    //constructor
    function lead() {
        $this->dbClass();
    }

    function ListLead($id = 0, $SearchKey, $SortBy, $AscDesc,$FromDate, $ToDate) {
        global $Config;
		$arryTime = explode(" ", $Config['TodayDate']);
        $strAddQuery = 'where 1';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" and l.leadID='" . $id . "'") : (" and l.Opportunity='0' ");

				 //added by sanjiv 8 jan
        $FolderID = (isset($_GET['FolderId']) && $_GET['FolderId']) ? (int) $_GET['FolderId'] : '';
		$strAddQuery .= ( !empty( $FolderID )) ? " and l.FolderID='" . $FolderID . "'" : " and l.FolderID='0'";

        #$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (l.AssignTo='" . $_SESSION['AdminID'] . "' OR l.created_id='" . $_SESSION['AdminID'] . "')") : ("");

	$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",l.AssignTo) OR l.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

// code by ali vstacks //         
$strAddQuery .= (!empty($FromDate) && !empty($ToDate) )?(" and ( l.LeadDate between'".$FromDate."'  and '".$ToDate."')"):("");
//  ali end //
 
	$strAddQuery .= (!empty($Config['Junk'])) ? (" and l.Junk='".$Config['Junk']."' ") : ("");

	$strAddQuery .= (!empty($Config['flag'])) ? (" and l.FlagType ='Yes' ") : ("");


if(!empty($Config['tab']) && $Config['tab']=='todays'){
		$strAddQuery .= " and l.UpdatedDate='".$arryTime[0]."'";

	}

$strAddQuery .= (!empty($Config['rule'])) ? ("   " . $Config['rule'] . "") : ("");  //add Rajan 23 dec
$strAddQuery .= (!empty($Config['rows'])) ? ("  and RowColor = '#" . $Config['rows'] . "' ") : ("");  //add chetan 25Dec
        if ($SortBy == 'e.UserName') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (e.UserName like '%" . $SearchKey . "%')") : ("");
        } else if ($SortBy == 'l.leadID') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (l.leadID = '" . $SearchKey . "')") : ("");
        } else if ($SortBy == 'l.FirstName') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (l.FirstName like '%" . $SearchKey . "%' or l.LastName like '%" . $SearchKey . "%' )") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                #$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' or l.primary_email like '%".$SearchKey."%' or l.leadID like '%".$SearchKey."%' or l.lead_status like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or l.company like '%".$SearchKey."%'  ) "  ):(""); 
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( l.LeadName like '%" . $SearchKey . "%' or  l.FirstName like '%" . $SearchKey . "%' or l.LastName like '%" . $SearchKey . "%' or l.primary_email like '%" . $SearchKey . "%' or l.leadID like '%" . $SearchKey . "%' or l.lead_status like '%" . $SearchKey . "%' or l.company like '%" . $SearchKey . "%'  or l.LandlineNumber like '%" . $SearchKey . "%'  or e.UserName like '%" . $SearchKey . "%' or l.type like '%" . $SearchKey . "%'   ) " ) : ("");
            }
        }
       
    
if($Config['GetNumRecords']==1){
				$Columns = " count(l.leadID) as NumCount ";				
			}else{			

			 $strAddQuery .= " group by l.leadID";
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by l.leadID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : ("desc");	
				$Columns = "  l.*,DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."') as AnnualRevenue, d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
 $strSQLQuery = "select ".$Columns." from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery; 

#echo  $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    function ListSearchLead($id = 0, $SearchKey, $SortBy, $AscDesc) {
        
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where l.leadID='" . $id . "'") : (" where 1 ");
        $strAddQuery .= ($_SESSION['AdminType'] != "admin") ? (" and l.AssignTo='" . $_SESSION['AdminID'] . "' ") : ("");
        $strAddQuery .= (!empty($SearchKey)) ? (" and ( l.FirstName like '%" . $SearchKey . "%' ) " ) : ("");

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by l.leadID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");

        $strSQLQuery = "select l.leadID,l.primary_email,l.FirstName,l.LastName,l.AssignTo,l.lead_status,l.description,l.company,d.Department,e.Role,e.UserName as AssignTo from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  h_department d on e.Department=d.depID " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

     function ConvertLead($leadID, $Opportunity, $OpportunityID) {
       	$arryLead = $this->GetLead($leadID,'');

        $strSQLQuery = "update c_lead set Opportunity='" . $Opportunity . "' where leadID='" . $leadID . "'";
        $this->query($strSQLQuery, 0);

	$strSQLQ = "update c_opportunity set AssignTo='" . $arryLead[0]['AssignTo'] . "',AssignType='" . $arryLead[0]['AssignType'] . "',GroupID='" . $arryLead[0]['GroupID'] . "',Currency='" . $arryLead[0]['Currency'] . "',created_id='" . $arryLead[0]['created_id'] . "',created_by='" . $arryLead[0]['created_by'] . "' where OpportunityID='" . $OpportunityID . "'";
        $this->query($strSQLQ, 0);



        $strSQL = "update c_comments set parent_type='Opportunity',parentID='" . $OpportunityID . "' where parentID='" . $leadID . "' and parent_type='lead'";
        $this->query($strSQL, 0);
        
    }

    function GetDashboardLead($limit=6) {
        global $Config;
        $strSQLQuery = "select l.leadID,l.FirstName,l.LastName,l.company,l.AssignTo,l.type,l.Opportunity,l.LeadDate,l.view_status  from c_lead l where 1  ";
        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (l.AssignTo = '" . $_SESSION['AdminID'] . "' OR l.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
        //$strAddQuery .= ($Opportunity!=1)?(" and l.Opportunity='".$Opportunity."' "):("");
        $strSQLQuery .= "  and l.Opportunity='0' order by l.view_status ASC limit 0,".$limit;
        //echo $strSQLQuery;
        return $this->query($strSQLQuery, 1);
        
    }

	function GetWorkspaceLead($leadType) {
		$arryDate = explode(" ",$_SESSION['TodayDate']);

		$strSQLQuery = "select l.leadID,l.FirstName,l.LastName,l.company,l.AssignTo,l.type,l.Opportunity from c_lead l where l.Opportunity='0'   ";
		$strSQLQuery .= ($_SESSION['vAllRecord'] != 1) ? (" and (l.AssignTo = '" . $_SESSION['AdminID'] . "' OR l.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

		switch($leadType){
		   case 'Top':  			
			break;
		   case 'Daily':  	
			$strSQLQuery .= " and LeadDate='".$arryDate[0]."' ";		
			break;
		   case 'Weekly':  	
			$strSQLQuery .= " and WEEKOFYEAR(LeadDate)=WEEKOFYEAR('".$arryDate[0]."') ";		
			break;
		   case 'Monthly':  	
			$strSQLQuery .= " and month(LeadDate)=month('".$arryDate[0]."') ";		
			break;
		  case 'Yearly':  	
			$strSQLQuery .= " and year(LeadDate)=year('".$arryDate[0]."') ";		
			break;
		}

		$strSQLQuery .= " order by l.LeadDate desc limit 0, 50";
		//echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}


function GetWorkspaceOpp($oppType,$SalesStage) {
		global $Config;
		$arryDate = explode(" ",$_SESSION['TodayDate']);

		 $strSQLQuery = "select o.OpportunityID,o.LeadID,o.Status,o.OpportunityName,o.lead_source, DECODE(o.Amount,'". $Config['EncryptKey']."') as AmountVal,DECODE(o.forecast_amount,'". $Config['EncryptKey']."') as forecast_amount from c_opportunity o where o.Status='1' and SalesStage like '".$SalesStage."%' ";

		 $strSQLQuery .= ($_SESSION['vAllRecord'] != 1) ? (" and (o.AssignTo='" . $_SESSION['AdminID'] . "' OR o.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

		switch($oppType){
		   case 'Top':  			
			break;
		   case 'Daily':  	
			$strSQLQuery .= " and DATE_FORMAT(AddedDate, '%Y-%m-%d')='".$arryDate[0]."' ";		
			break;
		   case 'Weekly':  	
			$strSQLQuery .= " and WEEKOFYEAR(DATE_FORMAT(AddedDate, '%Y-%m-%d'))=WEEKOFYEAR('".$arryDate[0]."') ";		
			break;
		   case 'Monthly':  	
			$strSQLQuery .= " and month(DATE_FORMAT(AddedDate, '%Y-%m-%d'))=month('".$arryDate[0]."') ";		
			break;
		  case 'Yearly':  	
			$strSQLQuery .= " and year(DATE_FORMAT(AddedDate, '%Y-%m-%d'))=year('".$arryDate[0]."') ";		
			break;
		}

		$strSQLQuery .= " having AmountVal>'0' order by AmountVal desc limit 0,50";
		//echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}


function GetWorkspaceTicket($ticketType) {
		$arryDate = explode(" ",$_SESSION['TodayDate']);

		 $strSQLQuery = "select t.title,t.AssignedTo,t.TicketID,t.AssignType,t.created_id from c_ticket t 
                         where 1 and t.Status in ('Open','In progress')  ";
		
		$strSQLQuery .= ($_SESSION['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",t.AssignedTo) OR t.created_id='" . $_SESSION['AdminID'] . "') ") : ("");


		switch($ticketType){
		   case 'Top':  			
			break;
		   case 'Daily':  	
			$strSQLQuery .= " and DATE_FORMAT(ticketDate, '%Y-%m-%d')='".$arryDate[0]."' ";		
			break;
		   case 'Weekly':  	
			$strSQLQuery .= " and WEEKOFYEAR(DATE_FORMAT(ticketDate, '%Y-%m-%d'))=WEEKOFYEAR('".$arryDate[0]."') ";		
			break;
		   case 'Monthly':  	
			$strSQLQuery .= " and month(DATE_FORMAT(ticketDate, '%Y-%m-%d'))=month('".$arryDate[0]."') ";		
			break;
		  case 'Yearly':  	
			$strSQLQuery .= " and year(DATE_FORMAT(ticketDate, '%Y-%m-%d'))=year('".$arryDate[0]."') ";		
			break;
		}

		$strSQLQuery .= " order by t.TicketID desc limit 0, 50";
		//echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}


function GetWorkspaceCampaign($campType) {
		$arryDate = explode(" ",$_SESSION['TodayDate']);

		$strSQLQuery = "select c.campaignname,c.assignedTo,c.campaignID,c.created_id from c_campaign c where 1 and c.campaignstatus in ('Active','Planning') ";

		$strSQLQuery .= ($_SESSION['vAllRecord'] != 1) ? (" and (c.assignedTo = '" . $_SESSION['AdminID'] . "' OR c.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
	

		switch($campType){
		   case 'Top':  			
			break;
		   case 'Daily':  	
			$strSQLQuery .= " and DATE_FORMAT(created_time, '%Y-%m-%d')='".$arryDate[0]."' ";		
			break;
		   case 'Weekly':  	
			$strSQLQuery .= " and WEEKOFYEAR(DATE_FORMAT(created_time, '%Y-%m-%d'))=WEEKOFYEAR('".$arryDate[0]."') ";		
			break;
		   case 'Monthly':  	
			$strSQLQuery .= " and month(DATE_FORMAT(created_time, '%Y-%m-%d'))=month('".$arryDate[0]."') ";		
			break;
		  case 'Yearly':  	
			$strSQLQuery .= " and year(DATE_FORMAT(created_time, '%Y-%m-%d'))=year('".$arryDate[0]."') ";		
			break;
		}

		$strSQLQuery .= " order by c.campaignID desc limit 0, 50";
		//echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}



    function GetLead($leadID, $Opportunity) {
        
        global $Config;
        //$strSQLQuery = "select * from c_lead  ";
        $strSQLQuery = "select l.*, DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."') as AnnualRevenue from c_lead l  ";
        $strSQLQuery .= (!empty($leadID)) ? (" where l.leadID='" . $leadID . "'") : (" where 1 ");
        $strSQLQuery .= ($Opportunity > 0) ? (" and l.Opportunity='" . $Opportunity . "'") : ("");
        return $this->query($strSQLQuery, 1);
        
    }

    function GetLeadBrief($leadID, $Opportunity='') {
        
        $strSQLQuery = "select leadID, FirstName, LastName, LeadName  from c_lead  ";
        $strSQLQuery .= (!empty($leadID)) ? (" where leadID='" . $leadID . "'") : (" where 1 ");
        $strSQLQuery .= ($Opportunity != '') ? (" and Opportunity='" . $Opportunity . "'") : ("");
        $strSQLQuery .= " order by FirstName asc ";
        return $this->query($strSQLQuery, 1);
        
    }

    function GetLeadsForprimary_email($leadID) {
        
        $strSQLQuery = "select leadID,primary_email from c_lead where 1";
        $strSQLQuery .= (!empty($leadID)) ? (" and leadID!='" . $leadID . "'") : ("");
        return $this->query($strSQLQuery, 1);
        
    }

    function AllLeads($Opportunity) {
        
        $strSQLQuery = "select leadID,primary_email from c_lead where 1 ";
        $strSQLQuery .= ($Opportunity > 0) ? (" and Opportunity='" . $Opportunity . "'") : ("");
        $strSQLQuery .= ($_SESSION['AdminType'] != "admin") ? (" and l.AssignTo='" . $_SESSION['AdminID'] . "' ") : ("");
        $strSQLQuery .= " order by primary_email Asc";

        return $this->query($strSQLQuery, 1);
    }

    function GetLeadDetail($id = 0) {
        $strAddQuery = '';
        $strAddQuery .= (!empty($id)) ? (" where l.leadID='" . $id . "'") : (" where 1 ");
        $strAddQuery .= ($_SESSION['AdminType'] != "admin") ? (" and l.AssignTo='" . $_SESSION['AdminID'] . "' ") : ("");

        $strAddQuery .= "and l.Opportunity='0' order by l.JoiningDate Desc ";

        $strSQLQuery = "select l.*, e.Role,e.UserName from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  h_department d on e.Department=d.depID  " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function AddLead($arryDetails,$CmpID=0) { 
        $objConfigure = new configure();
        global $Config;
	
	$AssignTo=$AssignType=$GroupID=$AnnualRevenue=$city_id=$state_id='';

        extract($arryDetails);

        if ($main_state_id > 0)
            $OtherState = '';
        if ($main_city_id > 0)
            $OtherCity = '';
        //if(empty($Status)) $Status=1;
        $LeadName = trim($FirstName . ' ' . $LastName);


        $ipaddress = GetIPAddress();
        $JoiningDatl = $Config['TodayDate'];
 
         if (!empty($assign) && $assign == 'Users') { //By Chetan//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else if (!empty($AssignToGroup)) {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }
          
    
	if(!empty($AssignTo)  && !empty($AssignType)){
	      //echo 'ok';
	}else if(!empty($TerritoryAssign)){
		if($AssignTo>0)$AssignToTerri = $AssignTo.",";
		foreach($TerritoryAssign as $key => $values) {
			$AssignToTerri .= $values['AssignTo'].",";
		}
		$AssignTo = rtrim($AssignToTerri, ",");
		
	}else if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
            $AssignType = 'User';
        }

 //By Chetan//
	/**************/
        if(empty($LeadDate)){$LeadDate=$Config['TodayDate']; }else{ $LeadDate = $LeadDate;}
	/**************/
	//if(empty($LeadDate))$LeadDate=$Config['TodayDate'];

	if(empty($type)){
		 $type = (!empty($company)) ? ("Company") : ("Individual");
	}else{
            $type = $type ;
        }

	 

      /* $strSQLQuery = "insert into c_lead (LeadName,type,ProductID,product_price, primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,lead_status,lead_source, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AssignType,GroupID,AnnualRevenue,designation,description,Industry,LeadDate , created_by, created_id,NumEmployee,LastContactDate,Currency,Rating) values('" . addslashes($LeadName) . "','" . addslashes($type) . "','" . addslashes($ProductID) . "', '" . addslashes($product_price) . "','" . addslashes($primary_email) . "', '" . addslashes($company) . "','" . addslashes($Website) . "','" . addslashes($FirstName) . "', '" . addslashes($LastName) . "', '" . addslashes($Address) . "',  '" . $main_city_id . "', '" . $main_state_id . "','" . addslashes($ZipCode) . "', '" . $country_id . "', '" . addslashes($Mobile) . "','" . addslashes($LandlineNumber) . "','" . addslashes($lead_status) . "','" . addslashes($lead_source) . "',  '" . $JoiningDatl . "',  '" . addslashes($OtherState) . "', '" . addslashes($OtherCity) . "','" . $ipaddress . "',  '" . $Config['TodayDate'] . "','" . addslashes($AssignTo) . "','" . addslashes($AssignType) . "','" . addslashes($GroupID) . "',ENCODE('" .addslashes($AnnualRevenue) . "','".$Config['EncryptKey']."'),'" . addslashes($designation) . "','" . addslashes($description) . "','" . addslashes($Industry) . "','" . addslashes($LeadDate) . "', '" . addslashes($_SESSION['AdminType']) . "', '" . addslashes($_SESSION['AdminID']) . "' ,'" . addslashes($NumEmployee) . "' ,'" . addslashes($LastContactDate) . "','" . addslashes($Currency) . "','" . addslashes($Rating) . "')";*/

        //$this->query($strSQLQuery, 0);
	unset($arryDetails['LeadDate']);
	unset($arryDetails['captcha']);
	unset($arryDetails['type']);
	unset($arryDetails['LeadSubmit']);
	unset($arryDetails['Cmp']);
 
	unset($arryDetails['AnnualRevenue']);
	unset($arryDetails['assign']);
	unset($arryDetails['AssignToGroup']);
	unset($arryDetails['AssignToUser']);
	unset($arryDetails['Submit']);
	unset($arryDetails['LeadID']);
	unset($arryDetails['main_state_id']);
	unset($arryDetails['main_city_id']);
	unset($arryDetails['ajax_state_id']);
	unset($arryDetails['ajax_city_id']);
	unset($arryDetails['state_id']);
	unset($arryDetails['city_id']);
                 
      	$fields = join(',',array_keys($arryDetails));
	$values = join("','",array_values(array_map(function($arr){ return addslashes($arr);},$arryDetails))); //updated for addslashes on 22Sep2017 by chetan//
      
       
       $strSQLQuery = "insert into c_lead 
                        (LeadName,LeadDate, type, JoiningDate,  ipaddress, UpdatedDate,AssignTo,AssignType,GroupID,AnnualRevenue,city_id,state_id,$fields)
                        values('" . addslashes($LeadName) . "',
                                '" . addslashes($LeadDate) . "',
                                '" . addslashes($type) ."',
                                '" . $JoiningDatl . "',
                                '" . $ipaddress . "',
                                '" . $Config['TodayDate'] . "',
                                '" . addslashes($AssignTo) . "',
                                '" . addslashes($AssignType) . "',
                                '" . addslashes($GroupID) ."', 
                                     ENCODE('".addslashes($AnnualRevenue)."' ,'".$Config['EncryptKey']."'),
                                 '".$city_id."',
                                '".$state_id."' ,'".$values."')" ;
       
 

        $this->query($strSQLQuery, 0);

        //End// 





        $LeadID = $this->lastInsertId();


        $htmlPrefix = $Config['EmailTemplateFolder'];
        if($AssignTo != '') {
            $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignTo . ")";
            //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
            $arryEmp = $this->query($strSQLQuery, 1);
            foreach ($arryEmp as $email) {
                $ToEmail .= $email['Email'] . ",";
                $AssignUserName .= $email['UserName'] . ",";
            }
            $assignEmail = rtrim($ToEmail, ",");
            $AssignUserName = rtrim($AssignUserName, ",");
       

            $ToEmail = $arryEmp[0]['Email'];
            $CC = $Config['AdminEmail'];

            $assignEmail = $arryEmp[0]['Email'];



            $TemplateContent = $objConfigure->GetTemplateContent(1, 1);
            $contents = $TemplateContent[0]['Content'];
            //$contents = file_get_contents($htmlPrefix . "LeadAssigned.htm");
            $subject = $TemplateContent[0]['subject'];
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[FIRSTNAME]", $FirstName, $contents);
            $contents = str_replace("[LASTNAME]", $LastName, $contents);
            $contents = str_replace("[LEADID]", $LeadID, $contents);
            $contents = str_replace("[LEADSTATUS]", $lead_status, $contents);
            $contents = str_replace("[PRODUCTPRICE]", (!empty($product_price)) ? (stripslashes($product_price)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[PRIMARYEMAIL]", (!empty($primary_email)) ? (stripslashes($primary_email)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[COMPANY]", (!empty($company)) ? (stripslashes($company)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADAMOUNT]", (!empty($LeadAmount)) ? (stripslashes($LeadAmount)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[WEBSITE]", (!empty($Website)) ? (stripslashes($Website)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[TITLE]", (!empty($designation)) ? (stripslashes($designation)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[PRODUCT]", (!empty($ProductID)) ? (stripslashes($ProductID)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[ANNUALREVENUE]", (!empty($AnnualRevenue)) ? (stripslashes($AnnualRevenue)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[NUMBEROFEMPLOYEES]", (!empty($NumEmployee)) ? (stripslashes($NumEmployee)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADDATE]", (!empty($LeadDate)) ? (date($Config['DateFormat'], strtotime($LeadDate))) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LASTCONTACTDATE]", (!empty($LastContactDate)) ? (date($Config['DateFormat'], strtotime($LastContactDate))) : (NOT_SPECIFIED), $contents);




            $contents = str_replace("[COMPANY]", $company, $contents);
            //$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
	    
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Lead [" . $LeadName . "] - " . $subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            //echo $assignEmail.$Config['AdminEmail'].$contents; exit; 
            if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                $mail->Send();
            }
        }
        //echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;
        //Projects [Sunesta]. Task Assigned to You: Email for Images and Files
        //Send Acknowledgment Email to admin


        $TemplateContent2 = $objConfigure->GetTemplateContent(2, 1);
        $contents = $TemplateContent2[0]['Content'];
        if (!empty($product_price))
            $LeadAmount = $product_price . ' ' . $Config['Currency'];
        $subject2 = $TemplateContent2[0]['subject'];
        //$contents = file_get_contents($htmlPrefix . "admin_Lead.htm");
        $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[FIRSTNAME]", $FirstName, $contents);
        $contents = str_replace("[LASTNAME]", $LastName, $contents);
        $contents = str_replace("[LEADID]", $LeadID, $contents);
        $contents = str_replace("[LEADSTATUS]", $lead_status, $contents);
        $contents = str_replace("[PRODUCTPRICE]", (!empty($product_price)) ? (stripslashes($product_price)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[PRIMARYEMAIL]", (!empty($primary_email)) ? (stripslashes($primary_email)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[COMPANY]", (!empty($company)) ? (stripslashes($company)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADAMOUNT]", (!empty($LeadAmount)) ? (stripslashes($LeadAmount)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[WEBSITE]", (!empty($Website)) ? (stripslashes($Website)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[TITLE]", (!empty($designation)) ? (stripslashes($designation)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[PRODUCT]", (!empty($ProductID)) ? (stripslashes($ProductID)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[ANNUALREVENUE]", (!empty($AnnualRevenue)) ? (stripslashes($AnnualRevenue)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[NUMBEROFEMPLOYEES]", (!empty($NumEmployee)) ? (stripslashes($NumEmployee)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADDATE]", (!empty($LeadDate)) ? (date($Config['DateFormat'], strtotime($LeadDate))) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LASTCONTACTDATE]", (!empty($LastContactDate)) ? (date($Config['DateFormat'], strtotime($LastContactDate))) : (NOT_SPECIFIED), $contents);


        $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($Config['AdminEmail']);
        if (!empty($Config['DeptHeadEmail'])) {
            $mail->AddCC($Config['DeptHeadEmail']);
        }
	if($CmpID=="34"){  //virtual stacks
		$mail->AddCC("anish.sinha@vstacks.in");
        }
        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " - " . $subject2;
        $mail->IsHTML(true);
        $mail->Body = $contents;
        # echo $arryRow[0]['Email'] . $Config['AdminEmail'] . $contents;exit;
        if($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
            $mail->Send();
        }

        #echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

        return $LeadID;
    }

    function UpdateLead($arryDetails) {
        $objConfigure = new configure();
        global $Config;

	$str=''; $AnnualRevenue='';

        extract($arryDetails);

	
        $LeadName = trim($FirstName . ' ' . $LastName);
        
         if ($assign == 'Users') { //By Chetan//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }

        if ($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
        }


        $sql = "select * from c_lead where AssignTo!='" . $AssignTo . "' and leadID='" . $leadID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {

            if ($AssignTo != '') {
                
                
                
                 $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignTo . ")";
                $arryEmp = $this->query($strSQLQuery, 1);

                foreach ($arryEmp as $email) {
                    $ToEmail .= $email['Email'] . ",";
                    $AssignUserName .= $email['UserName'] . ",";
                }
                $assignEmail = rtrim($ToEmail, ",");
                $AssignUserName = rtrim($AssignUserName, ",");

                //$objEmployee= new employee();
                //$arryEmp=$objEmployee->GetEmployeeUser($AssignTo,1);
               # $strSQLQuery = "select UserName,Email from h_employee where EmpID='" . $AssignTo . "'";
                #$arryEmp = $this->query($strSQLQuery, 1);

                $ToEmail = $arryEmp[0]['Email'];
                $CC = $Config['AdminEmail'];

                #$assignEmail = $arryEmp[0]['Email'];


                $TemplateContent = $objConfigure->GetTemplateContent(1, 1);
                $contents = $TemplateContent[0]['Content'];
                //$contents = file_get_contents($htmlPrefix . "LeadAssigned.htm");
                $subject = $TemplateContent[0]['subject'];
                $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
                $contents = str_replace("[URL]", $Config['Url'], $contents);
                $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
                $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
                $contents = str_replace("[FIRSTNAME]", $FirstName, $contents);
                $contents = str_replace("[LASTNAME]", $LastName, $contents);
                $contents = str_replace("[LEADID]", $LeadID, $contents);
                $contents = str_replace("[LEADSTATUS]", $lead_status, $contents);
                $contents = str_replace("[PRODUCTPRICE]", (!empty($product_price)) ? (stripslashes($product_price)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[PRIMARYEMAIL]", (!empty($primary_email)) ? (stripslashes($primary_email)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[LEADAMOUNT]", (!empty($product_price)) ? (stripslashes($product_price)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[EMAIL]", (!empty($primary_email)) ? (stripslashes($primary_email)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[COMPANY]", (!empty($company)) ? (stripslashes($company)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[LEADAMOUNT]", (!empty($LeadAmount)) ? (stripslashes($LeadAmount)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[WEBSITE]", (!empty($Website)) ? (stripslashes($Website)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[TITLE]", (!empty($designation)) ? (stripslashes($designation)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[PRODUCT]", (!empty($ProductID)) ? (stripslashes($ProductID)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[ANNUALREVENUE]", (!empty($AnnualRevenue)) ? (stripslashes($AnnualRevenue)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[NUMBEROFEMPLOYEES]", (!empty($NumEmployee)) ? (stripslashes($NumEmployee)) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[LEADDATE]", (!empty($LeadDate)) ? (date($Config['DateFormat'], strtotime($LeadDate))) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[LASTCONTACTDATE]", (!empty($LastContactDate)) ? (date($Config['DateFormat'], strtotime($LastContactDate))) : (NOT_SPECIFIED), $contents);
                //$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

                $mail = new MyMailer();
                $mail->IsMail();
                $mail->AddAddress($assignEmail);
                //$mail->sender($LeadName, $primary_email);
		$mail->sender($Config['SiteName'], $Config['AdminEmail']);
                $mail->Subject = $Config['SiteName'] . " - Lead [" . $LeadName . "] - " . $subject;
                $mail->IsHTML(true);
                $mail->Body = $contents;
                if ($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                    $mail->Send();
                }
            }
            #echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;
        }


        if ($main_city_id > 0)
            $OtherCity = '';
        if ($main_state_id > 0)
            $OtherState = '';
        //if(empty($Status)) $Status=1;type,ProductID,product_price
       /* $strSQLQuery = "update c_lead set  LeadName='" . addslashes($LeadName) . "',type='" . addslashes($type) . "', ProductID='" . addslashes($ProductID) . "', product_price='" . addslashes($product_price) . "',FirstName='" . addslashes($FirstName) . "', LastName='" . addslashes($LastName) . "',Website='" . addslashes($Website) . "',
			primary_email='" . addslashes($primary_email) . "',designation='" . addslashes($designation) . "',
			Industry='" . addslashes($Industry) . "',AnnualRevenue=ENCODE('" . addslashes($AnnualRevenue) . "','". $Config['EncryptKey']."'),
			lead_source='" . addslashes($lead_source) . "', AssignTo='" . addslashes($AssignTo) . "',AssignType = '" . $AssignType . "',GroupID = '" . $GroupID . "',lead_status='" . addslashes($lead_status) . "',Address='" . addslashes($Address) . "',  city_id='" . $main_city_id . "', state_id='" . $main_state_id . "', ZipCode='" . addslashes($ZipCode) . "', country_id='" . $country_id . "', Mobile='" . addslashes($Mobile) . "', LandlineNumber='" . addslashes($LandlineNumber) . "',  OtherState='" . addslashes($OtherState) . "' ,OtherCity='" . addslashes($OtherCity) . "',company='" . addslashes($company) . "', description='" . addslashes($description) . "', LeadDate='" . addslashes($LeadDate) . "', NumEmployee='" . addslashes($NumEmployee) . "', LastContactDate='" . addslashes($LastContactDate) . "', Currency='" . addslashes($Currency) . "', Rating='" . addslashes($Rating) . "'	where leadID='" . $leadID . "'";

        $this->query($strSQLQuery, 0);*/

 unset($arryDetails['AnnualRevenue']);
unset($arryDetails['captcha']);
	unset($arryDetails['assign']);
	unset($arryDetails['AssignToGroup']);
	unset($arryDetails['AssignToUser']);
	unset($arryDetails['Submit']);
	unset($arryDetails['LeadID']);
	unset($arryDetails['main_state_id']);
	unset($arryDetails['main_city_id']);
	unset($arryDetails['ajax_state_id']);
	unset($arryDetails['ajax_city_id']);
	unset($arryDetails['state_id']);
	unset($arryDetails['city_id']);
                 
       foreach($arryDetails as $key=>$values)
       {
		$str.= ''.$key.'="'.addslashes($values).'"'.',';
       }
     
       $strSQLQuery = "update c_lead set ".trim($str, ',')." , "
               . "AnnualRevenue=ENCODE('" . addslashes($AnnualRevenue) . "','". $Config['EncryptKey']."'),
                  AssignTo='" . addslashes($AssignTo) . "',AssignType = '" . $AssignType . "',
                   city_id='" . $main_city_id . "', state_id='" . $main_state_id . "'   where leadID='" . $leadID . "'";

//End//
	$this->query($strSQLQuery, 0);


        return 1;
    }

function Getrating($Rating='')
    {
        $strSQLQuery = "select * from rating";
	if($Rating!='') $strSQLQuery .= " where Rating='".$Rating."'";
      
       return $this->query($strSQLQuery, 1);    
    }

function UpdateCountyStateCity($arryDetails,$leadID){   
	extract($arryDetails);		

	$strSQLQuery = "UPDATE c_lead SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE leadID = '".$leadID."'";

	$this->query($strSQLQuery, 0);
	return 1;
}





    function UpdateCreater($arryDetail, $table, $typeID, $ID) {

        extract($arryDetail);

        $strSQLQuery = "update " . $table . " set  created_id='" . addslashes($created_id) . "', created_by='" . addslashes($created_by) . "' where " . $typeID . "='" . $ID."'";


        $this->query($strSQLQuery, 0);
        return 1;
    }

    function RemoveLead($leadID) {

        $strSQLQuery = "delete from c_lead where leadID='" . $leadID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function moveToJunkLead($leadID,$status) {
        if (!empty($leadID)) {
            $sql = "update c_lead set Junk='".$status."' where leadID in ( " . $leadID . ")";
            $rs = $this->query($sql, 0);
        }

        return true;
    }

   function setRowColorLead($leadID,$RowColor) {
        if (!empty($leadID)) {
            $sql = "update c_lead set RowColor='".$RowColor."' where leadID in ( " . $leadID . ")";
            $rs = $this->query($sql, 0);
        }

        return true;
    }

    function deleteLead($leadID) {
        if (!empty($leadID)) {
            $sql = "delete from c_lead where leadID in ( " . $leadID . ")";
            $rs = $this->query($sql, 0);
        }

        return true;
    }

    function changeLeadStatus($leadID) {
        $sql = "select * from c_lead where leadID='" . $leadID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update c_lead set Status='$Status' where leadID='" . $leadID . "'";
            $this->query($sql, 0);

            return true;
        }
    }

    function MultipleLeadStatus($leadIDs, $Status) {
        $sql = "select leadID from c_lead where leadID in (" . $leadIDs . ") ";
        $arryRow = $this->query($sql);
        if (sizeof($arryRow) > 0) {
            $sql = "update c_lead set Status='" . $Status . "' where leadID in (" . $leadIDs . ")";
            $this->query($sql, 0);
        }
        return true;
    }

    function isprimary_emailExists($primary_email, $leadID = 0) {
        $strSQLQuery = (!empty($leadID)) ? (" and leadID != '" . $leadID. "'") : ("");
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(primary_email)='" . strtolower(trim($primary_email)) . "'" . $strSQLQuery;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isLeadExist($FirstName, $LastName, $company, $leadID = 0) {
        $strAddQuery .= (!empty($leadID)) ? (" and leadID != '" . $leadID. "'") : ("");
	$strAddQuery .= (!empty($company)) ? (" and LCASE(company) ='".addslashes(strtolower(trim($company)))."' " ) : ("");
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(FirstName)='" . addslashes(strtolower(trim($FirstName))) . "' and LCASE(LastName)='" . addslashes(strtolower(trim($LastName))) . "' " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }


   function isLeadNameExist($FirstName, $LastName, $leadID = 0) {
        $strAddQuery .= (!empty($leadID)) ? (" and leadID != '" . $leadID. "'") : ("");
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(FirstName)='" . addslashes(strtolower(trim($FirstName))) . "' and LCASE(LastName)='" . addslashes(strtolower(trim($LastName))) . "' " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }


   function isLeadNameCompanyExist($FirstName, $LastName, $company) {
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(FirstName)='" . addslashes(strtolower(trim($FirstName))) . "' and LCASE(LastName)='" . addslashes(strtolower(trim($LastName))) . "' and LCASE(company)='" . addslashes(strtolower(trim($company))) . "' " . $strAddQuery55;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }

   function isLeadCompanyExist($company, $leadID = 0) {
        $strAddQuery .= (!empty($leadID)) ? (" and leadID != '" . $leadID. "'") : ("");
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(company)='" . addslashes(strtolower(trim($company))) . "'  " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }
   function isLeadEmailExist($primary_email, $leadID = 0) {
        $strAddQuery .= (!empty($leadID)) ? (" and leadID != '" . $leadID. "'") : ("");
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(primary_email)='" . addslashes(strtolower(trim($primary_email))) . "'  " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }

   function isLeadLandlineExist($LandlineNumber, $leadID = 0) {
        $strAddQuery .= (!empty($leadID)) ? (" and leadID != '" . $leadID. "'") : ("");
        $strSQLQuery = "select leadID from c_lead where Opportunity='0' and LCASE(LandlineNumber)='" . addslashes(strtolower(trim($LandlineNumber))) . "'  " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['leadID'])) {
            return true;
        } else {
            return false;
        }
    }



    function isOpportunityNameExists($OpportunityName, $OpportunityID = 0) {
        $strSQLQuery = (!empty($OpportunityID)) ? (" and OpportunityID != '" . $OpportunityID. "'") : ("");
        $strSQLQuery = "select OpportunityID from c_opportunity where LCASE(OpportunityName)='" . strtolower(trim($OpportunityName)) . "'" . $strSQLQuery;


        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['OpportunityID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isTicketTitleExists($title, $TicketID = 0) {
        $strSQLQuery = (!empty($TicketID)) ? (" and TicketID != '" . $TicketID. "'") : ("");
        $strSQLQuery = "select TicketID from c_ticket where LCASE(title)='" . strtolower(trim($title)) . "'" . $strSQLQuery;
//echo $strSQLQuery; exit;
        $arryRow = $this->query($strSQLQuery, 1);

        if (!empty($arryRow[0]['TicketID'])) {
            return true;
        } else {
            return false;
        }
    }

    /*     * **********Ticket Function**************** */

 function setRowColorTicket($TicketID,$RowColor) {

        if (!empty($TicketID)) {
            $sql = "update c_ticket set RowColor='".$RowColor."' where TicketID in ( " . $TicketID . ")";
            $rs = $this->query($sql, 0);
        }

        return true;
    }


    function AddTicket($arryDetails) {
        $objConfigure = new configure();
        global $Config;


        extract($arryDetails);

        if ($assign == 'Users') {   //By chetan//
            $AssignUser = $AssignToUser;
            $AssignType = $assign;
        } else {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignUser = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }
        if ($AssignUser != '') {
            $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignUser . ")";
            //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
            $arryEmp = $this->query($strSQLQuery, 1);
            foreach ($arryEmp as $email) {
                $ToEmail .= $email['Email'] . ",";
                $AssignUserName .= $email['UserName'] . ",";
            }
            $assignEmail = rtrim($ToEmail, ",");
            $AssignUserName = rtrim($AssignUserName, ",");
        }


	if($_SESSION['AdminType'] == "employee" && empty($AssignUser)) {
            $AssignUser = $_SESSION['AdminID'];
            $AssignType = 'User';
        }


        $htmlPrefix = $Config['EmailTemplateFolder'];
        $ipaddress = GetIPAddress();


	if($RelatedType == 'Lead'){
		$Related = $LeadID;
	}else if($RelatedType == 'Opportunity'){
		$Related = $OpprtunityID;
	}else if($RelatedType == 'Campaign'){
		$Related = $CampaignID;
	}else if($RelatedType == 'Quote'){
		$Related = $QuoteID;
	}


        /*$strSQLQuery = "insert into c_ticket ( title,AssignedTo,AssignType,GroupID,category,Name,day,hours, priority, description, solution,Status,ticketDate,parent_type,parentID,created_by,created_id ,CustID, RelatedType, RelatedTo) values( '" . addslashes($title) . "', '" . addslashes($AssignUser) . "','" . addslashes($AssignType) . "','" . addslashes($GroupID) . "','" . addslashes($category) . "','" . addslashes($Name) . "', '" . addslashes($day) . "', '" . addslashes($Hours) . "',  '" . $priority . "', '" . addslashes($description) . "', '" . addslashes($solution) . "','" . $Status . "','" . $Config['TodayDate'] . "','" . $parent_type . "','" . $parentID . "','" . $created_by . "','" . $created_id . "','" . $CustID . "', '" . addslashes($RelatedType)."', '".addslashes($Related)."')";

        $this->query($strSQLQuery, 0);*/
	//By Chetan 1july//
	unset($arryDetails['assign']);
	unset($arryDetails['contact_no']);
	unset($arryDetails['LeadSubmit']);
	unset($arryDetails['IsLeadForm']);
        unset($arryDetails['AssignToGroup']);
        unset($arryDetails['AssignToUser']);
        unset($arryDetails['Submit']);
	unset($arryDetails['module']);
        unset($arryDetails['RelatedTo']);
        unset($arryDetails['LeadID']);
        unset($arryDetails['OpprtunityID']);
        unset($arryDetails['CampaignID']);
        unset($arryDetails['TicketID']);
	unset($arryDetails['QuoteID']);
	if($Status==''){
	    $Status ='Open';
	}

      	$fields = join(',',array_keys($arryDetails));      
     	$values = join("','",array_values(array_map(function($arr){ return addslashes($arr);},$arryDetails))); //updated for addslashes on 22Sep2017 by chetan//
      
       
       	$strSQLQuery = "insert into c_ticket 
                        ( ticketDate,RelatedTo, AssignedTo,AssignType,GroupID,$fields)
                        values('" . $Config['TodayDate'] . "',
                                '" . addslashes($Related) . "',
                                '" . addslashes($AssignUser) . "',
                                '" . addslashes($AssignType) . "',
                                '" . addslashes($GroupID) ."', 
                                '".$values."')" ;
       $this->query($strSQLQuery, 0);
        //End// 
        $TicketID = $this->lastInsertId();

	//By Chetan on aug17,2017//
	$objCustomer = new Customer();
	$arrRes = $objCustomer->GetAddressBook($contact_id);
	$contNum = ($arrRes[0]["Mobile"]) ? $arrRes[0]["Mobile"] : $arrRes[0]["Landline"];
	$ContactInfo .= '<div style="margin:-27px 0 0 60px">'.nl2br(stripslashes($arrRes[0]["Address"]));
	if(!empty($arrRes[0]["CityName"]))$ContactInfo .= ', <br>'.htmlentities($arrRes[0]["CityName"], ENT_IGNORE);
	if(!empty($arrRes[0]["StateName"]))$ContactInfo .= ', '.stripslashes($arrRes[0]["StateName"]);
	$ContactInfo .= '<br>'.stripslashes($arrRes[0]["CountryName"]).' - '.stripslashes($arrRes[0]["ZipCode"]).'</div>';
	if(trim($arrRes[0]["FullName"])!=''){
		$Coust = $arrRes[0]["FullName"];
	}else{
		$Coust = $arrRes[0]["Company"];
	}		
   	//End//



        if ($parent_type != '' && $parentID != '' && $TicketID != '') {

            $mode_type = "Ticket";

            $strQuery = "insert into c_compaign_sel (compaignID,parent_type,parentID,mode_type ) values('" . $TicketID . "','" . addslashes($parent_type) . "','" . addslashes($parentID) . "','" . addslashes($mode_type) . "')";

            $this->query($strQuery, 0);

            $ID = $this->lastInsertId();



            $TemplateContent = $objConfigure->GetTemplateContent(5, 1);
            $contents = $TemplateContent[0]['Content'];
            //$contents = file_get_contents($htmlPrefix . "LeadAssigned.htm");
            $subject = $TemplateContent[0]['subject'] . "-" . $mode_type . "[" . $parentID . "]";

            //$subject = " has been added in " . $mode_type . "[" . $parentID . "]";
            //$contents = file_get_contents($htmlPrefix . "Added_Ticket.htm");

            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[PARENT]", $parent_type, $contents);
            $contents = str_replace("[TICKETID]", $TicketID, $contents);
            $contents = str_replace("[PARENTID]", $parentID, $contents);
            $contents = str_replace("[TITLE]", $title, $contents);
            $contents = str_replace("[CATEGORY]", $category, $contents);
            $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? ($AssignUserName) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[STATUS]", $Status, $contents);
            $contents = str_replace("[PRIORITY]", $priority, $contents);
            $contents = str_replace("[DESCRIPTION]", $description, $contents);
            $contents = str_replace("[CATEGORY]", $category, $contents);
            $contents = str_replace("[SOLUTION]", $solution, $contents);
            $contents = str_replace("[DAYS]", (!empty($day)) ? ($day) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[HOURS]", (!empty($Hours)) ? ($Hours) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[CREATEDON]", date($Config['DateFormat'], strtotime($Config['TodayDate'])), $contents);
	
            //By Chetan on aug18,2017//
	    $contents = str_replace("[CUSTOMER]", $Coust, $contents);
            $contents = str_replace("[ADDRESS]", $ContactInfo, $contents);
            $contents = str_replace("[CONTACTNUMBER]", $contNum, $contents);
	    //End//		

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['AdminEmail']);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Ticket - " . $subject2;
            $mail->IsHTML(true);
            #echo $Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                $mail->Send();
            }
        }

        if ($AssignUser != '') {

            $CC = $Config['AdminEmail'];
            $TemplateContent2 = $objConfigure->GetTemplateContent(6, 1);
            $contents = $TemplateContent2[0]['Content'];
            $subject2 = $TemplateContent2[0]['subject'];
           

            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[PARENT]", $parent_type, $contents);
            $contents = str_replace("[TICKETID]", $TicketID, $contents);
            $contents = str_replace("[PARENTID]", $parentID, $contents);
            $contents = str_replace("[TITLE]", $title, $contents);
            $contents = str_replace("[CATEGORY]", $category, $contents);
            $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? ($AssignUserName) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[STATUS]", $Status, $contents);
            $contents = str_replace("[PRIORITY]", $priority, $contents);
            $contents = str_replace("[DESCRIPTION]", $description, $contents);
            $contents = str_replace("[CATEGORY]", $category, $contents);
            $contents = str_replace("[SOLUTION]", (!empty($solution)) ? ($solution) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[DAYS]", (!empty($day)) ? ($day) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[HOURS]", (!empty($Hours)) ? ($hours) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[CREATEDON]", date($Config['DateFormat'], strtotime($Config['TodayDate'])), $contents);
	
	     //By Chetan on aug17,2017//
	    $contents = str_replace("[CUSTOMER]", $Coust, $contents);
            $contents = str_replace("[ADDRESS]", $ContactInfo, $contents);
            $contents = str_replace("[CONTACTNUMBER]", $contNum, $contents);
	    //End//	
            //$contents = str_replace("[DATE]",$ticketDate, $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Ticket - " . $subject2;
            $mail->IsHTML(true);
            $mail->Body = $contents;
#echo $assignEmail.$Config['AdminEmail'].$contents; exit;
            if ($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
                $mail->Send();
            }
        }

        #echo $assignEmail.$Config['AdminEmail'].$contents; exit;
        //Send Acknowledgment primary_email to admin
        $TemplateContent3 = $objConfigure->GetTemplateContent(5, 1);
        $contents = $TemplateContent3[0]['Content'];
        //$contents = file_get_contents($htmlPrefix . "admin_Ticket.htm");
        $subject3 = $TemplateContent[0]['subject'];
        $subject3 = "Details";
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[PARENT]", $parent_type, $contents);
        $contents = str_replace("[TICKETID]", $TicketID, $contents);
        $contents = str_replace("[PARENTID]", $parentID, $contents);
        $contents = str_replace("[TITLE]", $title, $contents);
        $contents = str_replace("[CATEGORY]", $category, $contents);
        $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? ($AssignUserName) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[STATUS]", $Status, $contents);
        $contents = str_replace("[PRIORITY]", $priority, $contents);
        $contents = str_replace("[DESCRIPTION]", $description, $contents);
        $contents = str_replace("[CATEGORY]", $category, $contents);
        $contents = str_replace("[SOLUTION]", $solution, $contents);
        $contents = str_replace("[DAYS]", (!empty($day)) ? ($day) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[HOURS]", (!empty($Hours)) ? ($Hours) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[CREATEDON]", date($Config['DateFormat'], strtotime($Config['TodayDate'])), $contents);

	//By Chetan on aug18,2017//
	$contents = str_replace("[CUSTOMER]", $Coust, $contents);
	$contents = str_replace("[ADDRESS]", $ContactInfo, $contents);
	$contents = str_replace("[CONTACTNUMBER]", $contNum, $contents);
	//End//

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($Config['AdminEmail']);
        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " -Ticket - " . $subject3;
        $mail->IsHTML(true);
        //echo $Config['AdminEmail'].$contents.$subject3; exit;
        $mail->Body = $contents;
        if ($Config['Online'] == 1) {
            $mail->Send();
        }
        #echo $assignEmail.$Config['AdminEmail'].$contents; exit;
if (!empty($TicketID) ) {

            //$TemplateContent = $objConfigure->GetTemplateContent(5, 1);
            //$contents = $TemplateContent[0]['Content'];
            
            

          $arryTick = $this->GetTicketBrief($TicketID,'');
            $TemplateContent[0]['subject'] = "Your Support Ticket";
$subject = $TemplateContent[0]['subject'] . "-" . $parent_type . "[" . $TicketID . "]";
$TemplateContent[0]['Status']=1;
$contents = " Hi! <br><br>
We just received your Query. We will get back to you as soon as possible. For your records, your support ticket number is #[".$arryTick[0]['TicketID']."]. Include it in any future correspondence you might send.<br><br>
You can view your ticket details or check its status by clicking the link below.<br><br>
<a href='http://www.eznetcrm.com/ticket-info.php?Cmp=".$arryTick[0]['Cmp']."&ticket=".$arryTick[0]['TicketID']."' target='_blanck'>Click here<a><br><br>
Thanks<br>
Support Team

";
            $subject = $TemplateContent[0]['subject'] . "-" . $parent_type . "[" . $parentID . "]";
            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($arryTick[0]['Email']);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Ticket - " . $subject2;
            $mail->IsHTML(true);
           //echo $Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1 && $arryTick[0]['Email']!='') {
                $mail->Send();
            }
       }


        return $TicketID;
    }

    /*     * *********************************** */

    function CustomTicket($selectCol, $condition) {
        global $Config;
        $strSQLQuery = "select * from c_ticket where 1 " . $condition . "";

        #$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (AssignedTo like '%".$_SESSION['AdminID']."%' OR created_id='".$_SESSION['AdminID']."') "):("");

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",AssignedTo) OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strSQLQuery .= ' order by TicketID desc ';
        //echo $strSQLQuery;
        return $this->query($strSQLQuery, 1);
    }

   function CustomLead($selectCol, $condition) {
        global $Config;
        $strSQLQuery = "select l.*, DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."') as AnnualRevenue from c_lead l where 1 and l.Opportunity='0' " . $condition . "  ";
        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (l.AssignTo = '" . $_SESSION['AdminID'] . "' OR l.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
	$strSQLQuery .= ($Config['flag']== 1) ? (" and l.FlagType ='Yes' ") : ("");
        $strSQLQuery .= ' order by l.leadID desc ';
       #echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }


     function CustomOpprotunity($selectCol, $condition) {
        global $Config;

        $strSQLQuery = "select p.*,DECODE(p.Amount,'". $Config['EncryptKey']."') as Amount,DECODE(p.forecast_amount,'". $Config['EncryptKey']."') as forecast_amount, l.Industry,l.leadID from c_opportunity p left outer join c_lead l on p.LeadID = l.leadID where 1  " . $condition . "  ";
        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (p.AssignTo = '" . $_SESSION['AdminID'] . "' OR p.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        if ($Config['DefaultActive'] == 1)
            $strSQLQuery .= " and p.Status='1' ";

        $strSQLQuery .= ' order by p.OpportunityID desc ';
       // echo "=>".$strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    function CustomCampaign($selectCol, $condition) {

        global $Config;
        $strSQLQuery = "select c.*,p.ItemID,p.description as ItemName,p.Sku from c_campaign c left outer join inv_items p on c.product =p.ItemID  where 1  " . $condition . "  ";
        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (c.assignedTo = '" . $_SESSION['AdminID'] . "' OR c.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strSQLQuery .= ' order by c.campaignID desc ';

        #echo $strSQLQuery;
        return $this->query($strSQLQuery, 1);
    }

    /*     * ************************************ */

    function ListTicket($arrayDetails) {
        global $Config;
        extract($arrayDetails);
        $strAddQuery = " where 1 ";
        $SearchKey = strtolower(trim($key));
        $SortBy = $sortby;
		$OrderBy = !empty($OrderBy) ? $OrderBy :'';
		$strAddQuery .= (isset($Config['flag']) && $Config['flag']==1) ? (" and t.FlagType ='Yes' ") : ("");
		$strAddQuery .= (!empty($Config['rule'])) ? ("   " . $Config['rule'] . "") : ("");  //add Rajan 23 dec
		$strAddQuery .= (!empty($Config['rows'])) ? ("  and t.RowColor = '#" . $Config['rows'] . "' ") : ("");  //add Rajan 20 jan
        //$strAddQuery .= ($search_Status=='Active')?(" and  (t.Status like 'In progress' or t.Status like 'Open')"):(" ");
        if ($SearchKey != "" && $SortBy == "t.TicketID") {

            $strAddQuery .= " and t.TicketID = '" . $SearchKey . "'";
        } elseif ($SearchKey != "" && $SortBy == "t.title") {

            $strAddQuery .= " and  t.title like '%" . $SearchKey . "%'";
      
        } else if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
        } else {

            $strAddQuery .= (!empty($SearchKey)) ? (" and (t.title like '%" . $SearchKey . "%' or t.category like '%" . $SearchKey . "%' or e.UserName like '%" . $SearchKey . "%' or t.TicketID like '%" . $SearchKey . "%'   or t.Status like '%" . $SearchKey . "%'  or t.description like '%" . $SearchKey . "%'  ) and t.PID =0 " ) : ("");




            //$strAddQuery .= "(!empty($SearchKey))? 1 AND (t.title like '%".$SearchKey."%' or t.TicketID = '".$SearchKey."' or  t.TicketID = '".$SearchKey."') and t.PID =0" ;	
        }


        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",t.AssignedTo) OR t.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        #$strAddQuery .= ($Config['vAllRecord']!=1)?(" and ( t.AssignedTo like '%".$_SESSION['AdminID']."%' OR t.created_id='".$_SESSION['AdminID']."') "):("");

        $strAddQuery .= (!empty($CustID)) ? (" and t.CustID='" . $CustID . "'") : ("");


        

        //$strSQLQuery = "select t.*,if(t.PID>0,t2.title,'') as ParentName from c_ticket t left outer join c_ticket t2 on t.PID = t2.TicketID " . $strAddQuery . $OrderBy;


if($Config['GetNumRecords']==1){
				$Columns = " count(t.TicketID) as NumCount ";				
			}else{		

$strAddQuery .= " group by t.TicketID";
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by t.TicketID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");	
				$Columns = " t.*,if(t.PID>0,t2.title,'') as ParentName,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}




 $strSQLQuery = "select ".$Columns." from c_ticket t left outer join c_ticket t2 on t.PID = t2.TicketID left outer join  h_employee e on FIND_IN_SET(e.EmpID,t.AssignedTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=t.created_id left outer join  h_department d2 on e2.Department=d2.depID  " . $strAddQuery . $OrderBy;

        return $this->query($strSQLQuery, 1);
    }

    function GetTicketBrief($TicketID, $Status) {
        $strSQLQuery = "select l.TicketID, l.title,l.Cmp,l.Email from c_ticket l ";

        $strSQLQuery .= (!empty($TicketID)) ? (" where l.TicketID='" . $TicketID . "'") : (" where 1 ");

        //$strSQLQuery .= ($Status>0)?(" and l.Status='".$Status."'"):("");
        $strSQLQuery .= " order by l.title asc ";

        return $this->query($strSQLQuery, 1);
    }

    function GetQuoteBrief($quoteid, $Status='') {
        $strSQLQuery = "select l.quoteid, l.subject from c_quotes l ";

        $strSQLQuery .= (!empty($quoteid)) ? (" where l.quoteid='" . $quoteid . "'") : (" where 1 ");

        //$strSQLQuery .= ($Status>0)?(" and l.Status='".$Status."'"):("");
        $strSQLQuery .= " order by l.subject asc ";

        return $this->query($strSQLQuery, 1);
    }

    function ListAllCategories() {


        $strSQLQuery = "select CategoryID,Level,Name,Status from e_categories WHERE ParentID ='0'";
        return $this->query($strSQLQuery, 1);
    }

    /* function  ListAllCategoriesAndSubcategories()
      {assignedTo


      $strSQLQuery = "select CategoryID,Level,Name,Status from e_categories";
      return $this->query($strSQLQuery, 1);
      } */

    function GetCategory($CategoryID, $ParentID) {
        $strAddQuery = '';
        $strAddQuery .= ($ParentID > 0) ? (" where c1.ParentID='" . $ParentID . "'") : (" where c1.ParentID='0'");
        $strAddQuery .= ($CategoryID > 0) ? (" and c1.CategoryID='" . $CategoryID . "'") : ("");

        $strSQLQuery = "select t1.*,if(t1.PID>0,t2.title,'') as ParentName,d.Department,e.Role,e.UserName as AssignTo from c_ticket t1 left outer join c_ticket c2 on c1.PID = c2.TicketID left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID " . $strAddQuery . " order by t1.title";

        return $this->query($strSQLQuery, 1);
    }

    function GetSubCategoryByParent($Status, $ParentID) {

        if ($Status == '1' || $Status == 'active' || $Status == 'Active') {
            $strAddQuery .= " and Status='1'";
        } else if ($Status == '0' || $Status == 'inactive') {
            $strAddQuery .= " and Status='0'";
        }


        $strSQLQuery = "select * from e_categories where ParentID='" . $ParentID . "'". $strAddQuery . " order by CategoryID";

        return $this->query($strSQLQuery, 1);
    }

    function GetNameByParentID($ParentID) {
        $strAddQuery = '';
        $strSQLQuery = "select Name from inv_categories where CategoryID = '" . $ParentID. "'" . $strAddQuery . " order by Name";
        return $this->query($strSQLQuery, 1);
    }

    function GetCategoryNameByID($CategoryID) {
        $strAddQuery = '';
        $strSQLQuery = "select c1.Name,c1.Image,c1.CategoryID,c1.ParentID from inv_categories c1 where c1.Status=1 and c1.CategoryID in(" . $CategoryID . ") " . $strAddQuery . " order by c1.Name ";
        return $this->query($strSQLQuery, 1);
    }

    /*     * ************************************* */

    function ListTicket6756($id = 0, $parent_type, $parentID, $SearchKey, $SortBy, $AscDesc) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where t.TicketID='" . $id . "'") : (" where 1 ");

        $strAddQuery .= (!empty($parent_type)) ? (" and t.parent_type='" . $parent_type . "' ") : ("");
        $strAddQuery .= (!empty($parentID)) ? (" and t.parentID='" . $parentID . "'") : ("");

        if ($SearchKey == 'active' && ($SortBy == 'l.Status' || $SortBy == '')) {
            $strAddQuery .= " and t.Status='1'";
        } else if ($SearchKey == 'inactive' && ($SortBy == 't.Status' || $SortBy == '')) {
            $strAddQuery .= " and t.Status='0'";
        } else if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " = '" . $SearchKey . "')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and ( t.title like '%" . $SearchKey . "%' or t.priority like '%" . $SearchKey . "%' or t.TicketID like '%" . $SearchKey . "%' ) " ) : ("");
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by t.TicketID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

        $strSQLQuery = "select t.*, d.Department,e.Role,e.UserName as AssignTo from c_ticket t  left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID  " . $strAddQuery;






        return $this->query($strSQLQuery, 1);
    }

    function GetTicket($TicketID, $Status) {
        $strSQLQuery = "select t.*,if(t.PID>0,t2.title,'') as ParentName,d.Department,e.EmpID,e.Role,e.UserName as AssignTo from c_ticket t left outer join c_ticket t2 on t.PID = t2.TicketID left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID  where  t.TicketID='" . $TicketID . "'";

        //$strSQLQuery .= (!empty($leadID))?(" where t.TicketID='".$TicketID."'"):(" where 1 ");
        //$strSQLQuery .= ($Status>0)?(" and t.Status='".$Status."'"):("");
//echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveTicket($TicketID) {

        $strSQLQuery = "delete from c_ticket where TicketID='" . $TicketID . "'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    function UpdateTicketDetail($arryDetails) {

        $objConfigure = new configure();
        global $Config;

        extract($arryDetails);


        if ($assign == 'Users') {   //By chetan 1july//
            $AssignUser = $AssignToUser;
            $AssignType = $assign;
        } else {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignUser = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }

if($RelatedType == 'Lead'){
		$Related = $LeadID;
	}else if($RelatedType == 'Opportunity'){
		$Related = $OpprtunityID;
	}else if($RelatedType == 'Campaign'){
		$Related = $CampaignID;
	}else if($RelatedType == 'Quote'){
		$Related = $QuoteID;
	}


      /*  $strSQLQuery = "update c_ticket set  title='" . addslashes($title) . "', AssignedTo='" . addslashes($AssignUser) . "',AssignType = '" . $AssignType . "',GroupID = '" . $GroupID . "',Status='" . addslashes($Status) . "',priority='" . addslashes($priority) . "',description='" .addslashes($description). "',solution='" .addslashes($solution). "' ,category='" . addslashes($category) . "',day='" . addslashes($day) . "',hours='" . $Hours . "',CustID='" . addslashes($CustID) . "', RelatedType='".addslashes($RelatedType)."',RelatedTo='".addslashes($Related)."'	where TicketID='" . $TicketID . "'"; */
 //Chetan1july//
	unset($arryDetails['assign']);
        unset($arryDetails['AssignToGroup']);
        unset($arryDetails['AssignToUser']);
        unset($arryDetails['Submit']);
        unset($arryDetails['RelatedTo']);
        unset($arryDetails['LeadID']);
        unset($arryDetails['OpprtunityID']);
        unset($arryDetails['CampaignID']);
        unset($arryDetails['TicketID']);
	unset($arryDetails['QuoteID']);
        unset($arryDetails['Comment']);
unset($arryDetails['contact_no']);
                 
       foreach($arryDetails as $key=>$values)
       {
           $str.= ''.$key.'="'.addslashes($values).'"'.',';
       }
     
       $strSQLQuery = "update c_ticket set ".trim($str, ',')." , "
               . "RelatedTo='".$Related."',
                  GroupID = '" . $GroupID . "',
                  AssignedTo='" . addslashes($AssignUser) . "',AssignType = '" . $AssignType . "'
                  where TicketID ='" .$TicketID . "'";

    	//End//	
        $this->query($strSQLQuery, 0);


        #$sql = "select * from c_ticket where AssignedTo!='" . $AssignUser . "' and TicketID='" . $TicketID . "'";
        #$rs = $this->query($sql, 1);

        #if (empty($rs[0]['AssignedTo'])) {

            if ($AssignUser != '') {

                $sqlTicket = "select * from c_ticket where 1 and TicketID='" . $TicketID . "'";
                $sqlTket = $this->query($sqlTicket, 1);

                $ticketDate = $sqlTket[0]['ticketDate'];
                $solution = $sqlTket[0]['solution'];
                $dayT = $sqlTket[0]['day'];
                $category = $sqlTket[0]['category'];
                $HoursT = $sqlTket[0]['hours'];
                $description = stripslashes($sqlTket[0]['description']);

                $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignUser . ")";
                $arryEmp = $this->query($strSQLQuery, 1);

                foreach ($arryEmp as $email) {
                    $ToEmail .= $email['Email'] . ",";
                    $AssignUserName .= $email['UserName'] . ",";
                }
                $assignEmail = rtrim($ToEmail, ",");
                $AssignUserName = rtrim($AssignUserName, ",");

                $ToEmail = $arryEmp[0]['Email'];
                
		/*$CC = $Config['AdminEmail'];
                $htmlPrefix = $Config['EmailTemplateFolder'];

                $TemplateContent = $objConfigure->GetTemplateContent(6, 1);
                $contents = $TemplateContent[0]['Content'];
                //$contents = file_get_contents($htmlPrefix . "LeadAssigned.htm");
                $subject = $TemplateContent[0]['subject'] . "-" . $mode_type . "[" . $parentID . "]";

                //$subject = " has been added in " . $mode_type . "[" . $parentID . "]";
                //$contents = file_get_contents($htmlPrefix . "Added_Ticket.htm");

                $contents = str_replace("[URL]", $Config['Url'], $contents);
                $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
                $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
                $contents = str_replace("[PARENT]", $parent_type, $contents);
                $contents = str_replace("[TICKETID]", $ID, $contents);
                $contents = str_replace("[PARENTID]", $parentID, $contents);
                $contents = str_replace("[TITLE]", $title, $contents);
                $contents = str_replace("[CATEGORY]", $category, $contents);
                $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? ($AssignUserName) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[STATUS]", $Name, $contents);
                $contents = str_replace("[PRIORITY]", $priority, $contents);
                $contents = str_replace("[DESCRIPTION]", $description, $contents);
                $contents = str_replace("[CATEGORY]", $category, $contents);
                $contents = str_replace("[SOLUTION]", (!empty($solution)) ? ($solution) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[DAYS]", (!empty($dayT)) ? ($dayT) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[HOURS]", (!empty($HoursT)) ? ($HoursT) : (NOT_SPECIFIED), $contents);
                $contents = str_replace("[CREATEDON]", date($Config['DateFormat'], strtotime($ticketDate)), $contents);


                $mail = new MyMailer();
                $mail->IsMail();
                $mail->AddAddress($assignEmail);
                $mail->sender($Config['SiteName'], $Config['AdminEmail']);
                $mail->Subject = $Config['SiteName'] . " - " . $subject;
                $mail->IsHTML(true);
                $mail->Body = $contents;

                if ($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                    $mail->Send();
                }*/


		//By Chetan on aug18,2017//
		$objCustomer = new Customer();
		$arrRes = $objCustomer->GetAddressBook($contact_id);
		$contNum = ($arrRes[0]["Mobile"]) ? $arrRes[0]["Mobile"] : $arrRes[0]["Landline"];
		$ContactInfo .= '<div style="margin:-27px 0 0 60px">'.nl2br(stripslashes($arrRes[0]["Address"]));
		if(!empty($arrRes[0]["CityName"]))$ContactInfo .= ', <br>'.htmlentities($arrRes[0]["CityName"], ENT_IGNORE);
		if(!empty($arrRes[0]["StateName"]))$ContactInfo .= ', '.stripslashes($arrRes[0]["StateName"]);
		$ContactInfo .= '<br>'.stripslashes($arrRes[0]["CountryName"]).' - '.stripslashes($arrRes[0]["ZipCode"]).'</div>';
		if(trim($arrRes[0]["FullName"])!=''){
		$Coust = $arrRes[0]["FullName"];
		}else{
		$Coust = $arrRes[0]["Company"];
		}		
   		//End//

		$CC = $Config['AdminEmail'];
		$TemplateContent2 = $objConfigure->GetTemplateContent(9, 1);
		$contents = $TemplateContent2[0]['Content'];
		$subject2 = $TemplateContent2[0]['subject'];

		$contents = str_replace("[URL]", $Config['Url'], $contents);
		$contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
		$contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
		$contents = str_replace("[PARENT]", $parent_type, $contents);
		$contents = str_replace("[TICKETID]", $TicketID, $contents);
		$contents = str_replace("[PARENTID]", $parentID, $contents);
		$contents = str_replace("[TITLE]", $title, $contents);
		$contents = str_replace("[CATEGORY]", $category, $contents);
		$contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? ($AssignUserName) : (NOT_SPECIFIED), $contents);
		$contents = str_replace("[STATUS]", $Status, $contents);
		$contents = str_replace("[PRIORITY]", $priority, $contents);
		$contents = str_replace("[DESCRIPTION]", $description, $contents);
		$contents = str_replace("[CATEGORY]", $category, $contents);
		$contents = str_replace("[SOLUTION]", (!empty($solution)) ? ($solution) : (NOT_SPECIFIED), $contents);
		$contents = str_replace("[DAYS]", (!empty($day)) ? ($day) : (NOT_SPECIFIED), $contents);
		$contents = str_replace("[HOURS]", (!empty($hours)) ? ($hours) : (NOT_SPECIFIED), $contents);
		$contents = str_replace("[CREATEDON]", date($Config['DateFormat'], strtotime($Config['TodayDate'])), $contents);
		

		//By Chetan on aug18,2017//
		$contents = str_replace("[USER]", $AssignUserName, $contents);
		$contents = str_replace("[CUSTOMER]", $Coust, $contents);
		$contents = str_replace("[ADDRESS]", $ContactInfo, $contents);
		$contents = str_replace("[CONTACTNUMBER]", $contNum, $contents);
		//End//
		//$contents = str_replace("[DATE]",$ticketDate, $contents);

		$mail = new MyMailer();
		$mail->IsMail();
		$mail->AddAddress($assignEmail);
		$mail->sender($Config['SiteName'], $Config['AdminEmail']);
		$mail->Subject = $Config['SiteName'] . " - Ticket - " . $subject2;
		$mail->IsHTML(true);
		$mail->Body = $contents;
		//echo $assignEmail.$Config['AdminEmail'].'----'.$contents; exit;
		if ($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
			$mail->Send();
		}

            }
        #}


	


        return 1;
    }

    function UpdateDescription($arryDetails) {
        extract($arryDetails);


        $strSQLQuery = "update c_ticket set description='" . addslashes($description) . "'
			where TicketID='" . $TicketID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function UpdateResolution($arryDetails) {
        global $Config;
        extract($arryDetails);


        $strSQLQuery = "update c_ticket set solution='" . addslashes($solution) . "'
			where TicketID='" . $TicketID . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    /*     * ********** Comment Section ********** */

    function AddComment($arrydetail) {
        global $Config;

        extract($arrydetail);
        $type=(empty($type))?('Comment'):($type);//by sachin
        $time = time();
					
if($CommentID!="" && !empty($CommentID))
	{
	$strSQLQuery = "update c_comments set Comment = '" . addslashes($Comment) . "' ,CommentDate = '" . $Config['TodayDate'] . "',timestamp = '" . $time . "' where CommentID = '" . $CommentID . "'";

	$this->query($strSQLQuery, 0);
	return '1';

	}else{
        $strSQLQuery = "insert into c_comments (parent,commented_by,commented_id,parent_type,parentID,Comment,CommentDate,timestamp,subject,type,callPurpuse,calltype,callduration) values( '" .$parent. "', '" .$commented_by. "','" .$commented_id. "','" .$parent_type. "','" . $parentID. "','" . addslashes($Comment) . "','" . $Config['TodayDate'] . "','" . $time . "','".$subject."','".$type."','".$callPurpuse."','".$calltype."','".$callduration."')";

        $this->query($strSQLQuery, 0);

        $cmtID = $this->lastInsertId();
        


 if ($parent_type == 'Ticket' && $parentID != '' ) {

            //$TemplateContent = $objConfigure->GetTemplateContent(5, 1);
            //$contents = $TemplateContent[0]['Content'];
            
            $subject = $TemplateContent[0]['subject'] . "-" . $parent_type . "[" . $parentID . "]";

          $arryTick = $this->GetTicketBrief($parentID,'');
            $TemplateContent[0]['subject'] = "Your Support Ticket Status";
$TemplateContent[0]['Status']=1;
$contents = " Hi! <br><br>
The status of your support ticket [".$arryTick[0]['TicketID']."] has been changed to answered.<br><br>
You can view your ticket details or check its status by clicking the link below.<br><br>
<a href='http://www.eznetcrm.com/ticket-info.php?Cmp=".$arryTick[0]['Cmp']."&ticket=".$arryTick[0]['TicketID']."' target='_blanck'>Click here<a><br><br>
Thanks<br>
Support Team

";
            $subject = $TemplateContent[0]['subject'] . "-" . $parent_type . "[" . $arryTick[0]['TicketID'] . "]";
            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($arryTick[0]['Email']);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Ticket - " . $subject2;
            $mail->IsHTML(true);
           //echo $Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1 && $arryTick[0]['Email']!='') {
                $mail->Send();
            }
       }





return $cmtID;

}
    }

    function GetCommentUser($id, $parentID, $parent_type, $parent, $status = 0,$type) {

        //$strAddQuery = 'where parent = ""';
        $strAddQuery = 'where 1';
        $strAddQuery .= (!empty($id)) ? (" and c.CommentID='" . $id . "'") : ("  ");
        $strAddQuery .= (!empty($parentID)) ? (" and c.parentID='" . $parentID . "'") : ("  ");
        $strAddQuery .= (!empty($parent_type)) ? (" and c.parent_type='" . $parent_type . "'") : (" ");
        $strAddQuery .= (!empty($parent)) ? (" and c.parent='" . $parent . "'") : (" ");
        $strAddQuery .= (!empty($type)) ? (" and c.type='" . $type . "'") : (" ");//by sachin

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.commented_id  " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }
    
    
    
    function GetCommentList($arrydetail) {

         extract($arrydetail);
                 
         $SearchKey = strtolower(trim($SearchKey));
         $SearchKey = str_replace("opportunity","customer",$SearchKey);
         
        $strAddQuery = "where ( c.parentID='" . $parentID . "'  and  c.parent_type='" . $parent_type . "')";       
        $strAddQuery .= (!empty($SearchKey)) ? (" and (c.comment like '%" . $SearchKey . "%' or e.UserName like '%" . $SearchKey . "%'  )" ) : ("");

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.commented_id   " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }
    
    function GetCommentListMain($arrydetail) {

         extract($arrydetail);
                 
         $SearchKey = strtolower(trim($SearchKey));
         $SearchKey = str_replace("opportunity","customer",$SearchKey);
         
        $strAddQuery = "where (( c.parentID='" . $parentID . "'  and  c.parent_type='" . $parent_type . "') or ( c.parent_type='Ticket' and t.CustID = '".$parentID."'))";       
        $strAddQuery .= (!empty($SearchKey)) ? (" and ( c.parent_type like '" . $SearchKey . "' or c.comment like '%" . $SearchKey . "%' or e.UserName like '%" . $SearchKey . "%'  )" ) : ("");

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.commented_id  left outer join c_ticket t  on (c.parentID=t.TicketID and t.CustID = '".$parentID."') " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function GetCommentByID($id, $parent) {

        $strAddQuery = 'where 1';
        $strAddQuery .= (!empty($id)) ? (" c.CommentID='" . $id . "'") : ("  ");
        $strAddQuery .= (!empty($parent)) ? (" and c.parent='" . $parent . "'") : (" ");

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.commented_id  " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveComment($commentID) {

        $strSQLQuery = "delete from c_comments where CommentID='" . $commentID . "'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

    /*     * *******************Document Section ********************** */

    function ListDocument($id = 0, $parent_type, $parentID, $SearchKey, $SortBy, $AscDesc) {
        global $Config;
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where d.documentID='" . $id . "'") : (" where 1 ");

        $strAddQuery .= (!empty($parent_type)) ? (" and d.parent_type='" . $parent_type . "' ") : ("");
        $strAddQuery .= (!empty($parentID)) ? (" and d.parentID='" . $parentID . "'") : ("");
if($parent_type == ''){
	$strAddQuery .= (!empty($_GET['FolderID'])) ? (" and d.FolderID='" . $_GET['FolderID']. "'") : (" and d.FolderID='0'");
}

        #$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (d.AssignTo like '%".$_SESSION['AdminID']."%' OR  d.AddedBy like '%".$_SESSION['AdminID']."%' )"):("");

        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",d.AssignTo) OR  d.AddedBy = '" . $_SESSION['AdminID'] . "') ") : ("");


        if ($SearchKey == 'active' && ($SortBy == 'd.Status' || $SortBy == '')) {
            $strAddQuery .= " and d.Status='1'";
        } else if ($SearchKey == 'inactive' && ($SortBy == 'd.Status' || $SortBy == '')) {
            $strAddQuery .= " and d.Status='0'";
        } else if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " = '" . $SearchKey . "')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and ( d.FileName like '%" . $SearchKey . "%' or d.title like '%" . $SearchKey . "%' or d.documentID like '%" . $SearchKey . "%' ) " ) : ("");
        }

        //$strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by d.documentID ");
        //$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");


if($Config['GetNumRecords']==1){
				$Columns = " count(d.documentID) as NumCount ";				
			}else{		

				//$strAddQuery .= " group by e.activityID ";
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by d.documentID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");	
				$Columns = " d.documentID, d.DownloadType, d.AddedDate, d.Status, d.title, d.FileName, d.AssignTo, d.description,d.FileExist, e.Role,e.UserName as AssignTo ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}




        $strSQLQuery = "select ".$Columns." from c_document d left outer join  h_employee e on e.EmpID=d.AssignTo  " . $strAddQuery;



        return $this->query($strSQLQuery, 1);
    }

    function AddDocument($arrydetail) {

        global $Config;

	$GroupID='';

        extract($arrydetail);


        if ($assign == 'Users') {   //By Chetan3Aug//
            $AssignTo = $AssignToUser;
        } else {

            $group = explode(":", $AssignToGroup);

            $AssignTo = $group[0];
            $GroupID = $group[1];
        }
        $time = time();


	if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
            $assign = 'Users';      //By Chetan3Aug//
        }


        //By Chetan3Aug//
         $unsetArray = array("assign","AssignToGroup","AssignToUser","Submit","documentID","created_id","AddedDate","created_by","AddedBy","OldFile","NewFile");
         foreach($unsetArray as $arr){unset($arrydetail[$arr]);}
        
        
        $fields = join(',',array_keys($arrydetail));
        $values = join("','",array_values($arrydetail));
       
        $strSQLQuery = "insert into c_document 
                        (AssignTo,AssignType,GroupID,AddedDate,created_by,AddedBy,$fields)
                        values( '" . $AssignTo . "',
                                '" . $assign . "',
                                '" . $GroupID ."', 
                                '" . $Config['TodayDate'] . "',
                                '".addslashes($_SESSION['AdminType']). "',
                                '".addslashes($_SESSION['AdminID'])."',
                                '".$values."')" ;    
                                 
        //End//


        $this->query($strSQLQuery, 0);

        $cmtID = $this->lastInsertId();
        return $cmtID;
    }

    function addDocAssign($arryDetails) {
	$AssignTo='';

        extract($arryDetails);


        $EmpID = explode(",", $AssignTo);
 

        $sql = "delete from c_doc_assign where documentID ='" . $_POST['documentID'] . "'";
        $rs = $this->query($sql, 0);
        for ($i = 0; $i < sizeof($EmpID); $i++) {
            $sql = "insert into c_doc_assign( EmpID, documentID) values('" . $EmpID[$i] . "', '" . $_POST['documentID'] . "')";
            $rs = $this->query($sql, 0);
        }

        return 1;
    }

    function getDocAssign($id = 0) {
        $sql = " where 1";
        $sql .= (!empty($id)) ? (" and a.documentID = '" . $id . "'") : ("");
        $sql = "select a.*,e.UserName,e.EmpID,e.Department,e.JobTitle,e.Image,d.Department as emp_dep,d.depID from c_doc_assign a left outer join  h_employee e on e.EmpID=a.EmpID left outer join  h_department d on e.Department=d.depID " . $sql . " order by a.EmpID Asc";
        return $this->query($sql, 1);
    }

    function UpdateDoc($FileName, $documentID) {
	if(!empty($documentID)){
		$strSQLQuery = "update c_document set FileName='" . addslashes($FileName) . "', FileExist='1' where documentID='" . $documentID . "'";
		$this->query($strSQLQuery, 0);
		return true;
	}
    }

    function RemoveDoc($documentID) {
	if(!empty($documentID)){
		$strSQLQuery = "update c_document set FileName='', FileExist='0' where documentID='" . $documentID . "'";
		$this->query($strSQLQuery, 0);
		return true;
	}
    }

    function changeDocumentStatus($documentID) {
        $sql = "select * from c_document where documentID='" . $documentID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update c_document set Status='" . $Status . "' where documentID='" . $documentID . "'";
            $this->query($sql, 0);

            return true;
        }
    }

    function RemoveDocument($documentID) {
	global $Config;
	$objFunction=new functions();

        $strSQLQuery = "select FileName from c_document where documentID='" . $documentID . "'";
        $arryRow = $this->query($strSQLQuery, 1);

      

        if ($arryRow[0]['FileName'] != '' ) {
           $objFunction->DeleteFileStorage($Config['C_DocumentDir'],$arryRow[0]['FileName']);
        }


        $strSQLQuery = "delete from c_document where documentID='" . $documentID . "'";
        $this->query($strSQLQuery, 0);


        return 1;
    }

    function UpdateDocument($arryDetails) {
        global $Config;

	$str=''; $GroupID='';

        extract($arryDetails);
	
	

        if ($assign == 'Users') {           //By Chetan3Aug//
            $AssignTo = $AssignToUser;
        } else {
            $group = explode(":", $AssignToGroup);
            $AssignTo = $group[0];
            $GroupID = $group[1];
        }

        //By Chetan3Aug//
         $unsetArray = array("assign","AssignToGroup","AssignToUser","Submit","documentID","created_id","AddedDate","created_by","AddedBy","OldFile","linkID",
                 "parent_type","parentID","NewFile");
        foreach($unsetArray as $arr){unset($arryDetails[$arr]);}
        
        foreach($arryDetails as $key=>$values)
        {
           $str.= ''.$key.'="'.addslashes($values).'"'.',';
        }
        
        $strSQLQuery = "update c_document set ".trim($str, ',')." , 
			AssignTo  = '" . $AssignTo . "',
                        AssignType  = '" . $assign . "',GroupID  = '" . $GroupID . "',AddedDate='" . $Config['TodayDate'] . "'			
                   	where documentID = '" . $documentID."'";

        //End//
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function isDocumentExists($title, $documentID = 0) {
        $strAddQuery = (!empty($documentID)) ? (" and documentID != '" . $documentID. "'") : ("");
        $strSQLQuery = "select documentID from c_document where title='" . $title . "' " . $strAddQuery;
        $arryRow = $this->query($strSQLQuery, 1);

//echo $arryRow[0]['documentID']; exit;
        if (!empty($arryRow[0]['documentID'])) {
            return true;
        } else {
            return false;
        } exit;
    }

    function GetDocument($documentID, $Status) {
        $strSQLQuery = "select t.*,f.FolderName from c_document t left outer join c_document_folder f on t.FolderID=f.FolderID where  t.documentID='" . $documentID . "'";

        //$strSQLQuery .= (!empty($leadID))?(" where t.TicketID='".$TicketID."'"):(" where 1 ");
        //$strSQLQuery .= ($Status>0)?(" and t.Status='".$Status."'"):("");
//echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetCustomerDocument($CustID) {
        $strSQLQuery = "select d.* from c_document d where  d.CustID='" . $CustID . "' order by d.documentID desc";

        return $this->query($strSQLQuery, 1);
    }

    /*     * *************************Opprtunity********************* */

    function ListOpportunity($id = 0, $SearchKey, $SortBy, $AscDesc) {
        global $Config;
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where o.OpportunityID='" . $id . "'") : (" where 1 ");
       # $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (o.AssignTo='" . $_SESSION['AdminID'] . "' OR o.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
$strAddQuery .= (!empty($Config['rule'])) ? ("   " . $Config['rule'] . "") : ("");  //add Rajan 23 dec
			$strAddQuery .= (!empty($Config['rows'])) ? ("  and o.RowColor = '#" . $Config['rows'] . "' ") : ("");  //add Rajan 20 jan
	$strAddQuery .= (!empty($Config['flag'])) ? (" and o.FlagType ='Yes' ") : ("");
        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",o.AssignTo) OR o.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
        
        if ($SearchKey == 'active' && ($SortBy == 'o.Status' || $SortBy == '')) {
            $strAddQuery .= " and o.Status='1'";
        } else if ($SearchKey == 'inactive' && ($SortBy == 'o.Status' || $SortBy == '')) {
            $strAddQuery .= " and o.Status='0'";
        } else if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " = '" . $SearchKey . "')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and ( o.OpportunityName like '%" . $SearchKey . "%' or o.lead_source like '%" . $SearchKey . "%' or l.LandlineNumber like '%" . $SearchKey . "%' or o.SalesStage like '%" . $SearchKey . "%'  ) " ) : ("");
        }
	$strAddQuery .= " and (convertToCus = '0' or convertToCus = '') ";   
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by o.OpportunityID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");

	if($Config['GetNumRecords']==1){
				$Columns = " count(o.OpportunityID) as NumCount ";				
			}else{				
				$Columns = "  o.*,DECODE(o.Amount,'". $Config['EncryptKey']."') as Amount,DECODE(o.forecast_amount,'". $Config['EncryptKey']."') as forecast_amount,e.EmpID,d.Department,e.Role,e.UserName,l.Mobile,l.LandlineNumber ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}



        $strSQLQuery = "select ".$Columns."  from c_opportunity o left outer join  h_employee e on e.EmpID=o.AssignTo left outer join  h_department d on e.Department=d.depID left outer join  c_lead l on o.LeadID=l.leadID " . $strAddQuery;



        return $this->query($strSQLQuery, 1);
    }

    function GetDashboardOpportunity($limit=6) {
	global $Config;
        $strSQLQuery = "select o.OpportunityID,o.LeadID,o.Status,o.OpportunityName,o.lead_source,o.AddedDate,o.view_status, DECODE(o.Amount,'". $Config['EncryptKey']."') as AmountVal,DECODE(o.forecast_amount,'". $Config['EncryptKey']."') as forecast_amount from c_opportunity o ";

        $strSQLQuery .= " where o.Status='1' and SalesStage not like 'Closed%' ";

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (o.AssignTo='" . $_SESSION['AdminID'] . "' OR o.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strSQLQuery .= " having AmountVal>0 order by o.view_status ASC limit 0,".$limit;

       // echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

 function setRowColorOpp($OpportunityID,$RowColor) {

        if (!empty($OpportunityID)) {
            $sql = "update c_opportunity set RowColor='".$RowColor."' where OpportunityID in ( " . $OpportunityID . ")";
            $rs = $this->query($sql, 0);
        }

        return true;
    }


    function AddOpportunity($arryDetails) {

        $objConfigure = new configure();

        global $Config;
	 $ipaddress = GetIPAddress();

	$AssignTo=$AssignType=$GroupID=$forecast_amount='';

        extract($arryDetails);


        if (empty($Status))
            $Status = 1;
		
	$UserName='';
	if(isset($FirstName)){
        	$UserName = trim($FirstName . ' ' . $LastName);
	}
	$LandlineNumber='';
	if(isset($Landline1)){
        	$LandlineNumber = trim($Landline1 . ' ' . $Landline2 . ' ' . $Landline3);
	}
	$expCloseDate = '';
	if(isset($CloseDate)){
        	$expCloseDate = $CloseDate . ' ' . $CloseTime;
	}
             
        
         if(!empty($assign) && $assign == 'Users') {  //By chetan 29june//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else if(!empty($AssignToGroup)) {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }
               
	if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
            $AssignType = 'User';
        }


        //if($Status=0 && !empty($Status)){ $Status=1;}

       /* $strSQLQuery = "insert into c_opportunity ( LeadID,OpportunityName,Amount,OrgName,AssignTo,AssignType,GroupID,CloseDate,lead_source,SalesStage,OpportunityType,NextStep,description,Probability,Campaign_Source,ContactName,AddedDate,forecast_amount,oppsite,Status, CustID, Currency ) values( '" . $LeadID . "', '" . addslashes($OpportunityName) . "',ENCODE('" .addslashes($Amount) . "','".$Config['EncryptKey']."'),'" . addslashes($OrgName) . "', '" . addslashes($AssignTo) . "','" . addslashes($AssignType) . "','" . addslashes($GroupID) . "', '" . addslashes($expCloseDate) . "', '" . addslashes($lead_source) . "',  '" . addslashes($SalesStage) . "','" . addslashes($OpportunityType) . "','" . addslashes($NextStep) . "','" . addslashes($description) . "','" . addslashes($Probability) . "',  '" . addslashes($Campaign_Source) . "', '" . addslashes($ContactName) . "',  '" . $Config['TodayDate'] . "',ENCODE('" .addslashes($forecast_amount) . "','".$Config['EncryptKey']."'),'" . addslashes($oppsite) . "','" . $Status . "','" . $CustID . "','" . $Currency . "')";*/



        //$this->query($strSQLQuery, 0);
        unset($arryDetails['Submit']);
        unset($arryDetails['TodayDate']);
        unset($arryDetails['assign']);
        unset($arryDetails['Amount']);
        unset($arryDetails['forecast_amount']);
        unset($arryDetails['AssignToGroup']);
        unset($arryDetails['AssignToUser']);
        unset($arryDetails['CloseDate']);
        unset($arryDetails['CloseTime']);
		unset($arryDetails['Industry']);
		unset($arryDetails['ContinueButton']);
        unset($arryDetails['ajax_state_id']);
	    unset($arryDetails['ajax_city_id']);
        unset($arryDetails['main_state_id']);
        unset($arryDetails['main_city_id']);
                 
      $fields = join(',',array_keys($arryDetails));
      $values = join("','",array_values(array_map(function($arr){ return addslashes($arr);},$arryDetails))); //updated for addslashes on 22Sep2017 by chetan//
      
       
       $strSQLQuery = "insert into c_opportunity 
                        (AssignTo,AssignType,GroupID,Amount,forecast_amount,AddedDate,CloseDate,$fields)
                        values('" . addslashes($AssignTo) . "',
                                '" . addslashes($AssignType) . "',
                                '" . addslashes($GroupID) ."',
                                ENCODE('" .addslashes($Amount) . "','".$Config['EncryptKey']."'),
                                ENCODE('" .addslashes($forecast_amount) . "','".$Config['EncryptKey']."'),   
                                '" . $Config['TodayDate'] ."',
                                '" . $expCloseDate ."',    
                               '".$values."')" ;

        $this->query($strSQLQuery, 0);

//End//


        /* if($LeadID!=''){
          $strUpSQLQuery = "update c_lead set  Opportunity='0' where leadID='".$LeadID."'";


          $this->query($strUpSQLQuery, 0);
          } */



        $OpportunityID = $this->lastInsertId();


        if (!empty($CustID)) {
            $CustSql = "Select FullName from s_customers where Cid ='" . $CustID . "' ";
            $arryCustomer = $this->query($CustSql, 1);

            $customer = $arryCustomer[0] ['FullName'];
        }


        if ($AssignTo != '') {
            
            
             $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignTo . ")";
            //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
            $arryEmp = $this->query($strSQLQuery, 1);
            foreach ($arryEmp as $email) {
                $ToEmail .= $email['Email'] . ",";
                $AssignUserName .= $email['UserName'] . ",";
            }
            $assignEmail = rtrim($ToEmail, ",");
            $AssignUserName = rtrim($AssignUserName, ",");
            
            

           # $strSQLQuery = "select UserName,Email from h_employee where EmpID='" . $AssignTo . "'";
            #$arryEmp = $this->query($strSQLQuery, 1);

            #$ToEmail = $arryEmp[0]['Email'];
            $CC = $Config['AdminEmail'];

            #$assignEmail = $arryEmp[0]['Email'];
            $TemplateContent = $objConfigure->GetTemplateContent(4, 1);
            $contents = $TemplateContent[0]['Content'];
            $subject = $TemplateContent[0]['subject'];
            $htmlPrefix = $Config['EmailTemplateFolder'];
            //$contents = file_get_contents($htmlPrefix . "oppAssigned.htm");
            //$subject = "  Assigned to You ";
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
	    $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[OPPORTUNITYNAME]", $OpportunityName, $contents);
            $contents = str_replace("[ORGANIZATIONNAME]", (!empty($OrgName)) ? (stripslashes($OrgName)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[EXPECTEDCLOSEDATE]", (!empty($expCloseDate)) ? (date($Config['DateFormat'], strtotime($expCloseDate))) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[AMOUNT]", (!empty($Amount)) ? (stripslashes($Amount)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[CUSTOMER]", (!empty($CustID)) ? (stripslashes($customer)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[INDUSTRY]", (!empty($Industry)) ? (stripslashes($Industry)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[PROBABILITY]", (!empty($Probability)) ? (stripslashes($Probability)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[CAMPAIGNSOURCE]", (!empty($Campaign_Source)) ? (stripslashes($Campaign_Source)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[FORECASTAMOUNT]", (!empty($forecast_amount)) ? (stripslashes($forecast_amount)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[CONTACTNAME]", (!empty($ContactName)) ? (stripslashes($ContactName)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[WEBSITE]", (!empty($oppsite)) ? (stripslashes($oppsite)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[SALESSTAGE]", (!empty($SalesStage)) ? ($SalesStage) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[NEXTSTEP]", (!empty($NextStep)) ? ($NextStep) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[OPPORTUNITYTYPE]", (!empty($OpportunityType)) ? ($OpportunityType) : (NOT_SPECIFIED), $contents);







            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Opportunity [" . $OpportunityName . "] - " . $subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            #echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;
            if ($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                $mail->Send();
            }
        }


        if (!empty($Amount))
            $Amount = $Amount . ' ' . $Config['Currency'];
        //$subject2 = "  has been Submitted. ";
        //Send Acknowledgment Email to admin
        //$contents = file_get_contents($htmlPrefix . "admin_opp.htm");

        $TemplateContent2 = $objConfigure->GetTemplateContent(3, 1);
        $contents = $TemplateContent2[0]['Content'];
        $subject2 = $TemplateContent2[0]['subject'];

        //$htmlPrefix = $Config['EmailTemplateFolder'];

        $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[OPPORTUNITYNAME]", $OpportunityName, $contents);
        $contents = str_replace("[ORGANIZATIONNAME]", (!empty($OrgName)) ? (stripslashes($OrgName)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[EXPECTEDCLOSEDATE]", (!empty($expCloseDate)) ? (date($Config['DateFormat'], strtotime($expCloseDate))) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[AMOUNT]", (!empty($Amount)) ? (stripslashes($Amount)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[INDUSTRY]", (!empty($Industry)) ? (stripslashes($Industry)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[CUSTOMER]", (!empty($CustID)) ? (stripslashes($customer)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[INDUSTRY]", (!empty($Industry)) ? (stripslashes($Industry)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[PROBABILITY]", (!empty($Probability)) ? (stripslashes($Probability)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[CAMPAIGNSOURCE]", (!empty($Campaign_Source)) ? (stripslashes($Campaign_Source)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[FORECASTAMOUNT]", (!empty($forecast_amount)) ? (stripslashes($forecast_amount)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[CONTACTNAME]", (!empty($ContactName)) ? (stripslashes($ContactName)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[WEBSITE]", (!empty($oppsite)) ? (stripslashes($oppsite)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[SALESSTAGE]", (!empty($SalesStage)) ? ($SalesStage) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[NEXTSTEP]", (!empty($NextStep)) ? ($NextStep) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[OPPORTUNITYTYPE]", (!empty($OpportunityType)) ? ($OpportunityType) : (NOT_SPECIFIED), $contents);

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($Config['AdminEmail']);
        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " - " . $subject2;
        $mail->IsHTML(true);

        $mail->Body = $contents;
        #echo $mail->Subject . ',' . $Config['AdminEmail'] . $contents;exit;

        if ($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
            $mail->Send();
        }


        return $OpportunityID;
    }

    function UpdateOpportunity($arryDetails) {

         global $Config;
        extract($arryDetails);
        $expCloseDate = $CloseDate . ' ' . $CloseTime;

         if ($assign == 'Users') {  //By chetan 29june//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }

        //if(empty($Status)) $Status=1;
        /*$strSQLQuery = "update c_opportunity set    OpportunityName='" . addslashes($OpportunityName) . "',
                                                    Amount=ENCODE('" .addslashes($Amount) . "','".$Config['EncryptKey']."'),
                                                    OrgName='" . addslashes($OrgName) . "',
                                                    AssignTo='" . addslashes($AssignTo) . "',
                                                    AssignType='" . addslashes($AssignType) . "',
                                                    GroupID='" . addslashes($GroupID) . "',
                                                    CloseDate='" . addslashes($expCloseDate) . "',
                                                    lead_source='" . addslashes($lead_source) . "',
                                                    SalesStage='" . addslashes($SalesStage) . "',
                                                    OpportunityType='" . addslashes($OpportunityType) . "',
                                                    NextStep='" . addslashes($NextStep) . "', 
                                                    description='" . addslashes($description) . "',
                                                    Probability='" . addslashes($Probability) . "',
                                                    Campaign_Source='" . addslashes($Campaign_Source) . "',
                                                    ContactName='" . addslashes($ContactName) . "', 
                                                    forecast_amount=ENCODE('" .addslashes($forecast_amount) . "','".$Config['EncryptKey']."'),
                                                    oppsite='" . addslashes($oppsite) . "',
                                                    Status='" . $Status . "',
                                                    CustID='" . $CustID . "', Currency='" . addslashes($Currency) . "'
                                                    where OpportunityID='" . $OpportunityID . "'";

        $this->query($strSQLQuery, 0);*/


	//By chetan 26Nov //
       /* $objField = new field();
        $arryField = $objField->getFormField('',2,'1'); 
        foreach($arryField as $val){
            
            	$queryStr .= ''.$val['fieldname'].' = "'.$arryDetails[$val['fieldname']].'",';
		unset($arryDetails[$val['fieldname']]);		
        }
       	
        if ($leadID > 0) {
            $sql = "update c_lead set ".$queryStr." primary_email='" . addslashes($primary_email) . "',
                    Industry='" . addslashes($Industry) . "',city_id='" . $main_city_id . "', state_id='" . $main_state_id . "',
                    OtherState='" . addslashes($OtherState) . "' ,OtherCity='" . addslashes($OtherCity) . "', 
                    LastContactDate='" . addslashes($LastContactDate) . "' 
                    where leadID='" . $leadID . "'";die;
            $this->query($sql, 0);
        }*/
		 if ($leadID > 0) {
            $sql = "update c_lead set ".$queryStr." primary_email='" . addslashes($primary_email) . "',
                    Industry='" . addslashes($Industry) . "', LastContactDate='" . addslashes($LastContactDate) . "' 
                    where leadID='" . $leadID . "'";
            $this->query($sql, 0);
        }
        //End//




 	    unset($arryDetails['CloseDate']);
        unset($arryDetails['CloseTime']);
        unset($arryDetails['assign']);
        unset($arryDetails['AssignToGroup']);
        unset($arryDetails['AssignToUser']);
        unset($arryDetails['Submit']);
        unset($arryDetails['leadID']);
        unset($arryDetails['main_state_id']);
        unset($arryDetails['main_city_id']);
        unset($arryDetails['state_id']);
        unset($arryDetails['city_id']);
        unset($arryDetails['CreatedDate']);
        
        $unsetArray = array("primary_email","Industry","LastContactDate","ajax_state_id","ajax_city_id");
       foreach($unsetArray as $arr){unset($arryDetails[$arr]);}
        
       foreach($arryDetails as $key=>$values)
       {
           $str.= ''.$key.'="'.addslashes($values).'"'.',';
       }
     
       $strSQLQuery = "update c_opportunity set ".trim($str, ',')." , 
                        Amount=ENCODE('" .addslashes($Amount) . "','".$Config['EncryptKey']."'),
                        forecast_amount=ENCODE('" .addslashes($forecast_amount) . "','".$Config['EncryptKey']."'),  
                        AssignTo='" . addslashes($AssignTo) . "',AssignType = '" . $AssignType . "',
                        CloseDate='" . addslashes($expCloseDate) . "',city_id='" . $main_city_id . "', 			                state_id='" . $main_state_id . "' where OpportunityID='" . $OpportunityID . "'";

	//End//

        $this->query($strSQLQuery, 0);

        return 1;
    }

   function GetOpportunity($OpportunityID, $Status) {
        global $Config;
        $strSQLQuery = "select p.*,DECODE(p.Amount,'". $Config['EncryptKey']."') as Amount,DECODE(p.forecast_amount,'". $Config['EncryptKey']."') as forecast_amount, l.Industry,l.leadID from c_opportunity p left outer join  c_lead  l on p.LeadID = l.leadID";
        $strSQLQuery .= (!empty($OpportunityID)) ? (" where p.OpportunityID='" . $OpportunityID . "'") : (" where 1 ");
        $strSQLQuery .= ($Status > 0) ? (" and p.Status='" . $Status . "'") : ("");
        $strSQLQuery .= " order by p.OpportunityName asc ";

        return $this->query($strSQLQuery, 1);
    }

    function GetOpportunityBrief($OpportunityID, $Status) {
        $strSQLQuery = "select l.OpportunityID, l.OpportunityName from c_opportunity l ";

        $strSQLQuery .= (!empty($OpportunityID)) ? (" where l.OpportunityID='" . $OpportunityID . "'") : (" where 1 ");
        $strSQLQuery .= ($Status > 0) ? (" and l.Status='" . $Status . "'") : ("");

        $strSQLQuery .= " order by OpportunityName asc ";

        return $this->query($strSQLQuery, 1);
    }

    function changeOpportunityStatus($OpportunityID) {
        $sql = "select OpportunityID,Status from c_opportunity where OpportunityID='" . $OpportunityID . "'";
        $rs = $this->query($sql);

        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update c_opportunity set Status='" . $Status . "' where OpportunityID='" . $OpportunityID . "'";
            $this->query($sql, 0);

            return true;
        }
    }

    function RemoveOpportunity($OpportunityID) {



        $strSQLQuery = "delete from c_opportunity where OpportunityID='" . $OpportunityID . "'";
        $this->query($strSQLQuery, 0);



        return 1;
    }

    /*     * *************************Compaign********************* */

    function ListCampaign($id = 0, $SearchKey, $SortBy, $closingdate, $AscDesc='', $SearchStatus='') {
        global $Config;
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where c.campaignID='" . $id . "'") : (" where 1 ");

        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (c.assignedTo='" . $_SESSION['AdminID'] . "' OR c.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strAddQuery .= ($SearchStatus == 'Active') ? (" and c.campaignstatus in ('Active','Planning')") : ("");

        if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . "  = '" . $SearchKey . "')") : ("");
        } else {
            $strAddQuery .= (!empty($SearchKey)) ? (" and ( c.campaignname like '%" . $SearchKey . "%' or c.campaigntype like '%" . $SearchKey . "%' or c.campaignstatus like '%" . $SearchKey . "%' or c.expectedrevenue like '%" . $SearchKey . "%' or closingdate like '%" . $SearchKey . "%' ) " ) : ("");
        }

	$closingdate = DefaultDateFormat($closingdate);

        $strAddQuery .= (!empty($closingdate)) ? (" and ( c.closingdate = '" . $closingdate . "')") : ("");

        //$strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by c.campaignID ");
        //$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" DESC");
if($Config['GetNumRecords']==1){
				$Columns = " count(c.campaignID) as NumCount ";				
			}else{			

			 $strAddQuery .= " group by c.campaignID";
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by c.campaignID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : ("desc");	
				$Columns = "  c.*,d.Department,e.EmpID,e.Role,e.UserName as AssignTo  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

         $strSQLQuery = "select ".$Columns." from c_campaign c left outer join  h_employee e on e.EmpID=c.assignedTo left outer join  h_department d on e.Department=d.depID " . $strAddQuery;



        return $this->query($strSQLQuery, 1);
    }

    function AddCampaign($arryDetails) {

        global $Config;
        extract($arryDetails);

        //if(empty($Status)) $Status=1;
        //By Chetan3Aug//
        $unsetArray = array("campaignID","IContactcampaigntype","ConstantContantcampaigntype","Submit","mailchimpCmpId");
        foreach($unsetArray as $arr){unset($arryDetails[$arr]);}
        
        
        $fields = join(',',array_keys($arryDetails));
        $values = join("','",array_values(array_map(function($arr){ return addslashes($arr);},$arryDetails))); //updated for addslashes on 22Sep2017 by chetan//

        $strSQLQuery = "insert into c_campaign (created_time,$fields) values('" . $Config['TodayDate'] . "','".$values."')" ;    
                                 
        //End//


        $this->query($strSQLQuery, 0);


        /* if($LeadID!=''){
          $strUpSQLQuery = "update c_lead set  Campaign='0' where leadID='".$LeadID."'";


          $this->query($strUpSQLQuery, 0);
          } */



        $CampaignID = $this->lastInsertId();

        if ($assignedTo != '') {

            $strSQLQuery = "select UserName,Email from h_employee where EmpID='" . $assignedTo . "'";
            $arryEmp = $this->query($strSQLQuery, 1);

            $ToEmail = $arryEmp[0]['Email'];
            $CC = $Config['AdminEmail'];

            $assignEmail = $arryEmp[0]['Email'];






            $htmlPrefix = $Config['EmailTemplateFolder'];
            $contents = file_get_contents($htmlPrefix . "CompaignAssigned.htm");
            $subject = "  Assigned to You ";
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[COMNAME]", $campaignname, $contents);
            $contents = str_replace("[COMSTATUS]", $campaignstatus, $contents);


            $contents = str_replace("[COMTYPE]", $campaigntype, $contents);
            $contents = str_replace("[TARGETAUDI]", $targetaudience, $contents);
            $contents = str_replace("[NUMSENT]", $numsent, $contents);
            $contents = str_replace("[BUDGETCOST]", $budgetcost, $contents);
            $contents = str_replace("[ACTUALCOST]", $actualcost, $contents);

            $contents = str_replace("[CLOSEDATE]", date($Config['DateFormat'] . " H:i:s", strtotime($closingdate)), $contents);

            //$contents = str_replace("[COMPANY]",$company,$contents);	
            //$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Campaign [" . $campaignname . "] - " . $subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
#echo $mail->Subject.','.$assignEmail.$contents; exit;  
            if ($Config['Online'] == 1) {
                $mail->Send();
            }
        }
        #echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;

        if (!empty($CampaignID)) {
            //Send Acknowledgment Email to admin
            $htmlPrefix = $Config['EmailTemplateFolder'];
            $contents = file_get_contents($htmlPrefix . "Compaign_Admin.htm");
            $subject = "  Assigned to You ";
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[COMNAME]", $campaignname, $contents);
            $contents = str_replace("[COMSTATUS]", $campaignstatus, $contents);


            $contents = str_replace("[COMTYPE]", $campaigntype, $contents);
            $contents = str_replace("[TARGETAUDI]", $targetaudience, $contents);
            $contents = str_replace("[NUMSENT]", $numsent, $contents);
            $contents = str_replace("[BUDGETCOST]", $budgetcost, $contents);
            $contents = str_replace("[ACTUALCOST]", $actualcost, $contents);

            $contents = str_replace("[CLOSEDATE]", date($Config['DateFormat'] . " H:i:s", strtotime($closingdate)), $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($Config['AdminEmail']);
            $mail->sender($_SESSION['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " -New  Campaign - " . $subject;
            $mail->IsHTML(true);
            //echo $Config['AdminEmail'].$contents; exit;
            $mail->Body = $contents;
            if ($Config['Online'] == 1) {
                $mail->Send();
            }
            #echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;
        }
        return $CampaignID;
    }

    function UpdateCampaign($arryDetails) {

        global $Config;
        extract($arryDetails);
        
        //By Chetan3Aug//
        $unsetArray = array("IContactcampaigntype","ConstantContantcampaigntype","Submit","mailchimpCmpId");
        foreach($unsetArray as $arr){unset($arryDetails[$arr]);}
        
        foreach($arryDetails as $key=>$values)
        {
           $str.= ''.$key.'="'.addslashes($values).'"'.',';
        }
        
        $strSQLQuery = "update c_campaign set ".trim($str, ',')." where campaignID = " . $campaignID;

        //End//


        $this->query($strSQLQuery, 0);

        if ($assignedTo != '') {

            $strSQLQuery = "select UserName,Email from h_employee where EmpID='" . $assignedTo . "'";
            $arryEmp = $this->query($strSQLQuery, 1);

            $ToEmail = $arryEmp[0]['Email'];
            $CC = $Config['AdminEmail'];

            $assignEmail = $arryEmp[0]['Email'];



            $htmlPrefix = $Config['EmailTemplateFolder'];
            $contents = file_get_contents($htmlPrefix . "CompaignAssigned.htm");
            $subject = "  Assigned to You ";
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[COMNAME]", $campaignname, $contents);
            $contents = str_replace("[COMSTATUS]", $campaignstatus, $contents);


            $contents = str_replace("[COMTYPE]", $campaigntype, $contents);
            $contents = str_replace("[TARGETAUDI]", $targetaudience, $contents);
            $contents = str_replace("[NUMSENT]", $numsent, $contents);
            $contents = str_replace("[BUDGETCOST]", $budgetcost, $contents);
            $contents = str_replace("[ACTUALCOST]", $actualcost, $contents);

            $contents = str_replace("[CLOSEDATE]", date($Config['DateFormat'] . " H:i:s", strtotime($closingdate)), $contents);
            //$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Campaign [" . $CampaignName . "][" . $CampaignID . "] - " . $subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            if ($Config['Online'] == 1) {
                $mail->Send();
            }
        }


        return 1;
    }

    function GetCampaign($campaignID, $Status) {
        $strSQLQuery = "select l.* from c_campaign l ";

        $strSQLQuery .= (!empty($campaignID)) ? (" where l.campaignID='" . $campaignID . "'") : (" where 1 ");

        //$strSQLQuery .= ($Status>0)?(" and l.Status='".$Status."'"):("");

        return $this->query($strSQLQuery, 1);
    }

    function GetCampaignBrief($campaignID, $Status) {
        $strSQLQuery = "select l.campaignID, l.campaignname from c_campaign l ";

        $strSQLQuery .= (!empty($campaignID)) ? (" where l.campaignID='" . $campaignID . "'") : (" where 1 ");

        //$strSQLQuery .= ($Status>0)?(" and l.Status='".$Status."'"):("");
        $strSQLQuery .= " order by campaignname asc ";

        return $this->query($strSQLQuery, 1);
    }

    function changeCampaignStatus($campaignID) {
        $sql = "select * from c_campaign where campaignID='" . $campaignID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $Status = 0;
            else
                $Status = 1;

            $sql = "update c_campaign set Status='$Status' where campaignID='" . $campaignID . "'";
            $this->query($sql, 0);

            return true;
        }
    }

    function RemoveCampaign($campaignID) {



        $strSQLQuery = "delete from c_campaign where campaignID='" . $campaignID . "'";
        $this->query($strSQLQuery, 0);



        return 1;
    }

    function RemoveSelectCompaign($sid) {


        $strSQLQuery = "delete from c_compaign_sel  where sid='" . $sid . "'";
        //$strSQLQuery = "delete from c_compaign_sel where campaignID='".$campaignID."'"; 
        $this->query($strSQLQuery, 0);



        return 1;
    }

    function AddMultipleCompaign($arrydetail) {


        extract($arrydetail);
        //print_r($campaignID);

        for ($i = 0; $i < sizeof($ID); $i++) {

            $sql = "select compaignID from c_compaign_sel where compaignID ='" . $ID[$i] . "' and parent_type='" . $parent_type . "' and parentID='" . $parentID . "'";
            $arryRow = $this->query($sql);

            if (sizeof($arryRow) == 0) {

                $strSQLQuery = "insert into c_compaign_sel (compaignID,parent_type,parentID,mode_type ) values('" . $ID[$i] . "','" . addslashes($parent_type) . "','" . addslashes($parentID) . "','" . addslashes($mode_type) . "')";

                $this->query($strSQLQuery, 0);
            }

            //echo $campaignID[$i];
        }

        return true;
    }

    function GetCompaignData($id = 0, $parentType, $mode_type) {
        $strAddQuery = '';
        $strAddQuery .= (!empty($id)) ? (" where c2.parentID='" . $id . "'") : (" where 1 ");
        $strAddQuery .= (!empty($id)) ? (" and c2.parent_type='" . $parentType . "'") : ("  ");
        $strAddQuery .= (!empty($id)) ? (" and c2.mode_type='" . $mode_type . "'") : ("  ");
        $strAddQuery .= ($_SESSION['AdminType'] != "admin") ? (" and c.assignedTo='" . $_SESSION['AdminID'] . "' ") : ("");

        $strAddQuery .= " and c2.deleted='0'";

        $strAddQuery .= " order by c2.sid Desc ";

        $strSQLQuery = "select c.campaignname,c.campaigntype,c.campaignstatus,c.expectedrevenue,c.closingdate,c.assignedTo,e.EmpID,c.campaignID,d.Department, e.Role,e.UserName as AssignTo,c2.sid,c2.parent_type,c2.parentID,c2.mode_type from c_campaign c left outer join  h_employee e on e.EmpID=c.assignedTo left outer join  h_department d on e.Department=d.depID  left outer join  c_compaign_sel c2 on c.campaignID=c2.compaignID  " . $strAddQuery;



        return $this->query($strSQLQuery, 1);
    }

    function GetTicketData($id = 0, $parentType, $mode_type) {
        $strAddQuery = '';
        $strAddQuery .= (!empty($id)) ? (" where c2.parentID='" . $id . "'") : (" where 1 ");
        $strAddQuery .= (!empty($id)) ? (" and c2.parent_type='" . $parentType . "'") : ("  ");
        $strAddQuery .= (!empty($id)) ? (" and c2.mode_type='" . $mode_type . "'") : ("  ");
        $strAddQuery .= ($_SESSION['AdminType'] != "admin") ? (" and (t.AssignedTo='" . $_SESSION['AdminID'] . "' or t.created_id='" . $_SESSION['AdminID'] . "')") : ("");

        $strAddQuery .= " and c2.deleted='0'";

        $strAddQuery .= " order by c2.sid Desc ";

        $strSQLQuery = "select t.title,t.ticketDate,t.TicketID,t.AssignedTo,t.Status,d.Department,e.EmpID,e.Role,e.UserName as AssignTo,c2.sid,c2.parent_type,c2.parentID from c_ticket t left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID  left outer join  c_compaign_sel c2 on t.TicketID=c2.compaignID  " . $strAddQuery;



        return $this->query($strSQLQuery, 1);
    }

    /*     * ****************Reports**************** */

    function LeadReport($arryDetails) {
//$FilterBy,$FromDate,$ToDate,$Month,$Year,$leadID,$source,$Status
        extract($arryDetails);

        $strAddQuery = "";
        if ($fby == 'Year') {
            $strAddQuery .= " and YEAR(l.JoiningDate)='" . $y . "'";
        } else {
		$f = DefaultDateFormat($f);
		$t = DefaultDateFormat($t);
            $strAddQuery .= (!empty($f)) ? (" and l.JoiningDate>='" . $f . "'") : ("");
            $strAddQuery .= (!empty($t)) ? (" and l.JoiningDate<='" . $t . "'") : ("");
        }
        $strAddQuery .= (!empty($w)) ? (" and l.leadID='" . $w . "'") : ("");
        $strAddQuery .= (!empty($lst)) ? (" and l.lead_status='" . $lst . "'") : ("");
        $strAddQuery .= (!empty($lso)) ? (" and l.lead_source='" . $lso . "'") : ("");

        $strSQLQuery = "select  l.JoiningDate,l.leadID,l.FirstName, l.LastName, l.lead_source,l.lead_status,l.type   from c_lead l  where 1 " . $strAddQuery . " order by l.JoiningDate desc";

        return $this->query($strSQLQuery, 1);
    }

    function GetNumLeadByYear($FilterBy, $month, $Year, $FromDate, $ToDate, $leadID, $Source, $Status) {

        $strAddQuery = "";
        if ($FilterBy == 'Year') {
            $strAddQuery .= " and YEAR(a.JoiningDate)='" . $Year . "'";
        } if ($fby == 'Month') {
            $strAddQuery .= " and MONTH(a.JoiningDate)='" . $FromDate . "'";
        } else {
            $strAddQuery .= (!empty($FromDate)) ? (" and a.JoiningDate >= '" . $FromDate . "'") : ("");
            $strAddQuery .= (!empty($ToDate)) ? (" and a.JoiningDate <= '" . $ToDate . "'") : ("");
        }



        $strAddQuery .= (!empty($leadID)) ? (" and a.leadID='" . $leadID . "'") : ("");
        $strAddQuery .= (!empty($Status)) ? (" and a.lead_status='" . $Status . "'") : ("");
        $strAddQuery .= (!empty($Source)) ? (" and a.lead_source='" . $Source . "'") : ("");

        $strSQLQuery = "select count(a.leadID) as TotalLead  from c_lead a where YEAR(a.JoiningDate)='" . $Year . "' " . $strAddQuery . " order by a.JoiningDate desc";

        return $this->query($strSQLQuery, 1);
    }

    function OpportunityReport($arryDetails) {
//$FilterBy,$FromDate,$ToDate,$Month,$Year,$leadID,$source,$Status
        extract($arryDetails);

        $strAddQuery = "";
        if ($fby == 'Year') {
            $strAddQuery .= " and YEAR(p.AddedDate)='" . $y . "'";
        } if ($fby == 'Month') {
            $strAddQuery .= " and MONTH(p.AddedDate)='" . $m . "'";
        } else {
            $strAddQuery .= (!empty($f)) ? (" and p.AddedDate>='" . $f . "'") : ("");
            $strAddQuery .= (!empty($t)) ? (" and p.AddedDate<='" . $t . "'") : ("");
        }
        $strAddQuery .= (!empty($w)) ? (" and p.OpportunityID='" . $w . "'") : ("");
        $strAddQuery .= (!empty($lst)) ? (" and p.lead_source='" . $lst . "'") : ("");
        $strAddQuery .= (!empty($lst)) ? (" and p.SalesStage='" . $lso . "'") : ("");


        $strSQLQuery = "select  p.AddedDate,p.OpportunityID,p.OpportunityName, p.SalesStage, p.lead_source   from c_opportunity p  where 1 " . $strAddQuery . " order by p.AddedDate desc";

        return $this->query($strSQLQuery, 1);
    }

    function GetNumOpportunityByYear($FilterBy, $month, $Year, $FromDate, $ToDate, $Source, $Status) {

        $strAddQuery = "";

        $strAddQuery .= (!empty($FromDate)) ? (" and a.AddedDate >= '" . $FromDate . "'") : ("");
        $strAddQuery .= (!empty($ToDate)) ? (" and a.AddedDate <= '" . $ToDate . "'") : ("");


        $strAddQuery .= (!empty($Source)) ? (" and a.lead_source='" . $Status . "'") : ("");
        $strAddQuery .= (!empty($lst)) ? (" and a.SalesStage='" . $Source . "'") : ("");

        $strSQLQuery = "select count(a.OpportunityID) as TotalOpportunity  from c_opportunity a where YEAR(a.AddedDate)='" . $Year . "' " . $strAddQuery . " order by a.AddedDate desc";

        return $this->query($strSQLQuery, 1);
    }

		function GetAssigneeUser5555555($arrayDetail) {
		$strAddQuery = ($arrayDetail != '') ? (" and  e.EmpID in (" . $arrayDetail . ")") : ("");
		//$strAddQuery .= "and e.Division in (5)"; 
		$strSQLQuery = "select e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  h_department d on e.Department=d.depID  WHERE e.Status='1' " . $strAddQuery;
		return $this->query($strSQLQuery, 1);
		}

 function GetAssigneeUser($EmpIDs) {

				$emID = explode(',',$EmpIDs);
       if(!empty($EmpIDs) && is_numeric($emID[0])){
               $sql = "select e.UserName,e.JobTitle,e.EmpID,d.Department as emp_dep,d.depID from h_employee e left outer join  h_department d on e.Department=d.depID WHERE e.EmpID in (" . $EmpIDs . ")" ;

#if($_GET['sql'] ==1) echo $sql; echo "<pre>"; print_r($emID);
               return $this->query($sql, 1);
       }
   }

    function GetNumTicket($priority) {

        $strSQLQuery = "select count(TicketID) as TotalTicket from c_ticket where 1 ";
        $strSQLQuery .= (!empty($priority)) ? (" and priority = '" . $priority . "'") : ("");


        /* if(!empty($Year)){
          $DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
          $strSQLQuery .= " and JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR ExitDate>'".$DateEnd."')";
          //$strSQLQuery .= " and JoiningDate<='".$DateEnd."' ";
          } */
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    function GetDashboardTicket($limit=7) {
        global $Config;
        $strSQLQuery = "select t.title,t.AssignedTo,t.TicketID,t.AssignType,t.created_id from c_ticket t 
                         where 1 and t.Status in ('Open','In progress')  ";

        #$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (t.AssignedTo like '%".$_SESSION['AdminID']."%'   OR   t.created_id='".$_SESSION['AdminID']."') "):("");

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",t.AssignedTo) OR t.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strSQLQuery .= "  order by  t.TicketID desc limit 0,".$limit;

        //echo $strSQLQuery; 

        return $this->query($strSQLQuery, 1);
    }

    function GetDashboardCompaign($limit=7) {
        global $Config;
        $strSQLQuery = "select c.campaignname,c.assignedTo,c.campaignID,c.created_id from c_campaign c where 1 and c.campaignstatus in ('Active','Planning') ";

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (c.assignedTo = '" . $_SESSION['AdminID'] . "' OR c.created_id='" . $_SESSION['AdminID'] . "') ") : ("");


        $strSQLQuery .= "  order by  c.campaignID desc limit 0,".$limit;

        //echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    
    
    
     /******LEAD FORM***********
    function UpdateLeadWebForm($arryDetails, $HtmlForm){   
                global $Config;
                extract($arryDetails);	
                #$formID=1;
                $sql = "select formID from c_lead_form where formID='".$formID."' ";
                $arryRow = $this->query($sql, 1);
               
                if($arryRow[0]['formID']>0){
                        $strSQLQuery = "update c_lead_form set FormTitle='".mysql_real_escape_string(strip_tags($FormTitle))."', Subtitle='".mysql_real_escape_string(strip_tags($Subtitle))."', Description='".mysql_real_escape_string(strip_tags($Description))."', AssignTo='".mysql_real_escape_string(strip_tags($AssignTo))."', ExtraInfo='".mysql_real_escape_string(strip_tags($ExtraInfo))."', Campaign='".mysql_real_escape_string(strip_tags($Campaign))."', ActionUrl='".mysql_real_escape_string(strip_tags($ActionUrl))."', HtmlForm='".addslashes($HtmlForm)."', LeadColumn='".addslashes($LeadColumn)."', UpdatedDate='".$Config['TodayDate']."', RoleGroup='".$RoleGroup."',FormType ='".$FormType."' where formID='".mysql_real_escape_string($formID)."'" ;
$this->query($strSQLQuery, 0);	
                }else{
                        $strSQLQuery = "insert into c_lead_form (FormTitle, Subtitle, Description, AssignTo, ExtraInfo, Campaign, ActionUrl, HtmlForm, UpdatedDate,LeadColumn,RoleGroup,FormType ) values('".mysql_real_escape_string($FormTitle)."', '".mysql_real_escape_string(strip_tags($Subtitle))."', '".mysql_real_escape_string(strip_tags($Description))."','".mysql_real_escape_string(strip_tags($AssignTo))."', '".mysql_real_escape_string(strip_tags($ExtraInfo))."', '".mysql_real_escape_string(strip_tags($Campaign))."', '".mysql_real_escape_string($ActionUrl)."', '".addslashes($HtmlForm)."', '".$Config['TodayDate']."', '".addslashes($LeadColumn)."' , '".addslashes($RoleGroup)."','".$FormType."')";
$this->query($strSQLQuery, 0);	

 $lastID = $this->lastInsertId();
return $lastID;	
                }     

                return 1;

     }*/
function UpdateLeadWebForm($arryDetails, $HtmlForm){   
                global $Config;
                extract($arryDetails);	
                #$formID=1;
                $formID = !empty($arryDetails['formID'])?$arryDetails['formID']:0;
                $LeadColumn = implode(',', $arryDetails['columnTo']);
                $sql = "select formID from c_lead_form where formID='".$formID."' ";
                $arryRow = $this->query($sql, 1);
                $RoleGroupNew = implode(',', $arryDetails['columnTo1']);
                if($arryRow[0]['formID']>0){
                        $strSQLQuery = "update c_lead_form set FormTitle='".mysql_real_escape_string(strip_tags($FormTitle))."', Subtitle='".mysql_real_escape_string(strip_tags($Subtitle))."', Description='".mysql_real_escape_string(strip_tags($Description))."', AssignTo='".mysql_real_escape_string(strip_tags($AssignTo))."', ExtraInfo='".mysql_real_escape_string(strip_tags($ExtraInfo))."', Campaign='".mysql_real_escape_string(strip_tags($Campaign))."', ActionUrl='".mysql_real_escape_string(strip_tags($ActionUrl))."', HtmlForm='".addslashes($HtmlForm)."', LeadColumn='".addslashes($LeadColumn)."', UpdatedDate='".$Config['TodayDate']."', RoleGroup='".$RoleGroup."',FormType ='".$FormType."',RoleGroupNew ='".$RoleGroupNew."'  where formID='".mysql_real_escape_string($formID)."'" ;
						$this->query($strSQLQuery, 0);	
							return $formID;
					    }else{
					        $strSQLQuery = "insert into c_lead_form (FormTitle, Subtitle, Description, AssignTo, ExtraInfo, Campaign, ActionUrl, HtmlForm, UpdatedDate,LeadColumn,RoleGroup,FormType,RoleGroupNew ) values('".mysql_real_escape_string($FormTitle)."', '".mysql_real_escape_string(strip_tags($Subtitle))."', '".mysql_real_escape_string(strip_tags($Description))."','".mysql_real_escape_string(strip_tags($AssignTo))."', '".mysql_real_escape_string(strip_tags($ExtraInfo))."', '".mysql_real_escape_string(strip_tags($Campaign))."', '".mysql_real_escape_string($ActionUrl)."', '".addslashes($HtmlForm)."', '".$Config['TodayDate']."', '".addslashes($LeadColumn)."' , '".addslashes($RoleGroup)."','".$FormType."','".$RoleGroupNew."')";
							$this->query($strSQLQuery, 0);	
							$lastID = $this->lastInsertId();
							return $lastID;	
					    }     
     }
    
    function GetLeadWebForm($formID) {
        global $Config;
        $strSQLQuery = "select * from c_lead_form where formID='".$formID."' ";
        return $this->query($strSQLQuery, 1);
    }    
        
        
    /***********************/
 function SearchCRMOld($key,$module){
	$SearchKey = strtolower(trim($key));

	//$LeadSql = "select 'Lead' as Section, '1' as OrderCol, leadID as SectionID, LeadName as Heading, LandlineNumber as Phone from c_lead where Opportunity=0 and LeadName like '%".$SearchKey."%'";

$LeadSql = "select 'Lead' as Section, '1' as OrderCol, leadID as SectionID, LeadName as Heading, LandlineNumber as Phone from c_lead where Opportunity=0   and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",AssignTo) OR created_id='" . $_SESSION['AdminID'] . "') and  LeadName like '%".$SearchKey."%'";

	$OppSql = "select 'Opportunity' as Section, '2' as OrderCol, OpportunityID as SectionID, o.OpportunityName  as Heading, l.LandlineNumber as Phone from c_opportunity o left outer join c_lead l on l.leadID=o.LeadID where o.OpportunityName like '%".$SearchKey."%' ";

	$TicketSql = "select 'Ticket' as Section, '3' as OrderCol, TicketID as SectionID, title as Heading, '' as Phone from c_ticket where title like '%".$SearchKey."%'";

	$ContactSql = "select 'Contact' as Section, '4' as OrderCol, AddID as SectionID, FullName as Heading, Landline as Phone from s_address_book where CrmContact=1 and AddType='contact' and FullName like '%".$SearchKey."%' and (AssignTo='".$_SESSION['AdminID']."' OR AdminID='".$_SESSION['AdminID']."')";

	$QuoteSql = "select 'Quote' as Section, '5' as OrderCol, quoteid as SectionID, subject as Heading, '' as Phone from c_quotes where subject like '%".$SearchKey."%'";

	$EventSql = "select 'Event' as Section, '6' as OrderCol, activityID as SectionID, subject as Heading, '' as Phone from c_activity where subject like '%".$SearchKey."%' and  (FIND_IN_SET(" . $_SESSION['AdminID'] . ",assignedTo) OR created_id='" . $_SESSION['AdminID'] . "')";

	$DocSql = "select 'Document' as Section, '7' as OrderCol, documentID as SectionID, title as Heading, '' as Phone from c_document where title like '%".$SearchKey."%'";

	$CampaignSql = "select 'Campaign' as Section, '8' as OrderCol, campaignID as SectionID, campaignname as Heading, '' as Phone from c_campaign where campaignname like '%".$SearchKey."%' and (assignedTo='" . $_SESSION['AdminID'] . "' OR created_id='" . $_SESSION['AdminID'] . "') ";

	$CustomerSql = "select 'Customer' as Section, '9' as OrderCol, Cid as SectionID,  IF(Company='', concat(FirstName, ' ', LastName), Company)  as Heading, Landline as Phone from s_customers where FullName like '%".$SearchKey."%' OR FirstName like '%".$SearchKey."%' OR Company like '%".$SearchKey."%'";

	switch($module){
		case 'Lead': $strSQLQuery = $LeadSql; break;
		case 'Opportunity': $strSQLQuery = $OppSql; break;
		case 'Ticket': $strSQLQuery = $TicketSql; break;
		case 'Contact': $strSQLQuery = $ContactSql; break;	
		case 'Quotes': $strSQLQuery = $QuoteSql; break;
		case 'Calendar': $strSQLQuery = $EventSql; break;
		case 'Document': $strSQLQuery = $DocSql; break;
		case 'Campaign': $strSQLQuery = $CampaignSql; break;
		case 'Customer': $strSQLQuery = $CustomerSql;

 break;			
	}


	if(empty($module)){
       	 $strSQLQuery = "(".$LeadSql.") UNION (".$OppSql.") UNION (".$TicketSql.") UNION (".$ContactSql.") UNION (".$QuoteSql.") UNION (".$EventSql.") UNION (".$DocSql.") UNION (".$CampaignSql.") UNION (".$CustomerSql.") order by OrderCol asc, Heading asc";
	}


        return $this->query($strSQLQuery, 1);
    } 



    function SearchCRM($key,$module){
	$SearchKey = strtolower(trim($key));

	//$LeadAdd = and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",AssignTo) OR created_id='" . $_SESSION['AdminID'] . "');
$LeadSql = "select 'Lead' as Section, '1' as OrderCol, leadID as SectionID, LeadName as Heading, LandlineNumber as Phone, company as CompanyName from c_lead where Opportunity=0  and  (LeadName like '%".$SearchKey."%' or company like '%".$SearchKey."%')";

	$OppSql = "select 'Opportunity' as Section, '2' as OrderCol, OpportunityID as SectionID, o.OpportunityName  as Heading, l.LandlineNumber as Phone, l.company as CompanyName from c_opportunity o left outer join c_lead l on l.leadID=o.LeadID where o.OpportunityName like '%".$SearchKey."%' ";

	$TicketSql = "select 'Ticket' as Section, '3' as OrderCol, TicketID as SectionID, title as Heading, '' as Phone,'' as CompanyName from c_ticket where title like '%".$SearchKey."%'";

	#$ContactAdd = " and (AssignTo='".$_SESSION['AdminID']."' OR AdminID='".$_SESSION['AdminID']."')";
	$ContactSql = "select 'Contact' as Section, '4' as OrderCol, AddID as SectionID, FullName as Heading, Landline as Phone,'' as CompanyName from s_address_book where CrmContact=1 and AddType='contact' and FullName like '%".$SearchKey."%' ";

	$QuoteSql = "select 'Quote' as Section, '5' as OrderCol, quoteid as SectionID, subject as Heading, '' as Phone,'' as CompanyName from c_quotes where subject like '%".$SearchKey."%'";


	#$EventAdd = "and  (FIND_IN_SET(" . $_SESSION['AdminID'] . ",assignedTo) OR created_id='" . $_SESSION['AdminID'] . "')";
	$EventSql = "select 'Event' as Section, '6' as OrderCol, activityID as SectionID, subject as Heading, '' as Phone,'' as CompanyName from c_activity where subject like '%".$SearchKey."%' ";

	$DocSql = "select 'Document' as Section, '7' as OrderCol, documentID as SectionID, title as Heading, '' as Phone,'' as CompanyName from c_document where title like '%".$SearchKey."%'";

	#$CampaignAdd = "and (assignedTo='" . $_SESSION['AdminID'] . "' OR created_id='" . $_SESSION['AdminID'] . "')";
	$CampaignSql = "select 'Campaign' as Section, '8' as OrderCol, campaignID as SectionID, campaignname as Heading, '' as Phone,'' as CompanyName from c_campaign where campaignname like '%".$SearchKey."%'  ";

	$CustomerSql = "select 'Customer' as Section, '9' as OrderCol, Cid as SectionID,  IF(Company='', concat(FirstName, ' ', LastName), Company)  as Heading, Landline as Phone,'' as CompanyName from s_customers where FullName like '%".$SearchKey."%' OR FirstName like '%".$SearchKey."%' OR Company like '%".$SearchKey."%'";

	switch($module){
		case 'Lead': $strSQLQuery = $LeadSql; break;
		case 'Opportunity': $strSQLQuery = $OppSql; break;
		case 'Ticket': $strSQLQuery = $TicketSql; break;
		case 'Contact': $strSQLQuery = $ContactSql; break;	
		case 'Quotes': $strSQLQuery = $QuoteSql; break;
		case 'Calendar': $strSQLQuery = $EventSql; break;
		case 'Document': $strSQLQuery = $DocSql; break;
		case 'Campaign': $strSQLQuery = $CampaignSql; break;
		case 'Customer': $strSQLQuery = $CustomerSql;

 break;			
	}


	if(empty($module)){
	       	 $strSQLQuery = "(".$LeadSql.") UNION (".$OppSql.") UNION (".$TicketSql.") UNION (".$ContactSql.") UNION (".$QuoteSql.") UNION (".$EventSql.") UNION (".$DocSql.") UNION (".$CampaignSql.") UNION (".$CustomerSql.") order by OrderCol asc, Heading asc";

		
	} 

	if(!empty($strSQLQuery)){
		return $this->query($strSQLQuery, 1);
	}
        
    } 
    
    


function LeadReportByRating($arryDetails) 
     {
//$FilterBy,$FromDate,$ToDate,$Month,$Year,$leadID,$source,$Status
        extract($arryDetails);
        $strAddQuery = "";
        if ($fby == 'Year')
         {
        
            $strAddQuery .= " and YEAR(l.LeadDate)='" . $y . "'";
        } 
        else 
        {
		$f = DefaultDateFormat($f);
		$t = DefaultDateFormat($t);

            $strAddQuery .= (!empty($f)) ? (" and l.LeadDate>='" . $f . "'") : ("");
            $strAddQuery .= (!empty($t)) ? (" and l.LeadDate<='" . $t . "'") : ("");
        }
       // $strAddQuery .= (!empty($w)) ? (" and l.leadID='" . $w . "'") : ("");
      //  $strAddQuery .= (!empty($lst)) ? (" and l.lead_status='" . $lst . "'") : ("");
       // $strAddQuery .= (!empty($lso)) ? (" and l.lead_source='" . $lso . "'") : ("");
  //$strSQLQuery .= 'where 1 ';
             $strAddQuery .= " and (l.Industry)!='" ." ". "'";
         // $strSQLQuery = "select l.LeadDate as LeadDate,l.leadID,l.FirstName, l.LastName, l.Industry,l.Rating from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery." order by l.Rating desc";
        $strSQLQuery = "select  l.LeadDate ,l.leadID,l.FirstName, l.LastName, l.Industry,l.Rating   from c_lead l  where 1 " . $strAddQuery . " order by l.Rating desc";
        return $this->query($strSQLQuery, 1);
    }
    
      function LearReportBysalesperson($arryDetails) 
      {
       
         extract($arryDetails);
       // echo"<pre>";   print_r($arryDetails);
     // echo $fby;exit;
       $strAddQuery = "";
        if ($fby == 'Year') 
        {
            
            $strAddQuery .= " where 1 and YEAR(l.LeadDate)='" . $y . "'";
        }
         else 
         {
		$f = DefaultDateFormat($f);
		$t = DefaultDateFormat($t);

            $strAddQuery .= (!empty($f)) ? (" where 1 and l.LeadDate>='" . $f . "'") : ("");
            $strAddQuery .= (!empty($t)) ? (" and l.LeadDate<='" . $t . "'") : ("");
        }
           //  $strAddQuery .= 'where 1 ';
             $strAddQuery .= " and (e.FirstName)!='" ."". "'";
        
        
       
       // $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery;
          $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery." order by l.Rating desc";
      
        return $this->query($strSQLQuery, 1);
    }
    
     function LearReportByAnnualRevenue($arryDetails) 
      {
      
         extract($arryDetails);
         global $Config;
         $strAddQuery = "";
         
     //   $strAddQuery .= 'where 1 ';
        if ($fby=='Year') 
        {
        
         $strAddQuery .= " where 1 and YEAR(l.LeadDate)='" . $y . "'";
        }
        
         else
          {
		$f = DefaultDateFormat($f);
		$t = DefaultDateFormat($t);

            $strAddQuery .= (!empty($f)) ? (" where 1 and l.LeadDate>='" . $f . "'") : ("");
            $strAddQuery .= (!empty($t)) ? (" and l.LeadDate<='" . $t . "'") : ("");
          }
          
           $strAddQuery .= "and(l.AnnualRevenue)!=' '";
        
         // echo  $strSQLQuery;exit;
       
       // $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery;
          $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role, DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."') as AnnualRevenue from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery." order by l.Rating desc";
       
          //echo  $strSQLQuery; 
          
        return $this->query($strSQLQuery, 1);
    
    }


   function LearReportByTerritory($arryDetails) 
      {
      
         extract($arryDetails);
         global $Config;
         $strAddQuery = "";
         
     //   $strAddQuery .= 'where 1 ';
        if ($fby=='Year') 
        {
        
         $strAddQuery .= " where 1 and YEAR(l.LeadDate)='" . $y . "'";
        }
        
         else
          {
		$f = DefaultDateFormat($f);
		$t = DefaultDateFormat($t);

            $strAddQuery .= (!empty($f)) ? (" where 1 and l.LeadDate>='" . $f . "'") : ("");
            $strAddQuery .= (!empty($t)) ? (" and l.LeadDate<='" . $t . "'") : ("");
          }
          
           $strAddQuery .= "and(l.CountryName)!=' '";
        
         // echo  $strSQLQuery;exit;
       

       // $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery;

           $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role, DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."') as AnnualRevenue from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery." order by l.Rating desc";
       
     
        return $this->query($strSQLQuery, 1);
    
    }

    



	function GetLeadImport()  {
		$strSQLQuery ="SELECT * FROM c_lead_import where AdminID = '".$_SESSION['AdminID']."' and AdminType='".$_SESSION['AdminType']."'";
		return $this->query($strSQLQuery, 1);
	}

      	function updateLeadImport($arryDetails){
         	extract($arryDetails);
		$arryRow = $this->GetLeadImport();
		$count=sizeof($arryRow);
		if($count>0)
       		{
		
		  	$strSQLQuery = "UPDATE `c_lead_import` SET FirstName ='".$FirstName."',LastName ='".$LastName."',company ='".$company."',primary_email='".$primary_email."',LandlineNumber='".$LandlineNumber."',designation ='".$designation."',ProductID='".$ProductID."',product_price='".$product_price."',Website='".$Website."',Address ='".$Address."',ZipCode='".$ZipCode."',OtherCity='".$OtherCity."',OtherState ='".$OtherState."',Country='".$Country."',Mobile='".$Mobile."',Industry='".$Industry."',AnnualRevenue='".$AnnualRevenue."',NumEmployee='".$NumEmployee."',lead_source='".$lead_source."',lead_status ='".$lead_status."',description='".$description."' where AdminID = '".$_SESSION['AdminID']."' and        AdminType='".$_SESSION['AdminType']."'";
			$this->query($strSQLQuery, 0);
		}
		else
		{
		  $strSQLQuery = "insert into c_lead_import(FirstName,LastName,company,primary_email, LandlineNumber,designation,ProductID,product_price,Website,Address, ZipCode, OtherCity, OtherState,Country,Mobile, Industry,AnnualRevenue,NumEmployee, lead_source,  lead_status, description,AdminID,AdminType)values('".addslashes($FirstName)."','" . addslashes($LastName) . "','" . addslashes($company) . "', '" . addslashes($primary_email) . "','" . addslashes($LandlineNumber) . "', '" . addslashes($designation) . "','" . addslashes($ProductID). "','" . addslashes($product_price) . "', '" . addslashes($Website) . "', '" . addslashes($Address) . "',  '" . $ZipCode. "', '" . $OtherCity. "','" . addslashes($OtherState) . "', '" .addslashes($Country)."', '" . addslashes($Mobile) . "','" . addslashes($Industry) . "','" . addslashes($AnnualRevenue) . "','" . addslashes($NumEmployee) . "',  '" . $lead_source. "',  '" . addslashes($lead_status) . "', '" . addslashes($description). "','".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."')";
      
			$this->query($strSQLQuery,0);
		}
		return;

	}
	


/************ Created By Abid 29 june, 2015 for creating and assigning folder Name to documents *****/

    function ListDocumentFolder() {
           $strSQLQuery = "select * from c_document_folder order by FolderName asc";
 return $this->query($strSQLQuery,1);
    }


   function AddDocumentFolder($arryDetails) {

          extract($arryDetails);
            $strSQLQuery = "insert into c_document_folder(FolderName,Status) values('".addslashes($arryDetails['FolderName'])."','".addslashes($arryDetails['Status'])."')";

          return $this->query($strSQLQuery, 1);
      
    }

	         
function UpdateDocumentFolder($arryDetails) {

        extract($arryDetails);

         $strSQLQuery = "update c_document_folder set FolderName = '" . addslashes($arryDetails['FolderName']) . "',Status='".addslashes($arryDetails['Status'])."' where FolderID='" . $arryDetails['FolderID'] . "'";

        $this->query($strSQLQuery, 0);
        return 1;


    }
 function RemoveDocumentFolder($FolderID) {

         $strSQLQuery = "delete from c_document_folder where FolderID='" . $FolderID . "'";

        $this->query($strSQLQuery, 0);
        return 1;
    }

 function  EditDocumentFolder($FolderID)
{
 $sql = "select * from c_document_folder where FolderID='".$FolderID."'"; 
	return $this->query($sql, 1);	
}
 
   function ChangeDocumentFolderStatus($FolderID) {

        $sql = "select * from c_document_folder where FolderID='" . $FolderID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 1)
                $status = 0;
            else
                $status = 1;

            $sql = "update c_document_folder set Status='" . $status . "' where FolderID='" . $FolderID . "'";
            $this->query($sql, 0);

            return true;
        }
  }


function  GetDocumentFolderName()
		{
			
			$strSQLQuery = "SELECT * FROM c_document_folder where Status='1' order by FolderName asc";
			
			return $this->query($strSQLQuery, 1);

		}

 function CheckDocumentFolderName($FolderName,$FolderID = 0) {
        $strAddQuery = (!empty($FolderID)) ? (" and FolderID != '" . $FolderID. "'") : ("");
        $strSQLQuery = "select FolderID,Foldername from c_document_folder where FolderName='" . $FolderName . "' ". $strAddQuery;
        $arryRow1 = $this->query($strSQLQuery, 1);

        if (!empty($arryRow1[0]['FolderID'])) {
            return true;
        } else {
            return false;
        } exit;
    }


 /************ End code . creating and assigning folder Name to documents *****/

//Bhoodev For flag function Lead,Opportunity,Ticket
function addFlag($arryDetails){  //Lead

extract($arryDetails);
             $sql = "select FlagType from c_lead where leadID='" . $LeadID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['FlagType'] == 'No')
                $FlagTypeInfo = 'Yes';
            else
                $FlagTypeInfo = 'No';

             $sqlUpdate = "update c_lead set FlagType='" . $FlagTypeInfo . "' where leadID='" . $LeadID . "'"; 
            $this->query($sqlUpdate, 0);


  $sqlFlag = "select FlagType from c_lead where leadID='" . $LeadID . "'";
        $res = $this->query($sql);

            return $res[0]['FlagType'];
        }

}


function addOppFlag($arryDetails){  //Opportunity

extract($arryDetails);
             $sql = "select FlagType from c_opportunity where OpportunityID='" . $ID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['FlagType'] == 'No')
                $FlagTypeInfo = 'Yes';
            else
                $FlagTypeInfo = 'No';

             $sqlUpdate = "update c_opportunity set FlagType='" . $FlagTypeInfo . "' where OpportunityID='" . $ID . "'"; 
            $this->query($sqlUpdate, 0);


  $sqlFlag = "select FlagType from c_opportunity where OpportunityID='" . $ID . "'";
        $res = $this->query($sql);

            return $res[0]['FlagType'];
        }

}

function addTicketFlag($arryDetails){  //Opportunity

extract($arryDetails);
             $sql = "select FlagType from c_ticket where TicketID='" . $ID . "'";
        $rs = $this->query($sql);
        if (sizeof($rs)) {
            if ($rs[0]['FlagType'] == 'No')
                $FlagTypeInfo = 'Yes';
            else
                $FlagTypeInfo = 'No';

             $sqlUpdate = "update c_ticket set FlagType='" . $FlagTypeInfo . "' where TicketID='" . $ID . "'"; 
            $this->query($sqlUpdate, 0);


  $sqlFlag = "select FlagType from c_ticket where TicketID='" . $LeadID . "'";
        $res = $this->query($sql);

            return $res[0]['FlagType'];
        }

}

/// ENd Flag 

function DocumentAssignToFolder( $FolderID,$documentID)
{
 $strSQLQuery = "update c_document set  FolderID='" . $FolderID . "' where documentID='" . $documentID. "'";

        $this->query($strSQLQuery, 0);
        return 1;
}

function CountDocument($FolderID) {
	$select_qry = "select COUNT(documentID) as totalDoc from c_document where FolderID='" . $FolderID . "' ";

	$arryRow = $this->query($select_qry, 1);

	if($arryRow[0]['totalDoc'] > 0) {
		return $arryRow[0]['totalDoc'];
	}
 }

//ad by bhoodev update by chetan 3DEc//
function ConvertQuote($arryDetails){


global $Config;
     
		@extract($arryDetails);
$CreatedBy = $_SESSION['UserName'];
				$AdminID = $_SESSION['AdminID'];
				$AdminType = $_SESSION['AdminType'];
                                $opportunityID = $opportunityID;
$CustomerCurrency =  $Config['Currency'];

$LeadRes = $this->GetLead($LeadID);
$objField = new field();
$Quotfields = $objField->getFormField('',22,1);
$Leadfields = $objField->getFormField('',1,1);
$QuotfieldsName = array_filter(array_map(function($arr){if($arr['editable'] == 1) { return $arr['fieldname']; }},$Quotfields));
$LeadfieldsName = array_filter(array_map(function($arr){if($arr['editable'] == 1){return $arr['fieldname'];}},$Leadfields));
$MatchFields = array_intersect($LeadfieldsName,$QuotfieldsName);

 foreach($MatchFields as $val){         
     $queryStr .= ','.$val.' = "'.$LeadRes[0][$val].'"';
 }





 if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                        
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}	
			$sql = "INSERT INTO c_quotes SET EntryType='".$EntryType."',
						EntryInterval='".$EntryInterval."',
						EntryMonth='".$EntryMonth."', 
						EntryWeekly = '".$EntryWeekly."',    
						EntryFrom='".$EntryFrom."',
						EntryTo='".$EntryTo."',
						EntryDate='".$EntryDate."', 
						subject = '".$subject."',
						opportunityName = '".$OpportunityName."',
						OpportunityID = '".$opportunityID."',
						CustType='".addslashes($CustType)."',
						CustCode='".addslashes($CustCode)."',
						CustID='".addslashes($CustID)."',
						CustomerName='".addslashes($CustomerName)."',
						CustomerCompany='".addslashes($CustomerCompany)."',
						ShippingName='".addslashes($ShippingName)."',
						ShippingCompany='".addslashes($ShippingCompany)."',
						quotestage='".addslashes($quotestage)."',
						CustomerCurrency = '".addslashes($CustomerCurrency)."',
						PostedDate   = '".$Config['TodayDate']."',
						validtill ='".$validtill."'$queryStr";
			$this->query($sql, 0); 
		$lastInsertId = $this->lastInsertId();

if(!empty($lastInsertId)){

         
		

		  /********************OPPORTUNITY ADDED ******/

					if($opportunityID!=''){
							  $sqlOppAdd="insert into c_quote_opp  (quoteID,opportunityName,opportunityID,mode_type) values(  '".addslashes($lastInsertId)."','".addslashes($opportunityName)."','".addslashes($opportunityID)."','Quote')";
                                                          $this->query($sqlOppAdd, 0);
					}

		  /************End Opportunity**************/

		
		}

		return $lastInsertId;


}

//By chetan 3Dec//
	function convertOpportunity($arryDetails){
			global $Config;
		@extract($arryDetails);
    
		 if (empty($Status))
            $Status = 1;
        
        $expCloseDate = $CloseDate . ' ' . $CloseTime;

        $ipaddress = GetIPAddress();
		  if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
            $AssignType = 'User';
        }

       if($Status=0 && !empty($Status)){ $Status=1;}
	
	//Start//
	$LeadRes = $this->GetLead($LeadID);
       
       $objField = new field();
       $Oppfields = $objField->getFormField('',4,1);
       $Leadfields = $objField->getFormField('',1,1);
       $OppfieldsName = array_filter(array_map(function($arr){if($arr['editable'] == 1) { return $arr['fieldname']; }},$Oppfields));
       $LeadfieldsName = array_filter(array_map(function($arr){if($arr['editable'] == 1){return $arr['fieldname'];}},$Leadfields));
       $MatchFields = array_intersect($LeadfieldsName,$OppfieldsName);
       
        foreach($MatchFields as $val){         
            $queryStr .= ','.$val;
            $valStr .= ",".'"'.$LeadRes[0][$val].'"';
        }



        $strSQLQuery = "insert into c_opportunity ( LeadID,OpportunityName,Amount,OrgName,AssignTo,AssignType,GroupID,CloseDate,lead_source,SalesStage,OpportunityType,NextStep,description,Probability,Campaign_Source,ContactName,AddedDate,forecast_amount,oppsite,Status, CustID, Currency, Address, country_id,city_id, state_id, ZipCode, Mobile, LandlineNumber, OtherState, OtherCity,  CountryName,  StateName, CityName".$queryStr.") values( '" . $LeadID . "', '" . addslashes($OpportunityName) . "',ENCODE('" .addslashes($Amount) . "','".$Config['EncryptKey']."'),'" . addslashes($OrgName) . "', '" . addslashes($AssignTo) . "','" . addslashes($AssignType) . "','" . addslashes($GroupID) . "', '" . addslashes($expCloseDate) . "', '" . addslashes($lead_source) . "',  '" . addslashes($SalesStage) . "','" . addslashes($OpportunityType) . "','" . addslashes($NextStep) . "','" . addslashes($LeadRes[0]['description']) . "','" . addslashes($Probability) . "',  '" . addslashes($Campaign_Source) . "', '" . addslashes($ContactName) . "',  '" . $Config['TodayDate'] . "',ENCODE('" .addslashes($forecast_amount) . "','".$Config['EncryptKey']."'),'" . addslashes($oppsite) . "','1','" . $CustID . "','" . $Currency . "','" . addslashes($LeadRes[0]['Address']) . "','" . addslashes($LeadRes[0]['country_id']) . "','" . addslashes($LeadRes[0]['city_id']) . "','" . addslashes($LeadRes[0]['state_id']) . "','" . addslashes($LeadRes[0]['ZipCode']) . "','" . addslashes($LeadRes[0]['Mobile']) . "','" . addslashes($LeadRes[0]['LandlineNumber']) . "','" . addslashes($LeadRes[0]['OtherState']) . "','" . addslashes($LeadRes[0]['OtherCity']) . "','" . addslashes($LeadRes[0]['CountryName']) . "','" . addslashes($LeadRes[0]['StateName']) . "','" . addslashes($LeadRes[0]['CityName']) . "'".$valStr.")";//updated for description and address header col on 22jan2017 by chetan//
	//End//


        $this->query($strSQLQuery, 0);
		$oppID = $this->lastInsertId();
		return $oppID;


	}
//End//
function addConvertContact($arryDetails,$CustID,$AddType)
		{
			global $Config;
			extract($arryDetails);		

			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			$FullName = $FirstName." ".$LastName;
			$IpAddress = GetIPAddress(); 
			if($Status=='') $Status=1;
			$LeadRes = $this->GetLead($LeadID);
			$strSQLQuery = "INSERT INTO s_address_book set CustID = '".$CustID."', AddType='".$AddType."', PrimaryContact = '".$PrimaryContact."', CrmContact = '1', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($LeadRes[0]['Address'])."', city_id='".$LeadRes[0]['city_id']."', state_id='".$LeadRes[0]['state_id']."', ZipCode='".mysql_real_escape_string($LeadRes[0]['ZipCode'])."', country_id='".$LeadRes[0]['country_id']."', Mobile='".mysql_real_escape_string($LeadRes[0]['Mobile'])."', Email='".mysql_real_escape_string($Email)."', PersonalEmail='".mysql_real_escape_string($PersonalEmail)."',  Landline='".mysql_real_escape_string($LeadRes[0]['LandlineNumber'])."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($LeadRes[0]['OtherState'])."' ,OtherCity='".mysql_real_escape_string($LeadRes[0]['OtherCity'])."', CreatedDate = '".$Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."', AdminID = '".$_SESSION['AdminID']."', AdminType = '".$_SESSION['AdminType']."', CreatedBy = '".addslashes($_SESSION['UserName'])."',Title='".mysql_real_escape_string($LeadRes[0]['designation'])."',Department='".mysql_real_escape_string($Department)."',LeadSource='".mysql_real_escape_string($LeadRes[0]['lead_source'])."',AssignTo='".addslashes($AssignTo)."',Reference='".mysql_real_escape_string($Reference)."', DoNotCall='".mysql_real_escape_string($DoNotCall)."', NotifyOwner='".mysql_real_escape_string($NotifyOwner)."', EmailOptOut='".mysql_real_escape_string($EmailOptOut)."', Description='".mysql_real_escape_string($Description)."' , Status='".mysql_real_escape_string($Status)."',CountryName='".addslashes($LeadRes[0]['CountryName'])."',  StateName='".addslashes($LeadRes[0]['StateName'])."',  
			CityName='".addslashes($LeadRes[0]['CityName'])."',
			RigisterType = '".$RigisterType."',
			RigisterTypeID = '".$RigisterTypeID."',
			FacebookID = '".$FacebookID."',
			TwitterID = '".$TwitterID."',
            LinkedinID = '".$LinkedinID."',
			InstagramID = '".$InstagramID."',
			GoogleID = '".$GoogleID."'";
			
			#echo $strSQLQuery;die;

			$this->query($strSQLQuery, 0);

			$AddID = $this->lastInsertId();

			return $AddID;

		}

function ListCreateLead($arrayDetails) {
        global $Config;
        extract($arrayDetails);
        $strAddQuery = " where 1 ";
        $SearchKey = strtolower(trim($key));
        $SortBy = $sortby;

         if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
        } 

		if(isset($_GET['type']) && $_GET['type']=='meetingLead') $strAddQuery .= " and ExtraInfo='Meeting'";
		else $strAddQuery .= " and ExtraInfo!='Meeting'";
        /*$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",t.AssignedTo) OR t.created_id='" . $_SESSION['AdminID'] . "') ") : ("");*/

       

        $strAddQuery .= (!empty($FormType)) ? (" and FormType='".$FormType."' ") : (" ");
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by formID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");
		$OrderBy = (isset($OrderBy) && $OrderBy!='') ? $OrderBy : '';
        $strSQLQuery = "select * from c_lead_form  " . $strAddQuery . $OrderBy;

        return $this->query($strSQLQuery, 1);
    }
function RemoveLeadForm($formID) {

         $strSQLQuery = "delete from c_lead_form where formID='" . $formID . "'";

        $this->query($strSQLQuery, 0);
        return 1;
    }

     function SendTicketNotification($arryDetails) {
        $objConfigure = new configure();
        global $Config;


        extract($arryDetails);

       
 	if ($CustID != '') {
            $strSQLQuery = "SELECT FullName as CustomerName, CustCode, Company as CustomerCompany,Email from s_customers where Cid ='".$CustID."'";
            //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
            $arryCust = $this->query($strSQLQuery, 1);
            
            $CustEmail = $arryCust[0]['Email'];
            $CustomerName = $arryCust[0]['CustomerName'];
        }

	if($_SESSION['AdminType'] == "employee" && empty($AssignUser)) {
            $AssignUser = $_SESSION['AdminID'];
            $AssignType = 'User';
        }




        $htmlPrefix = $Config['EmailTemplateFolder'];
        $ipaddress = GetIPAddress();


	if($RelatedType == 'Lead'){
		$Related = $LeadID;
	}else if($RelatedType == 'Opportunity'){
		$Related = $OpprtunityID;
	}else if($RelatedType == 'Campaign'){
		$Related = $CampaignID;
	}else if($RelatedType == 'Quote'){
		$Related = $QuoteID;
	}






        if ($CustID != '' && $sendnotification ==1 && ($notifications == $Status || $notifications == 'All')) {

	//By Chetan on aug21,2017//
	$objCustomer = new Customer();
	$arrRes = $objCustomer->GetAddressBook($contact_id);
	$contNum = ($arrRes[0]["Mobile"]) ? $arrRes[0]["Mobile"] : $arrRes[0]["Landline"];
	$ContactInfo .= '<div style="margin:-27px 0 0 60px">'.nl2br(stripslashes($arrRes[0]["Address"]));
	if(!empty($arrRes[0]["CityName"]))$ContactInfo .= ', <br>'.htmlentities($arrRes[0]["CityName"], ENT_IGNORE);
	if(!empty($arrRes[0]["StateName"]))$ContactInfo .= ', '.stripslashes($arrRes[0]["StateName"]);
	$ContactInfo .= '<br>'.stripslashes($arrRes[0]["CountryName"]).' - '.stripslashes($arrRes[0]["ZipCode"]).'</div>';
	if(trim($arrRes[0]["FullName"])!=''){
		$Coust = $arrRes[0]["FullName"];
	}else{
		$Coust = $arrRes[0]["Company"];
	}		
   	//End//



            $CC = $Config['AdminEmail'];
            $TemplateContent2 = $objConfigure->GetTemplateContent(9, 1);
            $contents = $TemplateContent2[0]['Content'];
            $subject2 = $TemplateContent2[0]['subject'];

            

            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[PARENT]", $parent_type, $contents);
            $contents = str_replace("[TICKETID]", $TicketID, $contents);
            $contents = str_replace("[PARENTID]", $parentID, $contents);
            $contents = str_replace("[TITLE]", $title, $contents);
            $contents = str_replace("[CATEGORY]", $category, $contents);
            $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? ($AssignUserName) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[STATUS]", $Status, $contents);
            $contents = str_replace("[PRIORITY]", $priority, $contents);
            $contents = str_replace("[DESCRIPTION]", $description, $contents);
            $contents = str_replace("[CATEGORY]", $category, $contents);
            $contents = str_replace("[SOLUTION]", (!empty($solution)) ? ($solution) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[DAYS]", (!empty($day)) ? ($day) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[HOURS]", (!empty($Hours)) ? ($Hours) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[CREATEDON]", date($Config['DateFormat'], strtotime($Config['TodayDate'])), $contents);

	//By Chetan on aug21,2017//
		$contents = str_replace("[USER]", $AssignUserName, $contents);
		$contents = str_replace("[CUSTOMER]", $Coust, $contents);
		$contents = str_replace("[ADDRESS]", $ContactInfo, $contents);
		$contents = str_replace("[CONTACTNUMBER]", $contNum, $contents);
	   //End//

            //$contents = str_replace("[DATE]",$ticketDate, $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($CustEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Ticket - " . $subject2;
            $mail->IsHTML(true);
            $mail->Body = $contents;
//echo $CustEmail.$Config['AdminEmail'].$contents; exit;
            if ($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
                $mail->Send();
            }
        }

       


        return 1;
    }

	//By Chetan 18Sep
    //function to add lead by import//
    function AddImportLead($arryDetails) { 
        $objConfigure = new configure();
        global $Config;

        extract($arryDetails);

        if ($main_state_id > 0)
            $OtherState = '';
        if ($main_city_id > 0)
            $OtherCity = '';
        //if(empty($Status)) $Status=1;
        $LeadName = trim($FirstName . ' ' . $LastName);


        $ipaddress = GetIPAddress();
        $JoiningDatl = $Config['TodayDate'];
 
         if ($assign == 'Users') { //By Chetan//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else if ($AssignToGroup != '') {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }
          
    
	if(!empty($AssignTo)  && !empty($AssignType)){
	      //echo 'ok';
	}else if(sizeof($TerritoryAssign)>0){
		if($AssignTo>0)$AssignToTerri = $AssignTo.",";
		foreach($TerritoryAssign as $key => $values) {
			$AssignToTerri .= $values['AssignTo'].",";
		}
		$AssignTo = rtrim($AssignToTerri, ",");
		
	}else if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
            $AssignType = 'Users';
        }

 //By Chetan//
	/**************/
        if(empty($LeadDate)){$LeadDate=$Config['TodayDate']; }else{ $LeadDate = $LeadDate;}
	/**************/
	//if(empty($LeadDate))$LeadDate=$Config['TodayDate'];

	if(empty($type)){
		 $type = (!empty($company)) ? ("Company") : ("Individual");
	}else{
            $type = $type ;
        }



        $strSQLQuery = "insert into c_lead (LeadName,type,ProductID,product_price, primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,lead_status,lead_source, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AssignType,GroupID,AnnualRevenue,designation,description,Industry,LeadDate , created_by, created_id,NumEmployee,LastContactDate,Currency,Rating) values('" . addslashes($LeadName) . "','" . addslashes($type) . "','" . addslashes($ProductID) . "', '" . addslashes($product_price) . "','" . addslashes($primary_email) . "', '" . addslashes($company) . "','" . addslashes($Website) . "','" . addslashes($FirstName) . "', '" . addslashes($LastName) . "', '" . addslashes($Address) . "',  '" . $main_city_id . "', '" . $main_state_id . "','" . addslashes($ZipCode) . "', '" . $country_id . "', '" . addslashes($Mobile) . "','" . addslashes($LandlineNumber) . "','" . addslashes($lead_status) . "','" . addslashes($lead_source) . "',  '" . $JoiningDatl . "',  '" . addslashes($OtherState) . "', '" . addslashes($OtherCity) . "','" . $ipaddress . "',  '" . $Config['TodayDate'] . "','" . addslashes($AssignTo) . "','" . addslashes($AssignType) . "','" . addslashes($GroupID) . "',ENCODE('" .addslashes($AnnualRevenue) . "','".$Config['EncryptKey']."'),'" . addslashes($designation) . "','" . addslashes($description) . "','" . addslashes($Industry) . "','" . addslashes($LeadDate) . "', '" . addslashes($_SESSION['AdminType']) . "', '" . addslashes($_SESSION['AdminID']) . "' ,'" . addslashes($NumEmployee) . "' ,'" . addslashes($LastContactDate) . "','" . addslashes($Currency) . "','" . addslashes($Rating) . "')";

        $this->query($strSQLQuery, 0);

        //End// 

        $LeadID = $this->lastInsertId();


        $htmlPrefix = $Config['EmailTemplateFolder'];
        if($AssignTo != '') {
            $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignTo . ")";
            //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
            $arryEmp = $this->query($strSQLQuery, 1);
            foreach ($arryEmp as $email) {
                $ToEmail .= $email['Email'] . ",";
                $AssignUserName .= $email['UserName'] . ",";
            }
            $assignEmail = rtrim($ToEmail, ",");
            $AssignUserName = rtrim($AssignUserName, ",");
       

            $ToEmail = $arryEmp[0]['Email'];
            $CC = $Config['AdminEmail'];

            $assignEmail = $arryEmp[0]['Email'];



            $TemplateContent = $objConfigure->GetTemplateContent(1, 1);
            $contents = $TemplateContent[0]['Content'];
            //$contents = file_get_contents($htmlPrefix . "LeadAssigned.htm");
            $subject = $TemplateContent[0]['subject'];
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
            $contents = str_replace("[FIRSTNAME]", $FirstName, $contents);
            $contents = str_replace("[LASTNAME]", $LastName, $contents);
            $contents = str_replace("[LEADID]", $LeadID, $contents);
            $contents = str_replace("[LEADSTATUS]", $lead_status, $contents);
            $contents = str_replace("[PRODUCTPRICE]", (!empty($product_price)) ? (stripslashes($product_price)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[PRIMARYEMAIL]", (!empty($primary_email)) ? (stripslashes($primary_email)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[COMPANY]", (!empty($company)) ? (stripslashes($company)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADAMOUNT]", (!empty($LeadAmount)) ? (stripslashes($LeadAmount)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[WEBSITE]", (!empty($Website)) ? (stripslashes($Website)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[TITLE]", (!empty($designation)) ? (stripslashes($designation)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[PRODUCT]", (!empty($ProductID)) ? (stripslashes($ProductID)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[ANNUALREVENUE]", (!empty($AnnualRevenue)) ? (stripslashes($AnnualRevenue)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[NUMBEROFEMPLOYEES]", (!empty($NumEmployee)) ? (stripslashes($NumEmployee)) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LEADDATE]", (!empty($LeadDate)) ? (date($Config['DateFormat'], strtotime($LeadDate))) : (NOT_SPECIFIED), $contents);
            $contents = str_replace("[LASTCONTACTDATE]", (!empty($LastContactDate)) ? (date($Config['DateFormat'], strtotime($LastContactDate))) : (NOT_SPECIFIED), $contents);




            $contents = str_replace("[COMPANY]", $company, $contents);
            //$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . " - Lead [" . $LeadName . "] - " . $subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            //echo $assignEmail.$Config['AdminEmail'].$contents; exit; 
            if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                $mail->Send();
            }
        }
        //echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;
        //Projects [Sunesta]. Task Assigned to You: Email for Images and Files
        //Send Acknowledgment Email to admin


        $TemplateContent2 = $objConfigure->GetTemplateContent(2, 1);
        $contents = $TemplateContent2[0]['Content'];
        if (!empty($product_price))
            $LeadAmount = $product_price . ' ' . $Config['Currency'];
        $subject2 = $TemplateContent2[0]['subject'];
        //$contents = file_get_contents($htmlPrefix . "admin_Lead.htm");
        $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
        $contents = str_replace("[FIRSTNAME]", $FirstName, $contents);
        $contents = str_replace("[LASTNAME]", $LastName, $contents);
        $contents = str_replace("[LEADID]", $LeadID, $contents);
        $contents = str_replace("[LEADSTATUS]", $lead_status, $contents);
        $contents = str_replace("[PRODUCTPRICE]", (!empty($product_price)) ? (stripslashes($product_price)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[DESCRIPTION]", (!empty($description)) ? (stripslashes($description)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[PRIMARYEMAIL]", (!empty($primary_email)) ? (stripslashes($primary_email)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[COMPANY]", (!empty($company)) ? (stripslashes($company)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADAMOUNT]", (!empty($LeadAmount)) ? (stripslashes($LeadAmount)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[ASSIGNEDTO]", (!empty($AssignUserName)) ? (stripslashes($arryEmp[0]['UserName'])) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[WEBSITE]", (!empty($Website)) ? (stripslashes($Website)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[TITLE]", (!empty($designation)) ? (stripslashes($designation)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[PRODUCT]", (!empty($ProductID)) ? (stripslashes($ProductID)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[ANNUALREVENUE]", (!empty($AnnualRevenue)) ? (stripslashes($AnnualRevenue)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADSOURCE]", (!empty($lead_source)) ? (stripslashes($lead_source)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[NUMBEROFEMPLOYEES]", (!empty($NumEmployee)) ? (stripslashes($NumEmployee)) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LEADDATE]", (!empty($LeadDate)) ? (date($Config['DateFormat'], strtotime($LeadDate))) : (NOT_SPECIFIED), $contents);
        $contents = str_replace("[LASTCONTACTDATE]", (!empty($LastContactDate)) ? (date($Config['DateFormat'], strtotime($LastContactDate))) : (NOT_SPECIFIED), $contents);


        $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress($Config['AdminEmail']);
        if (!empty($Config['DeptHeadEmail'])) {
            $mail->AddCC($Config['DeptHeadEmail']);
        }

        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " - " . $subject2;
        $mail->IsHTML(true);
        $mail->Body = $contents;
        # echo $arryRow[0]['Email'] . $Config['AdminEmail'] . $contents;exit;
        if($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
            $mail->Send();
        }

        #echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

        return $LeadID;
    }
// By Rajan 22 Dec
	 function updateStatus($status,$leadID){
	 		$strSQLQuery = "update c_lead set lead_status='".$status."' where leadID='".$leadID."' ";
	 		return $this->query($strSQLQuery);
	 }
	  // End //

/*------------------ Added by Sanjiv For Import Lead 8 jan-----------------------------*/
  function importToTemp($arryDetails){
    	 $objConfigure = new configure();
        global $Config;

        extract($arryDetails);

        if ($main_state_id > 0)
            $OtherState = '';
        if ($main_city_id > 0)
            $OtherCity = '';
        //if(empty($Status)) $Status=1;
        $LeadName = trim($FirstName . ' ' . $LastName);


        $ipaddress = GetIPAddress();
        $JoiningDatl = $Config['TodayDate'];
 
         if ($assign == 'Users') { //By Chetan//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else if ($AssignToGroup != '') {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }
          
    
		if(!empty($AssignTo)  && !empty($AssignType)){
		      //echo 'ok';
		}else if(sizeof($TerritoryAssign)>0){
			if($AssignTo>0)$AssignToTerri = $AssignTo.",";
			foreach($TerritoryAssign as $key => $values) {
				$AssignToTerri .= $values['AssignTo'].",";
			}
			$AssignTo = rtrim($AssignToTerri, ",");
			
		}else if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
	            $AssignTo = $_SESSION['AdminID'];
	            $AssignType = 'Users';
	        }

		/**************/
	         if(empty($LeadDate)){$LeadDate=$Config['TodayDate']; }else{ $LeadDate = date('Y-m-d',strtotime($LeadDate));} //update by chetan 20june2017//
		/**************/
		//if(empty($LeadDate))$LeadDate=$Config['TodayDate'];

		if(empty($type)){
			 $type = (!empty($company)) ? ("Company") : ("Individual");
		}else{
	            $type = $type ;
	        }

	//Added by chetan 20June2017//
	$objField = new field();
	$arryflds=$objField->getAllCustomFieldByModuleID(102);
	$arry = array_map(function($arr){
		    if($arr['editable']==1){
			return $arr['fieldname'];
		    }else{
			unset($arr);
		    }   
		},$arryflds);
	$arryflds = array_values(array_filter($arry)); 
	foreach($arryflds as $key)
	{       
		$queryStr .= ','.$key;
		$valStr .= ",".'"'.$arryDetails[$key].'"';
	}	
	//End//

        $strSQLQuery = "insert into c_lead_temp".$_SESSION['AdminID']." (LeadName,type,ProductID,product_price, primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,lead_status,lead_source, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AssignType,GroupID,AnnualRevenue,designation,description,Industry,LeadDate , created_by, created_id,NumEmployee,LastContactDate,Currency,Rating,FolderID $queryStr) values('" . addslashes($LeadName) . "','" . addslashes($type) . "','" . addslashes($ProductID) . "', '" . addslashes($product_price) . "','" . addslashes($primary_email) . "', '" . addslashes($company) . "','" . addslashes($Website) . "','" . addslashes($FirstName) . "', '" . addslashes($LastName) . "', '" . addslashes($Address) . "',  '" . $main_city_id . "', '" . $main_state_id . "','" . addslashes($ZipCode) . "', '" . $country_id . "', '" . addslashes($Mobile) . "','" . addslashes($LandlineNumber) . "','" . addslashes($lead_status) . "','" . addslashes($lead_source) . "',  '" . $JoiningDatl . "',  '" . addslashes($OtherState) . "', '" . addslashes($OtherCity) . "','" . $ipaddress . "',  '" . $Config['TodayDate'] . "','" . addslashes($AssignTo) . "','" . addslashes($AssignType) . "','" . addslashes($GroupID) . "',ENCODE('" .addslashes($AnnualRevenue) . "','".$Config['EncryptKey']."'),'" . addslashes($designation) . "','" . addslashes($description) . "','" . addslashes($Industry) . "','" . addslashes($LeadDate) . "', '" . addslashes($_SESSION['AdminType']) . "', '" . addslashes($_SESSION['AdminID']) . "' ,'" . addslashes($NumEmployee) . "' ,'" . addslashes($LastContactDate) . "','" . addslashes($Currency) . "','" . addslashes($Rating) . "','" . addslashes($FolderID) . "' $valStr)";
        $this->query($strSQLQuery, 0);
    }
    
    
    function SendMailForImport($arryDetails){
        $objConfigure = new configure();
        global $Config;

        extract($arryDetails);	
        
   	 	if($FolderID){
            	$objConfig=new admin();
            	$folderDetail = $objConfig->GetFolderDetails($FolderID);
            }else{
			$folderDetail[0]['FolderName'] = 'none';
		}
		
        $htmlPrefix = $Config['EmailTemplateFolder'];
        if($AssignTo != '') {
            $strSQLQuery = "select UserName,Email from h_employee where EmpID in (" . $AssignTo . ")";
            $arryEmp = $this->query($strSQLQuery, 1);
            foreach ($arryEmp as $email) {
                $ToEmail .= $email['Email'] . ",";
                $AssignUserName .= $email['UserName'] . ",";
            }
            $assignEmail = rtrim($ToEmail, ",");
            $AssignUserName = rtrim($AssignUserName, ",");
       

            $ToEmail = $arryEmp[0]['Email'];
            $CC = $Config['AdminEmail'];
            $assignEmail = $arryEmp[0]['Email'];
			
            $TemplateContent = $objConfigure->GetTemplateContent(10, 1);
            $contents = $TemplateContent[0]['Content'];
            $subject = $TemplateContent[0]['subject'];
            $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
            $contents = str_replace("[URL]", $Config['Url'], $contents);
            $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
            $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);


            $contents = str_replace("[COMPANY]", $company, $contents);
            $contents = str_replace("[TOTALLEADS]", $_SESSION['TotalImport'], $contents);
       		$contents = str_replace("[FOLDERNAME]", $folderDetail[0]['FolderName'], $contents);
            

            $mail = new MyMailer();
            $mail->IsMail();
            $mail->AddAddress($assignEmail);
            $mail->sender($Config['SiteName'], $Config['AdminEmail']);
            $mail->Subject = $Config['SiteName'] . $subject;
            $mail->IsHTML(true);
            $mail->Body = $contents;
            if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
                $mail->Send();
            }
        }
        


        $TemplateContent2 = $objConfigure->GetTemplateContent(11, 1);
        $contents = $TemplateContent2[0]['Content'];
        if (!empty($product_price))
            $LeadAmount = $product_price . ' ' . $Config['Currency'];
        $subject2 = $TemplateContent2[0]['subject'];
        $CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
        $contents = str_replace("[URL]", $Config['Url'], $contents);
        $contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
        $contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
       	
        $contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);
        $contents = str_replace("[TOTALLEADS]", $_SESSION['TotalImport'], $contents);
       	$contents = str_replace("[FOLDERNAME]", $folderDetail[0]['FolderName'], $contents);

        $mail = new MyMailer();
        $mail->IsMail();
        $mail->AddAddress('sanjiv.singh@vstacks.in');
        if (!empty($Config['DeptHeadEmail'])) {
            $mail->AddCC($Config['DeptHeadEmail']);
        }

        $mail->sender($Config['SiteName'], $Config['AdminEmail']);
        $mail->Subject = $Config['SiteName'] . " - " . $subject2;
        $mail->IsHTML(true);
        $mail->Body = $contents;
        if($Config['Online'] == 1 && $TemplateContent2[0]['Status'] == 1) {
            $mail->Send();
        }

        return true;
    }
    
    
	function MoveRecordToMasterTable(){
		$sql1 = "SELECT * from c_lead_temp".$_SESSION['AdminID']." limit 0,1";
		$data = $this->query($sql1,1);
		if($data[0]['leadID']){
			$sqlStr = "ALTER TABLE c_lead_temp".$_SESSION['AdminID']." DROP leadID";
			$this->query($sqlStr);
	    	$sql = "insert into c_lead select null as leadID, c_lead_temp".$_SESSION['AdminID'].".* from c_lead_temp".$_SESSION['AdminID']."";
	    	$this->query($sql);
		}
		$this->DropTempTableForImport();
    }
    
	function CreateTempTableForImport(){
			$this->DropTempTableForImport();
	    	$sql = "CREATE TABLE c_lead_temp".$_SESSION['AdminID']." like c_lead";
	    	$this->query($sql);
    }
    
    
	function DropTempTableForImport(){
		if($this->numRows($this->query("SHOW TABLES LIKE 'c_lead_temp".$_SESSION['AdminID']."'"))==1){
	    	$sql = "DROP TABLE c_lead_temp".$_SESSION['AdminID']."";
	    	$this->query($sql);
		}
    }
    
	function CountForImport(){
		if($this->numRows($this->query("SHOW TABLES LIKE 'c_lead_temp".$_SESSION['AdminID']."'"))==1){
	    	$sql = "SELECT count(*) count from c_lead_temp".$_SESSION['AdminID']."";
	    	$count = $this->query($sql,1);
	    	return $c = ($count[0]['count']>0)?$count[0]['count']:0; 
		}else{
			return false;
		}
    }

function moveToFolder($leadID,$folderId) {
        if (!empty($leadID)) {
            $sql = "update c_lead set FolderID='".$folderId."' where leadID in ( " . $leadID . ")";
            $rs = $this->query($sql, 0);
        }
        return true;
    }
/*----------------------------- END ---------------------------------------------------*/
// Added by karishma for editable field on 13 Jan 2016
	function getCustomField($moduleType){
		$strSQLQuery = "select a.ModuleID,b.head_id,b.head_value,c.type,c.fieldname,c.dropvalue,c.fieldid from admin_modules as a
		inner join c_head_value b on b.Module=a.ModuleID
		inner join c_field c on c.headid=b.head_id  and (c.type!='radio' and c.type!='checkbox')
		where a.Module='".addslashes($moduleType)."' ";
		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow;
	}

	// end by karishma for editable field on 13 Jan 2016


//ADDED BY CHETAN ON 24jAN2018//
function UpdateCountyStateCityforOpp($arryDetails,$leadID){   
	extract($arryDetails);		

	$strSQLQuery = "UPDATE c_opportunity SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE OpportunityID = '".$leadID."'";

	$this->query($strSQLQuery, 0);
	return 1;
}



function checkQueryidExist($Queryid) {
	$strAddQuery .= (!empty($Queryid)) ? (" and QUERY_ID = '" . $Queryid. "'") : ("");
	
	$strSQLQuery = "select leadID from c_lead where  1 " . $strAddQuery;
	
	$arryRow = $this->query($strSQLQuery, 1);

	if(!empty($arryRow[0]['leadID'])) {
		return true;
	} else {
		return false;
	}
}

 function AddLeadIndia($arryDetails,$CmpID=0) { 
        $objConfigure = new configure();
        global $Config;
	
	$AssignTo=$AssignType=$GroupID=$AnnualRevenue=$city_id=$state_id='';

        extract($arryDetails);

        if ($main_state_id > 0)
            $OtherState = '';
        if ($main_city_id > 0)
            $OtherCity = '';
        //if(empty($Status)) $Status=1;
        $LeadName = trim($FirstName . ' ' . $LastName);


        $ipaddress = GetIPAddress();
        $JoiningDatl = $Config['TodayDate'];
 
         if (!empty($assign) && $assign == 'Users') { //By Chetan//
            $AssignTo = $AssignToUser;
            $AssignType = $assign;
        } else if (!empty($AssignToGroup)) {
            $arryAsign = explode(":", $AssignToGroup);
            $AssignTo = $arryAsign[0];
            $AssignType = $assign;
            $GroupID = $arryAsign[1];
        }
          
    
	if(!empty($AssignTo)  && !empty($AssignType)){
	      //echo 'ok';
	}else if(!empty($TerritoryAssign)){
		if($AssignTo>0)$AssignToTerri = $AssignTo.",";
		foreach($TerritoryAssign as $key => $values) {
			$AssignToTerri .= $values['AssignTo'].",";
		}
		$AssignTo = rtrim($AssignToTerri, ",");
		
	}else if($_SESSION['AdminType'] == "employee" && empty($AssignTo)) {
            $AssignTo = $_SESSION['AdminID'];
            $AssignType = 'User';
        }


	/**************/
        if(empty($LeadDate)){$LeadDate=$Config['TodayDate']; }else{ $LeadDate = $LeadDate;}
	/**************/


	if(empty($type)){
		 $type = (!empty($company)) ? ("Company") : ("Individual");
	}else{
            $type = $type ;
        }


	unset($arryDetails['LeadDate']);
	unset($arryDetails['captcha']);
	unset($arryDetails['type']);
	unset($arryDetails['LeadSubmit']);
	unset($arryDetails['Cmp']);
 
	unset($arryDetails['AnnualRevenue']);
	unset($arryDetails['assign']);
	unset($arryDetails['AssignToGroup']);
	unset($arryDetails['AssignToUser']);
	unset($arryDetails['Submit']);
	unset($arryDetails['LeadID']);
	unset($arryDetails['main_state_id']);
	unset($arryDetails['main_city_id']);
	unset($arryDetails['ajax_state_id']);
	unset($arryDetails['ajax_city_id']);
	unset($arryDetails['state_id']);
	unset($arryDetails['city_id']);
                 
      	$fields = join(',',array_keys($arryDetails));
	$values = join("','",array_values(array_map(function($arr){ return addslashes($arr);},$arryDetails))); //updated for addslashes on 22Sep2017 by chetan//
      
       
       $strSQLQuery = "insert into c_lead 
                        (LeadName,LeadDate, type, JoiningDate,  ipaddress, UpdatedDate,AssignTo,AssignType,GroupID,AnnualRevenue,city_id,state_id,$fields)
                        values('" . addslashes($LeadName) . "',
                                '" . addslashes($LeadDate) . "',
                                '" . addslashes($type) ."',
                                '" . $JoiningDatl . "',
                                '" . $ipaddress . "',
                                '" . $Config['TodayDate'] . "',
                                '" . addslashes($AssignTo) . "',
                                '" . addslashes($AssignType) . "',
                                '" . addslashes($GroupID) ."', 
                                     ENCODE('".addslashes($AnnualRevenue)."' ,'".$Config['EncryptKey']."'),
                                 '".$city_id."',
                                '".$state_id."' ,'".$values."')" ;
       
 

        $this->query($strSQLQuery, 0);

        //End// 
        $LeadID = $this->lastInsertId();
        return $LeadID;
    }


    function  GetStateID($name,$country_id)
    {
    	$strAddQuery = (!empty($country_id))?(" and country_id='".$country_id."'"):("");
    	$strSQLQuery = "select state_id,name from erp.state where ( LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'   OR LCASE(code)='".mysql_real_escape_string(strtolower(trim($name)))."'   ) ".$strAddQuery."";
			//echo $strSQLQuery.'<br>';
    	return $this->query($strSQLQuery, 1);
    }

    function  GetCityID($name,$country_id)
    {
    	$strAddQuery = (!empty($country_id))?(" and country_id='".$country_id."'"):("");
    	$strSQLQuery = "select city_id from erp.city where  LCASE(name)='".strtolower(trim($name))."' ".$strAddQuery."";
    	return $this->query($strSQLQuery, 1);
    }


    function updateAsViewMarked($id, $tableName,$fieldName)
    {
    	
         $strSQLQuery = "update ".$tableName."  set view_status='1' where ".$fieldName."='" . $id . "'";
        $this->query($strSQLQuery, 0);
    }


        function GetDashboardOpportunityCount($limit=6) {
	global $Config;
      /*  $strSQLQuery = "select o.OpportunityID,o.LeadID,o.Status,o.OpportunityName,o.lead_source,o.AddedDate,o.view_status, DECODE(o.Amount,'". $Config['EncryptKey']."') as AmountVal,DECODE(o.forecast_amount,'". $Config['EncryptKey']."') as forecast_amount from c_opportunity o ";

        $strSQLQuery .= " where o.Status='1' and SalesStage not like 'Closed%' and o.view_status!= 1";

        $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (o.AssignTo='" . $_SESSION['AdminID'] . "' OR o.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

        $strSQLQuery .= " having AmountVal>0 order by o.view_status ASC limit 0,".$limit;
*/
       // echo $strSQLQuery;
         $strSQLQuery="select count(OpportunityID) as OppCount  from  c_opportunity where Status='1' AND view_status IS null  ";
        return $this->query($strSQLQuery, 1);
    }


     function GetDashboardLeadCount($limit=6) {
     
        global $Config;


        $strSQLQuery=" select count(leadID) as leadCount  from  c_lead where  Opportunity='0' AND view_status IS null  ";
        //echo $strSQLQuery;
        return $this->query($strSQLQuery, 1);
        
    }






}

?>
