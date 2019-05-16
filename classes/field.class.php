<?php
class field extends dbClass
{
		//constructor
		function field()
		{
			$this->dbClass();
		} 
		
		///////  Attribute Management //////

		function  GetFieldValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.head_id asc");

			$strSQLQuery = "select v.* from c_head_value v  ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetFieldByValue($head_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID='".$_SESSION['locationID']."'"):("");

			$strSQLFeaturedQuery .= (!empty($head_value))?(" and v.head_value like '".$head_value."%'"):("");

			$strSQLQuery = "select v.head_value from c_head_value v inner join c_attribute a on v.module = a.module ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	

		function GetCrmField($attribute_name,$OrderBy)
		{

			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.head_id asc");

			$strSQLQuery = "select v.* from c_head_value v inner join c_attribute a on v.module = a.module ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function getAllCrmHead($id=0,$module,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and head_id = '".$id."'"):("");
			$sql .= (!empty($module))?(" and module = '".$module."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		    $sql = "select * from c_head_value ".$sql." order by sequence asc" ;

			return $this->query($sql, 1);
		}


		function  GetFixedField($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.head_id asc");

			$strSQLQuery = "select v.* from c_head_value v inner join c_attribute a on v.module = a.module ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllFields($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and module in(".$id.")"):("");
		
			$strSQLQuery = "select * from c_attribute ".$strSQLQuery." order by module Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
			
			function addHead($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into c_head_value (head_value,module,Status,locationID,sequence) values('".addslashes($head_value)."','".$module."','".$Status."','".$_SESSION['locationID']."','".$sequence."')";
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function updateHead($arryAtt)
		{
			@extract($arryAtt);	
			$sql = "update c_head_value set head_value = '".addslashes($head_value)."',module = '".$module."',Status = '".$Status."',sequence='".$sequence."'  where head_id = '".$value_id."'"; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}
	
		function getHead($id=0,$module,$Status=0)
		{
			$sql = " where 1 ";
			//$sql .= (!empty($id))?(" and head_id = '".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($id))?(" and head_id = '".$id."'"):(" ");
			$sql .= (!empty($module))?(" and module = '".$module."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from c_head_value ".$sql." order by sequence asc" ;
		
			return $this->query($sql, 1);
		}
		function countFields()
		{
			$sql = "select sum(1) as NumAttribute from c_head_value where Status='1'" ;
			return $this->query($sql, 1);
		}

		function changeFieldStatus($head_id)
		{
			$sql="select * from c_head_value where head_id='".$head_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_head_value set Status='$Status' where head_id='".$head_id."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteField($id)
		{
			$sql = "delete from c_head_value where edittable='1' and head_id = '".$id."'";
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;
		}
	
		function isHeadExists($head_value,$module,$head_id)
			{

				$strSQLQuery ="select head_id from c_head_value where LCASE(head_value)='".strtolower(trim($head_value))."' and locationID='".$_SESSION['locationID']."'";

				$strSQLQuery .= (!empty($module))?(" and module = '".$module."'"):("");
				$strSQLQuery .= (!empty($head_id))?(" and head_id != '".$head_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['head_id'])) {
					return true;
				} else {
					return false;
				}
		}

		/****************************************/
//By Chetan 3july//
		/****************************************/
function isFieldExists($fieldlabel,$editID,$module)
			{
//$strSQLQuery = (!empty($editID))?(" and fieldid != '".$editID."'"):("");
				//$strSQLQuery ="select fieldid from c_field where LCASE(fieldlabel)='".strtolower(trim($fieldlabel))."'".$strSQLQuery;

$strSQLQuery = (!empty($editID))?(" and c.fieldid != '".$editID."'"):("");
//$strSQLQuery .= (!empty($module))?(" and fieldid != '".$editID."'"):("");
				$strSQLQuery ="select c.fieldid,c.fieldlabel,h.module from c_field c left join c_head_value h on c.headid = h.head_id where LCASE(c.fieldlabel)='".strtolower(trim($fieldlabel))."' and  LCASE(h.module)='".strtolower(trim($module))."' ".$strSQLQuery;

				
				
				
				$arryRow = $this->query($strSQLQuery, 1);

				 
                                
                                
				//28July//
                                
                                
				
				if (!empty($arryRow[0]['fieldid']) ) {
					return true;
				} else {
					return false;
				}
                                //END//
		}
//End//

		 //2DEc By Chetan//    
		function addFormField($arryDetails,$mod)
		{
			$mandatory='';

			@extract($arryDetails);	
                        
                        if($mod == '102' && $headid == '1')
                        {
                           $values =  ",('4','".addslashes($type)."','".addslashes($fieldname)."','".addslashes($fieldlabel)."','".addslashes($defaultvalue)."','".addslashes($dropvalue)."','".$mandatory."','".$sequence."','".$Status."','".$RadioValue."'),
                                        ('22','".addslashes($type)."','".addslashes($fieldname)."','".addslashes($fieldlabel)."','".addslashes($defaultvalue)."','".addslashes($dropvalue)."','".$mandatory."','".$sequence."','".$Status."','".$RadioValue."')";
                        
                           $this->AddColumnToMainTable('103', $arryDetails, 'add');
                           $this->AddColumnToMainTable('108', $arryDetails, 'add');
                           
                        }elseif($mod == '103' && $headid == '32')
                        {
                            $values =  ",('22','".addslashes($type)."','".addslashes($fieldname)."','".addslashes($fieldlabel)."','".addslashes($defaultvalue)."','".addslashes($dropvalue)."','".$mandatory."','".$sequence."','".$Status."','".$RadioValue."')";
                            $this->AddColumnToMainTable('108', $arryDetails, 'add');
                        }
			$sql = "insert into c_field (headid,type,fieldname,fieldlabel,defaultvalue,dropvalue,mandatory,sequence,Status,RadioValue) values('".$headid."','".addslashes($type)."','".addslashes($fieldname)."','".addslashes($fieldlabel)."','".addslashes($defaultvalue)."','".addslashes($dropvalue)."','".$mandatory."','".$sequence."','".$Status."','".$RadioValue."')".$values."";//By Chetan 13July//
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return true;
			else
				return false;

		}

		function UpdateFormField($arryAtt)
		{

			$mandatory='';

			@extract($arryAtt);
			
           
		$selectQuery="select * from c_field where fieldid = '".$fieldid."'";
		$arryField = $this->query($selectQuery, 1);

		if($arryField[0]['editable']==0){
		$sql = "update c_field set fieldlabel = '".$fieldlabel."',sequence = '".$sequence."'  where fieldid = '".$fieldid."'"; 
		}else{
		$sql = "update c_field set type = '".addslashes($type)."',
					fieldname = '".$fieldname."',
					fieldlabel = '".$fieldlabel."',
					mandatory='".$mandatory."',
					sequence='".$sequence."',
					defaultvalue='".addslashes($defaultvalue)."',
					Status='".$Status."',
					dropvalue='".addslashes($dropvalue)."',
					RadioValue = '".$RadioValue."'
					where fieldid = '".$fieldid."'"; 
		}
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}
			function getFormField($id=0,$headid,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and fieldid = '".$id."'"):(" ");
			$sql .= (!empty($headid))?(" and headid = '".$headid."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from c_field ".$sql." order by sequence asc" ;
		
			return $this->query($sql, 1);
		}
           function changeFormFieldStatus($fieldid)
		{
			$sql="select * from c_field where fieldid='".$fieldid."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_field set Status='$Status' where fieldid='".$fieldid."'";
				$this->query($sql,0);
				return true;
			}			
		}


		function changeFieldMandatory($fieldid)
		{
			$sql="select * from c_field where fieldid='".$fieldid."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['mandatory']==1)
					$mandatory=0;
				else
					$mandatory=1;
					
				$sql="update c_field set mandatory='$mandatory' where fieldid='".$fieldid."'";
				$this->query($sql,0);
				return true;
			}			
		}
function removeField($id)
		{
			$sql = "delete from c_field where editable='1' and fieldid = '".$id."'";
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;
		}


		function  GetCustomField($PID,$module)
		{
			$strSQLQuery = "select * from c_custom_field_value  ";

			$strSQLQuery .= (!empty($PID))?(" where PID='".$PID."'"):(" where 1 ");
			$strSQLQuery .= (!empty($module))?(" and module_type = '".$module."'"):("");
				
			
			
			return $this->query($strSQLQuery, 1);
		}


		function updateModuleForm($arryDetail,$PID,$fieldIDs,$fieldNames)
                {
            

                    $deleteSQLQuery = "delete from c_custom_field_value where PID='".$PID."'"; 
                    $this->query($deleteSQLQuery, 0);

                        
                    //By Chetan//    
                   /* foreach($_POST['arrField2'] as $key=>$values){
                             $a=explode("_",$key);					 
                             $strSQL = "insert into c_custom_field_value (module_type,PID,fieldid, custom_value ) values('".addslashes($_POST['module_type'])."','".addslashes($PID)."', '".addslashes($a[1])."','".addslashes($values)."')";

      $this->query($strSQL, 0);

                    }*/
                    unset($_POST['City']);
			
                   
                    $i=0; 
		    if(!empty($fieldNames)){
		            foreach($fieldNames as $field){
		                $value = $arryDetail[$field];
		                if($value)
		                {
		                    $strSQL = "insert into c_custom_field_value (module_type,PID,fieldid, custom_value ) values('','".addslashes($PID)."', '".addslashes($fieldIDs[$i])."','".addslashes($value)."')";
		                    $this->query($strSQL, 0);
		                    
		                }
		                $i++;
		            }
		    }
                        
                   //End// 
		}
                //By Chetan //updated by chetan 11Mar////
                function getAllCustomFieldByModule($module)
                { 
                    $sql = "select f.fieldname,f.fieldid,f.fieldlabel,type from c_field f";

                    $sql .= " left join c_head_value h on f.headid = h.head_id left join admin_modules m on h.module = m.ModuleID where m.Module = '$module' and f.status = '1'";
                   
                    return $this->query($sql, 1);
                }
                
                function GetCustomFieldsValue($PID,$FieldId)
                {
                    $strSQLQuery = "select custom_value from c_custom_field_value  where PID='".$PID."' and fieldid = '".$FieldId."' ";
                    $res = $this->query($strSQLQuery, 1);
                    if(count($res))
                    {
                        return $res[0]['custom_value'];
                    }
                    else{
                        
                        return false;
                    }
                }
                //23June//
                function GetCustomfieldByFieldId($Fid,$field)
                {
                    
                    $sql = "select ".$field." from c_field where fieldid='".$Fid."' and status = '1'"; 
                    $res = $this->query($sql, 1);
                    
                    if(count($res))
                    {
                        if($field!='' && $field!='*')
                        {
                            return $res[0][$field];
                            
                        }else{
                            
                            return $res[0];
                        }
                    }  
                    return false;
                }

 function GetCustomfieldByFieldName($Fname,$field)
                {
                    
                    $sql = "select ".$field." from c_field where fieldname='".$Fname."' and status = '1'"; 
                    $res = $this->query($sql, 1);
                    
                    if(count($res))
                    {
                        if($field!='' && $field!='*')
                        {
                            return $res[0][$field];
                            
                        }else{
                            
                            return $res[0];
                        }
                    }  
                    return false;
                }


                 //1july//

                function AddColumnToMainTable($module,$post,$do)
                {
                    if($module)
                    {
                        $table = $this->getTable($module);
                    }

                    if($_POST['type']=='text' || $_POST['type']=='date' || $_POST['type']=='select')
                    {
                        $datatype ='varchar(100)';
                    }elseif($_POST['type']=='radio' || $_POST['type']=='checkbox')
                    {
                        $datatype ="varchar(50)";
                    }else{
                        $datatype ='text';
                    }
                    
                    $col = trim($_POST['fieldname']);
                    
                     if($do == 'update')
                    {
                        
                        $prevCol = $this->GetCustomfieldByFieldId(trim($_POST['fieldid']),'fieldname');
                        if($prevCol!= $col)
                        {
                        
                             $strSQLQuery = "ALTER TABLE $table MODIFY $prevCol $col $datatype";
                            return $this->query($strSQLQuery, 1);
                        }    
                    }
                    if($do == 'add')
                    {
                        $strSQLQuery = "ALTER TABLE $table ADD $col $datatype";
                        return $this->query($strSQLQuery, 1);
                    }
                    
                }
                
                 //30June//
                function removeColFrMainTable($fieldId,$module)
                {
			if($module)
			{
				$table = $this->getTable($module);
			}

			$fieldname = $this->GetCustomfieldByFieldId($fieldId,'fieldname');
			$strQuery = "SHOW COLUMNS FROM $table  ";
			$res = $this->query($strQuery, 1);
			$resVals = array_map(function($arr){
				return $arr['Field'];},$res);//8july//
			if(in_array($fieldname,$resVals))//8july//
			{	
				$strSQLQuery = "ALTER TABLE $table DROP COLUMN $fieldname";
				return $this->query($strSQLQuery, 1);
			}
                }
                
		//21Aug//
                function getTable($moduleNo)
                {
                                        $tables = array('102'=>'c_lead','103'=>'c_opportunity','104'=>'c_ticket','105'=>'c_document','106' => 'c_campaign', '108'=>'c_quotes','107'=>'s_address_book','136'=>'c_activity','2015'=>'s_customers','2003'=> 'inv_items');

                    return $tables[$moduleNo];
                }

		//28July//
                function CheckFieldInTable($mod,$arr)
                {
                    if($mod)
                    {
                        $table = $this->getTable($mod);
                        $strQuery = "SHOW COLUMNS FROM $table  ";
                        $res = $this->query($strQuery, 1);
                       
                        $narr = array_map(function($arr){return strtolower($arr['Field']);},$res);
                        
                        $fieldname = trim(mysql_real_escape_string(strip_tags($arr['fieldname']))); 
                        if(!in_array(strtolower($fieldname),$narr))
                        {
                            return false;
                        }else{
                            return true;
                        }
                    }    
                }

                //End//

		//By Chetan 23Nov//
                function getAllCustomFieldByModuleID($moduleID)
                { 
                    $sql = "select f.* from c_field f";
                    $sql .= " left join c_head_value h on f.headid = h.head_id left join admin_modules m on h.module = m.ModuleID where m.ModuleID = '$moduleID' and f.status = '1'";
                    return $this->query($sql, 1);
                }
                
                //End//

		//by chetan 3Mar//
                function getSequenceToStart($ID,$headId)
                {
                    $sql = "select sequence from c_field where fieldid < '".$ID."' and headid = ".$headId."   order by fieldid desc limit 1 ";
                    $res =  $this->query($sql, 1);
                    return $res[0]['sequence'];
                }
                
                function updateSequence($IDsarr,$Seq=1)
                {
                    $Idcount = count($IDsarr);
                    foreach($IDsarr as $ID)
                    {
                        $sql="update c_field set sequence=".$Seq." where fieldid='".$ID."'";
                        $this->query($sql,0);
                        $Seq++;
                    }
                }
                
                function getLeftFieldIds($IdsStr , $headId, $seq)
                {
                    $addstr = ($seq) ? ' and sequence > '.$seq.'': '';
                    $sql = "select fieldid from c_field where fieldid not in (".$IdsStr.") and headid = ".$headId." ".$addstr."";
                    return $this->query($sql, 1);
                    
                }
                //End//

}

?>
