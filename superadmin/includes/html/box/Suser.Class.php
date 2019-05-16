<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suser
 *
 * @author linux8
 */
class Suser extends dbClass
{
		//constructor
		function Suser()
		{
			$this->dbClass();
		} 
		
		
		
		function  UserList($arryDetails)
		{
			
			extract($arryDetails);

			$strAddQuery = '';
	
			//$strAddQuery .= (!empty($id))?(" where Uid='".mysql_real_escape_string($id)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery = "select*from u_user order by Firstname";
		
		
			return $this->query($strAddQuery, 1);		
				
		}	
		
     function AddUser($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into u_user(FirstName,LastName,Gender ,uEmail, upassword,Designation, Status) values('".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($Gender)."','".addslashes($uEmail)."', '".md5($uPassword)."', '".($Designation)."', '".$Status."')";
          
			$this->query($strSQLQuery, 0);
			$UserID = $this->lastInsertId();

			return $UserID;
		}
  function deleteUser($Uid)
        {
           
          
            if(!empty($Uid))
            {
               
                $sql = "delete from u_user where Uid = '".mysql_real_escape_string($Uid)."'";
            
                $rs = $this->query($sql,0);
            }

            return true;



        }
  function getUser($Uid)
        {
            if(!empty($Uid))
            {
            	
              $sql = "select * from u_user where Uid='".mysql_real_escape_string($Uid)."'";
           
            
             return  $this->query($sql, 1);
               
              
            }
            
      
        }
function updateUser($arryDetails)
        {
      
            @extract($arryDetails);    
            if(!empty($Uid))
            {
                $sql = "update u_user set FirstName = '".addslashes($FirstName)."',LastName = '".addslashes($LastName)."',Gender = '".addslashes($Gender)."',uEmail = '".addslashes($uEmail)."',Designation = '".addslashes($Designation)."', Status = '".$Status."'  where Uid= '".$Uid."'"; 

            
                
                $rs = $this->query($sql,0);
            }
                
            return true;

        }
        
        
 function changeUserStatus($Uid)
        {
        
            if(!empty($Uid))
            {
                $sql="select * from u_user where Uid='".mysql_real_escape_string($Uid)."'";                
                $rs = $this->query($sql);

                if(sizeof($rs))
                {
                
                    if($rs[0]['status']==1)
                    
                        $Status=0;
                    else
                        $Status=1;

                        
                    $sql="update u_user set status='$Status' where Uid='".mysql_real_escape_string($Uid)."'";
                 
            
                                        $this->query($sql,0);
                }    
            }

            return true;

        }

function isModulePermittedUser($ModuleID,$UserID)
		{
			if(!empty($ModuleID) && !empty($UserID)){
				$sql ="select * from permission where ModuleID = '".$ModuleID."' and UserID = '".$UserID."'";
				//echo $sql;
				return $this->query($sql, 1);
			}

		}
function getMainModulesUser($UserID,$Parent)
{

			$OuterADD = (!empty($UserID))?(" and p.UserID='".$UserID."'"):("");

			//$strSQLQuery ="select m.*,p.UserID,p.ViewLabel,p.ModifyLabel,p.FullLabel from admin_modules m left outer join permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default=0 and m.Status=1 and m.DepID='".$DepID."' group by m.ModuleID order by m.ModuleID asc";

	$strSQLQuery ="select m.*,p.UserID,p.ViewLabel,p.ModifyLabel,p.FullLabel from admin_modules m left outer join permission p on (m.ModuleID=p.ModuleID ".$OuterADD.") where m.Parent='".$Parent."' and m.Default=0 and m.Status=1  group by m.ModuleID order by m.ModuleID asc";
		
			return $this->query($strSQLQuery, 1);
		}
		
        
function isEmailExit($uEmail,$Uid)
                {       
                        
                    $strSQLQuery = (!empty($Uid))?(" and Uid != '".$Uid."'"):("");
                     $strSQLQuery = "SELECT uEmail FROM u_user WHERE uEmail ='".trim($uEmail)."'".$strSQLQuery;
                     
                      $arryRow = $this->query($strSQLQuery, 1); 
                         
                        
                    if (!empty($arryRow[0]['uEmail'])) 
                    {
                        return true;
                    }
                     else 
                     {
                        return false;
                    }
                }
function UpdateEmpRole($arryDetails)
{   
			extract($arryDetails);
			if(!empty($EmpID))
			{
				$strSQLQuery = "update h_employee set Role='".mysql_real_escape_string(strip_tags($Role))."', vUserInfo='".mysql_real_escape_string(strip_tags($vUserInfo))."', vAllRecord='".mysql_real_escape_string(strip_tags($vAllRecord))."' where EmpID='".mysql_real_escape_string($EmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

function UpdateRolePermission($arryDetails)
		{
	
			global $Config;	
			extract($arryDetails);
		
			
			$sql = "delete from permission where UserID =".$Uid;
			
			
			$rs = $this->query($sql,0);
			
			if($Line>0)
				{
			
					for($i=1;$i<=$Line; $i++)
					{
						$ViewFlag = 0; $ModifyFlag = 0; $FullFlag = 0; 							$ModuleID=0;
						$ViewLabel = $arryDetails["ViewLabel".$i];
						$ModifyLabel = $arryDetails["ModifyLabel".$i];
						//$FullLabel = $arryDetails["FullLabel".$i];

						if($ModifyLabel>0)
						{
							$ModuleID = $ModifyLabel;
							$ModifyFlag = 1;
						}
						if($ViewLabel>0)
						{
							$ModuleID = $ViewLabel;
							$ViewFlag = 1;
						}
						//if($FullLabel>0)
						//{
							//$ModuleID = $FullLabel;
							//$FullFlag = 1;
						//}
						
						if($ModuleID>0)
						{
							
							$sql = "insert ignore into permission(UserID,ModuleID,ViewLabel,ModifyLabel) values('".$Uid."', '".$ModuleID."', '".$ViewFlag."', '".$ModifyFlag."')";
							
							//echo $sql;exit;
							$rs = $this->query($sql,0);
							//echo $sql;exit;
							//$PermissionGiven = 1;
						}

					}
				}
		
		
	
			return 1;

		}
        
	
	
	
		

	function ChangePassword($newPassword,$Uid)
		{
            if(!empty($Uid))
            {
               // $sql = "update u_user set FirstName = '".addslashes($FirstName)."',LastName = '".addslashes($LastName)."',Gender = '".addslashes($Gender)."',uEmail = '".addslashes($uEmail)."',Designation = '".addslashes($Designation)."', Status = '".$Status."'  where Uid= '".$Uid."'"; 
	         $strSQLQuery = "update u_user set upassword='".mysql_real_escape_string(md5($newPassword))."' where Uid='".mysql_real_escape_string($Uid)."'";
           // echo $strSQLQuery;
             
	    
            $this->query($strSQLQuery, 1);
            
			if(mysql_affected_rows()==1)
			{
				return "1";
			}
			else 
			{
			return "0";	
			}
			
			
			
            }
               	
		}		
				
		function ForgotPassword($Email,$UserType)
		{
			
			global $Config;
			$sql = "select * from user where Email='".mysql_real_escape_string($Email)."' and UserType='".mysql_real_escape_string($UserType)."' and Status=1"; 
			$arryRow = $this->query($sql, 1);
			$UserName = $arryRow[0]['UserName'];
			$UserID = $arryRow[0]['UserID'];

			if(sizeof($arryRow)>0)
			{
				$Password = substr(md5(rand(100,10000)),0,8);
				
				$sql_u = "update user set Password='".md5($Password)."'
				where UserID='".$UserID."'";
				$this->query($sql_u, 0);				
				return 1;
			}else{
				return 0;
			}
		}

		function ValidateUser($Email,$Password)
		{
			if(!empty($Email) && !empty($Password))
			{
				$strSQLQuery ="select * from u_user where uEmail ='".$Email."' and upassword='".md5($Password)."' and Status=1 ";
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
			}
		}
 function GetHeaderMenusUser($Uid)
	 {

   if(!empty($Uid))
     {
	 $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE Parent=0 and  P.UserID=".$Uid." Order by OrderBy  asc"; 

	 return $this->query($strAddQuery, 1);
	 }
	  
	
     
	 }	
	 function GetHeaderMenusBySuperadmin($Adminid)
	 {
	// echo $Adminid;exit;
    if(!empty($Adminid))
     {
     	$addQry=" order by OrderBy asc ";
	 // $strAddQuery="select*from admin_modules where UserID=$Uid";
	 $strAddQuery ="SELECT * FROM admin_modules WHERE Status=1  and Parent=0  Order by OrderBy  asc";
	 // $strAddQuery ="SELECT * FROM admin_modules WHERE Status=1  Order by OrderBy  asc";
	// echo $strAddQuery;exit;
	  return $this->query($strAddQuery, 1);
	 //echo $strAddQuery;exit;
	  }
	
     
	 }
	 function GetHeaderSubmenuMenusBySuperadmin($Parent)
	 {
	 
	   if(!empty($Parent))
     {
     
	
	 //$strAddQuery ="SELECT * FROM admin_modules WHERE Status=1 and Parent='".$Parent."'  Order by OrderBy  asc";
	  $strAddQuery ="SELECT * FROM admin_modules WHERE Status=1 and Parent='".$Parent."' ";
	  return $this->query($strAddQuery, 1);
	 
	  }
	 }
	
	function GetHeaderSubmenuUser($Uid)
	 {
	
    if(!empty($Uid))
     {
	// $strid="select*from admin_modules where UserID=$Uid";
	 $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE    Parent=8 and  P.UserID=".$Uid." Order by OrderBy  asc"; 
 //echo  $strAddQuery;exit;
	 return $this->query($strAddQuery, 1);
	 
	  }
	 }	
	 function GetHeaderSubmenuadmin($Uid)
	 {
	
    if(!empty($Uid))
     {
	// $strid="select*from admin_modules where UserID=$Uid";
	 $strAddQuery ="SELECT * FROM admin_modules   WHERE  Parent=8  Order by OrderBy  asc"; 
 
	 return $this->query($strAddQuery, 1);
	 
	  }
	 }	
function GetHeaderParent($pageurml)
	 {
	
    if(!empty($pageurml))
     {
	
	 $strAddQuery ="SELECT * FROM admin_modules   WHERE  link='".$pageurml."' and Parent=8  Order by OrderBy  asc"; 
    //echo   $strAddQuery ;
	 return $this->query($strAddQuery, 1);
	 
	  }
	 }
   function GetrightmenuByuser($AdminID)
	 {
	 	 if(!empty($AdminID))
     {
    $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE   M.Parent=2 and  P.UserID='".$AdminID."'"; 
   
	 return $this->query($strAddQuery, 1);
     }
	 
	  
	 }
	 
	 
	 
	 function GetHdMenu($Uid,$Parent)
	 {
	
	    if(!empty($Uid))
	     {
		 $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE  M.Parent!=2 and  Parent=".$Parent." and  P.UserID=".$Uid." Order by OrderBy  asc"; 
 //echo  $strAddQuery;exit;
	 return $this->query($strAddQuery, 1);
	 
	  }
	 }	
	 
	 
	 function GetHdMenuAdmin($Parent)
	 {
			 $strAddQuery ="SELECT M.* FROM admin_modules as M  WHERE M.Parent!=2 and  Parent=".$Parent." Order by OrderBy  asc"; 

	 return $this->query($strAddQuery, 1);
	 
	 }	
	 
	 function GetHdMenuByLink($Uid,$Link)
	 {
	
	    if(!empty($Uid))
	     {
		 $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE  M.Parent!=2 and  P.UserID='".$Uid."' and  M.Link='".$Link."' Order by OrderBy  asc"; 
 		//echo  $strAddQuery;exit;
	 return $this->query($strAddQuery, 1);
	 
	  }
	 }
	
	 function GetHdMenuByLinkFooter($Uid,$Link)
	 {
	
	    if(!empty($Uid))
	     {
		 $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE  M.Parent==2 and  P.UserID='".$Uid."' and  M.Link='".$Link."' Order by OrderBy  asc"; 
 		//echo  $strAddQuery;
	 return $this->query($strAddQuery, 1);
	 
	  }
	 }

 
	 
function GetrightmenuByadmin($AdminID)
	 {
	 	 if(!empty($AdminID))
     {
    $strAddQuery ="SELECT * FROM admin_modules   WHERE    Parent=2"; 
    
	 return $this->query($strAddQuery, 1);
	 
     }
	 }
	 function GetPageUrl($pageurml,$Uid)
	 {

    if(!empty($pageurml))
     {
	// $strid="select*from admin_modules where UserID=$Uid";
	 $strAddQuery ="SELECT M.*,P.* FROM admin_modules as M join permission as P on M.ModuleID=P.ModuleID  WHERE M.link='".$pageurml."'  and  M.Parent!=0 and  P.UserID=".$Uid." Order by OrderBy  asc"; 
     
	 return $this->query($strAddQuery, 1);
	
	  }
	 }		 		  	 		  		 		 		
}
