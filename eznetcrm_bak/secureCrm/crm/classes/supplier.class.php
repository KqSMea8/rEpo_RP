<?
class supplier extends dbClass
{
		//constructor
		function supplier()
		{
			$this->dbClass();
		} 
		
		function  ListSupplier($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			#$strAddQuery .= (!empty($id))?(" where s.SuppID='".$id."'"):(" where s.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($id))?(" where s.SuppID='".$id."'"):(" where 1");
                         $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev

			if($SearchKey=='active' && ($sortby=='s.Status' || $sortby=='') ){
				$strAddQuery .= " and s.Status=1"; 
			}else if($SearchKey=='inactive' && ($sortby=='s.Status' || $sortby=='') ){
				$strAddQuery .= " and s.Status=0";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (s.SuppCode like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' or ab.Country like '%".$SearchKey."%' or ab.State like '%".$SearchKey."%' or ab.City like '%".$SearchKey."%' or s.Currency like '%".$SearchKey."%'   ) " ):("");		
			}
			$strAddQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by s.SuppID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Desc");

			#$strSQLQuery = "select s.SuppID,s.SuppCode,s.UserName,ab.Country,ab.State, ab.City,s.Email,s.CompanyName,s.Mobile,s.Status,s.Currency from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery;
		
		$strSQLQuery = "select s.*,ab.Country,ab.State, ab.City from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery;
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function GetSupplierUser($UserID,$Status){
			if(!empty($UserID)){
				$strSQLQuery = "select * from p_supplier where UserID='".mysql_real_escape_string($UserID)."' ";
				$strSQLQuery .= ($Status>0)?(" and Status='".$Status."' "):("");			
				return $this->query($strSQLQuery, 1);
			}
		}

		function GetSupplierList($arryDetails)
		{
			extract($arryDetails);

			$strSQLQuery = "select s.SuppID,s.SuppCode,s.UserName,s.Email,s.CompanyName from p_supplier s where 1 ";

			#$strSQLQuery .= (!empty($SuppID))?(" and s.SuppID='".$SuppID."'"):(" and s.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= (!empty($SuppID))?(" and s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" ");
			$strSQLQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}

		function  GetSupplierImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.SuppID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strSQLQuery = "select s.Image from p_supplier s ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

	

		function  GetSupplier($SuppID,$SuppCode,$Status)
		{
			$strSQLQuery = "select s.*,ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ";

			#$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".$SuppID."'"):(" and s.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
			$strSQLQuery .= (!empty($SuppCode))?(" and s.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
			$strSQLQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}		
		
		function GetSupplierBrief($SuppID)
		{
			#$strAddQuery .= (!empty($SuppID))?(" and s.SuppID='".$SuppID."'"):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($SuppID))?(" and s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" ");
			$strSQLQuery = "select s.SuppID,s.SuppCode,s.UserName,s.Email,s.CompanyName from p_supplier s where s.Status=1 ".$strAddQuery." order by s.CompanyName asc";
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllSuppliers($Status)
		{
			$strSQLQuery = "select SuppID,UserName,CompanyName,Email from p_supplier where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status.""):("");

			$strSQLQuery .= " order by CompanyName,UserName Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetSupplierDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.SuppID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strAddQuery .= " order by s.SuppID Desc ";

			$strSQLQuery = "select s.*,c.name as Country , if(s.city_id>0,ct.name,s.OtherCity) as City, if(s.state_id>0,s.name,s.OtherState) as State from p_supplier s left outer join country c on s.country_id=c.country_id left outer join state s on s.state_id=s.state_id left outer join city ct on s.city_id=ct.city_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function  GetShippingBilling($SuppID,$AddType)
		{
			$strSQLQuery = "select p.* from  p_address_book p inner join p_supplier s on p.SuppID=s.SuppID ";

			$strSQLQuery .= (!empty($SuppID))?(" where p.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
			$strSQLQuery .= (!empty($AddType))?(" and p.AddType='".$AddType."'"):("");

			return $this->query($strSQLQuery, 1);
		}


		function AddSupplier($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
	
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 

			$strSQLQuery = "insert into p_supplier (SuppCode,UserName,Email,Password,FirstName,LastName, CompanyName, Address, city_id, state_id, ZipCode, country_id,Mobile, Landline, Fax, Website, Status, OtherState, OtherCity, TempPass,ipaddress, UpdatedDate, Currency , SupplierSince, TaxNumber, PaymentMethod, ShippingMethod, PaymentTerm, CustomerVendor) values('".addslashes($SuppCode)."', '".addslashes($UserName)."', '".addslashes($Email)."', '".md5($Password)."','".addslashes($FirstName)."', '".addslashes($LastName)."','".addslashes($CompanyName)."', '".addslashes(strip_tags($Address))."' ,  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($Landline)."', '".addslashes($Fax)."',  '".addslashes($Website)."', '".$Status."',    '".addslashes($OtherState)."', '".addslashes($OtherCity)."', '".$Password."', '".$ipaddress."', '".$Config['TodayDate']."','".$Currency."' ,'".$SupplierSince."', '".addslashes($TaxNumber)."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".$CustomerVendor."')";
			$this->query($strSQLQuery, 0);
			$SuppID = $this->lastInsertId();

			if(empty($SuppCode)){
				$SuppCode = 'VEN000'.$SuppID;
				$strSQL = "update p_supplier set SuppCode='".$SuppCode."' where SuppID='".$SuppID."'"; 
				$this->query($strSQL, 0);
			}

			return $SuppID;

		}


		function UpdateSupplier($arryDetails){ 
			global $Config;
			extract($arryDetails);

			if(!empty($SuppID)){
				$UserName = trim($FirstName.' '.$LastName);
		
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				if(empty($Status)) $Status=1;


				$strSQLQuery = "update p_supplier set UserName='".addslashes($UserName)."', Email='".addslashes($Email)."',  FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', CompanyName='".addslashes($CompanyName)."',
				Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' , Website='".addslashes($Website)."', Status='".$Status."' ,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'	 
				,UpdatedDate = '".$Config['TodayDate']."',Currency='".$Currency."' ,SupplierSince='".$SupplierSince."', TaxNumber='".addslashes($TaxNumber)."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."'
				where SuppID='".mysql_real_escape_string($SuppID)."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

	

		function UpdateGeneral($arryDetails){   
			global $Config;
			extract($arryDetails);

			if(!empty($SuppID)){
				if($Status=='') $Status=1;
				$UserName = trim($FirstName.' '.$LastName);	
				$strSQLQuery = "update p_supplier set CompanyName='".addslashes($CompanyName)."', UserName='".addslashes($UserName)."', FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."' , Email='".addslashes($Email)."', Mobile='".addslashes($Mobile)."', Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' , Website='".addslashes($Website)."', UpdatedDate = '".$Config['TodayDate']."', Status='".$Status."',Currency='".$Currency."',SupplierSince='".$SupplierSince."', TaxNumber='".addslashes($TaxNumber)."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."' where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

		function UpdateContact($arryDetails){   
			extract($arryDetails);	

			if(!empty($SuppID)){
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				$UserName = trim($FirstName.' '.$LastName);

				$strSQLQuery = "update p_supplier set UserName='".addslashes($UserName)."', FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."' , Email='".addslashes($Email)."', Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' , Website='".addslashes($Website)."', OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',UpdatedDate = '".$Config['TodayDate']."' where SuppID='".mysql_real_escape_string($SuppID)."'";
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function UpdateCountyStateCity($arryDetails,$SuppID){   
			extract($arryDetails);		
			if(!empty($SuppID)){
				$strSQLQuery = "update p_supplier set Country='".addslashes($Country)."',  State='".addslashes($State)."',  City='".addslashes($City)."' where SuppID='".mysql_real_escape_string($SuppID)."'";
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function UpdateAddCountryStateCity($arryDetails,$AddID){   
			extract($arryDetails);		
			if(!empty($AddID)){
				$strSQLQuery = "update p_address_book set Country='".addslashes($Country)."',  State='".addslashes($State)."',  City='".addslashes($City)."' where AddID='".mysql_real_escape_string($AddID)."'";
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}



		function UpdateShippingBilling($arryDetails,$AddType){ 
			global $Config;
			extract($arryDetails);		
			if(!empty($SuppID)){

				$arryBillShipp = $this->GetShippingBilling($SuppID,$AddType);
				if(empty($arryBillShipp[0]['AddID'])){
					$strSQL = "insert into p_address_book (SuppID,AddType) values( '".$SuppID."', '".addslashes($AddType)."')";
					$this->query($strSQL, 0);
					$AddID = $this->lastInsertId();
				}else{
					$AddID = $arryBillShipp[0]['AddID'];
				}

			
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';

				$strSQLQuery = "update p_address_book set Name='".addslashes($Name)."', Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', Email='".addslashes($Email)."',  Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',UpdatedDate = '".$Config['TodayDate']."' where AddID='".$AddID."' ";
				$this->query($strSQLQuery, 0);
			}
			return $AddID;
		}


		function UpdateBankDetail($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($SuppID)){
				$strSQLQuery = "update p_supplier set BankName='".addslashes($BankName)."'		,AccountName='".addslashes($AccountName)."'	, AccountNumber='".addslashes($AccountNumber)."', IFSCCode='".addslashes($IFSCCode)."',UpdatedDate = '".$Config['TodayDate']."'
				where SuppID='".$SuppID."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

				
		function UpdateAccount($arryDetails){   
			extract($arryDetails);
			if($Status=='') $Status=1;

			if(!empty($Password)) $PasswordSql = ", Password='".md5($Password)."'" ;
			
			if(!empty($SuppID)){
				$strSQLQuery = "update p_supplier set Email='".addslashes($Email)."', Status='".$Status."' ".$PasswordSql." where SuppID='".$SuppID."'";
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}


		function ChangePassword($SuppID,$Password)
		{
			global $Config;				
			if(!empty($SuppID) && !empty($Password)){
				$strSQLQuery = "update p_supplier set Password='".md5($Password)."' where SuppID='".mysql_real_escape_string($SuppID)."'";
				$this->query($strSQLQuery, 0);

				$sql = "select SuppID,UserName,Email from p_supplier where SuppID='".mysql_real_escape_string($SuppID)."'";
				$arryRow = $this->query($sql, 1);

				$htmlPrefix = 'hrms/'.$Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."password.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Vendor - Your login details have been reset";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}		
		
		function IsActivatedSupplier($SuppID,$verification_code)
		{
			$sql = "select * from p_supplier where SuppID='".$SuppID."' and verification_code='".$verification_code."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['SuppID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		
		
		function ForgotPassword($Email){
			
			global $Config;
			if(!empty($Email)){
				$sql = "select * from p_supplier where Email='".$Email."' and Status=1"; 
				$arryRow = $this->query($sql, 1);
				$UserName = $arryRow[0]['UserName'];

				if(sizeof($arryRow)>0)
				{
					$Password = substr(md5(rand(100,10000)),0,8);
					
					$sql_u = "update p_supplier set Password='".md5($Password)."'
					where Email='".$Email."'";
					$this->query($sql_u, 0);

					$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['EmailTemplateFolder']):($Config['EmailTemplateFolder']);

					$contents = file_get_contents($htmlPrefix."forgot.htm");
					
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[USERNAME]",$arryRow[0]['UserName'],$contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
							
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Email);
					$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Vendor - New Password";
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
		
		

		function RemoveSupplier($SuppID)
		{
			global $Config;
			$objConfigure=new configure();
			if(!empty($SuppID)){
				$strSQLQuery = "select UserID,Image from p_supplier where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				$ImgDir = 'upload/supplier/'.$_SESSION['CmpID'].'/';
			
				if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){				
					$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);					
					unlink($ImgDir.$arryRow[0]['Image']);	
				}
			
				$strSQLQuery = "delete from p_supplier where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery = "delete from p_address_book where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$this->query($strSQLQuery, 0);

				/********************
				if($arryRow[0]['UserID']>0){
					$objUser=new user();
					$objUser->RemoveUser($arryRow[0]['UserID']);		
				}
				/********************/
			}

			return 1;

		}

		function UpdateImage($Image,$SuppID)
		{
			if(!empty($SuppID) && !empty($Image)){
				$strSQLQuery = "update p_supplier set Image='".$Image."' where SuppID='".mysql_real_escape_string($SuppID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		
		function changeSupplierStatus($SuppID)
		{
			if(!empty($SuppID)){
				$sql="select SuppID,Status from p_supplier where SuppID='".$SuppID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update p_supplier set Status='$Status' where SuppID='".mysql_real_escape_string($SuppID)."'";
					$this->query($sql,0);				

					return true;
				}	
			}
		}
		

		function MultipleSupplierStatus($SuppIDs,$Status)
		{
			$sql="select SuppID from p_supplier where SuppID in (".$SuppIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update p_supplier set Status=".$Status." where SuppID in (".$SuppIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		
		function ValidateSupplier($Email,$Password){
			if(!empty($Email) && !empty($Password)){
				$strSQLQuery = "select * from p_supplier where Email='".$Email."' and Password='".md5($Password)."' and Status=1";
				return $this->query($strSQLQuery, 1);
			}
		}

		function isEmailExists($Email,$SuppID=0)
		{
			$strSQLQuery = (!empty($SuppID))?(" and SuppID != '".$SuppID."'"):("");
			$strSQLQuery = "select SuppID from p_supplier where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['SuppID'])) {
				return true;
			} else {
				return false;
			}
		}
                
                function isEmailExistsForCustomerVendor($Email,$UserName)
		{
			$strSQLQuery = "select SuppID from p_supplier where LCASE(Email)='".strtolower(trim($Email))."' and LCASE(UserName) = '".strtolower(trim($UserName))."'";
                        //echo "=>".$strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);
                        return $arryRow[0]['SuppID'];
		}
                
                function updateSupplierContactAddress($arryDetails){ 
			global $Config;
			extract($arryDetails);

			if(!empty($SuppID)){
				$UserName = trim($FirstName.' '.$LastName);
		
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				if(empty($Status)) $Status=1;


				$strSQLQuery = "update p_supplier set Address='".addslashes(strip_tags($Address))."', city_id='".$main_city_id."',state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Country ='".addslashes($Country)."', State ='".addslashes($State)."', City ='".addslashes($City)."', Mobile='".addslashes($Mobile)."', Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'	 
				,UpdatedDate = '".$Config['TodayDate']."' where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$this->query($strSQLQuery, 0);
                                
                                //update address
                                
                                $strSQLQueryAdd = "update p_address_book set Name='".addslashes($UserName)."', Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Country ='".addslashes($Country)."', State ='".addslashes($State)."', City ='".addslashes($City)."', Mobile='".addslashes($Mobile)."', Email='".addslashes($Email)."',  Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',UpdatedDate = '".$Config['TodayDate']."' where SuppID='".$SuppID."' and PrimaryContact=1";
				$this->query($strSQLQueryAdd, 0);
			}

			return 1;
		}

		function isSuppCodeExists($SuppCode,$SuppID=0)
		{
			$strSQLQuery = (!empty($SuppID))?(" and SuppID != '".$SuppID."'"):("");
			$strSQLQuery = "select SuppID from p_supplier where LCASE(SuppCode)='".strtolower(trim($SuppCode))."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['SuppID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isCompanyExists($CompanyName,$SuppID=0)
		{
			$strSQLQuery = (!empty($SuppID))?(" and SuppID != '".$SuppID."'"):("");
			$strSQLQuery = "select SuppID from p_supplier where LCASE(CompanyName)='".strtolower(trim($CompanyName))."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['SuppID'])) {
				return true;
			} else {
				return false;
			}
		}	
		
		function UpdatePasswordEncrypted($SuppID,$Password)
		{
			if(!empty($SuppID) && !empty($Password)){
				$sql = "update p_supplier set Password='".md5($Password)."', PasswordUpdated='1'  where SuppID = '".$SuppID."'";
				$rs = $this->query($sql,0);
			}
				
				return true;

		}

	
	/*****************************/
	/*****************************

		function  CountSupplier()
		{
			$strSQLQuery = "select count(SuppID) as TotalSupplier from p_supplier"; //where locationID=".$_SESSION['locationID'];
			return $this->query($strSQLQuery, 1);		
		}	

		function  GetNumSupplier($depID)
		{
			$strSQLQuery = "select count(SuppID) as TotalSupplier from p_supplier"; //where locationID=".$_SESSION['locationID'];
			return $this->query($strSQLQuery, 1);		
		}


	*****************************/

	function addSupplierAddress($arryDetails,$SupplierID,$AddType)
	{
		global $Config;
		extract($arryDetails);		

		if($main_city_id>0) $OtherCity = '';
		if($main_state_id>0) $OtherState = '';
		$FullName = $FirstName." ".$LastName;
			
		if(!empty($Name)) $FullName = $Name;
		$strSQLQuery = "INSERT INTO p_address_book set SuppID = '".$SupplierID."', AddType='".$AddType."', PrimaryContact = '".$PrimaryContact."', Name = '".mysql_real_escape_string(strip_tags($FullName))."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$country_id."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', UpdatedDate = '".$Config['TodayDate']."' ";

		$this->query($strSQLQuery, 0);

		$AddID = $this->lastInsertId();

		return $AddID;

	}


	function updateSupplierAddress($arryDetails,$AddID)
	{
			           
	     	global $Config;
		extract($arryDetails);		

		if($main_city_id>0) $OtherCity = '';
		if($main_state_id>0) $OtherState = '';		
		$FullName = $FirstName." ".$LastName;

		if(!empty($Name)) $FullName = $Name;
		$strSQLQuery = "update p_address_book set Name = '".mysql_real_escape_string(strip_tags($FullName))."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$country_id."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', UpdatedDate = '".$Config['TodayDate']."' where AddID='".$AddID."' ";
		$this->query($strSQLQuery, 0);		

		return true;
	   
	}   



	function  GetSupplierContact($SuppID,$PrimaryContact)
	{
		
		$strAddQuery .= (!empty($PrimaryContact))?(" and ab.PrimaryContact='".$PrimaryContact."'"):("");
		$strSQLQuery = "SELECT ab.* FROM p_address_book ab WHERE ab.SuppID='".$SuppID."' AND ab.AddType = 'contact' ".$strAddQuery." order by PrimaryContact Desc, AddID asc";
		return $this->query($strSQLQuery, 1);
	}

	function  GetAddressBook($AddID)
	{
		if($AddID>0){
		$strSQLQuery = "SELECT * FROM p_address_book WHERE AddID='".$AddID."' ";			
		return $this->query($strSQLQuery, 1);
		}
	}

	function RemoveSupplierContact($AddID)
	{			

		$strSQLQuery = "DELETE FROM p_address_book WHERE AddID = '".$AddID."'"; 

		$this->query($strSQLQuery, 0);

		return 1;

	}

	function isSuppAddressExists($SuppID,$AddType)
	{
		$strSAddQuery = (!empty($AddType))?(" and AddType = '".$AddType."'"):("");
		$strSQLQuery = "select AddID from p_address_book where SuppID='".$SuppID."'".$strSAddQuery;
	
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['AddID'])) {
			return true;
		} else {
			return false;
		}
	}

	function  GetAllAddress($SuppID)
	{
		$strSQLQuery = "SELECT ab.* FROM p_address_book ab WHERE ab.SuppID='".$SuppID."' order by PrimaryContact desc";
		return $this->query($strSQLQuery, 1);
	}	

	function  GetSupplierAddressBook($SuppID,$AddID)
	{
		if($AddID>0){
		$strSQLQuery = "SELECT  s.SuppCode,s.CompanyName,s.Currency, ab.* FROM p_address_book ab inner join p_supplier s on ab.SuppID=s.SuppID WHERE ab.AddID='".$AddID."' ";			
		return $this->query($strSQLQuery, 1);
		}
	}




}
?>
