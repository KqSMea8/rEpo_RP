<?php
/* Developer Name: Niraj Gupta
 * Date : 29-06-15
 * 
 * Description: For User class
 * @param: 
 * @return: 
 */
class company extends dbClass {
/*
 * Name: user
 * Description: For Superadmin  company user managements
 * @param: 
 * @return: 
 */
	
 //function getUser($arg = array(), $userID,$count=false) 
/*function getUser($arg = array(), $userID,$count=false){   
        if (isset($userID)) { 
            $sql = "SELECT * FROM `flow_compnay` where cmp_id='" . $userID . "'";
            return $this->get_row($sql);
        } 
		else {
			$offset=$arg['offset'];
           		$limit=$arg['limit'];
			if(isset($limit) AND isset($offset))
		        $limitval="LIMIT $offset , $limit";

                 $sql="SELECT flow_company_membership.id,flow_compnay.cmp_id, flow_compnay.name, flow_compnay.email,flow_company_membership.expire_date ,flow_company_membership.allow_users,flow_compnay.status,flow_compnay.created_date  FROM  flow_compnay left JOIN flow_company_membership ON flow_compnay.cmp_id=flow_company_membership.cmp_id $limitval  ";
		       // $sql = "SELECT * , (Select Count(*) FROM flow_compnay) as c FROM `flow_compnay` $limitval";   
                     // print_r($sql); die();         
                	return $this->get_results($sql);
		       //$sql = "SELECT * FROM `flow_compnay`";
		       //return $this->get_results($sql);
	
           }


    }*/

function getRecords($arg = array(),$count=false){
    $offset=$arg['offset'];
           		$limit=$arg['limit'];
			if(isset($limit) AND isset($offset))
		        $limitval="LIMIT $offset , $limit";
   //  $sql = "select count(*) As Total from `flow_compnay`";
                 $sql="SELECT count(*) As Total FROM  flow_compnay INNER  JOIN flow_company_membership ON flow_compnay.cmp_id=flow_company_membership.cmp_id $limitval ";

     return $this->get_results($sql);
     
}

//*********************ganesh 7 jan****************************//
function getUser($arg = array(), $userID,$count=false) {   
        if (isset($userID)) { 
            //$sql = "SELECT * FROM `flow_compnay` where cmp_id='" . $userID . "'";
            $sql="SELECT flow_company_membership.id, flow_compnay.cmp_id, flow_company_membership.membership_type,flow_compnay.name, flow_compnay.email, flow_company_membership.expire_date, flow_company_membership.allow_users, flow_compnay.status, flow_compnay.created_date FROM flow_compnay INNER  JOIN flow_company_membership ON flow_compnay.cmp_id = flow_company_membership.cmp_id WHERE flow_compnay.cmp_id = $userID";
          //echo $sql=" SELECT flow_company_membership.id,flow_compnay.cmp_id, flow_compnay.name, flow_compnay.email,flow_company_membership.expire_date ,flow_company_membership.allow_users,flow_compnay.status,flow_compnay.created_date  FROM  flow_compnay left JOIN flow_company_membership ON flow_compnay.cmp_id=flow_company_membership.cmp_id where cmp_id=$userID ";
            return $this->get_row($sql);
        } 
		else {
			$offset=$arg['offset'];
           		$limit=$arg['limit'];
			if(isset($limit) AND isset($offset))
		        $limitval="LIMIT $offset , $limit";
		      //  $sql = "SELECT * , (Select Count(*) FROM flow_compnay) as c FROM `flow_compnay` $limitval"; 
                        
                 $sql="SELECT flow_company_membership.id,flow_compnay.cmp_id, flow_compnay.name, flow_compnay.email,flow_company_membership.expire_date ,flow_company_membership.allow_users,flow_compnay.status,flow_compnay.created_date  FROM  flow_compnay INNER  JOIN flow_company_membership ON flow_compnay.cmp_id=flow_company_membership.cmp_id $limitval  ";
                     // print_r($sql); die();         
                	return $this->get_results($sql);
		       //$sql = "SELECT * FROM `flow_compnay`";
		       //return $this->get_results($sql);
	
           }


    }
//*********************end****************************//



  /*function AddUserdata($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('flow_compnay', $arryDetails);
        $pckgID = $this->insert_id;
        return $pckgID;
    }*/


//*********************ganesh 8 jan****************************//
function AddUserdata($arryDetails) {

    
     $sql = "SELECT * FROM `flow_compnay` where email='" . $arryDetails['email'] . "'";
     
     $result  =$this->get_results($sql);
   
     
     
    if (!$result){  
        
      
        $arryflow=array('name'=>$arryDetails['name'],'email'=>$arryDetails['email'],'status'=>$arryDetails['status'],'created_date'=>$arryDetails['created_date']);
        extract($arryDetails);
        $result = $this->insert('flow_compnay', $arryflow);
        $pckgID = $this->insert_id;
        if($pckgID!=''){
            $arryDetail=  array('cmp_id'=>$pckgID,'name'=>$arryDetails['name'],'email'=>$arryDetails['email'],'rand_key'=>$arryDetails['rand_key'], 'password'=>$arryDetails['password'],'status'=>$arryDetails['status'],'user_type'=>2) ; 
            $result = $this->insert('flow_users', $arryDetail);
            $arryDetai=  array('cmp_id'=>$pckgID,'expire_date'=>$arryDetails['expire_date'],'allow_users'=>3,'plan_duration'=>3,'membership_type'=>$arryDetails['membership_type'],);
          //  print_r($arryDetails);die;
            $result = $this->insert('flow_company_membership', $arryDetai);
$_SESSION['msg'] = "Company has been registered successfully. "; 
          
        }
       
        return $pckgID;
  }else{
       $RedirectURL = "addCompany.php"; 
          $_SESSION['msg'] = "Email already exist";       
          header("Location:".$RedirectURL);exit; 
      
  }
  
        }

//*********************end****************************//
function AddUseruserdata($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('flow_users', $arryDetails);
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
               $data=array('plan_package_element'=>$arryDetails['plan_package_element'],'exp_date'=>$newDate);
               
              
               # ##update data on the basis of existing package in user_plan table
               $this->update('user_plan', $data, array('userCompcode' => $comcode));
               
               ##update data on the basis of existing package in order_payment table
               $orderdata=array('amount'=>$arryDetails['pckg_price'],'package_id' => $userPackageId,'plan_package_element'=>$arryDetails['plan_package_element']);
             //  print_r($orderdata);die;
               $this->update('order_payment', $orderdata, array('companycode' => $comcode));

            } else {
                // update Exp Date And update element & package id
               $datetime = new DateTime(date());
               $datetime->modify("+ " . $arryDetails['exp_date'] . " day");
               $newDate = $datetime->format('Y-m-d');
                 //$arryDetails['exp_date']=365;
                //die
               // $arryDetails['exp_date']=1;
               // $newDate =date('Y-m-d',strtotime(date('Y-m-d')."+".$arryDetails['exp_date']." days"));
               
               $data=array('plan_package_element'=>$arryDetails['plan_package_element'],'exp_date'=>$newDate,'userPackageId' => $userPackageId);
             
              ##update data on the basis of existing package in user_plan table
               $this->update('user_plan', $data, array('userCompcode' => $comcode));
             
               ##update data on the basis of existing package in order_payment table
               $orderdata=array('amount'=>$arryDetails['pckg_price'],'package_id' => $userPackageId,'plan_package_element'=>$arryDetails['plan_package_element']);
            
               $this->update('order_payment', $orderdata, array('companycode' => $comcode));
            }
          //  unset($arryDetails['userCompcode']);
          //  $this->update('user_plan', $arryDetails, array('userPackageId' => $userPackageId, 'userCompcode' => $comcode));
          } else {
           ##Insert data on the basis of existing package in order_payment table
          $order_data=array('companycode'=>$arryDetails['userCompcode'],'payment_type'=>'cash','txn_id'=>'NULL','amount'=>$arryDetails['pckg_price'],'package_id' => $userPackageId,'plan_package_element'=>$arryDetails['plan_package_element'],'status'=>'1','date'=>date('Y-m-d h:i:s'));
         
          $result = $this->insert('order_payment', $order_data);
              ##Insert data on the basis of existing package in user_plan table
            unset($arryDetails['pckg_price']);
            $result = $this->insert('user_plan', $arryDetails);
            
        }
        return $result;
    }
    
/*function UpdateUserdata($arryDetails,$userID)
                {   
			extract($arryDetails);
			if(!empty($userID)){
			$this->update('flow_compnay',$arryDetails,array('cmp_id'=>$userID));
			}
			return 1;
		}*/




//*********************ganesh 7 jan****************************//
function UpdateUserdata($arryDetails,$userID)
                {   
 
 
  
			extract($arryDetails);
                        $arryflow=array('name'=>$arryDetails['name'],'status'=>$arryDetails['status']);
                        
                    $arryDetail=  array('expire_date'=>$arryDetails['expire_date'],'allow_users'=>$arryDetails['allow_users'],'membership_type'=>$arryDetails['membership_type']) ;  
			if(!empty($userID)){
			echo $this->update('flow_compnay',$arryflow,array('cmp_id'=>$userID));
                     echo $this->update('flow_company_membership',$arryDetail,array('cmp_id'=>$userID));
$_SESSION['msg'] = "Company details has been updated successfully. "; 
			}
			return 1;
		}

//*********************end****************************//
function UpdateUseruserdata($name, $userID, $email)
                {   
			
			if(!empty($userID)){
			$sql = "UPDATE flow_users SET name='".$name."' where cmp_id='" . $userID . "' AND email='".$email."'";
		       return $this->get_results($sql);
			//print_r($sql);
			}
			
		}
    
    function DeleteUser($userID) {
        $this->delete('flow_compnay', array('cmp_id' => $userID));
        return 1;
    }
    
    
function changeUserStatus($arryDetails,$userID)
 {   
                    if(!empty($arryDetails)){
					if($arryDetails['status']=='Active')
						$arryDetails['status']='Inactive';
					else
						$arryDetails['status']='Active';
					$this->update('flow_compnay',$arryDetails,array('cmp_id'=>$userID));					
                                 }
			return true;

		}
		
function ChangePassword($name,$userID)
		{  //echo $userID;
			//print_r($arryDetails);die(test);
			extract($arryDetails);
			if(!empty($userID)){
			$sql = mysql_query("UPDATE flow_users JOIN flow_compnay  ON flow_compnay.email= flow_users.email SET flow_users.password='".$name."' where flow_compnay.cmp_id='" . $userID . "'");
				//echo 'eeeeee'.$sql;
				//echo 'qqqqq'.mysql_affected_rows();
		       		return mysql_affected_rows();
				
				
				//echo $ram[0]->affected_rows;
			}
			return 1;
		}	
/*public function GetCompUsers($compcod,$userRoleID) {
	 $sql = "SELECT * FROM `flow_users` where userCompcode='" .$compcod ."' && userRoleID='".$userRoleID."'";
	  $rajan= $this->get_results($sql);
	  return $rajan;
 }
 public function FindCompUsers($compcod,$userRoleID,$vari) {
	  $sql = "SELECT * FROM `flow_users` where userCompcode='" .$compcod ."' AND userRoleID='".$userRoleID."' AND (userFname ='".$vari."' OR userEmail ='".$vari."' OR userContacts ='".$vari."')";
	 $rajan= $this->get_results($sql);
	// print_r($rr);
	 return $rajan;		
}
*/
public function randomPassword() {
             $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
             $pass = array(); //remember to declare $pass as an array
             $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
             for ($i = 0; $i < 10; $i++) {
              $n = rand(0, $alphaLength);
              $pass[] = $alphabet[$n];
              }
             return implode($pass); //turn the array into a string
             }


/*****************************Pagination( Ravi Solanki) edited Amit Singh**************************************************/
function pagingChat($page,$limit,$offset,$num,$totalrecords){
        
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

/*****************************end Pagination**************************************************/


}
?>
