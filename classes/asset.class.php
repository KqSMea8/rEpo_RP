<?
class asset extends dbClass
{
		//constructor
		function asset()
		{
			$this->dbClass();
		} 
		
		function  ListAsset($arryDetails){
			extract($arryDetails);
			global $Config;

			(empty($Status))?($Status=""):("");

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where a.AssetID='".$id."'"):(" where a.locationID='".$_SESSION['locationID']."'");

			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (a.TagID like '%".$SearchKey."%' or a.SerialNumber like '%".$SearchKey."%' or a.AssetName like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or a.Model like '%".$SearchKey."%'  ) " ):("");

				#$strAddQuery .= (!empty($SearchKey))?(" and (a.TagID like '%".$SearchKey."%' or v.VendorName like '%".$SearchKey."%' or a.AssetName like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or a.Category like '%".$SearchKey."%' or a.Model like '%".$SearchKey."%'  ) " ):("");		
			}
			
			if(!empty($AssignID)){
			  $strAddQuery .= " and a.AssignID = '0' ";
			}
			
			$strAddQuery .= ($Status>0)?(" and a.Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by a.TagID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Desc");

			if($Config['GetNumRecords']==1){
				$Columns = " count(a.AssetID) as NumCount ";				
			}else{				
				$Columns = " a.AssetID,a.TagID, a.RFID, a.AssetName, a.SerialNumber, e.UserName, e.JobTitle, v.VendorName, a.Category, a.Brand, a.Model,a.Vendor,a.AssignID,a.Status ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}				
			}


			$strSQLQuery = "select ".$Columns." from h_asset a  left outer join h_asset_assign n on a.AssignID=n.AssignID left outer join h_employee e on a.AssignID=e.EmpID left outer join h_vendor v on a.Vendor=v.VendorID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		function  GetAsset($AssetID,$TagID,$Status)
		{
			$strSQLQuery = "select a.*,e.UserName,e.JobTitle,v.VendorName from h_asset a left outer join h_employee e on a.AssignID=e.EmpID left outer join h_vendor v on a.Vendor=v.VendorID ";
			$strSQLQuery .= " where 1 ";
			$strSQLQuery .= (!empty($AssetID))?(" and a.AssetID='".$AssetID."'"):("");
			$strSQLQuery .= (!empty($TagID))?(" and a.TagID='".mysql_real_escape_string($TagID)."'"):("");
			$strSQLQuery .= ($Status>0)?(" and a.Status='".$Status."'"):("");
			return $this->query($strSQLQuery, 1);
		}		
		

		
		function GetAssetUser($UserID,$Status){
			if(!empty($UserID)){
				$strSQLQuery = "select * from h_asset where UserID='".mysql_real_escape_string($UserID)."' ";
				$strSQLQuery .= (!empty($Status))?(" and Status='".$Status."' "):("");
			
				return $this->query($strSQLQuery, 1);
			}
		}

		function  GetAssetImage($id=0)
		{
			if(!empty($id)){
				$strAddQuery = '';
				$strAddQuery .= (!empty($id))?(" where a.AssetID='".mysql_real_escape_string($id)."'"):(" where 1 ");

				$strSQLQuery = "select a.Image from h_asset s ".$strAddQuery;

				return $this->query($strSQLQuery, 1);
			}
		}

		function AddAsset($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
	
			$ipaddress = GetIPAddress(); 

			if($AssignID > 0){
			  $Status = 'In Use';
			}else{
			  $Status = 'In Stock';
			}

			$strSQLQuery = "insert into h_asset (locationID, TagID, RFID, AssetName, SerialNumber, Location, Description, Vendor,  WrStart, WrEnd, Status, ipaddress, UpdatedDate, Acquired, Model, Brand, Category) values('".$_SESSION['locationID']."', '".addslashes($TagID)."', '".addslashes($RFID)."', '".addslashes($AssetName)."', '".addslashes($SerialNumber)."', '".addslashes($Location)."', '".mysql_real_escape_string(strip_tags($Description))."', '".addslashes($Vendor)."','".addslashes($WrStart)."',  '".addslashes($WrEnd)."', '".$Status."', '".$ipaddress."', '".$Config['TodayDate']."','".$Acquired."', '".addslashes($Model)."', '".addslashes($Brand)."', '".addslashes($Category)."')";
			$this->query($strSQLQuery, 0);
			$AssetID = $this->lastInsertId();

			if(empty($TagID)){
				$TagID = 'AS000'.$AssetID;
				$strSQL = "update h_asset set TagID='".$TagID."' where AssetID='".$AssetID."'"; 
				$this->query($strSQL, 0);
			}

			return $AssetID;

		}


		function UpdateAsset($arryDetails){ 
			global $Config;
			extract($arryDetails);

			if(!empty($AssetID)){

				if($AssignID > 0){
				  $Status = 'In Use';
				}else{
				  $Status = 'In Stock';
				}

				$strSQLQuery = "update h_asset set AssetName='".addslashes($AssetName)."', Location='".addslashes($Location)."', Description='".mysql_real_escape_string(strip_tags($Description))."', Vendor='".addslashes($Vendor)."',
				Model='".addslashes($Model)."', WrStart='".addslashes($WrStart)."' , WrEnd='".addslashes($WrEnd)."', Status='".$Status."' ,UpdatedDate = '".$Config['TodayDate']."',Acquired='".$Acquired."',  Brand='".addslashes($Brand)."', Category='".addslashes($Category)."'
				where AssetID='".mysql_real_escape_string($AssetID)."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}



		function RemoveAsset($AssetID)
		{
			global $Config;
			$objFunction=new functions();
			if(!empty($AssetID)){
				$strSQLQuery = "select AssetID,Image from h_asset where AssetID='".mysql_real_escape_string($AssetID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
 
				if($arryRow[0]['Image'] !=''){	
					$objFunction->DeleteFileStorage($Config['AssetDir'],$arryRow[0]['Image']);
				}
			
				$strSQLQuery = "delete from h_asset where AssetID='".mysql_real_escape_string($AssetID)."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;

		}

		function UpdateImage($Image,$AssetID)
		{
			if(!empty($AssetID) && !empty($Image)){
				$strSQLQuery = "update h_asset set Image='".$Image."' where AssetID='".mysql_real_escape_string($AssetID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		
		function changeAssetStatus($AssetID)
		{
			if(!empty($AssetID)){
				$sql="select AssetID,Status from h_asset where AssetID='".$AssetID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_asset set Status='$Status' where AssetID='".mysql_real_escape_string($AssetID)."'";
					$this->query($sql,0);				

					return true;
				}	
			}
		}
		
		
		function isSerialNumberExists($SerialNumber,$AssetID=0)
		{
			$strSQLQuery = (!empty($AssetID))?(" and AssetID != '".$AssetID."'"):("");
			$strSQLQuery = "select AssetID from h_asset where LCASE(SerialNumber)='".strtolower(trim($SerialNumber))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['AssetID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isTagIDExists($TagID,$AssetID=0)
		{
			if(!empty($TagID)){
				$strSQLQuery = (!empty($AssetID))?(" and AssetID != '".$AssetID."'"):("");
				$strSQLQuery = "select AssetID from h_asset where LCASE(TagID)='".strtolower(trim($TagID))."'".$strSQLQuery;

				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['AssetID'])) {
					return true;
				} else {
					return false;
				}
			}else{
				return false;
			}
		}
		
		function AddAssignAsset($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
	
			$ipaddress = GetIPAddress(); 

		 
			$strSQLQuery = "insert into h_asset_assign (AssetID,TagID, AssetName, EmpID, EmpName, ExpectedReturnDate, AssignedBy, AssignedByName, AssignDate, ipaddress) values('".mysql_real_escape_string($AssetID)."','".mysql_real_escape_string($TagID)."','".addslashes($AssetName)."', '".mysql_real_escape_string($EmpID)."', '".addslashes($EmployeeName)."', '".mysql_real_escape_string($ExpectedReturnDate)."', '".mysql_real_escape_string($AdminID)."', '".addslashes($UserName)."', '".$Config['TodayDate']."', '".$ipaddress."')";
			$this->query($strSQLQuery, 0);
			
			$sql="update h_asset set AssignID='".mysql_real_escape_string($EmpID)."' where AssetID='".mysql_real_escape_string($AssetID)."'";
			$this->query($sql,0);	
			
		}
		
		function  ListAssignAsset($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = ' WHERE 1  ';
			$SearchKey   = strtolower(trim($key));
			 
			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (a.AssetName like '%".$SearchKey."%' or a.EmpName  like '%".$SearchKey."%'  ) " ):("");		
			}
		
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by a.AssignID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Desc");

			$strSQLQuery = "select * FROM h_asset_assign a ".$strAddQuery;	

			return $this->query($strSQLQuery, 1);		
				
		}

	function RemoveAssignAsset($AssignID,$AssetID)
		{
				$strSQLQuery = "delete from h_asset_assign where AssignID='".mysql_real_escape_string($AssignID)."'"; 
				$this->query($strSQLQuery, 0);
				
			   $strSQLQuery2="update h_asset set AssignID='0' where AssetID='".mysql_real_escape_string($AssetID)."'";
			    $this->query($strSQLQuery2,0);		
			
			     return 1;

		}
		
		function UpdateAssignAsset($arryDetails)
		{ 
		
		    global $Config;
			extract($arryDetails);
			
			$strSQLQuery="update h_asset_assign set ReturnDate='".mysql_real_escape_string($ReturnDate)."',UpdatedDate='".$Config['TodayDate']."' where AssignID='".mysql_real_escape_string($AssignID)."' and AssetID='".mysql_real_escape_string($AssetID)."'";
			$this->query($strSQLQuery,0);

			$strSQLQuery2="update h_asset set AssignID='0' where AssetID='".mysql_real_escape_string($AssetID)."'";
			$this->query($strSQLQuery2,0);				
		
		}
		

}
?>
