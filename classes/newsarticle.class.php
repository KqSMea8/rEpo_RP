<?
class news extends dbClass
{
	//constructor
	function news()
	{
		$this->dbClass();
	}
	function  ListNews($arryDetails)
	{
		extract($arryDetails);
		$strAddQuery = '';
		$SearchKey   = strtolower(trim($key));
		$strAddQuery .= (!empty($id))?(" where w.NewsID='".mysql_real_escape_string($id)."'"):(" where 1 ");
		$strAddQuery .= (!empty($CategoryID))?(" and c.CategoryID='".mysql_real_escape_string($CategoryID)."'"):("");
		if($SearchKey=='active' && ($sortby=='w.Status' || $sortby=='') ){
			$strAddQuery .= " and w.Status='1'";
		}else if($SearchKey=='inactive' && ($sortby=='w.Status' || $sortby=='') ){
			$strAddQuery .= " and w.Status='0'";
		}else if($sortby != ''){
		if($sortby=='w.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (w.Heading like '%".$SearchKey."%' or c.NewsCategoryName like '%".$SearchKey."%') " ):("");			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by c.OrderBy,w.Heading ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");		
			$strSQLQuery = "select w.NewsID,w.Heading,w.Summary,w.Status,w.Detail,w.Image,w.Date,c.NewsCategoryName from news w  inner join news_cat c on w.CategoryID=c.CategoryID ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
	}

	function  GetNews($NewsID,$Status)
	{
		$strSQLQuery = "select w.* from news w ";
		$strSQLQuery .= (!empty($NewsID))?(" where w.NewsID='".mysql_real_escape_string($NewsID)."'"):(" where 1 ");
		$strSQLQuery .= ($Status>0)?(" and w.Status='".mysql_real_escape_string($Status)."'"):("");
		return $this->query($strSQLQuery, 1);
	}

	function RemoveNews($NewsID) {
		global $Config;
		$objFunction=new functions();
		if(!empty($NewsID)){
			$sql = "select Image from news where NewsID='".mysql_real_escape_string($NewsID)."'"; 
			$arryNews = $this->query($sql, 1);

			if($arryNews[0]['Image'] !='' ){				
				$objFunction->DeleteFileStorage($Config['NewsDir'],$arryNews[0]['Image']);		
			} 

			$sql = "DELETE from news where NewsID = '" . mysql_real_escape_string($NewsID) . "'";
			$this->query($sql, 0);    
		}
		return 1;
	}

	function changeNewsStatus($NewsID)
	{
		if(!empty($NewsID)){
			$sql="select NewsID,Status from news where NewsID='".mysql_real_escape_string($NewsID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
				$Status=0;
				else
				$Status=1;
				$sql="update news set Status='$Status' where NewsID='".mysql_real_escape_string($NewsID)."'";
				$this->query($sql,0);
			}
		}
		return true;
	}

	function MultipleNewsStatus($NewsID,$Status)
	{
		$sql="select NewsID from news where NewsID in (".$NewsID.") and Status!='".$Status."'";
		$arryRow = $this->query($sql);
		if(sizeof($arryRow)>0){
			$sql="update news set Status='".$Status."' where NewsID in (".$NewsID.")";
			$this->query($sql,0);
		}
		return true;
	}

	function AddNews($arryDetails,$imageName)
	{
		global $Config;
		@extract($arryDetails);			
		$strSQLQuery = "insert into news (CategoryID, Heading,NewsUrl,Summary, Detail, Status, Image,Date, MetaTitle, MetaKeywords, MetaDescription) values('".mysql_real_escape_string(strip_tags($CategoryName))."', '".mysql_real_escape_string(strip_tags($Heading))."', '".mysql_real_escape_string(strip_tags($NewsUrl))."', '" . mysql_real_escape_string(strip_tags($Summary)) . "',  '".addslashes($Content)."',  '".mysql_real_escape_string(strip_tags($Status))."' ,  '".mysql_real_escape_string(strip_tags($imageName))."','".addslashes($Date)."', '".mysql_real_escape_string(strip_tags($MetaTitle))."', '".mysql_real_escape_string(strip_tags($MetaKeywords))."', '".mysql_real_escape_string(strip_tags($MetaDescription))."')";
		$this->query($strSQLQuery, 0);
		$NewsID = $this->lastInsertId();
		return $NewsID;
	}

	function UpdateNews($arryDetails,$imageName){		
		@extract($arryDetails);
		if(!empty($imageName)){
			$strSQLQuery = "UPDATE  news SET CategoryID = '". mysql_real_escape_string(strip_tags($CategoryName)) ."',Heading = '". mysql_real_escape_string(strip_tags($Heading)) ."' ,NewsUrl = '". mysql_real_escape_string(strip_tags($NewsUrl)) ."' ,Summary = '". mysql_real_escape_string(strip_tags($Summary)) ."',Detail='".addslashes($Content)."',Image='".mysql_real_escape_string(strip_tags($imageName))."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "',Date='".mysql_real_escape_string(strip_tags($Date))."',MetaTitle = '". mysql_real_escape_string(strip_tags($MetaTitle)) ."',MetaKeywords = '". mysql_real_escape_string(strip_tags($MetaKeywords)) ."',MetaDescription = '". mysql_real_escape_string(strip_tags($MetaDescription)) ."' WHERE NewsID = '" .  mysql_real_escape_string($NewsID) . "' ";
		}else{				
			$strSQLQuery = "update news set  CategoryID='".mysql_real_escape_string(strip_tags($CategoryName))."', Heading='".mysql_real_escape_string(strip_tags($Heading))."' ,NewsUrl = '". mysql_real_escape_string(strip_tags($NewsUrl)) ."' , Summary = '". mysql_real_escape_string(strip_tags($Summary)) ."',Detail='".addslashes($Content)."', Status='".mysql_real_escape_string(strip_tags($Status))."',Date='".mysql_real_escape_string(strip_tags($Date))."',MetaTitle = '". mysql_real_escape_string(strip_tags($MetaTitle)) ."',MetaKeywords = '". mysql_real_escape_string(strip_tags($MetaKeywords)) ."',MetaDescription = '". mysql_real_escape_string(strip_tags($MetaDescription)) ."' WHERE NewsID = '" .  mysql_real_escape_string($NewsID) . "' ";
		}
		$this->query($strSQLQuery, 0);			
	}

	function categoryNametById($CategoryID){
		if(!empty($CategoryID)){				
			$strSQLQuery = "SELECT * FROM news where NewsID='".$CategoryID."'";
			$results = $this->query($strSQLQuery,1);
			return $results;
		}			
	}

	function UpdateDocWorkFlow($Image, $NewsID) {
		$strSQLQuery = "update news set Image='" . $Image . "' where NewsID='" . $NewsID . "'";	
		$this->query($strSQLQuery, 1);
		return true;
	}
	 
	function  NewsListing($CategoryID)
	{
		if($CategoryID>0){
			$addsql = " and w.CategoryID='".$CategoryID."'";
		}
		$strSQLQuery = "select w.NewsID,w.Heading,w.Summary,w.Status,w.Detail,w.Image,w.Date,c.CategoryName,c.CategoryID from news w inner join news_cat c on w.CategoryID=c.CategoryID where  w.Status='1' ".$addsql." order by c.OrderBy,w.NewsID Asc";
		return $this->query($strSQLQuery, 1);
	}

	function  ListContentbyHeadingId($NewsID)
	{
		$strSQLQuery ="select Heading,Summary,Content,Image from news  where NewsID='" . $NewsID . "'";
		return $this->query($strSQLQuery, 1);
	}

	/************* News Category Start ************/

	function  ListNewsCategory($arryDetails)
	{
		extract($arryDetails);
		$strAddQuery = " where 1";
		$SearchKey   = strtolower(trim($key));
		$strAddQuery .= (!empty($id))?(" and CategoryID='".$id."'"):("");
		if($SearchKey=='active' && ($sortby=='Status' || $sortby=='') ){
			$strAddQuery .= " and Status='1'";
		}else if($SearchKey=='inactive' && ($sortby=='Status' || $sortby=='') ){
			$strAddQuery .= " and Status='0'";
		}else if($sortby != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (NewsCategoryName like '%".$SearchKey."%') " ):("");
		}
		$strAddQuery .= (!empty($Status))?(" and Status='".$Status."'"):("");
		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by OrderBy,NewsCategoryName ");
		$strAddQuery .= (!empty($asc))?($asc):(" Asc");
		$strSQLQuery = "select * from news_cat  ".$strAddQuery;
		return $this->query($strSQLQuery, 1);
	}

	function  GetNewsCategory($CategoryID,$Status)
	{
		$strAddQuery = " where 1 ";
		$strAddQuery .= (!empty($CategoryID))?(" and CategoryID='".$CategoryID."'"):("");
		$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");
		$strSQLQuery = "select * from news_cat  ".$strAddQuery." order by OrderBy,NewsCategoryName ";
		return $this->query($strSQLQuery, 1);
	}
		
	function AddNewsCategory($arryDetails)
	{			
		global $Config;
		extract($arryDetails);
		$strSQLQuery = "insert into news_cat (NewsCategoryName, Status, OrderBy) values( '".mysql_real_escape_string(strip_tags($NewsCategoryName))."', '".mysql_real_escape_string(strip_tags($Status))."', '".mysql_real_escape_string(strip_tags($OrderBy))."')";
		$this->query($strSQLQuery, 0);
		$CategoryID = $this->lastInsertId();			
		return $CategoryID;
	}

	function UpdateNewsCategory($arryDetails){
		global $Config;
		extract($arryDetails);
		$strSQLQuery = "update news_cat set NewsCategoryName='".mysql_real_escape_string(strip_tags($NewsCategoryName))."', Status='".mysql_real_escape_string(strip_tags($Status))."', OrderBy='".mysql_real_escape_string(strip_tags($OrderBy))."' where CategoryID='".$CategoryID."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function RemoveNewsCategory($CategoryID)
	{   
            
		$strSQLQuery = "delete from news_cat where CategoryID='".mysql_real_escape_string($CategoryID)."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function changeNewsCategoryStatus($CategoryID)
	{
		$sql="select * from news_cat where CategoryID='".$CategoryID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
			$Status=0;
			else
			$Status=1;				
			$sql="update news_cat set Status='$Status' where CategoryID='".$CategoryID."'";
			$this->query($sql,0);
			return true;
		}
	}

	function isNewsCategoryExists($CategoryName,$CategoryID=0)
	{
		$strSQLQuery = (!empty($CategoryID))?(" and CategoryID != '".$CategoryID."'"):("");
		$strSQLQuery = "select CategoryID from news_cat where LCASE(NewsCategoryName)='".strtolower(trim($CategoryName))."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['CategoryID'])) {
			return true;
		} else {
			return false;
		}
	}

	function isNewsHeadingExists($Heading,$NewsID=0)
	{
		$strSQLQuery = (!empty($NewsID))?(" and NewsID != '".$NewsID."'"):("");
		$strSQLQuery = "select NewsID from news where LCASE(Heading)='".strtolower(trim($Heading))."'".$strSQLQuery;
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['NewsID'])) {
			return true;
		} else {
			return false;
		}
	}

       function GetCatName($Status=''){
      	      $strAddQuery='';
      	       $strAddQuery .= (!empty($Status))?(" and c.Status='".$Status."'"):("");
      	       $strSQLQuery = "select NewsCategoryName,CategoryID from news_cat c ".$strAddQuery;
			   return $this->query($strSQLQuery, 1);
      	       
      }

	/*************News Category End ************/


}
?>
