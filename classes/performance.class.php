<?
class performance extends dbClass
{
		//constructor
		function performance()
		{
			$this->dbClass();
		} 
		
		////////// Component Management Start ///////////////

		function addComponent($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "insert into h_component (locationID, heading, detail, Status, updatedDate) values('".$_SESSION['locationID']."', '".mysql_real_escape_string(strip_tags($heading))."', '".addslashes($detail)."','".mysql_real_escape_string(strip_tags($Status))."', '".mysql_real_escape_string(strip_tags($Config['TodayDate']))."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateComponent($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			if(!empty($compID)){
				$sql = "update h_component set heading='".mysql_real_escape_string(strip_tags($heading))."', detail = '".addslashes($detail)."' ,Status = '".mysql_real_escape_string(strip_tags($Status))."', updatedDate = '".mysql_real_escape_string(strip_tags($Config['TodayDate']))."'  where compID = '".mysql_real_escape_string($compID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function updateComponentWeightage($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			if(!empty($compID)){
				$AddWt = '';
				for($i=1;$i<=3;$i++){
					$Weightage = $arryDetails['Weightage'.$i];
					//if($Weightage!=''){
						$AddWt .= ", Weightage".$i."='".$Weightage."'";
					//}
				}
				$sql = "update h_component_cat set catName='".addslashes($catName)."' ".$AddWt.", updatedDate = '".$Config['TodayDate']."'  where catID = '".mysql_real_escape_string($catID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}
		function getComponent($id=0,$Status=0)
		{
			$sql = " where 1";
			#$sql .= (!empty($id))?(" and compID = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($id))?(" and compID = '".mysql_real_escape_string($id)."'"):(" ");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_component ".$sql." order by compID Asc" ; 
			return $this->query($sql, 1);
		}

		function GetComponentWeightage($id=0,$Status=0)
		{
			$sql = " where 1";
			#$sql .= (!empty($id))?(" and catID = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($id))?(" and catID = '".mysql_real_escape_string($id)."'"):(" ");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_component_cat ".$sql." order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		function GetWeightageByComponent($catID, $compID)
		{
			$sql = "select ct.Weightage".$compID." as KraWeightage from h_component_cat ct where ct.catID='".mysql_real_escape_string($catID)."'";
			return $this->query($sql, 1);
		}

		function changeComponentStatus($compID)
		{
			if(!empty($compID)){
				$sql="select * from h_component where compID='".mysql_real_escape_string($compID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{

					if($rs[0]['Status']==1){
						$Status=0; 
					}else{
						$Status=1;
					}
						
					$sql="update h_component set Status='$Status' where compID='".mysql_real_escape_string($compID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteComponent($compID)
		{
			if(!empty($compID)){
				$sql = "delete from h_component where compID = '".mysql_real_escape_string($compID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
		function  ListComponent($id=0, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			#$strAddQuery .= (!empty($id))?(" and compID='".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$strAddQuery .= (!empty($id))?(" and compID='".mysql_real_escape_string($id)."'"):(" ");

			if($SearchKey=='yes' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status='1'"; 
			}else if($SearchKey=='no' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status='0'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or detail like '%".$SearchKey."%')"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by compID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from h_component ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isComponentExists($heading, $compID)
		{

			$strSQLQuery ="select compID from h_component where LCASE(heading)='".strtolower(trim($heading))."'";

			$strSQLQuery .= (!empty($compID))?(" and compID != '".$compID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['compID'])) {
				return true;
			} else {
				return false;
			}


		}

		function isCategoryExists($catName, $catID)
		{

			$strSQLQuery ="select catID from h_component_cat where LCASE(catName)='".strtolower(trim($catName))."'";

			$strSQLQuery .= (!empty($catID))?(" and catID != '".$catID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['catID'])) {
				return true;
			} else {
				return false;
			}


		}

		////////// KRA Start ///////////////

		function addKra($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "insert into h_kra (locationID, heading, JobTitle, MinRating, MaxRating, Status, updatedDate) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($JobTitle)."', '".addslashes($MinRating)."', '".addslashes($MaxRating)."','".addslashes($Status)."', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}

		function updateKra($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			if(!empty($kraID)){
				$sql = "update h_kra set heading='".addslashes($heading)."', JobTitle = '".addslashes($JobTitle)."', MinRating = '".addslashes($MinRating)."', MaxRating = '".addslashes($MaxRating)."' ,Status = '".$Status."', updatedDate = '".$Config['TodayDate']."'  where kraID = '".mysql_real_escape_string($kraID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}

		function getKra($id=0,$Status=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and kraID = '".mysql_real_escape_string($id)."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_kra ".$sql." order by kraID Asc" ; 
			return $this->query($sql, 1);
		}


		function changeKraStatus($kraID)
		{
			if(!empty($kraID)){
				$sql="select * from  h_kra where kraID='".mysql_real_escape_string($kraID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{

					if($rs[0]['Status']==1){
						$Status=0; 
					}else{
						$Status=1;
					}
						
					$sql="update  h_kra set Status='$Status' where kraID='".mysql_real_escape_string($kraID)."'";
					$this->query($sql,0);
				}	
			}
			return true;

		}

		function deleteKra($kraID)
		{
			if(!empty($kraID)){
				$sql = "delete from h_kra where kraID = '".mysql_real_escape_string($kraID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
		function  ListKra($id=0, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and kraID='".$id."'"):(" and locationID='".$_SESSION['locationID']."'");

			if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status='0'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or JobTitle like '%".$SearchKey."%' or MinRating like '%".$SearchKey."%' or MaxRating like '%".$SearchKey."%')"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by kraID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from  h_kra ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isKraExists($heading, $kraID)
		{

			$strSQLQuery = "select kraID from  h_kra where LCASE(heading)='".strtolower(trim($heading))."' and locationID='".$_SESSION['locationID']."'";

			$strSQLQuery .= (!empty($kraID))?(" and kraID != '".$kraID."'"):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['kraID'])) {
				return true;
			} else {
				return false;
			}

		}

		function isKraJobTitleExists($JobTitle, $kraID)
		{

			$strSQLQuery = "select kraID from  h_kra where LCASE(JobTitle)='".strtolower(trim($JobTitle))."' and locationID='".$_SESSION['locationID']."'";

			$strSQLQuery .= (!empty($kraID))?(" and kraID != '".$kraID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['kraID'])) {
				return true;
			} else {
				return false;
			}

		}

		function getKraByJobTitle($JobTitle)
		{
			$sql = "select k.* from h_kra k where k.Status='1' and k.locationID='".$_SESSION['locationID']."' and k.JobTitle='".$JobTitle."' order by kraID Asc" ; 
			return $this->query($sql, 1);
		}


		////////// Review Start ///////////////

		function addReview($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "insert into h_review (EmpID, ReviewerID, FromDate, ToDate, ReviewDate, Status, updatedDate) values('".$EmpID."', '".$ReviewerID."', '".$FromDate."', '".$ToDate."', '".$Config['TodayDate']."','Scheduled', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}

		function updateReview($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			if(!empty($reviewID)){
				$AddRating = '';
				for($i=1;$i<=3;$i++){
					$Rating = $arryDetails['Rating'.$i];
					//if($Rating!=''){
						$AddRating .= ", Rating".$i."='".$Rating."'";
					//}
				}

				$sql = "update h_review set  Comment = '".addslashes($Comment)."' ".$AddRating." , Status = 'Being Reviewed', updatedDate = '".$Config['TodayDate']."'  where reviewID = '".mysql_real_escape_string($reviewID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getReview($id=0)
		{
			$sql = " where e.locationID='".$_SESSION['locationID']."'";
			$sql .= (!empty($id))?(" and r.reviewID = '".mysql_real_escape_string($id)."'"):("");

			$strSQLQuery = "select r.*, e.UserName, e.JobTitle, e.Email, d.Department, e2.UserName as ReviewerName, d2.Department as ReviewerDepartment,e.catID, ct.catName from h_review r inner join h_employee e on r.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID inner join h_employee e2 on r.ReviewerID=e2.EmpID left outer join  h_department d2 on e2.Department=d2.depID left outer join h_component_cat ct on e.catID=ct.catID".$sql;
			return $this->query($strSQLQuery, 1);
		}

		function deleteReview($reviewID)
		{
			if(!empty($reviewID)){
				$sql = "delete from  h_review where reviewID = '".mysql_real_escape_string($reviewID)."'";
				$rs = $this->query($sql,0);
			}

		   return true;
		}
		
		function  ListReview($id=0, $SearchKey,$SortBy,$FromDate,$ToDate,$AscDesc)
		{
			$strAddQuery = " where e.locationID='".$_SESSION['locationID']."'";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and r.reviewID='".$id."'"):(" ");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%' or e.JobTitle like '%".$SearchKey."%' or e2.UserName like '%".$SearchKey."%' or r.Status like '%".$SearchKey."%' )"):("");
			}

			/**************/
			$FromDate = DefaultDateFormat($FromDate);
			$ToDate = DefaultDateFormat($ToDate);		 
			/**************/

			$strAddQuery .= (!empty($FromDate))?(" and ( r.FromDate>='".$FromDate."' or  r.ToDate>='".$FromDate."')"):("");
			$strAddQuery .= (!empty($ToDate))?(" and (r.FromDate<='".$ToDate."' or  r.ToDate<='".$ToDate."')"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by r.reviewID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

			$strSQLQuery = "select r.*, e.UserName, e.JobTitle, e.Email, d.Department, e2.UserName as ReviewerName, d2.Department as ReviewerDepartment from h_review r inner join h_employee e on r.EmpID=e.EmpID left outer join  h_department d on e.Department=d.depID inner join h_employee e2 on r.ReviewerID=e2.EmpID left outer join  h_department d2 on e2.Department=d2.depID ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isReviewExists($heading, $reviewID)
		{

			$strSQLQuery = "select reviewID from  h_review where LCASE(heading)='".strtolower(trim($heading))."' and locationID='".$_SESSION['locationID']."'";

			$strSQLQuery .= (!empty($reviewID))?(" and reviewID != '".$reviewID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['reviewID'])) {
				return true;
			} else {
				return false;
			}


		}



}

?>
