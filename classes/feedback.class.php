<?
class feedback extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function feedback(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addFeedback($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into feedback (ProductID,Name,Comment,Email,Status,feedbackDate) values('".$ProductID."', '".addslashes($Name)."', '".addslashes($Comment)."','".$Email."' ,'".$Status."','".date('Y-m-d H:i:s')."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateFeedback($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update feedback set Name = '".addslashes($Name)."', Comment = '".addslashes($Comment)."', Email = '".$Email."', Status = '".$Status."'  where feedbackID = '".$feedbackID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function getFeedback($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and feedbackID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from feedback ".$sql." order by Email desc" ;
		return $this->query($sql, 1);
	}

	function changeFeedbackStatus($feedbackID)
	{
		$sql="select * from feedback where feedbackID='".$feedbackID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update feedback set Status='$Status' where feedbackID='".$feedbackID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteFeedback($feedbackID)
	{
		
		$sql = "delete from feedback where feedbackID = '".$feedbackID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListFeedback($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and f.feedbackID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (p.Name like '".$SearchKey."%' or f.Comment like '%".$SearchKey."%' or f.Name like '%".$SearchKey."%'  or f.Email like '%".$SearchKey."%'  )"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by f.feedbackID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select f.*,p.Name as ProductName from feedback f inner join products p on f.ProductID=p.ProductID ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}




}
?>
