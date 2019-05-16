<?
class video extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function video(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addVideo($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into video (heading,catID,detail,Status,Date,sort_order) values('".addslashes($heading)."','".$catID."', '".addslashes($detail)."', '".$Status."', '".date('Y-m-d H:i:s')."', '".$sort_order."')";
		$rs = $this->query($sql,0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateVideo($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update video set heading = '".addslashes($heading)."',catID = '".$catID."', detail = '".addslashes($detail)."', Status = '".$Status."', sort_order = '".$sort_order."'  where videoID = '".$videoID."'";
		$rs = $this->query($sql,0);
		if(sizeof($rs))
			return true;
		else
			return false;
	}
	function getVideo($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and videoID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from video".$sql." order by sort_order asc" ;
		return $this->query($sql, 1);
	}

	function getTopVideo($Limit)
	{
		$sql = "select * from video where Status='1' and Video!='' and showHome!='1' order by sort_order asc limit 0,".$Limit."" ;
		return $this->query($sql, 1);
	}

	function getInitailVideo()
	{
		$sql = "select * from video where Status='1' and Video!='' and showHome='1' order by sort_order asc ";
		return $this->query($sql, 1);
	}

	function showHomeVideo($videoID)
	{
			$sql="update video set showHome='1' where videoID='".$videoID."'";
			$this->query($sql,0);
			$sql="update video set showHome='0' where videoID!='".$videoID."'";
			$this->query($sql,0);
		
			return true;
	}

	function changeVideoStatus($videoID)
	{
		$sql="select * from video where videoID='".$videoID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update video set Status='$Status' where videoID='".$videoID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteVideo($id)
	{
		$strSQLQuery = "select Video,Image,Pdf from video where videoID='".$id."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		$VideoDir = '../videos/';

		if($arryRow[0]['Video'] !='' && file_exists($VideoDir.$arryRow[0]['Video']) ){						unlink($VideoDir.$arryRow[0]['Video']);	
		}


		$ImgDir = '../videos/videos_image/';

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){						unlink($ImgDir.$arryRow[0]['Image']);	
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.'thumb/'.$arryRow[0]['Image']) ){				unlink($ImgDir.'thumb/'.$arryRow[0]['Image']);
		}


		$PdfDir = '../videos/pdf/';

		if($arryRow[0]['Pdf'] !='' && file_exists($PdfDir.$arryRow[0]['Pdf']) ){						unlink($PdfDir.$arryRow[0]['Pdf']);	
		}


		$sql = "delete from video where videoID = '".$id."'";
		$rs = $this->query($sql,0);
		if(sizeof($rs))
			return true;
		else
			return false;
	}
	
	
	function  ListVideo($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and v.videoID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (v.heading like '".$SearchKey."%' or vc.Name like '".$SearchKey."%')"):("");
		}

		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by v.sort_order ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

		$strSQLQuery = "select v.*,vc.Name as Category from video v left outer join video_cat vc on v.catID=vc.catID ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function isVideoExists($heading,$videoID)
	{
		$sql ="select * from video where LCASE(heading) = '".strtolower(trim($heading))."'";
		$sql .= (!empty($videoID))?(" and videoID != '".$videoID."'"):("");

		$arryRow = $this->query($sql, 1);
		if (!empty($arryRow[0]['videoID'])) {
			return true;
		} else {
			return false;
		}
	}


	function UpdateVideoFile($Video,$videoID)
	{
			$strSQLQuery = "update video set Video='".$Video."' where videoID='".$videoID."'";
			return $this->query($strSQLQuery, 0);
	}

	function UpdateImage($Image,$videoID)
	{
			$strSQLQuery = "update video set Image='".$Image."' where videoID='".$videoID."'";
			return $this->query($strSQLQuery, 0);
	}

	function UpdatePdf($Pdf,$videoID)
	{
			$strSQLQuery = "update video set Pdf='".$Pdf."' where videoID='".$videoID."'";
			return $this->query($strSQLQuery, 0);
	}

	function getVideoByCategory($catID=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($catID))?(" and catID = '".$catID."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from video ".$sql." order by sort_order Asc" ;
		return $this->query($sql, 1);
	}
	function getVideoCategory($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and catID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from video_cat ".$sql." order by Name Asc" ;
		return $this->query($sql, 1);
	}

	function changeCategoryStatus($catID)
	{
		$sql="select * from video_cat where catID='".$catID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update video_cat set Status='$Status' where catID='".$catID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function isCategoryExists($Name,$catID=0)
	{

		$strSQLQuery ="select catID from video_cat where LCASE(Name)='".strtolower(trim($Name))."'";

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
		$strSQLQuery = "delete from video_cat where catID='".$catID."'"; 
		$this->query($strSQLQuery, 0);

	}


	function AddCategory($arryDetails)
	{ 
		extract($arryDetails);
		$strSQLQuery = "insert into video_cat (Name,Status) values('".addslashes($Name)."','".$Status."')";
		$this->query($strSQLQuery, 0);
		return 1;

	}
	function UpdateCategory($arryDetails)
	{
		extract($arryDetails);
		$strSQLQuery = "update video_cat set Name='".addslashes($Name)."', Status='".$Status."' where catID='".$catID."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}


}
?>
