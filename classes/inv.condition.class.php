<?
class condition extends dbClass
{
		//constructor
		function condition()
		{
			$this->dbClass();
		} 
		
		function  ListCondition($ParentID,$SearchKey,$SortBy,$AscDesc)
		{
			
			$strAddQuery = '';
                        $SearchKey   = strtolower(trim($SearchKey));
                      
			/*if($ParentID>0){
				$strAddQuery .= " where c1.ParentID='".$ParentID."'";
				
			}*/
                       if($SearchKey != "" && $SortBy == "c1.Name")
                        {
                                $strAddQuery .= " where c1.Name like '".$SearchKey."%'";
				
                        }
                        elseif(trim($SearchKey)=='active' && ($SortBy=='c1.Status' || $SortBy==''))
                        {   
                                  $strAddQuery .= " where c1.Status='1' AND c1.ParentID ='0'";
                        }
                        else if($SearchKey=='inactive' && ($SortBy=='c1.Status' || $SortBy=='') ){
				  $strAddQuery .= " where c1.Status='0' AND c1.ParentID ='0'";
			}
                        else if($SearchKey=='in active' && ($SortBy=='c1.Status' || $SortBy=='') ){
				  $strAddQuery .= " where c1.Status='0' AND c1.ParentID ='0'";
			}
                        else if($SortBy != '' && $SearchKey != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%' AND c1.ParentID =0)"):("");
			}
                        else{
				$strAddQuery .= " where c1.Name like '".$SearchKey."%' AND c1.ParentID =0" ;	
			}

                        $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.ConditionID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                        
			//$strSQLQuery = "select c1.ConditionID,c1.Level,c1.Image,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcondition,c1.NumProducts from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.ConditionID".$strAddQuery;
                        $strSQLQuery = "select c1.ConditionID,c1.Level,c1.Image,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcondition,c1.NumProducts from inv_condition c1 left outer join inv_condition c2 on c1.ParentID = c2.ConditionID".$strAddQuery;
                        //echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}
                
                function  ListAllCondition()
		{
			
			
                        $strSQLQuery = "select ConditionID,Level,Name,Status from inv_condition WHERE   ParentID ='0'";
			return $this->query($strSQLQuery, 1);
		}
                
               /*function  ListAllCategoriesAndSubcategories()
		{
			
			
                        $strSQLQuery = "select ConditionID,Level,Name,Status from inv_condition";
			return $this->query($strSQLQuery, 1);
		}*/

		function  GetCondition($ConditionID)
		{
			
			$strSQLQuery = "select * from inv_condition WHERE Status=1 and ConditionID = '".$ConditionID."'";  
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetSubConditionByParent($Status,$ParentID)
		{
                    $strAddQuery ='';
                     if($Status=='1' || $Status=='active' || $Status=='Active')
                        {   
                                  $strAddQuery .= " and Status='1'";
                        }
                        else if($Status=='0' || $Status=='inactive'){
				  $strAddQuery .= " and Status='0'";
			}
                        

			$strSQLQuery = "select * from inv_condition where ParentID='".$ParentID."' ".$strAddQuery." order by ConditionID";
                        
			return $this->query($strSQLQuery, 1);
		}
                
                
                /*function getCategoryTree($parentid, $num, $str = "") {
                   
                        $sql="select * from inv_condition
                                        where ParentID = '$parentid'";
                        print $sql."<br>";
                        $rs=mysql_query($sql);
                        if(mysql_num_rows($rs)>0) {
                                $num=$num+3;
                                while($row=mysql_fetch_array($rs)) {
                                        $str = $str.str_repeat("&nbsp;",$num).$row["Name"]."<br>";
                                        $this->getCategoryTree($row["ConditionID"],$num, $str);
                                        print $str;
                                }
                        }
                        return $str;
                }*/




                function  GetSubConditionTree($ParentID,$num)
		{
                   global $Config;
                   $edit = $Config['editImg'];
                   $delete = $Config['deleteImg'];
                 
			  $query = "SELECT * FROM inv_condition WHERE ParentID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlCat = '';
                                 $num=$num+3;
                            while($values = mysql_fetch_array($result)) { 
                                
                                $htmlCat = '<tr align="left" bgcolor="#ffffff">
                               <td height="26"  align="left">
                                  <table border="0" cellspacing="0" cellpadding="0" class="margin-left">
                                    <tr>
                                        <td align="left">
                                            <a href="editCategory.php?edit='.$values['ConditionID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">';
                                           
                                              $htmlCat .= str_repeat("&nbsp;",$num);
                                              
                                              $htmlCat .= '<b>'.stripslashes($values['Name']).'</b>
                                            </a>
                                        </td>
                                    </tr>
                                </table></td>
                            <   td align="center">'.$values['sort_order'].'</td>
                            <td align="center" >';  
                                if ($values['Status'] == 1) {
                                    $status = 'Active';
                                } else {
                                    $status = 'InActive';
                                }



                        $htmlCat .= '<a href="editCategory.php?active_id=' . $values["ConditionID"] . '&ParentID=' . $values['ParentID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>
                        
                        </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editCategory.php?edit='.$values['ConditionID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlCat .= '<a href="editCategory.php?del_id='.$values['ConditionID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';
                                

                                $htmlCat .= '&nbsp;</td>
                        </tr>';
                                  
                                  echo $htmlCat;
                                  
                                  
                                  if($values['ParentID'] > 0)
                                  {
                                    $this->GetSubCategoryTree($values['ConditionID'],$num); 
                                  }
                                }  
             
		}
		
		function GetConditionDropValue($selected=''){

			
			$listAllCondition =  $this->ListAllCondition();
			$ConditionDrop = ''; 
					foreach($listAllCondition as $key=>$values){
					 
                                       if($selected==$values['Name']) {
                                                   $ConditionDrop .='<option value="'.$values['Name'].'" selected>'.$values['Name'].'</option>';
                                            }
                                            else {
                                                   $ConditionDrop .='<option value="'.$values['Name'].'">'.$values['Name'].'</option>';
                                            }

					

					
				}
			
			return $ConditionDrop ;
			
			
			
		}


		function GetConditionDropValueOld($selected=''){

			
			$listAllCondition =  $this->ListAllCondition();
			 
					foreach($listAllCondition as $key=>$values){
					//$arrySubCategory = $this->GetSubConditionByParent('',$values['ConditionID']);
                                       if($selected==$values['Name']) {
                                                   $ConditionDrop .='<option value="'.$values['Name'].'" selected>'.$values['Name'].'</option>';
                                            }
                                            else {
                                                   $ConditionDrop .='<option value="'.$values['Name'].'">'.$values['Name'].'</option>';
                                            }

					

					foreach ($arrySubCategory as $key => $value) {
					$arrySubCategory = $this->GetSubConditionByParent('',$value['ConditionID']);

					 if($selected==$value['Name']) {
                                                   $ConditionDrop .='<option value="'.$value['Name'].'" selected>--'.$value['Name'].'</option>';
                                            }
                                            else {
                                                   $ConditionDrop .='<option value="'.$value['Name'].'">--'.$value['Name'].'</option>';
                                            }
					foreach ($arrySubCategory as $key => $value) {
						$arrySubCategory = $this->GetSubConditionByParent('',$value['ConditionID']);
                                        if($selected==$value['Name']) {
                                                   $ConditionDrop .='<option value="'.$value['Name'].'" selected>---'.$value['Name'].'</option>';
                                            }
                                            else {
                                                   $ConditionDrop .='<option value="'.$value['Name'].'">---'.$value['Name'].'</option>';
                                            }
						
					} 
				  } 
				}
			
			return $ConditionDrop ;
			
			
			
		}

		function getConditions($parentid,$num,$selected='') {
                            $sql="select * from inv_condition
                                            where Status ='1' and ParentID='".$parentid."'";
                            $rs=mysql_query($sql);
                            if(mysql_num_rows($rs)>0) {
                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                            if($selected==$row['Name']) {
                                                    $str="<option value='".$row['Name']."' selected>".$row['Name']."</option>";
                                            }
                                            else {
                                                    $str="<option value='".$row['Name']."'>".$row['Name']."</option>";
                                            }
                                            
                                             echo $str;   
                                       
                                                $this->getConditions($row['ConditionID'],$num,$selected);
                                             
                                          
                                    }
                            }
                           
                    }
                    
                  
              function  GetNameParent($ParentID)
		{
			$strAddQuery = '';
			 $strSQLQuery = "select Name,NumSubcondition from inv_condition where ConditionID = '".$ParentID."' ".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}  
                  

		function  GetNameByParentID($ParentID)
			{
				$strAddQuery = '';
				$strSQLQuery = "select Name from inv_condition where ConditionID = '".$ParentID."' ".$strAddQuery." order by Name";
				return $this->query($strSQLQuery, 1);
			}

		

		function  GetConditionNameByID($ConditionID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select c1.Name,c1.Image,c1.ConditionID,c1.ParentID from inv_condition c1 where c1.Status='1' and c1.ConditionID ='".$ConditionID."' ".$strAddQuery." order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
                function  GetSubConditionByID($ConditionID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select * from inv_condition c1 where c1.Status='1' and c1.ParentID = '".$ConditionID."' order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
                

		function UpdateImage($FieldName,$imageName,$ConditionID)
		{
			 $strSQLQuery = "update inv_condition set ".$FieldName."='".$imageName."' where ConditionID='".$ConditionID."' ";
  			return $this->query($strSQLQuery, 0);
		}

		function AddCondition($arryDetails)
		{ 
			extract($arryDetails);

			$NameArray = explode('#',$Name);
			foreach($NameArray as $Name){
				$Name = ucfirst(trim($Name));
				$strSQLQuery = "insert into inv_condition (ParentID,Name,ConditionDescription,sort_order,Status,AddedDate) 
                 values('".$ParentID."','".addslashes($Name)."','".addslashes($CategoryDescription)."','".addslashes($sort_order)."','".$Status."','".date('Y-m-d')."')";
				$this->query($strSQLQuery, 0);
			}
			
			$lastInsertId = $this->lastInsertId();

			if($ParentID > 0){
				$strUpdateQuery = "update inv_condition set NumSubcondition = NumSubcondition + 1 where ConditionID = '".$ParentID."'";
				$this->query($strUpdateQuery, 0);
			}
			return $lastInsertId;

		}

		

		function UpdateCondition($arryDetails)
		{
			extract($arryDetails);
                        
                    
                    
		     	  $strSQLQuery = "update inv_condition set ParentID='".$ParentID."',Name='".addslashes($Name)."',sort_order='".$sort_order."', Status='".$Status."' where ConditionID='".$ConditionID."'";
                     
			$this->query($strSQLQuery, 0);

			return 1;
		}

		

		function RemoveCondition($id, $ParentID)
		{
			$objConfigure=new configure();
			$strSQLQuery = "select Image from inv_condition where ConditionID='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
		
			#$ImgDir = $Config['UploadPrefix'].'upload/category/'.$_SESSION['CmpID'].'/';
			/*if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){				
                              $objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);	
				unlink($ImgDir.$arryRow[0]['Image']);	
			}*/			
			
			
			$strSQLQuery = "delete from inv_condition where ConditionID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			

			if($ParentID > 0){

				$strSQLQuery ="select NumSubcondition from inv_condition where ConditionID='".$ParentID."' ";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumSubcondition'])) {
					$strUpdateQuery = "update inv_condition set NumSubcondition = NumSubcondition - 1 where ConditionID = '".$ParentID."'";
					$this->query($strUpdateQuery, 0);
				} 


			}
			return 1;
		}

       

		function RemoveConditionCompletly($id)
		{

			$strSQLQuery = "delete from inv_condition where ConditionID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from inv_condition where ParentID='".$id."'"; 
			$this->query($strSQLQuery, 0);

		
			/******************************/
			
			
			return 1;
		}

		function changeConditionStatus($ConditionID)
		{
			$sql="select * from inv_condition where ConditionID='".$ConditionID."' ";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update inv_condition set Status='$Status' where ConditionID='".$ConditionID."' ";
				$this->query($sql,0);
				return true;
			}			
		}

		function isSubConditionExists($id)
		{
			$strSQLQuery ="select ConditionID from inv_condition where ParentID='".$id."' ";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ConditionID'])) {
				return true;
			} else {
				return false;
			}
		}
		function isProductExists($id)
		{
			$strSQLQuery ="select`Condition` from inv_items where `Condition`='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['Condition'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function isConditionExists($Name,$ConditionID=0,$ParentID=0)
		{

			 $strSQLQuery ="select ConditionID from inv_condition where LCASE(Name)='".strtolower(trim($Name))."' and ParentID = '".$ParentID."'";

			$strSQLQuery .= (!empty($ConditionID))?(" and ConditionID != '".$ConditionID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ConditionID'])) {
				return true;
			} else {
				return false;
			}
		}

		

		function  GetConditionsListing($id=0,$ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID=0");
			$strAddQuery .= (!empty($id))?(" and c1.ConditionID='".$id."'"):("");

			$strSQLQuery = "select c1.ConditionID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcondition from inv_condition c1 left outer join inv_condition c2 on c1.ParentID = c2.ConditionID where c1.Status='1' ".$strAddQuery." order by c1.ConditionID";
			return $this->query($strSQLQuery, 1);
		}

		function  GetSubCategoriesListing($id=0,$ParentID,$StoreID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID=0");
			$strAddQuery .= (!empty($id))?(" and c1.ConditionID='".$id."'"):("");

			$strSQLQuery = "select c1.ConditionID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcondition,sc.StoreConditionID from inv_condition c1 left outer join inv_condition c2 on c1.ParentID = c2.ConditionID where c1.Status='1' ".$strAddQuery." group by c1.Name order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."' "):("");

			$strSQLQuery = "select * from inv_condition where ParentID='".$ParentID."' ".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetParentCategories($Status)
		{
			 $strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");
			
			 $strSQLQuery = "select c1.* from inv_condition c1 where ParentID='0' ".$strAddQuery." order by c1.sort_order ";

			return $this->query($strSQLQuery, 1);
		}
		function  GetSubSubCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from inv_condition where ParentID='".$ParentID."' ".$strAddQuery." order by ConditionID";
			return $this->query($strSQLQuery, 1);
		}
		
		/*function GetNumProductsSingle($ConditionID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from e_products p1 where p1.Status=1  and p1.ConditionID=".$ConditionID.$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}		
*/
		


	

                function  GettotalActiveCategory()
		{
			
			$strSQLQuery = "select * from inv_condition WHERE Status = '1'";  
			return $this->query($strSQLQuery, 1);
		}

	function  GetConditionTransaction($Name)
			{
				$strAddQuery = '';
				 $strSQLQuery = "select COUNT(ID) as numC from inv_item_quanity_condition where `Condition` like '%".$Name."%' group by `Condition` ";
				$rs = $this->query($strSQLQuery, 1);
					if(!empty($rs)){
							return $rs[0]['numC'];
					}else{
							return 0;
					}
			}

  function  ListAllWarehouse()
		{
			
			
                        $strSQLQuery = "select WID,warehouse_code from w_warehouse WHERE   Status ='1' order by WID asc";
			return $this->query($strSQLQuery, 1);
		}
	function GetWarehouseDropValue($selected=''){

			
			$ListAllWarehouse =  $this->ListAllWarehouse();
$WarehouseDrop='';

					foreach($ListAllWarehouse as $key=>$values){
					//$arrySubCategory = $this->GetSubConditionByParent('',$values['ConditionID']);
                                       if($selected==$values['WID']) {
                                                   $WarehouseDrop .='<option value="'.$values['WID'].'" selected>'.$values['warehouse_code'].'</option>';
                                            }
                                            else {
                                                   $WarehouseDrop .='<option value="'.$values['WID'].'">'.$values['warehouse_code'].'</option>';
                                            }

					

				}
			 //echo $WarehouseDrop; exit;
			return $WarehouseDrop ;
			
			
			
		}

}

?>
