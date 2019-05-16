<?
class brand extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function brand(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addBrand($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into brand (heading,detail,Website,Status) values('".addslashes($heading)."', '".addslashes($detail)."','".addslashes($Website)."', '".$Status."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateBrand($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update brand set heading='".addslashes($heading)."', detail = '".addslashes($detail)."', Website = '".addslashes($Website)."',Status = '".$Status."'  where brandID = '".$brandID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function getBrand($id=0,$MemberID,$Status=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and brandID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from brand ".$sql." order by brandID desc" ; 
		return $this->query($sql, 1);
	}

	function changeBrandStatus($brandID)
	{
		$sql="select * from brand where brandID='".$brandID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update brand set Status='$Status' where brandID='".$brandID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteBrand($brandID)
	{

		$strSQLQuery = "select Image from brand where brandID='".$brandID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		if($Front > 0){
			$ImgDir = 'upload/brands/';
		}else{
			$ImgDir = '../upload/brands/';
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							unlink($ImgDir.$arryRow[0]['Image']);	
		}

		$sql = "delete from brand where brandID = '".$brandID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListBrand($id=0,$MemberID, $SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = " where 1";
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and brandID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (heading like '".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by brandID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from brand ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateImage($imageName,$brandID)
	{
			$strSQLQuery = "update brand set Image='".$imageName."' where brandID='".$brandID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isBrandExists($heading,$brandID)
	{

		$strSQLQuery ="select * from brand where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($brandID))?(" and brandID != '".$brandID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['brandID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
