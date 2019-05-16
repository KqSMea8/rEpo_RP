<?
class category extends dbClass
{
     public $catids;
    //constructor
		function category()
		{
			$this->dbClass();
		} 
		
		function  ListCategories($ParentID,$SearchKey,$SortBy,$AscDesc)
		{
			
			$strAddQuery = '';
                        $SearchKey   = strtolower(trim($SearchKey));
                      
			/*if($ParentID>0){
				$strAddQuery .= " where c1.ParentID=".$ParentID;
				
			}*/
                       if($SearchKey != "" && $SortBy == "c1.Name")
                        {
                                $strAddQuery .= " where c1.Name like '".$SearchKey."%'";
				
                        }
                        elseif($SearchKey=='active' && ($SortBy=='c1.Status' || $SortBy==''))
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
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%' AND c1.ParentID ='0')"):("");
			}
                        else{
				$strAddQuery .= " where c1.Name like '".$SearchKey."%' AND c1.ParentID ='0'" ;	
			}

                        $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.CategoryID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                        
			//$strSQLQuery = "select c1.CategoryID,c1.Level,c1.Image,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcategory,c1.NumProducts from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID".$strAddQuery ;
                        $strSQLQuery = "select c1.CategoryID,c1.Level,c1.Image,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcategory,c1.NumProducts from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID".$strAddQuery ;
                        //echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}
                
                function  ListAllCategories()
		{
			
			
                        $strSQLQuery = "select CategoryID,Level,Name,Status from e_categories WHERE ParentID ='0'";
			return $this->query($strSQLQuery, 1);
		}
                
               /*function  ListAllCategoriesAndSubcategories()
		{
			
			
                        $strSQLQuery = "select CategoryID,Level,Name,Status from e_categories";
			return $this->query($strSQLQuery, 1);
		}*/

		function  GetCategory($CategoryID)
		{
			
			$strSQLQuery = "select * from e_categories WHERE CategoryID = '".mysql_real_escape_string($CategoryID)."'";  
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetSubCategoryByParent($Status,$ParentID)
		{
                    $strAddQuery='';
			if($Status=='1' || $Status=='active' || $Status=='Active')
			{   
			 $strAddQuery .= " and Status='1'";
			}
			else if($Status=='0' || $Status=='inactive'){
			$strAddQuery .= " and Status='0'";
			}


			$strSQLQuery = "select * from e_categories where ParentID='".$ParentID."' ".$strAddQuery." order by CategoryID";

			return $this->query($strSQLQuery, 1);
		}
                
                
                /*function getCategoryTree($parentid, $num, $str = "") {
                   
                        $sql="select * from e_categories
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
                   $edit = $Config['editImg'];
                   $delete = $Config['deleteImg'];
                 
		    if(empty($cat_title)) $cat_title='Category';

			  $query = "SELECT * FROM e_categories WHERE ParentID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlCat = '';
                                 $num=$num+3;
                            while($values = mysql_fetch_array($result)) { 
                                
                                $htmlCat = '<tr align="left" bgcolor="#ffffff">
                                     <!--By Chetan11Aug-->
                                <td align="center"></td>    
                                <!--End-->
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
                            <td height="26" align="center" class="head1_inner" valign="top">
                                <a href="editCategory.php?edit='.$values['CategoryID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlCat .= '<a href="editCategory.php?del_id='.$values['CategoryID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';
                                

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
                            $sql="select * from e_categories
                                            where ParentID= '".$parentid."'";
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
                            
                            $strSQLQuery = "SELECT * FROM e_promo_categories WHERE PromoID='".mysql_real_escape_string($promID)."'";
			                $arrayRows = $this->query($strSQLQuery, 1);
                            foreach($arrayRows as $val)
                            {
                                    $categories[] = trim($val["CID"]);
                            }
                        return $categories;                            
                    }
                    
                    function getPromoCategories($parentid,$num,$selected=0,$promID=0) {
                        
                            $sql="select * from e_categories
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
                    
                    function getAppliedAttributeCategory($attrID)
                    {
                            $categories = array();
                            
                            $strSQLQuery = "SELECT * FROM e_catalog_attributes WHERE Gaid='".mysql_real_escape_string($attrID)."'";
                          
							$arrayRows = $this->query($strSQLQuery, 1);
                            foreach($arrayRows as $val)
                            {
                               $categories[] = trim($val["Cid"]);
                            }
                         return $categories;                            
                    }
                    
                     function getGlobalAttributeCategories($parentid,$num,$selected=0,$attrID=0) {
                        
                            $sql="select * from e_categories
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
                        	$num=0;
                             $sql="select a.*, c.CategoryID,c.Name  from e_catalog_attributes a left outer join e_categories c on a.Cid = c.CategoryID
                                            where Gaid = '".$Gaid."' group by a.Cid"; 
                          
                            $rs=mysql_query($sql);
                            
			if(!isset($attrID)) $attrID='';
                            $selectedcategories =  $this->getAppliedAttributeCategory($attrID);
                             
                            if(mysql_num_rows($rs)>0) {
                                    //$num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                        
                                           
                                               
                                                    $str="<option value='".$row['CategoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                           
                                            
                                                                                        
                                                echo $str;   
                                       
                                                //$this->getGlobalSelectedCategories($row['CategoryID'],$num,$selected,$attrID);
                                             
                                          
                                    }
                            }
                           
                    }

		function  GetNameByParentID($ParentID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select Name from e_categories where CategoryID = '".$ParentID."' ".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		

		function  GetCategoryNameByID($CategoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select c1.Name,c1.Image,c1.CategoryID,c1.ParentID from e_categories c1 where c1.Status='1' and c1.CategoryID in(".$CategoryID.") ".$strAddQuery." order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
       function  GetSubCategoryByID($CategoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select * from e_categories c1 where c1.Status='1' and c1.ParentID = '".$CategoryID."' order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
                

		function UpdateImage($FieldName,$imageName,$CategoryID)
		{
			 $strSQLQuery = "update e_categories set ".$FieldName."='".$imageName."' where CategoryID='".mysql_real_escape_string($CategoryID)."'";
  			return $this->query($strSQLQuery, 0);
		}

		function AddCategory($arryDetails)
		{ 
			extract($arryDetails);

			$NameArray = explode('#',$Name);
			foreach($NameArray as $Name){
				$Name = ucfirst(trim($Name));
				$strSQLQuery = "insert into e_categories (ParentID,Name,MetaTitle,MetaKeyword,MetaDescription,CategoryDescription,sort_order,Status,AddedDate) 
                                                                                                                                  values('".$ParentID."','".addslashes($Name)."','".addslashes($MetaTitle)."','".addslashes($MetaKeyword)."','".addslashes($MetaDescription)."','".addslashes($CategoryDescription)."','".addslashes($sort_order)."','".$Status."','".date('Y-m-d')."')";
				$this->query($strSQLQuery, 0);
			}
			
			$lastInsertId = $this->lastInsertId();

			if($ParentID > 0){
				$strUpdateQuery = "update e_categories set NumSubcategory = NumSubcategory + 1 where CategoryID = '".mysql_real_escape_string($ParentID)."'";
				$this->query($strUpdateQuery, 0);
			}
			return $lastInsertId;

		}

		

		function UpdateCategory($arryDetails)
		{
			extract($arryDetails);
                        
                       if($imagedelete == "Yes")
                        {
				$strSQLQuery = "select Image from e_categories where CategoryID='".$CategoryID."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				$ImgDir = '../../upload/category/'.$_SESSION['CmpID'].'/';
				unlink($ImgDir.$arryRow[0]['Image']);
							$strSQLQuery = "update e_categories set ParentID='".$ParentID."',Name='".addslashes($Name)."',MetaTitle='".addslashes($MetaTitle)."',MetaKeyword='".addslashes($MetaKeyword)."', MetaDescription='".addslashes($MetaDescription)."', CategoryDescription='".addslashes($CategoryDescription)."',sort_order='".$sort_order."', Image='', Status='".$Status."' where CategoryID='".mysql_real_escape_string($CategoryID)."'";
                        }
                    else 
                        {
                    
						$strSQLQuery = "update e_categories set ParentID='".$ParentID."',Name='".addslashes($Name)."',MetaTitle='".addslashes($MetaTitle)."',MetaKeyword='".addslashes($MetaKeyword)."', MetaDescription='".addslashes($MetaDescription)."', CategoryDescription='".addslashes($CategoryDescription)."',sort_order='".$sort_order."', Status='".$Status."' where CategoryID='".mysql_real_escape_string($CategoryID)."'";
						}
						$this->query($strSQLQuery, 0);

						return 1;
		}

		

		function RemoveCategory($id, $ParentID)
		{
			/*$objConfigure=new configure();
			$strSQLQuery = "select Image from e_categories where CategoryID='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			 
			$ImgDir = '../../upload/category/'.$_SESSION['CmpID'].'/';
			

			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){				$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);	
				unlink($ImgDir.$arryRow[0]['Image']);	
			}*/			
			
			global $Config;
			$objConfigure=new configure();
			$objFunction=new functions();
			$strSQLQuery = "select Image from e_categories where CategoryID='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
	
			if($arryRow[0]['Image'] != '') {  
			    $objFunction->DeleteFileStorage($Config['ProductsCategory'],$arryRow[0]['Image']); 
			}

			$strSQLQuery = "delete from e_categories where CategoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			

			if($ParentID > 0){

				$strSQLQuery ="select NumSubcategory from e_categories where CategoryID='".$ParentID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumSubcategory'])) {
					$strUpdateQuery = "update e_categories set NumSubcategory = NumSubcategory - 1 where CategoryID = '".$ParentID."'";
					$this->query($strUpdateQuery, 0);
				} 


			}
			return 1;
		}

		function RemoveCategoryCompletly($id)
		{

			$strSQLQuery = "delete from e_categories where CategoryID = '".mysql_real_escape_string($id)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from e_categories where ParentID = '".mysql_real_escape_string($id)."'";
			$this->query($strSQLQuery, 0);

		
			/******************************/
			$strSQLQuery = "delete from e_products where CategoryID = '".mysql_real_escape_string($id)."'";
			$this->query($strSQLQuery, 0);
			
			return 1;
		}

		function changeCategoryStatus($CategoryID)
		{
			$sql="select * from e_categories where CategoryID= '".mysql_real_escape_string($CategoryID)."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update e_categories set Status='$Status' where CategoryID = '".mysql_real_escape_string($CategoryID)."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function isSubCategoryExists($id)
		{
			$strSQLQuery ="select * from e_categories where ParentID='".mysql_real_escape_string($id)."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		function isProductExists($id)
		{
			$strSQLQuery ="select * from e_products where CategoryID='".mysql_real_escape_string($id)."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function isCategoryExists($Name,$CategoryID=0,$ParentID=0)
		{

			$strSQLQuery ="select CategoryID from e_categories where LCASE(Name)='".addslashes(strtolower(trim($Name)))."' and ParentID = '".$ParentID."'";

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
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID='0'");
			$strAddQuery .= (!empty($id))?(" and c1.CategoryID='".$id."'"):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcategory from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID where c1.Status='1' ".$strAddQuery." order by c1.CategoryID";
			return $this->query($strSQLQuery, 1);
		}

		function  GetSubCategoriesListing($id=0,$ParentID,$StoreID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID='0'");
			$strAddQuery .= (!empty($id))?(" and c1.CategoryID='".$id."'"):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcategory,sc.StoreCategoryID from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID where c1.Status='1' ".$strAddQuery." group by c1.Name order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from e_categories where ParentID='".$ParentID."' ".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetParentCategories($Status)
		{
			 $strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");
			
			 $strSQLQuery = "select c1.* from e_categories c1 where ParentID='0' ".$strAddQuery." order by c1.sort_order ";

			return $this->query($strSQLQuery, 1);
		}
		function  GetSubSubCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from e_categories where ParentID='".$ParentID."' ".$strAddQuery." order by CategoryID";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetNumProductsSingle($CategoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from e_products p1 where p1.Status='1'  and p1.CategoryID='".$CategoryID."' ".$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}		

		 

        function  GettotalActiveCategory()
		{
			$strSQLQuery = "select * from e_categories WHERE Status = '1'";  
			return $this->query($strSQLQuery, 1);
		}

                
    //By Chetan30Sep//
    function sync_category($arr) {
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
                $strSQLQuery5 = "select count(*) count from inv_categories where e_categoryId ='".$id."'";
                $res = $this->query($strSQLQuery5, 1);
                if($res[0]['count'] == 0)
                {
                    $Name = 'Y';
                    $strSQLQuery5 = "select count(*) count from inv_categories where Name = '".addslashes($CatName[0]['Name'])."' ";
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
                $added = date("Y-m-d");
                $strSQLQuery = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from e_categories WHERE CategoryID = '" . $this->insertData[$i]['CategoryID'] . "'";
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
                    
                    $SQLQuery5 = "select count(*) count from inv_categories where e_categoryId ='".$this->updateData[$k]['CategoryID']."'";
                    $res5 = $this->query($SQLQuery5, 1);
                    
                    if($res5[0]['count'] == 0)
                    {   
                        $SQLQuery5 = "select count(*) count,ParentID from inv_categories where Name = '".addslashes($this->updateData[$k]['Name'])."' AND ParentID !='' ";
                        $res5 = $this->query($SQLQuery5, 1);
                        $name= ($Name == 'Y')? $this->updateData[$k]['Name'] : '1';
                        
                    }
                        
                    if($res5[0]['count'] == 1)
                    {
                        
                        $this->updateSynCatData($this->updateData[$k]['CategoryID'],$name);
                        
                    }else{
                        
                        $strSqlQuery3 = "select CategoryID from inv_categories where e_categoryId ='".$this->updateData[$k]['ParentID']."'";
                        $resPCatID = $this->query($strSqlQuery3, 1);

                        $strSqlQuery4 = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from e_categories WHERE CategoryID = '" . $this->updateData[$k]['CategoryID'] . "'";
                        $this->query($strSqlQuery4, 1);
                        
                    }
                    
                    
                }
                
            } 
        }    
    }

    function getAllData($parentId, $do) {
        $query = mysql_query("select CategoryID,ParentID,Name from e_categories where ParentID In(" . $parentId . ")");
        while ($row = mysql_fetch_assoc($query)) {
           ($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
            $this->getAllData($row['CategoryID'],$do);
        }
    }
    
    function updateSynCatData($ID)
    {
        $where = ($name != 1) ? "ecat.Name = '".addslashes($name)."'"  : "e_categoryId = '".$ID."'";
        $set = ($name != 1) ? ",ecat.e_categoryId = '".$ID."'"  : "";
        $strSqlQuery2 = "update inv_categories ecat,(select * from e_categories where CategoryID = '".$ID."') old 
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
    
    
    function  GettotalActiveCategoryCurrentYear()
		{
			$strSQLQuery = "select * from e_categories WHERE (DATE(AddedDate) BETWEEN '".date('Y').'-01-01'."' AND '".date('Y').'-12-31'."') AND Status = '1'";  
			return $this->query($strSQLQuery, 1);
		}


}

?>
