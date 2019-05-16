<?
class reseller extends dbClass
{
		//constructor
		function reseller()
		{
			$this->dbClass();
		} 
		
		function  ListReseller($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where r.RsID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			if($SearchKey=='active' && ($sortby=='r.Status' || $sortby=='') ){
				$strAddQuery .= " and r.Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='r.Status' || $sortby=='') ){
				$strAddQuery .= " and r.Status='0'";
			}else if($sortby != ''){

				if($sortby=='r.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");

				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (r.FullName like '%".$SearchKey."%' or r.CompanyName like '%".$SearchKey."%' or r.Email like '%".$SearchKey."%' or r.RsID like '%".$SearchKey."%'  ) " ):("");			}		


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by r.FullName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			if($Config['GetNumRecords']==1){
				$Columns = " count(r.RsID) as NumCount ";				
			}else{				
				$Columns = " r.RsID,r.Status,r.CompanyName,r.FullName,r.Email,r.ExpiryDate  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}				
			}	

			 $strSQLQuery = "select ".$Columns." from reseller r ".$strAddQuery;
		
			
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function  GetResellerImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where RsID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strSQLQuery = "select e.Image  from reseller e ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		
		function  GetReseller($RsID,$Status)
		{
			$strSQLQuery = "select e.* from reseller e ";

			$strSQLQuery .= (!empty($RsID))?(" where e.RsID='".mysql_real_escape_string($RsID)."'"):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and e.Status='".mysql_real_escape_string($Status)."'"):("");
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetResellerBrief($RsID)
		{
			$strAddQuery = '';

			$strAddQuery .= (!empty($RsID))?(" and r.RsID='".mysql_real_escape_string($RsID)."'"):("");
			$strSQLQuery = "select r.RsID, r.FullName, r.CompanyName, r.Email, r.Image from reseller r where r.Status='1' ".$strAddQuery." order by r.CompanyName asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetResellerCompany($RsID)
		{			
			$strSQLQuery = "select count(CmpID) as TotalCmp from company where RsID='".$RsID."' ";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['TotalCmp'];
		}

		function  GetResellerByEmail($Email)
		{
			if(!empty($Email)){
				$strSQLQuery = "select RsID,FullName,Email from reseller where Email='".mysql_real_escape_string($Email)."' ";
				return $this->query($strSQLQuery, 1);
			}
		}




		function  GetResellerDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where e.RsID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strAddQuery .= " order by e.JoiningDate Desc ";

			$strSQLQuery = "select e.*,r.name as Country , if(e.city_id>0,ct.name,e.OtherCity) as City, if(e.state_id>0,s.name,e.OtherState) as State from reseller e left outer join country c on e.country_id=r.country_id left outer join state s on e.state_id=s.state_id left outer join city ct on e.city_id=ct.city_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}


		function AddReseller($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			#if(empty($Status)) $Status=1;
	
			$ipaddress = GetIPAddress();
			if($JoiningDate<=0) $JoiningDate = date('Y-m-d');
			$FullName = $FirstName.' '.$LastName;
			$CreatedDate= date('Y-m-d H:i:s');

			$strSQLQuery = "insert into reseller ( FirstName, LastName, FullName, Email,Password,CompanyName,Description, Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber, AlternateEmail,  Status, JoiningDate, ExpiryDate, OtherState, OtherCity,TempPass,ipaddress, UpdatedDate, Fax, Website,CreatedDate) values(  '".addslashes($FirstName)."',  '".addslashes($LastName)."',  '".addslashes($FullName)."', '".addslashes($Email)."', '".md5($Password)."', '".addslashes($CompanyName)."', '".addslashes($Description)."',  '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."', '".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."', '".addslashes($LandlineNumber)."', '".addslashes($AlternateEmail)."', '".$Status."', '".$JoiningDate."', '".$ExpiryDate."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".$Password."', '".$ipaddress."', '".date('Y-m-d')."', '".addslashes($Fax)."', '".addslashes($Website)."',  '".$CreatedDate."')";
			//echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);

			$RsID = $this->lastInsertId();

			$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['EmailTemplateFolder']):($Config['EmailTemplateFolder']);

			$_SESSION['mess_account'] = SUCCESSFULLY_REGISTERED;
			$contents = file_get_contents($htmlPrefix."logindetails.htm");
			$subject  = "Account Details";
			
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[FULLNAME]",$FullName, $contents);
			$contents = str_replace("[FullName]",$FullName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[FULLNAME]",$FullName, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Reseller - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['Online'] == '5555555'){
				 $mail->Send();	
			}

			//echo $ResellerApproval.$Email.$Config['AdminEmail'].$contents; 



			if($Config['RecieveSignEmail']=='y'){
					//Send Acknowledgment Email to admin
					$contents = file_get_contents($htmlPrefix."admin_signup.htm");

					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

					$contents = str_replace("[FULLNAME]",$FullName, $contents);
					$contents = str_replace("[FullName]",$FullName, $contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[USERNAME]",$FullName,$contents);
					$contents = str_replace("[ReferenceNo]",$RsID,$contents);

					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Config['AdminEmail']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Reseller - ".$subject;
					$mail->IsHTML(true);
					//echo $Config['AdminEmail'].$contents; exit;
					$mail->Body = $contents;    
					if($Config['Online'] == '5555555'){
						$mail->Send();	
					}

			}


			return $RsID;

		}


		function UpdateReseller($arryDetails){   
			extract($arryDetails);

			if(!empty($RsID)){
			
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				if(empty($Status)) $Status=1;


				$strSQLQuery = "update reseller set FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', FullName='".addslashes($FullName)."',  Email='".addslashes($Email)."', CompanyName='".addslashes($CompanyName)."', Description='".addslashes($Description)."', 
				Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', AlternateEmail='".addslashes($AlternateEmail)."', Status='".$Status."'
				,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'			 
				,UpdatedDate = '".date('Y-m-d')."'
				where RsID='".$RsID."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}


		function UpdateResellerProfile($arryDetails){   
			extract($arryDetails);

			if(!empty($RsID)){
				$FullName = $FirstName.' '.$LastName;
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';

				 $strSQLQuery = "update reseller set FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', FullName='".addslashes($FullName)."', CompanyName='".addslashes($CompanyName)."', Description='".addslashes($Description)."',   Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', AlternateEmail='".addslashes($AlternateEmail)."', OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."' 
				,UpdatedDate = '".date('Y-m-d')."', Fax='".addslashes($Fax)."', Website='".addslashes($Website)."'	where RsID='".mysql_real_escape_string($RsID)."'"; 
				$this->query($strSQLQuery, 0);

			}

			return 1;
		}

	

		function UpdateAccount($arryDetails){   
			extract($arryDetails);

			if(!empty($RsID)){
				$AddSql = '';
				
				$sql = "select RsID,FullName,Email from reseller where RsID='".mysql_real_escape_string($RsID)."'";
				$arryRow = $this->query($sql, 1);
			

				#if(empty($Status)) $Status=1;
				if(!empty($Password)) $AddSql .= ", Password='".md5($Password)."'" ;

				if(!is_null($ExpiryDate)) $AddSql .= ", ExpiryDate='".$ExpiryDate."'" ;
				

				$strSQLQuery = "update reseller set Email='".addslashes($Email)."', Status='".$Status."' ".$AddSql." where RsID='".$RsID."'"; 
				$this->query($strSQLQuery, 0);


			}

			return 1;
		}		
		

		function ChangePassword($RsID,$Password)
		{
			
			if(!empty($RsID) && !empty($Password)){
				global $Config;				
			
				$strSQLQuery = "update reseller set Password='".mysql_real_escape_string(md5($Password))."' where RsID='".mysql_real_escape_string($RsID)."'"; 
				$this->query($strSQLQuery, 0);

				$sql = "select RsID,FullName,Email from reseller where RsID='".mysql_real_escape_string($RsID)."'";
				$arryRow = $this->query($sql, 1);

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."password.htm");
				
				$ResellerUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FullName]",$arryRow[0]['FullName'],$contents);
				$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$ResellerUrl, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your login details have been reset.";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents;exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}		
		
		function IsActivatedReseller($RsID,$verification_code)
		{
			$sql = "select * from reseller where RsID='".mysql_real_escape_string($RsID)."' and verification_code='".$verification_code."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['RsID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		

		
		function ForgotPassword($Email,$RsID){
			
			global $Config;

			if(!empty($Email)){
				$sql = "select * from reseller where Email='".mysql_real_escape_string($Email)."' and RsID='".mysql_real_escape_string($RsID)."' and Status='1'"; 
				$arryRow = $this->query($sql, 1);
				$FullName = $arryRow[0]['FullName'];

				if(sizeof($arryRow)>0)
				{

					$Password = substr(md5(rand(100,10000)),0,8);
					
					$sql_u = "update reseller set Password='".md5($Password)."'
					where Email='".$Email."'";
					$this->query($sql_u, 0);

					$htmlPrefix = $Config['EmailTemplateFolder'];

					$contents = file_get_contents($htmlPrefix."forgot.htm");
					
					$ResellerUrl = $Config['Url'].$Config['AdminFolder'].'/';
					$contents = str_replace("[COMPNAY_URL]",$ResellerUrl,$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FullName]",$arryRow[0]['FullName'],$contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
							
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Email);
					$mail->AddBCC('parwez.khan@sakshay.in');
					$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Administrator - New Password";
					$mail->IsHTML(true);
					$mail->Body = $contents;  

					//echo $Email.$Config['AdminEmail'].$contents; exit;

					if($Config['Online'] == '1'){
						$mail->Send();	
					}
					return 1;
				}else{
					return 0;
				}
			}

		}				
		
		function RemoveReseller($RsID)
		{
			global $Config;
			$objFunction=new functions();
			if(!empty($RsID)){
				$strSQLQuery = "select Email,Image from reseller where RsID='".mysql_real_escape_string($RsID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
			  		 
				if($arryRow[0]['Image'] !='' ){				
					$objFunction->DeleteFileStorage($Config['ResellerDir'],$arryRow[0]['Image']);		
				} 
				
				$strSQLQuery = "delete from reseller where RsID='".mysql_real_escape_string($RsID)."'"; 
				$this->query($strSQLQuery, 0);			

							
			}

			return 1;

		}

		function UpdateImage($Image,$RsID)
		{
			if(!empty($Image) && !empty($RsID)){
				$strSQLQuery = "update reseller set Image='".mysql_real_escape_string($Image)."' where RsID='".mysql_real_escape_string($RsID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}

		
		function changeResellerStatus($RsID)
		{
			if(!empty($RsID)){
				$sql="select RsID,Status from reseller where RsID='".mysql_real_escape_string($RsID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update reseller set Status='$Status' where RsID='".mysql_real_escape_string($RsID)."'";
					$this->query($sql,0);					
				}	
			}

			return true;

		}
		

		function ActivateReseller($arryDet)
		{
			global $Config;
			extract($arryDet);
			if(!empty($Email)){
				$sql="select RsID,Status,FullName from reseller where Email='".$Email."'";
				$arryCmp = $this->query($sql);
				if(sizeof($arryCmp))
				{
					$Status=1;						
					$sql2="update reseller set Status='".$Status."',Password='".md5($Password)."' where RsID='".$arryCmp[0]['RsID']."'";
					$this->query($sql2,0);	

					/************************/
					//mail to user
		
				$htmlPrefix = 'superadmin/'.$Config['EmailTemplateFolder'];

				//$ResellerUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$ResellerUrl = $Config['Url'].'crm/';	
				$contents = file_get_contents($htmlPrefix."logindetails.htm");
				
				$contents = str_replace("[URL]",$ResellerUrl,$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

				$contents = str_replace("[FullName]",$arryCmp[0]['FullName'], $contents);
				$contents = str_replace("[EMAIL]",$Email,$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[FULLNAME]",$FullName, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Email);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']. " :: Account Activated";
				$mail->IsHTML(true);
				$mail->Body = $contents;   
				if($Config['Online'] == '1'){
					 $mail->Send();	
				}

				//echo $Email.$Config['AdminEmail'].$contents; 


					/************************/

				
				}	
			}

			return true;

		}

		

		function MultipleResellerStatus($RsIDs,$Status)
		{
			$sql="select RsID from reseller where RsID in (".$RsIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update reseller set Status='".$Status."' where RsID in (".$RsIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function ValidateReseller($Email,$Password,$RsID){
			if(!empty($Email) && !empty($Password)){
				$strSQLQuery = "select * from reseller where MD5(Email)='".md5($Email)."' and Password='".md5($Password)."' and RsID='".$RsID."' and Status='1'"; 
				return $this->query($strSQLQuery, 1);
			}
		}

		function isEmailExists($Email,$RsID=0)
		{
			$strSQLQuery = (!empty($RsID))?(" and RsID != '".mysql_real_escape_string($RsID)."'"):("");
			$strSQLQuery = "select RsID from reseller where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;

		
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['RsID'])) {
				return true;
			} else {
				return false;
			}
		}
	
				
		function UpdatePasswordEncrypted($RsID,$Password)
		{
			if(!empty($RsID) && !empty($Password)){
				$sql = "update reseller set Password='".md5($Password)."', PasswordUpdated='1'  where RsID = '".mysql_real_escape_string($RsID)."'";
				$rs = $this->query($sql,0);
			}
				
			return true;

		}


		function UpdateDiscount($arryDetails){   
			extract($arryDetails);

			if(!empty($RsID)){
				 $strSQLQuery = "update reseller set DiscountS='".addslashes($DiscountS)."', DiscountP='".addslashes($DiscountP)."', DiscountE='".addslashes($DiscountE)."', DiscountPC='".addslashes($DiscountPC)."' where RsID='".mysql_real_escape_string($RsID)."'"; 
				$this->query($strSQLQuery, 0);

			}

			return 1;
		}

		function UpdateAccountLimit($arryDetails){   
			extract($arryDetails);

			if(!empty($RsID)){
				 $strSQLQuery = "update reseller set AccountLimit='".addslashes($AccountLimit)."', PaymentMethod='".addslashes($PaymentMethod)."', PaymentTerm='".addslashes($PaymentTerm)."' where RsID='".mysql_real_escape_string($RsID)."'"; 
				$this->query($strSQLQuery, 0);

			}

			return 1;
		}


		////////////Tier Management Start ///// 
		
		function  GetResellerWithComm($RsID,$Status){
			$strSQLQuery = "select e.*,r.CommOn from reseller e left outer join r_commission r on e.RsID=r.RsID ";

			$strSQLQuery .= (!empty($RsID))?(" where e.RsID='".mysql_real_escape_string($RsID)."'"):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and e.Status='".mysql_real_escape_string($Status)."'"):("");
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}

		function  GetSalesCommission($RsID){
			if(!empty($RsID)){
				$strSQLQuery = "select c.*,t.Percentage,t.RangeFrom,t.RangeTo,s.SalesTarget,s.SpiffAmount from r_commission c left outer join r_tier t on c.tierID=t.tierID left outer join r_spiff s on c.spiffID=s.spiffID where c.RsID= '".mysql_real_escape_string($RsID)."' order by c.comID Asc";
				return $this->query($strSQLQuery, 1);
			}
		}

		function UpdateSalesCommission($arryDetails){   
			global $Config;
			extract($arryDetails);	
			/******************/
			$arrytierID = explode("|",$tierID);
			$tierID = $arrytierID[0];

			$arryspiffID = explode("|",$spiffID);
			$spiffID = $arryspiffID[0];
			/******************/

			$sql = "select RangeFrom,RangeTo from r_tier where tierID='".$tierID."' ";
			$arryRow = $this->query($sql, 1);
			$RangeFrom = $arryRow[0]["RangeFrom"];
			$RangeTo = $arryRow[0]["RangeTo"];

			/*$PrevRange = $this->GerPrevTier($RangeFrom);
			$NextRange = $this->GerNextTier($RangeFrom);
			if(empty($PrevRange)) $PrevRange=0;

			$TargetFrom = $PrevRange+1;
			$TargetTo = $RangeFrom;

			if($RangeFrom==$TargetTo && empty($NextRange)) $TargetTo=0;
			
			#echo $RangeFrom.' = '.$TargetFrom.' - '.$TargetTo;exit;
			*/
			
			$TargetFrom = $RangeFrom;
			$TargetTo = $RangeTo;

			/******************/


			if(!empty($RsID)){
				$sql = "select RsID from r_commission where RsID='".$RsID."' ";
				$arryRow = $this->query($sql, 1);
	
				if($arryRow[0]['RsID']>0){
					$strSQLQuery = "update r_commission set CommType='".mysql_real_escape_string(strip_tags($CommType))."', tierID='".mysql_real_escape_string(strip_tags($tierID))."', spiffID='".mysql_real_escape_string(strip_tags($spiffID))."', SalesPersonType='".mysql_real_escape_string(strip_tags($SalesPersonType))."', Accelerator='".mysql_real_escape_string(strip_tags($Accelerator))."', AcceleratorPer='".mysql_real_escape_string(strip_tags($AcceleratorPer))."', TargetFrom='".mysql_real_escape_string(strip_tags($TargetFrom))."', TargetTo='".mysql_real_escape_string(strip_tags($TargetTo))."', CommPercentage='".mysql_real_escape_string(strip_tags($CommPercentage))."', SpiffTarget='".mysql_real_escape_string(strip_tags($SpiffTarget))."', SpiffEmp='".mysql_real_escape_string(strip_tags($SpiffEmp))."', CommOn='".mysql_real_escape_string(strip_tags($CommOn))."',CommissionType='".mysql_real_escape_string($Commission_type)."' where RsID='".mysql_real_escape_string($RsID)."'" ;
$this->query($strSQLQuery, 0);	
				}else if(!empty($CommType)){
					$strSQLQuery = "insert into r_commission (RsID, CommType, tierID, spiffID, SalesPersonType, Accelerator, AcceleratorPer, TargetFrom, TargetTo, CommPercentage, SpiffTarget, SpiffEmp, CommOn,CommissionType ) values('".mysql_real_escape_string($RsID)."', '".mysql_real_escape_string($CommType)."', '".mysql_real_escape_string(strip_tags($tierID))."', '".mysql_real_escape_string(strip_tags($spiffID))."','".mysql_real_escape_string(strip_tags($SalesPersonType))."', '".mysql_real_escape_string(strip_tags($Accelerator))."', '".mysql_real_escape_string(strip_tags($AcceleratorPer))."', '".mysql_real_escape_string($TargetFrom)."', '".mysql_real_escape_string($TargetTo)."', '".mysql_real_escape_string($CommPercentage)."', '".mysql_real_escape_string($SpiffTarget)."', '".mysql_real_escape_string($SpiffEmp)."', '".mysql_real_escape_string($CommOn)."','".mysql_real_escape_string($Commission_type)."')";
$this->query($strSQLQuery, 0);	
				}
				

			}

			return 1;

		}




		function  GetSalesPayment($FromDate,$ToDate,$RsID)
		{

                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($RsID))?(" and o.RsID='".$RsID."'"):("");			

			$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by o.RsID";

			$arryRow = $this->query($strSQLQuery, 1);

			return $arryRow[0]['TotalSales'];
				
		}

		function  GetSalesPaymentNonResidual($FromDate,$ToDate,$RsID)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($RsID))?(" and o.RsID='".$RsID."'"):("");
	
			$sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);

		
			if(!empty($arryInvoice[0]["InvoiceID"])){
				$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." group by o.RsID";
			
				$arryRow = $this->query($strSQLQuery, 1);
			}

			return $arryRow[0]['TotalSales'];
				
		}

		function  SalesCommReport($FromDate,$ToDate,$RsID)
		{
                        global $Config;

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($RsID))?(" and o.RsID='".$RsID."'"):("");			

			$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales,o.RsID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' ) where o.Module='Invoice' and o.RsID>'0' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by o.RsID order by o.RsID asc";
			
			return $this->query($strSQLQuery, 1);		
		}

		function  PaymentReport($FromDate,$ToDate,$RsID)
		{
                         global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($RsID))?(" and o.RsID='".$RsID."'"):("");			

			$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,o.InvoiceDate,o.OrderDate,o.CustomerName,o.TotalAmount from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' )  where o.Module='Invoice' and o.RsID>'0' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." order by p.PaymentDate desc,p.PaymentID desc";

				
			return $this->query($strSQLQuery, 1);		
		}



		function  GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$RsID)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($RsID))?(" and o.RsID='".$RsID."'"):("");			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");			

			$strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." ";

			return $this->query($strSQLQuery, 1);
							
		}

		function  GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$RsID)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($RsID))?(" and o.RsID='".$RsID."'"):("");
			

			$sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);
			
			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
			if(!empty($arryInvoice[0]["InvoiceID"])){
				$strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." ";
			
				return $this->query($strSQLQuery, 1);
			}
			
				
		}


}
?>
