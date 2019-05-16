<?php

class user extends dbClass {

    function getUser($arg = array(), $userID = '', $searchType = '', $searchKeyword = '') { 

        extract($arg);
        $limitval = ''; 
        if (!empty($userID)) {
         //$sql= "SELECT `comp_users`.*, `payment_history`.`plan_id` FROM `payment_history` INNER JOIN `comp_users` ON comp_users.`company_code` = payment_history.`company_code` WHERE comp_users.id='" . $userID . "'"; 
           // $sql = "SELECT * FROM `user` where id='" . $userID . "'";

//$sql= "SELECT `comp_users`.*, `companystatus`.`allow_storage` AS `allow_storage` FROM `comp_users` LEFT JOIN `companystatus` ON `companystatus`.`companycode` = `comp_users`.`company_code` WHERE `comp_users`.`id` = '" . $userID . "' AND `comp_users`.`deleted` = '0'";
 //echo $sql = "SELECT `u`.*, `pp`.`plandata`,   IF(pp.payment_status='complete', `pp`.`expiredDate`, '') as expiredDate
         //   FROM `comp_users` `u` 
          // LEFT JOIN `payment_history` `pp` on `u`.`company_code` =`pp`.`company_code` 
          //s where `u`.`deleted` = 0 and `u`.`id` = '" . $userID . "'";


$sql ="SELECT `comp_users`.*, `companystatus`.`allow_storage` AS `allow_storage`, `payment_history`.`planData` AS `planData` FROM `comp_users` LEFT JOIN `companystatus` ON `companystatus`.`companycode` = `comp_users`.`company_code` LEFT JOIN `payment_history` ON payment_history.company_code = comp_users.company_code AND payment_history.status = 1 WHERE `comp_users`.`id` = '" . $userID . "' AND `comp_users`.`deleted` = '0'";


            return $this->get_row($sql);
        } else {
            
            $offset = $arg['offset'];
            $limit = $arg['limit'];

            if (isset($limit) AND isset($offset))
                $limitval = "LIMIT $offset , $limit";

            $serachSql = '';
           
            if (!empty($searchType) && !empty($searchKeyword)) {
                if ($searchType == 'byName') {
                    $serachSql .= " AND ( `u`.firstName like '%" . $searchKeyword . "%' || `u`.lastName like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byEmail') {
                    $serachSql .= " AND ( `u`.username like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byExpiryDate') {
                    $serachSql .= " AND ( `pp`.`expiredDate` like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byCreatedDate') {
                    $serachSql .= " AND ( `u`.recordInsertedDate like '%" . $searchKeyword . "%'  ) ";
                }
            }
         $sql= "SELECT `u`.*, `pp`.`plandata`, `createComapnyByCrons`.`status` as `createCompany`, IF( pp.payment_status = 'complete', `pp`.`expiredDate`, '' ) as expiredDate, ( Select Count(*) FROM `comp_users` u where `u`.`deleted` = 0 AND `u`.`roleId` = 4 ) as c FROM `comp_users` `u` LEFT JOIN `payment_history` `pp` on `u`.`company_code` = `pp`.`company_code` LEFT JOIN `createComapnyByCrons` on `createComapnyByCrons`.`compId` = `u`.`id` where `u`.`deleted` = 0 AND pp.payment_status='complete'AND `u`.`roleId` = 4 group by `u`.`company_code`  $serachSql $limitval";

        /*cho $sql = "SELECT `u`.*, `pp`.`plandata`,   IF(pp.payment_status='complete', `pp`.`expiredDate`, '') as expiredDate, 
           (Select Count(*) FROM `comp_users` u  where `u`.`deleted` = 0 AND `u`.`roleId` = 4) as c FROM `comp_users` `u` 
           LEFT JOIN `payment_history` `pp` on `u`.`company_code` =`pp`.`company_code` 
           where `u`.`deleted` = 0 AND pp.payment_status='complete'AND `u`.`roleId` = 4 group by `u`.`company_code`  $serachSql $limitval";*/
            return $this->get_results($sql);
        }
    }

   

function getSettingData($userID){


 $sql = "SELECT * FROM `createComapnyByCrons` where compId='" . $userID . "'";

            return $this->get_row($sql);


} 
    
    function getCustomerList($arg = array(),$searchType = '', $searchKeyword = ''){       
        extract($arg);
        if (isset($id)) {
          $sql = "SELECT * FROM `comp_users` where id='" . $id . "'";
            return $this->get_row($sql);
        } else {
        	
            
            $offset=$arg['offset'];
            $limit=$arg['limit'];
            if(isset($limit) AND isset($offset))
                $limitval="LIMIT $offset , $limit";
            
              
             $serachSql = '';
            if (!empty($searchType) && !empty($searchKeyword)) {
                if ($searchType == 'byName') {
                    $serachSql .= " AND ( `user`.firstName like '%" . $searchKeyword . "%' || `user`.lastName like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byEmail') {
                    $serachSql .= " AND ( `user`.username like '%" . $searchKeyword . "%' ) ";
             
                } else if ($searchType == 'byCompany') {
                    $serachSql .= " AND ( `user`.company_code like '%" . $searchKeyword . "%'  ) ";
                }
                  else if ($searchType == 'byRegisteredDate') {
                    $serachSql .= " AND ( `user`.recordInsertedDate like '%" . $searchKeyword . "%'  ) ";
                }
                
                
            }
            
            $where ="where roleId=2";
           $sql = "SELECT * , (Select Count(*) FROM `comp_users`  $where $serachSql) as c FROM `user` $where $serachSql $limitval";
            
            return $this->get_results($sql);
        }
    }
            
    
    function getOrderList($arg = array(),$searchType = '', $searchKeyword = ''){
        
         extract($arg);
         if (isset($id)) {
          $sql = "SELECT * FROM `comp_users` where id='" . $id . "'";
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
                    $serachSql .= " ( `comp_users`.firstName like '%" . $searchKeyword . "%' || `comp_users`.lastName like '%" . $searchKeyword . "%' ) ";
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
                . " INNER JOIN `comp_users` ON `user`.`id` = `purchased_document`.`userId` ";
               $sql.= "INNER JOIN `comp_users` as secUser ON `secUser`.`id` = `author_document`.`author_id`";
                      if(!empty($searchType)){
               $sql.=  "where $serachSql";
              } 
               $sql.= ") AS `c`,";
     $sql.= "DATE_FORMAT(paymentDate, '%b %d,%Y') AS `paymentDate`, "
                . "`author_document`.`id` AS `documentId`, "
                . "`author_document`.`title` AS `document`, "
                . "`author_document`.`doc_type` AS `documentType`, "
                . "`comp_users`.`id` AS `userId`, "
                . "`purchased_document`.`order_id` AS `orderid`, "
                . "concat(comp_users.firstName, ' ', comp_users.lastName) AS `user`,"
                . " concat( secUser.firstName, ' ', secUser.lastName ) AS `author`, "
                . "`secUser`.`id` AS `Id`, "
                . "`user`.`company_code` AS `company` "
                . "FROM `purchased_document` "
                . "INNER JOIN `author_document` ON `author_document`.`id` = `purchased_document`.`documentId` "
                . "INNER JOIN `comp_users` ON `comp_users`.`id` = `purchased_document`.`userId`";
            $sql.= "INNER JOIN `comp_users` as secUser ON `secUser`.`id` = `author_document`.`author_id` ";
            if(!empty($searchType)){
            $sql.=  "where $serachSql";
              }
         $sql.=  "ORDER BY `purchased_document`.`id`   $limitval"; 
       

     return $this->get_results($sql);
        }
    }
            


    //**************** get payment history
    function getOrderHistory($arg = array(),$compcod,$id='',$Todate,$Fromdate)
    {
        
         extract($arg);
        $offset = $arg['offset'];
        $limit = $arg['limit'];

        if (isset($limit) AND isset($offset)){
            $limitval = "LIMIT $offset , $limit";
        }
        $serachSql = '';
        if (!empty($Todate) && !empty($Fromdate)) {
           
             $serachSql .= " AND `payment_history`.recordInsertedDate between  '" . $Todate . "' AND '" . $Fromdate . "'";
    
        }
     $sql= "SELECT `payment_history`.`id` AS `id`, `payment_history`.`txnId` AS `txnId`, `payment_history`.`company_code` AS `company_code`, `payment_history`.`recordInsertedDate` AS `recordInsertedDate`,"
               . " `payment_history`.`amount` AS `amount`, "
               . "sum( if( bill_key = 'OverDoc', bill_amount, 0 ) ) AS `DocCost`, "
               . "sum( if( bill_key = 'OverPage', bill_amount, 0 ) ) AS `PageCost`, "
               . "sum( if( bill_key = 'OverVideo', bill_amount, 0 ) ) AS `VideoCost`, "
               . "sum( if( bill_key = 'OverVideoSize', bill_amount, 0 ) ) AS `VideoSizeCost`, "
               . "sum( if( bill_key = 'OverUser', bill_amount, 0 ) ) AS `UserCost`, "
               . "sum( if( bill_key = 'OverDoc', extra_uses, 0 ) ) AS `extraDoc`, "
               . "sum( if( bill_key = 'OverPage', extra_uses, 0 ) ) AS `extraPage`, "
               . "sum( if( bill_key = 'OverVideo', extra_uses, 0 ) ) AS `extraVideo`, "
               . "sum( if( bill_key = 'OverVideoSize', extra_uses, 0 ) ) AS `extraVideoSize`, "
               . "sum( if( bill_key = 'OverUser', extra_uses, 0 ) ) AS `extraUser` "
         
               . "FROM `payment_history` LEFT JOIN `company_bill` ON company_bill.payment_id = payment_history.id and company_bill.bill_key!='Plan' "
               . "and company_bill.status='Paid' ";
          
     $sql.=  "WHERE payment_status = 'complete' AND `payment_history`.`company_code` = '" .$compcod ."'$serachSql";
           if(!empty($id)){
            $sql.=  " AND  `payment_history`.`id` = '" .$id ."'";
              }
            $sql.=  " GROUP BY payment_history.id $limitval";
             
            
      
         $order= $this->get_results($sql);
	  return $order;
    }
    
    
    public function FindCompUsers($id) {
        $sql = "SELECT * FROM `comp_users` where `id`='" .$id ."'";
        $sql = $this->get_results($sql); ;
        return $sql;
    }
    function AddUserdata($arryDetails) {
        extract($arryDetails);
        $this->insert('comp_users', $arryDetails); 
 $lastID = $this->insert_id;   
      return $lastID;
    }

     function AddUserCronsdata($arryDetails) {
        extract($arryDetails);
        $this->insert('createComapnyByCrons', $arryDetails); 
     $lastID = $this->insert_id;   
      return $lastID;
    }


     function AddUserPackagedata($arryDetails) {
        extract($arryDetails);  
        $this->insert('payment_history', $arryDetails); 
        $pckgID = $this->insert_id;   
$_SESSION['msg'] = "Company has been add successfully. "; 
 return 1;
        //return $pckgID;
    }
    
     function AddUserCompanystatus($arryDetails) {
        extract($arryDetails);      
        $this->insert('companystatus', $arryDetails); 
        $pckgID = $this->insert_id;      
        return $pckgID;
    }
    
    function UpdateUserdata($arryDetails, $userID) {


        extract($arryDetails);
        if (!empty($userID)) {   
           $this->update('comp_users', $arryDetails, array('id' => $userID));
             
          
            $_SESSION['msg'] = "Company has been update successfully. "; 
        }
        return 1;
    }


function UpdateUserstorage($arryDetails, $userID){

$updatedata=array('allow_storage' => $arryDetails['allow_storage']
);
$insertdata=array('company_code' => $arryDetails['company_code'], 
'allow_storage' => $arryDetails['allow_storage'],
'inserted_by' => $arryDetails['userID']
);

       $this->update('companystatus', $updatedata, array('companycode' => $arryDetails['company_code']));
       $this->insert('companystorage_log', $insertdata); 
              return 1;
}
    function DeleteUser($userID) {
        $this->delete('comp_users', array('id' => $userID));
        return 1;
    }

function changeCompanyStatus($arryDetails, $userID) {

        if (!empty($arryDetails)) {
            if ($arryDetails['status'] == 1)
                $arryDetails['status'] = 0;
            else
                $arryDetails['status'] = 1;
            $this->update('comp_users', $arryDetails, array('id' => $userID));
        }
        return true;
    }

    function ChangePassword($arryDetails, $id) { 
        extract($arryDetails);
        if (!empty($id)) {
            $this->update('comp_users', $arryDetails, array('id' => $id));
        }
        return 1;
    }

    public function GetCompUsers($compcod,$userRoleID=3) {
       $sql = "SELECT *  FROM  `comp_users` where company_code='" .$compcod ."' AND  roleId='".$userRoleID."'";

        $sql= $this->get_results($sql);
        return $sql;
     }
      
     function getPackage($pckg_id)
    {
         //echo $pckg_id;
       
            $sql = "SELECT * FROM `plan_package`";
            $sql = $this->get_results($sql); 
              return  $sql;
    }

      function getPackageById($userPackageId)
    {
        if(!empty($userPackageId))
                { 
               $sql = "SELECT * FROM `plan_package` where id='".$userPackageId."'";  
                }
              return  $this->get_results($sql); 
    }

     function getPlanPackage($compcod,$status)
    {
        if(!empty($compcod))
                { 
             $sql = "SELECT * FROM `payment_history` where company_code='" .$compcod ."' && status='".$status."'";
               
                }
              return  $this->get_results($sql); 
    }

    

    function pagingChat($page, $limit, $offset, $num, $totalrecords) {
        $intLoopStartPoint = 1;
        $intLoopEndPoint = $totalrecords;
        $strURL = $pageslink=$intTotalNumPage='';
       
        if (($page) > ($totalrecords)) {
            $intLoopStartPoint = $page - $num + 1;
            if (($intLoopStartPoint + $limit) <= ($num)) {
                $intLoopEndPoint = $intLoopStartPoint + $limit - 1;
            } else {
                $intLoopEndPoint = $totalrecords;
            }
        }
 
        if (($num > $limit) && ($page != 1)) {
           
           $pageslink.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?curP=1&" . $strURL . "\" class=\"pagenumber\"><<</a> ";
       
            }

        if ($intLoopStartPoint > 1) {
            $intPreviousPage = $page - 1;
            $pageslink.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?curP=" . $intPreviousPage . "&" . $strURL . "\" class=\"edit22\"> &lt;&lt; </a> ";
        }

        for ($i = $intLoopStartPoint; $i <= $intLoopEndPoint; $i++) {
            if ($page == $i) {
                //$this->strShowPaging.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$this->strURL."\" class=\"pagenumber\"><b>".$i."</b></a> ";
               $pageslink.= '<span class="pagenumber"><b>' . $i . '</b></span> ';
            } else {
                $pageslink.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?curP=" . $i . "&" . $strURL . "\" class=\"pagenumber\">" . $i . "</a> ";
            }
            if ($i != $intLoopEndPoint) {
                $pageslink.=" ";
            }
        }

        if ($intLoopEndPoint < $intTotalNumPage) {
            $intNextPage = $page + 1;
            $pageslink.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?curP=" . $intNextPage . "&" . $strURL . "\" class=\"edit22\"> &gt;&gt; </a> ";
        }

        if (($totalrecords > $limit) && ($page != $totalrecords)) {
            $pageslink.="<a href=\"" . basename($_SERVER['PHP_SELF']) . "?curP=" . $totalrecords . "&" . $strURL . "\" class=\"pagenumber\">>></a>";
    }
        //echo $pageslink;
        return $pageslink;
    }

    
    /*     * ***************************end Pagination************************************************* */
}

?>
