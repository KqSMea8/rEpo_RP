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
		//updated for Addtype = billing and cloumns city/Zip/Address on 21Dec2017 by chetan//
                function getCustomers($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
			global $Config;
                        $strAddQuery = 'where 1 ';
			$strAddQuery .= (!empty($Config['rule']))?( $Config['rule']):(""); 
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= ($Status>0)?(" and c1.Status='".$Status."'"):("");

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (c1.AdminType='".$_SESSION['AdminType']."' and c1.AdminID='".$_SESSION['AdminID']."') or c1.SalesID='".$_SESSION['AdminID']."' "):(""); 

$strOnQuery = (!empty($Config['addTp']))?(" c1.Cid = ab.CustID and ab.AddType = '".$Config['addTp']."' "):(" c1.Cid = ab.CustID and (ab.AddType = 'billing') "); //and ab.PrimaryContact='1' updated on 3Jan2018//

$strAddQuery .= (!empty($Config['rows'])) ? ("  and c1.RowColor = '#" . $Config['rows'] . "' ") : ("");  //add Rajan 20 jan
			if($SearchKey=='active' && ($SortBy=='c1.Status' || $SortBy=='') ){
				$strAddQuery .= " and c1.Status='Yes'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c1.Status' || $SortBy=='') ){
				$strAddQuery .= " and c1.Status='No'";
			}else if($SortBy != '' && $SortBy=='c1.FullName'){
				$strAddQuery .= (!empty($SearchKey))?(" and (c1.FullName like '".$SearchKey."%' or c1.Company like '".$SearchKey."%')"):("");
			
			}else if($SortBy != '' && $SortBy!='c1.FullName'){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}			 
			 else{
				//$strAddQuery .= (!empty($SearchKey))?(" and (c1.FullName like '".$SearchKey."%' or c1.FirstName like '".$SearchKey."%' or c1.LastName like '%".$SearchKey."%' or c1.Company like '%".$SearchKey."%' or c1.Email like '%".$SearchKey."%' or c1.Landline like '%".$SearchKey."%' or c1.CustCode like '%".$SearchKey."%' or ab.CountryName like '%".$SearchKey."%' or ab.StateName  like '%".$SearchKey."%') "):("");
$strAddQuery .= (!empty($SearchKey))?(" and (c1.FullName like '".$SearchKey."%' or c1.FirstName like '".$SearchKey."%' or c1.LastName like '%".$SearchKey."%' or c1.Company like '%".$SearchKey."%' or c1.Email like '%".$SearchKey."%' or c1.Landline like '%".$SearchKey."%' or c1.CustCode like '%".$SearchKey."%'  ) "):("");
			}
			

						
			if($Config['GetNumRecords']==1){
				$Columns = " count(c1.Cid) as NumCount ";				
			}else{		
				$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by CustomerName ");
				$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");
		
			$Columns = "  c1.*,IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as CustomerName,ab.CountryName ,ab.StateName,ab.Landline,ab.CityName,ab.ZipCode,ab.Address  ";
//$Columns = "  c1.*,IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as CustomerName  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
   			//$addTp = ($Config['addTp'])	 ?  $Config['addTp']	: 'contact';
		 $SqlCustomer = "select ".$Columns." from s_customers c1 left outer join s_address_book ab ON (".$strOnQuery.") ".$strAddQuery;
	//SqlCustomer = "select ".$Columns." from s_customers c1 ".$strAddQuery;
			 
                    return $this->query($SqlCustomer, 1);
                }
                

  
		function  ListCustomer($arryDetails,$DB='')
		{
			global $Config;
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where c.Cid='".$id."'"):(" where 1");

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."' "):(""); 


			$strAddQuery .= (!empty($SearchKey))?(" and ( c.FullName like '%".$SearchKey."%' or c.Company like '%".$SearchKey."%' or c.CustCode like '%".$SearchKey."%' or c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%' or ab.CountryName like '%".$SearchKey."%' or ab.StateName like '%".$SearchKey."%' or ab.CityName like '%".$SearchKey."%') " ):("");
			$strAddQuery .= " and c.Status='Yes'"; 

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by FullName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");
			$strSQLQuery = "SELECT c.*,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as FullName, ab.CountryName ,ab.StateName,ab.CityName from ".$DB."s_customers c left outer join ".$DB."s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'billing' ) ".$strAddQuery."";

                        //and ab.PrimaryContact='1'
                     
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		

		}	

	function  CustomerListing($arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where c.Cid='".$id."'"):(" where 1");

			
			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."') or c.SalesID='".$_SESSION['AdminID']."' "):(""); 

			$strAddQuery .= (!empty($SearchKey))?(" and ( c.FullName like '%".$SearchKey."%' or c.Company like '%".$SearchKey."%' or c.CustCode like '%".$SearchKey."%' or c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%' or ab.CountryName like '%".$SearchKey."%' or ab.StateName like '%".$SearchKey."%' or ab.CityName like '%".$SearchKey."%') " ):("");
			$strAddQuery .= " and c.Status='Yes'"; 

			

			if($Config['GetNumRecords']==1){
				$Columns = " count(c.Cid) as NumCount ";				
			}else{	
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by CustomerName ");
				$strAddQuery .= (!empty($asc))?($asc):(" Asc");
			
				$Columns = "  c.*,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName, ab.CountryName ,ab.StateName,ab.CityName ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			$strSQLQuery = "SELECT ".$Columns." from s_customers c left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery."";
                       
                     
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		

		}	


		function  GetCustomer($CustID,$CustCode,$Status)
		{
			global $Config;


			$strSQLQuery = "SELECT c.*,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName,concat(e.FirstName,' ',e.LastName) as sales_person FROM s_customers c left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') left outer join h_employee e on FIND_IN_SET(e.EmpID, c.SalesID)  ";
			$strSQLQuery .= (!empty($CustID))?(" WHERE c.Cid='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($CustCode))?(" and c.CustCode='".$CustCode."'"):("");
			$strSQLQuery .= ($Status!='')?(" AND c.Status='".$Status."'"):("");

			
			$strSQLQuery .= ' order by CustomerName asc ';
			return $this->query($strSQLQuery, 1);

		}

		function  GetCustomerBrief($CustID,$CustCode,$Status)
		{
			global $Config;

			$strSQLQuery = "SELECT c.Cid, c.CustCode, IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName, c.Currency as CustCurrency, c.CreditLimit,c.CreditLimitCurrency FROM s_customers c  ";
			$strSQLQuery .= (!empty($CustID))?(" WHERE c.Cid='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($CustCode))?(" and c.CustCode='".$CustCode."'"):("");
			$strSQLQuery .= ($Status!='')?(" AND c.Status='".$Status."'"):("");
			
			$strSQLQuery .= ' order by CustomerName asc ';
			return $this->query($strSQLQuery, 1);

		}

		function  GetCustomerBalance($CustCode)
		{
			global $Config;
			if(!empty($CustCode)){
				/********Open Orders********/
			 	$strSQLQuery = "SELECT SUM(s.TotalAmount) as TotalOrderAmount FROM s_order s  WHERE s.CustCode='".$CustCode."' and s.Module='Order' and s.Status not in ('Completed') ";
			 	$arryOrder = $this->query($strSQLQuery, 1);
			 	$OrderAmount = $arryOrder[0]["TotalOrderAmount"];
				/*******Invoice Balance******/
				$CustomerUnpaidInvoice = 0; 		
				$strSQL = "select distinct(o.OrderID) as OrderID, o.Module, o.InvoiceID, o.CreditID, o.TotalInvoiceAmount ,o.TotalAmount ,o.ConversionRate, o.CustomerCurrency, (SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and (p.InvoiceID !='' OR p.CreditID !='') and p.PostToGL ='Yes' and ((p.InvoiceID=o.InvoiceID and o.Module='Invoice') OR (p.CreditID=o.CreditID and o.Module='Credit')) and p.CustCode='".$CustCode."' and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt from s_order o  where ((o.InvoicePaid!='Paid' and o.Module='Invoice') OR (o.Status!='Completed' and o.Module='Credit')) and o.CustCode='".$CustCode."' and o.PostToGL='1'  order by o.CustCode asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END Desc  ,o.OrderID Desc";
				$arryAging = $this->query($strSQL, 1);
				foreach($arryAging as $key=>$values){
					$ConversionRate=1;
					if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
						$ConversionRate = $values['ConversionRate'];			   
					}
					if($values['Module']=='Invoice'){
						$orginalAmount = $values['TotalInvoiceAmount'];
					}else if($values['Module']=='Credit'){
						$orginalAmount = -$values['TotalAmount'];
					}					 
					$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 
					$PaidAmnt = $values['ReceiveAmnt'];
					if($PaidAmnt !=''){
					    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
					}else{
					    $UnpaidInvoice = $orginalAmount;
					}					 
					$CustomerUnpaidInvoice += $UnpaidInvoice;
				}			 
				$CustomerUnpaidInvoice = round($CustomerUnpaidInvoice,2);
				/*******Total Balance*******/
				return $TotalBalance = $OrderAmount + $CustomerUnpaidInvoice;
			}	 
			

		}



		function  GetCustomerBalanceOnOrder($CustCode)
		{
			global $Config;
			if(!empty($CustCode)){				
			 	$strSQLQuery = "SELECT SUM(s.TotalAmount) as TotalOrderAmount FROM s_order s  WHERE s.CustCode='".$CustCode."' and s.Module='Order' and s.Status not in ('Completed') ";
			 	$arryOrder = $this->query($strSQLQuery, 1);
			 	$OrderAmount = $arryOrder[0]["TotalOrderAmount"];				
				return $OrderAmount;
			} 

		}

		function  GetCustomerOrderSource($CustCode)
		{
			global $Config;
			if(!empty($CustCode)){
			 	$strSQLQuery = "SELECT s.OrderSource FROM s_order s  WHERE s.CustCode='".$CustCode."' and OrderSource!='' and s.Module='Order' order by OrderID desc limit 0,1";
			 	$arryOrder = $this->query($strSQLQuery, 1);
			 	if(!empty($arryOrder[0]["OrderSource"]))return $arryOrder[0]["OrderSource"];		
			}				

		}
		
		function  GetCustomerContact555($CustID,$PrimaryContact)
		{
			
			$strAddQuery .= (!empty($PrimaryContact))?(" and ab.PrimaryContact='".$PrimaryContact."'"):("");
			$strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.AddType = 'contact' ".$strAddQuery." order by PrimaryContact Desc, AddID asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCustomerContact($CustID,$PrimaryContact,$status=null,$order=' , AddID asc')
		{
			$strAddQuery='';
			/**********Added By karishma for Multistore**************/
			if( $_GET['tab']=='shipping' ) $AddType='shipping';
			else  $AddType='contact';
			$strAddQuery .= (!empty($PrimaryContact))?(" and ab.PrimaryContact='".$PrimaryContact."'"):("");
			if( $_GET['tab']=='shipping' ) $strAddQuery .= " and ( ab.Status='".$status."' or ab.Status='0')";
			else  if($status!=null)
			$strAddQuery .= " and ab.Status='".$status."'";
			
			/**********End By karishma for Multistore**************/

		    $strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.AddType = '".$AddType."' ".$strAddQuery." order by PrimaryContact Desc $order";
			if(!empty($_GET['pk'])) echo $strSQLQuery;

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

		function setRowColorContact($AddID,$RowColor) {

			if (!empty($AddID)) {
			    $sql = "update s_address_book set RowColor='".$RowColor."' where AddID in ( " . $AddID . ")";
			    $rs = $this->query($sql, 0);
			}

			return true;
		}

		function  ListCrmContact($arryDetails)
		{
			global $Config;
                        extract($arryDetails);
			$strAddQuery = '';
                        $SearchKey   = strtolower(trim($key));
			
                        $SortBy = $sortby;
			$strAddQuery .= (!empty($id))?(" where c.AddID='".$id. "'"):(" where c.CrmContact='1' and c.AddType='contact' ");

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (c.AssignTo='".$_SESSION['AdminID']."' OR c.AdminID='".$_SESSION['AdminID']."')  "):("");
$strAddQuery .= (!empty($Config['rows'])) ? ("  and c.RowColor = '#" . $Config['rows'] . "' ") : ("");  //add Rajan 20 jan
                         $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			if($SearchKey=='active' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status='0'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '%".$SearchKey."%' or c.LastName like '%".$SearchKey."%'  or c.Email like '%".$SearchKey."%' or c.Title like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%'   ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.FirstName ");
			$strAddQuery .= (!empty($AscDesc))?($asc):(" Asc");

if($Config['GetNumRecords']==1){
				$Columns = " count(c.AddID) as NumCount ";				
			}else{				
				$Columns = " c.*,e.EmpID,e.UserName as AssignTo,cus.FullName as CustomerName, cus.CustCode ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}



			 $strSQLQuery = "select ".$Columns."   from s_address_book c left outer join  h_employee e on e.EmpID=c.AssignTo left outer join s_customers cus ON cus.Cid = c.CustID  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}
                
                
                function  ListContact($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
                       $SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where c.AddID='".$id. "'"):(" where c.CrmContact='1' and c.AddType='contact' ");

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (c.AssignTo='".$_SESSION['AdminID']."' OR c.AdminID='".$_SESSION['AdminID']."')  "):("");

			if($SearchKey=='active' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='c.Status' || $SortBy=='') ){
				$strAddQuery .= " and c.Status='0'";
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
		
	//update by chetan 16Mar//	
	function isCustomerExist($FirstName, $LastName, $Company, $Cid = 0) {
        $strAddQuery .= (!empty($Cid)) ? (" and Cid != '" . $Cid. "'") : ("");
		//$strAddQuery .= (!empty($Company)) ? (" and LCASE(Company) ='".addslashes(strtolower(trim($Company)))."' " ) : (" and LCASE(FirstName)='" . addslashes(strtolower(trim($FirstName))) . "' and LCASE(LastName)='" . addslashes(strtolower(trim($LastName))) . "' ");
	$strAddQuery .= (!empty($Company)) ? (" and LCASE(Company) ='".addslashes(strtolower(trim($Company)))."' " ) : ('');
	$strAddQuery .= (!empty($FirstName) && !empty($LastName) ) ? (" and LCASE(FirstName)='" . addslashes(strtolower(trim($FirstName))) . "' and LCASE(LastName)='" . addslashes(strtolower(trim($LastName))) . "' " ) : ('');

        $strSQLQuery = "select Cid from s_customers where 1 " . $strAddQuery;
	
        $arryRow = $this->query($strSQLQuery, 1);

        if(!empty($arryRow[0]['Cid'])) {
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
                
                function addCustomer($arryDetails,$DBName="")
                {
			@extract($arryDetails);
			global $Config;

if($AdminID==''){ $AdminID=$_SESSION['AdminID']; } if($AdminType==''){ $AdminType=$_SESSION['AdminType']; }
									$DB=''; $CmpID=$_SESSION['CmpID']; if($DBName!='') { $DB=$DBName.'.'; $CmpID=$AdminID; }
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status="Yes";
			$ipaddress = GetIPAddress(); 
			$FullName = $FirstName." ".$LastName; 
			
			//By chetan 15Feb//
			if($arryDetails['Company']!='')
			{
				$CustomerType = 'Company';
			}
			//End//

			/*
			$sql = "INSERT INTO s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."', CustomerType = '".mysql_real_escape_string($CustomerType)."', Company = '".mysql_real_escape_string(strip_tags($Company))."', Currency='".mysql_real_escape_string($Currency)."',CustomerSince='".mysql_real_escape_string($CustomerSince)."', PaymentMethod='".mysql_real_escape_string($PaymentMethod)."', ShippingMethod='".mysql_real_escape_string($ShippingMethod)."', PaymentTerm='".mysql_real_escape_string($PaymentTerm)."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Gender = '".mysql_real_escape_string($Gender)."', Landline = '".mysql_real_escape_string($Landline)."', Website = '".mysql_real_escape_string(strip_tags($Website))."', Mobile = '".mysql_real_escape_string($Mobile)."', Email = '".mysql_real_escape_string(strip_tags($Email))."', CreatedDate = '".mysql_real_escape_string($Config['TodayDate'])."', ipaddress = '".$ipaddress."', Status='".mysql_real_escape_string($Status)."' , Taxable='".mysql_real_escape_string($Taxable)."', AdminID='".$_SESSION['AdminID']."', AdminType='".$_SESSION['AdminType']."' ";
			*/
			
			$sql = "INSERT INTO ".$DB."s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."', 
			CustomerType = '".mysql_real_escape_string($CustomerType)."', 
			Company = '".mysql_real_escape_string(strip_tags($Company))."', 
			Currency='".mysql_real_escape_string($Currency)."',
			CustomerSince='".mysql_real_escape_string($CustomerSince)."', 
			PaymentMethod='".mysql_real_escape_string($PaymentMethod)."', 
			ShippingMethod='".mysql_real_escape_string($ShippingMethod)."', 
			PaymentTerm='".mysql_real_escape_string($PaymentTerm)."', 
			FirstName='".mysql_real_escape_string(strip_tags($FirstName))."',
			LastName = '".mysql_real_escape_string(strip_tags($LastName))."', 
			FullName = '".mysql_real_escape_string(strip_tags($FullName))."', 
			Gender = '".mysql_real_escape_string($Gender)."', 
			Landline = '".mysql_real_escape_string($Landline)."',
			Website = '".mysql_real_escape_string(strip_tags($Website))."', 
			Mobile = '".mysql_real_escape_string($Mobile)."', 
			Email = '".mysql_real_escape_string(strip_tags($Email))."', 
			CreatedDate = '".mysql_real_escape_string($Config['TodayDate'])."', 
			ipaddress = '".$ipaddress."', 
			Status='".mysql_real_escape_string($Status)."' , 
			Taxable='".mysql_real_escape_string($Taxable)."', 
			AdminID='".$_SESSION['AdminID']."', 
			AdminType='".$_SESSION['AdminType']."', 
			RigisterType = '".$RigisterType."',
			RigisterTypeID = '".$RigisterTypeID."',
			FacebookID = '".$FacebookID."',
			TwitterID = '".$TwitterID."',
   GoogleID = '".$GoogleID."',
			InstagramID = '".$InstagramID."',
			FacebookInfo = '".$FacebookInfo."',
			TwitterInfo = '".$TwitterInfo."',
			LinkedinInfo = '".$LinkedinInfo."',
			LinkedinID = '".$LinkedinID."',
			PID 			= '".$PID."',
   EDICompId = '".$EDICompId."', 
   EDICompName = '".$EDICompName."',
   DefaultCustomer = '".$DefaultCustomer."' ";
			//echo $sql;die;


  
			
			$this->query($sql,0);

			$customerId = $this->lastInsertId();
			
			
				if(!empty($_POST['DefaultCustomer'])){
			    $strSQLQuery = "SELECT COUNT(*) DefCust FROM s_customers WHERE  DefaultCustomer=1  ";
       $arryDefCust = $this->query($strSQLQuery, 1);
       if($arryDefCust[0]['DefCust'] >0){
            $SqlCust = "update s_customers set DefaultCustomer=0 where DefaultCustomer=1";
             $this->query($SqlCust,0);
       }
   }
			

			if(empty($CustCode)){
				$CustCode = 'CUST000'.$customerId;
				$strSQL = "UPDATE ".$DB."s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."' WHERE Cid = '".mysql_real_escape_string($customerId)."'"; 
				$this->query($strSQL, 0);
			}
			$CustId = $customerId;
			/***********************/			
	
			$strSQLQuery = "insert INTO ".$Config['DbMain'].".company_user set  user_name='".addslashes($Email)."', ref_id='".mysql_real_escape_string($CustId)."', user_type='customer', comId='".$_SESSION['CmpID']."' "; 
			$this->query($strSQLQuery, 0);		

			/***********************/





                    	return $customerId;
                   
                }



/************************** Added by bhoodev customer add function new for custom field************/
 function addCustomFieldCustomer($arryDetails)
                {									
			@extract($arryDetails);
			global $Config;

			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status="Yes";
			$ipaddress = GetIPAddress(); 
			$FullName = $FirstName." ".$LastName; 

			//By chetan 18Aug//    
                        $objField = new field();
                        $arryflds=$objField->getFormField('',21,1);  //3Sep//
                        $arry = array_map(function($arr){
                                    if($arr['fieldname']== 'Image'){		//$arr['fieldname']== 'FirstName' || $arr['fieldname']== 'LastName' ||8Dec//
                                         unset($arr);
                                    }else{
                                       return $arr['fieldname'];
                                    }   
                                },$arryflds);
                        $arryflds = array_values(array_filter($arry)); 
                        foreach($arryflds as $key)
                        {       
                        	$str.= "$key='".addslashes($arryDetails[$key])."'".',';
                        }


   
			$sql = "insert into s_customers set ".$str." FullName='" . $FullName . "', CreatedDate='" . $Config['TodayDate'] ."', IpAddress='".$IpAddress."', AdminID='".$_SESSION['AdminID']."', AdminType ='".$_SESSION['AdminType']."', PID = '".$PID."'" ;

			//End//

			$this->query($sql,0);

			$customerId = $this->lastInsertId();

			if(empty($CustCode)){
				$CustCode = 'CUST000'.$customerId;
				$strSQL = "UPDATE s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."' WHERE Cid = '".mysql_real_escape_string($customerId)."'"; 
				$this->query($strSQL, 0);
			}
			$CustId = $customerId;
			/***********************updated by chetan on 3Aug@2017*/
			
			
			$strSQLQuery = "insert INTO ".$Config['DbMain'].".company_user set  user_name='".addslashes($Email)."', ref_id='".mysql_real_escape_string($CustId)."', user_type='customer', comId='".$_SESSION['CmpID']."' "; 
			$this->query($strSQLQuery, 0);		

if($_SESSION['AdminType']=='employee'){
				 $SelectQuery ="select * from h_commission where EmpID='".$_SESSION['AdminID']."'"; 
				$rslt = $this->query($SelectQuery, 1);
				if(sizeof($rslt)>0){
				    $strSQL = "UPDATE ".$DB."s_customers SET SaleID = '".mysql_real_escape_string($_SESSION['AdminID'])."' WHERE Cid = '".mysql_real_escape_string($customerId)."'"; 
				$this->query($strSQL, 0);
				
				}
			
			
			}
			
			/***********************End********************/

                    	return $customerId;
                   
                }


/*****************************End *********************************/
				
			
		function addCustomerAddress($arryDetails,$CustID,$AddType,$DBName='')
		{
			global $Config;
			extract($arryDetails);
// EDI update
        $DB='';
					if($DBName!='') {
						$DB=$DBName.'.';
			
					}
// End EDI update

			if($main_city_id>0) $OtherCity = "";
			if($main_state_id>0) $OtherState = "";
                        if(empty($FullName)){
			$FullName = $FirstName." ".$LastName;
                        }
                        else{
                            $FullName=$FullName;
                            unset($arryDetails['FullName']);
                        }
			$IpAddress = GetIPAddress(); 
			if($Status=='') $Status=1;
			/*$strSQLQuery = "INSERT INTO s_address_book set CustID = '".$CustID."', AddType='".$AddType."', PrimaryContact = '".$PrimaryContact."', CrmContact = '".$CrmContact."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$Country."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."', PersonalEmail='".mysql_real_escape_string($PersonalEmail)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', CreatedDate = '".$Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."', AdminID = '".$_SESSION['AdminID']."', AdminType = '".$_SESSION['AdminType']."', CreatedBy = '".addslashes($_SESSION['UserName'])."',Title='".mysql_real_escape_string($Title)."',Department='".mysql_real_escape_string($Department)."',LeadSource='".mysql_real_escape_string($LeadSource)."',AssignTo='".addslashes($AssignTo)."',Reference='".mysql_real_escape_string($Reference)."', DoNotCall='".mysql_real_escape_string($DoNotCall)."', NotifyOwner='".mysql_real_escape_string($NotifyOwner)."', EmailOptOut='".mysql_real_escape_string($EmailOptOut)."', Description='".mysql_real_escape_string($Description)."' , Status='".mysql_real_escape_string($Status)."',CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  
			CityName='".addslashes($City)."',
			RigisterType = '".$RigisterType."',
			RigisterTypeID = '".$RigisterTypeID."',
			FacebookID = '".$FacebookID."',
			TwitterID = '".$TwitterID."',
                        LinkedinID = '".$LinkedinID."',
			InstagramID = '".$InstagramID."',
			GoogleID = '".$GoogleID."'";*/
			//By chetan 7Dec//    
     unset($arryDetails['Submit']);
     unset($arryDetails['CustCode']);
     unset($arryDetails['main_state_id']);
     unset($arryDetails['main_city_id']);
     unset($arryDetails['ajax_state_id']);
     unset($arryDetails['ajax_city_id']);
     unset($arryDetails['state_id']);
     unset($arryDetails['city_id']);
     //unset($arryDetails['Company']);
     unset($arryDetails['country']);
     unset($arryDetails['State']);
     unset($arryDetails['City']);
     unset($arryDetails['SubmitContact']);
     unset($arryDetails['CurrentDivision']);
     unset($arryDetails['CustCode']);
     unset($arryDetails['Gender']);
     unset($arryDetails['Website']);
     unset($arryDetails['CreditLimit']);
     unset($arryDetails['tab']);
     unset($arryDetails['CustomerType']);
     unset($arryDetails['CustomerSince']);
     unset($arryDetails['PaymentTerm']);
     unset($arryDetails['customerHold']);
     unset($arryDetails['ShippingMethod']);
     unset($arryDetails['Taxable']);
     unset($arryDetails['VAT']);
     unset($arryDetails['PAN']);
     unset($arryDetails['CST']);
     unset($arryDetails['TRN']);
     unset($arryDetails['CreditLimit']);
     unset($arryDetails['c_taxRate']);
     unset($arryDetails['Currency']);
     unset($arryDetails['CreditLimitCurrency']);
     unset($arryDetails['Status']);
     unset($arryDetails['tel_ext']);
     unset($arryDetails['e5cfd1']);
      unset($arryDetails['3bcf5c']);
      unset($arryDetails['DefaultAccount']);


if($arryDetails['AdminID']!='' && !empty($arryDetails['AdminID'])){
$AdminIDValue = $arryDetails['AdminID'];
$AdminTypeValue = $arryDetails['AdminType'];
unset($arryDetails['AdminID']);
unset($arryDetails['AdminType']);
}else{
unset($arryDetails['AdminID']);
unset($arryDetails['AdminType']);
$AdminIDValue = $_SESSION['AdminID'];
$AdminTypeValue = $_SESSION['AdminType'];

}


/*$ArrayFieldName2 = $this->GetFieldName('s_customers');	
				foreach($ArrayFieldName2 as $key=>$dataval){
					if($values['Key'] != 'PRI' && $dataval['Field']!='OrderID'){
						$FeildAndValuesArray2[] = "`".$dataval['Field']."`";
						echo $dataval['Field']."<br>";
						unset($arryDetails[$dataval['Field']]);
					} 	 
				}
				$FeildAndValues2 = implode(", ",$FeildAndValuesArray2);

pr($FeildAndValuesArray2);
*/

			$fields = join(',',array_keys($arryDetails));
			//$values = join('','',array_map($arryDetails));
			  foreach($arryDetails as $val)
		             {
		             	$values.= "'".addslashes($val)."'".',';//updated on 22Sept2017 by chetan//
		             }

			$values =rtrim($values,',');
			if($arryDetails['CustID'] == "" && $CustID!='')
                        {
                            $fields .= ',CustID';
                            $values.= ',"'.$CustID.'"';
                        }
			$strSQLQuery = "insert into ".$DB."s_address_book 
				    (AddType,  FullName, city_id,state_id,CreatedDate,UpdatedDate,IpAddress,AdminID,
				    AdminType,CreatedBy,CountryName,StateName,CityName,$fields)
				    values( '" . $AddType . "',
					    '" . $FullName . "',
					    '"  . $main_city_id ."',
					    '"  . $main_state_id . "',
					    '"  . $Config['TodayDate'] ."', 
					    '" .  $Config['TodayDate']."',
					     '" .$IpAddress."',
					    '" .$AdminIDValue."',
					    '" .$AdminTypeValue."' ,  
					    '" .addslashes($_SESSION['UserName'])."',   
					    '" .$country."',    
					    '" .$State."',      
					    '" .$City."',
					    $values)" ;

			//End//
		#echo $strSQLQuery;die;
			$this->query($strSQLQuery, 0);

			 $AddID = $this->lastInsertId();

			return $AddID;

		}

		//Updated by Chetan 11Dec//
  		function updateCustomerAddress($arryDetails,$AddID)
                {
			                   
                     	global $Config;
			extract($arryDetails);		

			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			$FullName = $FirstName." ".$LastName;
			$IpAddress = GetIPAddress(); 
			$str='';
unset($arryDetails['tab']);

			/*$strSQLQuery = "update s_address_book set FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$Country."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."', PersonalEmail='".mysql_real_escape_string($PersonalEmail)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."' ";*/
//By Chetan 6July//
                        $unsetArray = array("AddID","CustID","Title","Department","LeadSource","Submit","AssignTo","Reference","DoNotCall","NotifyOwner",
                            "EmailOptOut","ajax_state_id","ajax_city_id","Description","Status",'main_state_id','main_city_id','state_id','city_id','SubmitContact','CurrentDivision','e5cfd1');
                        foreach($unsetArray as $arr){unset($arryDetails[$arr]);}

                        foreach($arryDetails as $key=>$values)
                        {
                        	$str.= "$key='".$values."'".',';
                        }

                        $strSQLQuery = "update s_address_book set ".trim($str, ',')." , 
					UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."',
                                    city_id='".$main_city_id."', state_id='".$main_state_id."' , FullName='".mysql_real_escape_string($FullName)."' ";

                        
                        //End//
			
			if(!empty($CrmContact)){
				$strSQLQuery .= " ,CustID = '".$CustID."', Title='".mysql_real_escape_string($Title)."', Department='".mysql_real_escape_string($Department)."', LeadSource='".mysql_real_escape_string($LeadSource)."', AssignTo='".addslashes($AssignTo)."', Reference='".mysql_real_escape_string($Reference)."', DoNotCall='".mysql_real_escape_string($DoNotCall)."', NotifyOwner='".mysql_real_escape_string($NotifyOwner)."', EmailOptOut='".mysql_real_escape_string($EmailOptOut)."' , Description='".mysql_real_escape_string($Description)."', Status='".mysql_real_escape_string($Status)."'";
			}

			$strSQLQuery .= " where AddID='".$AddID."' ";

			//echo $strSQLQuery;exit;

			$this->query($strSQLQuery, 0);		

			return true;
                   
                }    

		function updateAssignRole($arryDetails,$AddID)
		{
					   
		     	global $Config;
			extract($arryDetails);	

			if($PaymentInfo==1){
				$strSQLQuery = "update s_address_book set PaymentInfo = '0' where AddID!='".$AddID."' and CustID='".$CustID."' ";
				$this->query($strSQLQuery, 0);	
			}
			if($SoDelivery==1){
				$strSQLQuery = "update s_address_book set SoDelivery = '0' where AddID!='".$AddID."' and CustID='".$CustID."'  ";
				$this->query($strSQLQuery, 0);	
			}
			if($CreditDelivery==1){
				$strSQLQuery = "update s_address_book set CreditDelivery = '0' where AddID!='".$AddID."' and CustID='".$CustID."' ";
				$this->query($strSQLQuery, 0);	
			}
			if($ReturnDelivery==1){
				$strSQLQuery = "update s_address_book set ReturnDelivery = '0' where AddID!='".$AddID."' and CustID='".$CustID."' ";
				$this->query($strSQLQuery, 0);	
			}
			if($Statement==1){
				$strSQLQuery = "update s_address_book set Statement = '0' where AddID!='".$AddID."' and CustID='".$CustID."' ";
				$this->query($strSQLQuery, 0);	
			}	

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
				function UpdateCountryStateCity($arryDetails,$AddID,$DBName=''){   
					extract($arryDetails);		

$DB='';		
		if(!empty($DBName)) {
			$DB=$DBName.'.';
			
		}
					$strSQLQuery = "UPDATE ".$DB."s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddID = '".$AddID."'";
					$this->query($strSQLQuery, 0);
					return 1;
				}
					
					function UpdateBillingCountyStateCity($arryDetails,$Cid){   
						extract($arryDetails);		

						$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddType 	= 'billing' AND CustID = '".$Cid."'";
						$this->query($strSQLQuery, 0);
						return 1;
					}
	function UpdateBillingWithImport($arryDetails,$Cid){   
						extract($arryDetails);		

						$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddType 	= 'billing' AND AddID = '".$Cid."'";
						$this->query($strSQLQuery, 0);
						return 1;
					}

					function UpdateShippingCountyStateCity($arryDetails,$Cid){   
						extract($arryDetails);		

						$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddType 	= 'shipping' AND CustID= '".$Cid."'";
						$this->query($strSQLQuery, 0);
						return 1;
					}

function UpdateShippingWithImport($arryDetails,$Cid){   
						extract($arryDetails);		

						$strSQLQuery = "UPDATE s_address_book SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE AddType 	= 'shipping' AND AddID= '".$Cid."'";
						$this->query($strSQLQuery, 0);
						return 1;
					}
					
		function updateCustomerGeneralInfo($arryDetails)
		{
			 @extract($arryDetails);
			 global $Config;
			 $FullName = $FirstName." ".$LastName; 

			/* $SqlCustomer = "UPDATE s_customers SET CustomerType = '".$CustomerType."', Company = '".addslashes($Company)."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Gender = '".mysql_real_escape_string($Gender)."', Landline = '".mysql_real_escape_string($Landline)."', Website = '".mysql_real_escape_string(strip_tags($Website))."', Mobile = '".mysql_real_escape_string($Mobile)."', Email = '".mysql_real_escape_string(strip_tags($Email))."', UpdatedDate = '".$Config['TodayDate']."', Status='".$Status."',Currency='".$Currency."',CustomerSince='".$CustomerSince."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', Taxable='".mysql_real_escape_string($Taxable)."' WHERE Cid = '".$CustId."'";*/
			
			if(!empty($_POST['DefaultCustomer'])){
			    $strSQLQuery = "SELECT COUNT(*) DefCust FROM s_customers WHERE  DefaultCustomer=1  ";
       $arryDefCust = $this->query($strSQLQuery, 1);
       if($arryDefCust[0]['DefCust'] >0){
            $SqlCust = "update s_customers set DefaultCustomer=0 where DefaultCustomer=1";
             $this->query($SqlCust,0);
       }
   }

    //By Chetan 27July// 
    $unsetArray = array("CustId","tab","Submit","AddType","SalesPersonID","TotalOpenAmount");
     foreach($unsetArray as $arr){
        unset($arryDetails[$arr]);
     }

                        foreach($arryDetails as $key=>$values)
                        {
                           $str.= "$key='".$values."'".',';
                        }

                        $SqlCustomer = "update s_customers set ".trim($str, ',').",FullName = '".$FullName."',UpdatedDate = '".$Config['TodayDate']."',CreditLimitCurrency = '".$CreditLimitCurrency."' where Cid = '".$CustId."' ";

                        //End//

			 $this->query($SqlCustomer,0);


			/***********************/
			$objConfig=new admin();
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
	
			$strSQLQuery = "update company_user set  user_name='".addslashes($Email)."' where ref_id='".mysql_real_escape_string($CustId)."' and user_type='customer' and comId='".$_SESSION['CmpID']."' "; 
			$this->query($strSQLQuery, 0);		


			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************/



		   
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
                        $SqlCustomer = "SELECT c.*,IF(c.CustomerType = 'Company' and Company!='', Company, FullName) as CustomerName,concat(e.FirstName,' ',e.LastName) as sales_person from s_customers as c
						left join h_employee as e on FIND_IN_SET(e.EmpID, c.SalesID)  
						WHERE c.Cid = '".$custId."'"; 
						
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
		
		function UpdateSalesPerson($arryDetails){   
			global $Config;
			extract($arryDetails);
			//echo "<pre>";print_r($arryDetails);die;

			//$strSQLQuery = "UPDATE s_customers SET SalesID = '".$arryDetails['SalesPersonID']."',Department = '".$arryDetails['Department']."',SalesPerson = '".$arryDetails['SalesPerson']."',SalesPersonType = '".$arryDetails['SalesPersonType']."' WHERE Cid = '".$CustId."'";
			$strSQLQuery = "UPDATE s_customers SET SalesID = '".$arryDetails['SalesPersonID']."',Department = '".$arryDetails['Department']."',VendorSalesPerson = '".$arryDetails['vendorSalesPersonID']."' WHERE Cid = '".$CustId."'";
			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                function UpdateImage($Image,$CustID)
				{
					$strSQLQuery = "UPDATE s_customers SET Image='".$Image."' WHERE Cid = '".$CustID."'";
					return $this->query($strSQLQuery, 0);
				}
                
		function  GetShippingBilling($CustID,$AddType,$status=null,$order='')
		{
			$strSQLQuery = "select s.* from s_address_book s inner join s_customers c on s.CustID=c.Cid ";
			$strSQLQuery .= (!empty($CustID))?(" where s.CustID='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($AddType))?(" and s.AddType='".$AddType."'"):("");
			$strSQLQuery .= ($status!==null)?(" and s.Status='".$status."'"):("");
			$strSQLQuery .= !empty($order)?' order by '.$order:'';
			
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
			$objFunction=new functions();

			$strSQLQuery = "select Cid,Image FROM s_customers WHERE Cid= '".$CustID."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
 
			if($arryRow[0]['Image'] !=''){				
				$objFunction->DeleteFileStorage($Config['CustomerDir'],$arryRow[0]['Image']);
			}

			$strSQLQuery = "DELETE FROM s_customers WHERE Cid = '".$CustID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "DELETE FROM s_address_book WHERE CustID = '".$CustID."'"; 
			$this->query($strSQLQuery, 0);



			/***********************/
			$objConfig=new admin();
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();

			$strSQLQuery = "delete from company_user where ref_id='".mysql_real_escape_string($CustID)."' and user_type='customer' and comId='".$_SESSION['CmpID']."' "; 
			$this->query($strSQLQuery, 0);


			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************/



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
									#$mail->Send();	
								}
                                
                }
                
              
    
		function  GetCustomerAddressBook($CustID,$AddID)
		{
			if($AddID>0){
			 $strSQLQuery = "SELECT c.FullName as CustomerName, c.CustCode, c.Company as CustomerCompany,c.Taxable,ab.* FROM s_address_book ab inner join s_customers c on ab.CustID=c.Cid WHERE ab.AddID='".$AddID."' ";			
			return $this->query($strSQLQuery, 1);
			}
		}




function GetCustomerByKey($key)
			   {
			       /* $strSQLQuery = "SELECT c.FullName as CustomerName, c.CustCode, c.Company as CustomerCompany,c.PaymentTerm,c.PaymentMethod,c.ShippingMethod,c.Currency,c.Taxable
,ab.FullName as Name,ab.Company,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName, ab.Mobile,ab.Landline,ab.Fax, ab.Email 
,sp.FullName as sName,sp.Company  as sCompany ,sp.Address as sAddress, sp.ZipCode as sZipCode, sp.CountryName as sCountryName ,sp.StateName as sStateName, sp.CityName as sCityName, sp.Mobile as sMobile,sp.Landline as sLandline,sp.Fax as sFax, sp.Email  as sEmail,concat(e.FirstName,' ',e.LastName) as SalesPerson, c.SalesId as SalesPersonID FROM s_customers as c 
FROM s_customers as c 
LEFT OUTER JOIN h_employee as e on c.SalesID = e.UserID 
LEFT OUTER JOIN s_address_book as ab ON (c.Cid = ab.CustID and ab.AddType = 'billing') LEFT OUTER JOIN s_address_book as sp ON (c.Cid = sp.CustID and sp.AddType = 'shipping') WHERE c.CustCode='".$CustCode."'  ";
*/
$strAddQuery = (!empty($key))?(" and (c.FullName like '".$key."%' or c.Company like '".$key."%')"):("");
				$strSQLQuery = "SELECT IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName, c.CustomerType,c.CustCode, c.Company as CustomerCompany,c.PaymentTerm,c.PaymentMethod,c.ShippingMethod,c.MDType,c.DiscountType,c.MDAmount,c.MDiscount,c.Cid,
				c.Currency,c.DefaultAccount,c.Taxable ,ab.FullName as Name,ab.Company,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName, 
				ab.Mobile,ab.Landline,ab.Fax, ab.Email ,sp.FullName as sName,sp.Company as sCompany ,sp.Address as sAddress, 
				sp.ZipCode as sZipCode, sp.CountryName as sCountryName ,sp.StateName as sStateName, sp.CityName as sCityName, 
				sp.Mobile as sMobile,sp.Landline as sLandline,sp.Fax as sFax, sp.Email as sEmail, concat(e.FirstName,' ',e.LastName) as SalesPerson, c.SalesId as SalesPersonID FROM s_customers as c 
				LEFT OUTER JOIN h_employee as e on  FIND_IN_SET(e.EmpID, c.SalesID)
				LEFT OUTER JOIN s_address_book as ab ON (c.Cid = ab.CustID and ab.AddType = 'billing' )
				LEFT OUTER JOIN s_address_book as sp ON (c.Cid = sp.CustID and sp.AddType = 'shipping' )
				WHERE 1 ".$strAddQuery."";
				return $this->query($strSQLQuery, 1);
			   
			   }


	           function GetCustomerAllInformation($CustID,$CustCode,$Status)
			   {
				global $Config;
				
			       /* $strSQLQuery = "SELECT c.FullName as CustomerName, c.CustCode, c.Company as CustomerCompany,c.PaymentTerm,c.PaymentMethod,c.ShippingMethod,c.Currency,c.Taxable
,ab.FullName as Name,ab.Company,ab.Address, ab.ZipCode, ab.CountryName ,ab.StateName, ab.CityName, ab.Mobile,ab.Landline,ab.Fax, ab.Email 
,sp.FullName as sName,sp.Company  as sCompany ,sp.Address as sAddress, sp.ZipCode as sZipCode, sp.CountryName as sCountryName ,sp.StateName as sStateName, sp.CityName as sCityName, sp.Mobile as sMobile,sp.Landline as sLandline,sp.Fax as sFax, sp.Email  as sEmail,concat(e.FirstName,' ',e.LastName) as SalesPerson, c.SalesId as SalesPersonID FROM s_customers as c 
FROM s_customers as c 
LEFT OUTER JOIN h_employee as e on c.SalesID = e.UserID 
LEFT OUTER JOIN s_address_book as ab ON (c.Cid = ab.CustID and ab.AddType = 'billing') LEFT OUTER JOIN s_address_book as sp ON (c.Cid = sp.CustID and sp.AddType = 'shipping') WHERE c.CustCode='".$CustCode."'  ";
*/
//LEFT OUTER JOIN h_employee as e on FIND_IN_SET(e.EmpID, c.SalesID)
						$strSQLQuery = "SELECT IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName,c.c_taxRate, c.CustomerType,c.CustCode,c.Cid, c.Company as CustomerCompany,c.PaymentTerm,c.PaymentMethod,c.ShippingMethod,c.MDType,c.DiscountType,c.MDAmount,c.MDiscount,
				c.Currency,c.DefaultAccount,c.Taxable ,ab.FullName as Name,ab.Company,ab.Address, ab.ZipCode,ab.CountryName ,  ab.country_id , ab.StateName, ab.state_id , ab.CityName, ab.city_id , 
				ab.Mobile,ab.Landline,ab.Fax, ab.Email ,sp.FullName as sName,sp.Company as sCompany ,sp.Address as sAddress, 
				sp.ZipCode as sZipCode, sp.CountryName as sCountryName ,sp.country_id as sCountryid ,sp.StateName as sStateName, sp.state_id as sStateid, sp.CityName as sCityName, sp.city_id as sCityid, 
				sp.Mobile as sMobile,sp.Landline as sLandline,sp.Fax as sFax, sp.Email as sEmail,  c.SalesId as SalesPersonID ,c.SalesPerson as SalesPerson,c.SalesPersonType as SalesPersonType,c.EDICompId,c.EDICompName,c.VendorSalesPerson as VendorSalesPerson FROM s_customers as c 
				
				LEFT OUTER JOIN s_address_book as ab ON (c.Cid = ab.CustID and ab.AddType = 'billing' )
				LEFT OUTER JOIN s_address_book as sp ON (c.Cid = sp.CustID and sp.AddType = 'shipping' )
				WHERE c.CustCode='".$CustCode."'";

				if(!empty($Config["CustNameAlso"])) $strSQLQuery .= " or c.Company ='".$CustCode."' or c.FullName ='".$CustCode."'  ";

//echo $strSQLQuery;

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
	       # $strSQLQuery .= ($_SESSION['vAllRecord'] != 1) ? (" and (AssignTo = '" . $_SESSION['AdminID'] . "' OR created_id='" . $_SESSION['AdminID'] . "') ") : ("");

		$strSQLQuery .= ' order by Cid desc ';
		#echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);
	  }

	function NextPrevCustomer($Cid,$FullName,$Next) {
		global $Config;
		if(!empty($Cid)){
			$strAddQuery = ($_SESSION['vAllRecord']!=1)?(" and (c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."') "):(""); 
		
			if($Next==1){
				$operator = ">"; $asc = 'asc';
			}else{
				$operator = "<";  $asc = 'desc';
			}

			$strSQLQuery = "select c.Cid,IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName from s_customers c where c.Cid!='".$Cid."' ". $strAddQuery. " 
having CustomerName ".$operator." '" . addslashes($FullName) . "' order by CustomerName ".$asc." limit 0,1";

			$arrRow = $this->query($strSQLQuery, 1);
			if(!empty($arrRow[0]['Cid'])){
				return $arrRow[0]['Cid'];
			}
		}
	}
        
        
        function getCustomerAddressForPO($CustID){
            
             $SqlCustomer = "select * from s_address_book where AddType = 'contact' and PrimaryContact='1' and CustID='".$CustID."'";
		 
             return $this->query($SqlCustomer, 1);
            
        }

	
	 #new for email
		function addCustomerAddressViaEmail($arryDetails,$CustID)
		{
			global $Config;
			extract($arryDetails);		
			$sel="select Email from s_address_book where Email='".$Email."' and AdminID = '".$_SESSION['AdminID']."' ";
            $ddd=$this->query($sel, 1);
            if(empty($ddd[0]['Email']))
            {
				$FullName = $FirstName." ".$LastName;
				$IpAddress = GetIPAddress(); 
				$strSQLQuery = "INSERT INTO s_address_book set CustID = '".$CustID."', AddType='contact', CrmContact =1, FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Email='".mysql_real_escape_string($Email)."', NickName = '".mysql_real_escape_string(strip_tags($NickName))."', CreatedDate = '".$Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."', AdminID = '".$_SESSION['AdminID']."', AdminType = '".$_SESSION['AdminType']."', CreatedBy = '".addslashes($_SESSION['UserName'])."', Status=1";
				return	$this->query($strSQLQuery, 1);
            }else{
            	return "AlreadyExist";
            }
		}
		
		function editCustomerAddressViaEmail($arryDetails,$CustID)
		{
			global $Config;
			extract($arryDetails);		
			$sel="select AddID,Email from s_address_book where Email='".$Email."' and AdminID = '".$_SESSION['AdminID']."' ";
            $ddd=$this->query($sel, 1);
            if(empty($ddd[0]['Email']))
            { 
            	$this->addCustomerAddressViaEmail($arryDetails,$CustID);
            }else{
            	$FullName = $FirstName." ".$LastName;
				$strSQLQuery = "update s_address_book set CustID = '".$CustID."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', NickName = '".mysql_real_escape_string(strip_tags($NickName))."', UpdatedDate = '".$Config['TodayDate']."' where AddID='".$ddd[0]['AddID']."'";
				return	$this->query($strSQLQuery, 1);
            }
		}
		


	function GetContactId($Email){
		$sel="select * from s_address_book where Email='".$Email."' and AdminID = '".$_SESSION['AdminID']."' ";
		return $this->query($sel, 1);
	}

	function setRowColorCust($Cid,$RowColor) {
		if (!empty($Cid)) {
		    $sql = "update s_customers set RowColor='".$RowColor."' where Cid in ( " . $Cid . ")";
		    $rs = $this->query($sql, 0);
		}

		return true;
	}


	
 function Updatemarkup($arryDetails)
 {   
            global $Config;
//echo '<pre>'; print_r($arryDetails);
            extract($arryDetails);
        
       
        if($MDType=="Markup")
        {
            $amt=$Percentage;
        }
        else if($MDType=="Discount")
        {
            if($DiscountType=="Percentage")
            {
                 $amt=$PercentageDis;    
            }
            else if($DiscountType=="Fixed")
            {
                $amt=$MDAmount;
            }
        
        }
       else if($MDType=="None")
        {
        $amt=0;    
        }
            
       $strSQLQuery = "UPDATE s_customers SET MDType='".addslashes($MDType)."', MDAmount='".addslashes($amt)."', DiscountType='".addslashes($DiscountType)."',MDiscount='".addslashes($MDiscount)."'       WHERE Cid = '".$CustId."'"; 
       #echo $strSQLQuery;exit;
            $this->query($strSQLQuery, 0);
            return 1;
}


 //By chetan 8July for getting Name and Company Name Merge//
        function GetCustomerList()
        {
              $SqlCustomer = "SELECT Cid,CustCode,IF(CustomerType = 'Company' and Company!='', Company, FullName) as FullName FROM s_customers where Status = 'Yes' having FullName!='' order by FullName";
              return  $this->query($SqlCustomer);
        }
 function getCustomerList3333()
    {
        $strSQLQuery = "Select c.Cid as custID,IF(c.CustomerType = 'Company', Company, FullName) as CustomerName,c.CustomerType from  s_customers c where c.Status = 'Yes' having CustomerName!='' ORDER BY CustomerName ASC";

        return $this->query($strSQLQuery, 1);

    }
 
function AddContactByCustomer($arryDetails,$CustID,$AddType)
		{
			global $Config;
			extract($arryDetails);		
///
///
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			$FullName = $FirstName." ".$LastName;
			$IpAddress = GetIPAddress(); 
			if($Status=='') $Status=1;
			$strSQLQuery = "INSERT INTO s_address_book set CustID = '".$CustID."', AddType='".$AddType."', PrimaryContact = '".$PrimaryContact."', CrmContact = '".$CrmContact."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."', LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."', Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$Country."', Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."', PersonalEmail='".mysql_real_escape_string($PersonalEmail)."',  Landline='".mysql_real_escape_string($Landline)."', Fax='".mysql_real_escape_string($Fax)."' ,  OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', CreatedDate = '".$Config['TodayDate']."', UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."', AdminID = '".$_SESSION['AdminID']."', AdminType = '".$_SESSION['AdminType']."', CreatedBy = '".addslashes($_SESSION['UserName'])."',Title='".mysql_real_escape_string($Title)."',Department='".mysql_real_escape_string($Department)."',LeadSource='".mysql_real_escape_string($LeadSource)."',AssignTo='".addslashes($AssignTo)."',Reference='".mysql_real_escape_string($Reference)."', DoNotCall='".mysql_real_escape_string($DoNotCall)."', NotifyOwner='".mysql_real_escape_string($NotifyOwner)."', EmailOptOut='".mysql_real_escape_string($EmailOptOut)."', Description='".mysql_real_escape_string($Description)."' , Status='".mysql_real_escape_string($Status)."',CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  
			CityName='".addslashes($City)."',
			RigisterType = '".$RigisterType."',
			RigisterTypeID = '".$RigisterTypeID."',
			FacebookID = '".$FacebookID."',
			TwitterID = '".$TwitterID."',
                        LinkedinID = '".$LinkedinID."',
			InstagramID = '".$InstagramID."',
			GoogleID = '".$GoogleID."'";
$this->query($strSQLQuery, 0);

			$AddID = $this->lastInsertId();

			return $AddID;
 
}

	//By Chetan 18Aug//
        function AddContactByaddCustomer($arryDetails,$CustID,$AddType)
                        {
                                global $Config;
                                extract($arryDetails);	

                                if($main_city_id>0) $OtherCity = '';
                                if($main_state_id>0) $OtherState = '';
                                $FullName = $FirstName." ".$LastName;
                                $IpAddress = GetIPAddress(); 
                                if($Status=='') $Status=1;

                                $objField = new field();
                                $arryflds=$objField->getFormField('',16,1);
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
                                        $str.= "$key='".addslashes($arryDetails[$key])."'".',';
                                }
                                $strSQLQuery = "INSERT INTO s_address_book set ".$str."  CustID = '".$CustID."', AddType='".$AddType."', 
                                PrimaryContact = '".$PrimaryContact."', CrmContact = '".$CrmContact."', FirstName='".mysql_real_escape_string(strip_tags($FirstName))."',
                                LastName = '".mysql_real_escape_string(strip_tags($LastName))."', FullName = '".mysql_real_escape_string(strip_tags($FullName))."',
                                Company = '".mysql_real_escape_string($Company)."', Address='".mysql_real_escape_string($Address)."', city_id='".$main_city_id."',
                                state_id='".$main_state_id."', ZipCode='".mysql_real_escape_string($ZipCode)."', country_id='".$country_id."',
                                Mobile='".mysql_real_escape_string($Mobile)."', Email='".mysql_real_escape_string($Email)."',Landline='".mysql_real_escape_string($Landline)."',
                                OtherState='".mysql_real_escape_string($OtherState)."' ,OtherCity='".mysql_real_escape_string($OtherCity)."', CreatedDate = '".$Config['TodayDate']."',
                                UpdatedDate = '".$Config['TodayDate']."', IpAddress = '".$IpAddress."', AdminID = '".$_SESSION['AdminID']."', AdminType = '".$_SESSION['AdminType']."',
                                CreatedBy = '".addslashes($_SESSION['UserName'])."',CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',CityName='".addslashes($City)."' ";


                                $this->query($strSQLQuery, 0);

                                $AddID = $this->lastInsertId();

                                return $AddID;

        }
        

	 //Update by Chetan 11Dec//
        function addPopUpCustomerAddress($arryDetails,$AddType)
        {
            global $Config;
            extract($arryDetails);		

            if($main_city_id>0) $OtherCity = '';
            if($main_state_id>0) $OtherState = '';
            $FullName = $FirstName." ".$LastName;
            $IpAddress = GetIPAddress(); 


 /********* By Karishma for MultiStore 22 Dec 2015******/

            if($AddType=='shipping')  $Status=0;
	   else if($Status=='') $Status=1;
	  /*****End By Karishma for MultiStore 22 Dec 2015**********/
            //if($Status=='') $Status=1;
            
            unset($arryDetails['ajax_state_id']);
            unset($arryDetails['ajax_city_id']);
            unset($arryDetails['SubmitContact']);
            unset($arryDetails['CustomerID']);
            unset($arryDetails['AddressID']);
            unset($arryDetails['CurrentDivision']);
            unset($arryDetails['main_state_id']);
            unset($arryDetails['main_city_id']);
						unset($arryDetails['tab']);
            $fields = join(',',array_keys($arryDetails));
            foreach($arryDetails as $val)
             {
             	$values.= "'".addslashes($val)."'".',';//updated on 22Sept2017 by chetan//
             }

		$values =rtrim($values,',');
            
            $strSQLQuery = "insert into s_address_book 
                        (AddType,FullName,  CreatedDate,UpdatedDate,IpAddress,AdminID,
                        AdminType,CreatedBy,Status,$fields)
                        values('" . $AddType . "',
																	'".$FullName."',
                            	'" . $Config['TodayDate'] ."', 
                                '".  $Config['TodayDate']."',
                                 '".$IpAddress."',
                                '".$_SESSION['AdminID']."',
                                '".$_SESSION['AdminType']."' ,  
                                '".addslashes($_SESSION['UserName'])."',
																'".addslashes($Status)."',   
                                $values)" ;
		//echo  $strSQLQuery;exit;				
            $this->query($strSQLQuery, 0);
            $AddID = $this->lastInsertId();
            return $AddID;
            
        }
        //End//

	/****************************************/
	   function MergeCustomer($OldCustID, $NewCustID){  
		
		 if(!empty($OldCustID) && !empty($NewCustID)){
		    $arryOld = $this->GetCustomer($OldCustID,'','');
		    $arryNew = $this->GetCustomer($NewCustID,'','');
		    $OldCustCode = $arryOld[0]['CustCode'];
		    $NewCustCode = $arryNew[0]['CustCode'];
		   
		    $sqlAct = "update c_activity set CustID='".$NewCustID."' where CustID='".$OldCustID."'"; 
		    $this->query($sqlAct, 0);

		    /*$sqlCont = "update c_contact set CustID='".$NewCustID."' where CustID='".$OldCustID."'"; 
		    $this->query($sqlCont, 0); //Not Used Now*/

		    /*$sqlAdd = "update s_address_book set CustID='".$NewCustID."' where CustID='".$OldCustID."' and PrimaryContact=0"; 
		    $this->query($sqlAdd, 0);*/

		    $sqlDoc = "update c_document set CustID='".$NewCustID."' where CustID='".$OldCustID."'"; 
		    $this->query($sqlDoc, 0);

		    $sqlOpp = "update c_opportunity set CustID='".$NewCustID."' where CustID='".$OldCustID."'"; 
		    $this->query($sqlOpp, 0);

		    $sqlQuo = "update c_quotes set CustID='".$NewCustID."', CustCode='".$NewCustCode."', CustomerName='".$arryNew[0]['FullName']."', CustomerCompany='".$arryNew[0]['Company']."' where CustID='".$OldCustID."'"; 
		   $this->query($sqlQuo, 0);

		    $sqlTick = "update c_ticket set CustID='".$NewCustID."' where CustID='".$OldCustID."'";
		    $this->query($sqlTick, 0);

		     $sqlOrd = "update s_order set CustID='".$NewCustID."',CustCode='".$NewCustCode."', CustomerName='".$arryNew[0]['FullName']."', CustomerCompany='".$arryNew[0]['Company']."' where CustCode='".$OldCustCode."'";
		    $this->query($sqlOrd, 0);
		    $sqlPay = "update f_payments set CustID='".$NewCustID."', CustCode='".$NewCustCode."' where CustID='".$OldCustID."'";
		    $this->query($sqlPay, 0);

		    $sqlOrdp = "update p_order set CustCode='".$NewCustCode."' where CustCode='".$OldCustCode."'";
		    $this->query($sqlOrdp, 0);

		    $sqlInv = "update s_invoice_payment set CustID='".$NewCustID."', CustCode='".$NewCustCode."' where CustID='".$OldCustID."'";
		   $this->query($sqlInv, 0);	
	   
		    $sqlOrdRec = "update w_order_recieve set CustID='".$NewCustID."' where CustID='".$OldCustID."'";
		    $this->query($sqlOrdRec, 0);

		    $sqlCar = "update w_cargo set CustID='".$NewCustID."',CustCode='".$NewCustCode."' where CustID='".$OldCustID."'";
		    $this->query($sqlCar, 0);
		    		  

		    $sqlOrdRec = "update w_order_recieve set CustCode='".$NewCustCode."' where CustCode='".$OldCustCode."'";
		    $this->query($sqlOrdRec, 0);
		    
	     
		   // echo $sqlOrdp;exit;
	 
		    /***************************/
		    /***************************/
		    $sqlDC ="DELETE FROM `s_customers` where Cid='".$OldCustID."'";
		    $this->query($sqlDC, 0);
		    $sqlDA ="DELETE FROM `s_address_book` where CustID='".$OldCustID."'";
		    $this->query($sqlDA, 0);
		}
	
		return 1;
	    }




	/********** Credit Card *********/
	/*******************************/
	function addCard($arryDetails){
		global $Config;
		@extract($arryDetails);	
		if(!empty($CustID)){
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';

			$sql = "insert into s_customer_card set CustID='".addslashes($CustID)."', CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."'), CardType='".addslashes($CardType)."', CardHolderName='".addslashes($CardHolderName)."', ExpiryMonth='".addslashes($ExpiryMonth)."', ExpiryYear='".addslashes($ExpiryYear)."', DefaultCard='".addslashes($DefaultCard)."', Address='".addslashes($Address)."' , Comment='".addslashes($Comment)."', UpdatedDate = '".$Config['TodayDate']."', city_id = '".addslashes($main_city_id)."', country_id = '".addslashes($country_id)."', state_id = '".addslashes($main_state_id)."', ZipCode = '".addslashes($ZipCode)."', OtherState='".addslashes($OtherState)."', OtherCity='".addslashes($OtherCity)."', SecurityCode = '".addslashes($securityCode)."'  ";

			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
		}
		return $lastInsertId;

	}

	function UpdateCard($arryDetails){   
		global $Config;
		extract($arryDetails);
		if(!empty($CustID) && !empty($CardID)){
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';

			$strSQLQuery = "update s_customer_card set CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."'),CardType='".addslashes($CardType)."', CardHolderName='".addslashes($CardHolderName)."',  ExpiryMonth='".addslashes($ExpiryMonth)."', ExpiryYear='".addslashes($ExpiryYear)."' ,DefaultCard='".addslashes($DefaultCard)."', Address='".addslashes($Address)."'  , Comment='".addslashes($Comment)."', UpdatedDate = '".$Config['TodayDate']."', city_id = '".addslashes($main_city_id)."', country_id = '".addslashes($country_id)."', state_id = '".addslashes($main_state_id)."', ZipCode = '".addslashes($ZipCode)."', OtherState='".addslashes($OtherState)."', OtherCity='".addslashes($OtherCity)."', SecurityCode = '".addslashes($securityCode)."'  where CustID='".$CustID."' and CardID='".$CardID."'  "; 
			$this->query($strSQLQuery, 0);
		}

		return 1;
	}

	function UpdateCardOnSaleOld($arryDetails){
		global $Config;		 
	      extract($arryDetails);
	     if(!empty($CustID) && !empty($CardID)){
			
			/******Check if card has been modified************/
			$arryCard = $this->GetCard($CardID,$CustID,'');
			$ExpiryMonthOld = $arryCard[0]['ExpiryMonth'];
			$ExpiryYearOld = $arryCard[0]['ExpiryYear'];
			$securityCodeOld = $arryCard[0]['SecurityCode'];
			$CardHolderNameOld = $arryCard[0]['CardHolderName'];
			$AddressOld = $arryCard[0]['Address'];
			$CurrentMonthYear = date("Y-m-01");
			$YearMonth = $ExpiryYear."-".$ExpiryMonth."-01";

			$UpdateCardOnSaleFlag=0;
			if( $ExpiryMonthOld != $ExpiryMonth || $ExpiryYearOld != $ExpiryYear || $securityCodeOld != $securityCode || $CardHolderNameOld != $CardHolderName || $AddressOld != $Address ){
				$UpdateCardOnSaleFlag=1;
			}
			if($CurrentMonthYear>$YearMonth){ //expired
				$UpdateCardOnSaleFlag=0;
			}

			/******************/
			
			if($UpdateCardOnSaleFlag=="1"){

			   $strSQLQuery = "select o.InvoiceID, o.SaleID, o.InvoicePaid, o.OrderPaid, c.*,cs.CustCode from s_order_card c inner join s_order o on (c.OrderID = o.OrderID and c.OrderID>'0') inner join s_customers cs on (o.CustCode=cs.CustCode and o.CustCode!='') left outer join `s_order_transaction` t on o.OrderID=t.OrderID where o.PaymentTerm='Credit Card' and o.Module in('Quote','Order','Invoice')  and cs.Cid='".$CustID."' and  c.CardType='".$CardType."' and c.CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."') and o.Status not in('Cancelled', 'Rejected','Completed')  and o.InvoicePaid='Unpaid' and o.OrderPaid='0' and t.TransactionID is NULL  order by c.CardID asc";
			  $arryRow = $this->query($strSQLQuery, 1);
			 		
			  foreach ($arryRow as $key => $values) { 			 
				$orderArray[] = $values['OrderID'];	 
			  } 
			
			  if(!empty($orderArray[0])){
				$OrderIDS = "'".implode("','",$orderArray)."'";
				/***************/
				if($main_state_id>0) $OtherState = '';
				if($main_city_id>0) $OtherCity = '';
				$objRegion=new region();
				$arryCountry = $objRegion->GetCountryCode($country_id);
				$Country= stripslashes($arryCountry[0]["code"]);
				$State=$City='';
				if(!empty($main_state_id)) {
					$arryState = $objRegion->getStateName($main_state_id);
					$State = stripslashes($arryState[0]["name"]);
				}else if(!empty($OtherState)){
					 $State = $OtherState;
				}

				if(!empty($main_city_id)) {
					$arryCity = $objRegion->getCityName($main_city_id);
					$City= stripslashes($arryCity[0]["name"]);
				}else if(!empty($OtherCity)){
					 $City = $OtherCity;
				}
				/***************/
				$strSQLQue = "update s_order_card set CardHolderName='".addslashes($CardHolderName)."',  ExpiryMonth='".addslashes($ExpiryMonth)."', ExpiryYear='".addslashes($ExpiryYear)."', SecurityCode = '".addslashes($securityCode)."', Address='".addslashes($Address)."', Country='".addslashes($Country)."', State='".addslashes($State)."', City='".addslashes($City)."', ZipCode = '".addslashes($ZipCode)."'   WHERE OrderID in (".$OrderIDS.") " ;	
				 	 
				$this->query($strSQLQue, 0);
			}

		     }
	    }	
		 
	 return 1;

	}


	function UpdateCardOnSale($arryDetails){
		global $Config;		 
	      extract($arryDetails);
	     if(!empty($CustID) && !empty($CardID)){
			
			/******Check if card has been modified************/
			$arryCard = $this->GetCard($CardID,$CustID,'');
			$ExpiryMonthOld = $arryCard[0]['ExpiryMonth'];
			$ExpiryYearOld = $arryCard[0]['ExpiryYear'];
			$securityCodeOld = $arryCard[0]['SecurityCode'];
			$CardHolderNameOld = $arryCard[0]['CardHolderName'];
			$AddressOld = $arryCard[0]['Address'];
			$CurrentMonthYear = date("Y-m-01");
			$YearMonth = $ExpiryYear."-".$ExpiryMonth."-01";

			$UpdateCardOnSaleFlag=0;
			if( $ExpiryMonthOld != $ExpiryMonth || $ExpiryYearOld != $ExpiryYear || $securityCodeOld != $securityCode || $CardHolderNameOld != $CardHolderName || $AddressOld != $Address ){
				$UpdateCardOnSaleFlag=1;
			}
			if($CurrentMonthYear>$YearMonth){ //expired
				$UpdateCardOnSaleFlag=0;
			}

			/******************/
			
			if($UpdateCardOnSaleFlag=="1"){

			   $strSQLQuery = "select distinct(o.OrderID) as OrderID , o.Parent, o.InvoiceID, o.SaleID, o.InvoicePaid, o.OrderPaid, c.*,cs.CustCode, so.EntryType from s_order_card c inner join s_order o on (c.OrderID = o.OrderID and c.OrderID>'0') inner join s_customers cs on (o.CustCode=cs.CustCode and o.CustCode!='') left outer join `s_order_item` so on o.OrderID=so.OrderID left outer join `s_order_transaction` t on o.OrderID=t.OrderID where o.PaymentTerm='Credit Card' and o.Module in('Quote','Order','Invoice')  and cs.Cid='".$CustID."' and  c.CardType='".$CardType."' and c.CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."') and o.Status not in('Cancelled', 'Rejected','Completed')  and ((o.InvoicePaid='Unpaid' and o.OrderPaid='0' and t.TransactionID is NULL) OR (o.Module='Invoice' and o.OrderPaid>'0' and o.InvoiceEntry in ('0','1') and so.id>'0' and so.sku!='' and so.EntryType='recurring' )) order by c.CardID asc";
			  $arryRow = $this->query($strSQLQuery, 1);
			 		
			  foreach ($arryRow as $key => $values) { 
				if($values['EntryType']=="recurring" && $values['OrderPaid']>0){
					$recurringOrderArray[] = $values['OrderID'];
				}else{		 
					$orderArray[] = $values['OrderID'];
				}	 
			  } 
 
			  if(!empty($orderArray[0]) || !empty($recurringOrderArray[0])){
				
				/***************/
				if($main_state_id>0) $OtherState = '';
				if($main_city_id>0) $OtherCity = '';
				$objRegion=new region();
				$arryCountry = $objRegion->GetCountryCode($country_id);
				$Country= stripslashes($arryCountry[0]["code"]);
				$State=$City='';
				if(!empty($main_state_id)) {
					$arryState = $objRegion->getStateName($main_state_id);
					$State = stripslashes($arryState[0]["name"]);
				}else if(!empty($OtherState)){
					 $State = $OtherState;
				}

				if(!empty($main_city_id)) {
					$arryCity = $objRegion->getCityName($main_city_id);
					$City= stripslashes($arryCity[0]["name"]);
				}else if(!empty($OtherCity)){
					 $City = $OtherCity;
				}
				/***************/
				 
				if(!empty($orderArray[0])){
					$OrderIDS = "'".implode("','",$orderArray)."'";
					$strSQLQue = "update s_order_card set CardHolderName='".addslashes($CardHolderName)."',  ExpiryMonth='".addslashes($ExpiryMonth)."', ExpiryYear='".addslashes($ExpiryYear)."', SecurityCode = '".addslashes($securityCode)."', Address='".addslashes($Address)."', Country='".addslashes($Country)."', State='".addslashes($State)."', City='".addslashes($City)."', ZipCode = '".addslashes($ZipCode)."'   WHERE OrderID in (".$OrderIDS.") " ;	
				 	$this->query($strSQLQue, 0);
				}
				if(!empty($recurringOrderArray[0])){
					$OrderIDSRec = "'".implode("','",$recurringOrderArray)."'";

					$CardInfo =	array(
					'CardHolderName'=>$CardHolderName,
					'ExpiryMonth'=>$ExpiryMonth,
					'ExpiryYear'=>$ExpiryYear,
					'SecurityCode'=>$securityCode,
					'Address'=>$Address,
					'Country'=>$Country,
					'State'=>$State,
					'City'=>$City,
					'ZipCode'=>$ZipCode
					);

					$RecurringCardInfo= json_encode($CardInfo);
					$strSQLQue2 = "update s_order_card set RecurringCardInfo = '".addslashes($RecurringCardInfo)."'   WHERE OrderID in (".$OrderIDSRec.") " ;	 
					$this->query($strSQLQue2, 0);	
				}	

				//echo $strSQLQue.'<br><br>'.$strSQLQue2; die;

			}

		     }
	    }	
		 
	 return 1;

	}

	function UnDefaultCard($CardID, $CustID){   
		global $Config;
		extract($arryDetails);
		if(!empty($CustID) && !empty($CardID)){
			$strSQLQuery = "update s_customer_card set DefaultCard='0' where CardID!='".$CardID."'  "; 
			$this->query($strSQLQuery, 0);
		}

		return 1;
	}
	function RemoveCard($CardID,$CustID){
		if(!empty($CustID) && !empty($CardID)){
			$strSQLQuery = "Delete FROM s_customer_card WHERE CardID = '".$CardID."' and CustID = '".$CustID."'"; 
			$this->query($strSQLQuery, 0);
			return 1;
		}

	}
	function GetCard($CardID,$CustID,$DefaultCard){
		global $Config;
		$strSQLQuery = "select b.*, DECODE(b.CardNumber,'". $Config['EncryptKey']."') as CardNumber from s_customer_card b where CustID= '".$CustID."' ";
		$strSQLQuery .= (!empty($CardID))?(" and b.CardID='".$CardID."'"):("");
		$strSQLQuery .= (!empty($DefaultCard))?(" and b.DefaultCard='".$DefaultCard."'"):("");
		$strSQLQuery .= ' order by CardNumber asc';
		 
		return $this->query($strSQLQuery, 1);
	}

	function isCustCardExist($CardNumber,$CustID,$CardID=0){
		global $Config;
		$strSQLQuery = (!empty($CardID))?(" and CardID != '".$CardID."'"):("");
		$strSQLQuery = "SELECT CardID FROM s_customer_card WHERE DECODE(CardNumber,'". $Config['EncryptKey']."')='".strtolower(trim($CardNumber))."' and CustID = '".$CustID."' ".$strSQLQuery;

		
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['CardID'])) {
			return true;
		} else {
			return false;
		}
	}
	function GetCardIDExist($CardNumber,$CustID){
		global $Config;
		
		$strSQLQuery = "SELECT CardID FROM s_customer_card WHERE DECODE(CardNumber,'". $Config['EncryptKey']."')='".strtolower(trim($CardNumber))."' and CustID = '".$CustID."' ";

		
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['CardID'])) {
			return $arryRow[0]['CardID'];
		} else {
			return false;
		}
	}
	/**********************************/

	//By Chetan 4Dec//
        function convertTocustomerOpp($ID)
        {
            global $Config;
            $objLead=new lead();
            $OppRes = $objLead->GetOpportunity($ID);
            if($OppRes[0]['LeadID'])
            {
                $LeadRes = $objLead->GetLead($OppRes[0]['LeadID']);
            }
           
            //$FullName = $LeadRes[0]['FirstName'].' '.$LeadRes[0]['LastName'];
            $company = ($OppRes[0]['OrgName'])?  $OppRes[0]['OrgName'] : $LeadRes[0]['company'];
            $ipaddress = GetIPAddress();
            $OppName = explode(" ",$OppRes[0]['OpportunityName'],2);
              
            $arry['FirstName'] = $OppName[0];
            $arry['LastName'] = $OppName[1];
            $arry['Email'] = $LeadRes[0]['primary_email'];
            $arry['Company'] = $company;
            $arry['Mobile'] = $LeadRes[0]['Mobile'];
            $arry['Landline'] = $LeadRes[0]['LandlineNumber'];
            $arry['CustomerType'] = $LeadRes[0]['type'];
            $arry['FullName'] = $OppRes[0]['OpportunityName'];
            $arry['CreatedDate'] = $Config['TodayDate'];
            $arry['AdminID'] = $_SESSION['AdminID'];
            $arry['AdminType'] = $_SESSION['AdminType'];
            $arry['CustomerType'] = $LeadRes[0]['type'];
            $arry['ipaddress'] = $IpAddress;
            $arry['Website'] = $LeadRes[0]['Website'];
            $arry['Status'] = 'Yes';
            
            $customerId =  $this->addCustomer($arry);

            if(empty($CustCode)){
                    $CustCode = 'CUST000'.$customerId;
                    $strSQL = "UPDATE s_customers SET CustCode = '".mysql_real_escape_string($CustCode)."' WHERE Cid = '".mysql_real_escape_string($customerId)."'"; 
                    $this->query($strSQL, 0);
            }
            
             $arryShipping['FirstName'] = $arry['FirstName'];
            $arryShipping['LastName'] = $arry['LastName'];
            $arryShipping['Company'] = $arry['Company'];
            $arryShipping['Mobile'] = $LeadRes[0]['Mobile'];
            $arryShipping['Landline'] = $LeadRes[0]['LandlineNumber'];
            $arryShipping['Address'] = $arryQuoteAddress[0]['ship_street']; 
            $arryShipping['CityName'] = $LeadRes[0]['CityName']; 
            $arryShipping['StateName'] = $LeadRes[0]['StateName']; 
            $arryShipping['ZipCode'] = $LeadRes[0]['ZipCode']; 
            $arryShipping['CountryName'] = $LeadRes[0]['Country']; 
            $arryShipping['city_id'] = $LeadRes[0]['city_id'];
            $arryShipping['state_id'] = $LeadRes[0]['state_id'];
            $arryShipping['country_id'] = $LeadRes[0]['country_id'];
            $arryShipping['CustID']  = $customerId;
            
            $arryBilling['FirstName'] = $arry['FirstName'];
            $arryBilling['LastName'] = $arry['LastName'];
            $arryBilling['Company'] = $arry['Company'];
            $arryBilling['Mobile'] = $LeadRes[0]['Mobile'];
            $arryBilling['Landline'] = $LeadRes[0]['LandlineNumber'];
            $arryBilling['Address'] = $LeadRes[0]['Address']; 
            $arryBilling['CityName'] = $LeadRes[0]['CityName']; 
            $arryBilling['StateName'] = $LeadRes[0]['StateName']; 
            $arryBilling['ZipCode'] = $LeadRes[0]['ZipCode']; 
            $arryBilling['CountryName'] = $LeadRes[0]['Country']; 
            $arryBilling['city_id'] = $LeadRes[0]['city_id'];
            $arryBilling['state_id'] = $LeadRes[0]['state_id'];
            $arryBilling['country_id'] = $LeadRes[0]['country_id'];
            $arryBilling['CustID']  = $customerId;
            
            $billingID = $this->addCustomerAddressbyType($arryBilling,$customerId,'billing');
            $shippingID = $this->addCustomerAddressbyType($arryShipping,$customerId,'shipping');
            
            $arryShipping = array_merge($arryShipping,array('PrimaryContact' => '1'));
            $contactID = $this->addCustomerAddressbyType($arryShipping,$customerId,'contact');
            
            $sql = "update c_opportunity set convertToCus='1' where OpportunityID = " . $ID . "";
            $rs = $this->query($sql, 0);
            
            $sqlquery = "update c_comments set parentID='" . $customerId . "',parent_type='Customer' where parentID='".$ID."' and parent_type='Opportunity'";
            $this->query($sqlquery, 0);
            return 1;
        }
        
        
        function addCustomerAddressbyType($arr,$ID,$Type)
        {   
            global $Config;
            foreach($arr as $key=>$value)
            {       
                    $str.= "$key='".$value."'".',';
            }
            $ipaddress = GetIPAddress(); 
            $sql = "insert into s_address_book set ".$str." CreatedDate='" . $Config['TodayDate'] ."', 
		IpAddress='".$ipaddress."', AdminID='".$_SESSION['AdminID']."', AdminType ='".$_SESSION['AdminType']."', AddType ='".$Type."' " ;
           
            $this->query($sql,0);
        }
        
        //End//

/*add by suneel 7 Dec*/
		function  GetCustomerforVenderList($CustID,$CustCode,$Status)
		{
			global $Config;


			$strSQLQuery = "SELECT c.*,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName,ab.Address, ab.ZipCode, ab.country_id ,ab.state_id, ab.city_id,concat(e.FirstName,' ',e.LastName) as sales_person,ab.OtherState,ab.OtherCity,ab.Fax FROM s_customers c left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'billing') left outer join h_employee e on FIND_IN_SET(e.EmpID, c.SalesID)  ";
			// and ab.PrimaryContact='1'
			
			$strSQLQuery .= (!empty($CustID))?(" WHERE c.Cid='".$CustID."'"):(" where 1");
			$strSQLQuery .= (!empty($CustCode))?(" and c.CustCode='".$CustCode."'"):("");
			$strSQLQuery .= ($Status!='')?(" AND c.Status='".$Status."'"):("");

			
			 $strSQLQuery .= ' order by CustomerName asc ';
			return $this->query($strSQLQuery, 1);

		}
		/*end here*/

// added by karishma || 18 nov 2015
	function  GetCustomerShippingContact($CustID,$ShipId='')
	{
		$AddType='shipping';		
		 
		$strAddQuery = " and ( ab.Status='1' or ab.Status='0')";
		$strAddQuery .= (!empty($ShipId))?(" and ab.AddID='".$ShipId."'"):("");	 

		$strSQLQuery = "SELECT ab.* FROM s_address_book ab WHERE ab.CustID='".$CustID."' AND ab.AddType = '".$AddType."' ".$strAddQuery." order by Status Desc";
		return $this->query($strSQLQuery, 1);
	}

	function isCustomerTransactionExist($CustCode){		
		$OrdSql = "select CustCode from s_order where CustCode = '".$CustCode."' limit 0,1";
		$PaySql = "select CustCode from f_payments where CustCode = '".$CustCode."' limit 0,1";
				
	 	$strSQLQuery = "(".$OrdSql.") UNION (".$PaySql.") ";
		 $arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['CustCode'])) {
			return true;
		}else{
			return false;
		}
	}

	function isCardTransactionExist($CardID){		
		$strSQLQuery = "select CardID from s_order_card where CardID = '".$CardID."' limit 0,1"; 
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['CardID'])) {
			return true;
		}else{
			return false;
		}
	}

//Import Excel functions by chetan 23 sep 2016//

	function MoveRecordToMasterTable(){
		$sql = "update s_customers set PID = '0', Status = 'Yes' where AdminID = '".$_SESSION['AdminID']."'  and AdminType = '".$_SESSION['AdminType']."' and PID = '1'";
		$this->query($sql);
    	}  
    
	function DropDataOFImport(){
		 $sql = "DELETE FROM s_customers, s_address_book USING s_customers INNER JOIN s_address_book ON s_customers.Cid = s_address_book.CustID WHERE s_customers.AdminID = '".$_SESSION['AdminID']."' and s_customers.AdminType = '".$_SESSION['AdminType']."' and s_customers.PID = '1' and s_customers.Status = 'No' ";
		$this->query($sql);
  	}
	
	function CountForImport(){
	    	$sql = "SELECT count(*) count from s_customers where AdminID = '".$_SESSION['AdminID']."' and AdminType = '".$_SESSION['AdminType']."' and PID = '1' and Status = 'No'";
	    	$count = $this->query($sql,1);
	    	return $c = ($count[0]['count']>0)?$count[0]['count']:0; 
   	}	
	
	//End//	

		function  GetContactAddressByEmail($Email, $AddID, $Status)
   	{
   		$strSQLQuery = "select * from s_address_book where Email='".$Email."' and AddID='".$AddID."' and Status='".$Status."' "; 
   		return $this->query($strSQLQuery, 1);
   	}

	/******************************/
	/******************************/

	function GetCustomerBySalesPerson($arryDetails){
		global $Config;
		extract($arryDetails);
		$strAddQuery = "";	
		$strAddQuery .= (!empty($sp))?(" and o.SalesPersonID='".$sp."'"):("");
			
	
	
		if($Config['GetNumRecords']==1){
			$Columns = " count(distinct(c.Cid)) as NumCount ";				
		}else{	
			$strAddQuery .= " group by c.Cid ";
			$strAddQuery .= " order by Customer asc ";			
			$Columns = "  c.Cid as CustID, c.CustCode, c.CreditLimit, c.VAT, c.CreditLimitCurrency, c.Currency as CustCurrency, c.CreditAmount, c.Landline,  ab.FullName as ContactPerson,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as Customer, o.SalesPersonID, e.UserName as SalesPerson  ";
		 

			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}			
		}
		$strSQLQuery = "select ".$Columns." from s_order o  inner join h_employee e on o.SalesPersonID = e.EmpID inner join  s_customers c on  o.CustCode =  c.CustCode  left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') where o.Module in ('Order', 'Invoice', 'Credit') and o.SalesPersonID!='' and e.UserName!='' and (c.Company!='' OR c.FullName!='' )  ".$strAddQuery;

		return $this->query($strSQLQuery, 1);		
	}


	function GetCustomerByTax($arryDetails){
		global $Config;
		extract($arryDetails);
		$strAddQuery = "";	
	
		if(!empty($Tax)){
			$arrTx = explode(":",$Tax);
			$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
			$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
		}	
		
		if($Config['GetNumRecords']==1){
			$Columns = " count(distinct(c.Cid)) as NumCount ";				
		}else{	
			$strAddQuery .= " group by c.Cid ";
			$strAddQuery .= " order by Customer asc ";			
			$Columns = "  o.InvoiceID, o.SaleID, c.Cid as CustID, c.CustCode, c.CreditLimit, c.VAT, c.CreditLimitCurrency, c.Currency as CustCurrency, c.CreditAmount, c.Landline,  ab.FullName as ContactPerson,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as Customer, o.SalesPersonID, e.UserName as SalesPerson  ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}			
		}
		 $strSQLQuery = "select ".$Columns." from s_customers c inner join  s_order o on  o.CustCode =  c.CustCode left outer join h_employee e on  o.SalesPersonID = e.EmpID left outer join s_address_book ab ON (c.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') where o.Module in ('Order', 'Invoice', 'Credit') and (c.Company!='' OR c.FullName!='' ) and o.TaxRate!='' ".$strAddQuery;

		return $this->query($strSQLQuery, 1);		
	}


	function  CustomerTaxByProduct($arryDetails){ 
		global $Config;		
		extract($arryDetails);		 

		$strAddQuery = "";
		if(!empty($Tax)){
			$arrTx = explode(":",$Tax);
			$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
			$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
		}

		if($fby=='Year'){ 
			#$strAddQuery .= " and YEAR(o.InvoiceDate)='".$y."'";
			
			 $strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE  ( YEAR(o.InvoiceDate)='".$y."') END ";
		}else if($fby=='Month'){
			#$strAddQuery .= " and MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."'";

			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE  (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";

		}else{
			#$strAddQuery .= (!empty($f))?(" and o.InvoiceDate>='".$f."'"):("");
			#$strAddQuery .= (!empty($t))?(" and o.InvoiceDate<='".$t."'"):("");
			
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE  (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";
			

		}
		 

		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");

		if($Config['GetNumRecords']==1){
			$Columns = " count(so.id) as NumCount ";				
		}else{				 
			//$strAddQuery .= " order by so.sku asc ";			

			$strAddQuery .= " order by CustomerName asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END ,o.OrderID Asc, so.sku asc   ";

			$Columns = " so.id, so.sku, so.description, so.amount, o.taxAmnt, o.TaxRate, o.InvoiceID, o.CreditID, o.Module, o.OrderID, o.PostedDate, o.InvoiceDate, c.Cid as CustID, c.CustCode, c.VAT, c.Landline  ,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName, o.CustomerCurrency, o.ConversionRate ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}			
		}
		 $strSQLQuery = "select ".$Columns." from s_order_item so inner join s_order o on so.OrderID=o.OrderID inner join s_customers c on  o.CustCode =  c.CustCode  where o.Module in ('Invoice', 'Credit') and (c.Company!='' OR c.FullName!='' ) and o.TaxRate>'0' and o.taxAmnt>'0' and so.sku!='' and so.Taxable='Yes' ".$strAddQuery;

 
	
		return $this->query($strSQLQuery, 1);		
	}


	function  GetSalesProductByCategory($arryDetails){ 
		global $Config;		
		extract($arryDetails);		 
 
		$strAddQuery = "";
		if(!empty($Tax)){
			$arrTx = explode(":",$Tax);
			$TaxVale = trim($arrTx[0]).':'.trim($arrTx[1]);
			$strAddQuery .= " and o.TaxRate like '%".trim($TaxVale)."%' ";
		}

		if($fby=='Year'){ 
			#$strAddQuery .= " and YEAR(o.InvoiceDate)='".$y."'";
			
			 $strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE  ( YEAR(o.InvoiceDate)='".$y."') END ";
		}else if($fby=='Month'){
			#$strAddQuery .= " and MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."'";

			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE  (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";

		}else{
			#$strAddQuery .= (!empty($f))?(" and o.InvoiceDate>='".$f."'"):("");
			#$strAddQuery .= (!empty($t))?(" and o.InvoiceDate<='".$t."'"):("");
			
			$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE  (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";
			

		}
		 
		if(!empty($CategoryID)){			
			$strAddQuery .= " and i.CategoryID in (".$CategoryID.") ";
		}

		if($Config['ConversionType']==1){
			$ConvertedAmount =  "so.amount/o.ConversionRate" ;
		}else{
			$ConvertedAmount = "so.amount*o.ConversionRate";
		}

		 
		
	
		$strAddQuery .= " group by i.CategoryID order by c.Name asc ";

		$Columns = " i.CategoryID , SUM(IF(o.Module = 'Credit', -$ConvertedAmount, $ConvertedAmount)) as LineAmount , SUM(IF(o.Module = 'Credit', -so.qty, so.qty_invoiced)) as Qty ";
			
		
		  $strSQLQuery = "select ".$Columns." from s_order_item so inner join s_order o on so.OrderID=o.OrderID inner join inv_items i on (so.sku = i.Sku and i.Sku!='') left outer join inv_categories c on (i.CategoryID=c.CategoryID and i.CategoryID>0) where o.Module in ('Invoice','Credit') and so.sku!='' ".$strAddQuery;

 		 
	
		return $this->query($strSQLQuery, 1);		
	}

	/****************Abbas*************/		

	function GetSalesByCustomer($arryDetails){  
		global $Config; 
		extract($arryDetails); 

		$strAddQuery = "";

		if($fby=='Year'){ 

		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE ( YEAR(o.InvoiceDate)='".$y."') END ";
		}else if($fby=='Month'){
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";
		}else{ 
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";

		}

		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");

		if($Config['ConversionType']==1){
		$ConvertedAmount = "o.TotalAmount/o.ConversionRate" ;
		}else{
		$ConvertedAmount = "o.TotalAmount*o.ConversionRate";
		}

		
		if($Config['GetNumRecords']==1){
			$Columns = " count(distinct(o.CustCode)) as NumCount ";				
		}else{	
			$strAddQuery .= " group by o.CustCode  order by CustomerName asc ";
			$Columns = " c.Cid as CustID,o.Module, c.CustCode, IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName , SUM(IF(o.Module = 'Credit', -$ConvertedAmount, $ConvertedAmount)) as SalesAmount ";

			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}			
		}

		$strSQLQuery = "select ".$Columns." from s_order o inner join s_customers c on  o.CustCode =  c.CustCode where o.OverPaid='0' and o.Module in ('Invoice','Credit') and PostToGL='1' ".$strAddQuery;

		 

		return $this->query($strSQLQuery, 1); 
	}

	function GetSalesDataByCustomer($arryDetails){  
		global $Config; 
		extract($arryDetails); 

		$strAddQuery = "";

		if($fby=='Year'){ 

		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE ( YEAR(o.InvoiceDate)='".$y."') END ";
		}else if($fby=='Month'){
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";
		}else{ 
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";

		}

		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");

		if($Config['ConversionType']==1){
		$ConvertedAmount = "o.TotalAmount/o.ConversionRate" ;
		}else{
		$ConvertedAmount = "o.TotalAmount*o.ConversionRate";
		}

		$strAddQuery .= " order by CustomerName asc, CASE WHEN o.Module = 'Credit' THEN o.PostedDate ELSE o.InvoiceDate END Desc  ,o.OrderID Desc ";
		if($Config['GetNumRecords']==1){
			$Columns = " count(o.OrderID) as NumCount ";				
		}else{	
		$Columns = " o.OrderID, o.Module, o.InvoiceID, o.SaleID,  o.CustomerPO ,o.CreditID, o.TotalAmount, o.TotalInvoiceAmount, o.CustomerCurrency, o.InvoiceDate, o.PostedDate, o.PaymentTerm, o.OrderSource, o.OverPaid, o.InvoiceEntry, IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName , IF(o.Module = 'Credit', -$ConvertedAmount, $ConvertedAmount) as SalesAmount ";

			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}			
		}

		$strSQLQuery = "select ".$Columns." from s_order o inner join s_customers c on  o.CustCode =  c.CustCode where o.OverPaid='0' and o.Module in ('Invoice','Credit') and PostToGL='1' ".$strAddQuery;

		 

		return $this->query($strSQLQuery, 1); 
	}
	/***************End***************/
	
	//Added By chetan 8Aug2017//
	function deleteCustomer($Cid) {
		if (!empty($Cid)) {
		   $countCust = count($Cid);		
		   for($c=0;$c<$countCust;$c++)	
		   {
			$this->RemoveCustomer($Cid[$c]);
		   }
		}

		return true;
	}
	//End//



/***********************Customer Shipping Acount***************************/
function AddCustShipAcount($arryDetails){
		
		extract($arryDetails);
		
		if($defaultVal==1){
			$strSQLQueryUpdate = "update s_customer_shipping SET defaultVal = '0' where api_name='".addslashes($api_name)."' and CustID = '".addslashes($CustID)."' ";

   			$this->query($strSQLQueryUpdate, 0);

		}
   		  $strSQLQuery = "INSERT INTO s_customer_shipping SET api_key = '".addslashes($api_key)."',api_password = '".addslashes($api_password)."',api_account_number = '".addslashes($api_account_number)."',api_meter_number = '".addslashes($api_meter_number)."',api_name = '".addslashes($api_name)."',SourceZipcode = '".addslashes($SourceZipcode)."',defaultVal = '".addslashes($defaultVal)."',fixed = '".addslashes($fixed)."',live = '".addslashes($live)."',CustID = '".addslashes($CustID)."'";

   		$this->query($strSQLQuery, 0);
	   		
   	}
   	


function ListCustShipAccount($Type,$CustID,$default=''){
		if(!empty($Type) && !empty($CustID)){
			 $def = ($default) ? " and defaultVal = '".$default."' " : "";
			 $strSqlQuery="SELECT * FROM s_customer_shipping  WHERE LOWER(api_name)='".strtolower($Type)."' and CustID= '".$CustID."'  $def  ORDER BY defaultVal='1' DESC";
				 
				$results = $this->query($strSqlQuery,1);
				return $results;
		}
		
			
	}


	function GetCustShipAcountById($ID){
		if(!empty($ID)){
			$strSQLQuery = "select * from s_customer_shipping where ID='".$ID."'";
			$results= $this->query($strSQLQuery, 1);
			return $results;
		}
		
		
	}

	
	function UpdateCustShipAcount($arryDetails,$ID){    //pr($arryDetails);die;
		
		extract($arryDetails);
		if(!empty($defaultVal)){	 
			 $strSQLQueryUpdate = "update s_customer_shipping SET defaultVal = '0' where api_name='".addslashes($api_name)."' and CustID = '".addslashes($CustID)."' ";
   			$this->query($strSQLQueryUpdate, 0);
		}
		
   		 $strSQLQuery = "update s_customer_shipping SET api_key = '".addslashes($api_key)."',api_password = '".addslashes($api_password)."',api_account_number = '".addslashes($api_account_number)."',api_meter_number = '".addslashes($api_meter_number)."' , SourceZipcode = '".addslashes($SourceZipcode)."',defaultVal = '".addslashes($defaultVal)."',fixed = '".addslashes($fixed)."' where ID='".$ID."'";

   		$this->query($strSQLQuery, 0);
	   		
   	}


function isCustShippingAccountExists($AcNumber,$CustID,$editID){
	$str ='';
	if(!empty($editID)){
		$str = "and ID not in ('".$editID."')";
	}
		if(!empty($AcNumber) && !empty($CustID)){
			$strSQLQuery = "select id,api_account_number from  s_customer_shipping where api_account_number='".addslashes($AcNumber)."' and CustID='".addslashes($CustID)."' $str";

			//echo $strSQLQuery; die;
 			$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['api_account_number'])) {
					return true;
				} else {
					return false;
			}
	   		
   	}
}


 	
  function DeleteCustShipAccount($ID){
  	
  	if(!empty($ID)){
  		$strSQLQuery = "delete from s_customer_shipping where ID='".$ID."'";
		$this->query($strSQLQuery, 0);
		return 1;
  	 }

  }



	function SaveCustShipAcount($CustID,$api_name,$api_account_number){		
 
		if(!empty($api_account_number) && !empty($CustID) && !empty($api_name)){
			$strSQL = "select id from  s_customer_shipping where api_account_number='".addslashes($api_account_number)."' and CustID='".addslashes($CustID)."' and LCASE(api_name)='".strtolower(trim($api_name))."'  ";
	 		$arryRow = $this->query($strSQL, 1);

			 
			if(empty($arryRow[0]["id"])){
			 $strSQLQuery = "INSERT INTO s_customer_shipping SET api_account_number = '".addslashes($api_account_number)."', api_name = '".addslashes($api_name)."', CustID = '".addslashes($CustID)."'";
			  $this->query($strSQLQuery, 0);
			}
		}		
	   		
   	}

/*************************End****************************/

	
function ListCustomerSales($arryDetails) {
	global $Config;
	extract($arryDetails);	
	$objConfigure=new configure();
	$CostOfGoods = $objConfigure->getSettingVariable('CostOfGoods');
	 
	$strAddQuery = ""; 
	if($fby=='Year'){ 
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN ( YEAR(o.PostedDate)='".$y."') ELSE ( YEAR(o.InvoiceDate)='".$y."') END ";
	}else if($fby=='Month'){
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."') ELSE (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";
	}else{ 
		$strAddQuery .= " and CASE WHEN o.Module = 'Credit' THEN (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) ELSE (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";

	}		   
 	$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
 
 	
	if($Config['ConversionType']==1){
		$TotalAmount =  "if(o.ConversionRate>0, s.TotalAmount/o.ConversionRate,s.TotalAmount)" ;
		$line_amount = "if(s.ConversionRate>0, t.amount/s.ConversionRate, t.amount)";		
	}else{
		$TotalAmount =  "if(o.ConversionRate>0, s.TotalAmount*o.ConversionRate,s.TotalAmount)" ;
		$line_amount = "if(s.ConversionRate>0, t.amount*s.ConversionRate, t.amount)";	
	}
        
	$strAddQuery .= " GROUP BY MONTH(InvDate),YEAR(InvDate) ";

	$strAddQuery .= " Order By  InvDate ASC ,o.OrderID ASC ";
	
	/*********Invoice Nested Queries*************/	 
	$InnerWhereGroup = " and s.CustCode='".$CustCode."' and s.PostToGL='1' and CASE WHEN o.Module = 'Invoice' THEN (MONTH(s.InvoiceDate)=MONTH(o.InvoiceDate) and YEAR(s.InvoiceDate)=YEAR(o.InvoiceDate)) ELSE ( MONTH(s.InvoiceDate)=MONTH(o.PostedDate) and YEAR(s.InvoiceDate)=YEAR(o.PostedDate) ) END  GROUP BY MONTH(s.InvoiceDate),YEAR(s.InvoiceDate) ";




	$SalesAmountGL = "(select sum(".$TotalAmount.") from s_order s  where s.Module='Invoice' and s.InvoiceEntry in(2,3) ".$InnerWhereGroup.") as SalesAmountGL, ";

	$SalesLineAmount = " (select sum(".$line_amount.") from s_order_item t inner join s_order s on s.OrderID=t.OrderID    where s.Module='Invoice' and s.InvoiceEntry in(0,1) ".$InnerWhereGroup." ) as SalesLineAmount, ";

	$CostOfSale = " (select sum(if(t.DropshipCheck=1,t.DropshipCost * t.qty_invoiced,t.avgCost * t.qty_invoiced)) from s_order_item t inner join s_order s on t.OrderID=s.OrderID  where t.parent_item_id='0' ".$InnerWhereGroup." )  as CostOfSale, ";

	/*********Credit Nested Queries*************/
 	$InnerWhereGroupCr = " and s.Module='Credit' and s.OverPaid='0' and s.CustCode='".$CustCode."' and s.PostToGL='1' 
and CASE WHEN o.Module = 'Credit' THEN ( MONTH(s.PostedDate)=MONTH(o.PostedDate) and YEAR(s.PostedDate)=YEAR(o.PostedDate)) ELSE ( MONTH(s.PostedDate)=MONTH(o.InvoiceDate) and YEAR(s.PostedDate)=YEAR(o.InvoiceDate) ) END
  GROUP BY MONTH(s.PostedDate),YEAR(s.PostedDate) ";	

	$CreditAmountGL = " (select sum(".$TotalAmount.") from s_order s  where  s.AccountID>0 ".$InnerWhereGroupCr.")
  as CreditAmountGL, ";	


	$CreditLineAmount = " (select sum(".$line_amount.") from s_order_item t inner join s_order s on s.OrderID=t.OrderID    where  s.AccountID<=0 ".$InnerWhereGroupCr." ) as CreditLineAmount, ";



	if($CostOfGoods>0){
		$CostOfCredit = " (SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.PostToGL ='Yes' and p.CreditID !='' and p.PaymentType in ('Customer Credit Memo') and p.CustCode='".$CustCode."' and p.AccountID='".$CostOfGoods."'  and MONTH(p.PaymentDate)=MONTH(o.PostToGLDate) and YEAR(p.PaymentDate)=YEAR(o.PostToGLDate) GROUP BY MONTH(p.PaymentDate),YEAR(p.PaymentDate)  ) as CostOfCredit, ";
		 
	}

	/*****************************/


       	$Columns = "  COUNT(DISTINCT(o.OrderID)) as TotalInvoiceNo  ,  MONTH(IF(o.Module = 'Credit', o.PostedDate, o.InvoiceDate)) as MonthDate,
".$SalesAmountGL. $SalesLineAmount. $CostOfSale. $CreditAmountGL. $CreditLineAmount.$CostOfCredit." 
IF(o.Module = 'Credit', o.PostedDate, o.InvoiceDate) as InvDate   ";
 
	/*$Columns2 = "  
i.DropshipCheck, i.avgCost, o.InvoiceID, o.CreditID, o.Module, 


if(o.InvoiceEntry<=1 and o.Module='Invoice' and parent_item_id='0' and DropshipCheck='0', i.avgCost * i.qty_invoiced ,0) as CostOfSale,

if(o.InvoiceEntry<=1 and o.Module='Invoice' and parent_item_id='0' and DropshipCheck='1', i.DropshipCost * i.qty_invoiced ,0) as CostDropship,

IF(o.Module = 'Credit', o.PostedDate, o.InvoiceDate) as InvDate   ";*/
 		                		
         
	  $strSQLQuery = "select ".$Columns." from s_order o left outer join s_order_item i on o.OrderID=i.OrderID where o.Module in ('Invoice','Credit') and o.PostToGL='1' and o.NoUse='0' and o.OverPaid='0'   ".$strAddQuery;
	//and CASE WHEN o.Module = 'Credit' THEN ( o.Status IN('Completed') ) ELSE ( o.InvoicePaid IN('Part Paid','Paid')) END

	return $this->query($strSQLQuery, 1);
	}

	
	function getCashReciviedByDate($arryDetails, $CustID,$year,$month) {
	    	 global $Config;
		extract($arryDetails);	
		 if(!empty($CustID) && !empty($year) && !empty($month)) {  
			 
	 
		 	 $strSQLQuery = "select sum(d.Amount) as Amount from f_transaction_data d inner join f_transaction t on d.TransactionID=t.TransactionID where MONTH(t.PaymentDate)='".$month."' and YEAR(t.PaymentDate)='".$year."'  and d.Deleted='0' and d.CustID='".$CustID."' and t.Voided='0' ";  
			$rs = $this->query($strSQLQuery, 1);
			return $rs[0]["Amount"];
		}
	}


	function  ListRecurringHistory($arryDetails)
		{
			global $Config;
			extract($arryDetails); 
			$strAddQuery = "";	   
			if(!empty($Parent)){
				$strAddQuery .= " and (o.OrderID='".$Parent."' or (o.Parent='".$Parent."' and o.EntryBy='C')) ";				 
			}		 
			 
			if($Config['GetNumRecords']==1){
				$Columns = " count(distinct(o.OrderID)) as NumCount ";				
			}else{	
				$strAddQuery .= " order by o.InvoiceDate asc, o.OrderID asc, t.ID desc  ";
	
				$Columns = "  distinct(o.OrderID), o.InvoiceID,  o.TotalInvoiceAmount, o.CustomerCurrency, o.ConversionRate,o.NoUse,o.Parent, o.StatusMsg, o.PaymentTerm , o.InvoicePaid, o.OrderPaid, o.InvoiceDate, o.InvoiceEntry,  t.TransactionDate, t.TransactionID, t.TransactionType ,t.TotalAmount as TransactionAmount, t.Fee as TransactionFee, t.Currency as TransactionCurrency, p.ProviderName   ";
		
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			$strSQLQuery = "select ".$Columns."  from s_order_item si inner join s_order o on si.OrderID=o.OrderID left outer join s_order so on (o.SaleID!='' and o.SaleID=so.SaleID and so.Module='Order') left outer join s_order_transaction t on (t.OrderID=o.OrderID OR t.OrderID=so.OrderID) left outer join f_payment_provider p on t.ProviderID=p.ProviderID where o.Module='Invoice' and o.InvoiceID != '' and o.InvoiceEntry in ('0','1') and si.id>'0' and si.sku!='' ".$strAddQuery;
		
			if(!empty($_GET['pk'])) 
				echo $strSQLQuery.'<br><br>';

			return $this->query($strSQLQuery, 1);		
				
		}

	function UpdateOnlyCardOnSale($arryDetails,$NewCardID){
		global $Config;		 
		extract($arryDetails);
		if(!empty($CustID) && !empty($NewCardID)){
			
			/******Check if there is no card for customer************/
			$strSQL = "SELECT CardID FROM s_customer_card WHERE CustID = '".$CustID."' and CardID!='".$NewCardID."' ";	 
			$arryCardExist = $this->query($strSQL, 1);
  
 
			if(empty($arryCardExist[0]['CardID']) || ($DefaultCard!=$OldDefaultCard && !empty($DefaultCard))){

			    $arryCard = $this->GetCard($NewCardID,$CustID,'');
 
 

			   $strSQLQuery = "select distinct(o.OrderID) as OrderID , o.Parent, o.InvoiceID, o.SaleID, o.InvoicePaid, o.OrderPaid, c.*,cs.CustCode, so.EntryType from s_order_card c inner join s_order o on (c.OrderID = o.OrderID and c.OrderID>'0') inner join s_customers cs on (o.CustCode=cs.CustCode and o.CustCode!='') left outer join `s_order_item` so on o.OrderID=so.OrderID left outer join `s_order_transaction` t on o.OrderID=t.OrderID where o.PaymentTerm='Credit Card' and o.Module in('Quote','Order','Invoice')  and cs.Cid='".$CustID."' and  c.CardType!='' and c.CardNumber!='' and o.Status not in('Cancelled', 'Rejected','Completed')  and ((o.InvoicePaid='Unpaid' and o.OrderPaid='0' and t.TransactionID is NULL) OR (o.Module='Invoice' and o.OrderPaid>'0' and o.InvoiceEntry in ('0','1') and so.id>'0' and so.sku!='' and so.EntryType='recurring' )) order by c.CardID asc";
			  $arryRow = $this->query($strSQLQuery, 1);
	 	 	 
			  foreach ($arryRow as $key => $values) { 
				if($values['EntryType']=="recurring" && $values['OrderPaid']>0){
					$recurringOrderArray[] = $values['OrderID'];
				}else{		 
					$orderArray[] = $values['OrderID'];
				}	 
			  } 
 
 
			  if(!empty($orderArray[0]) || !empty($recurringOrderArray[0])){
				
				/***************/
				if($main_state_id>0) $OtherState = '';
				if($main_city_id>0) $OtherCity = '';
				$objRegion=new region();
				$arryCountry = $objRegion->GetCountryCode($country_id);
				$Country= stripslashes($arryCountry[0]["code"]);
				$State=$City='';
				if(!empty($main_state_id)) {
					$arryState = $objRegion->getStateName($main_state_id);
					$State = stripslashes($arryState[0]["name"]);
				}else if(!empty($OtherState)){
					 $State = $OtherState;
				}

				if(!empty($main_city_id)) {
					$arryCity = $objRegion->getCityName($main_city_id);
					$City= stripslashes($arryCity[0]["name"]);
				}else if(!empty($OtherCity)){
					 $City = $OtherCity;
				}
				/***************/
				 
				if(!empty($orderArray[0])){
					$OrderIDS = "'".implode("','",$orderArray)."'";
					$strSQLQue = "update s_order_card set CardID='".addslashes($NewCardID)."', CardNumber=ENCODE('" .$CardNumber. "','".$Config['EncryptKey']."'), CardType='".addslashes($arryCard[0]['CardType'])."', CardHolderName='".addslashes($arryCard[0]['CardHolderName'])."',  ExpiryMonth='".addslashes($arryCard[0]['ExpiryMonth'])."', ExpiryYear='".addslashes($arryCard[0]['ExpiryYear'])."', SecurityCode = '".addslashes($arryCard[0]['SecurityCode'])."', Address='".addslashes($arryCard[0]['Address'])."', Country='".addslashes($Country)."', State='".addslashes($State)."', City='".addslashes($City)."', ZipCode = '".addslashes($ZipCode)."'   WHERE OrderID in (".$OrderIDS.") " ;	
				 	$this->query($strSQLQue, 0);
				}
				if(!empty($recurringOrderArray[0])){
					$OrderIDSRec = "'".implode("','",$recurringOrderArray)."'";

					$CardInfo =	array(
					'CardID'=>$NewCardID,
					'CardNumber'=>$CardNumber,
					'CardType'=>$arryCard[0]['CardType'],
					'CardHolderName'=>$arryCard[0]['CardHolderName'],
					'ExpiryMonth'=>$arryCard[0]['ExpiryMonth'],
					'ExpiryYear'=>$arryCard[0]['ExpiryYear'],
					'SecurityCode'=>$arryCard[0]['SecurityCode'],
					'Address'=>$arryCard[0]['Address'],
					'Country'=>$Country,
					'State'=>$State,
					'City'=>$City,
					'ZipCode'=>$ZipCode
					);
 
					$RecurringCardInfo= json_encode($CardInfo);

 
					$strSQLQue2 = "update s_order_card set RecurringCardInfo = '".addslashes($RecurringCardInfo)."'   WHERE OrderID in (".$OrderIDSRec.") " ;	 
					$this->query($strSQLQue2, 0);	
				}	

				//echo $strSQLQue.'<br><br>'.$strSQLQue2; die;

			}

		     }
	    }	
		 
	 return 1;

	}
	
	//this function is created by nisha to record sales commission by customer.
function UpdateSalesPersonCommission($arrayDetails)
{
global $Config;		 
extract($arrayDetails);
$arrayEmpInserted = []; $arrayUpdated = []; $arrayVenInserted = []; $venSalesPersonIdsArr=[]; $empSalesPersonIdsArr=[];
    if(!empty($CustId)){
       	if(!empty($SalesPersonID)){
       		$empSalesPersonIdsArr = explode(",",$SalesPersonID);  //emp type sp
       	}
			if(!empty($vendorSalesPersonID)){
			$venSalesPersonIdsArr  = explode(",",$vendorSalesPersonID); //vendor type sp
       	}
       	$strSQL = "SELECT ID,EmpSpId,VenSpId FROM customer_sales_commission WHERE CustomerId = '".$CustId."'"; 	 
			$arryIdExist = $this->query($strSQL, 1);
       	    if(!empty($arryIdExist)){
                foreach ($arryIdExist as $value) {
                	if(!empty($value['EmpSpId'])){
                    array_push($arrayEmpInserted, $value['EmpSpId']);
                    }
                }
            }

            if(!empty($arryIdExist)){
                foreach ($arryIdExist as $value) {
                	if(!empty($value['VenSpId'])){
                    array_push($arrayVenInserted, $value['VenSpId']);
                    }
                }
            } 

            $empArryToDelete = array_diff($arrayEmpInserted, $empSalesPersonIdsArr);
            $empArryToUpdate = array_diff($empSalesPersonIdsArr, $arrayEmpInserted);
            $venArryToDelete = array_diff($arrayVenInserted, $venSalesPersonIdsArr);
            $venArryToUpdate = array_diff($venSalesPersonIdsArr, $arrayVenInserted);

        if(!empty($empArryToDelete)){
          foreach ($empArryToDelete as $key => $value2) {
            $strSqlQueryToDelEmp = "DELETE FROM customer_sales_commission  WHERE CustomerId = '".$CustId."' and EmpSpId='".$value2."'"; 
          $this->query($strSqlQueryToDelEmp,0);
          }
          
        }
        if(!empty($venArryToDelete)){
          foreach ($venArryToDelete as $key => $value3) {
            $strSqlQueryToDelVen = "DELETE FROM customer_sales_commission  WHERE CustomerId = '".$CustId."' and VenSpId='".$value3."'"; 
          $this->query($strSqlQueryToDelVen,0);
          }
          
        }

            	if(!empty($empSalesPersonIdsArr)){

            		foreach ($empSalesPersonIdsArr as $key => $value) {

            			//get commission percentage for emplpyee
            			$strSQL1 = "SELECT CommPercentage FROM h_commission WHERE EmpID = '".$value."'";
                      $arryCommpercentage = $this->query($strSQL1, 1);
                        /******Check if there is sales commission percentage setup for customer************/ 
                if(empty($arryIdExist)){
            	     $strSQLQue2 = "insert into customer_sales_commission set  CustomerId = '".$CustId."', EmpSpId = '".$value."', CommPercentage = '".$arryCommpercentage[0]['CommPercentage']."'" ;   
                    $this->query($strSQLQue2, 0); 
                }
                else{
                	if((!empty($empArryToUpdate)) && (in_array($value,$empArryToUpdate))){
                        $strSQLQueryEmpUpdate = "insert into customer_sales_commission set  CustomerId = '".$CustId."', EmpSpId = '".$value."',  CommPercentage = '".$arryCommpercentage[0]['CommPercentage']."'" ;  
                        $this->query($strSQLQueryEmpUpdate, 0);
                    }
                }
        
       
        

            		 }
            	}
            	if(!empty($venSalesPersonIdsArr)){
                    foreach ($venSalesPersonIdsArr as $key1 => $value1) {
            			//get commission percentage for emplpyee
            			$strSQL1 = "SELECT CommPercentage FROM h_commission WHERE SuppID = '".$value1."'";
                      $arryCommpercentage = $this->query($strSQL1, 1);
                        /******Check if there is sales commission percentage setup for customer************/ 

        
                       if(empty($arryIdExist)){
            	     $strSQLQue2 = "insert into customer_sales_commission set  CustomerId = '".$CustId."', VenSpId = '".$value1."', CommPercentage = '".$arryCommpercentage[0]['CommPercentage']."'" ;   
                    $this->query($strSQLQue2, 0); 
                }
                else{
                	if((!empty($venArryToUpdate)) && (in_array($value1,$venArryToUpdate))){
                        $strSQLQueryEmpUpdate = "insert into customer_sales_commission set  CustomerId = '".$CustId."', VenSpId = '".$value1."',  CommPercentage = '".$arryCommpercentage[0]['CommPercentage']."'" ;  
                        $this->query($strSQLQueryEmpUpdate, 0);
                    }
                }
        
        

            		 }
            	}

			
			
		}


}
// this function is created by nisha to get sales person commission for customer.
function GetCustomerCommissionPercent($custID)
{
  global $Config;		 
   $strSqlQuery = "SELECT * FROM `customer_sales_commission`  where CustomerId = '".$custID."'";
   return $this->query($strSqlQuery, 1);
}

//this function is created by nisha to update customer sales commission

function updateCustomerSaleCommission($id,$commission_per)
{
   global $Config;
   $strSqlQuery = "update customer_sales_commission set CommPercentage = '".$commission_per."'   WHERE ID= '".$id."'" ;	 
	return $this->query($strSqlQuery, 0);
}


}
?>
