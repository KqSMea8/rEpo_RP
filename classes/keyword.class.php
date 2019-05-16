<?
class keyword extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function keyword(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addKeyword($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into keywords (Keyword,KeywordType,Status,Date) values('".addslashes($Keyword)."','".$KeywordType."', '".$Status."', '".date('Y-m-d H:i:s')."')";
		$rs = $this->query($sql,0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateKeyword($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update keywords set Keyword = '".addslashes($Keyword)."',KeywordType = '".$KeywordType."',  Status = '".$Status."'  where keywordID = '".$keywordID."'";
		$rs = $this->query($sql,0);
		if(sizeof($rs))
			return true;
		else
			return false;
	}
	function getKeyword($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and keywordID = ".$id):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from keywords".$sql." order by keywordID desc" ;
		return $this->query($sql, 1);
	}


	function changeKeywordStatus($keywordID)
	{
		$sql="select * from keywords where keywordID='".$keywordID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update keywords set Status='$Status' where keywordID='".$keywordID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteKeyword($id)
	{
		$sql = "delete from keywords where keywordID = '".$id."'";
		$rs = $this->query($sql,0);
		if(sizeof($rs))
			return true;
		else
			return false;
	}
	
	
	function  ListKeyword($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$sql = "delete from keywords where keyword = ''";
		$rs = $this->query($sql,0);

		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and v.keywordID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (v.Keyword like '".$SearchKey."%' or v.KeywordType  like '".$SearchKey."%')"):("");
		}

		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by v.Keyword ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

		$strSQLQuery = "select v.* from keywords v ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function isKeywordExists($Keyword,$keywordID,$KeywordType)
	{
		$sql ="select * from keywords where LCASE(Keyword) = '".strtolower(trim($Keyword))."' and KeywordType='".$KeywordType."'";
		$sql .= (!empty($keywordID))?(" and keywordID != '".$keywordID."'"):("");

		$arryRow = $this->query($sql, 1);
		if (!empty($arryRow[0]['keywordID'])) {
			return true;
		} else {
			return false;
		}
	}


}
?>
