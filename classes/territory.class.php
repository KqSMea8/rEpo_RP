<?
class territory extends dbClass
{
		//constructor
		function territory()
		{
			$this->dbClass();
		} 
		
		function  ListTerritories($ParentID,$SearchKey,$SortBy,$AscDesc)
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
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%' AND c1.ParentID ='0')"):("");
			}
                        else{
				$strAddQuery .= " where c1.ParentID ='0'" ;	
			}

                        $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.Name ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" asc");
                        
			
			//$strSQLQuery = "select c1.TerritoryID,c1.Level,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubTerritory from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.TerritoryID".$strAddQuery.$OrderBy;
            
			//$strSQLQuery = "select c1.TerritoryID,c1.Level,c1.Name,c1.sort_order,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubTerritory from c_territory c1 left outer join c_territory c2 on c1.ParentID = c2.TerritoryID".$strAddQuery.$OrderBy;
                       
			$strSQLQuery = "select c1.* from c_territory c1 ".$strAddQuery;//$OrderBy;
		// echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}
                
                function  ListAllCategories()
		{
			
			
                         $strSQLQuery = "select TerritoryID,Name,Status from c_territory WHERE ParentID ='0' order by name"; 
			return $this->query($strSQLQuery, 1);
		}
                
         
                
                function getTerritoryOption($parentid,$num,$selected=0) {
                            $sql="select * from c_territory
                                            where ParentID= '".$parentid."' and Status ='1' order by Name";
                            $rs=mysql_query($sql);
                            if(mysql_num_rows($rs)>0) {
                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                            if($selected==$row['TerritoryID']) {
                                                    $str="<option value='".$row['TerritoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            else {
                                                
                                                   if($row['ParentID'] == 0){
                                                    $str="<option value='".$row['TerritoryID']."' disabled='disabled'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                                   }else{
                                                       $str="<option value='".$row['TerritoryID']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                                   }
                                            }
                                            
                                             echo $str;   
                                       
                                                $this->getTerritoryOption($row['TerritoryID'],$num,$selected);
                                             
                                          
                                    }
                            }
                           
                    }

		function  GetTerritory($TerritoryID)
		{
			
			 $strSQLQuery = "select * from c_territory WHERE TerritoryID = '".$TerritoryID."'";  
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetSubTerritoryByParent($Status,$ParentID)
		{
			$strAddQuery = '';   
			if($Status=='1' || $Status=='active' || $Status=='Active')
			{   
					  $strAddQuery .= " and Status='1'";
			}
			else if($Status=='0' || $Status=='inactive'){
				$strAddQuery .= " and Status='0'";
			}
                        

			$strSQLQuery = "select * from c_territory where ParentID='".$ParentID."'".$strAddQuery." order by Name asc";
                        
			return $this->query($strSQLQuery, 1);
		}
                
                
                /*function getTerritoryTree($parentid, $num, $str = "") {
                   
                        $sql="select * from c_territory
                                        where ParentID = '".$parentid."'";
                        print $sql."<br>";
                        $rs=mysql_query($sql);
                        if(mysql_num_rows($rs)>0) {
                                $num=$num+3;
                                while($row=mysql_fetch_array($rs)) {
                                        $str = $str.str_repeat("&nbsp;",$num).$row["Name"]."<br>";
                                        $this->getTerritoryTree($row["TerritoryID"],$num, $str);
                                        print $str;
                                }
                        }
                        return $str;
                }*/




                function  GetSubTerritoryTree($ParentID,$num)
		{
                   global $Config;
                   $edit = $Config['editImg'];
                   $delete = $Config['deleteImg'];
					$cat_title = "Sub Territory";
			  $query = "SELECT * FROM c_territory WHERE ParentID ='".$ParentID."' order by Name asc";
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
                                            <a href="editTerritory.php?edit='.$values['TerritoryID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">';
                                           
                                              $htmlCat .= str_repeat("&nbsp;&nbsp;",$num);
                                              
                                              $htmlCat .= ' - <b>'.stripslashes($values['Name']).'</b>
                                            </a>
                                        </td>
                                    </tr>
                                </table></td>
                           
                            <td align="center" >';  
                                if ($values['Status'] == 1) {
                                    $status = 'Active';
                                } else {
                                    $status = 'InActive';
                                }



                        $htmlCat .= '<a href="editTerritory.php?active_id=' . $values["TerritoryID"] . '&ParentID=' . $values['ParentID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>
                        
                        </td>
                            <td height="26" class="head1_inner" align="center"  valign="top">
                                <a href="editTerritory.php?edit='.$values['TerritoryID'].'&ParentID='.$values['ParentID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlCat .= '<a href="editTerritory.php?del_id='.$values['TerritoryID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentID'].'" onclick="return confDel(\''.$cat_title.'\')" class="Blue" >'.$delete.'</a>';
                                

                                $htmlCat .= '&nbsp;</td>
                        </tr>';
                                  
                                  echo $htmlCat;
                                  
                                  
                                  if($values['ParentID'] > 0)
                                  {
                                    $this->GetSubTerritoryTree($values['TerritoryID'],$num); 
                                  }
                                }  
             
		}

		function getCategories($parentid,$num,$selected=0) {
                            $sql="select * from c_territory
                                            where ParentID='".$parentid."'";
                            $rs=mysql_query($sql);
                            if(mysql_num_rows($rs)>0) {
                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
                                            if($selected==$row['TerritoryID']) {
                                                    $str="<option value='".$row['TerritoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            else {
                                                    $str="<option value='".$row['TerritoryID']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                            }
                                            
                                             echo $str;   
                                       
                                                $this->getCategories($row['TerritoryID'],$num,$selected);
                                             
                                          
                                    }
                            }
                           
                    }
                    
               
                    
                 

		function  GetNameByParentID($ParentID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select Name from c_territory where TerritoryID = '".$ParentID."'".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		

		function  GetTerritoryNameByID($TerritoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select c1.Name,c1.TerritoryID,c1.ParentID from c_territory c1 where c1.Status='1' and c1.TerritoryID in(".$TerritoryID.") ".$strAddQuery." order by c1.Name "; 
			return $this->query($strSQLQuery, 1);
		}
                
                function  GetSubTerritoryByID($TerritoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select * from c_territory c1 where c1.Status='1' and c1.ParentID = '".$TerritoryID."' order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}
                
                


		function AddTerritory($arryDetails)
		{ 
			extract($arryDetails);

			$NameArray = explode('#',$Name);
			foreach($NameArray as $Name){
				$Name = ucfirst(trim($Name));
				$strSQLQuery = "insert into c_territory (ParentID,Name,sort_order,Status,AddedDate) 
                                                                                                                                  values('".$ParentID."','".addslashes($Name)."','".addslashes($sort_order)."','".$Status."','".date('Y-m-d')."')";
				$this->query($strSQLQuery, 0);
			}
			
			$lastInsertId = $this->lastInsertId();

			if($ParentID > 0){
				$strUpdateQuery = "update c_territory set NumSubTerritory = NumSubTerritory + 1 where TerritoryID = '".$ParentID."'";
				$this->query($strUpdateQuery, 0);
			}
			return $lastInsertId;

		}

		

		function UpdateTerritory($arryDetails)
		{
			extract($arryDetails);
                        
                       if($imagedelete == "Yes")
                        {
                               $strSQLQuery = "select Image from c_territory where TerritoryID='".$TerritoryID."'"; 
			       $arryRow = $this->query($strSQLQuery, 1);
                                $ImgDir = '../../upload/Territory/';
                                unlink($ImgDir.$arryRow[0]['Image']);
			  $strSQLQuery = "update c_territory set ParentID='".$ParentID."',Name='".addslashes($Name)."',sort_order='".$sort_order."', Image='', Status='".$Status."' where TerritoryID='".$TerritoryID."'";
                        }
                    else 
                        {
                    
		     	  $strSQLQuery = "update c_territory set ParentID='".$ParentID."',Name='".addslashes($Name)."',sort_order='".$sort_order."', Status='".$Status."' where TerritoryID='".$TerritoryID."'";
                        }
			$this->query($strSQLQuery, 0);

			return 1;
		}

		

		function RemoveTerritory($id, $ParentID)
		{
			$objConfigure=new configure();
			
			
			$strSQLQuery = "delete from c_territory where TerritoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			/**************/
			$strSQLQuery ="select TRID from c_territory_rule where TerritoryID='".$id."'";
			$arryTr = $this->query($strSQLQuery, 1);
			
			$sql = "delete from c_territory_rule where TerritoryID = '".$id."'";
			$rs = $this->query($sql,0);
			if($arryTr[0]['TRID']>0){
				$sql2 = "delete from c_territory_rule_location where TRID = '".$arryTr[0]['TRID']."'";
				$rs2 = $this->query($sql2,0);
			}
			/**************/
			
			
			
			

			if($ParentID > 0){

				$strSQLQuery ="select NumSubTerritory from c_territory where TerritoryID='".$ParentID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumSubTerritory'])) {
					$strUpdateQuery = "update c_territory set NumSubTerritory = NumSubTerritory - 1 where TerritoryID = '".$ParentID."'";
					$this->query($strUpdateQuery, 0);
				} 


			}
			
			
			
			return 1;
		}

		function RemoveTerritoryCompletly($id)
		{

			$strSQLQuery = "delete from c_territory where TerritoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from c_territory where ParentID='".$id."'"; 
			$this->query($strSQLQuery, 0);

		
			/******************************/
			/*$strSQLQuery = "delete from e_products where TerritoryID='".$id."'"; 
			$this->query($strSQLQuery, 0);*/
			
			return 1;
		}

		function changeTerritoryStatus($TerritoryID)
		{
			$sql="select * from c_territory where TerritoryID='".$TerritoryID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_territory set Status='$Status' where TerritoryID='".$TerritoryID."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function isSubTerritoryExists($id)
		{
			$strSQLQuery ="select TerritoryID from c_territory where ParentID='".$id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['TerritoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		function isProductExists($id)
		{
			$strSQLQuery ="select TerritoryID from inv_items where TerritoryID='".$id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['TerritoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function isTerritoryExists($Name,$TerritoryID=0,$ParentID=0)
		{

			$strSQLQuery ="select TerritoryID from c_territory where LCASE(Name)='".strtolower(trim($Name))."' and ParentID = '".$ParentID."'";

			$strSQLQuery .= (!empty($TerritoryID))?(" and TerritoryID != '".$TerritoryID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['TerritoryID'])) {
				return true;
			} else {
				return false;
			}
		}

		

		function  GetCategoriesListing($id=0,$ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID='0'");
			$strAddQuery .= (!empty($id))?(" and c1.TerritoryID='".$id."'"):("");

			$strSQLQuery = "select c1.TerritoryID,c1.Name,c1.ParentID, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubTerritory from c_territory c1 left outer join c_territory c2 on c1.ParentID = c2.TerritoryID where c1.Status='1' ".$strAddQuery." order by c1.TerritoryID";
			return $this->query($strSQLQuery, 1);
		}

		function  GetSubCategoriesListing($id=0,$ParentID,$StoreID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID='".$ParentID."'"):(" and c1.ParentID='0'");
			$strAddQuery .= (!empty($id))?(" and c1.TerritoryID='".$id."'"):("");

			$strSQLQuery = "select c1.TerritoryID,c1.Name,c1.ParentID, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubTerritory,sc.StoreTerritoryID from c_territory c1 left outer join c_territory c2 on c1.ParentID = c2.TerritoryID where c1.Status='1' ".$strAddQuery." group by c1.Name order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetTerritoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from c_territory where ParentID='".$ParentID."'".$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetParentCategories($Status)
		{
			 $strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");
			
			 $strSQLQuery = "select c1.* from c_territory c1 where ParentID='0' ".$strAddQuery." order by c1.sort_order ";

			return $this->query($strSQLQuery, 1);
		}
		function  GetSubSubTerritoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from c_territory where ParentID='".$ParentID."'".$strAddQuery." order by TerritoryID";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetNumProductsSingle($TerritoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from e_products p1 where p1.Status='1'  and p1.TerritoryID=".$TerritoryID.$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}		

		function GetNumProductsMultiple($TerritoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from e_products p1 where p1.Status='1'  and p1.TerritoryID in( select TerritoryID from c_territory where ParentID='".$TerritoryID."' and Status='1')".$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}


	

                function  GettotalActiveTerritory()
		{
			
			$strSQLQuery = "select * from c_territory WHERE Status = '1'";  
			return $this->query($strSQLQuery, 1);
		}
                
                function  ListTerritoryRule($id=0, $SearchKey,$SortBy,$AscDesc)
                {
                        $strAddQuery = " where 1";
                        $SearchKey   = strtolower(trim($SearchKey));
                        
                        if(!empty($id)){$strAddQuery .= " AND r.TRID = '".$id."'";}
                        
                        $strAddQuery .= (!empty($SearchKey))?(" and (h.UserName like '%".$SearchKey."%' or t.Name like '%".$SearchKey."%' )"):("");


                        $strAddQuery .= (!empty($SortBy))?(" order by '".$SortBy."' "):(" order by Name ");
                        $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" asc ");

                        $strSQLQuery = "select r.*,t.Name,h.EmpID,h.EmpCode from c_territory_rule as r left outer join c_territory as t on t.TerritoryID = r.TerritoryID left outer join h_employee as h on h.EmpID = r.SalesPersonID".$strAddQuery;
                         //echo "=>".$strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);

                }
                
                function  GetTerritoryRuleLocation($TRID) 
		{	$strAddQuery='';
			$strAddQuery .= (!empty($TRID))?(" and r.TRID='".$TRID."'"):("");
			
                        $strSQLQuery = "select r.* from c_territory_rule_location r  where 1".$strAddQuery." order by r.TRLID asc";
			return $this->query($strSQLQuery, 1);
		}


		function  GetLocationByTerritory($TRID) 
		{
			$strAddQuery .= (!empty($TRID))?(" and t.TerritoryID in (".$TRID.") "):("");
			
                        $strSQLQuery = "select l.*,t.Name from c_territory_rule_location l inner join c_territory_rule r on l.TRID=r.TRID inner join c_territory t on r.TerritoryID=t.TerritoryID  where 1 ".$strAddQuery." order by t.Name asc"; 
			return $this->query($strSQLQuery, 1);
		}
                

		
                

                function addTerritoryRule($arryDetails)
		{
                        global $Config;
			extract($arryDetails);
                        $ipaddress = GetIPAddress(); 
                        $strSQLQuery = "INSERT INTO c_territory_rule SET TerritoryID = '".$TerritoryID."', SalesPersonID='".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', CreatedDate='".$Config['TodayDate']."',IPAddress = '".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			$TRID = $this->lastInsertId();
                        return $TRID;
                        
                }   
                
                function addTerritoryRuleLocation($TRID, $arryDetails){
                    
                    
                        global $Config;
			extract($arryDetails);
                        for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['country_id'.$i])){
                                    
                                        $sql = "insert into c_territory_rule_location(TRID, country, state, city) values('".$TRID."', '".trim($arryDetails['country_id'.$i])."', '".trim($arryDetails['state_id'.$i])."', '".trim($arryDetails['city_id'.$i])."')";
					$this->query($sql, 0);
                                    
                                    }
                                }
                    
                }
                
                
                function RemoveTerritoryRule($TRID)
                {


                    $sql = "delete from c_territory_rule where TRID = '".$TRID."'";
                    $rs = $this->query($sql,0);

                    $sql2 = "delete from c_territory_rule_location where TRID = '".$TRID."'";
                    $rs2 = $this->query($sql2,0);

                 
                    if(sizeof($rs))
                            return true;
                    else
                            return false;

                }
                
                function getParentTerritoryParentID($TerritoryID){
                    
                    $strSQLQuery = "select TerritoryID,ParentID from c_territory WHERE Status = '1' and TerritoryID='".$TerritoryID."'";  
                   // echo "=>".$strSQLQuery;exit;
		    $rowTerritory = $this->query($strSQLQuery, 1);
                    foreach($rowTerritory as $value){
                        
                                $ParentID = $value['ParentID'];
                                $TerritoryID = $value['TerritoryID'];
                               
				 if($ParentID != 0)
				 {   
                                   
				   $TerritoryID =  $this->getParentTerritoryParentID($ParentID);
				 }
                                 else {
                                     
                                     return $TerritoryID;
                                    
                                 }
                                 return $TerritoryID;
                    }
                    
                }
                
                
                
         function getParentIDTerritory($TerritoryID){
                    
                    $strSQLQuery = "select TerritoryID,ParentID from c_territory WHERE TerritoryID='".$TerritoryID."'";  
                   // echo "=>".$strSQLQuery;exit;		    			
                    return $this->query($strSQLQuery, 1);
                    
                }
                        
                
                
            function getParentTerritoryName($TerritoryID)
            {
                    $strSQLQuery = "select Name as ParentTerritory from c_territory WHERE Status = '1' and TerritoryID='".$TerritoryID."'";  
                    //echo "=>".$strSQLQuery;
		    $rowTerritory = $this->query($strSQLQuery, 1);
                   
                    return $rowTerritory[0]['ParentTerritory'];
            }
            
            function getTerritoryByCountryID($country_id){
                
                 $strSQLQuery = "select l.TRLID,l.country,t.Name,t.TerritoryID,r.TRID from c_territory_rule_location as l inner join c_territory_rule as r on r.TRID = l.TRID inner join c_territory as t on t.TerritoryID = r.TerritoryID where l.country = '".$country_id."'";
                 
                 return $this->query($strSQLQuery, 1);
                
                
            }
            
            function checkTerritory($TerritoryID){
                
                   $strSQLQuery = "select TerritoryID from c_territory_rule WHERE TerritoryID='".$TerritoryID."'";  
                  
		   $rowTerritory = $this->query($strSQLQuery, 1);
                   
                   return $rowTerritory[0]['TerritoryID'];
                   
                
            }
            
            function getCityIDByTerritory($TerritoryList,$country){
                
                $strSQLQuery = "select l.TRLID,l.country,l.state,l.city,t.Name,t.TerritoryID,r.TRID from c_territory_rule_location as l left outer join c_territory_rule as r on r.TRID = l.TRID left outer join c_territory as t on t.TerritoryID = r.TerritoryID where t.TerritoryID = '".$TerritoryList."' and l.country='".$country."'";
                //echo "=>".$strSQLQuery;exit;
                
                return $this->query($strSQLQuery, 1);
                
                //$row =  $this->query($strSQLQuery, 1);
                //return $row[0]['city']; 
                
            }
            
            function getCustomerByTerritory($city,$state,$country){
                
                        global $Config;
                        $strAddQuery = 'where 1';
			 
			if(!empty($city)){
				$strAddQuery .= " and ab.city_id in (".$city.")"; 
			} 
                        if(!empty($state)){
				$strAddQuery .= " and ab.state_id in (".$state.")"; 
			} 
                        if(!empty($country)){
				$strAddQuery .= " and ab.country_id in (".$country.")"; 
			} 
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.FullName ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");
                
                $SqlCustomer = "select c1.*,ab.CountryName ,ab.StateName,ab.CityName from s_customers c1 left outer join s_address_book ab ON (c1.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery;
		//echo "=>".$SqlCustomer;exit;	
                return $this->query($SqlCustomer, 1);
                
            }
            
            function addTerritoryManager($TRID,$SalesPersonID,$SalesPerson){
                
                 $strSQLQuery = "update c_territory_rule set SalesPersonID = '".$SalesPersonID."', SalesPerson = '".$SalesPerson."' WHERE TRID='".$TRID."'";  
                 $this->query($strSQLQuery, 1);
                 return 1;
                
            }
            
            function getLeadByTerritory($city,$state,$country){
                
                        global $Config;
                        $strAddQuery = 'where 1';
			 
			if(!empty($city)){
				$strAddQuery .= " and l.city_id in (".$city.")"; 
			} 
                        if(!empty($state)){
				$strAddQuery .= " and l.state_id in (".$state.")"; 
			} 
                        if(!empty($country)){
				$strAddQuery .= " and l.country_id in (".$country.")"; 
			} 
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):("  order by l.leadID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                
                 
                 #$strSQLQuery = "select  l.*,e.UserName as AssignTo  from c_lead l  left outer join  h_employee e on e.EmpID=l.AssignTo " . $strAddQuery . "";
                 $strSQLQuery = "select  l.* from c_lead l " . $strAddQuery . "";
		//echo "=>".$strSQLQuery;exit;	
                
                return $this->query($strSQLQuery, 1);
                
            }
            
            function  SalesReportTerritory($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$SalesPID,$Status)
		{

			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.OrderDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.OrderDate)='".$Month."' and YEAR(o.OrderDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode in (".$CustCode.")"):("");
			$strAddQuery .= (!empty($SalesPID))?(" and o.SalesPersonID='".$SalesPID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select o.OrderDate, o.PostedDate, o.OrderID, o.SaleID, o.CustCode, o.CustomerName, o.SalesPersonID,o.SalesPerson, o.CustomerCurrency, o.Freight, o.discountAmnt, o.taxAmnt, o.TotalAmount, o.Status,o.Approved  from s_order o where o.Module='Order' ".$strAddQuery." order by o.OrderDate desc";
				//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
            function getTerritoryLocation($TerritoryID){
                
                $strSQLQuery = "select l.TRLID,l.country,l.state,l.city,t.Name,t.TerritoryID,r.TRID from c_territory_rule_location as l left outer join c_territory_rule as r on r.TRID = l.TRID left outer join c_territory as t on t.TerritoryID = r.TerritoryID where t.TerritoryID = '".$TerritoryID."'";
                //echo "=>".$strSQLQuery;exit;
                
                return $this->query($strSQLQuery, 1);
                 
                
            }
            
            
           /**************************************************/
            
            
     /***********Territory Assign Start ****************/
    function GetTerritoryByAssign($AssignTo)
    {        
        $strSQLQuery = " select a.TerritoryID,e.UserName from c_territory_assign a inner join h_employee e on a.AssignTo=e.EmpID where a.AssignTo='".$AssignTo."' Order by e.UserName Asc";   
 
        return $this->query($strSQLQuery, 1);
    }         
            
    function GetTerritoryAssign($arryDetails)
    {
        extract($arryDetails);   
               
        if(!empty($AssignTo)) $strAddQuery .= " and a.AssignTo='".$AssignTo."'";
        if(!empty($TerritoryID)) $strAddQuery .= " and a.TerritoryID='".$TerritoryID."'";
       
        $strSQLQuery = " select a.*,e.UserName,if(a.ManagerID>0,e2.UserName,'') as ManagerName from c_territory_assign a left outer join h_employee e on a.AssignTo=e.EmpID left outer join h_employee e2 on a.ManagerID=e2.EmpID where 1 ".$strAddQuery." Order by e.UserName Asc";   
 
        return $this->query($strSQLQuery, 1);
    }


    function GetTerritoryManager($TerritoryID,$EmpID)
    {
        #if(!empty($TerritoryID)) $strAddQuery .= " and a.TerritoryID in (".$TerritoryID.")";
		$strAddQuery = '';
        $arryTerri = explode(",",$TerritoryID);
        if(sizeof($arryTerri)>0){
            $strAddQuery .= " and ( ";
            foreach($arryTerri as $terriID){
                if($terriID>0) $strAddQuery .= "FIND_IN_SET (".$terriID.",a.TerritoryID)  OR ";
            }
            $strAddQuery = rtrim($strAddQuery, " OR ");
            $strAddQuery .= " ) ";
        }
        $strAddQuery .= " and a.ManagerID='0' and a.AssignType='Manager' ";
        if(!empty($EmpID)) $strAddQuery .= " and a.AssignTo!='".$EmpID."'";
       
        $strSQLQuery = " select a.*, e.UserName from c_territory_assign a inner join h_employee e on a.AssignTo=e.EmpID  where 1 ".$strAddQuery." Order by e.UserName Asc";   
 
        return $this->query($strSQLQuery, 1);
    }

    function GetSalesPerson($TerritoryID,$ManagerID)
    {
		$strAddQuery = '';
        if(!empty($TerritoryID)) $strAddQuery .= " and FIND_IN_SET (".$TerritoryID.",a.TerritoryID)";

        if(!empty($ManagerID)) $strAddQuery .= " and a.ManagerID='".$ManagerID."'";
       
        $strSQLQuery = " select a.AssignTo,a.ManagerID, e.UserName from c_territory_assign a inner join h_employee e on a.AssignTo=e.EmpID  where 1 and a.AssignType='Sales Person' ".$strAddQuery." Order by e.UserName Asc";   
 
        return $this->query($strSQLQuery, 1);
    }

    function UpdateTerritoryAssign($arryDetails){  
            global $Config;
            extract($arryDetails);

            $IPAddress = GetIPAddress(); 

            if(sizeof($TerritoryID)>0){
                $TerritoryIDVal = implode(",", $TerritoryID); 
            }



            if(!empty($EmpID)){
                $sql = "select * from c_territory_assign where AssignTo='".$EmpID."' ";
                $arryRow = $this->query($sql, 1);
   
                if($arryRow[0]['AssignID']>0){

                    if($TerritoryIDVal=='None'){
                    $strSQLQuery = "delete from c_territory_assign where AssignID ='".$arryRow[0]['AssignID']."'";
                    }else{
                    $strSQLQuery = "update c_territory_assign set AssignType='".mysql_real_escape_string(strip_tags($AssignType))."', TerritoryID='".mysql_real_escape_string(strip_tags($TerritoryIDVal))."', ManagerID='".mysql_real_escape_string(strip_tags($MainManagerID))."'
 where AssignID='".$arryRow[0]['AssignID']."'" ;
                    }
$this->query($strSQLQuery, 0);     
                }else if(!empty($AssignType) && $TerritoryID!='None'){
                    $strSQLQuery = "insert into c_territory_assign (AssignTo, AssignType, TerritoryID, ManagerID, AddedDate, IPAddress) values('".mysql_real_escape_string($EmpID)."', '".mysql_real_escape_string($AssignType)."', '".mysql_real_escape_string(strip_tags($TerritoryIDVal))."', '".mysql_real_escape_string(strip_tags($MainManagerID))."','".$Config['TodayDate']."', '".$IPAddress."' )";
$this->query($strSQLQuery, 0);     
                }
               

            }
 
            return 1;
 
        }


    function getTerritoryOptionMulti($parentid,$num,$selected=0) {
                    $sql="select * from c_territory
                                    where ParentID= '".$parentid."' and Status ='1' order by Name";
                    $rs=mysql_query($sql);
                    if(mysql_num_rows($rs)>0) {


            if(!empty($selected)){
                $TerritoryArray = explode(",", $selected);
            }else{
                $TerritoryArray[] = '';
            }

                                    $num=$num+3;
                                    while($row=mysql_fetch_array($rs)) {
 

					



                                            if(in_array($row['TerritoryID'],$TerritoryArray)){
                                                    $str="<option value='".$row['TerritoryID']."' selected>".str_repeat("&nbsp;",$num).$row['Name']." </option>";
                                            }
                                            else {
                                                
                                                   if($row['ParentID'] == 0){
                                                    $str="<option value='".$row['TerritoryID']."' disabled='disabled'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
                                                   }else{
                                                       $str="<option value='".$row['TerritoryID']."'>".str_repeat("&nbsp;",$num).$row['Name']." </option>";
                                                   }
                                            }
                                            
                                             echo $str;   
                                       
                                                $this->getTerritoryOptionMulti($row['TerritoryID'],$num,$selected);
                                             
                                          
                                    }
                            }
                           
                    }

 
    function  GetTerritoryMulti($TerritoryID){         
        $strSQLQuery = "select * from c_territory WHERE TerritoryID in (".$TerritoryID.") order by Name asc";  
        return $this->query($strSQLQuery, 1);
    }
    
   function  GetTerritoryRuleMulti($TerritoryID){         
        $strSQLQuery = "select t.*,r.TRID from c_territory t inner join c_territory_rule r on t.TerritoryID=r.TerritoryID WHERE t.TerritoryID in (".$TerritoryID.") order by t.Name asc";  
        return $this->query($strSQLQuery, 1);
    }


     function  TerritoryRuleLocation($country,$state,$city)
       {
       
               $strAddQuery .= (!empty($state))?(" and FIND_IN_SET(".$state.",l.state)"):("");
               $strAddQuery .= (!empty($city))?(" and FIND_IN_SET(".$city.",l.city)"):("");
       
               $strSQLQuery = "select a.AssignTo from c_territory_rule_location l inner join c_territory_rule r on l.TRID=r.TRID inner join c_territory t on r.TerritoryID=t.TerritoryID inner join c_territory_assign a on FIND_IN_SET(t.TerritoryID,a.TerritoryID) where l.country='".$country."' ".$strAddQuery." group by a.AssignTo ";


               return $this->query($strSQLQuery, 1);
       }

    /***********Territory Assign End ****************/
        
        
        
        
        
        
            
            
       function ListLead() {
        global $Config;
        $strSQLQuery = "select l.leadID,l.country_id,l.state_id,l.city_id from c_lead l ";
        return $this->query($strSQLQuery, 1);
    
        
       }
       
function UpdateCountryStateCity($arryDetails){   
        extract($arryDetails);		

        $strSQLQuery = "UPDATE c_lead SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE leadID = '".$leadID."'";
        $this->query($strSQLQuery, 0);
        return 1;
  }
          


}

?>
