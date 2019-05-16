<?
class partner extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function partner(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addPartner($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into partner (heading,detail,Website,MemberID,Status,DisplayWidth,DisplayHeight) values('".addslashes($heading)."', '".addslashes($detail)."','".addslashes($Website)."', '".$MemberID."','".$Status."','".$DisplayWidth."','".$DisplayHeight."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updatePartner($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update partner set heading='".addslashes($heading)."', detail = '".addslashes($detail)."', Website = '".addslashes($Website)."',MemberID='".$MemberID."',Status = '".$Status."',
			DisplayWidth='".$DisplayWidth."', DisplayHeight='".$DisplayHeight."'  where partnerID = '".$partnerID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function getPartner($id=0,$MemberID,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($MemberID))?(" and MemberID = '".$MemberID."'"):("");
		$sql .= (!empty($id))?(" and partnerID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		 $sql = "select * from partner ".$sql." order by partnerID desc" ; 
		return $this->query($sql, 1);
	}

	function changePartnerStatus($partnerID)
	{
		$sql="select * from partner where partnerID='".$partnerID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update partner set Status='$Status' where partnerID='".$partnerID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deletePartner($partnerID)
	{

		$strSQLQuery = "select Image from partner where partnerID='".$partnerID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		if($Front > 0){
			$ImgDir = 'upload/partners/';
		}else{
			$ImgDir = '../upload/partners/';
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							unlink($ImgDir.$arryRow[0]['Image']);	
		}

		$sql = "delete from partner where partnerID = '".$partnerID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListPartner($id=0,$MemberID, $SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = " where MemberID='".$MemberID."'";
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and partnerID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (heading like '".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by partnerID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from partner ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateImage($imageName,$partnerID)
	{
			$strSQLQuery = "update partner set Image='".$imageName."' where partnerID='".$partnerID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isPartnerExists($heading,$partnerID)
	{

		$strSQLQuery ="select * from partner where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($partnerID))?(" and partnerID != '".$partnerID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['partnerID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
