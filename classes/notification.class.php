<?
class notification extends dbClass
{
	//constructor
	function notification()
	{
		$this->dbClass();
	}
	
	
	function  ListNotifictaion()
	{
		global $Config;
		$strAddQuery='';
		if($Config['GetNumRecords']==1){
			$Columns = " count(NotificationId) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
		
		}

		 $sql = "SELECT ".$Columns." from notifications  ORDER BY NotificationId DESC ".$strAddQuery;
		return $this->query($sql, 1);		
		
		
	}




	function GetNotificationById($NotificationID) { 
			    global $Config;
			    $sql = "SELECT * from ".$Config['DbMain'].".notifications WHERE NotificationId = '" . mysql_real_escape_string($NotificationID) . "'";
			   return $this->query($sql, 1);
		}

	function vNotification($NotificationID) {
			 $sql = "SELECT * from notifications WHERE NotificationId = '" . mysql_real_escape_string($NotificationID) . "'";
			return $this->query($sql, 1);
		}

	function RemoveNotification($NotificationID)
		{
			global $Config;
			$objConfigure=new configure();
			$objFunction=new functions();
			if(!empty($NotificationID)){
				$strSQLQuery = "select Image from notifications where NotificationId='".$NotificationID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if($arryRow[0]['Image'] !='' ){	 		
						$objFunction->DeleteFileStorage($Config['NotificationDir'],$arryRow[0]['Image']);	
					}
			
				$strSQLQuery = "delete from notifications where NotificationId='".$NotificationID."'";
				$this->query($strSQLQuery, 0);
			
			}
			return 1;

	}

	function changeNotificationStatus($NotificationID)
		{
			if(!empty($NotificationID)){
				$sql="select NotificationId,Status from notifications where NotificationId='".mysql_real_escape_string($NotificationID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
					$Status=0;
					else
					$Status=1;
					$sql="update notifications set Status='$Status' where NotificationId='".mysql_real_escape_string($NotificationID)."'";
					$this->query($sql,0);
				}
			}
			return true;
	}


	function AddNotification($arryDetails,$imageName)
		{
			global $Config;
			@extract($arryDetails);
		     $latest_update = (!empty($filecheck)? 1 : 0);
			$addedDate = date("Y-m-d");
			$strSQLQuery = "insert into notifications (Heading,Detail, Status, Image,Date,latest_update) values( '".mysql_real_escape_string(strip_tags($Heading))."','".addslashes($Content)."',  '".mysql_real_escape_string(strip_tags($Status))."' ,  '".mysql_real_escape_string(strip_tags($imageName))."','".addslashes($Date)."', '".mysql_real_escape_string($latest_update)."')";
			$this->query($strSQLQuery, 0);
			$NotificationID = $this->lastInsertId();
			return $NotificationID;
		}

	function UpdateNotification($arryDetails){		
		@extract($arryDetails);
		$latest_update = (!empty($filecheck)? 1 : 0);
		$addedDate = date("Y-m-d");			
			$strSQLQuery = "UPDATE  notifications SET Heading = '". mysql_real_escape_string(strip_tags($Heading)) ."' ,Detail='".addslashes($Content)."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "',Date='".mysql_real_escape_string(strip_tags($Date))."',latest_update = '". mysql_real_escape_string(strip_tags($latest_update)) ."' WHERE NotificationId = '" .  mysql_real_escape_string($NotificationID) . "' ";

		$this->query($strSQLQuery, 0);			
	}

	function UpdateImageNotification($Image,$NotificationID)
			{
				if(!empty($Image) && !empty($NotificationID)){
					$strSQLQuery = "update notifications set Image='".$Image."' where NotificationId='".$NotificationID."'";
					return $this->query($strSQLQuery, 0);
				}
			}

	function isNotificationHeadingExists($Heading,$NotificationID=0)
	{
		$strSQLQuery = (!empty($NotificationID))?(" and NotificationId != '".$NotificationID."'"):("");
		$strSQLQuery = "select NotificationId from notifications where LCASE(Heading)='".strtolower(trim($Heading))."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['NotificationId'])) {
			return true;
		} else {
			return false;
		}
	}
	
	

}
?>
