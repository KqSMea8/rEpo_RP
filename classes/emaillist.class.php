<?
class emaillist extends dbClass
{
	//constructor
	function emaillist()
	{
		$this->dbClass();
	}


	function Listemail($arrayDetails){

		global $Config;
		extract($arrayDetails);
	
		$strAddQuery = '';$strAddQueryD1=$strAddQueryD2='';
		$SearchKey = strtolower(trim($key));

		if ($SearchKey != "" && $sortby == "CompanyName") {

			$strAddQuery = " and  c.CompanyName like '%" . $SearchKey . "%'";

		}elseif ($SearchKey != "" && $sortby == "DisplayName") {

			$strAddQuery .= " and  c.DisplayName like '%" . $SearchKey . "%'";
			
			 
		}elseif ($SearchKey != "" && $sortby == "Email") {

			$strAddQuery .= " and  u.Email  like '%" . $SearchKey . "%' ";
			$strAddQueryother = " and  cu.user_name  like '%" . $SearchKey . "%' ";
			
			
		//}elseif ($SearchKey != "" && $sortby == "RefID") {
			
           //if  ($SearchKey=='user'){
           // 	$SearchKey = '0';
            	
           // }
            
		  //  $strAddQuery .= " and  u.RefID  like '" . $SearchKey . "%' ";
		//	$strAddQueryother .= " and  cu.user_type  like '%" . $SearchKey . "%' ";
			
			
		}elseif ($SearchKey != "" && $sortby == "CmpID") {

			$strAddQuery .= " and  c.CmpID like '%" . $SearchKey . "%'";

		}elseif ($sortby != '') {

			$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
			 
		}else{

		 	$strAddQueryD1 .= (!empty($SearchKey)) ? (" and ( u.Email like '%" . $SearchKey . "%' or c.CompanyName like '%" . $SearchKey . "%' or c.DisplayName like '%" . $SearchKey . "%' or c.CmpID like '%" . $SearchKey . "%')" ) : ("");
			
			$strAddQueryD2 .= (!empty($SearchKey)) ? (" and (cu.user_name like '%" . $SearchKey . "%' or c.CompanyName like '%" . $SearchKey . "%' or c.DisplayName like '%" . $SearchKey . "%' or c.CmpID like '%" . $SearchKey . "%')" ) : ("");			

			$sortby='CmpID';
		}

		$strAddQuerysort = (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by ".$sortby." desc");
		
		
		
		if($sortby=='Email'){
			 
			$strSQLQuery="(Select u.Email ,u.ID,u.RefID,c.CompanyName,c.DisplayName,c.CmpID FROM user_email u INNER JOIN company c ON (u.CmpID=c.CmpID and u.Email!='') ".$strAddQuery." ) UNION ALL (Select cu.user_name,cu.id,cu.user_type,c.CompanyName,c.DisplayName,c.CmpID  FROM company_user cu INNER JOIN company c ON (cu.comId=c.CmpID and cu.user_name!='')  ".$strAddQueryother.")".$strAddQuerysort."";
			
		}else{
			  $strSQLQuery="(Select u.Email ,u.RefID,c.CompanyName,c.DisplayName,c.CmpID FROM user_email u INNER JOIN company c ON (u.CmpID=c.CmpID and u.Email!='') ".$strAddQuery.$strAddQueryD1." ) UNION ALL (Select cu.user_name,cu.user_type,c.CompanyName,c.DisplayName,c.CmpID  FROM company_user cu INNER JOIN company c ON (cu.comId=c.CmpID and cu.user_name!='') ".$strAddQuery.$strAddQueryD2.")".$strAddQuerysort."";

		}

		return $this->query($strSQLQuery, 1);
	}

	
	function deleteUser($CmpID)
        {
           
          
            if(!empty($CmpID))
            {
               
             $sql = "delete from user_email where CmpID = '".mysql_real_escape_string($CmpID)."'";
            
                $rs = $this->query($sql,0);
            }

            return true;
        }

	function deleteEmail($Email,$RefID)
	{
		
		global $Config;
		$objConfigure=new configure();
		
		if(!empty($Email))
		{
			
			 
			 $sql = "delete from erp.user_email  where Email = '".mysql_real_escape_string($Email)."' and RefID = '".mysql_real_escape_string($RefID)."' ";
			     $this->query($sql, 0);
			 $sql = "delete from erp.company  where Email = '".mysql_real_escape_string($Email)."'";
			     $this->query($sql,0);
			 $sql = "delete from  h_employee where Email = '".mysql_real_escape_string($Email)."'";
			     $this->query($sql, 0);
			
		}
		return 1;
	}
	
      function RemoveCustomer($Email,$RefID)
      
		{ 
			
			global $Config;
			$objConfigure=new configure();
			$objCompany=new company();
			
			 
		    $strSQLQuery = "select Cid,Image FROM s_customers WHERE Email= '".mysql_real_escape_string($Email)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			
       	    $ImgDir = '../upload/customer/'.$_GET['CmpID'].'/';

			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){				
			//$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);					
			unlink($ImgDir.$arryRow[0]['Image']);	
			}

		    $strSQLQuery = "DELETE FROM s_customers WHERE Email= '".mysql_real_escape_string($Email)."'"; 
			$this->query($strSQLQuery, 0);

	       $strSQLQuery = "DELETE FROM s_address_book WHERE Email = '".mysql_real_escape_string($Email)."'"; 
			$this->query($strSQLQuery, 0);

			 $strSQLQuery = "delete from erp.company_user where user_name = '".mysql_real_escape_string($Email)."' and user_type = '".mysql_real_escape_string($RefID)."' ";
			$this->query($strSQLQuery, 0);
		

			return 1;

		}
		
		

		function RemoveVendor($Email,$RefID)
		{ 
			
			global $Config;
			$objConfigure=new configure();
            $objCompany=new company();
			   
			if(!empty($Email)){
				  $strSQLQuery = "select Image from h_vendor where Email='".mysql_real_escape_string($Email)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);

				 $ImgDir = '../upload/vendor/'.$_GET['CmpID'].'/';
			
				if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							
					unlink($ImgDir.$arryRow[0]['Image']);	
				}
			
				$strSQLQuery = "delete from h_vendor where Email='".mysql_real_escape_string($Email)."'"; 
				$this->query($strSQLQuery, 0);	

			   $strSQLQuery = "delete from erp.company_user  where user_name = '".mysql_real_escape_string($Email)."' and user_type = '".mysql_real_escape_string($RefID)."' "; die;
			   $this->query($strSQLQuery, 0);
			}

			return 1;

		}
        
}?>
