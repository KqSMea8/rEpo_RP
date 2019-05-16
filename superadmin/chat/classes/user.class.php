<?php

/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * 
 * Description: For User class
 * @param: 
 * @return: 
 */
class user extends dbClass {
/*
 * Name: user
 * Description: For Superadmin  company user managements
 * @param: 
 * @return: 
 */
	
    function getUser($arg = array(), $userID,$count=false) {   
        $limitval='';
        if (!empty($userID)) { 
            $sql = "SELECT *  FROM `users` LEFT JOIN user_plan ON user_plan.userCompcode=users.userCompcode where userID='" . $userID . "'";
            return $this->get_row($sql);
        } else { 
                
            $where='WHERE 1 ';
            if(!empty($arg['userRoleID']))
                    $where .=' AND userRoleID="'.$arg['userRoleID'].'"';
           
         
            if(isset($arg['limit']) AND isset($arg['offset'])){
		 $offset=$arg['offset'];
            	  $limit=$arg['limit'];
                $limitval="LIMIT $offset , $limit";
	    }

             $sql = "SELECT * , (Select Count(*) FROM users  $where) as c FROM `users` $where $limitval";   
                               
                return $this->get_results($sql);
        }
    }


    function AddUserdata($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('users', $arryDetails);
        $pckgID = $this->insert_id;
        return $pckgID;
    }

    function AddUserPackagedata($arryDetails) { 
       // print_r($arryDetails);die;
        extract($arryDetails);
        $comcode = $arryDetails['userCompcode'];
        $packageid = $arryDetails['userPackageId'];
        $sql = "SELECT * FROM `user_plan` where userCompcode='" . $comcode . "'";
        $result = $this->get_row($sql);
      
        if (!empty($result)) {
            if ($result->userPackageId == $packageid) {
                // increase Exp Date And update element 
                $olddate = $result->exp_date;
                $newDays = $arryDetails['exp_date'];
                // $newDate =date('Y-m-d',strtotime($olddate."+".$newDays." days"));

                // Date format function 
                $datetime = new DateTime($olddate);
                $datetime->modify("+ " . $arryDetails['exp_date'] . " day");
                $newDate = $datetime->format('Y-m-d');
                $data=array(
                    'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    ,'exp_date'=>$newDate
                    );
               
              
                # ##update data on the basis of existing package in user_plan table
                 $this->update('user_plan', $data, array('userCompcode' => $comcode));
               
                ##update data on the basis of existing package in order_payment table
                //****************************Amit Singh****************************************/
               
                $amt=$arryDetails['pckg_price']*$arryDetails['allow_user'];
               
                //********************************************************************************/
                $orderdata=array(
                    'amount'=>$amt
                    ,'package_id' => $userPackageId
                    ,'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    );
                //  print_r($orderdata);die;
                $this->update('order_payment', $orderdata, array('companycode' => $comcode));

            }else {
                // update Exp Date And update element & package id
                $datetime = new DateTime(date());
                $datetime->modify("+ " . $arryDetails['exp_date'] . " day");
                $newDate = $datetime->format('Y-m-d');
                 //$arryDetails['exp_date']=365;
                //die
                // $arryDetails['exp_date']=1;
                // $newDate =date('Y-m-d',strtotime(date('Y-m-d')."+".$arryDetails['exp_date']." days"));
               
               $data=array(
                    'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    ,'exp_date'=>$newDate
                    ,'userPackageId' => $userPackageId
                    );
             
                ##update data on the basis of existing package in user_plan table
                $this->update('user_plan', $data, array('userCompcode' => $comcode));
             
                ##update data on the basis of existing package in order_payment table
                //**************************Amit singh******************************/
                $amt=$arryDetails['pckg_price']*$arryDetails['allow_user'];
                //*********************************************************/
                $orderdata=array(
                    'amount'=>$amt
                    ,'package_id' => $userPackageId
                    ,'plan_package_element'=>$arryDetails['plan_package_element']
                    ,'package_detail'=>$arryDetails['package_detail']//amit singh
                    );
            
                $this->update('order_payment', $orderdata, array('companycode' => $comcode));
            }
            //  unset($arryDetails['userCompcode']);
            //  $this->update('user_plan', $arryDetails, array('userPackageId' => $userPackageId, 'userCompcode' => $comcode));
        }else {
            ##Insert data on the basis of existing package in order_payment table
            /***************************add users into amount(Amit Singh)***************************************/
            $arryDetails['pckg_price']=$arryDetails['pckg_price']*$arryDetails['allow_user'];
              
              ///**********************************************************/
            $order_data=array(
                'companycode'=>$arryDetails['userCompcode'],
                'payment_type'=>'cash',
                'txn_id'=>'NULL',
                'amount'=>$arryDetails['pckg_price'],
                'allow_user'=>$arryDetails['allow_user'],
                'package_id' => $userPackageId,             
                'plan_package_element'=>$arryDetails['plan_package_element'],
                'package_detail'=>$arryDetails['package_detail'],
                'status'=>'1',
                'date'=>date('Y-m-d h:i:s')
                );
            //print_r($order_data);die('fsgdfgfsdgfd');
            $result = $this->insert('order_payment', $order_data);
            ##Insert data on the basis of existing package in user_plan table
            unset($arryDetails['pckg_price']);
            $result = $this->insert('user_plan', $arryDetails);    
        }
        return $result;
    }
    
    function UpdateUserdata($arryDetails,$userID)
    {   
        extract($arryDetails);
        if(!empty($userID)){
        $this->update('users',$arryDetails,array('userID'=>$userID));
        }
        return 1;
    }

    
    function DeleteUser($userID) {
        $this->delete('users', array('userID' => $userID));
        return 1;
    }
    
    
    function changeUserStatus($arryDetails,$userID)
    {   
        if(!empty($arryDetails)){
            if($arryDetails['status']==1)
                    $arryDetails['status']=0;
            else
                    $arryDetails['status']=1;
            $this->update('users',$arryDetails,array('userID'=>$userID));					
        }
        return true;
    }
		
    function ChangePassword($arryDetails,$userID)
    {  //echo $userID;
            //print_r($arryDetails);die(test);
            extract($arryDetails);
            if(!empty($userID)){
            $this->update('users',$arryDetails,array('userID'=>$userID));
            }
            return 1;
    }		
		
    public function GetCompUsers($compcod,$userRoleID) {
        $sql = "SELECT * FROM `users` where userCompcode='" .$compcod ."' && userRoleID='".$userRoleID."'";
        $rajan= $this->get_results($sql);
        return $rajan;
     }
    public function FindCompUsers($compcod,$userRoleID,$vari) {
        $sql = "SELECT * FROM `users` where userCompcode='" .$compcod ."' AND userRoleID='".$userRoleID."' AND (userFname ='".$vari."' OR userEmail ='".$vari."' OR userContacts ='".$vari."')";
        $rajan= $this->get_results($sql);
        // print_r($rr);
        return $rajan;		
    }


/*****************************Pagination( Ravi Solanki) edited Amit Singh**************************************************/
function pagingChat($page,$limit,$offset,$num,$totalrecords){
        $pageslink=$intTotalNumPage='';
        $intLoopStartPoint = 1;
        $intLoopEndPoint= $totalrecords;
         $strURL='';
        
        if(($page) > ($totalrecords)){
            $intLoopStartPoint = $page - $num + 1;
            if (($intLoopStartPoint + $limit) <= ($num)) {
                    $intLoopEndPoint=$intLoopStartPoint + $limit - 1;
            } else {
                    $intLoopEndPoint = $totalrecords;
            }
        } 
        
        if (($num > $limit) && ($page != 1)) {
            $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=1&".$strURL."\" class=\"pagenumber\"><<</a> ";							
        }
        
        if ($intLoopStartPoint > 1) {
            $intPreviousPage=$page - 1;
            $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$intPreviousPage."&".$strURL."\" class=\"edit22\"> &lt;&lt; </a> ";			
        }	
        
        for($i=$intLoopStartPoint;$i<=$intLoopEndPoint;$i++){
            if ($page==$i) {
            //$this->strShowPaging.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$this->strURL."\" class=\"pagenumber\"><b>".$i."</b></a> ";
                $pageslink.= '<span class="pagenumber"><b>'.$i.'</b></span> ';
            } else {
                $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$strURL."\" class=\"pagenumber\">".$i."</a> ";
            }
            if ($i!=$intLoopEndPoint) {
                    $pageslink.=" ";
            }
        }
			
        if ($intLoopEndPoint < $intTotalNumPage) {
                $intNextPage=$page+1;
                $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$intNextPage."&".$strURL."\" class=\"edit22\"> &gt;&gt; </a> ";
        }
        
        if (($totalrecords > $limit) && ($page != $totalrecords)) {
        $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$totalrecords."&".$strURL."\" class=\"pagenumber\">>></a>";			
        }
        //echo $pageslink;
        return $pageslink;
    }
    //**************** get payment history
    function getOrderHistory($val)
    {
         $sql = "SELECT * FROM `order_payment` where companycode='".$val."'";// where userCompcode='" .$compcod ."' && userRoleID='".$userRoleID."'";
	  $ord= $this->get_results($sql);
	  return $ord;
    }

/*****************************end Pagination**************************************************/

}
?>
