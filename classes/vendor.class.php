<?
class vendor extends dbClass
{
		//constructor
		function vendor()
		{
			$this->dbClass();
		} 
		
		function  ListVendor($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			#$strAddQuery .= (!empty($id))?(" where v.VendorID='".$id."'"):(" where v.locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= (!empty($id))?(" where v.VendorID='".$id."'"):(" where 1");

			if($SearchKey=='active' && ($sortby=='v.Status' || $sortby=='') ){
				$strAddQuery .= " and v.Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='v.Status' || $sortby=='') ){
				$strAddQuery .= " and v.Status='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (v.VendorCode like '%".$SearchKey."%' or v.VendorName like '%".$SearchKey."%'  or v.Email like '%".$SearchKey."%' or v.Country like '%".$SearchKey."%' or v.State like '%".$SearchKey."%' or v.City like '%".$SearchKey."%'  ) " ):("");		
			}
			$strAddQuery .= ($Status>0)?(" and v.Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by v.VendorID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Desc");

			$strSQLQuery = "select v.VendorID,v.VendorCode,v.Country,v.State, v.City,v.Email,v.VendorName,v.Mobile,v.Status from h_vendor v ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
	
		function  GetVendorImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where v.VendorID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strSQLQuery = "select v.Image from h_vendor v ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

	

		function  GetVendor($VendorID,$VendorCode,$Status)
		{
			$strSQLQuery = "select v.* from h_vendor v ";

			#$strSQLQuery .= (!empty($VendorID))?(" where v.VendorID='".$VendorID."'"):(" and v.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= (!empty($VendorID))?(" where v.VendorID='".mysql_real_escape_string($VendorID)."'"):(" where 1");
			$strSQLQuery .= (!empty($VendorCode))?(" and v.VendorCode='".mysql_real_escape_string($VendorCode)."'"):("");
			$strSQLQuery .= ($Status>0)?(" and v.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}		
		

		function AddVendor($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if($Status=='') $Status=1;

	
			$ipaddress = GetIPAddress(); 

			$strSQLQuery = "insert into h_vendor (VendorCode,Email,VendorName, Address, city_id, state_id, ZipCode, country_id,Mobile, Landline, Fax, Website, Status, OtherState, OtherCity, ipaddress, UpdatedDate) values('".addslashes($VendorCode)."', '".addslashes($Email)."','".addslashes($VendorName)."', '".addslashes(strip_tags($Address))."' ,  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($Landline)."', '".addslashes($Fax)."',  '".addslashes($Website)."', '".$Status."',    '".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".$ipaddress."', '".$Config['TodayDate']."')";
			$this->query($strSQLQuery, 0);
			$VendorID = $this->lastInsertId();

			if(empty($VendorCode)){
				$VendorCode = 'VND000'.$VendorID;
				$strSQL = "update h_vendor set VendorCode='".$VendorCode."' where VendorID='".$VendorID."'"; 
				$this->query($strSQL, 0);
			}

			return $VendorID;

		}


		function UpdateVendor($arryDetails){ 
			global $Config;
			extract($arryDetails);

			if(!empty($VendorID)){
		
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				if($Status=='') $Status=1;


				$strSQLQuery = "update h_vendor set Email='".addslashes($Email)."', VendorName='".addslashes($VendorName)."',
				Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' , Website='".addslashes($Website)."', Status='".$Status."' ,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'	 
				,UpdatedDate = '".$Config['TodayDate']."' where VendorID='".mysql_real_escape_string($VendorID)."'"; 

				$this->query($strSQLQuery, 0);

				if(empty($VendorCode)){
					$VendorCode = 'VND000'.$VendorID;
					$strSQL = "update h_vendor set VendorCode='".$VendorCode."' where VendorID='".$VendorID."'"; 
					$this->query($strSQL, 0);
				}


			}

			return 1;
		}

		function UpdateCountyStateCity($arryDetails,$VendorID){   
			extract($arryDetails);		
			if(!empty($VendorID)){
				$strSQLQuery = "update h_vendor set Country='".addslashes($Country)."',  State='".addslashes($State)."',  City='".addslashes($City)."' where VendorID='".mysql_real_escape_string($VendorID)."'";
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function RemoveVendor($VendorID)
		{
			if(!empty($VendorID)){
				$strSQLQuery = "select Image from h_vendor where VendorID='".mysql_real_escape_string($VendorID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				$ImgDir = 'upload/vendor/'.$_SESSION['CmpID'].'/';
			
				if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							
					unlink($ImgDir.$arryRow[0]['Image']);	
				}
			
				$strSQLQuery = "delete from h_vendor where VendorID='".mysql_real_escape_string($VendorID)."'"; 
				$this->query($strSQLQuery, 0);				
			}

			return 1;

		}

		function UpdateImage($Image,$VendorID)
		{
			if(!empty($VendorID) && !empty($Image)){
				$strSQLQuery = "update h_vendor set Image='".$Image."' where VendorID='".mysql_real_escape_string($VendorID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		
		function changeVendorStatus($VendorID)
		{
			if(!empty($VendorID)){
				$sql="select VendorID,Status from h_vendor where VendorID='".$VendorID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_vendor set Status='$Status' where VendorID='".mysql_real_escape_string($VendorID)."'";
					$this->query($sql,0);				

					return true;
				}	
			}
		}
		

		function MultipleVendorStatus($VendorIDs,$Status)
		{
			$sql="select VendorID from h_vendor where VendorID in (".$VendorIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update h_vendor set Status='".$Status."' where VendorID in (".$VendorIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		
		
		function isEmailExists($Email,$VendorID=0)
		{
			$strSQLQuery = (!empty($VendorID))?(" and VendorID != '".$VendorID."'"):("");
			$strSQLQuery = "select VendorID from h_vendor where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['VendorID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isVendorCodeExists($VendorCode,$VendorID=0)
		{
			$strSQLQuery = (!empty($VendorID))?(" and VendorID != '".$VendorID."'"):("");
			$strSQLQuery = "select VendorID from h_vendor where LCASE(VendorCode)='".strtolower(trim($VendorCode))."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['VendorID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isVendorNameExists($VendorName,$VendorID=0)
		{
			$strSQLQuery = (!empty($VendorID))?(" and VendorID != '".$VendorID."'"):("");
			$strSQLQuery = "select VendorID from h_vendor where LCASE(VendorName)='".strtolower(trim($VendorName))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['VendorID'])) {
				return true;
			} else {
				return false;
			}
		}	
		

		function GetAssetVendor($Status){
			
				$strSQLQuery = "SELECT VendorID,VendorName FROM h_vendor WHERE Status='".mysql_real_escape_string($Status)."'";
				return $this->query($strSQLQuery, 1);
			
		}
		




}
?>
