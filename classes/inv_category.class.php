<?
class category extends dbClass
{
		//constructor
		function category()
		{
			$this->dbClass();
		} 
		
		function  ListCategories($ParentID,$SearchKey,$SortBy,$AscDesc)
		{
			
			$strAddQuery = ' where 1 ';
                        $SearchKey   = strtolower(trim($SearchKey));
             if($SearchKey!=''){

$searchQuery = "select group_concat(`ParentID` separator ',') as `totparent` from inv_categories where Name like '%".$SearchKey."%' ";

$par = $this->query($searchQuery, 1);
//print_r($par[0]['totparent']);
if($par[0]['totparent']>0)
$SearchKey = '';
}
                      
			if(!empty($par[0]['totparent'])){
//$pent = rtrim($par[0]['totparent'], ')');
				$strAddQuery .= " AND c1.CategoryID in (".$par[0]['totparent'].")";
				
			}         
			/*if($ParentID>0){
				$strAddQuery .= " where c1.ParentID=".$ParentID;
				
			}*/
                       if($SearchKey != "" && $SortBy == "c1.Name")
                        {
                                $strAddQuery .= " AND c1.Name like '".$SearchKey."%'";
				
                        }
                        elseif(trim($SearchKey)=='active' && ($SortBy=='c1.Status' || $SortBy==''))
                        {   
                                  $strAddQuery .= " AND c1.Status='1' AND c1.ParentID ='0' ";
                        }
                        else if($SearchKey=='inactive' && ($SortBy=='c1.Status' || $SortBy=='') ){
				  $strAddQuery .= " AND c1.Status='0' AND c1.ParentID ='0'";
			}
                        else if($SearchKey=='in active' && ($SortBy=='c1.Status' || $SortBy=='') ){
				  $strAddQuery .= " AND c1.Status='0' AND c1.ParentID ='0'";
			}
          else if($SortBy != '' && $SearchKey != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%' AND c1.ParentID =0)"):("");
			} else if($SearchKey != ''){
				$strAddQuery .= " AND c1.Name like '".$SearchKey."%' " ;	
			}else{
$strAddQuery .= " AND c1.ParentID =0 ";
}

                        $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.Name ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");
                        
			//$strSQLQuery = "select c1.CategoryID,c1.Level,c1.Image,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcategory,c1.NumProducts from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID".$strAddQuery;
                         $strSQLQuery = "select c1.CategoryID,c1.Level,c1.Image,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcategory,c1.NumProducts from inv_categories c1 left outer join inv_categories c2 on c1.ParentID = c2.CategoryID".$strAddQuery;
                        //echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}
                
                function  ListAllCategories()
		{
			
			
                        $strSQLQuery = "select CategoryID,Level,Name,Status from inv_categories WHERE ParentID ='0' order by Name";
			return $this->query($strSQLQuery, 1);
		}
                
               /*function  ListAllCategoriesAndSubcategories()
		{
			
			
                        $strSQLQuery = "select CategoryID,Level,Name,Status from inv_categories";
			return $this->query($strSQLQuery, 1);
		}*/

		function  GetCategory($CategoryID)
		{
			
			$strSQLQuery = "select * from inv_categories WHERE CategoryID = '".$CategoryID."'";  
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetSubCategoryByParent($Status,$ParentID)
		{
                    $strAddQuery='';
                     if($Status=='1' || $Status=='active' || $Status=='Active')
                        {   
                                  $strAddQuery .= " and Status='1' ";
                        }
                        else if($Status=='0' || $Status=='inactive'){
				  $strAddQuery .= " and Status='0' ";
			}
                        

			$strSQLQuery = "select * from inv_categories where ParentID='".$ParentID."'".$strAddQuery." order by Name asc";
                        
			return $this->query($strSQLQuery, 1);
		}
                
                
                /*function getCategoryTree($parentid, $num, $str = "") {
                   
                        $sql="select * from inv_categories
                                        where ParentID = '$parentid'";
                        print $sql."<br>";
                        $rs=mysql_query($sql);
                        if(mysql_num_rows($rs)>0) {
                                $num=$num+3;
                                while($row=mysql_fetch_array($rs)) {
                                        $str = $str.str_repeat("&nbsp;",$num).$row["Name"]."<br>";
                                        $this->getCategoryTree($row["CategoryID"],$num, $str);
                                        print $str;
                                }
                        }
                        return $str;
                }*/




                function  GetSubCategoryTree($ParentID,$num)
		{
                   global $Config;
			$objItem =  new items();
                   $edit = $Config['editImg'];
                   $delete = $Config['deleteImg'];
                 	$cat_title = "'Sub Category'";
			  $query = "SELECT * FROM inv_categories WHERE ParentID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlCat = '';
                                 $num=$num+3;
                            while($values = mysql_fetch_array($result)) { 
                                
                                $htmlCat = '<tr align="left" bgcolor="#ffffff">
                                <td align="left" >&nbsp;</td>
                               <td height="26"  align="left">
                                  <table border="0" cellspacing="0" cellpadding="0" class="margin-left">
                                    <tr>
                                       
                                        <td align="left">
                                            <a href="editCategory.php?edit='.$values['CategoryID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">';
                                           
                                              $htmlCat .= str_repeat("&nbsp;",$num);
                                              
                                              $htmlCat .= '<b>'.stripslashes($values['Name']).'</b>
                                            </a>
                                        </td>
                                    </tr>
                                </table></td>
                            <td align="center">'.$values['sort_order'].'</td>
                            <td align="center" >';  
                                if ($values['Status'] == 1) {
                                    $status = 'Active';
                                } else {
                                    $status = 'InActive';
                                }



                        $htmlCat .= '<a href="editCategory.php?active_id=' . $values["CategoryID"] . '&ParentID=' . $values['ParentID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>
                        
                        </td>
                            <td height="26" align="right"  valign="top">
                                <a href="editCategory.php?edit='.$values['CategoryID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 if(!$objItem->isCategoryTransactionExist($values['CategoryID'])){  
                                    $htmlCat .= '<a href="editCategory.php?del_id='.$values['CategoryID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';
                                }

                                $htmlCat .= '&nbsp;</td>
                        </tr>';
                                  
                                  echo $htmlCat;
                                  
                                  
                                  if($values['ParentID'] > 0)
                                  {
                                    $this->GetSubCategoryTree($values['CategoryID'],$num); 
                                  }
                                }  
             
		}

		function getCategories($parentid,$num,$selected=0) {
			   
                            $sql="select * from inv_categories where ParentID='".$parentid."' and Status='1' order by Name asc";
                            $rs=mysql_query($sql);
                            if(mysql_num_rows($rs)>0) {
                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                            if($selected==$row['CategoryID']) {
                                                    $str="<option value='".$row['CategoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            else {
                                                    $str="<option value='".$row['CategoryID']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            
                                             echo $str;   
                                       
                                                $this->getCategories($row['CategoryID'],$num,$selected);
                                             
                                          
                                    }
                            }
                           
                    }
                    
                    function getAppliedPromoCategory($promID)
                    {
                            $categories = array();
                            
                            $strSQLQuery = "SELECT * FROM e_promo_categories WHERE PromoID='".$promID."'";
			    $arrayRows = $this->query($strSQLQuery, 1);
                            foreach($arrayRows as $val)
                            {
                                    $categories[] = trim($val["CID"]);
                            }
                        return $categories;                            
                    }
                    
                    function getPromoCategories($parentid,$num,$selected=0,$promID=0) {
                        
                            $sql="select * from inv_categories
                                            where ParentID='".$parentid."'";
                            $rs=mysql_query($sql);
                            
                            $selectedcategories =  $this->getAppliedPromoCategory($promID);
                           
                            if(mysql_num_rows($rs)>0) {
                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                        
                                           if(in_array($row['CategoryID'], $selectedcategories)) {
                                               
                                                    $str="<option value='".$row['CategoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            else {
                                                    $str="<option value='".$row['CategoryID']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                                                                        
                                                echo $str;   
                                       
                                                $this->getPromoCategories($row['CategoryID'],$num,$selected,$promID);
                                             
                                          
                                    }
                            }
                           
                    }


function category_tree($catid){
		//global $conn;

		  $sql = "select * from inv_categories where CategoryID ='".$catid."' ";  
		$row = $this->query($sql, 1);
		$output = '';
		foreach($row as $key=>$values){
		$i = 0;

		$output .= $values['Name']." >>> ";

		$this->category_tree($values['ParentID']);


		$i++;
		 
		}
		//$output =rtrim($output,'>>');

		//$output =substr($output,0,strlen($output)-3);
		echo $output; 
		//return $output;
}


function GetCategoryTree($catid){
	if($catid>0){
		$sql = "select * from inv_categories where CategoryID ='".$catid."' ";  
		$row = $this->query($sql, 1);
		foreach($row as $key=>$values){
			$i = 0;
			$_SESSION['CatName'][] = $values['Name'];
			$_SESSION['CatCount']++;
			if($values['ParentID']>0 && $_SESSION['CatCount']<5){
				$this->GetCategoryTree($values['ParentID']);
			}
			$i++;	 
		}
	}		
		 
}


		function  GetNameByParentID($ParentID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select Name from inv_categories where CategoryID = '".$ParentID."'".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		

		function  GetCategoryNameByID($CategoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select c1.Name,c1.Image,c1.CategoryID,c1.ParentID from inv_categories c1 where c1.Status='1' and c1.CategoryID ='".$CategoryID."' ".$strAddQuery." order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
                function  GetSubCategoryByID($CategoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select * from inv_categories c1 where c1.Status='1' and c1.ParentID = '".$CategoryID."' order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
		function  GetCatIDByParent($CategoryID)
		{		
			$strSQLQuery = "select CategoryID from inv_categories c1 where c1.Status='1' and c1.ParentID = '".$CategoryID."' order by c1.CategoryID ";
			$arryChildCat = $this->query($strSQLQuery, 1);
			$_SESSION['CatIDs'][] = (int)$CategoryID;

			if(sizeof($arryChildCat)>0){
				foreach($arryChildCat as $key=>$values){
					$_SESSION['CatIDs'][] = $values['CategoryID'];
					$this->GetCatIDByParent($values['CategoryID']);
				}
			
			}
			
		}
                

		function UpdateImage($FieldName,$imageName,$CategoryID)
		{
			 $strSQLQuery = "update inv_categories set ".$FieldName."='".$imageName."' where CategoryID='".$CategoryID."'";
  			return $this->query($strSQLQuery, 0);
		}

		function AddCategory($arryDetails)
		{ 
		
		
		
			$MetaTitle=$MetaKeyword=$MetaDescription='';
			extract($arryDetails);

			$NameArray = explode('#',$Name);
			foreach($NameArray as $Name){
				$Name = ucfirst(trim($Name));
				$strSQLQuery = "insert into inv_categories (ParentID,Name,MetaTitle,MetaKeyword,MetaDescription,CategoryDescription,sort_order,Status,AddedDate,valuationType,Spiff,spiffType,spiffAmt) 
                                                                                                                                  values('".$ParentID."','".addslashes($Name)."','".addslashes($MetaTitle)."','".addslashes($MetaKeyword)."','".addslashes($MetaDescription)."','".addslashes($CategoryDescription)."','".addslashes($sort_order)."','".$Status."','".date('Y-m-d')."','".$valuationType."','".addslashes($Spiff)."','".addslashes($spiffType)."','".addslashes($spiffAmt)."')";
                                                                                                                                                                                                                                                                 
				$this->query($strSQLQuery, 0);
			}
			
			$lastInsertId = $this->lastInsertId();

			if($ParentID > 0){
				$strUpdateQuery = "update inv_categories set NumSubcategory = NumSubcategory + 1 where CategoryID = '".$ParentID."'";
				$this->query($strUpdateQuery, 0);
			}
			return $lastInsertId;

		}

		

		function UpdateCategory($arryDetails)
		{
		
	
			$MetaTitle=$MetaKeyword=$MetaDescription=$imagedelete='';
			extract($arryDetails);
			
			if($OverrideItem==1){
			
			$dd = implode(',',$arryDetails['ItemID']);
			
			}else{
			
			$dd = '';
			}
			
			
			    if($OverrideItem==0){
            $OverrideItem=0;
            $OverspiffAmt =0.00;
            	$dd='';

         }
			
			
                        global $Config;
                       if($imagedelete == "Yes")
                        {
                               $strSQLQuery = "select Image from inv_categories where CategoryID='".$CategoryID."'"; 
			       $arryRow = $this->query($strSQLQuery, 1);
                               # $ImgDir = '../../upload/category/'.$_SESSION['CmpID'].'/';
				$ImgDir = $Config['FileUploadDir'].$Config['ItemCategory'];

                                unlink($ImgDir.$arryRow[0]['Image']);
			  $strSQLQuery = "update inv_categories set ParentID='".$ParentID."',Name='".addslashes($Name)."',MetaTitle='".addslashes($MetaTitle)."',MetaKeyword='".addslashes($MetaKeyword)."', MetaDescription='".addslashes($MetaDescription)."', CategoryDescription='".addslashes($CategoryDescription)."',sort_order='".$sort_order."', Image='', Status='".$Status."',valuationType='".$valuationType."',Spiff='".addslashes($Spiff)."',spiffType ='".addslashes($spiffType)."',spiffAmt='".addslashes($spiffAmt)."',OverrideItem='" . addslashes($OverrideItem) . "',OverspiffAmt='" . addslashes($OverspiffAmt) . "',itemIds ='" . addslashes($dd) . "' where CategoryID='".$CategoryID."'";
                        }
                    else 
                        {
                    
		     	  $strSQLQuery = "update inv_categories set ParentID='".$ParentID."',Name='".addslashes($Name)."',MetaTitle='".addslashes($MetaTitle)."',MetaKeyword='".addslashes($MetaKeyword)."', MetaDescription='".addslashes($MetaDescription)."', CategoryDescription='".addslashes($CategoryDescription)."',sort_order='".$sort_order."', Status='".$Status."',valuationType='".$valuationType."',Spiff='".addslashes($Spiff)."',spiffType ='".addslashes($spiffType)."',spiffAmt='".addslashes($spiffAmt)."',OverrideItem='" . addslashes($OverrideItem) . "',OverspiffAmt='" . addslashes($OverspiffAmt) . "',itemIds ='" . addslashes($dd) . "' where CategoryID='".$CategoryID."'";
                        }
			$this->query($strSQLQuery, 0);
/************************Update Evaluation Type for item ***************************/
			$strSql = "update inv_items set evaluationType='" . mysql_real_escape_string($valuationType) . "' where CategoryID = '" . $CategoryID . "'";
			$this->query($strSql, 0);
/************************End ******************************************************/
			return 1;
		}

		

		function RemoveCategory($id, $ParentID)
		{
			global $Config;
			$objFunction=new functions();
			$objConfigure=new configure();
			$strSQLQuery = "select Image from inv_categories where CategoryID='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
		 

			if($arryRow[0]['Image'] !='' ){	
				$objFunction->DeleteFileStorage($Config['ItemCategory'],$arryRow[0]['Image']);			
			}			
			
			
			$strSQLQuery = "delete from inv_categories where CategoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			

			if($ParentID > 0){

				$strSQLQuery ="select NumSubcategory from inv_categories where CategoryID='".$ParentID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumSubcategory'])) {
					$strUpdateQuery = "update inv_categories set NumSubcategory = NumSubcategory - 1 where CategoryID = '".$ParentID."'";
					$this->query($strUpdateQuery, 0);
				} 


			}
			return 1;
		}

		function RemoveCategoryCompletly($id)
		{

			$strSQLQuery = "delete from inv_categories where CategoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from inv_categories where ParentID='".$id."'"; 
			$this->query($strSQLQuery, 0);

		
			/******************************/
			$strSQLQuery = "delete from e_products where CategoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);
			
			return 1;
		}

		function changeCategoryStatus($CategoryID)
		{
			$sql="select * from inv_categories where CategoryID='".$CategoryID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update inv_categories set Status='$Status' where CategoryID='".$CategoryID."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function isSubCategoryExists($id)
		{
			$strSQLQuery ="select CategoryID from inv_categories where ParentID='".$id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		function isProductExists($id)
		{
			$strSQLQuery ="select CategoryID from inv_items where CategoryID='".$id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function isCategoryExists($Name,$CategoryID=0,$ParentID=0)
		{

			$strSQLQuery ="select CategoryID from inv_categories where LCASE(Name)='".addslashes(strtolower(trim($Name)))."' and ParentID = '".$ParentID."'";

			$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID != '".$CategoryID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}

		

		function  GetCategoriesListing($id=0,$ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID=0");
			$strAddQuery .= (!empty($id))?(" and c1.CategoryID='".$id."'"):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcategory from inv_categories c1 left outer join inv_categories c2 on c1.ParentID = c2.CategoryID where c1.Status='1' ".$strAddQuery." order by c1.CategoryID";
			return $this->query($strSQLQuery, 1);
		}

		function  GetSubCategoriesListing($id=0,$ParentID,$StoreID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID=0");
			$strAddQuery .= (!empty($id))?(" and c1.CategoryID='".$id."'"):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcategory,sc.StoreCategoryID from inv_categories c1 left outer join inv_categories c2 on c1.ParentID = c2.CategoryID where c1.Status='1' ".$strAddQuery." group by c1.Name order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from inv_categories where ParentID='".$ParentID."' ".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetParentCategories($Status)
		{
			 $strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");
			
			 $strSQLQuery = "select c1.* from inv_categories c1 where ParentID='0' ".$strAddQuery." order by c1.sort_order ";

			return $this->query($strSQLQuery, 1);
		}
		function  GetSubSubCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from inv_categories where ParentID='".$ParentID."'".$strAddQuery." order by CategoryID";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetNumProductsSingle($CategoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from e_products p1 where p1.Status='1'  and p1.CategoryID='".$CategoryID."'".$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}		

		function GetNumProductsMultiple($CategoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from e_products p1 where p1.Status='1'  and p1.CategoryID in( select CategoryID from inv_categories where ParentID='".$CategoryID."' and Status='1')".$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}


	

                function  GettotalActiveCategory()
		{
			
			$strSQLQuery = "select * from inv_categories WHERE Status = '1'";  
			return $this->query($strSQLQuery, 1);
		}

 function sync_category($id) {	         
		$this->insertData = array();
		array_push($this->insertData, ($id));
		$this->getAllData($id);
	 
		return $this->insertData;
	    }

	             
            
    //By Chetan30Sep//
    function invSyncCategory($arr) {
         if($arr['Allselect'] == 'Y')
        {
             $AllCatIds = $this->ListAllCategories();
             $catIds = array_map(function($arr){return $arr['CategoryID'];},$AllCatIds);
             
        }else{
            $catIds = $arr['CategoryID'];
        }    
        if(count($catIds))
        {   
            $this->insertData = array();
            $this->updateData = array();
            foreach ($catIds as $id) 
            {
                $CatName = $this->GetCategory($id);
                $strSQLQuery5 = "select count(*) count from e_categories where item_categoryId =".$id." ";
                $res = $this->query($strSQLQuery5, 1);
                if($res[0]['count'] == 0)
                {
                    $Name = 'Y';
                    $strSQLQuery5 = "select count(*) count from e_categories where Name = '".addslashes($CatName[0]['Name'])."' ";
                    $res = $this->query($strSQLQuery5, 1);
                }
                if($res[0]['count'] == 1){
                    $name= ($Name == 'Y')? $CatName[0]['Name'] : '1';
                    array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0,'Name' => $name)));
                    $this->getAllData($id,2);
                }else{
                    array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));
                    $this->getAllData($id,1);
                }    
            }

            
            for ($i = 0; $i < sizeOf($this->insertData); $i++) {
               
                $strSQLQuery = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
                $this->query($strSQLQuery, 1);
                for ($j = 0; $j < sizeOf($this->insertData); $j++) {
                    $this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
                }
            }
            
            for ($k = 0; $k < sizeOf($this->updateData); $k++) 
            {
                if($this->updateData[$k]['ParentID'] == 0)
                {
                    
                    $this->updateSynCatData($this->updateData[$k]['CategoryID'],$this->updateData[$k]['Name']);
                    
                }else{
                    
                    $SQLQuery5 = "select count(*) count from e_categories where item_categoryId ='".$this->updateData[$k]['CategoryID']."' ";
                    $res5 = $this->query($SQLQuery5, 1);
                    
                    
                    if($res5[0]['count'] == 0)
                    {   
                        $SQLQuery5 = "select count(*) count,ParentID from e_categories where Name = '".addslashes($this->updateData[$k]['Name'])."' AND ParentID !='' ";
                        $res5 = $this->query($SQLQuery5, 1);
                        $name= ($Name == 'Y')? $this->updateData[$k]['Name'] : '1';
                        
                    }
                    
                    if($res5[0]['count'] == 1)
                    {
                        
                        $this->updateSynCatData($this->updateData[$k]['CategoryID'],$name);
                        
                    }else{
                        
                        $strSqlQuery3 = "select CategoryID from e_categories where item_categoryId ='".$this->updateData[$k]['ParentID']."' OR Name = '".$this->updateData[$k]['Name']."'";
                        $resPCatID = $this->query($strSqlQuery3, 1);

                        $strSqlQuery4 = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->updateData[$k]['CategoryID'] . "";
                        $this->query($strSqlQuery4, 1);
                        
                    }
                    
                    
                }
                
            }    
        
        } 
    }

    function getAllData($parentId, $do) {
        $query = mysql_query("select CategoryID,ParentID,Name from inv_categories where ParentID In(" . $parentId . ")");
        while ($row = mysql_fetch_assoc($query)) {
            ($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
            $this->getAllData($row['CategoryID'],$do);
        }
    }
    
    function updateSynCatData($ID,$name)
    {
        $where = ($name != 1) ? "ecat.Name = '".addslashes($name)."'"  : "item_categoryId = '".$ID."'";
        $set = ($name != 1) ? ",ecat.item_categoryId = '".$ID."'"  : "";
        $strSqlQuery2 = "update e_categories ecat,(select * from inv_categories where CategoryID = ".$ID.") old 
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                            ".$set."
                                        where ".$where." "; 
        $result = $this->query($strSqlQuery2, 1);
    }
    
    //End//
    /*************************Add By Bhoodev ***************************/

 function getAppliedAttributeCategory($attrID)
                    {
                            $categories = array();
                            
                            $strSQLQuery = "SELECT * FROM inv_catalog_attributes WHERE Gaid='".mysql_real_escape_string($attrID)."'";
                          
							$arrayRows = $this->query($strSQLQuery, 1);
                            foreach($arrayRows as $val)
                            {
                               $categories[] = trim($val["Cid"]);
                            }
                         return $categories;                            
                    }
                    
function getGlobalAttributeCategories($parentid,$num,$selected=0,$attrID=0) {
                        
                            $sql="select * from inv_categories
                                            where ParentID = '".$parentid."'";
                          
                            $rs=mysql_query($sql);
                            
                            $selectedcategories =  $this->getAppliedAttributeCategory($attrID);


                             
                            if(mysql_num_rows($rs)>0) {
                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                        
                                           if(in_array($row['CategoryID'], $selectedcategories)) {
                                               
                                                    $str="<option style='display:none;' value='".$row['CategoryID']."' selected>".str_repeat("&nbsp;&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            else {
                                                    $str="<option value='".$row['CategoryID']."'>".str_repeat("&nbsp;&nbsp;",$num).$row['Name']."</option>";
                                            }
                                                                                        
                                                echo $str;   
                                       
                                                $this->getGlobalAttributeCategories($row['CategoryID'],$num,$selected,$attrID);
                                             
                                          
                                    }
                            }
                           
                    }
 function getGlobalSelectedCategories($Gaid) {
                        
                              $sql="select a.*, c.CategoryID,c.Name  from inv_catalog_attributes a left outer join inv_categories c on a.Cid = c.CategoryID
                                            where a.Gaid = '".$Gaid."' group by a.Cid"; 
                          
                            $rs=mysql_query($sql);
                            
                            //$selectedcategories =  $this->getAppliedAttributeCategory($attrID);
                             
                            if(mysql_num_rows($rs)>0) {
                                    //$num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                        
                                           
                                               
                                                    $str="<option value='".$row['CategoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                           
                                            
                                                                                        
                                                echo $str;   
                                       
                                                //$this->getGlobalSelectedCategories($row['CategoryID'],$num,$selected,$attrID);
                                             
                                          
                                    }
                            }
                           
                    }
/******************************************************************/
            //by chetan on 7Mar2017 ///
 	var $ophtml;
	function getCategoriesforCustomSearch($parentid,$num,$selected=0){
			   
		$sql="select * from inv_categories where ParentID='".$parentid."' and Status='1' order by Name asc";
		$rs=mysql_query($sql);
		if(mysql_num_rows($rs)>0) {
		    $num=$num+3;
		    while($row=mysql_fetch_array($rs)) {
			    if($selected==$row['CategoryID']) {
				    $str="<option value='".$row['CategoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
			    }
			    else {
				    $str="<option value='".$row['CategoryID']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
			    }
			    
			   $this->ophtml .= $str;   
		       
			   $this->getCategoriesforCustomSearch($row['CategoryID'],$num,$selected);
			     
			  
		    }
		}
		 
	   return $this->ophtml;
	}

}

?>
