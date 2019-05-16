<?
class license extends dbClass
{
		//constructor
		function license()
		{
			$this->dbClass();
		} 
		
		function  ListLicense($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where l.LicenseID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			if($SearchKey=='active' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and l.Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and l.Status='0'";
			}else if($SortBy != ''){

				if($SortBy=='l.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");

				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (l.DomainName like '%".$SearchKey."%' ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by l.DomainName asc ");

			if($Config['GetNumRecords']==1){
				$Columns = " count(l.LicenseID) as NumCount ";				
			}else{				
				$Columns = " l.* ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}


			$strSQLQuery = "select ".$Columns." from z_iocube_license_key l ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}		

		function  GetLicense($LicenseID,$Status)
		{
			$strSQLQuery = "select l.* from z_iocube_license_key l ";

			$strSQLQuery .= (!empty($LicenseID))?(" where l.LicenseID='".mysql_real_escape_string($LicenseID)."'"):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and l.Status='".mysql_real_escape_string($Status)."'"):("");
	
			return $this->query($strSQLQuery, 1);
		}		
		
		
		function AddLicense($arryDetails)
		{  			
			global $Config;
			extract($arryDetails);
			$Ipaddress = GetIPAddress();
			$strSQLQuery = "insert into z_iocube_license_key (DomainName, LicenseKey, ExpiryDate, Status, Ipaddress, AddedDate,MaxUser) values( '".addslashes($DomainName)."', '".addslashes($LicenseKey)."', '".addslashes($ExpiryDate)."', '".$Status."', '".$Ipaddress."', '".date('Y-m-d')."', '".$MaxUser."')";
			//echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$LicenseID = $this->lastInsertId();
			return $LicenseID;
		}


		function UpdateLicenseExpiry($arryDetails){   
			extract($arryDetails);
			if(!empty($LicenseID)){
				$strSQLQuery = "update z_iocube_license_key set ExpiryDate='".addslashes($ExpiryDate)."', Status='".$Status."', MaxUser='".$MaxUser."' where LicenseID='".$LicenseID."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}



		function RemoveLicense($LicenseID)
		{
			if(!empty($LicenseID)){
				$strSQLQuery = "delete from z_iocube_license_key where LicenseID='".mysql_real_escape_string($LicenseID)."'"; 
				$this->query($strSQLQuery, 0);	
			}
			return 1;
		}

				
		function changeLicenseStatus($LicenseID)
		{
			if(!empty($LicenseID)){
				$sql="select LicenseID,Status from z_iocube_license_key where LicenseID='".mysql_real_escape_string($LicenseID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update z_iocube_license_key set Status='$Status' where LicenseID='".mysql_real_escape_string($LicenseID)."'";
					$this->query($sql,0);					
				}	
			}

			return true;

		}
		
		
		function isDomainExists($DomainName,$LicenseID=0)
		{
			$strSQLQuery = (!empty($LicenseID))?(" and LicenseID != '".mysql_real_escape_string($LicenseID)."'"):("");
			$strSQLQuery = "select LicenseID from z_iocube_license_key where LCASE(DomainName)='".addslashes(strtolower(trim($DomainName)))."'".$strSQLQuery;
			//echo $strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['LicenseID'])) {
				return true;
			} else {
				return false;
			}
		}	

		
		

		function isLicenseKeyExists($LicenseKey,$LicenseID=0)
		{
			$strSQLQuery = (!empty($LicenseID))?(" and LicenseID != '".mysql_real_escape_string($LicenseID)."'"):("");
			$strSQLQuery = "select LicenseID from z_iocube_license_key where LCASE(LicenseKey)='".addslashes(strtolower(trim($LicenseKey)))."'".$strSQLQuery;
			//echo $strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['LicenseID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		
		/* Checking for Coupon Code existance */
		
		function isCouponExists($CouponName,$CouponID=0)
		{
			$strSQLQuery = (!empty($CouponID))?(" and id != '".mysql_real_escape_string($CouponID)."'"):("");
			$strSQLQuery = "select id from coupons where LCASE(CouponCode)='".addslashes(strtolower(trim($CouponName)))."'".$strSQLQuery;
			//echo $strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['id'])) {
				return true;
			} else {
				return false;
			}
		}		
		
		



}
?>
