<?php
class activity extends dbClass
{
		//constructor
		function activity()
		{
			$this->dbClass();
		} 
		
		function  ListActivity($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = 'where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and l.eventID='".$id."'"):(" ");

		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
		 $strAddQuery .= (!empty($SearchKey))?(" and ( l.subject like '%".$SearchKey."%' or  l.eventID like '%".$SearchKey."%' or l.Status like '%".$SearchKey."%' ) "  ):("");		
	}
$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and (l.assignedTo='".$_SESSION['AdminID']."' OR l.created_id='".$_SESSION['AdminID']."') "):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by l.eventID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			  $strSQLQuery = "select l.eventID,d.Department,e.Role,e.UserName as AssignTo from c_activity l left outer join  h_employee e on e.EmpID=l.assignedTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		


		
		function  ConvertActivity($eventID,$Opportunity=0)
		{
			$strSQLQuery = "update c_event set  Opportunity='".$Opportunity."'";

			$strSQLQuery .= (!empty($eventID))?(" where eventID='".$eventID."'"):(" where 1 ");
			//$strSQLQuery .= ($Opportunity>0)?(" and l.Opportunity=".$Opportunity):("");

			$this->query($strSQLQuery, 0);
		}	


		function  GetActivity($eventID,$Opportunity)
		{
			$strSQLQuery = "select l.* from c_event l ";

			$strSQLQuery .= (!empty($eventID))?(" where l.eventID='".$eventID."'"):(" where 1 ");
			$strSQLQuery .= ($Opportunity>0)?(" and l.Opportunity='".$Opportunity."'"):("");

			return $this->query($strSQLQuery, 1);
		}		
		

		function  GetActivitysForprimary_email($eventID)
		{
			$strSQLQuery = "select eventID,primary_email from c_event where 1";
			$strSQLQuery .= (!empty($eventID))?(" and eventID!='".$eventID."'"):("");
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllActivitys($Opportunity)
		{
			$strSQLQuery = "select eventID,primary_email from c_event where 1 ";

			$strSQLQuery .= ($Opportunity>0)?(" and Opportunity='".$Opportunity."'"):("");

			$strSQLQuery .= " order by primary_email Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetActivityDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where l.eventID='".$id."'"):(" where 1 ");

			$strAddQuery .= " order by l.JoiningDate Desc ";

			$strSQLQuery = "select l.*, e.Role,e.UserName as AssignTo from c_event l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  h_department d on e.Department=d.depID  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddActivity($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			//if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
	
			$ipaddress = GetIPAddress();

		 $strSQLQuery = "insert into c_event (type,ProductID,product_price, primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,Status,lead_source, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AnnualRevenue,designation,description,Industry ) values('".addslashes($type)."','".addslashes($ProductID)."', '".addslashes($product_price)."','".addslashes($primary_email)."', '".addslashes($company)."','".addslashes($Website)."','".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($LandlineNumber)."','".addslashes($Status)."','".addslashes($lead_source)."',  '".$JoiningDatl."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."','".$ipaddress."',  '".date('Y-m-d')."','".addslashes($AssignTo)."','".addslashes($AnnualRevenue)."','".addslashes($designation)."','".addslashes($description)."','".addslashes($Industry)."')";

			$this->query($strSQLQuery, 0);

			

			$ActivityID = $this->lastInsertId();

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."Activitydetails.htm");
			$subject  = " Details";
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Activity - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['DbUser'] != 'root'){
				 $mail->Send();	
			}

			
			//Send Acknowledgment Email to admin
			$contents = file_get_contents($htmlPrefix."admin_Activity.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Activity - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $ActivityID;

		}


		

		function UpdateActivity($arryDetails){   
			extract($arryDetails);

			$UserName = trim($FirstNaml.' '.$LastName);
	
			
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			//if(empty($Status)) $Status=1;type,ProductID,product_price
			 $strSQLQuery = "update c_event set  type='".addslashes($type)."', ProductID='".addslashes($ProductID)."', product_price='".addslashes($product_price)."',FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."',Website='".addslashes($Website)."',
			primary_email='".addslashes($primary_email)."',designation='".addslashes($designation)."',
			Industry='".addslashes($Industry)."',AnnualRevenue='".addslashes($AnnualRevenue)."',
			lead_source='".addslashes($lead_source)."',AssignTo='".addslashes($AssignTo)."',Status='".addslashes($Status)."',Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."',  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',company='".addslashes($company)."', description='".addslashes($description)."'
			where eventID='".$eventID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}


		
		
		function RemoveActivity($eventID)
		{

			$strSQLQuery = "delete from c_event where eventID='".$eventID."'"; 
			$this->query($strSQLQuery, 0);			
			return 1;

		}

		
		
		
		function changeActivityStatus($eventID)
		{
			$sql="select * from c_event where eventID='".$eventID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_event set Status='$Status' where eventID='".$eventID."'";
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleActivityStatus($eventIDs,$Status)
		{
			$sql="select eventID from c_event where eventID in (".$eventIDs.") "; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update c_event set Status='".$Status."' where eventID in (".$eventIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function ValidateActivity($primary_email,$Password){
			$strSQLQuery = "select * from c_event where primary_email='".$primary_email."' and Password='".md5($Password)."' and Status='1'";
			return $this->query($strSQLQuery, 1);
		}

		function isprimary_emailExists($primary_email,$eventID=0)
		{
			$strSQLQuery = (!empty($eventID))?(" and eventID != '".$eventID."'"):("");
			$strSQLQuery = "select eventID from c_event where LCASE(primary_email)='".strtolower(trim($primary_email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['eventID'])) {
				return true;
			} else {
				return false;
			}
		}
	
		
	

		

	

       

		

		
		
		




		/***************************Opprtunity**********************/

	/*	function  ListOpportunity($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where o.OpportunityID=".$id):(" where 1 ");

			if($SearchKey=='active' && ($SortBy=='o.Status' || $SortBy=='') ){
				$strAddQuery .= " and o.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='o.Status' || $SortBy=='') ){
				$strAddQuery .= " and o.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( o.OpportunityName like '%".$SearchKey."%' or o.activity_source like '%".$SearchKey."%' or o.SalesStage like '%".$SearchKey."%' ) "  ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by o.OpportunityID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select o.OpportunityID,o.Status,o.OpportunityName,o.activity_source,o.CloseDate,o.SalesStage,o.description,d.Department,e.Role,e.UserName as AssignTo from c_opportunity o left outer join  h_employee e on e.EmpID=o.AssignTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		function AddOpportunity($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			
			//if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			 $expCloseDate=$CloseDate.' '.$CloseTime;
	
			$ipaddress = GetIPAddress();
			

			 $strSQLQuery = "insert into c_opportunity ( LeadID,OpportunityName,Amount,OrgName,AssignTo,CloseDate,lead_source,SalesStage,OpportunityType,NextStep, 	description,Probability,Status,Campaign_Source,ContactName,AddedDate,forecast_amount,oppsite ) values( '".$LeadID."', '".addslashes($OpportunityName)."','".addslashes($Amount)."','".addslashes($OrgName)."','".addslashes($AssignTo)."', '".addslashes($expCloseDate)."', '".addslashes($lead_source)."',  '".addslashes($SalesStage)."','".addslashes($OpportunityType)."','".addslashes($NextStep)."','".addslashes($description)."','".addslashes($Probability)."', '".$Status."',  '".addslashes($Campaign_Source)."', '".addslashes($ContactName)."',  '".date('Y-m-d h:i:s')."','".addslashes($forecast_amount)."','".addslashes($oppsite)."')";
			
		

			$this->query($strSQLQuery, 0);

			

			$OpportunityID = $this->lastInsertId();

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."oppdetails.htm");
			$subject  = " Details";
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['DbUser'] != 'root'){
				 $mail->Send();	
			}

			
			//Send Acknowledgment Email to admin
			$contents = file_get_contents($htmlPrefix."admin_opp.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Opportunity - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $LeadID;

		}


		function UpdateOpportunity($arryDetails){   
			
			
					extract($arryDetails);
    				$expCloseDate=$CloseDate.' '.$CloseTime;
			
			
			//if(empty($Status)) $Status=1;
            $strSQLQuery = "update c_opportunity set  OpportunityName='".addslashes($OpportunityName)."', Amount='".addslashes($Amount)."',OrgName='".addslashes($OrgName)."',
			AssignTo='".addslashes($AssignTo)."',CloseDate='".addslashes($expCloseDate)."',
			lead_source='".addslashes($lead_source)."',
			SalesStage='".addslashes($SalesStage)."',OpportunityType='".addslashes($OpportunityType)."',NextStep='".addslashes($NextStep)."',  description='".addslashes($description)."', Probability='".addslashes($Probability)."', Campaign_Source='".addslashes($Campaign_Source)."', ContactName='".addslashes($ContactName)."', forecast_amount='".addslashes($forecast_amount)."', oppsite='".addslashes($oppsite)."'
			where OpportunityID=".$OpportunityID; 
		

			$this->query($strSQLQuery, 0);

			return 1;
		}

			function  GetOpportunity($OpportunityID,$Status)
		{
			$strSQLQuery = "select l.* from c_opportunity l ";

			$strSQLQuery .= (!empty($OpportunityID))?(" where l.OpportunityID=".$OpportunityID):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and l.Status=".$Status):("");
			

			return $this->query($strSQLQuery, 1);
		}	


		function changeOpportunityStatus($OpportunityID)
		{
			$sql="select * from c_opportunity where OpportunityID=".$OpportunityID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_opportunity set Status='$Status' where OpportunityID=".$OpportunityID;
				$this->query($sql,0);				

				return true;
			}			
		}

		function RemoveOpportunity($OpportunityID)
		{

			
			
			$strSQLQuery = "delete from c_opportunity where OpportunityID=".$OpportunityID; 
			$this->query($strSQLQuery, 0);			

			

			return 1;

		}
*/
	

}
?>
