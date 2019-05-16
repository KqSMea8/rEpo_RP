<?
class candidate extends dbClass
{
		//constructor
		function candidate()
		{
			$this->dbClass();
		} 
		
		function  ListCandidate($arryDetails){
			extract($arryDetails);
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where c.CanID='".mysql_real_escape_string($id)."'"):(" where c.locationID='".$_SESSION['locationID']."'");

			if($sortby != ''){
					$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c.UserName like '%".$SearchKey."%'  or c.Email like '%".$SearchKey."%' or c.Mobile like '%".$SearchKey."%' or v.Name like '%".$SearchKey."%' or c.InterviewStatus like '%".$SearchKey."%'  ) " ):("");	
			}		

			$strAddQuery .= ($module=="Manage")?(" and c.Status=''"):(" and c.Status='".$module."'");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by c.CanID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");


			if($Config['GetNumRecords']==1){
				$Columns = " count(c.CanID) as NumCount ";				
			}else{				
				$Columns = "   c.CanID,c.InterviewStatus,c.UserName, c.Email,c.Mobile,c.Image, c.JoiningDate, v.vacancyID, v.Name as Vacancy ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			$strSQLQuery = "select ".$Columns." from h_candidate c left outer join h_vacancy v on c.Vacancy=v.vacancyID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function  GetNumCandidate($module,$Vacancy)
		{
			$strSQLQuery = "select count(CanID) as TotalCandidate from h_candidate where locationID='".$_SESSION['locationID']."'";
			$strSQLQuery .= ($module!="")?(" and Status='".$module."'"):("");
			$strSQLQuery .= ($Vacancy>0)?(" and Vacancy='".$Vacancy."'"):("");

			$arryCount =  $this->query($strSQLQuery);	
			return $arryCount[0]['TotalCandidate'];
		}

		function  GetCandidateImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c.CanID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strSQLQuery = "select c.Image  from h_candidate c ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

	

		function  GetCandidate($CanID,$Status)
		{

			$strAddQuery = '';
			$strAddQuery .= (!empty($CanID))?(" where c.CanID='".mysql_real_escape_string($CanID)."'"):(" where c.locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= ($Status>0)?(" and c.Status='".$Status."'"):("");

			$strSQLQuery = "select c.*,v.Name as VacancyName,d.Department as DepartmentName from h_candidate c left outer join h_vacancy v on c.Vacancy=v.vacancyID left outer join h_employee e on v.HiringManager=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}		
		
		function GetCandidateBrief($CanID)
		{
			$strAddQuery .= (!empty($CanID))?(" and c.CanID='".mysql_real_escape_string($CanID)."'"):(" and c.locationID='".$_SESSION['locationID']."'");
			$strSQLQuery = "select c.CanID,c.UserName,c.Email from h_candidate c where 1 ".$strAddQuery." order by c.CanID asc";
			return $this->query($strSQLQuery, 1);
		}
				
		function  GetCandidateDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c.CanID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strAddQuery .= " order by c.CanID Desc ";

			$strSQLQuery = "select c.*,c.name as Country , if(c.city_id>0,ct.name,c.OtherCity) as City, if(c.state_id>0,s.name,c.OtherState) as State from h_candidate c left outer join country c on c.country_id=c.country_id left outer join state s on c.state_id=s.state_id left outer join city ct on c.city_id=ct.city_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddCandidate($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';

			if(!empty($TestTaken)) $TestTakenVal = ltrim(implode(",",$TestTaken), ",");

			$UserName = trim($FirstName.' '.$LastName);
	
			$ipaddress = GetIPAddress();

			$strSQLQuery = "insert into h_candidate (locationID, UserName,Email,FirstName,LastName,Gender ,date_of_birth,Address, city_id, state_id, ZipCode, country_id,Mobile, InterviewStatus, ApplyDate, OtherState, OtherCity, ExperienceYear, ExperienceMonth, Skill, Resume, Vacancy, Salary, SalaryFrequency,  UpdatedDate, TestTaken ,EmpID1 ,EmpID2 ,EmpID3 ,EmpName1 ,EmpName2 ,EmpName3   ) values(  '".$_SESSION['locationID']."', '".addslashes($UserName)."', '".addslashes($Email)."', '".addslashes($FirstName)."', '".addslashes($LastName)."','".addslashes($Gender)."', '".$date_of_birth."', '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."',  '".$InterviewStatus."', '".$ApplyDate."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".addslashes($ExperienceYear)."', '".addslashes($ExperienceMonth)."',  '".addslashes($Skill)."',   '".addslashes($Resume)."' , '".addslashes($Vacancy)."', '".addslashes($Salary)."', '".addslashes($SalaryFrequency)."',  '".$Config['TodayDate']."', '".addslashes($TestTakenVal)."', '".addslashes($EmpID1)."', '".addslashes($EmpID2)."', '".addslashes($EmpID3)."', '".addslashes($EmpName1)."', '".addslashes($EmpName2)."', '".addslashes($EmpName3)."')";

			$this->query($strSQLQuery, 0);

			$CanID = $this->lastInsertId();
			/*
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."logindetails.htm");
			$subject  = "Account Details";
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Candidate - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['Online'] == '1'){
				 $mail->Send();	
			}

			
			//Send Acknowledgment Email to admin
			$contents = file_get_contents($htmlPrefix."admin_signup.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Candidate - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['Online'] == '1'){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;
			*/

			return $CanID;

		}


		function UpdateCandidate($arryDetails){
			global $Config;
			extract($arryDetails);

			

			if(!empty($TestTaken)) $TestTakenVal = ltrim(implode(",",$TestTaken), ",");



			$UserName = trim($FirstName.' '.$LastName);
			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';


			$strSQLQuery = "update h_candidate set UserName='".addslashes($UserName)."', Email='".addslashes($Email)."',  FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', Gender='".addslashes($Gender)."',date_of_birth='".$date_of_birth."', 
			Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."',  InterviewStatus='".$InterviewStatus."' , OtherState='".addslashes($OtherState)."', OtherCity='".addslashes($OtherCity)."' ,ExperienceYear='".addslashes($ExperienceYear)."', ExperienceMonth='".addslashes($ExperienceMonth)."'	,UpdatedDate = '".$Config['TodayDate']."' , Vacancy='".addslashes($Vacancy)."' , Skill='".addslashes($Skill)."'	,ApplyDate='".addslashes($ApplyDate)."'	,Salary='".addslashes($Salary)."', SalaryFrequency='".addslashes($SalaryFrequency)."', TestTaken='".addslashes($TestTakenVal)."' ,EmpID1='".addslashes($EmpID1)."' ,EmpID2='".addslashes($EmpID2)."' ,EmpID3='".addslashes($EmpID3)."' ,EmpName1='".addslashes($EmpName1)."' ,EmpName2='".addslashes($EmpName2)."' ,EmpName3='".addslashes($EmpName3)."'
			where CanID='".$CanID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

					
		
		function RemoveCandidate($CanID)
		{
			global $Config;
			$objConfigure=new configure();
			$objFunction=new functions();
			if(!empty($CanID)){
				$strSQLQuery = "select Image,Resume from h_candidate where CanID='".mysql_real_escape_string($CanID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				 
				if($arryRow[0]['Image'] !='' ){				
					$objFunction->DeleteFileStorage($Config['CandidateDir'],$arryRow[0]['Image']);	
				}

				if($arryRow[0]['Resume'] !=''){				
					$objFunction->DeleteFileStorage($Config['CandResumeDir'],$arryRow[0]['Resume']);
				}			

				
				$strSQLQuery = "delete from h_candidate where CanID='".mysql_real_escape_string($CanID)."'"; 
				$this->query($strSQLQuery, 0);		
			}
		

			return 1;

		}

		function UpdateImage($Image,$CanID)
		{
			if(!empty($Image) && !empty($CanID)){
				$strSQLQuery = "update h_candidate set Image='".$Image."' where CanID='".$CanID."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		
		function UpdateResume($Resume,$CanID)
		{
			if(!empty($Resume) && !empty($CanID)){
				$strSQLQuery = "update h_candidate set Resume='".$Resume."' where CanID='".$CanID."'";
				$this->query($strSQLQuery, 0);
			}
			return true;
		}

		function changeCandidateStatus($CanID,$Status)
		{
			if(!empty($CanID)){
				$sql="update h_candidate set Status='".$Status."' where CanID='".$CanID."'";
				$this->query($sql,0);
			}
		}
		
		function changeCandidateStatus55($CanID)
		{
			if(!empty($CanID)){
				$sql="select CanID, Status from h_candidate where CanID='".$CanID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_candidate set Status='$Status' where CanID='".$CanID."'";
					$this->query($sql,0);				

					return true;
				}	
			}

		}
		

		function MultipleCandidateStatus($CanIDs,$Status)
		{
			$sql="select CanID from h_candidate where CanID in (".$CanIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update h_candidate set Status='".$Status."' where CanID in (".$CanIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function isEmailExists($Email,$CanID=0)
		{
			$strSQLQuery = (!empty($CanID))?(" and CanID != '".$CanID."'"):("");
			$strSQLQuery = "select CanID from h_candidate where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['CanID'])) {
				return true;
			} else {
				return false;
			}
		}

		function sendOfferLetter($arryDetail, $OfferLetterName)
		{
			global $Config;	
			extract($arryDetail);

			if(!empty($CanID)){
				$sql="update h_candidate set Status='Offered',JoiningDate='".$JoiningDate."',OfferedDate='".$Config['TodayDate']."' where CanID='".$CanID."'";
				$this->query($sql,0);				

				$arryRow = $this->GetCandidate($CanID,''); 
				if($arryRow[0]['Vacancy']>0){
					$arryVacancy = $this->GetVacancy($arryRow[0]['Vacancy'],''); 
				}

				//echo '<pre>';print_r($arryVacancy);exit;
				$htmlPrefix = $Config['EmailTemplateFolder'];
				
				$contents = file_get_contents($htmlPrefix."offer_letter.htm");
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/';

				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[JobTitle]",stripslashes($arryVacancy[0]['JobTitle']),$contents);
				$contents = str_replace("[Vacancy]",stripslashes($arryVacancy[0]['Name']),$contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[Email]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[Mobile]",$arryRow[0]['Mobile'],$contents);
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[JoiningDate]",date($Config['DateFormat'], strtotime($JoiningDate)),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Offer Letter";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $OfferLetterName.$arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					if($OfferLetterName != ''){
						$mail->AddAttachment(getcwd().'/upload/offer_letter/'.$_SESSION['CmpID'].'/'.$OfferLetterName,$OfferLetterName);
					}
					$mail->Send();	
				}

				/***************************/

				$contents = file_get_contents($htmlPrefix."offer_letter_admin.htm");
				
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[JobTitle]",stripslashes($arryVacancy[0]['JobTitle']),$contents);
				$contents = str_replace("[Vacancy]",stripslashes($arryVacancy[0]['Name']),$contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[Email]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[Mobile]",$arryRow[0]['Mobile'],$contents);
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[JoiningDate]",date($Config['DateFormat'], strtotime($JoiningDate)),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Offer letter sent for vacancy: ".stripslashes($arryVacancy[0]['Name']);
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					if($OfferLetterName != ''){
						$mail->AddAttachment(getcwd().'/upload/offer_letter/'.$_SESSION['CmpID'].'/'.$OfferLetterName,$OfferLetterName);
					}
					$mail->Send();	
				}
			}
			return 1;
		}


	
		/**********Vacancy Functions *******/
		/***********************************/
		function  ListVacancy($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where v.vacancyID='".mysql_real_escape_string($id)."'"):(" where v.locationID='".$_SESSION['locationID']."'");

			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (v.JobTitle like '%".$SearchKey."%' or v.Name like '%".$SearchKey."%' or d.Department like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or v.NumPosition like '%".$SearchKey."%'  or v.Status like '%".$SearchKey."%'  ) " ):("");		
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by v.vacancyID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			if($Config['GetNumRecords']==1){
				$Columns = " count(v.vacancyID) as NumCount ";				
			}else{				
				$Columns = "  v.*,e.UserName,d.Department as DepartmentName ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
			$strSQLQuery = "select ".$Columns." from h_vacancy v left outer join h_employee e on v.HiringManager=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
					
		}

		function  GetVacancy($vacancyID,$Status)
		{
			$strSQLQuery = "select v.*,e.UserName,e.Email,d.Department as DepartmentName from h_vacancy v left outer join h_employee e on v.HiringManager=e.EmpID left outer join h_department d on e.Department=d.depID";

			$strSQLQuery .= (!empty($vacancyID))?(" where v.vacancyID='".mysql_real_escape_string($vacancyID)."'"):(" where v.locationID='".$_SESSION['locationID']."'");
			$strSQLQuery .= (!empty($Status))?(" and v.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}

		function isVacancyExists($Name,$vacancyID=0)
		{
				$strSQLQuery = (!empty($vacancyID))?(" and vacancyID != '".$vacancyID."'"):("");
				$strSQLQuery = "select vacancyID from h_vacancy where LCASE(Name)='".strtolower(trim($Name))."' and locationID='".$_SESSION['locationID']."'".$strSQLQuery;
				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['vacancyID'])) {
					return true;
				} else {
					return false;
				}
		}

		function RemoveVacancy($vacancyID)
		{
			if(!empty($vacancyID)){
				$strSQLQuery = "delete from h_vacancy where vacancyID='".mysql_real_escape_string($vacancyID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

		function changeVacancyStatus($vacancyID)
		{
				/*
				if(!empty($vacancyID)){
					$sql="select * from h_vacancy where vacancyID='".$vacancyID."'";
					$rs = $this->query($sql);
					if(sizeof($rs))
					{
						if($rs[0]['Status']==1)
							$Status=0;
						else
							$Status=1;
							
						$sql="update h_vacancy set Status='$Status' where vacancyID='".$vacancyID."'";
						$this->query($sql,0);				

						return true;
					}	
				}
				
				*/		
		}

		function AddVacancy($arryDetails)
		{  
			global $Config;
			extract($arryDetails);
		
			$strSQLQuery = "insert into h_vacancy (locationID, Department, JobTitle, Name, HiringManager, NumPosition, Description, Status, MinAge, MaxAge, MinExp, MaxExp, PostedDate, Exceptional, MinSalary, MaxSalary, Qualification, OtherQualification, Skill) values(  '".$_SESSION['locationID']."', '".$Department."', '".addslashes($JobTitle)."', '".addslashes($Name)."', '".addslashes($HiringManager)."', '".addslashes($NumPosition)."','".addslashes($Description)."', '".$Status."', '".$MinAge."', '".$MaxAge."', '".$MinExp."', '".$MaxExp."', '".$Config['TodayDate']."', '".$Exceptional."', '".$MinSalary."', '".$MaxSalary."', '".addslashes($Qualification)."', '".addslashes($OtherQualification)."', '".addslashes($Skill)."')";
			$this->query($strSQLQuery, 0);
			$vacancyID = $this->lastInsertId();
			return $vacancyID;
		}


		function UpdateVacancy($arryDetails){   
			extract($arryDetails);

			if(!empty($vacancyID)){
				$strSQLQuery = "update h_vacancy set Department='".$Department."', JobTitle='".addslashes($JobTitle)."', Name='".addslashes($Name)."',  HiringManager='".addslashes($HiringManager)."', NumPosition='".addslashes($NumPosition)."', Description='".addslashes($Description)."', Qualification='".addslashes($Qualification)."', OtherQualification='".addslashes($OtherQualification)."', Skill='".addslashes($Skill)."',  Status='".$Status."',  Exceptional='".$Exceptional."',  MinAge='".$MinAge."',  MaxAge='".$MaxAge."',  MinExp='".$MinExp."',  MaxExp='".$MaxExp."',  MinSalary='".$MinSalary."',  MaxSalary='".$MaxSalary."'
				where vacancyID='".$vacancyID."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

		
		function sendVacancyEmail($vacancyID)
		{
			global $Config;	
			if(!empty($vacancyID)){
				$arryRow = $this->GetVacancy($vacancyID,''); 
		
				$htmlPrefix = $Config['EmailTemplateFolder'];
				
				$Exceptional = ($arryVacancy[0]['Exceptional'] == 1)?('Yes'):('No');

				$contents = file_get_contents($htmlPrefix."vacancy.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPANY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[Currency]",$Config['Currency'],$contents);

				$contents = str_replace("[JobTitle]",stripslashes($arryRow[0]['JobTitle']),$contents);
				$contents = str_replace("[VacancyName]",stripslashes($arryRow[0]['Name']),$contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[NumPosition]",$arryRow[0]['NumPosition'],$contents);
				$contents = str_replace("[Qualification]",stripslashes($arryRow[0]['Qualification']),$contents);
				$contents = str_replace("[Skill]",stripslashes($arryRow[0]['Skill']),$contents);
				$contents = str_replace("[MinExp]",$arryRow[0]['MinExp'],$contents);
				$contents = str_replace("[MaxExp]",$arryRow[0]['MaxExp'],$contents);
				$contents = str_replace("[MinAge]",$arryRow[0]['MinAge'],$contents);
				$contents = str_replace("[MaxAge]",$arryRow[0]['MaxAge'],$contents);
				$contents = str_replace("[MinSalary]",$arryRow[0]['MinSalary'],$contents);
				$contents = str_replace("[MaxSalary]",$arryRow[0]['MaxSalary'],$contents);
				$contents = str_replace("[Description]",stripslashes($arryRow[0]['Description']),$contents);
				$contents = str_replace("[Exceptional]",$Exceptional,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[PostedDate]",date("j M Y", strtotime($arryRow[0]['PostedDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Vacancy Status - ".$arryRow[0]['Status'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/

				$contents = file_get_contents($htmlPrefix."vacancy_admin.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPANY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[Currency]",$Config['Currency'],$contents);

				$contents = str_replace("[JobTitle]",stripslashes($arryRow[0]['JobTitle']),$contents);
				$contents = str_replace("[VacancyName]",stripslashes($arryRow[0]['Name']),$contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[NumPosition]",$arryRow[0]['NumPosition'],$contents);
				$contents = str_replace("[Qualification]",stripslashes($arryRow[0]['Qualification']),$contents);
				$contents = str_replace("[Skill]",stripslashes($arryRow[0]['Skill']),$contents);
				$contents = str_replace("[MinExp]",$arryRow[0]['MinExp'],$contents);
				$contents = str_replace("[MaxExp]",$arryRow[0]['MaxExp'],$contents);
				$contents = str_replace("[MinAge]",$arryRow[0]['MinAge'],$contents);
				$contents = str_replace("[MaxAge]",$arryRow[0]['MaxAge'],$contents);
				$contents = str_replace("[MinSalary]",$arryRow[0]['MinSalary'],$contents);
				$contents = str_replace("[MaxSalary]",$arryRow[0]['MaxSalary'],$contents);
				$contents = str_replace("[Description]",stripslashes($arryRow[0]['Description']),$contents);
				$contents = str_replace("[Exceptional]",$Exceptional,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[PostedDate]",date("j M Y", strtotime($arryRow[0]['PostedDate'])),$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				if(!empty($arryRow[0]['Email'])){
					$mail->AddCC($arryRow[0]['Email']);
				}			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Vacancy Status - ".$arryRow[0]['Status'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
			}
			return 1;
		}

		function UpdateVacancyAfterJoining($vacancyID)
		{	
			if($vacancyID>0){
				$strSQLQuery = "update h_vacancy set Hired=Hired+1 where vacancyID='".$vacancyID."'"; 
				$this->query($strSQLQuery, 0);			
			}
			return 1;
		}

	/***********************************/
	/***********************************/

}
?>
