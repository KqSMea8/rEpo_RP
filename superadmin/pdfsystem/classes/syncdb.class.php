<?php
class syncdb 
{
        
         function mydecrypt($text){
		$salt ='2210198022101980';
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}
        
	function  syncconnect()
	{
           
         global $compcod;    
         //global $Config; 
	 $servername='172.21.24.51';
	 $username='Mt4CnU1X2ll+Z+dFQ6OROENpJLwuZ1TnYqS4rOEHbNU=';
	 $password='HdDB56buesH12gEVFA4c3hEnqCF64WlXH2XE85LVMiw=';
         $dbname="pdfviewer_$compcod";
          //$dbname="pdfviewer_$compcod";
         
         //echo "<pre>"; print_r($Config);die;	
         //echo "gggg".$dbname;die;
 		//$conn=mysqli_connect($servername,$username,$password); 
 		
               $conn=mysqli_connect($servername,mydecrypt($username),mydecrypt($password),$dbname);                         
		if(!$conn)
		{
			die("could not connect database!");
		
		}
		else{
			$conn;
		}
		return $conn; 		
 		
 		
 		/*$link=mysql_connect ($servername,$username,$password,TRUE);
			if(!$link){die("Could not connect to MySQL");}
			mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
			return $link;   */            
		
	}
        
 
    
	function GetCompUsers($arg = array(),$compcod,$userRoleID=4)
	{    

            extract($arg);                         
            $offset=$arg['offset'];
            $limit=$arg['limit'];
            if(isset($limit) AND isset($offset))
            $limitval="LIMIT $offset , $limit";

$sql="SELECT user.*, user_role.role, (select count(*) FROM `user` where company_code='" .$compcod ."' AND  roleId!='".$userRoleID."') as totalCount FROM `user` LEFT JOIN user_role ON user.roleId = user_role.profileId where user.company_code = '" .$compcod ."' AND user.roleId != '".$userRoleID."'$limitval ";
	
	   $res=mysqli_query($this->syncconnect(),$sql);
		if(!$res)
		 {
			echo "query not executed...";
		}
		else
		{
			foreach($res as $rows)
			{
				$records[]=$rows;
			}
			return $records;
		}
	}
	
   
 function getCompanyOrderList($arg = array(),$searchType = '', $searchKeyword = '',$compcod){ 
       
         extract($arg);
         if (isset($id)) {
          $sql = "SELECT * FROM `user` where company_code = '" .$id ."'";
            return $this->get_row($sql);
        } else {  
            $offset=$arg['offset'];
            $limit=$arg['limit'];
            if(isset($limit) AND isset($offset))
                $limitval="LIMIT $offset , $limit";
             
             $serachSql = '';
            if (!empty($searchType) && !empty($searchKeyword)) {
                if ($searchType == 'byName') {
                    $serachSql .= " ( `secUser`.firstName like '%" . $searchKeyword . "%' || `secUser`.lastName like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byCustomer') {
                    $serachSql .= " ( `user`.firstName like '%" . $searchKeyword . "%' || `user`.lastName like '%" . $searchKeyword . "%' ) ";
               } else if ($searchType == 'byTransection') {
                    $serachSql .= "  ( `purchased_document`.txnId like '%" . $searchKeyword . "%'  ) ";
                }
                 else if ($searchType == 'byPaymentDate') {
                    $serachSql .= "  ( `purchased_document`.paymentDate like '%" . $searchKeyword . "%'  ) ";
                }
            }

    $sql="SELECT `purchased_document`.*, "
                . "( Select Count(*) FROM  `purchased_document` "
                . "INNER JOIN `author_document` ON `author_document`.`id` = `purchased_document`.`documentId` "
                . " INNER JOIN `user` ON `user`.`id` = `purchased_document`.`userId` ";
               $sql.= "INNER JOIN `user` as secUser ON `secUser`.`id` = `author_document`.`author_id`";
		
                      if(!empty($searchType)){
               $sql.=  "where $serachSql";
              } 
               $sql.=  ") AS `c`,";
     $sql.= "DATE_FORMAT(paymentDate, '%b %d,%Y') AS `paymentDate`, "
                . "`author_document`.`id` AS `documentId`, "
                . "`author_document`.`title` AS `document`, "
                . "`author_document`.`doc_type` AS `documentType`, "
                . "`user`.`id` AS `userId`, "
                . "`purchased_document`.`order_id` AS `orderid`, "
                . "concat(user.firstName, ' ', user.lastName) AS `user`,"
                . " concat( secUser.firstName, ' ', secUser.lastName ) AS `author`, "
                . "`secUser`.`id` AS `Id`, "
                . "`user`.`company_code` AS `company` "
                . "FROM `purchased_document` "
                . "INNER JOIN `author_document` ON `author_document`.`id` = `purchased_document`.`documentId` "
                . "INNER JOIN `user` ON `user`.`id` = `purchased_document`.`userId`";
            $sql.= "INNER JOIN `user` as secUser ON `secUser`.`id` = `author_document`.`author_id` ";
            if(!empty($searchType)){
            	$sql.=  "where $serachSql";
              }
	 $sql.= "where `user`.`company_code` = '" .$compcod ."'";
         $sql.=  "ORDER BY `purchased_document`.`id`   $limitval"; 
	
     //echo $sql; 
	 $res=mysqli_query($this->syncconnect(),$sql);

		if(!$res)
		 {
			echo "query not executed...";
		}
		else
		{
			foreach($res as $rows)
			{
				$records[]=$rows;
			}
			return $records;
                   exit;
		}
    	//echo $sql; die('aaa');

     //return $this->get_results($sql);
        }
    } 

public function FindPdfCompUsers($id, $compcod) { 



        $sql = "SELECT * FROM `user` where `id`='".$id."'";
//echo $sql;
	 $res=mysqli_query($this->syncconnect(),$sql);
	//return $res;
        if(!$res)
		 {
			echo "query not executed...";
		}
		else
		{
			foreach($res as $rows)
			{
				$records[]=$rows;
			}
			return $records;
                   
		}
    }

public function AddAllowedStore($compcod,$optionKey,$optionValue){

      $sql = "insert into setting  set  `companyCode`='".$compcod."', `optionKey`='".$optionKey."', `optionValue`='".$optionValue."'";
       $res=mysqli_query($this->syncconnect(),$sql);

}

function updateSetting($arryDetails,$compcod,$paymentMode){
if($paymentMode==0){
$optionKey='PAYMENT_MODE_ON_LINE';
$optionValue='1';
$sql = "insert into setting  set  `companyCode`='".$compcod."', `optionKey`='".$optionKey."', `optionValue`='".$optionValue."'";
$res=mysqli_query($this->syncconnect(),$sql);
}

foreach ($arryDetails as $key=>$value){      
              $updateData = array(
                 'optionKey'=>$key,
                 'optionValue'=> $value,                         
                 
        ); 
 $sql = "update `setting` set  `optionKey`='".$key."',`optionValue`='".$value."' where `companyCode`='".$compcod."' and `optionKey`='".$key."'";
       $res=mysqli_query($this->syncconnect(),$sql);
       
$_SESSION['mess_msg'] = "Setting has been update successfully. "; 
            
}
}

function getSettingByCompanyCode($compcod){

 $query = "SELECT * FROM `setting` WHERE `companyCode`='".$compcod."'";

 $res=mysqli_query($this->syncconnect(),$query);
	//return $res;
        if(!$res)
		 {
			echo "query not executed...";
		}
		else
		{
			foreach($res as $rows)
			{
				$records[]=$rows;
			}
			return $records;
                   
		}
}

function changeCompanyStatus($status, $compcod) {
         if ($status== 1)
               $status = 0;
            else
                $status= 1;
       $sql = "update user set  `status`='".$status."' where `company_code`='".$compcod."'";
//echo $sql;die;
       $res=mysqli_query($this->syncconnect(),$sql);
       return true;
    }



  
     function paging($page,$limit,$totalrecords,$userID){  
       $tab=$_REQUEST['tab'];
       $prevlabel = "&lsaquo; Prev";
       $nextlabel = "Next &rsaquo;";
       $lastlabel = "Last &rsaquo;&rsaquo;";   
       $page = ($page == 0 ? 1 : $page);  
       $start = ($page - 1) * $limit;                                   
       $prev = $page - 1;                          
       $next = $page + 1;    
       $lastpage = ceil($totalrecords/$limit);   
       $pagination = "";
           if($lastpage > 1){         
                  if ($page > 1)                 
                                 $pagination.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?edit=$userID&tab=$tab&curP=" . $prev ."\" class=\"pagenumber\">{$prevlabel}</a> ";    
                       for ($counter = 1; $counter <= $lastpage; $counter++){
                                if ($counter == $page){
                                           $pagination.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?edit=$userID&tab=$tab&curP=" . $prev ."\" class=\"pagenumber\">{$counter}</a> ";
                               }
                                else{
                                     $pagination.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?edit=$userID&tab=$tab&curP={$counter}\" class=\"pagenumber\">{$counter}</a> ";
                        
                              }
            
                       }
       
         
               if ($page < $counter - 1) {
                
                                    $pagination.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?edit=$userID&tab=$tab&curP={$next}\" class=\"pagenumber\">{$nextlabel}</a> ";
                                    $pagination.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?edit=$userID&tab=$tab&curP=$lastpage\" class=\"pagenumber\">{$lastlabel}</a> ";

		}
         
 
              return $pagination;
        } 
 
    }




}
?>

