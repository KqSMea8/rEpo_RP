<?
class reimbursement extends dbClass
{
		//constructor
		function reimbursement()
		{
			$this->dbClass();
		} 

		/********** Reimbursement Management *********/
		
		
		function  ListReimbursementDetail($arryDetails){
			extract($arryDetails);
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID='".$_SESSION['locationID']."'");

			/**************/
			$FromDate = DefaultDateFormat($FromDate);
			$ToDate = DefaultDateFormat($ToDate);		 
			/**************/


			$strAddQuery .= (!empty($FromDate))?(" and s.ApplyDate>='".mysql_real_escape_string($FromDate)."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and s.ApplyDate<='".mysql_real_escape_string($ToDate)."'"):("");

			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%' or  d.Department like '%".$SearchKey."%' or s.Status like '%".$SearchKey."%' ) " ):("");			
			}			

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.ReimID desc ");
  
			
			if($Config['GetNumRecords']==1){
				$Columns = " count(s.ReimID) as NumCount ";				
			}else{				
				$Columns = "   s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			 $strSQLQuery = "select ".$Columns." from  h_reimbursement s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;


			return $this->query($strSQLQuery, 1);	
					
		}
		

		function addReimbursement($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$IPAddress = GetIPAddress();
		    switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}
			
			$sql = "insert into h_reimbursement (ExReason, EmpID, CreatedDate, Comment, TotalAmount, Currency, Status, ApplyDate, Approved, AdminID, AdminType, IPAddress) values('".addslashes($ExReason)."', '".addslashes($EmpID)."', '". $Config['TodayDate']."', '".addslashes($Comment)."', '".addslashes($TotalAmount)."', '".$Config['Currency']."', '".addslashes($Status)."', '".addslashes($ApplyDate)."', '".addslashes($Approved)."', '". $_SESSION['AdminID']."', '". $_SESSION['AdminType']."', '". $IPAddress."')";
			$this->query($sql, 0);
			$ReimID = $this->lastInsertId();
			return $ReimID;

		}
		
        function returnReimbursement($arryDetails){
			global $Config;
			@extract($arryDetails);	
			if(!empty($ReimID)){
				$sql = "update h_reimbursement set Returned='1', Status='Paid', updatedDate = '".$Config['TodayDate']."', ReturnDate = '".$ReturnDate."' where ReimID = '".addslashes($ReimID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;
		}
		
		function updateReimbursement($arryDetails)
		{
			global $Config;
			@extract($arryDetails);

		    switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}
			
			if(!empty($ReimID)){
			    $sql = "update h_reimbursement set Approved='".addslashes($Approved)."', Status='".addslashes($Status)."', SancAmount='".addslashes($SancAmount)."', IssueDate='".addslashes($IssueDate)."', ExReason='".addslashes($ExReason)."', Comment= '".addslashes($Comment)."', UpdatedDate = '".$Config['TodayDate']."'  where ReimID = '".addslashes($ReimID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}
		
		
        function deleteReimbursement($ReimID){
			global $Config;
			$objConfigure=new configure();
			$objFunction=new functions();
			if(!empty($ReimID)){

				$strSQLQuery = "select document from h_reimbursement where ReimID='".mysql_real_escape_string($ReimID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
				  
				if($arryRow[0]['document'] !='' ){	
					$objFunction->DeleteFileStorage($Config['ReimDir'],$arryRow[0]['document']);	
				}

				$sql = "delete from  h_reimbursement where ReimID = '".mysql_real_escape_string($ReimID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}
		
		
		function ListReimbursement($arryDetails){
			@extract($arryDetails);
			$strAddQuery = "select * from h_reimbursement order by ApplyDate desc" ; 
		    return $this->query($strAddQuery, 1);
			
		}
		
       function UpdateReim($document,$ReimID)
		{
			if(!empty($ReimID) && !empty($document)){			

				$strSQLQuery = "update h_reimbursement set document='".$document."' where ReimID = '".mysql_real_escape_string($ReimID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		
       function addReimbursementLineItem($ReimValID,$arryDetails)
		{  
				
			extract($arryDetails);
			//echo "<pre>";print_r($arryDetails);exit;
			for($i=1;$i<=$NumLine;$i++){
				//echo "<pre>";print_r($NumLine);exit;
				if(!empty($arryDetails['EmpID'])){
					$MileageRate = $arryDetails['MileageRate'.$i];
					$TotalMiles = $arryDetails['TotalMiles'.$i];
					$Type = $arryDetails['Type'.$i];
					if($Type == 'Miss'){
						$Type = "Miscellaneous";
						$MileageRate='';
						$TotalMiles='';
					}else{
						$Type = "Mileage";
						$MileageRate = $arryDetails['MileageRate'.$i];
					    $TotalMiles = $arryDetails['TotalMiles'.$i];
					}
				  $strSQLQuery = "insert into h_reimbursement_item (ReimID, Type, FromZip, ToZip, MileageRate, TotalMiles, Reference, ReimComment, TotalRate) values('".addslashes($ReimValID)."', '".addslashes($Type)."', '".addslashes($arryDetails['FromZip'.$i])."', '".addslashes($arryDetails['ToZip'.$i])."', '".addslashes($MileageRate)."', '".addslashes($TotalMiles)."', '".addslashes($arryDetails['Reference'.$i])."', '".addslashes($arryDetails['ReimComment'.$i])."', '".addslashes($arryDetails['TotalRate'.$i])."')";
				  $this->query($strSQLQuery, 0);	

				}
			}
			return true;

		}
		
       function ListReimbursementItem($ReimID){
			$strAddQuery = "select * from h_reimbursement_item where ReimID = '".$ReimID."'" ; 
		    return $this->query($strAddQuery, 1);
			
		}
		
		
      function ListReimbursementView($ReimID){
			//@extract($arryDetails);
		  $strAddQuery = "select r.*,e.UserName from h_reimbursement r left outer join h_employee e on r.EmpID=e.EmpID where r.ReimID = '".$ReimID."' order by r.ReimID desc" ; 
		    return $this->query($strAddQuery, 1);
			
		}

	/**********************************/
		
      function sendReimbursementEmail($ReimID)
		{
			global $Config;	
			$ReimID = mysql_real_escape_string($ReimID);
			if($ReimID>0){
				$arryRow = $this->getReimbursementData($ReimID,''); 

				$Comment = (!empty($arryRow[0]['Comment']))?(nl2br(stripslashes($arryRow[0]['Comment']))):(NOT_SPECIFIED);
				$ApplyDate = ($arryRow[0]['ApplyDate']>0)?(date($Config['DateFormat'], strtotime($arryRow[0]['ApplyDate']))):(NOT_SPECIFIED);


				if($arryRow[0]['EmpID']!=$arryRow[0]['Supervisor']){
					$sql = "select Email from h_employee where EmpID='".$arryRow[0]['Supervisor']."'" ; 
					$arrySupervisor = $this->query($sql, 1);
				}
				if($arryRow[0]['Approved']==1){
					$arryRow[0]['Status'] = 'Approved';
				}
				
				//echo "<pre>";print_r($arryRow);exit;

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."reimbursement.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[ExReason]",stripslashes($arryRow[0]['ExReason']),$contents);
				//$contents = str_replace("[ClaimAmount]",$ClaimAmount,$contents);
				//$contents = str_replace("[SancAmount]",$SancAmount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date($Config['DateFormat'], strtotime($arryRow[0]['ApplyDate'])),$contents);
				$contents = str_replace("[CreatedDate]",date($Config['DateFormat'], strtotime($arryRow[0]['CreatedDate'])),$contents);
				//$contents = str_replace("[ExpenseDate]",date($Config['DateFormat'], strtotime($arryRow[0]['ExpenseDate'])),$contents);
					

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				//$mail->AddAddress('rajeev.kushwaha@vstacks.in');
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Reimbursement Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/
				$contents = file_get_contents($htmlPrefix."reimbursement_admin.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[ExReason]",stripslashes($arryRow[0]['ExReason']),$contents);
				//$contents = str_replace("[ClaimAmount]",$ClaimAmount,$contents);
				//$contents = str_replace("[SancAmount]",$SancAmount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date($Config['DateFormat'], strtotime($arryRow[0]['ApplyDate'])),$contents);
				$contents = str_replace("[CreatedDate]",date($Config['DateFormat'], strtotime($arryRow[0]['CreatedDate'])),$contents);
				//$contents = str_replace("[IssueDate]",$IssueDate,$contents);
				//$contents = str_replace("[ExpenseDate]",date($Config['DateFormat'], strtotime($arryRow[0]['ExpenseDate'])),$contents);
					
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
				$mail->Subject = $Config['SiteName']." - Reimbursement Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arrySupervisor[0]['Email'].$Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}
		
		
       function getReimbursementData($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.ReimID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from  h_reimbursement s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery." order by s.ApplyDate desc";		
		
			return $this->query($strSQLQuery, 1);	
					
		}

}

?>
