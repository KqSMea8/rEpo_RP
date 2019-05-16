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
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' "):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	


		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from attribute_value v inner join attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id ='".$id."'"):("");
		
			$strSQLQuery = "select * from attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
		
		function addUpdateAttribute($attribute_value,$attribute_id)
		{
			$strSQLQuery ="select value_id from attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and attribute_id='".$attribute_id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['value_id'])) {
				$value_id = $arryRow[0]['value_id'];
			}else{ $Status=1;
			$sql = "insert into attribute_value (attribute_value,attribute_id,Status) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."')";
			$this->query($sql, 0);
			$value_id = $this->lastInsertId();
			}
			return $value_id;

		}

	
		function addAttribute($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into attribute_value (attribute_value,attribute_id,Status) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."')";
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
				$sql = "update attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',Status = '".$Status."'  where value_id = '".$value_id."'"; 
				$rs = $this->query($sql,0);
			}				
			return true;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			 $sql = "select * from attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from attribute_value where Status='1'" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			if(!empty($value_id)){
				$sql="select * from attribute_value where value_id='".$value_id."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update attribute_value set Status='$Status' where value_id='".$value_id."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteAttribute($id)
		{
			if(!empty($id)){
				$sql = "delete from attribute_value where value_id = '".mysql_real_escape_string($id)."'";
				$rs = $this->query($sql,0);
			}

			return true;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' ";

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


		////////////Tier Management Start ///// 

		function addTier($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into r_tier (tierName, detail, Status, RangeFrom, RangeTo, Percentage) values( '".mysql_real_escape_string($tierName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($RangeFrom)."', '".mysql_real_escape_string($RangeTo)."', '".mysql_real_escape_string($Percentage)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateTier($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($tierID)){
				$sql = "update r_tier set tierName = '".mysql_real_escape_string($tierName)."', detail = '".mysql_real_escape_string($detail)."', RangeFrom = '".mysql_real_escape_string($RangeFrom)."', RangeTo = '".mysql_real_escape_string($RangeTo)."', Percentage = '".mysql_real_escape_string($Percentage)."', Status = '".$Status."'  where tierID = '".mysql_real_escape_string($tierID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getTier($id=0,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and tierID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from r_tier ".$sql." order by RangeFrom asc,RangeTo asc";
			return $this->query($sql, 1);
		}

		function changeTierStatus($tierID)
		{
			if(!empty($tierID)){
				$sql="select * from r_tier where tierID='".mysql_real_escape_string($tierID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update r_tier set Status='$Status' where tierID='".mysql_real_escape_string($tierID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteTier($tierID)
		{
			if(!empty($tierID)){
				$sql = "delete from r_tier where tierID = '".mysql_real_escape_string($tierID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isTierNameExists($tierName,$tierID)
		{

			$strSQLQuery ="select * from r_tier where LCASE(tierName)='".strtolower(trim($tierName))."'";

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

			$strSQLQuery ="select * from r_tier where LCASE(RangeFrom)='".strtolower(trim($RangeFrom))."'";

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

			$strSQLQuery ="select * from r_tier where 1  ";

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

			$strSQLQuery ="select * from r_tier where 1 ";

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
			$sql = "insert into r_spiff (tierName, detail, Status, SalesTarget, SpiffAmount) values( '".mysql_real_escape_string($tierName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($SalesTarget)."', '".mysql_real_escape_string($SpiffAmount)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateSpiffTier($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($spiffID)){
				$sql = "update r_spiff set tierName = '".mysql_real_escape_string($tierName)."', detail = '".mysql_real_escape_string($detail)."', SalesTarget = '".mysql_real_escape_string($SalesTarget)."', SpiffAmount = '".mysql_real_escape_string($SpiffAmount)."', Status = '".$Status."'  where spiffID = '".mysql_real_escape_string($spiffID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getSpiffTier($id=0,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and spiffID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from r_spiff ".$sql." order by SalesTarget asc";
			return $this->query($sql, 1);
		}

		function changeSpiffTierStatus($spiffID)
		{
			if(!empty($spiffID)){
				$sql="select * from r_spiff where spiffID='".mysql_real_escape_string($spiffID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update r_spiff set Status='$Status' where spiffID='".mysql_real_escape_string($spiffID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteSpiffTier($spiffID)
		{
			if(!empty($spiffID)){
				$sql = "delete from r_spiff where spiffID = '".mysql_real_escape_string($spiffID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}


		function isSpiffNameExists($tierName,$spiffID)
		{

			$strSQLQuery ="select * from r_spiff where LCASE(tierName)='".strtolower(trim($tierName))."'";

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

			$strSQLQuery ="select * from r_spiff where LCASE(SalesTarget)='".strtolower(trim($SalesTarget))."'";

			$strSQLQuery .= (!empty($spiffID))?(" and spiffID != '".$spiffID."'"):("");

			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['spiffID'])) {
				return true;
			} else {
				return false;
			}


		}

		/*************Payment Term Start ************/

		function  ListTerm($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" and termID='".$id."'"):("");

			if($SearchKey=='active' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (termName like '%".$SearchKey."%' or Day like '%".$SearchKey."%' or Due like '%".$SearchKey."%' or CreditLimit like '%".$SearchKey."%') " ):("");		
			}
			$strAddQuery .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by termID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			$strSQLQuery = "select * from r_term  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function  GetTerm($termID,$Status)
		{

			$strAddQuery = " where 1 ";
			$strAddQuery .= (!empty($termID))?(" and termID='".$termID."'"):("");
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from r_term  ".$strAddQuery." order by termID Asc";

			return $this->query($strSQLQuery, 1);
		}		
			
		
		function AddTerm($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into r_term (termName, termDate, Due, Status, Day, CreditLimit, UpdatedDate ) values( '".addslashes($termName)."', '".$termDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."', '".addslashes($CreditLimit)."',  '".$Config['TodayDate']."')";

			$this->query($strSQLQuery, 0);

			$termID = $this->lastInsertId();
			
			return $termID;

		}


		function UpdateTerm($arryDetails){
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update r_term set termName='".addslashes($termName)."', termDate='".$termDate."',  Due='".addslashes($Due)."',  Status='".$Status."'  ,Day='".addslashes($Day)."'	,CreditLimit='".addslashes($CreditLimit)."'	, UpdatedDate = '".$Config['TodayDate']."' where termID='".$termID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

					
		
		function RemoveTerm($termID)
		{
		
			$strSQLQuery = "delete from r_term where termID='".$termID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function changeTermStatus($termID)
		{
			$sql="select * from r_term where termID='".$termID."'"; 
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update r_term set Status='$Status' where termID='".$termID."'"; 
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleTermStatus($termIDs,$Status)
		{
			$sql="select termID from r_term where termID in (".$termIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update r_term set Status='".$Status."' where termID in (".$termIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		

		function isTermExists($termName,$termID=0)
		{
			$strSQLQuery = (!empty($termID))?(" and termID != '".$termID."'"):("");
			$strSQLQuery = "select termID from r_term where LCASE(termName)='".strtolower(trim($termName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['termID'])) {
				return true;
			} else {
				return false;
			}
		}


		/*************Payment Term End ************/	

		/********************* template class **********************/
		
		function GetTemplateContent($TemplateID=0,$Status=0)
		{
			
			$sql = " where 1 ";
			$sql .= (!empty($TemplateID))?(" and TemplateID = '".$TemplateID."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from email_template ".$sql." order by TemplateID asc" ; 
			return $this->query($sql, 1);
		}

		function GetTemplateCategory($CatID)
		{
			$sql = (!empty($CatID))?(" where CatID = '".$CatID."'"):("");
			$sql = "select * from email_cat ".$sql." order by Name asc" ; 
			return $this->query($sql, 1);
		}

		function GetTemplateByCategory($CatID)
		{
			$sql = (!empty($CatID))?(" where CatID = '".$CatID."'"):("");

			 $sql = "select * from email_template ".$sql." order by TemplateID asc" ; 
			return $this->query($sql, 1);
		}

		function UpdateTemplateContent($arryDetails)
		{
			global $Config;
			extract($arryDetails);          

			 $sql="update email_template set Status='".$Status."',Content='".$TemplateContent."',subject='".$subject."',FromEmail='".$FromEmail."',ToEmail='".$ToEmail."',DaysBefore='".$DaysBefore."',MailFrequency='".$MailFrequency."' where TemplateID = '".$TemplateID."'"; 

			$this->query($sql,0);			
	    }

		/*********************end of template class **********************/

/*********************start of template uploader**********************/
		function ListTemplates()
		{
			global $Config;
			$sql = "select * from templates order by TemplateDisplayName asc" ; 
			return $this->query($sql, 1);		
	    }
		function getTemplateById($Id)
		{
			global $Config;
			$sql = "select * from templates where TemplateId ='".addslashes($Id)."' order by TemplateDisplayName asc" ; 
			return $this->query($sql, 1);		
	    }
	    
		/*function addTemplate($arryDetails) {  // comment by bhoodev 17 may 2016
			@extract($arryDetails);
			
			$response=$this->uploadfile($_FILES);
			if($response=='success'){
				$filename = $_FILES["template"]["name"];
				$name = explode(".", $filename);
				$TemplateName=$name[0];
				$Prefix = '../'; 
				$dir = $Prefix."template/".$TemplateName;  
				
				$files = scandir($dir, 1);
				
				$Thumbnail=$files[0];
				
				$sql = "INSERT INTO  templates SET TemplateName='" . addslashes($TemplateName) . "',
				TemplateDisplayName='" . addslashes($TemplateDisplayName) . "', 
				Thumbnail='" . addslashes($Thumbnail) . "', 
				TemplateType='" . addslashes($TemplateType) . "',
				Status='1' ".$sqltemp." ";
				$this->query($sql, 0);
				
			
			}
			return $response;
	
			
		}

		function updateTemplate($arryDetails) {
			@extract($arryDetails);
			
			$sql = "UPDATE  templates SET TemplateDisplayName='" . addslashes($TemplateDisplayName) . "',TemplateType='" . addslashes($TemplateType) . "' 
			 WHERE TemplateId =" . $TemplateId; 
			$this->query($sql, 0);
		}*/



	function addTemplate($arryDetails) {
                @extract($arryDetails);
               // $lastTempArray = $this->getLastTemplateId();
                //echo isset($lastTempArray[0]['TemplateId'])?$lastTempArray[0]['TemplateId']:1; 
                 $TemplateId = @$lastTempArray[0]['TemplateId']?:'null';
                       
                       $response=$this->uploadfile($_FILES);
			if($response=='success'){
                            $filename = $_FILES["template"]["name"];
                            $name = explode(".", $filename);
                            $TemplateName=$name[0];
                            $Prefix = '../'; 
                            $dir = $Prefix."template/".$TemplateName;				
                            $files = scandir($dir, 1);				
                            $Thumbnail=$files[0]; 
				/* added by Rakesh */
                          if($TemplateType == 'w'){                            
                           $EcomType='';   
                           }      
                            $sql = "INSERT INTO  templates SET TemplateName='" . addslashes($TemplateName) . "',
                            TemplateDisplayName='" . addslashes($TemplateDisplayName) . "', 
														CmpID='" . addslashes($CmpID) . "', 
                            Thumbnail='" . addslashes($Thumbnail) . "', 
                            TemplateType='" . addslashes($TemplateType) . "',
														TemplateDis='" . addslashes($TemplateDis) . "',
                            TemplatePrice='" . addslashes($TemplatePrice) . "',
                            EcomType='" . addslashes($EcomType) . "',
                            is_default ='" . addslashes($is_default) . "',
                            Status='1' ".$sqltemp." ";
                            $this->query($sql, 0);		
			}
			return $response;
		}
		
		
		

		function updateTemplate($arryDetails) {
			@extract($arryDetails);
			
		//	print_r($arryDetails); die;
			if($TemplateType == 'w'){                            
                         $EcomType='';   
                        }
			$sql = "UPDATE  templates SET TemplateDisplayName='" . addslashes($TemplateDisplayName) . "',CmpID='" . addslashes($CmpID) . "', is_default ='" . addslashes($is_default) . "', TemplateType='" . addslashes($TemplateType) . "',TemplateDis='" . addslashes($TemplateDis) . "',EcomType='" . addslashes($EcomType) . "',TemplatePrice='" . addslashes($TemplatePrice) . "'  
			 WHERE TemplateId ='" . $TemplateId."'"; 
			$this->query($sql, 0);
		}
		
		function uploadfile($file){
			
			
			if($file["template"]["name"]) {
				$filename = $file["template"]["name"];
				$source = $file["template"]["tmp_name"];
				$type = $file["template"]["type"];
				
				$name = explode(".", $filename);
				$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
				foreach($accepted_types as $mime_type) {
					if($mime_type == $type) {
						$okay = true;
						break;
					} 
				}
				
				$continue = strtolower($name[1]) == 'zip' ? true : false;
				if(!$continue) {
					$message = ADD_TEMPLATE_ONLY_ZIP;
					return $message;
				}
				
				$Prefix = '../'; 
				$MainDir = $Prefix."template/";                         
								if (!is_dir($MainDir)) {
									mkdir($MainDir);
									chmod($MainDir,0777);
								}
								
				$filename = $_FILES['template']['name'];
							
				$target_path = $MainDir.$filename; 
				
				
				
				if (is_dir($MainDir.$name[0])) {
							$continue=false;
				} 
				if(!$continue) {
					$message = ADD_TEMPLATE_ALREADY_EXIT;
					return $message;
				}				
				
				if(move_uploaded_file($source, $target_path)) {
					
					$zip = new ZipArchive();
					$x = $zip->open($target_path); 
					if ($x === true) { 
						$zip->extractTo($MainDir); 
						$zip->close();
				
						unlink($target_path);
					}
					$message = "success";
				} else {	
					$message = ADD_TEMPLATE_FAIL;
				}
                               
			}
			
			return $message;
		}

/* eznet erp mail template start here add by madhurendra */
		
		function eznetERPUpdateTemplateContent($arryDetails)
		{
			global $Config;
			extract($arryDetails);          

			 $sql="update erp_email_template set Status='".$Status."',Content='".addslashes($TemplateContent)."',subject='".addslashes($subject)."' where TemplateID = '".$TemplateID."'"; 

			$this->query($sql,0);			
	    }
	    
	    
		function eznetERPGetTemplateCategory($CatID)
		{
			$sql = (!empty($CatID))?(" where CatID = '".$CatID."'"):("");

			$sql = "select * from erp_email_cat ".$sql." order by CatID asc" ; 
			return $this->query($sql, 1);
		}
		
		
		function eznetERPGetTemplateByCategory($CatID)
		{
			$sql = (!empty($CatID))?(" where CatID = '".$CatID."'"):("");

			 $sql = "select * from erp_email_template ".$sql." order by TemplateID asc" ; 
			return $this->query($sql, 1);
		}
		
		
		function eznetERPGetTemplateContent($TemplateID=0,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($TemplateID))?(" and TemplateID = '".$TemplateID."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from erp_email_template ".$sql." order by TemplateID asc" ; 
			return $this->query($sql, 1);
		}
		
		
		/* eznet erp mail template end here */


		function isFaqTitleExists($Title,$FaqID)
		{

			$strSQLQuery ="select * from faq where Title='".strtolower(trim($Title))."'";

			$strSQLQuery .= (!empty($FaqID))?(" and FaqID != '".$FaqID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['FaqID'])) {
				return true;
			} else {
				return false;
			}

		}

function  getAllCompanys($Status)
		{
			$strSQLQuery = "select CmpID,DisplayName,Email,CompanyName from company where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status='".mysql_real_escape_string($Status)."'"):("");

			$strSQLQuery .= " order by DisplayName,Email Asc";

			return $this->query($strSQLQuery, 1);
		}

}

?>
