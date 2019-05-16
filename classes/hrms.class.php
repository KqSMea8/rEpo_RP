<?
class common extends dbClass
{
		//constructor
		function common()
		{
			$this->dbClass();
		} 
		
		///////  Attribute Management //////

		function  GetAttributeValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' and locationID='".$_SESSION['locationID']."'"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID='".$_SESSION['locationID']."'"):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	

		function GetCrmAttribute($attribute_name,$OrderBy)
		{

			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1'"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function getAllCrmAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_attribute_value ".$sql." order by value_id asc" ;

			return $this->query($sql, 1);
		}


		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id in(".$id.")"):("");
		
			$strSQLQuery = "select * from h_attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
		
		function addUpdateAttribute($attribute_value,$attribute_id)
		{
			$strSQLQuery ="select value_id from h_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and attribute_id='".$attribute_id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['value_id'])) {
				$value_id = $arryRow[0]['value_id'];
			}else{ $Status=1;
			$sql = "insert into h_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$this->query($sql, 0);
			$value_id = $this->lastInsertId();
			}
			return $value_id;

		}

	
		function addAttribute($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into h_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function updateAttribute($arryAtt)
		{
			@extract($arryAtt);	
			if(!empty($value_id)){
				$sql = "update h_attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',Status = '".$Status."'  where value_id = '".$value_id."'"; 
				$rs = $this->query($sql,0);
			}				
			return true;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from h_attribute_value where Status=1" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			if(!empty($value_id)){
				$sql="select * from h_attribute_value where value_id='".$value_id."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_attribute_value set Status='$Status' where value_id='".$value_id."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteAttribute($id)
		{
			if(!empty($id)){
				$sql = "delete from h_attribute_value where value_id = '".mysql_real_escape_string($id)."'";
				$rs = $this->query($sql,0);
			}

			return true;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from h_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and locationID='".$_SESSION['locationID']."'";

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}


		function GetEmpCategory()
		{
			$sql = "select * from  h_component_cat where Status='1' order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		function GetEmpCategoryName($catID)
		{
			$sql = "select * from h_component_cat where Status='1' and catID='".$catID."'" ; 
			return $this->query($sql, 1);
		}


		////////////Education Attribute Start ///// 
		function  GetAttribMultiple($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name in(".$attribute_name.") and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}



		function  GetAttribValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}
		function getAttrib($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}

		function isAttribExists($attribute_value,$attribute_id,$value_id)
		{

				$strSQLQuery ="select value_id from h_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' ";

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}

		////////////Document Management Start ///// 

		function addDocument($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "insert into h_document (locationID, heading, detail, publish, AdminID, AdminType, docDate) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($detail)."','".addslashes($publish)."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateDocument($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			if(!empty($documentID)){
				$sql = "update h_document set heading='".addslashes($heading)."', detail = '".addslashes($detail)."' ,publish = '".$publish."',AdminID = '".$_SESSION['AdminID']."',AdminType = '".$_SESSION['AdminType']."',docDate = '".$Config['TodayDate']."'  where documentID = '".$documentID."'"; 
				
				$rs = $this->query($sql,0);
			}	

			return true;

		}


		function getDocument($id=0,$EmpID,$publish=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and documentID = '".mysql_real_escape_string($id)."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($EmpID))?(" and EmpID = '".mysql_real_escape_string($EmpID)."'"):("");
			$sql .= (!empty($publish) && $publish == 1)?(" and publish = '".$publish."'"):("");

			$sql = "select * from h_document ".$sql." order by documentID desc" ; 
			return $this->query($sql, 1);
		}

		function getActiveDocument($Limit)
		{
			$LimitSql = (!empty($Limit))?(" Limit 0,".$Limit):("");

			$sql = "select documentID,heading,document from h_document where publish='1' and document!='' order by documentID desc ".$LimitSql ;
			return $this->query($sql, 1);
		}

		function changeDocumentPublish($documentID)
		{
			if(!empty($documentID)){
				$sql="select * from h_document where documentID='".$documentID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{

					if($rs[0]['publish']==1){
						$publish=0; $_SESSION['mess_document'] = "Document has been published successfully.";
					}else{
						$publish=1; $_SESSION['mess_document'] = "Document has been unpublished.";
					}
						
					$sql="update h_document set publish='$publish' where documentID='".$documentID."'";
					$this->query($sql,0);
				}
			}

			return true;

		}

		function deleteDocument($documentID)
		{
			global $Config;
			$objFunction=new functions();
			if(!empty($documentID)){
				$strSQLQuery = "select document from h_document where documentID='".mysql_real_escape_string($documentID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
							 
				 
				if($arryRow[0]['document'] !=''){			
					$objFunction->DeleteFileStorage($Config['H_DocumentDir'],$arryRow[0]['document']);	
				}

				$sql = "delete from h_document where documentID = '".mysql_real_escape_string($documentID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
		function  ListDocument($id=0, $EmpID, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and documentID='".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");

			if($SearchKey=='yes' && ($SortBy=='publish' || $SortBy=='') ){
					$strAddQuery .= " and publish='1'"; 
			}else if($SearchKey=='no' && ($SortBy=='publish' || $SortBy=='') ){
					$strAddQuery .= " and publish='0'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or detail like '%".$SearchKey."%')"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by documentID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

			$strSQLQuery = "select * from h_document ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function UpdateDocumentFile($document,$documentID)
		{
			if(!empty($documentID) && !empty($document)){
				$strSQLQuery = "update h_document set document='".$document."' where documentID='".$documentID."'";
				return $this->query($strSQLQuery, 0);
			}
		}


		function isDocumentExists($heading, $documentID)
		{

			$strSQLQuery ="select * from h_document where LCASE(heading)='".strtolower(trim($heading))."'";

			$strSQLQuery .= (!empty($documentID))?(" and documentID != '".$documentID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['documentID'])) {
				return true;
			} else {
				return false;
			}


		}

		////////////Tax Document Start ///////

		function getTaxDocument($id=0,$EmpID,$publish=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and documentID = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");
			$sql .= (!empty($publish) && $publish == 1)?(" and publish = '".$publish."'"):("");

			$sql = "select * from h_tax_form ".$sql." order by documentID Asc" ; 
			return $this->query($sql, 1);
		}

		function updateTaxDocument($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	

			$arryDocument = $this->getTaxDocument('','','');
			if (!empty($arryDocument[0]['documentID'])) {
				$sql = "update h_tax_form set heading='".addslashes($heading)."', detail = '".addslashes($detail)."' ,publish = '".$publish."',AdminID = '".$_SESSION['AdminID']."',AdminType = '".$_SESSION['AdminType']."',docDate = '".$Config['TodayDate']."'  where documentID = '".$arryDocument[0]['documentID']."'";
				$rs = $this->query($sql,0);
				$documentID = $arryDocument[0]['documentID'];
			}else{
				$sql = "insert into h_tax_form (locationID, heading, detail, publish, AdminID, AdminType, docDate) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($detail)."','".addslashes($publish)."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."' )"; 
			
				$this->query($sql, 0);
				$documentID = $this->lastInsertId();
			}
				
			return $documentID;

		}

		function UpdateTaxFile($document,$documentID)
		{
			if(!empty($documentID) && !empty($document)){
				$strSQLQuery = "update h_tax_form set document='".$document."' where documentID='".$documentID."'";
				return $this->query($strSQLQuery, 0);
			}
		}



		////////////News Management Start ///// 

		function addNews($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_news (heading,detail,newsDate,Status) values('".mysql_real_escape_string(strip_tags($heading))."', '".addslashes($detail)."','".mysql_real_escape_string(strip_tags($newsDate))."', '".mysql_real_escape_string(strip_tags($Status))."')";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateNews($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($newsID)){
				$sql = "update h_news set heading = '".mysql_real_escape_string(strip_tags($heading))."', detail = '".addslashes($detail)."', newsDate = '".mysql_real_escape_string(strip_tags($newsDate))."', Status = '".mysql_real_escape_string(strip_tags($Status))."'  where newsID = '".mysql_real_escape_string(strip_tags($newsID))."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;
		}

		function getNews($id=0,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and newsID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_news ".$sql." order by newsDate desc" ;
			return $this->query($sql, 1);
		}

		function getActiveNews($Limit)
		{
			$LimitSql = (!empty($Limit))?(" Limit 0,".$Limit):("");

			$sql = "select newsID,heading,newsDate from h_news where Status='1'  order by newsDate desc ".$LimitSql ;
			return $this->query($sql, 1);
		}
		function changeNewsStatus($newsID)
		{
			if(!empty($newsID)){
				$sql="select * from h_news where newsID='".mysql_real_escape_string($newsID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_news set Status='$Status' where newsID='".mysql_real_escape_string($newsID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteNews($newsID)
		{
			global $Config;			
			$objFunction=new functions();
			if(!empty($newsID)){
				$strSQLQuery = "select Image from h_news where newsID='".mysql_real_escape_string($newsID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				 
				if($arryRow[0]['Image'] !='' ){
					$objFunction->DeleteFileStorage($Config['NewsDir'],$arryRow[0]['Image']);
				}
				/**************/
				$arryDocument = $this->GetNewsDoc($newsID,'News');
				foreach($arryDocument as $key=>$values){                
					if($values['Document'] !=''){
						$objFunction->DeleteFileStorage($Config['NewsDir'],$values['Document']);
					}
				}	 				 
				/*************/
				$sql1 = "delete from h_news_doc where newsID = '".mysql_real_escape_string($newsID)."'";
				$rs1 = $this->query($sql1,0);

				$sql = "delete from h_news where newsID = '".mysql_real_escape_string($newsID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
		function  ListNews($arryDetails){
			extract($arryDetails);
			global $Config;
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" and newsID='".$id."'"):("");


			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '".$SearchKey."%' or newsDate like '%".$SearchKey."%')"):("");
			}

			/**************/
			$FromDate = DefaultDateFormat($FromDate);
			$ToDate = DefaultDateFormat($ToDate);		 
			/**************/

			$strAddQuery .= (!empty($FromDate))?(" and newsDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and newsDate<='".$ToDate."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by newsDate ");
			$strAddQuery .= (!empty($asc))?($asc):(" Desc ");

			if($Config['GetNumRecords']==1){
				$Columns = " count(newsID) as NumCount ";				
			}else{				
				$Columns = " * ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}				
			}

			$strSQLQuery = "select ".$Columns." from h_news ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function UpdateImage($imageName,$newsID)
		{
			if(!empty($newsID) && !empty($imageName)){
				$strSQLQuery = "update h_news set Image='".$imageName."' where newsID='".$newsID."'";
				return $this->query($strSQLQuery, 0);
			}
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

		function AddNewsDoc($newsID, $Document, $DocType, $DocumentTitle){   
			global $Config;
			$strSQLQuery = "insert into h_news_doc (newsID, DocType, Document, DocumentTitle, AddedDate) values('".$newsID."', '".mysql_real_escape_string($DocType)."', '".mysql_real_escape_string($Document)."', '".mysql_real_escape_string($DocumentTitle)."','".$Config['TodayDate']."')";
			$this->query($strSQLQuery, 0);
			return 1;
		}

		function  GetNewsDoc($newsID,$DocType){
			if(!empty($newsID)){
				$strSQLQuery = "select * from h_news_doc where newsID= '".mysql_real_escape_string($newsID)."' and DocType= '".mysql_real_escape_string($DocType)."' order by DocID Asc";
				return $this->query($strSQLQuery, 1);
			}
		}

		function RemoveNewsDoc($DocID,$Dir)
		{
				$objFunction=new functions();
				global $Config;

				$strSQLQuery = "select Document from h_news_doc where DocID='".mysql_real_escape_string($DocID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
							 
				 
				if($arryRow[0]['Document'] !='' ){	
					$objFunction->DeleteFileStorage($Config['NewsDir'],$arryRow[0]['Document']);	
				}

				$sql = "delete from h_news_doc where DocID='".mysql_real_escape_string($DocID)."'"; 
				$rs = $this->query($sql,0);

				if(sizeof($rs))
					return true;
				else
					return false;

		}
		
		////////////Department Management Start ///// 

		function addDepartment($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_department (Division,Department,Status) values('".$Division."', '".addslashes($Department)."', '".$Status."')";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateDepartment($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($depID)){
				$sql = "update h_department set Division = '".$Division."',Department = '".addslashes($Department)."', Status = '".$Status."'  where depID = '".$depID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}
		function getDepartment($id=0,$Division,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and d.depID = '".$id."'"):("");
			$sql .= (!empty($Division))?(" and d.Division = '".$Division."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and d.Status = '".$Status."'"):("");

			 $sql = "select d.*,e.EmpID, e.UserName,e.Email,e.JobTitle from h_department d left outer join h_employee e on (d.depID=e.Department and e.DeptHead='1' and e.locationID='".$_SESSION['locationID']."') ".$sql." group by d.depID  order by d.depID Asc " ;
			return $this->query($sql, 1);
		}

		function getOtherHead($id=0,$Division)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and d.depID = '".$id."'"):("");
			$sql .= (!empty($Division))?(" and d.Division = '".$Division."'"):("");

			$sql = "select e.EmpID, e.UserName,e.Email,e.JobTitle from h_department d inner join h_employee e on (d.depID=e.Department and e.DeptHead='0' and e.OtherHead='1' and e.locationID='".$_SESSION['locationID']."') ".$sql."   order by e.UserName Asc " ;
			return $this->query($sql, 1);
		}
		


		function getAllHead($Department)
		{
			$sql = "select e.Email from h_employee e where e.Department='".$Department."' and (e.DeptHead='1' or e.OtherHead='1') and e.locationID='".$_SESSION['locationID']."'" ; 
			return $this->query($sql, 1);
		}

		function IsDeptHead($EmpID)
		{
			$sql = "select e.EmpID from h_department d inner join h_employee e on d.depID=e.Department where e.EmpID='".$EmpID."'  and (e.DeptHead='1' or e.OtherHead='1') and e.locationID='".$_SESSION['locationID']."'";

			$rs = $this->query($sql);

			if(!empty($rs[0]['EmpID'])){
				return true;
			}
		}

		function changeDepartmentStatus($depID)
		{
			if(!empty($depID)){
				$sql="select * from h_department where depID='".$depID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_department set Status='$Status' where depID='".$depID."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteDepartment($depID)
		{
			if(!empty($depID)){
				$sql = "delete from h_department where depID = '".mysql_real_escape_string($depID)."'";
				$rs = $this->query($sql,0);
			}
			
			return true;

		}
		
		function isDepartmentExists($Department,$depID)
		{

			$strSQLQuery ="select depID from h_department where LCASE(Department)='".strtolower(trim($Department))."'";
			#if(!empty($_SESSION['CmpDepartment'])) $strSQLQuery .= " and Division in (".$_SESSION['CmpDepartment'].")";

			$strSQLQuery .= (!empty($depID))?(" and depID != '".$depID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['depID'])) {
				return true;
			} else {
				return false;
			}


		}

		function addUpdateDepartment($Department)
		{
			$strSQLQuery ="select depID from h_department where LCASE(Department)='".strtolower(trim($Department))."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['depID'])) {
				$depID = $arryRow[0]['depID'];
			}else{	$Division=1; $Status=1;
			$sql = "insert into h_department (Division,Department,Status) values('".$Division."', '".addslashes($Department)."', '".$Status."')";		
			$this->query($sql, 0);
			$depID = $this->lastInsertId();
			}
			return $depID;

		}


		////////////Global Settings Start ///// 

		function UpdateGlobal($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($depID)){
				$sql = "update h_setting set Division = '".$Division."',Department = '".addslashes($Department)."', Status = '".$Status."'  where depID = '".$depID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}



	/*************************************/
	/********Employee Request ************/

	/************************Code Edit By Rajeev*******************************/
        function sendRequestEmail($arryDetails)
        {
                @extract($arryDetails);
                 global $Config;   
               
                $strSQLQuery = "select e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_employee e left outer join h_department d on e.Department=d.depID where e.EmpID = '". mysql_real_escape_string($EmpID)."'";   

                $arryRow = $this->query($strSQLQuery, 1);
             
                $htmlPrefix = $Config['EmailTemplateFolder'];
                $contents = file_get_contents($htmlPrefix."send_request.htm");
               
                $CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
                $contents = str_replace("[URL]",$Config['Url'],$contents);
                $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
                $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
                $contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
                $contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
                $contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
                $contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
                $contents = str_replace("[Subject]",mysql_real_escape_string(strip_tags($request_subject)),$contents);
                $contents = str_replace("[Message]",mysql_real_escape_string(strip_tags($request_message)),$contents);
                $contents = str_replace("[ApplyDate]",date("j M Y"),$contents);
                   
                $mail = new MyMailer();
                $mail->IsMail();           
                $mail->AddAddress($Config['AdminEmail']);
                if(!empty($Config['DeptHeadEmail'])){
                    $mail->AddCC($Config['DeptHeadEmail']);
                }
                       
                $mail->sender($Config['SiteName'], $Config['AdminEmail']);  
                $mail->Subject = $Config['SiteName']."-".mysql_real_escape_string(strip_tags($request_subject));
                $mail->IsHTML(true);
                $mail->Body = $contents; 
                //echo $Config['DeptHeadEmail']."<br>".$Config['AdminEmail'].$contents; exit;
                if($Config['Online'] == '1'){
                    $mail->Send();   
                }

           
        }
       
        function addRequest($arryDetails){  
            extract($arryDetails);   
              global $Config;   
               
                $strSQLQuery = "select e.EmpID,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_employee e left outer join h_department d on e.Department=d.depID WHERE e.EmpID = '". mysql_real_escape_string($EmpID)."'";   
                $arryRow = $this->query($strSQLQuery, 1);
           
            $strSQLQuery = "insert into h_request SET EmpID = '".mysql_real_escape_string($EmpID)."',UserName = '".mysql_real_escape_string($arryRow[0]['UserName'])."', EmpCode = '".mysql_real_escape_string($arryRow[0]['EmpCode'])."', Department = '".mysql_real_escape_string($arryRow[0]['Department'])."', Subject = '".mysql_real_escape_string(strip_tags($request_subject))."', Message = '".mysql_real_escape_string(strip_tags($request_message))."', RequestDate = '".$Config['TodayDate']."'";

            $this->query($strSQLQuery, 0);
            return 1;
    }
   

    function moveRequest($arryDetails){  
            extract($arryDetails);   
             global $Config;   

			$arryNews["heading"] = $request_subject;
			$arryNews["detail"] = $request_message;
			$arryNews["newsDate"] = $Config['TodayDate'];
			$arryNews["Status"] = 1;
			$this->addNews($arryNews);

			$sql = "update h_request set Moved = '1' where RequestID = '".$RequestID."'"; 
			$rs = $this->query($sql,0);

            return 1;
    }


     function  ListRequest($id=0,$SearchKey,$SortBy,$AscDesc,$FromDate,$ToDate)
        {
            $strAddQuery = " where 1 = 1 ";
            $SearchKey   = strtolower(trim($SearchKey));
           
            $strAddQuery .= (!empty($FromDate))?(" and RequestDate>='".mysql_real_escape_string($FromDate)."'"):("");
            $strAddQuery .= (!empty($ToDate))?(" and RequestDate<='".mysql_real_escape_string($ToDate)."'"):("");
           
            if($SortBy != ''){
                $strAddQuery .= (!empty($SearchKey))?(" and (".mysql_real_escape_string($SortBy)." like '%".$SearchKey."%')"):("");
            }else{
                $strAddQuery .= (!empty($SearchKey))?(" and (UserName like '%".mysql_real_escape_string($SearchKey)."%'  or EmpCode like '%".mysql_real_escape_string($SearchKey)."%'  or Department like '%".mysql_real_escape_string($SearchKey)."%' ) " ):("");       
            }

            $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" Order by RequestID DESC ");
             $strSQLQuery = "SELECT * FROM h_request ".$strAddQuery." ";
            //echo "=>".$strSQLQuery;
             return $this->query($strSQLQuery, 1);       
               
        }   
       
        function RemoveRequest($RequestID)
        {
            $strSQLQuery = "DELETE FROM h_request WHERE RequestID = '".mysql_real_escape_string($RequestID)."'";
            $this->query($strSQLQuery, 0);

            return 1;

        }
       function getRequest($RequestID)
        {
             $SqlCustomer = "SELECT * FROM h_request WHERE RequestID = '".mysql_real_escape_string($RequestID)."'";
            return $this->query($SqlCustomer, 1);
        }
   




    /**************************End Code**************************************************/


		////////////Shift Management Start ///// 
		function isShiftEmployeeExist($shiftID){
		
			$strSQLQuery = "select EmpID from h_employee where shiftID = '".$shiftID."' limit 0,1";
			  
			 $arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['EmpID'])) {
				return true;
			}else{
				return false;
			}
		}


		function addShift($arryDetails)
		{
			@extract($arryDetails);	
			$LunchTime = $LunchTimeHour.':'.$LunchTimeMinute;
			$sql = "insert into h_shift (locationID, shiftName, detail, Status, WorkingHourStart, WorkingHourEnd, SL_Coming, SL_Leaving, FlexTime , LunchPunch , LunchTime , ShortBreakPunch , ShortBreakLimit , ShortBreakTime , LunchPaid , ShortBreakPaid, WeekStart , WeekEnd , WeekendCount, OvertimePeriod, OvertimeHourWeek, PayrollStart, PayCycle, EarlyPunchRestrict, EarlyBreakRestrict ,EarlyLunchRestrict) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($shiftName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($WorkingHourStart)."', '".mysql_real_escape_string($WorkingHourEnd)."', '".mysql_real_escape_string($SL_Coming)."', '".mysql_real_escape_string($SL_Leaving)."', '".mysql_real_escape_string($FlexTime)."', '".mysql_real_escape_string($LunchPunch)."', '".mysql_real_escape_string($LunchTime)."', '".mysql_real_escape_string($ShortBreakPunch)."', '".mysql_real_escape_string($ShortBreakLimit)."', '".mysql_real_escape_string($ShortBreakTime)."', '".mysql_real_escape_string($LunchPaid)."', '".mysql_real_escape_string($ShortBreakPaid)."', '".mysql_real_escape_string($WeekStart)."', '".mysql_real_escape_string($WeekEnd)."', '".mysql_real_escape_string($WeekendCount)."', '".mysql_real_escape_string($OvertimePeriod)."', '".mysql_real_escape_string($OvertimeHourWeek)."', '".mysql_real_escape_string($PayrollStart)."', '".mysql_real_escape_string($PayCycle)."','" . mysql_real_escape_string($EarlyPunchRestrict) . "', '" . mysql_real_escape_string($EarlyBreakRestrict) . "', '" . mysql_real_escape_string($EarlyLunchRestrict) . "')";		
			$this->query($sql, 0);
			return true;
		}
		function updateShift($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($shiftID)){
				$LunchTime = $LunchTimeHour.':'.$LunchTimeMinute;

				$sql = "update h_shift set shiftName = '".mysql_real_escape_string($shiftName)."', detail = '".mysql_real_escape_string($detail)."', WorkingHourStart = '".mysql_real_escape_string($WorkingHourStart)."', WorkingHourEnd = '".mysql_real_escape_string($WorkingHourEnd)."', SL_Coming = '".mysql_real_escape_string($SL_Coming)."', SL_Leaving = '".mysql_real_escape_string($SL_Leaving)."', FlexTime = '".mysql_real_escape_string($FlexTime)."', Status = '".$Status."', LunchPunch = '".mysql_real_escape_string($LunchPunch)."', LunchTime = '".mysql_real_escape_string($LunchTime)."', ShortBreakPunch = '".mysql_real_escape_string($ShortBreakPunch)."', ShortBreakLimit = '".mysql_real_escape_string($ShortBreakLimit)."', ShortBreakTime = '".mysql_real_escape_string($ShortBreakTime)."',  LunchPaid = '".mysql_real_escape_string($LunchPaid)."', ShortBreakPaid = '".mysql_real_escape_string($ShortBreakPaid)."' , WeekStart = '".mysql_real_escape_string($WeekStart)."', WeekEnd = '".mysql_real_escape_string($WeekEnd)."', WeekendCount = '".mysql_real_escape_string($WeekendCount)."', OvertimePeriod = '".mysql_real_escape_string($OvertimePeriod)."', OvertimeHourWeek = '".mysql_real_escape_string($OvertimeHourWeek)."', PayrollStart = '".mysql_real_escape_string($PayrollStart)."', PayCycle = '".mysql_real_escape_string($PayCycle)."',EarlyPunchRestrict = '" . mysql_real_escape_string($EarlyPunchRestrict) . "',EarlyBreakRestrict = '" . mysql_real_escape_string($EarlyBreakRestrict) . "' , EarlyLunchRestrict = '" . mysql_real_escape_string($EarlyLunchRestrict) . "'


 where shiftID = '".$shiftID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getShift($id=0,$Status=0)
		{
			$sql = " where locationID='".$_SESSION['locationID']."'";
			$sql .= (!empty($id))?(" and shiftID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_shift ".$sql." order by shiftID asc" ;
			return $this->query($sql, 1);
		}

		function changeShiftStatus($shiftID)
		{
			if(!empty($shiftID)){
				$sql="select * from h_shift where shiftID='".mysql_real_escape_string($shiftID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_shift set Status='$Status' where shiftID='".mysql_real_escape_string($shiftID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteShift($shiftID)
		{
			if(!empty($shiftID)){
				$sql = "delete from h_shift where shiftID = '".mysql_real_escape_string($shiftID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isShiftExists($shiftName,$shiftID)
		{

			$strSQLQuery ="select * from h_shift where locationID='".$_SESSION['locationID']."' and LCASE(shiftName)='".strtolower(trim($shiftName))."'";

			$strSQLQuery .= (!empty($shiftID))?(" and shiftID != '".$shiftID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['shiftID'])) {
				return true;
			} else {
				return false;
			}


		}


		////////////Tier Management Start ///// 

		function addTier($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_tier (locationID, tierName, detail, Status, RangeFrom, RangeTo, Percentage) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($tierName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($RangeFrom)."', '".mysql_real_escape_string($RangeTo)."', '".mysql_real_escape_string($Percentage)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateTier($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($tierID)){
				$sql = "update h_tier set tierName = '".mysql_real_escape_string($tierName)."', detail = '".mysql_real_escape_string($detail)."', RangeFrom = '".mysql_real_escape_string($RangeFrom)."', RangeTo = '".mysql_real_escape_string($RangeTo)."', Percentage = '".mysql_real_escape_string($Percentage)."', Status = '".$Status."'  where tierID = '".mysql_real_escape_string($tierID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getTier($id=0,$Status=0)
		{
			$sql = " where locationID='".$_SESSION['locationID']."'";
			$sql .= (!empty($id))?(" and tierID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_tier ".$sql." order by RangeFrom asc,RangeTo asc";
			return $this->query($sql, 1);
		}

		function changeTierStatus($tierID)
		{
			if(!empty($tierID)){
				$sql="select * from h_tier where tierID='".mysql_real_escape_string($tierID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_tier set Status='$Status' where tierID='".mysql_real_escape_string($tierID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteTier($tierID)
		{
			if(!empty($tierID)){
				$sql = "delete from h_tier where tierID = '".mysql_real_escape_string($tierID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isTierNameExists($tierName,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."' and LCASE(tierName)='".strtolower(trim($tierName))."'";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}

	
		function isCommissionTierExists($RangeFrom,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."' and LCASE(RangeFrom)='".strtolower(trim($RangeFrom))."'";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");

			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}

			

		function isTierRangeExists($RangeFrom,$RangeTo,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."'  ";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");
			$strSQLQuery .= (!empty($RangeFrom))?(" and ( ".$RangeFrom.">=RangeFrom and ".$RangeFrom."<=RangeTo) "):("");
			$strSQLQuery .= (!empty($RangeTo))?(" and ( ".$RangeTo.">=RangeFrom and ".$RangeTo."<=RangeTo) "):("");

			//echo $strSQLQuery; exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}


		function isTierFromToExists($RangeFrom,$RangeTo,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."'  ";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");

			$strSQLQuery .= (!empty($RangeFrom))?(" and RangeFrom = '".$RangeFrom."'"):("");
			$strSQLQuery .= (!empty($RangeTo))?(" and RangeTo = '".$RangeTo."'"):("");

			//echo $strSQLQuery; exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}



		////////////Spiff Tier Management Start ///// 

		function addSpiffTier($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_spiff (locationID, tierName, detail, Status, SalesTarget, SpiffAmount) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($tierName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($SalesTarget)."', '".mysql_real_escape_string($SpiffAmount)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateSpiffTier($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($spiffID)){
				$sql = "update h_spiff set tierName = '".mysql_real_escape_string($tierName)."', detail = '".mysql_real_escape_string($detail)."', SalesTarget = '".mysql_real_escape_string($SalesTarget)."', SpiffAmount = '".mysql_real_escape_string($SpiffAmount)."', Status = '".$Status."'  where spiffID = '".mysql_real_escape_string($spiffID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getSpiffTier($id=0,$Status=0)
		{
			$sql = " where locationID='".$_SESSION['locationID']."'";
			$sql .= (!empty($id))?(" and spiffID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_spiff ".$sql." order by SalesTarget asc";
			return $this->query($sql, 1);
		}

		function changeSpiffTierStatus($spiffID)
		{
			if(!empty($spiffID)){
				$sql="select * from h_spiff where spiffID='".mysql_real_escape_string($spiffID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_spiff set Status='$Status' where spiffID='".mysql_real_escape_string($spiffID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteSpiffTier($spiffID)
		{
			if(!empty($spiffID)){
				$sql = "delete from h_spiff where spiffID = '".mysql_real_escape_string($spiffID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}


		function isSpiffNameExists($tierName,$spiffID)
		{

			$strSQLQuery ="select * from h_spiff where locationID='".$_SESSION['locationID']."' and LCASE(tierName)='".strtolower(trim($tierName))."'";

			$strSQLQuery .= (!empty($spiffID))?(" and spiffID != '".$spiffID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['spiffID'])) {
				return true;
			} else {
				return false;
			}


		}

		function isSpiffTargetExists($SalesTarget,$spiffID)
		{

			$strSQLQuery ="select * from h_spiff where locationID='".$_SESSION['locationID']."' and LCASE(SalesTarget)='".strtolower(trim($SalesTarget))."'";

			$strSQLQuery .= (!empty($spiffID))?(" and spiffID != '".$spiffID."'"):("");

			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['spiffID'])) {
				return true;
			} else {
				return false;
			}


		}


		


		////////////LeaveCheck Management Start ///// 

		function addLeaveCheck($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_leave_check (locationID, Heading, Status, Value) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($Heading)."', '".$Status."', '".mysql_real_escape_string($Value)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateLeaveCheck($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($checkID)){
				$sql = "update h_leave_check set Heading = '".mysql_real_escape_string($Heading)."', Value = '".mysql_real_escape_string($Value)."', Status = '".$Status."'  where checkID = '".mysql_real_escape_string($checkID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getLeaveCheck($id=0,$Status=0)
		{
			$sql = " where locationID='".$_SESSION['locationID']."'";
			$sql .= (!empty($id))?(" and checkID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_leave_check ".$sql." order by Value asc";
			return $this->query($sql, 1);
		}

		function changeLeaveCheckStatus($checkID)
		{
			if(!empty($checkID)){
				$sql="select * from h_leave_check where checkID='".mysql_real_escape_string($checkID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_leave_check set Status='$Status' where checkID='".mysql_real_escape_string($checkID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteLeaveCheck($checkID)
		{
			if(!empty($checkID)){
				$sql = "delete from h_leave_check where checkID = '".mysql_real_escape_string($checkID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isLeaveCheckNameExists($Heading,$checkID)
		{

			$strSQLQuery ="select * from h_leave_check where locationID='".$_SESSION['locationID']."' and LCASE(Heading)='".strtolower(trim($Heading))."'";

			$strSQLQuery .= (!empty($checkID))?(" and checkID != '".$checkID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['checkID'])) {
				return true;
			} else {
				return false;
			}


		}

		function isLeaveCheckValueExists($Value,$checkID)
		{

			$strSQLQuery ="select * from h_leave_check where locationID='".$_SESSION['locationID']."' and Value='".trim($Value)."'";

			$strSQLQuery .= (!empty($checkID))?(" and checkID != '".$checkID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['checkID'])) {
				return true;
			} else {
				return false;
			}


		}
		

	//----------------------------------Start Benefit  add,update,delete,view----------------------------------------
      
        function addBenefit($arryDetails)
        {
            @extract($arryDetails);    
               $sql = "insert into h_benefit(Heading,Detail,Status,ApplyAll) values('".mysql_real_escape_string(strip_tags($Heading))."', '".addslashes($Detail)."', '".mysql_real_escape_string(strip_tags($Status))."','".mysql_real_escape_string(strip_tags($ApplyAll))."')";
        
            $this->query($sql, 0);
            $lastInsertId = $this->lastInsertId();
            return $lastInsertId;

        }

        function updateBenefit($arryDetails)
        {
            @extract($arryDetails);    
            if(!empty($Bid))
            {
                $sql = "update h_benefit set Heading = '".mysql_real_escape_string(strip_tags($Heading))."', Detail = '".addslashes($Detail)."', Status = '".mysql_real_escape_string(strip_tags($Status))."', ApplyAll='".mysql_real_escape_string(strip_tags($ApplyAll))."'  where Bid= '".mysql_real_escape_string(strip_tags($Bid))."'"; 

                $rs = $this->query($sql,0);
            }
                
            return true;

        }

        function getBenefit($id=0,$Status=0)
        {
            $sql = " where 1 ";
            $sql .= (!empty($id))?(" and Bid = '".mysql_real_escape_string($id)."'"):("");
            $sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

            $sql = "select * from h_benefit ".$sql." order by Bid desc" ;
            return $this->query($sql, 1);
        }

        function getActiveBenefit($Limit)
        {
            $LimitSql = (!empty($Limit))?(" Limit 0,".$Limit):("");

            $sql = "select Bid,heading,Details from h_benefit where Status='1'  order by Bid desc ".$LimitSql ;
            return $this->query($sql, 1);
        }

        function changeBenefitStatus($Bid)
        {
               
            if(!empty($Bid)){
                $sql="select * from h_benefit where Bid='".mysql_real_escape_string($Bid)."'";                
                $rs = $this->query($sql);

                if(sizeof($rs))
                {
                    if($rs[0]['Status']==1)
                    
                        $Status=0;
                    else
                        $Status=1;
                        
                    $sql="update h_benefit set Status='$Status' where Bid='".mysql_real_escape_string($Bid)."'";
            
                                        $this->query($sql,0);
                }    
            }

            return true;

        }



        function deleteBenefit($Bid)
        {
            global $Config;
            $objConfigure=new configure();
		$objFunction=new functions();
            if(!empty($Bid)){
                $strSQLQuery = "select Document from h_benefit where Bid='".mysql_real_escape_string($Bid)."'"; 
                $arryRow = $this->query($strSQLQuery, 1);
                 

                if($arryRow[0]['Document'] !='' ){
                	$objFunction->DeleteFileStorage($Config['BenefitDir'],$arryRow[0]['Document']);  
                }

                $sql = "delete from h_benefit where Bid = '".mysql_real_escape_string($Bid)."'";
                $rs = $this->query($sql,0);
            }

            return true;



        }
        

    	function  ListBenefit($arryDetils) {
	    extract($arryDetils);
            $strAddQuery = ' where 1 ';
	    $strAddQuery .= (!empty($ApplyAll))?(" and ApplyAll='".$ApplyAll."'"):("");
             $strAddQuery .= (!empty($Status))?(" and Status='".$Status."'"):("");

            $strSQLQuery = "select * from h_benefit ".$strAddQuery;
            return $this->query($strSQLQuery, 1);

        }
                
               
        function UpdateBenefitDocument($DocumentName,$Bid)
        {              
         
            if(!empty($Bid) && !empty($DocumentName)) {
                $strSQLQuery = "update h_benefit set Document='".mysql_real_escape_string($DocumentName)."' where Bid='".mysql_real_escape_string($Bid)."'";
                return $this->query($strSQLQuery, 0);
            }
        } 
        
	function isBenefitExists($Heading,$Bid){

		$strSQLQuery ="select Bid from h_benefit where LCASE(Heading)='".strtolower(trim($Heading))."'";

		$strSQLQuery .= (!empty($Bid))?(" and Bid != '".$Bid."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['Bid'])) {
			return true;
		} else {
			return false;
		}


	}

	
	function getAllRoleGroup()
	{
		$sql = "select GroupID,group_name from h_role_group where Status=1 order by group_name asc" ; 
		return $this->query($sql, 1);
	}

   	/********Start Employee Category***************/
	function addEmpCategory($arryDetails)
        {
            @extract($arryDetails);    
              $sql = "insert into h_component_cat(catName,Status) values('".mysql_real_escape_string(strip_tags($catName))."', '".mysql_real_escape_string(strip_tags($Status))."')";
        
            $this->query($sql, 0);
            $lastInsertId = $this->lastInsertId();
            return $lastInsertId;

        }

        function updateEmpCategory($arryDetails)
        {
            @extract($arryDetails);    
            if(!empty($value_id))
            {
                $sql = "update h_component_cat set catName = '".mysql_real_escape_string(strip_tags($catName))."',Status = '".mysql_real_escape_string(strip_tags($Status))."'  where catID= '".mysql_real_escape_string(strip_tags($value_id))."'";

                $rs = $this->query($sql,0);
            }
                
            return true;

        }

        function getEmpCategoryDt($id=0,$Status=0)
        {
            $sql = " where 1 ";
            $sql .= (!empty($id))?(" and catID = '".mysql_real_escape_string($id)."'"):("");
            $sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

            $sql = "select * from h_component_cat ".$sql." order by catID desc" ; 
            return $this->query($sql, 1);
        }

        

        function changeEmpCategoryStatus($catID)
        {
            
            if(!empty($catID))
			{
                $sql="select * from h_component_cat where catID='".mysql_real_escape_string($catID)."'";                
                $rs = $this->query($sql);

                if(sizeof($rs))
                {
                    if($rs[0]['Status']==1)
                    
                        $Status=0;
                    else
                        $Status=1;
                        
                  $sql="update h_component_cat set Status='$Status' where catID='".mysql_real_escape_string($catID)."'"; 
            
                                        $this->query($sql,0);
                }    
            }

            return true;

        }



        function deleteEmpCategory($catID){          
		if(!empty($catID)){   
			$sql = "delete from h_component_cat where catID = '".mysql_real_escape_string($catID)."'";
			$rs = $this->query($sql,0);
		}
		return true;
        }
        

        function GetEmpCategoryList(){
		//$sql = "select * from  h_component_cat where Status=1 order by catID Asc" ;
		$sql = "select * from  h_component_cat  order by catID Asc" ;
		return $this->query($sql, 1);
	}  

	function isEmployeeCategoryExists($catName,$editID)
			{

				$strSQLQuery ="select catName from h_component_cat where LCASE(catName)='".strtolower(trim($catName))."'";

	$strSQLQuery .= (!empty($editID))?(" and catID != '".$editID."'"):("");
				
				$arryRow = $this->query($strSQLQuery, 1);
				
				if (!empty($arryRow[0]['catName']))
					{
					return true;
				}
				else 
				{
					return false;
				}
		}      
           /********End Employee Category***************/



}

?>
