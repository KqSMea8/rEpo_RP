<?
class news extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function news(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addNews($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into h_news (heading,detail,newsDate,Status) values('".addslashes($heading)."', '".addslashes($detail)."','".$newsDate."', '".$Status."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateNews($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update h_news set heading = '".addslashes($heading)."', detail = '".addslashes($detail)."', newsDate = '".$newsDate."', Status = '".$Status."'  where newsID = '".$newsID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function getNews($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and newsID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from h_news ".$sql." order by newsDate desc" ;
		return $this->query($sql, 1);
	}

	function changeNewsStatus($newsID)
	{
		$sql="select * from h_news where newsID='".$newsID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update h_news set Status='$Status' where newsID='".$newsID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteNews($newsID)
	{

		$strSQLQuery = "select Image from h_news where newsID='".$newsID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		if($Front > 0){
			$ImgDir = 'upload/news/'.$_SESSION['CmpID'].'/';
		}else{
			$ImgDir = '../upload/news/'.$_SESSION['CmpID'].'/';
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){	
                    unlink($ImgDir.$arryRow[0]['Image']);	
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.'thumbs/'.$arryRow[0]['Image']) ){	
                    unlink($ImgDir.'thumbs/'.$arryRow[0]['Image']);
		}

		$sql = "delete from h_news where newsID = '".$newsID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListNews($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and newsID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (heading like '".$SearchKey."%' or newsDate like '%".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by newsDate ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from h_news ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateImage($imageName,$newsID)
	{
			$strSQLQuery = "update h_news set Image='".$imageName."' where newsID='".$newsID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isNewsExists($heading,$newsID)
	{

		$strSQLQuery ="select * from h_news where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($newsID))?(" and newsID != '".$newsID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['newsID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
