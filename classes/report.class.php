<?
class report extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function report(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addReport($arryEmails)
	{
		@extract($arryEmails);	
		$sql = "insert into report (Name,Email,Phone, Website, Content,WhyOffensive,Date) values('".addslashes($Name)."', '".addslashes($Email)."', '".addslashes($Phone)."','".addslashes($Website)."' , '".addslashes($Content)."', '".addslashes($WhyOffensive)."','".date('Y-m-d')."')";
		$rs = $this->query($sql,0);
		$lastInsertId = $this->lastInsertId();

		if(sizeof($rs))
			return true;
		else
			return false;

	}



	function getReport($id=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and reportID = '".$id."'"):("");

		$sql = "select * from report ".$sql." order by reportID desc" ;
		return $this->query($sql, 1);
	}


	function deleteReport($id)
	{
		$sql = "delete from report where reportID = '".$id."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;
	}
	
	function  ListReport($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and reportID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (Content like '%".$SearchKey."%' or Name like '".$SearchKey."%' or Email like '".$SearchKey."%' or Date like '".$SearchKey."%')"):("");
		}

		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by reportID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from report ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}



}
?>
