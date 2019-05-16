<?php

class user extends dbClass {

    function getUser($arg = array(), $userID = '', $searchType = '', $searchKeyword = '') {

        extract($arg);
        $limitval = ''; // amit singh
        if (!empty($userID)) {
            $sql = "SELECT * FROM `user` where id='" . $userID . "'";
            return $this->get_row($sql);
        } else {
            //*********************Amit Singh**************************/
            $offset = $arg['offset'];
            $limit = $arg['limit'];

            if (isset($limit) AND isset($offset))
                $limitval = "LIMIT $offset , $limit";

            $serachSql = '';
            if (!empty($searchType) && !empty($searchKeyword)) {
                if ($searchType == 'byName') {
                    $serachSql .= " AND ( `u`.firstName like '%" . $searchKeyword . "%' || `u`.lastName like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byEmail') {
                    $serachSql .= " AND ( `u`.username like '%" . $searchKeyword . "%' || `u`.email like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byExpiryDate') {
                    $serachSql .= " AND ( `u`.expiryDate like '%" . $searchKeyword . "%' ) ";
                } else if ($searchType == 'byCreatedDate') {
                    $serachSql .= " AND ( `u`.recordInsertedDate like '%" . $searchKeyword . "%'  ) ";
                }
            }

            $sql = "SELECT `u`.*, `pp`.`pckg_name`, (Select Count(*) FROM `user` u  where `u`.`deleted` = 0 AND `u`.`parentId` = 0) as c FROM `user` `u` LEFT JOIN `plan_package` `pp` on `u`.`packageId` =`pp`.`pckg_id` where `u`.`deleted` = 0 AND `u`.`parentId` = 0 $serachSql $limitval";

            return $this->get_results($sql);
        }
    }

    function getPaymentHistory($arg = array()) {
       // echo "<pre>"; print_r($arg);
         extract($arg);
        $offset = $arg['offset'];
        $limit = $arg['limit'];

        if (isset($limit) AND isset($offset)){
            $limitval = "LIMIT $offset , $limit";
        }
        $serachSql = '';
        if (!empty($type) && !empty($keyword)) {
            if ($type == 'byDate') {
                $serachSql .= " where  `payment_history`.`recordInsertedDate` like '" . $keyword . "%' ";
            } else if ($type == 'byTxnId') {
                $serachSql .= " where  `payment_history`.`txnId` like '%" . $keyword . "%' ";
            } 
        }

         $sql = "SELECT `user`.`email`,`user`.`telephone`,`user`.`firstName`,`user`.`lastName`, `payment_history`.`amount`,`payment_history`.`recordInsertedDate`,`payment_history`.`txnId`,(Select Count(*) FROM `payment_history`) as c from `payment_history` join `user` on `user`.`id`=`payment_history`.`userId` $serachSql  $limitval";
        
        return $this->get_results($sql);
    }

    function AddUserdata($arryDetails) {
        extract($arryDetails);
        $this->insert('user', $arryDetails); //print_r($result);die('raj');
        $pckgID = $this->insert_id;
        // print_r($pckgID);die('raj');
        return $pckgID;
    }

    function UpdateUserdata($arryDetails, $userID) {
        extract($arryDetails);
        if (!empty($userID)) {
            $this->update('user', $arryDetails, array('id' => $userID));
        }
        return 1;
    }

    function DeleteUser($userID) {
        $this->delete('user', array('id' => $userID));
        return 1;
    }

    function changeUserStatus($arryDetails, $userID) {
        if (!empty($arryDetails)) {
            if ($arryDetails['status'] == 1)
                $arryDetails['status'] = 0;
            else
                $arryDetails['status'] = 1;
            $this->update('user', $arryDetails, array('id' => $userID));
        }
        return true;
    }

    function ChangePassword($arryDetails, $id) {  //echo $id;
        //print_r($arryDetails);die('rajan');
        extract($arryDetails);
        if (!empty($id)) {
            $this->update('user', $arryDetails, array('id' => $id));
        }
        return 1;
    }

    public function FindCompUsers($vari) {
        $sql = "SELECT * FROM `user` where  (firstName ='" . $vari . "'  OR lastName ='" . $vari . "' OR email ='" . $vari . "' OR telephone ='" . $vari . "' OR cellular ='" . $vari . "')";
        $rajan = $this->get_results($sql);
        // print_r($rr);
        return $rajan;
    }

    /*     * ***************************Pagination( Ravi Solanki) edited Amit Singh************************************************* */

    function pagingChat($page, $limit, $offset, $num, $totalrecords) {

        $intLoopStartPoint = 1;
        $intLoopEndPoint = $totalrecords;
        $strURL = '';

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

    /*     * ************** get payment history
      function getOrderHistory($val)
      {
      $sql = "SELECT * FROM `order_payment` where companycode='".$val."'";// where userCompcode='" .$compcod ."' && userRoleID='".$userRoleID."'";
      $ord= $this->get_results($sql);
      return $ord;
      }/ */

    /*     * ***************************end Pagination************************************************* */
}

?>
