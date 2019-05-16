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
           //  echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$UserID = $this->lastInsertId();

			return $UserID;
		}
  function deleteUser($Uid)
        {
           
           // $objConfigure=new configure();
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
             // echo $sql;exit;
            
             return  $this->query($sql, 1);
               
               // echo print_r($rr);
            }
            
           // return true;
        }
function updateUser($arryDetails)
        {
      
            @extract($arryDetails);    
            if(!empty($Uid))
            {
                $sql = "update u_user set FirstName = '".addslashes($FirstName)."',LastName = '".addslashes($LastName)."',Gender = '".addslashes($Gender)."',uEmail = '".addslashes($uEmail)."',Designation = '".addslashes($Designation)."', Status = '".$Status."'  where Uid= '".$Uid."'"; 

               // echo $sql;exit;
                
                $rs = $this->query($sql,0);
            }
                
            return true;

        }
        
        
 function changeUserStatus($Uid)
        {
      //echo    $Uid;exit;     
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
}
