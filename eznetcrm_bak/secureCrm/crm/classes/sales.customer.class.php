<?php

class Customer extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function Customer(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

                function getCustomers($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
			global $Config;
                        $strAddQuery = 'where 1';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= ($Status>0)?(" and c1.Status=".$Status.""):("");

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (c1.AdminType='".$_SESSION['AdminType']."' and c1.AdminID='".$_SESSION['AdminID']."') "):(""); 

			if($SearchKey=='active' && ($SortBy=='c1.Status' || $SortBy=='') ){
				$strAddQuery .= " and c1.Status='Yes'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c1.Status' || $SortBy=='') ){
				$strAddQuery .= " and c1.Status='No'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}			 
			 else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c1.FirstName like '".$SearchKey."%' or c1.LastName like '%".$SearchKey."%' or c1.Email like '%".$SearchKey."%' or c1.Landline like '%".$SearchKey."%' or c1.CustCode like '%".$SearchKey."%' or ab.CountryName like '%".$SearchKey."%' or ab.StateName  like '%".$SearchKey."%') "):("");
			}
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.FullName ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

						   
		 $SqlCustomer = "select c1.*,ab.CountryName ,ab.StateName from s_customers c1 left outer join s_address_book ab ON (c1.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery;
			
                    return $this->query($SqlCustomer, 1);
                }
                

  
		function  ListCustomer($arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where c.Cid='".$id."'"):(" where 1");

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."' "):(""); 


			$strAddQuery .= (!empty($SearchKey))?(" and ( c.CustCode like '%".$SearchKey."%' or c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%' or c.FullName like '%".$SearchKey."%' or ab.CountryName like '%".$SearchKey."%' or ab.StateName like '%".$SearchKey."%' or ab.CityName like '%".$SearchKey."%') " ):("");
			$strAddQuery .= " and c.Status='Yes'"; 

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by c.FullName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");
			$strSQLQuery = "SELECT c.*,ab.CountryName ,ab.StateName,ab.CityName from s_customers c left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery."";

                        
                     
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		

		}	

		function  GetCustomer($CustID,$CustCode,$Status)
		{
			global $Config;
			$strSQLQuery = "SELECT c.*,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName FROM s_customers c left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') ";
			$strSQLQuery .= (!empty($CustID))?(" WHERE c.Cid='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($CustCode))?(" and c.CustCode='".$CustCode."'"):("");
			$strSQLQuery .= ($Status!='')?(" AND c.Status='".$Status."'"):("");

			
			$strSQLQuery .= ' order by c.FullName';
			return $this->query($strSQLQuery, 1);

		}
		
		function  GetCustomerContact($CustID,$PrimaryContact)
		{
			
			$strAddQuery .= (!empty($PrimaryContact))?(" and ab.PrimaryContact='".$PrimaryContact."'"):("");
			$strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.AddType = 'contact' ".$strAddQuery." order by PrimaryContact Desc, AddID asc";
			return $this->query($strSQLQuery, 1);
		}

		function CountCustomerOrder($CustCode,$Module)
		{			
			$strSQLQuery = "select Count(OrderID) as TotalOrder from s_order as o WHERE o.Module='".$Module."' and o.CustCode='".$CustCode."' ";
			$rs = $this->query($strSQLQuery, 1);
			return $rs[0]['TotalOrder'];			
		}

		function  GetAddressBook($AddID)
		{
			if($AddID>0){
			$strSQLQuery = "SELECT * FROM s_address_book WHERE AddID='".$AddID."' ";			
			return $this->query($strSQLQuery, 1);
			}
		}
		


		function  GetContactAddress($AddID,$Status)
		{
			$strSQLQuery = "select * from s_address_book ";

			$strSQLQuery .= ($AddID>0)?(" where AddID='".$AddID."'"):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}


		function changeAddressBookStatus($AddID)
		{
			$sql="select * from s_address_book where AddID='".$AddID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update s_address_book set Status='$Status' where AddID='".$AddID."'";
				$this->query($sql,0);				

				return true;
			}			
		}


		function  ListCrmContact($arryDetails)
		{
			global $Config;
                        extract($arryDetails);
			$strAddQuery = '';
                        $SearchKey   = strtolower(trim($key));
			
                        $SortBy = $sortby;
			$strAddQuery .= (!empty($id))?(" where c.AddID=".$id):(" where c.CrmContact=1 and c.AddType='contact' ");

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (c.AssignTo='".$_SESSION['AdminID']."' OR c.AdminID='".$_SESSION['AdminID']."')  "):("");
                         $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			if($SearchKey=='active' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%'  or c.Email like '%".$SearchKey."%' or c.Title like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%'   ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.FirstName ");
			$strAddQuery .= (!empty($AscDesc))?($asc):(" Asc");

			$strSQLQuery = "select c.*,e.EmpID,e.UserName as AssignTo,cus.FullName as CustomerName, cus.CustCode   from s_address_book c left outer join  h_employee e on e.EmpID=c.AssignTo left outer join s_customers cus ON cus.Cid = c.CustID  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}
                
                
                function  ListContact($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
                       $SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where c.AddID=".$id):(" where c.CrmContact=1 and c.AddType='contact' ");

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (c.AssignTo='".$_SESSION['AdminID']."' OR c.AdminID='".$_SESSION['AdminID']."')  "):("");

			if($SearchKey=='active' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%'  or c.Email like '%".$SearchKey."%' or c.Title like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%'   ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.FirstName ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select c.AddID,c.Status,c.LastName,c.Title,c.Email,c.FirstName,e.EmpID,e.UserName as AssignTo from s_address_book c left outer join  h_employee e on e.EmpID=c.AssignTo ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}


		function  GetCustomerBilling($CustID)
		{
			$strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.AddType = 'billing'";
			
			return $this->query($strSQLQuery, 1);
		}

		function  GetCustomerShipping($CustID)
		{
			$strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.AddType = 'shipping'";
			return $this->query($strSQLQuery, 1);
		}
                
		function  GetAllAddress($CustID)
		{
			$strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.Status = '1' order by PrimaryContact desc";
			return $this->query($strSQLQuery, 1);
		}	
			
                function isCustCodeExists($CustCode)
				{
					$strSQLQuery = "SELECT Cid FROM s_customers WHERE LCASE(CustCode)='".strtolower(trim($CustCode))."'";
					$arryRow = $this->query($strSQLQuery, 1);

					if (!empty($arryRow[0]['Cid'])) {
						return true;
					} else {
						return false;
					}
				}
		
               function isEmailExists($Email,$CustId=0)
				{
					$strSQLQuery = (!empty($CustId))?(" and Cid != '".$CustId."'"):("");
					$strSQLQuery = "SELECT Cid FROM s_customers WHERE LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
					$arryRow = $this->query($strSQLQuery, 1);

					if (!empty($arryRow[0]['Cid'])) {
						return true;
					} else {
						return false;
					}
				}
                
                function addCustomer($arryDetails)
                {
			@extract($arryDetails);
			global $Config;

			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status="Yes";
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 
			$FullName = $FirstName." ".$LastName; 

			$sql = "INSERT INTO s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."', CustomerType = '".mysql_real_escape_string($CustomerType)."', Company = '".mysql_real_escape_string(strip_tags($Company))."', Currency='".mysql_real_escape_string($Currency)."',CustomerSince='".mysql_real_escape_string($CustomerSince)."', PaymentMethod='".mysql_real_escape_string($PaymentMethod)."', ShippingMethod='".mysql_real_escape_string($ShippingMethod)."', PaymentTerm='".mysql_real_escape_string($PaymentTerm)."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Gender = '".mysql_real_escape_string($Gender)."', Landline = '".mysql_real_escape_string($Landline)."', Website = '".mysql_real_escape_string(strip_tags($Website))."', Mobile = '".mysql_real_escape_string($Mobile)."', Email = '".mysql_real_escape_string(strip_tags($Email))."', CreatedDate = '".mysql_real_escape_string($Config['TodayDate'])."', ipaddress = '".$ipaddress."', Status='".mysql_real_escape_string($Status)."' , Taxable='".mysql_real_escape_string($Taxable)."', AdminID='".$_SESSION['AdminID']."', AdminType='".$_SESSION['AdminType']."' ";
			$this->query($sql,0);

			$customerId = $this->lastInsertId();

			if(empty($CustCode)){
				$CustCode = 'CUST000'.$customerId;
				$strSQL = "UPDATE s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."' WHERE Cid = '".mysql_real_escape_string($customerId)."'"; 
				$this->query($strSQL, 0);
			}

                    	return $customerId;
                   
                }
				
			
		function addCustomerAddress($arryDetails,$CustID,$AddType)
		{
			global $Config;
			extract($arryDetails);		

			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			$FullName = $FirstName." ".$LastName;
			$IpAddress = $_SERVER["REMOTE_ADDR"]; 
			if($Status=='') $Status=1;
			$strSQLQuery = "INSERT INTO s_address_book set CustID = '".$CustID."', AddType='".$AddType."', PrimaryContact = '".$PrimaryContact."', CrmContact = '".$CrmContact."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$Country."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."', PersonalEmail='".mysql_real_escape_string($PersonalEmail)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', CreatedDate = '".$Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."', AdminID = '".$_SESSION['AdminID']."', AdminType = '".$_SESSION['AdminType']."', CreatedBy = '".addslashes($_SESSION['UserName'])."',Title='".mysql_real_escape_string($Title)."',Department='".mysql_real_escape_string($Department)."',LeadSource='".mysql_real_escape_string($LeadSource)."',AssignTo='".addslashes($AssignTo)."',Reference='".mysql_real_escape_string($Reference)."', DoNotCall='".mysql_real_escape_string($DoNotCall)."', NotifyOwner='".mysql_real_escape_string($NotifyOwner)."', EmailOptOut='".mysql_real_escape_string($EmailOptOut)."', Description='".mysql_real_escape_string($Description)."' , Status='".mysql_real_escape_string($Status)."',CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' ";
			//echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);

			$AddID = $this->lastInsertId();

			return $AddID;

		}

		
  		function updateCustomerAddress($arryDetails,$AddID)
                {
			                   
                     	global $Config;
			extract($arryDetails);		

			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			$FullName = $FirstName." ".$LastName;
			$IpAddress = $_SERVER["REMOTE_ADDR"]; 

			$strSQLQuery = "update s_address_book set FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$Country."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."', PersonalEmail='".mysql_real_escape_string($PersonalEmail)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."' ";
			
			if($CrmContact==1){
				$strSQLQuery .= " ,CustID = '".$CustID."', Title='".mysql_real_escape_string($Title)."', Department='".mysql_real_escape_string($Department)."', LeadSource='".mysql_real_escape_string($LeadSource)."', AssignTo='".addslashes($AssignTo)."', Reference='".mysql_real_escape_string($Reference)."', DoNotCall='".mysql_real_escape_string($DoNotCall)."', NotifyOwner='".mysql_real_escape_string($NotifyOwner)."', EmailOptOut='".mysql_real_escape_string($EmailOptOut)."' , Description='".mysql_real_escape_string($Description)."', Status='".mysql_real_escape_string($Status)."'";
			}

			$strSQLQuery .= " where AddID='".$AddID."' ";

			$this->query($strSQLQuery, 0);		

			return true;
                   
                }    




		function addCustomerBillingAddress($arryDetails,$CustId)
				{
					global $Config;
					extract($arryDetails);		

					if($main_city_id>0) $OtherCity = '';
					if($main_state_id>0) $OtherState = '';
					$Name = addslashes($FirstName)." ".addslashes($LastName);
					$strSQLQuery = "INSERT INTO s_address_book set CustID = '".$CustId."', AddType='billing', Name='".$Name."', Company = '".addslashes($Company)."', Address='".addslashes(strip_tags($Address))."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$Country."', Mobile='".addslashes($Mobile)."',
					Email='".addslashes($Email)."',  Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',UpdatedDate = '".$Config['TodayDate']."'";
					$this->query($strSQLQuery, 0);
				
				
				}
				function UpdateCountryStateCity($arryDetails,$AddID){   
					extract($arryDetails);		

					$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddID = '".$AddID."'";
					$this->query($strSQLQuery, 0);
					return 1;
				}
					
					function UpdateBillingCountyStateCity($arryDetails,$Cid){   
						extract($arryDetails);		

						$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddType 	= 'billing' AND CustID = '".$Cid."'";
						$this->query($strSQLQuery, 0);
						return 1;
					}
					function UpdateShippingCountyStateCity($arryDetails,$Cid){   
						extract($arryDetails);		

						$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddType 	= 'shipping' AND CustID= '".$Cid."'";
						$this->query($strSQLQuery, 0);
						return 1;
					}
					
		function updateCustomerGeneralInfo($arryDetails)
		{
			 @extract($arryDetails);
			 global $Config;
			 $FullName = $FirstName." ".$LastName; 

			 $SqlCustomer = "UPDATE s_customers SET CustomerType = '".$CustomerType."', Company = '".addslashes($Company)."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Gender = '".mysql_real_escape_string($Gender)."', Landline = '".mysql_real_escape_string($Landline)."', Website = '".mysql_real_escape_string(strip_tags($Website))."', Mobile = '".mysql_real_escape_string($Mobile)."', Email = '".mysql_real_escape_string(strip_tags($Email))."', UpdatedDate = '".$Config['TodayDate']."', Status='".$Status."',Currency='".$Currency."',CustomerSince='".$CustomerSince."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', Taxable='".mysql_real_escape_string($Taxable)."' WHERE Cid = '".$CustId."'";
			 $this->query($SqlCustomer,0);
		   
		}    

                function updateCustomerContact($arryDetails)
                {
                     @extract($arryDetails);
                     global $Config;
                     
                     if($main_state_id>0) $OtherState = '';
		             if($main_city_id>0) $OtherCity = '';
                       $FullName = $FirstName." ".$LastName;  
                     $SqlCustomer = "UPDATE s_customers SET UpdatedDate = '".$Config['TodayDate']."',  FirstName='".addslashes($FirstName)."', LastName = '".addslashes($LastName)."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Gender = '".addslashes($Gender)."', Landline = '".$Landline."',  
	                              Fax = '".addslashes($Fax)."', Website = '".addslashes($Website)."', Mobile = '".$Mobile."', Email = '".addslashes($Email)."', Address = '".addslashes(strip_tags($Address))."', City = '".$main_city_id."',OtherCity = '".addslashes($OtherCity)."', State = '".$main_state_id."', OtherState = '".addslashes($OtherState)."', Country= '".$Country."', ZipCode = '".$ZipCode."' WHERE Cid = '".$CustId."'";
                     $this->query($SqlCustomer,0);
                   
                }    
                
                function getCustomerById($custId)
                {
                        $SqlCustomer = "SELECT * from s_customers WHERE Cid = '".$custId."'"; 
                        return $this->query($SqlCustomer, 1);
                }
                
              
               function UpdateShippingBilling($arryDetails){ 
			global $Config;
			extract($arryDetails);		

			$strSQLQuery = "select AddID FROM s_address_book WHERE CustId= '".$CustId."' and AddType='".$AddType."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['AddID']>0){
				$AddID = $arryRow[0]['AddID'];
			}else{
			$strSQL = "INSERT INTO s_address_book (CustID,AddType) values( '".$CustId."', '".addslashes($AddType)."')";
			$this->query($strSQL, 0);
			$AddID = $this->lastInsertId();
			}



			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';

			$strSQLQuery = "UPDATE s_address_book set FullName='".addslashes($Name)."', Address='".addslashes(strip_tags($Address))."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', Email='".addslashes($Email)."',  Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',UpdatedDate = '".$Config['TodayDate']."' WHERE AddID = '".$AddID."' ";
			$this->query($strSQLQuery, 0);
			return $AddID;
		 }
		 
		 function UpdateBankDetail($arryDetails){   
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "UPDATE s_customers SET BankName='".addslashes($BankName)."',AccountName='".addslashes($AccountName)."', AccountNumber='".addslashes($AccountNumber)."', IFSCCode='".addslashes($IFSCCode)."',UpdatedDate = '".$Config['TodayDate']."'
			WHERE Cid = '".$CustId."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                function UpdateImage($Image,$CustID)
				{
					$strSQLQuery = "UPDATE s_customers SET Image='".$Image."' WHERE Cid = '".$CustID."'";
					return $this->query($strSQLQuery, 0);
				}
                
		function  GetShippingBilling($CustID,$AddType)
		{
			$strSQLQuery = "select s.* from s_address_book s inner join s_customers c on s.CustID=c.Cid ";

			$strSQLQuery .= (!empty($CustID))?(" where s.CustID='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($AddType))?(" and s.AddType='".$AddType."'"):("");

			return $this->query($strSQLQuery, 1);
		}
                
               
		function RemoveCustomerContact($AddID)
		{			

			$strSQLQuery = "DELETE FROM s_address_book WHERE AddID = '".$AddID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;

		}



		function RemoveCustomer($CustID)
		{
			global $Config;
			$objConfigure=new configure();

			$strSQLQuery = "select Cid,Image FROM s_customers WHERE Cid= '".$CustID."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$ImgDir = '../upload/customer/'.$_SESSION['CmpID'].'/';

			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){				
			$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);					
			unlink($ImgDir.$arryRow[0]['Image']);	
			}

			$strSQLQuery = "DELETE FROM s_customers WHERE Cid = '".$CustID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "DELETE FROM s_address_book WHERE CustID = '".$CustID."'"; 
			$this->query($strSQLQuery, 0);



			return 1;

		}
                
                function changeCustomerStatus($Cid)
                {
                        $strSQLQuery = "SELECT * FROM s_customers WHERE Cid = '".$Cid."'";
                        $rs = $this->query($strSQLQuery);
                        if(sizeof($rs))
                        {
                                if($rs[0]['Status']== "Yes")
                                        $Status="No";
                                else
                                        $Status="Yes";

                                $strSQLQuery = "UPDATE s_customers SET Status ='$Status' WHERE Cid = '".$Cid."'";
                                $this->query($strSQLQuery,0);
                                return true;
                        }			
                }
                
                
             function customerRegistrationEmail($arryDetails,$CountryName,$StateName,$CityName)
                {
                       @extract($arryDetails);
                        
                       global $Config;
                        
                                $StoreUrl = $Config['homeCompleteUrl'].'/index.php';
                                $htmlPrefix = $Config['EmailTemplateFolder'];
                                 /**** Email to  Customer ******/
                                $ContentMsg = "Congratulations! You have successfully created a new account with <a href='".$StoreUrl."' target='_blank'>".stripslashes($Config['StoreName'])."</a>.";
                                $contents = file_get_contents($htmlPrefix."customerRegistrationEmail.htm");
								$FullName = ucfirst($FirstName)." ".ucfirst($LastName);
								$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);
								$contents = str_replace("[SITENAME]",$Config['StoreName'],$contents);
								$contents = str_replace("[USERNAME]",ucfirst($FirstName),$contents);
                                $contents = str_replace("[FULLNAME]",$FullName,$contents);
                                $contents = str_replace("[Company]",$Company,$contents);
                                $contents = str_replace("[Address]",$Address,$contents);
                                $contents = str_replace("[Address2]",$Address2,$contents);
                                $contents = str_replace("[Country]",$CountryName,$contents);
                                $contents = str_replace("[State]",$StateName,$contents);
                                $contents = str_replace("[City]",$CityName,$contents);
                                $contents = str_replace("[Zipcode]",$ZipCode,$contents);
                                $contents = str_replace("[Phone]",$Phone,$contents);
								$contents = str_replace("[EMAIL]",$Email,$contents);
								$contents = str_replace("[PASSWORD]",$Password,$contents);	
								$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								$contents = str_replace("[DATE]",date("jS, F Y"),$contents);			
								$mail = new MyMailer();
								$mail->IsMail();			
								$mail->AddAddress($Email);
								$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);   
								$mail->Subject = $Config['StoreName']." - Registration Details";
								$mail->IsHTML(true);
								$mail->Body = $contents;  
   
							if($Config['Online'] == '1'){
								$mail->Send();	
							}
                             
                                 /**** Email to  Admin ******/
                                $ContentMsg = "There is a new user registered on ".stripslashes($Config['StoreName'])." website";
                                $contents = file_get_contents($htmlPrefix."customerRegistrationEmailToAdmin.htm");
								$FullName = ucfirst($FirstName)." ".ucfirst($LastName);
								$contents = str_replace("[ContentMsg]",$ContentMsg,$contents);
								$contents = str_replace("[SITENAME]",$Config['StoreName'],$contents);
								$contents = str_replace("[USERNAME]",ucfirst($FirstName),$contents);
                                $contents = str_replace("[FULLNAME]",$FullName,$contents);
                                $contents = str_replace("[Company]",$Company,$contents);
                                $contents = str_replace("[Address]",$Address,$contents);
                                $contents = str_replace("[Address2]",$Address2,$contents);
                                $contents = str_replace("[Country]",$CountryName,$contents);
                                $contents = str_replace("[State]",$StateName,$contents);
                                $contents = str_replace("[City]",$CityName,$contents);
                                $contents = str_replace("[Zipcode]",$ZipCode,$contents);
                                $contents = str_replace("[Phone]",$Phone,$contents);
								$contents = str_replace("[EMAIL]",$Email,$contents);
								$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								$contents = str_replace("[DATE]",date("jS, F Y"),$contents);			
								$mail = new MyMailer();
								$mail->IsMail();			
								$mail->AddAddress($Config['CompanyEmail']);
								$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);   
								$mail->Subject = $Config['StoreName']." - New user registered";
								$mail->IsHTML(true);
								$mail->Body = $contents;  
				   
								if($Config['Online'] == '1'){
									$mail->Send();	
								}
                                
                }
                
              
    
		function  GetCustomerAddressBook($CustID,$AddID)
		{
			if($AddID>0){
			$strSQLQuery = "SELECT c.FullName as CustomerName, c.CustCode, c.Company as CustomerCompany,c.Taxable,ab.* FROM s_address_book ab inner join s_customers c on ab.CustID=c.Cid WHERE ab.AddID='".$AddID."' ";			
			return $this->query($strSQLQuery, 1);
			}
		}


	           function GetCustomerAllInformation($CustID,$CustCode,$Status)
			   {
			        $strSQLQuery = "SELECT c.FullName as CustomerName, c.CustCode, c.Company as CustomerCompany,c.PaymentTerm,c.PaymentMethod,c.ShippingMethod,c.Currency,c.Taxable
,ab.FullName as Name,ab.Company,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName, ab.Mobile,ab.Landline,ab.Fax, ab.Email 
,sp.FullName as sName,sp.Company  as sCompany ,sp.Address as sAddress, sp.ZipCode as sZipCode, sp.CountryName as sCountryName ,sp.StateName as sStateName, sp.CityName as sCityName, sp.Mobile as sMobile,sp.Landline as sLandline,sp.Fax as sFax, sp.Email  as sEmail
FROM s_customers as c LEFT OUTER JOIN s_address_book as ab ON (c.Cid = ab.CustID and ab.AddType = 'billing') LEFT OUTER JOIN s_address_book as sp ON (c.Cid = sp.CustID and sp.AddType = 'shipping') WHERE c.CustCode='".$CustCode."'  ";
					return $this->query($strSQLQuery, 1);
			   
			   }
            
			  
			  function checkShippingAddress($id)
			  {
			          $SqlCustomer = "SELECT COUNT(AddID) AS total FROM s_address_book WHERE CustID = '".$id."' AND AddType = 'shipping'";
					  $ChArray = $this->query($SqlCustomer,1);
					  $ChShipp = $ChArray[0]['total'];
                      return  $ChShipp;
			  
			  
			  }


		function isCustAddressExists($CustID,$AddType)
		{
			$strSAddQuery = (!empty($AddType))?(" and AddType = '".$AddType."'"):("");
			$strSQLQuery = "select AddID from s_address_book where CustID='".$CustID."'".$strSAddQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['AddID'])) {
				return true;
			} else {
				return false;
			}
		}


	 function CustomCustomer($selectCol, $condition) {
		global $Config;
		$strSQLQuery = "select * from s_customers where 1  " . $condition . "  ";
	       # $strSQLQuery .= ($Config['vAllRecord'] != 1) ? (" and (AssignTo = '" . $_SESSION['AdminID'] . "' OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");

		$strSQLQuery .= ' order by Cid desc ';
		#echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);
	  }

	function NextPrevCustomer($Cid,$FullName,$Next) {
		global $Config;
		if($Cid>0){
			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."') "):(""); 
		
			if($Next==1){
				$operator = ">"; $asc = 'asc';
			}else{
				$operator = "<";  $asc = 'desc';
			}

			$strSQLQuery = "select c.Cid from s_customers c where c.Cid!='".$Cid."' 
and c.FullName ".$operator." '" . $FullName . "' ". $strAddQuery. " order by c.FullName ".$asc." limit 0,1";

			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow[0]['Cid'];
		}
	}
        
        
        function getCustomerAddressForPO($CustID){
            
             $SqlCustomer = "select * from s_address_book where AddType = 'contact' and PrimaryContact='1' and CustID='".$CustID."'";
		 
             return $this->query($SqlCustomer, 1);
            
        }


}
?>
