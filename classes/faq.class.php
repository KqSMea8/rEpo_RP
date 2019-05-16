<?
class faq extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function faq(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addFaq($arryAnswers)
	{
		@extract($arryAnswers);	
		$sql = "insert into faq (Question,Answer,catID,Status) values('".addslashes($Question)."', '".addslashes($Answer)."','".$catID."','".$Status."')";
		$rs = $this->query($sql,0);
		$lastInsertId = $this->lastInsertId();

		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function updateFaq($arryAnswers)
	{
		@extract($arryAnswers);	
		$sql = "update faq set Question = '".addslashes($Question)."', Answer = '".addslashes($Answer)."',catID = '".$catID."',Status = '".$Status."'  where faqID = '".$faqID."'";
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function getFaq($id=0,$Status=0,$catID)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and faqID = '".$id."'"):("");
		$sql .= (!empty($catID))?(" and catID = '".$catID."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from faq f1 ".$sql." order by faqID desc" ;
	
		return $this->query($sql, 1);
	}


	function countFaq()
	{
		$sql = "select sum(1) as NumFaq from faq where Status='1' " ;
		return $this->query($sql, 1);
	}


	function changeFaqStatus($faqID)
	{
		$sql="select * from faq where faqID='".$faqID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update faq set Status='$Status' where faqID='".$faqID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteFaq($id)
	{
		$sql = "delete from faq where faqID = '".$id."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;
	}
	
	function  ListFaq($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and f.faqID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (f.Question like '".$SearchKey."%' or c.Name like '".$SearchKey."%')"):("");
		}

		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by f.Question ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

		$strSQLQuery = "select f.*,c.Name as Category from faq f left outer join faq_cat c on f.catID=c.catID ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function isFaqExists($Question,$FaqID)
	{

		$strSQLQuery ="select * from faq where LCASE(Question)='".strtolower(trim($Question))."' ";

		$strSQLQuery .= (!empty($FaqID))?(" and faqID != '".$FaqID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['faqID'])) {
			return true;
		} else {
			return false;
		}

	}

	/***********************************/

	function getFaqCategory($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and catID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from faq_cat ".$sql." order by Name Asc" ;
		return $this->query($sql, 1);
	}

	function changeCategoryStatus($catID)
	{
		$sql="select * from faq_cat where catID='".$catID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update faq_cat set Status='$Status' where catID='".$catID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function isCategoryExists($Name,$catID=0)
	{

		$strSQLQuery ="select catID from faq_cat where LCASE(Name)='".strtolower(trim($Name))."'";

		$strSQLQuery .= (!empty($catID))?(" and catID != '".$catID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['catID'])) {
			return true;
		} else {
			return false;
		}
	}

	function RemoveCategory($catID)
	{
		$strSQLQuery = "delete from faq_cat where catID='".$catID."'"; 
		$this->query($strSQLQuery, 0);

	}


	function AddCategory($arryDetails)
	{ 
		extract($arryDetails);
		$strSQLQuery = "insert into faq_cat (Name,Status) values('".addslashes($Name)."','".$Status."')";
		$this->query($strSQLQuery, 0);
		return 1;

	}
	function UpdateCategory($arryDetails)
	{
		extract($arryDetails);
		$strSQLQuery = "update faq_cat set Name='".addslashes($Name)."', Status='".$Status."' where catID='".$catID."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}


}
?>
