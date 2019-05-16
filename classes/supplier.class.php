<?
class supplier extends dbClass
{
		//constructor
		function supplier()
		{
			$this->dbClass();
		} 
		
		function  ListSupplier($arryDetails,$DB='')
		{
			extract($arryDetails);
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			#$strAddQuery .= (!empty($id))?(" where s.SuppID='".$id."'"):(" where s.locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= (!empty($id))?(" where s.SuppID='".$id."'"):(" where 1");
                         $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev

			if($SearchKey=='active' && ($sortby=='s.Status' || $sortby=='') ){
				$strAddQuery .= " and s.Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='s.Status' || $sortby=='') ){
				$strAddQuery .= " and s.Status='0'";
			}else if($sortby != '' && $sortby=='VendorName'){
				$strAddQuery .= (!empty($SearchKey))?(" and (s.UserName like '".$SearchKey."%' or s.CompanyName like '".$SearchKey."%')"):("");
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (s.SuppCode like '%".$SearchKey."%' or s.SuppType like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' or s.UserName like '%".$SearchKey."%'  or s.FirstName like '%".$SearchKey."%'  or s.LastName like '%".$SearchKey."%'   or ab.Country like '%".$SearchKey."%' or ab.State like '%".$SearchKey."%' or ab.City like '%".$SearchKey."%' or s.Currency like '%".$SearchKey."%'   ) " ):("");		
			}

			
			$strAddQuery .= (!empty($Status))?(" and s.Status='".$Status."'"):("");
				$strAddQuery .= (" and s.PID='0' " );

			$userSql='';
			if($_SESSION['AdminType']=="employee"){
				$userSql =  " left outer join ".$DB."permission_vendor p on (s.SuppCode =  p.SuppCode and p.EmpID='".$_SESSION['AdminID']."') ";	
				$strAddQuery .= " and p.SuppCode IS NULL";
			}
			
			
			if($Config['GetNumRecords']==1){
				$Columns = " count(s.SuppID) as NumCount ";				
			}else{	
$strAddQuery .= " group by s.SuppID ";

				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by VendorName ");
				$strAddQuery .= (!empty($asc))?($asc):(" Asc");
			
				$Columns = "  s.*, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, CompanyName) as VendorName, ab.Country, IF(ab.State!='', ab.State, ab.OtherState) as State, IF(ab.City!='', ab.City, ab.OtherCity) as City  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			#$strSQLQuery = "select s.SuppID,s.SuppCode,s.UserName,ab.Country,ab.State, ab.City,s.Email,s.CompanyName,s.Mobile,s.Status,s.Currency from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery;

			if(!empty($Config['addTp'])){
			   	$addTp = $Config['addTp'];
				$PrimaryContactSql ='';
			}else{
				$addTp = 'contact';
				$PrimaryContactSql = " and ab.PrimaryContact='1' ";
			}


		    $strSQLQuery = "select ".$Columns." from ".$DB."p_supplier s left outer join ".$DB."p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = '".$addTp."' ".$PrimaryContactSql.") ".$userSql.$strAddQuery;

			
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function GetSupplierUser($UserID,$Status){
			if(!empty($UserID)){
				$strSQLQuery = "select * from p_supplier where UserID='".mysql_real_escape_string($UserID)."' ";
				$strSQLQuery .= ($Status>0)?(" and Status='".$Status."' "):("");			
				return $this->query($strSQLQuery, 1);
			}
		}
//Updated by chetan 16Mar(added primary field and Address to State )
		function GetSupplierList($arryDetails)
		{
			extract($arryDetails);			
			$strAddQuery ='';
			#$strAddQuery .= (!empty($SuppID))?(" and s.SuppID='".$SuppID."'"):(" and s.locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= (!empty($SuppID))?(" and s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" ");
			$strAddQuery .= (!empty($Status))?(" and s.Status='".$Status."'"):("");
			$strAddQuery .= (!empty($primaryVendor))?(" and s.primaryVendor='1'"):("");
			$strAddQuery .= (!empty($CreditCard))?(" and s.CreditCard='1'"):("");
			$strSQLQuery = "select s.SuppID,s.SuppCode,s.UserName,s.Email,s.CompanyName,s.Address,s.Landline,s.Mobile,s.UserName as SuppContact,s.ZipCode,s.Country,s.City,s.State, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, CompanyName) as VendorName from p_supplier s where 1 ".$strAddQuery." having VendorName!='' order by CompanyName asc";
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
			//$strSQLQuery = "select s.*,ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ";
//$strSQLQuery = "select s.*,ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'shipping' and ab.PrimaryContact='1') ";
$strSQLQuery = "select s.* , IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, CompanyName) as VendorName,  ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'billing' ) ";

			#$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".$SuppID."'"):(" and s.locationID='".$_SESSION['locationID']."'");
			$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
			$strSQLQuery .= (!empty($SuppCode))?(" and s.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
			$strSQLQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}		
		
		function GetSupplierBrief($SuppID)
		{
			$strAddQuery ='';
			#$strAddQuery .= (!empty($SuppID))?(" and s.SuppID='".$SuppID."'"):(" and locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= (!empty($SuppID))?(" and s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" ");
			$strSQLQuery = "select s.SuppID,s.SuppCode,s.UserName,s.Email,s.CompanyName, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName from p_supplier s where s.Status='1' ".$strAddQuery." having VendorName!='' order by VendorName asc";
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllSuppliers($Status)
		{
			$strSQLQuery = "select SuppID,UserName,CompanyName,Email from p_supplier where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

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

		
		function  GetShippingBilling($SuppID,$AddType,$status=null,$order='')
		{
			global $Config;
			$strSQLQuery = "select p.*,s.SuppCode,s.CompanyName as SuppCompany,s.UserName as SuppContact,s.Taxable,s.TaxRate from  p_address_book p inner join p_supplier s on p.SuppID=s.SuppID ";

			$strSQLQuery .= (!empty($SuppID))?(" where p.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
			$strSQLQuery .= (!empty($AddType))?(" and p.AddType='".$AddType."'"):("");
			$strSQLQuery .= (!empty($Config['primaryVendor']))?(" and s.primaryVendor='1'"):("");
			$strSQLQuery .= ($status!==null)?(" and p.Status='".$status."'"):("");
			$strSQLQuery .= !empty($order)?' order by '.$order:'';
			return $this->query($strSQLQuery, 1);
		}

		function  GetVendorZipCode($SuppID,$SuppCode,$AddType)
		{
			$strSQLQuery = "select p.ZipCode from  p_address_book p inner join p_supplier s on p.SuppID=s.SuppID ";

			$strSQLQuery .= (!empty($SuppID))?(" where p.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
			$strSQLQuery .= (!empty($SuppCode))?(" and s.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
			$strSQLQuery .= (!empty($AddType))?(" and p.AddType='".$AddType."'"):("");
			$arrayRow = $this->query($strSQLQuery, 1);

			return $arrayRow[0]['ZipCode'];
		}


		//update by chetan 16Mar(added Primary field)//
		function AddSupplier($arryDetails,$DBName='')
		{  
			
			global $Config;
			extract($arryDetails);

$DB='';	
if($DBName!='') { $DB=$DBName.'.'; } if($EDICompId==''){ $EDICompId=0; }

			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$SuppCode =   trim($SuppCode);

			$ipaddress = GetIPAddress();
			if($primaryVendor == 1)
			{
				$strSQLQuery2 = "update p_supplier set primaryVendor = '0'";
				$this->query($strSQLQuery2, 0);
			}


	if($defaultVendor == 1)
				{
					$strSQLQuery3 = "update p_supplier set defaultVendor = '0'";
					$this->query($strSQLQuery3, 0);
				}	
	if($Taxable == 'No')
			{
				$TaxRate = '';
			}

			$strSQLQuery = "insert into ".$DB."p_supplier (primaryVendor,SuppCode,SuppType,UserName,Email,Password,FirstName,LastName, CompanyName, Address, city_id, state_id, ZipCode, country_id,Mobile, Landline, Fax, Website, Status, OtherState, OtherCity, TempPass,ipaddress, UpdatedDate, Currency , SupplierSince, TaxNumber, PaymentMethod, ShippingMethod, PaymentTerm, CustomerVendor, SSN, TenNine, EIN,Taxable, TaxRate,CreditLimit, AdminID, AdminType, CreatedDate, PID, VAT, CST, TRN, AccountID, EDICompId, EDICompName, defaultVendor, CreditCard) values('".addslashes($primaryVendor)."','".addslashes($SuppCode)."','".addslashes($SuppType)."', '".addslashes($UserName)."', '".addslashes($Email)."', '".md5($Password)."','".addslashes($FirstName)."', '".addslashes($LastName)."','".addslashes($CompanyName)."', '".addslashes(strip_tags($Address))."' ,  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($Landline)."', '".addslashes($Fax)."',  '".addslashes($Website)."', '".$Status."',    '".addslashes($OtherState)."', '".addslashes($OtherCity)."', '".$Password."', '".$ipaddress."', '".$Config['TodayDate']."','".$Currency."' ,'".$SupplierSince."', '".addslashes($TaxNumber)."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".$CustomerVendor."', '".addslashes($SSN)."', '".addslashes($TenNine)."', '".addslashes($EIN)."','".$Taxable."', '".$TaxRate."', '".addslashes($CreditLimit)."', '". $_SESSION['AdminID']."', '". $_SESSION['AdminType']."', '". $Config['TodayDate']."','".$PID."','".$VAT."'
, '".$CST."', '".$TRN."', '".$AccountID."','".addslashes($EDICompId)."','".addslashes($EDICompName)."', '".addslashes($defaultVendor)."' , '".addslashes($CreditCard)."')";

			//echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$SuppID = $this->lastInsertId();

			if(empty($SuppCode)){
				$SuppCode = 'VEN000'.$SuppID;
				$strSQL = "update ".$DB."p_supplier set SuppCode='".$SuppCode."' where SuppID='".$SuppID."'"; 
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
				,UpdatedDate = '".$Config['TodayDate']."',Currency='".$Currency."' ,SupplierSince='".$SupplierSince."', TaxNumber='".addslashes($TaxNumber)."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', CreditLimit='".addslashes($CreditLimit)."',VAT='".$VAT."',CST ='".$CST."',TRN ='".$TRN."',defaultVendor ='".$defaultVendor."'
				where SuppID='".mysql_real_escape_string($SuppID)."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

	
		//update by chetan 16Mar(added Primary field)//
		function UpdateGeneral($arryDetails){   
			global $Config;
			extract($arryDetails);

			if(!empty($SuppID)){
				if($Status=='') $Status=1;
				$UserName = trim($FirstName.' '.$LastName);
				if($primaryVendor == 1){
					$strSQLQuery2 = "update p_supplier set primaryVendor = '0'";
					$this->query($strSQLQuery2, 0);
				}	
					if($defaultVendor == 1){
					$strSQLQuery3 = "update p_supplier set defaultVendor = '0'";
					$this->query($strSQLQuery3, 0);
				}	
				
	if($Taxable == 'No')
			{
				$TaxRate = '';
			}


				$strSQLQuery = "update p_supplier set primaryVendor = '".addslashes($primaryVendor)."', SuppType='".addslashes($SuppType)."', CompanyName='".addslashes($CompanyName)."',  UserName='".addslashes($UserName)."', FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."' , Email='".addslashes($Email)."', Mobile='".addslashes($Mobile)."', Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' , Website='".addslashes($Website)."', UpdatedDate = '".$Config['TodayDate']."', Status='".$Status."',Currency='".$Currency."',SupplierSince='".$SupplierSince."', TaxNumber='".addslashes($TaxNumber)."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', SSN='".addslashes($SSN)."', TenNine='".addslashes($TenNine)."' , AccountID='".addslashes($AccountID)."', CreditCard='".addslashes($CreditCard)."', HoldPayment='".addslashes($HoldPayment)."', EIN='".addslashes($EIN)."',Taxable='".addslashes($Taxable)."',TaxRate='".addslashes($TaxRate)."', CreditLimit='".addslashes($CreditLimit)."',VAT='".mysql_real_escape_string($VAT)."',CST='".mysql_real_escape_string($CST)."',TRN='".mysql_real_escape_string($TRN)."',defaultVendor ='".mysql_real_escape_string($defaultVendor)."' where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$this->query($strSQLQuery, 0);



				
				/***********************/
				$objConfig=new admin();
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
		
				$strSQLQuery = "update company_user set  user_name='".addslashes($Email)."' where ref_id='".mysql_real_escape_string($SuppID)."' and user_type='vendor' and comId='".$_SESSION['CmpID']."' "; 
				$this->query($strSQLQuery, 0);		


				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/***********************/


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


		function UpdateAddCountryStateCity($arryDetails,$AddID,$DBName=''){   
			extract($arryDetails);	
$DB='';	if($DBName!='') { $DB=$DBName.'.';}		
			if(!empty($AddID)){
				$strSQLQuery = "update ".$DB."p_address_book set Country='".addslashes($Country)."',  State='".addslashes($State)."',  City='".addslashes($City)."' where AddID='".mysql_real_escape_string($AddID)."'";
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
				$sql = "select * from p_supplier where Email='".$Email."' and Status='1'"; 
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
			$objFunction=new functions();
			if(!empty($SuppID)){
				$strSQLQuery = "select UserID,Image from p_supplier where SuppID='".mysql_real_escape_string($SuppID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				$ImgDir = $Config['FileUploadDir'].$Config['VendorDir'];
				 
				if($arryRow[0]['Image'] !=''){				
					$objFunction->DeleteFileStorage($Config['VendorDir'],$arryRow[0]['Image']);
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


				/***********************/
				$objConfig=new admin();
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
		
				$strSQLQuery = "delete from company_user where ref_id='".mysql_real_escape_string($SuppID)."' and user_type='vendor' and comId='".$_SESSION['CmpID']."' "; 
				$this->query($strSQLQuery, 0);


				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/***********************/







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
			$sql="select SuppID from p_supplier where SuppID in (".$SuppIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update p_supplier set Status='".$Status."' where SuppID in (".$SuppIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		
		function ValidateSupplier($Email,$Password){
			if(!empty($Email) && !empty($Password)){
				$strSQLQuery = "select * from p_supplier where Email='".$Email."' and Password='".md5($Password)."' and Status='1'";
				return $this->query($strSQLQuery, 1);
			}
		}

		function isEmailExists($Email,$SuppID=0)
		{
			if(!empty($Email)){
				$strSQLQuery = (!empty($SuppID))?(" and SuppID != '".$SuppID."'"):("");
				$strSQLQuery = "select SuppID from p_supplier where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;

				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['SuppID'])) {
					return true;
				} else {
					return false;
				}
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
                                
                                $strSQLQueryAdd = "update p_address_book set Name='".addslashes($UserName)."', Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Country ='".addslashes($Country)."', State ='".addslashes($State)."', City ='".addslashes($City)."', Mobile='".addslashes($Mobile)."', Email='".addslashes($Email)."',  Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',UpdatedDate = '".$Config['TodayDate']."' where SuppID='".$SuppID."' and PrimaryContact='1'";
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
			$strSQLQuery = "select count(SuppID) as TotalSupplier from p_supplier"; //where locationID='".$_SESSION['locationID']."'";
			return $this->query($strSQLQuery, 1);		
		}	

		function  GetNumSupplier($depID)
		{
			$strSQLQuery = "select count(SuppID) as TotalSupplier from p_supplier"; //where locationID='".$_SESSION['locationID']."'";
			return $this->query($strSQLQuery, 1);		
		}


	*****************************/

	function addSupplierAddress($arryDetails,$SupplierID,$AddType,$DBName='')
	{
		global $Config;
		extract($arryDetails);		
$DB='';	if($DBName!='') { $DB=$DBName.'.';}
		if($main_city_id>0) $OtherCity = '';
		if($main_state_id>0) $OtherState = '';
		$FullName = $FirstName." ".$LastName;
			
		if(!empty($Name)) $FullName = $Name;
if($CompanyName!='') { $FullName = $CompanyName;} else{ $FullName = $FullName; }
		$strSQLQuery = "INSERT INTO ".$DB."p_address_book set SuppID = '".$SupplierID."', AddType='".$AddType."', PrimaryContact = '".$PrimaryContact."', Name = '".mysql_real_escape_string(strip_tags($FullName))."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$country_id."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', UpdatedDate = '".$Config['TodayDate']."' ,PaymentInfo='".$PaymentInfo."' ,PoDelivery='".$PoDelivery."' ,CreditDelivery='".$CreditDelivery."' ,ReturnDelivery='".$ReturnDelivery."',InvoiceDelivery='".$InvoiceDelivery."' ";

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
		$strSQLQuery = "update p_address_book set Name = '".mysql_real_escape_string(strip_tags($FullName))."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$country_id."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', UpdatedDate = '".$Config['TodayDate']."' ,PaymentInfo='".$PaymentInfo."' ,PoDelivery='".$PoDelivery."' ,CreditDelivery='".$CreditDelivery."' ,ReturnDelivery='".$ReturnDelivery."',InvoiceDelivery='".$InvoiceDelivery."' where AddID='".$AddID."' ";
		$this->query($strSQLQuery, 0);		

		return true;
	   
	} 
  
	function updateAssignRole($arryDetails,$AddID)
	{
			           
	     	global $Config;
		extract($arryDetails);
		$SuppID = $SupplierID;
	
		if($PaymentInfo==1){
			$strSQLQuery = "update p_address_book set PaymentInfo = '0' where AddID!='".$AddID."' and SuppID='".$SuppID."' ";
			$this->query($strSQLQuery, 0);	
		}
		if($PoDelivery==1){
			$strSQLQuery = "update p_address_book set PoDelivery = '0' where AddID!='".$AddID."' and SuppID='".$SuppID."'  ";
			$this->query($strSQLQuery, 0);	
		}
		if($CreditDelivery==1){
			$strSQLQuery = "update p_address_book set CreditDelivery = '0' where AddID!='".$AddID."' and SuppID='".$SuppID."' ";
			$this->query($strSQLQuery, 0);	
		}
		if($ReturnDelivery==1){
			$strSQLQuery = "update p_address_book set ReturnDelivery = '0' where AddID!='".$AddID."' and SuppID='".$SuppID."' ";
			$this->query($strSQLQuery, 0);	
		}	
		if($InvoiceDelivery==1){
			$strSQLQuery = "update p_address_book set InvoiceDelivery = '0' where AddID!='".$AddID."' and SuppID='".$SuppID."' ";
			$this->query($strSQLQuery, 0);	
		}
		return true;
	   
	}   


	function  GetSupplierContact($SuppID,$PrimaryContact)
	{
		
		$strAddQuery = (!empty($PrimaryContact))?(" and ab.PrimaryContact='".$PrimaryContact."'"):("");
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


	/********** Supplier Bank *********/
	function addBank($arryDetails){
		global $Config;
		@extract($arryDetails);	
		if(!empty($SuppID)){
			$sql = "insert into p_supplier_bank (SuppID, BankName, AccountName, AccountNumber, RoutingNumber, DefaultAccount, SwiftCode, UpdatedDate) values('".addslashes($SuppID)."', '".addslashes($BankName)."', '".addslashes($AccountName)."', '".addslashes($AccountNumber)."', '".addslashes($RoutingNumber)."', '".addslashes($DefaultAccount)."', '".addslashes($SwiftCode)."', '".$Config['TodayDate']."' )";

			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
		}
		return $lastInsertId;

	}

	function UpdateBank($arryDetails){   
		global $Config;
		extract($arryDetails);
		if(!empty($SuppID) && !empty($BankID)){
			$strSQLQuery = "update p_supplier_bank set BankName='".addslashes($BankName)."',AccountName='".addslashes($AccountName)."', AccountNumber='".addslashes($AccountNumber)."', RoutingNumber='".addslashes($RoutingNumber)."', DefaultAccount='".addslashes($DefaultAccount)."', SwiftCode='".addslashes($SwiftCode)."', UpdatedDate = '".$Config['TodayDate']."'  where SuppID='".$SuppID."' and BankID='".$BankID."'  "; 
			$this->query($strSQLQuery, 0);
		}

		return 1;
	}
	function UnDefaultBank($BankID, $SuppID){   
		global $Config;
		extract($arryDetails);
		if(!empty($SuppID) && !empty($BankID)){
			$strSQLQuery = "update p_supplier_bank set DefaultAccount='0' where BankID!='".$BankID."'  "; 
			$this->query($strSQLQuery, 0);
		}

		return 1;
	}
	function RemoveBank($BankID,$SuppID){
		if(!empty($SuppID) && !empty($BankID)){
			$strSQLQuery = "Delete FROM p_supplier_bank WHERE BankID = '".$BankID."' and SuppID = '".$SuppID."'"; 
			$this->query($strSQLQuery, 0);
			return 1;
		}

	}
	function GetBank($BankID,$SuppID,$DefaultAccount){
		$strSQLQuery = "select b.* from p_supplier_bank b where SuppID= '".$SuppID."' ";
		$strSQLQuery .= (!empty($BankID))?(" and b.BankID='".$BankID."'"):("");
		$strSQLQuery .= (!empty($DefaultAccount))?(" and b.DefaultAccount='".$DefaultAccount."'"):("");
		$strSQLQuery .= ' order by BankName asc';
		return $this->query($strSQLQuery, 1);
	}

	/**********************************/
	function MergeVendor($OldSuppID, $NewSuppID){  

		if(!empty($OldSuppID) && !empty($NewSuppID)){
			$arryOld = $this->GetSupplier($OldSuppID,'','');
			$arryNew = $this->GetSupplier($NewSuppID,'','');
			$OldSuppCode = $arryOld[0]['SuppCode'];
			$NewSuppCode = $arryNew[0]['SuppCode'];

			$sqlAdd = "update p_address_book set SuppID='".$NewSuppID."' where SuppID='".$OldSuppID."' and PrimaryContact='0'"; 
			$this->query($sqlAdd, 0);

			$sqlBank = "update p_supplier_bank set SuppID='".$NewSuppID."' where SuppID='".$OldSuppID."'"; 
			$this->query($sqlBank, 0);

			$sqlOrd = "update p_order set SuppCode='".$NewSuppCode."', SuppCompany='".$arryNew[0]['CompanyName']."',SuppContact='".$arryNew[0]['UserName']."',SuppCurrency='".$arryNew[0]['Currency']."' where SuppCode='".$OldSuppCode."'";
			$this->query($sqlOrd, 0);

			$sqlPay = "update f_payments set SuppCode='".$NewSuppCode."' where SuppCode='".$OldSuppCode."'"; 
			$this->query($sqlPay, 0);

			$sqlExp = "update f_expense set PaidTo='".$NewSuppCode."' where PaidTo='".$OldSuppCode."'"; 
			$this->query($sqlExp, 0);


			$sqlGen = "update f_gerenal_journal_entry set EntityName='".$arryNew[0]['CompanyName']."', EntityID='".$NewSuppID."' where EntityID='".$OldSuppID."' and EntityType='supplier'";
			$this->query($sqlGen, 0);

			$sqlInv = "update inv_items set SuppCode='".$NewSuppCode."' where SuppCode='".$OldSuppCode."'";
			$this->query($sqlInv, 0);

			$sqlInv2 = "update inv_items set supplier_code='".$NewSuppCode."' where supplier_code='".$OldSuppCode."'";
			$this->query($sqlInv2, 0);

			

			$sqlW = "update w_order set SuppCode='".$NewSuppCode."', SuppCompany='".$arryNew[0]['CompanyName']."',SuppContact='".$arryNew[0]['UserName']."',SuppCurrency='".$arryNew[0]['Currency']."' where SuppCode='".$OldSuppCode."'";
			$this->query($sqlW, 0);
		
			/***************************/
			/***************************/
			$sqlD ="DELETE FROM `p_supplier` where SuppID='".$OldSuppID."'";
			$this->query($sqlD, 0);

			$sqlDA ="DELETE FROM `p_address_book` where SuppID='".$OldSuppID."' and PrimaryContact='1'";
			$this->query($sqlDA, 0);

			$sqlDP ="DELETE FROM `permission_vendor` where SuppCode='".$OldSuppCode."'";
			$this->query($sqlDP, 0);

		}
		
		return 1;
	}

// By Rajan 09 Dec //
	function  GetVendorShippingContact($SuppID,$ShipId='')
	{
		$AddType='shipping';		
		 
		$strAddQuery .= " and ( ab.Status='1' or ab.Status='0')";
		$strAddQuery .= (!empty($ShipId))?(" and ab.AddID='".$ShipId."'"):("");	 

		$strSQLQuery = "SELECT s.CompanyName, ab.* FROM p_address_book ab inner join p_supplier s on ab.SuppID=s.SuppID  WHERE ab.SuppID='".$SuppID."' AND ab.AddType = '".$AddType."' ".$strAddQuery." order by Status Desc";
		return $this->query($strSQLQuery, 1);
	}
	// End   ///

/***************************By Niraj For import****************************************/



      function AddVendor($arryDetails) { 
        extract($arryDetails);
$UserName = trim($FirstName.' '.$LastName);
	
$sql = "insert into p_supplier (SuppCode, SuppType, FirstName, LastName, UserName, Email, Mobile, Landline,CompanyName, country_id, state_id,city_id,ZipCode,Currency,UpdatedDate,OtherState,OtherCity) values('".addslashes($SuppCode)."', '".addslashes($SuppType)."', '".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($UserName)."', '".addslashes($Email)."', '".addslashes($Mobile)."','".addslashes($Landline)."', '".addslashes($CompanyName)."','".addslashes($country_id)."','".addslashes($main_state_id)."','".addslashes($main_city_id)."','".mysql_real_escape_string($ZipCode)."','".addslashes($Currency)."', '".$Config['TodayDate']."','".addslashes($State)."', '".addslashes($City)."' )";


        $this->query($sql, 0);
        $lastInsertId = $this->lastInsertId();
      if(empty($SuppCode)){

				$SuppCode = 'VEN000'.$lastInsertId;
				$strSQL = "update p_supplier set SuppCode='".$SuppCode."' where SuppID='".$lastInsertId."'"; 
				$this->query($strSQL, 0);
			}

        return $lastInsertId;
    }
function isVendorNameExist($FirstName, $LastName, $VendorID = 0) {
        $strAddQuery .= (!empty($VendorID)) ? (" and SuppID != '" . $VendorID. "'") : ("");
        $strSQLQuery = "select SuppID from p_supplier where LCASE(FirstName)='" . addslashes(strtolower(trim($FirstName))) . "' and LCASE(LastName)='" . addslashes(strtolower(trim($LastName))) . "' " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['SuppID'])) {
            return true;
        } else {
            return false;
        }
    }
 

   function isVendorCompanyExist($company, $VendorID = 0) {
        $strAddQuery .= (!empty($VendorID)) ? (" and SuppID != '" . $VendorID. "'") : ("");
        $strSQLQuery = "select SuppID from p_supplier where LCASE(CompanyName)='" . addslashes(strtolower(trim($CompanyName))) . "'  " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['SuppID'])) {
            return true;
        } else {
            return false;
        }
    }
    function isVendorCodeExists($SuppCode)
				{
					$strSQLQuery = "SELECT SuppID FROM p_supplier WHERE LCASE(SuppCode)='".strtolower(trim($SuppCode))."'";
					$arryRow = $this->query($strSQLQuery, 1);

					if (!empty($arryRow[0]['SuppID'])) {
						return true;
					} else {
						return false;
					}
				}

/**************************end by niraj Dec22 2015**************/

	function isVendorTransactionExist($SuppCode){		
		$OrdSql = "select SuppCode from p_order where SuppCode = '".$SuppCode."' limit 0,1";
		$PaySql = "select SuppCode from f_payments where SuppCode = '".$SuppCode."' limit 0,1";
				
	 	$strSQLQuery = "(".$OrdSql.") UNION (".$PaySql.") ";
		 $arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['SuppCode'])) {
			return true;
		}else{
			return false;
		}
	}
//Import Excel functions by chetan 21 sep 2016//

	function MoveRecordToMasterTable(){
		$sql = "update p_supplier set PID = '0', Status = '1' where AdminID = '".$_SESSION['AdminID']."'  and AdminType = '".$_SESSION['AdminType']."'  and PID = '1'";
		$this->query($sql);
    	}  
    
	function DropDataOFImport(){
		$sql = "DELETE FROM p_supplier, p_address_book USING p_supplier INNER JOIN p_address_book ON p_supplier.SuppID = p_address_book.SuppID WHERE p_supplier.AdminID = '".$_SESSION['AdminID']."' and p_supplier.AdminType = '".$_SESSION['AdminType']."' and p_supplier.PID = '1'  ";
		$this->query($sql);
  	}
	
	function CountForImport(){
	    	$sql = "SELECT COUNT(*) `count` from p_supplier where AdminID = '".$_SESSION['AdminID']."' and AdminType = '".$_SESSION['AdminType']."' and PID = '1' ";
	    	$count = $this->query($sql,1);
	    	return $c = ($count[0]['count']>0)?$count[0]['count']:0; 
   	}	
	//End//

	//added by chetan for customer to add from vender on 1Mar2017//
	function GetSupplierforCustomer($SuppID)
	{
		$strSQLQuery = "select s.SuppType, s.SuppCode, s.FirstName, s.LastName, s.UserName, s.CompanyName, s.SupplierSince, s.PaymentTerm, s.ShippingMethod,s.TaxNumber, s.PaymentMethod, s.Email, s.AccountID, s.CreditLimit, s.Status, s.Website, s.Currency, ab.city_id, ab.state_id, ab.country_id, ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode, ab.Mobile, ab.Landline,ab.OtherState,ab.OtherCity from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'billing' ) ";
		$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
		return $this->query($strSQLQuery, 1);
	}
	//End//

	 
	
function ListSupplierPurchase($arryDetails) {
	global $Config;
	extract($arryDetails);	
	 	 
	$strAddQuery = ""; 
	if($fby=='Year'){ 
		$strAddQuery .= " and YEAR(o.PostedDate) ='".$y."' ";
	}else if($fby=='Month'){
		$strAddQuery .= " and  MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."' ";
	}else{ 
		$strAddQuery .= " and o.PostedDate>='".$f."' and o.PostedDate<='".$t."'  ";
	}	
	   
 	$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
 
 	
	if($Config['ConversionType']==1){
		$TotalAmount =  "if(o.ConversionRate>0, s.TotalAmount/o.ConversionRate,s.TotalAmount)" ;
		$line_amount = "if(s.ConversionRate>0, t.amount/s.ConversionRate, t.amount)";		
	}else{
		$TotalAmount =  "if(o.ConversionRate>0, s.TotalAmount*o.ConversionRate,s.TotalAmount)" ;
		$line_amount = "if(s.ConversionRate>0, t.amount*s.ConversionRate, t.amount)";	
	}
        
	$strAddQuery .= " GROUP BY MONTH(o.PostedDate),YEAR(o.PostedDate) ";

	$strAddQuery .= " Order By  o.PostedDate ASC ,o.OrderID ASC ";
	
	/*********Invoice Nested Queries*************/	 
	$InnerWhereGroup = " and s.SuppCode='".$SuppCode."' and s.PostToGL='1' and (MONTH(s.PostedDate)=MONTH(o.PostedDate) and YEAR(s.PostedDate)=YEAR(o.PostedDate)) GROUP BY MONTH(s.PostedDate),YEAR(s.PostedDate) ";

	$PurchaseAmountGL = "(select sum(".$TotalAmount.") from p_order s  where s.Module='Invoice' and s.InvoiceEntry in(2,3) ".$InnerWhereGroup.") as PurchaseAmountGL, ";

	$PurchaseLineAmount = " (select sum(".$line_amount.") from p_order_item t inner join p_order s on s.OrderID=t.OrderID    where s.Module='Invoice' and s.InvoiceEntry in(0,1) ".$InnerWhereGroup." ) as PurchaseLineAmount, ";

	/*********Credit Nested Queries*************/
 	$InnerWhereGroupCr = " and s.Module='Credit' and s.OverPaid='0' and s.SuppCode='".$SuppCode."' and s.PostToGL='1' 
and ( MONTH(s.PostedDate)=MONTH(o.PostedDate) and YEAR(s.PostedDate)=YEAR(o.PostedDate)) 
  GROUP BY MONTH(s.PostedDate),YEAR(s.PostedDate) ";	

	$CreditAmountGL = " (select sum(".$TotalAmount.") from p_order s  where  s.AccountID>0 ".$InnerWhereGroupCr.")
  as CreditAmountGL, ";	

	$CreditLineAmount = " (select sum(".$line_amount.") from p_order_item t inner join p_order s on s.OrderID=t.OrderID  where  s.AccountID<=0 ".$InnerWhereGroupCr." ) as CreditLineAmount, ";
	/*****************************/

       	$Columns = "  COUNT(DISTINCT(o.OrderID)) as TotalInvoiceNo  , MONTH(o.PostedDate) as MonthDate, 
".$PurchaseAmountGL. $PurchaseLineAmount. $CreditAmountGL. $CreditLineAmount." 
 o.PostedDate    ";
 	  		               		
         
	  $strSQLQuery = "select ".$Columns." from p_order o left outer join p_order_item i on o.OrderID=i.OrderID where o.Module in ('Invoice','Credit') and o.PostToGL='1'  and o.OverPaid='0'   ".$strAddQuery;
	//and CASE WHEN o.Module = 'Credit' THEN ( o.Status IN('Completed') ) ELSE ( o.InvoicePaid IN('1','2')) END

	return $this->query($strSQLQuery, 1);
	}

	
function getVendorPaymentByDate($arryDetails, $SuppCode,$year,$month) {
    	 global $Config;
	 extract($arryDetails);	
 
	 if(!empty($SuppCode) && !empty($year) && !empty($month)) {  
         	    $strSQLQuery = "select sum(d.Amount) as Amount from f_transaction_data d inner join f_transaction t on d.TransactionID=t.TransactionID where MONTH(t.PaymentDate)='".$month."' and YEAR(t.PaymentDate)='".$year."'  and d.Deleted='0' and d.SuppCode='".$SuppCode."' and t.Voided='0' ";   
		$rs = $this->query($strSQLQuery, 1);
		return $rs[0]["Amount"];
	}
}
//added by nisha for sales commision report
	
function GetsalesCommission($SuppID)
{
			$strSQLQuery = "select p.*,s.SuppCode from  h_commission p inner join p_supplier s on p.SuppID=s.SuppID ";

			$strSQLQuery .= (!empty($SuppID))?(" where p.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");

			return $this->query($strSQLQuery, 1);
}
//added by nisha for colour highlight functionality
function setRowColorSupplier($SuppID,$RowColor)
{
$sql = "update p_supplier set RowColor='".$RowColor."' where SuppID in ( $SuppID)"; 
         $this->query($sql, 0);
        return true;	
}
}
?>
