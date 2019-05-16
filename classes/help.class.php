<?
class help extends dbClass
{
		//constructor
		function help()
		{

			$this->dbClass();
		} 
		
		function  ListHelp($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where w.WsID='".mysql_real_escape_string($id)."'"):(" where 1 ");
			$strAddQuery .= (!empty($depID))?(" and w.depID='".mysql_real_escape_string($depID)."'"):("");

			if($SearchKey=='active' && ($sortby=='w.Status' || $sortby=='') ){
				$strAddQuery .= " and w.Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='w.Status' || $sortby=='') ){
				$strAddQuery .= " and w.Status='0'";
			}else if($sortby != ''){

				if($sortby=='w.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");

				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (w.Heading like '%".$SearchKey."%' or c.CategoryName like '%".$SearchKey."%') " ):("");			}		

			//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by c.OrderBy,w.Heading ");
			//$strAddQuery .= (!empty($asc))?($asc):(" Asc");
			if($Config['GetNumRecords']==1){
				$Columns = " count(w.WsID) as NumCount ";				
			}else{		
        $strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$AscDesc):(" order by w.WsID  desc ");		
				$Columns = " w.WsID, w.Heading, w.Status, w.Content, w.UploadDoc, w.Videolink, d.Department, c.CategoryName  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}				
			}	

			 $strSQLQuery = "select ".$Columns." from help w inner join department d on w.depID=d.depID inner join help_cat c on w.CategoryID=c.CategoryID ".$strAddQuery;

			return $this->query($strSQLQuery, 1);		
				
		}	
		
		

		
		function  DepByList($dpName)
		{
			
			if($dpName!='all'){
				   $strAddQuery .= " where d.Department like '%".$dpName."%'";
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by w.Heading ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");
			

			$strSQLQuery = "select w.WsID,w.Heading,w.Status,w.Content,w.UploadDoc,w.Videolink,d.Department,c.CategoryName from help w inner join department d on w.depID=d.depID inner join help_cat c on w.CategoryID=c.CategoryID ".$strAddQuery;

			return $this->query($strSQLQuery, 1);		
				
		}	
		
		
		
		
		
		
		function  GetHelp($WsID,$Status)
		{
			$strSQLQuery = "select w.* from help w ";

			$strSQLQuery .= (!empty($WsID))?(" where w.WsID='".mysql_real_escape_string($WsID)."'"):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and w.Status='".mysql_real_escape_string($Status)."'"):("");
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}		
		
		
		
		function RemoveHelp($WsID)
		{
			global $Config;

			$objFunction=new functions();
			if(!empty($WsID)){
				$strSQLQuery = "select UploadDoc,Videolink from help where WsID='".$WsID."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				if($arryRow[0]['UploadDoc'] !='' ){				
					$objFunction->DeleteFileStorage($Config['HelpDoc'],$arryRow[0]['UploadDoc']);		
				}
				if($arryRow[0]['Videolink'] !='' ){				
						
					$objFunction->DeleteFileStorage($Config['HelpVedio'],$arryRow[0]['Videolink']);	
				}

				$strSQLQuery = "delete from help where WsID='".$WsID."'"; 
				$this->query($strSQLQuery, 0);			

							
			}

			return 1;

		}
		

		
		function changeHelpStatus($WsID)
		{
			if(!empty($WsID)){
				$sql="select WsID,Status from help where WsID='".mysql_real_escape_string($WsID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update help set Status='$Status' where WsID='".mysql_real_escape_string($WsID)."'";
					$this->query($sql,0);					
				}	
			}

			return true;

		}
		


		function MultipleHelpStatus($WsIDs,$Status)
		{
			$sql="select WsID from help where WsID in (".$WsIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update help set Status='".$Status."' where WsID in (".$WsIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}




      /************************************************/
		
      function GetDepartmentName($Status){
      	       global $Config;
      	       $strAddQuery = (!empty($Status))?(" and d.Status='".$Status."'"):("");
      	       $strSQLQuery = "select Department,depID from department d ".$strAddQuery;
			   return $this->query($strSQLQuery, 1);
      	       
      }
      
      function AddHelp($arryDetails)
		{  
			//print_r($arryDetails);die;
			global $Config;
			@extract($arryDetails);
			
			$strSQLQuery = "insert into help (depID, CategoryID, Heading, Content, Status, VideoUrl) values(  '".addslashes($Department)."', '".addslashes($CategoryName)."', '".addslashes($Heading)."',  '".addslashes($Content)."',  '".$Status."' ,  '".$VideoUrl."')";
		    //echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
            $WsID = $this->lastInsertId();
           // echo $WsID;exit;
			return $WsID;

		}
		

		function UpdateHelp($arryDetails){   
          //print_r($arryDetails);die;
			extract($arryDetails);

			if(!empty($WareHouseID)){
			
			    $strSQLQuery = "update help set depID='".addslashes($Department)."', CategoryID='".addslashes($CategoryName)."', Heading='".addslashes($Heading)."', Content='".addslashes($Content)."', Status='".$Status."', VideoUrl='".$VideoUrl."' where WsID='".$WareHouseID."'"; 
             //echo $strSQLQuery;exit;
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}
		
		
		function departById($dpID){   

			if(!empty($dpID)){
			
			  $strSQLQuery = "SELECT * FROM help where WsID='".$dpID."'"; 

			 $results = $this->query($strSQLQuery,1);
			 
			 return $results;
			 
			}

			
		}
		
        function categoryNametById($CategoryID){   

			if(!empty($CategoryID)){
			
			 $strSQLQuery = "SELECT * FROM help where WsID='".$CategoryID."'"; 

			 $results = $this->query($strSQLQuery,1);
			 
			 return $results;
			 
			}

			
		}
		
  function UpdateDocWorkFlow($UploadDoc, $WsID) {
        $strSQLQuery = "update help set UploadDoc='" . $UploadDoc . "' where WsID='" . $WsID . "'";
        //echo $strSQLQuery; die;
        $this->query($strSQLQuery, 1);
        return true;
    }
    
 function UpdateVideoWorkFlow($Videolink, $WsID) {
        $strSQLQuery = "update help set Videolink='" . $Videolink . "' where WsID='" . $WsID . "'";
        //echo $strSQLQuery; die;
        $this->query($strSQLQuery, 1);
        return true;
    }
		
     /****************** Help Desk *************************/
   
		function  HelpListing($CategoryID,$depID)
		{
			$addsql='';
			if($CategoryID>0){
				$addsql = " and w.CategoryID='".$CategoryID."'";
			}
		$strSQLQuery = "select w.WsID,w.Heading,w.Status,w.Content,w.UploadDoc,w.Videolink,w.VideoUrl,d.Department,d.depID,c.CategoryName,c.CategoryID from help w 
		inner join department d on w.depID=d.depID 
		inner join help_cat c on w.CategoryID=c.CategoryID where d.depID ='" . $depID . "' and w.Status='1' ".$addsql." order by c.OrderBy,w.WsID Asc ";  //c.OrderBy,w.WsID Asc
		return $this->query($strSQLQuery, 1);		
				
		}

		function  ListContentbyHeadingId($WsID)
		{   
			$strSQLQuery ="select Heading,Content,UploadDoc,Videolink,VideoUrl from help  where WsID='" . $WsID . "'";
			return $this->query($strSQLQuery, 1);	
		}
		
        function  ListHCByDepartmentName($CategoryID,$depID)
		{  
			$addsql='';
			if($CategoryID>0){
				$addsql = " and w.CategoryID='".$CategoryID."'";
			}
			$strSQLQuery ="select w.Heading,w.Content,w.WsID,d.depID from help w left join department d on w.depID=d.depID where w.depID='" . $depID . "' ".$addsql."  order by w.Heading asc";
			return $this->query($strSQLQuery, 1);	
		}
		
		function ListCountPost($CategoryID,$depID) {
			$strSQlQuery = "select count(WsID) count from help where CategoryID='" . $CategoryID . "' and depID='" . $depID . "' and Status='1'";
			$count = $this->query($strSQlQuery, 1);
			return $count = ($count>0)? $count[0]['count'] : 0;
		}
    
       /************************************************/

	  /************* Help Category Start ************/

		function  ListHelpCategory($arryDetails)
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
				$strAddQuery .= (!empty($SearchKey))?(" and (CategoryName like '%".$SearchKey."%') " ):("");		
			}
			$strAddQuery .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by OrderBy,CategoryName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			$strSQLQuery = "select * from help_cat  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function  GetHelpCategory($CategoryID,$Status)
		{

			$strAddQuery = " where 1 ";
			$strAddQuery .= (!empty($CategoryID))?(" and CategoryID='".$CategoryID."'"):("");
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from help_cat  ".$strAddQuery." order by OrderBy,CategoryName ";

			return $this->query($strSQLQuery, 1);
		}		
			
		
		function AddHelpCategory($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into help_cat (CategoryName, Status, OrderBy) values( '".addslashes($CategoryName)."', '".$Status."', '".$OrderBy."')";

			$this->query($strSQLQuery, 0);

			$CategoryID = $this->lastInsertId();
			
			return $CategoryID;

		}


		function UpdateHelpCategory($arryDetails){
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update help_cat set CategoryName='".addslashes($CategoryName)."', Status='".$Status."', OrderBy='".$OrderBy."' where CategoryID='".$CategoryID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

					
		
		function RemoveHelpCategory($CategoryID)
		{
		
			$strSQLQuery = "delete from help_cat where CategoryID='".$CategoryID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function changeHelpCategoryStatus($CategoryID)
		{
			$sql="select * from help_cat where CategoryID='".$CategoryID."'"; 
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update help_cat set Status='$Status' where CategoryID='".$CategoryID."'"; 
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleHelpCategoryStatus($CategoryIDs,$Status)
		{
			$sql="select CategoryID from help_cat where CategoryID in (".$CategoryIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update help_cat set Status='".$Status."' where CategoryID in (".$CategoryIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		

		function isHelpCategoryExists($CategoryName,$CategoryID=0)
		{
			$strSQLQuery = (!empty($CategoryID))?(" and CategoryID != '".$CategoryID."'"):("");
			$strSQLQuery = "select CategoryID from help_cat where LCASE(CategoryName)='".strtolower(trim($CategoryName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}


		/*************help Category End ************/	



}
?>
