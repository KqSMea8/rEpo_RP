<?php 

class phone extends dbFunction
{
		//constructor
		var $tables;
		public $server_id;
		function phone()
		{
			global $configTables,$Config;		
			$this->tables=$configTables;
			$this->dbClass();
		} 
	/*
	 * Cheack User Email exits or not
	 *
	 * @$email (staring) about this param
	 * @return (0 OR 1)
	 */
	
	function connectCallServer($data , $server_id, $secret=""){	
		$empdata =array();			
			$results=$saveId=array();
		
				 $empdata =	$this->getCallRegiUserid($server_id);				
				if(!empty($data)){
					foreach( $data as $val){
						$results=array();
						if(!empty($val['agentID'])){
						
							if(!is_int($val['EmpID'])){
								$adminid=explode('-',$val['EmpID']);
								if(empty($adminid[1])){
								$val['EmpID']=$adminid[0];
								}else{						
								$val['EmpID']=$adminid[1];
								$results['type']='admin';	
								}					
							}
							
							$results['user_id']=$val['EmpID'];
							$results['agent_id']=$val['agentID'];
							$results['server_id']=$server_id;		
						    $results['password'] = $secret;
							
							
							if(!in_array($empdata,$val['EmpID'])){							
							$saveId[] =	$this->insert('c_callUsers',$results);
							}else{
							// Update Code
							
							}
						}else{						
							// Delete Code
						}
					}
				
				}
				return $saveId;
	}
	
	function getCallRegiUserid($serverId,$agent=false){
		$results=array();
		$agents=array();
		 		 $sql="Select * FROM `c_callUsers` WHERE `server_id`='$serverId'";		 
				 $empdata=$this->get_results($this->prepare($sql));				
				 if(!empty($empdata)){				 
					 foreach($empdata as $val){	
					 				 
						 $results[]=$val->user_id;
						 $agents[]=$val->agent_id;
					 }
				 }
				 if(empty($agent))
				 return $results;
				 else 
				 return $agents;
				 
	
	}
	function getCallRegisData($serverId,$type='_OBJ')
	{
	$results=array();
	  $sql="Select * FROM `c_callUsers` WHERE `server_id`='$serverId'";		 
		$results=$this->get_results($this->prepare($sql));	
		if($type=='_ARRAY')
			return (array) $results;
		else
		return $results;
	}
	
	function getCallUserDetail($serverId,$user_id,$usertype='employee',$type='_OBJ'){
	$results=array();
	    $sql="Select * FROM `c_callUsers` WHERE `server_id`='$serverId' AND user_id='$user_id' AND type='$usertype' and is_site='Yes'";		 
		$results=$this->get_results($this->prepare($sql));	
		if($type=='_ARRAY')
			return (array) $results;
		else
		return $results;
	
	}
	function api($url,$params=array()){
		
		
		  $postData = ''; 
		  if(empty($this->server_id)) 
		 	 return  false;
		  $base='https://'.$this->server_id.'/webservice/';
			  $results=array();
			  $url=$base.$url;	
			  
			  if($_GET['test']=="test"){
			  echo $url;die('2153g');
			  
			  }
			  
		   	 
	  
		   foreach($params as $k => $v) 
		   { 
		      $postData .= $k . '='.$v.'&'; 
		   }
		   rtrim($postData, '&');		
			$ch = curl_init();
			if(!empty($postData)){
			    //echo $postData;die;
			}
			curl_setopt($ch, CURLOPT_URL,$url);
			
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			
			
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			
			$results = json_decode($server_output);			
			return $results;
	
	}
	
	function getServerUrl($server_id){	
   
		$sql="Select * from erp.call_server WHERE id = '$server_id'";
		$results =$this->get_results($this->prepare($sql));	
		return $results;
	
	}
	
	function deleteCallEmployee($agent_id,$user_id,$server_id){		
		$this->delete('c_callUsers',array('user_id'=>$user_id,'agent_id'=>$agent_id,'server_id'=>$server_id));
	}
	
	function GetcallSetting(){
		$sql="Select * FROM c_call_setting";		 
		$results =$this->get_results($this->prepare($sql));	
		return $results;
	}
	
	function CreateGroup($name,$serverid){
		$responce=array();
		$parm = "acl_group.php?action=groupadd&group=".$name."&description=".$name;
		
		try{
	     $data  = $this->api($parm);
		 if($data->error){
		 	 $responce['error'] = '<div class="error">'.$data->error.'</div>';
			  return $responce;
		 }
		 $setting['server_id'] = $serverid;
		 $setting['group_id'] = $data->id;
		 $setting['group_name'] = $name;
		 $this->insert('c_call_setting',$setting);
		 $responce['success']='<div class="success">Group added successfully.</div>';
		  return $responce;
		}catch(Exception $e) {
			$responce['error']='<div class="error">Something went wrong. Please try to letter.</div>';
		 return $responce;
		 return $mag;
	     }
	}

	
	function getEmpQuota($server_id,$empid,$status='active' , $type='_OBJ'){
	$where=' 1 ';	
	if(!empty($server_id))
		$where .=" AND server_id='$server_id'";
	if(!empty($empid))
		$where .=" AND user_id='$empid'";
	if(!empty($empid))
		$where .=" AND status='$status'";
	$sql="Select* From c_callquota WHERE $where";
	$results=$this->get_results($this->prepare($sql));	
		if($type=='_ARRAY')
			return (array) $results;
		else
		return $results;
	}
	
	function SaveEmpQuota($data){
		$this->insert('c_callquota',$data);	
	}
	
	function updateEmpQuota($data,$where){
		$this->update('c_callquota',$data,$where);	
	
	}
	
	function DeleteGroup($group_id){
		
		$parm = "acl_group.php?action=groupdelete&group_id=".$group_id;
		
		try{
	     $data  = $this->api($parm);
		 $this->delete('c_call_setting',array('group_id'=>$group_id));
		 //$this->insert('c_call_setting',$setting);
		 return '<div class="success">Group delete successfully.</div>';
		}catch(Exception $e) {
		  return '<div class="error">Something went wrong. Please try to letter.</div>';
		 return $mag;
	     }
		
	}
	
	# list server 
	function ListServer($condi=array()){
		$where=' WHERE 1 ';
		foreach($condi as $k=>$cond){
		$where .=' AND '.$k.' = "'.$cond.'"';		
		}
		
	 $sql="Select * FROM call_server $where";		 
		$results =$this->get_results($this->prepare($sql));	
		
		return $results;	
	}
	# delete server 
	function DeleteServer($delID){
		$this->delete('call_server',array('id'=>$delID));
		
	}
	
	function GetEmployeeListByIds($arryDetails,$ids=array(),$serverid='')
		{
			global $Config;
		   
			extract($arryDetails);
			$SearchKey   = strtolower(trim($key));

			$strSQLQuery = "select e.EmpID,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_employee e left outer join h_department d on e.Department=d.depID where 1 ";

			$strSQLQuery .= (!empty($EmpID))?(" and e.EmpID='".$EmpID."'"):(" and e.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= ($Status>0)?(" and e.Status='".$Status."'"):("");
			$strSQLQuery .= (!empty($Department))?(" and e.Department='".$Department."'"):("");
			$strSQLQuery .= (!empty($Division))?(" and e.Division in (".$Division.")"):("");
			$strSQLQuery .= (!empty($JobType))?(" and e.JobType='".$JobType."'"):("");
			$strSQLQuery .= (!empty($FixedLeave))?(" and e.LeaveAccrual!='1'"):("");
			if($Config['AllCallUser']==1){
				$strSQLQuery .= (!empty($ids))?(" and e.EmpID IN (".implode(',',$ids).")"):("");	
			}else{
				$strSQLQuery .= (!empty($ids))?(" and e.EmpID = '".$_SESSION['AdminID']."'"):("");
			}
			
			
			
			
			$strSQLQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpCode like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%') " ):("");			
			$strSQLQuery .= " Order by e.UserName Asc";
			 	
			return $this->query($strSQLQuery, 1);
		}
		
		
	   function ConnectUserDetail($arryDetails,$ids=array(),$serverid)
		 {
			extract($arryDetails);
			$SearchKey   = strtolower(trim($key));

			$strSQLQuery = "select  cu.id,cu.user_id,cu.agent_id,cu.type,cu.is_site,e.EmpID,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_employee e left outer join h_department d on e.Department=d.depID Right JOIN c_callUsers as cu ON (e.EmpID=cu.user_id AND cu.server_id=$serverid) where 1 ";

			//$strSQLQuery .= (!empty($EmpID))?(" and e.EmpID='".$EmpID."'"):(" and e.locationID=".$_SESSION['locationID']);
			//$strSQLQuery .= ($Status>0)?(" and e.Status='".$Status."'"):("");
			$strSQLQuery .= (!empty($Department))?(" and e.Department='".$Department."'"):("");
			$strSQLQuery .= (!empty($Division))?(" and e.Division in (".$Division.")"):("");
			$strSQLQuery .= (!empty($JobType))?(" and e.JobType='".$JobType."'"):("");
			$strSQLQuery .= (!empty($FixedLeave))?(" and e.LeaveAccrual!='1'"):("");
			$strSQLQuery .= (!empty($ids))?(" and e.EmpID IN (".implode(',',$ids).")"):("");
			$strSQLQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpCode like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%') " ):("");			
			$strSQLQuery .= " Order by e.UserName Asc";	
		
		    
			return $this->query($strSQLQuery, 1);
		}
		
		
		function ListLeadbyphone($id = 0, $SearchKey='', $SortBy='', $AscDesc='', $limit='') {
			
        global $Config;
        $strAddQuery = 'where 1';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" and l.leadID='" . $id . "'") : (" and l.Opportunity=0 ");


        #$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (l.AssignTo='" . $_SESSION['AdminID'] . "' OR l.created_id='" . $_SESSION['AdminID'] . "')") : ("");

	   $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",l.AssignTo) OR l.created_id='" . $_SESSION['AdminID'] . "') ") : ("");

       $strAddQuery .= (!empty($SearchKey)) ? (" and ( l.LandlineNumber = '" . $SearchKey . "'  or l.Mobile = '" . $SearchKey . "'
	      ) " ) : ("");
            
        
        $strAddQuery .= "group by l.leadID";
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by l.leadID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : ("desc");

        $strSQLQuery = "select l.leadID as ID, l.LeadName as Name,l.primary_email as Email , l.Mobile as Mobile, l.LandlineNumber as LandlineNumber, d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role from c_lead l left outer join  h_employee e on FIND_IN_SET(e.EmpID,l.AssignTo)  left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID " . $strAddQuery;
		
		return $this->query($strSQLQuery, 1);
       }
	   
	   function ListOpportunitybyphone($id = 0, $SearchKey='', $SortBy='', $AscDesc='', $limit=''){
		   
		global $Config;
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where o.OpportunityID='" . $id . "'") : (" where 1 ");
      

        $strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",o.AssignTo) OR o.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
        
		 $strAddQuery .= (!empty($SearchKey)) ? (" and ( l.LandlineNumber = '" . $SearchKey . "'  or l.Mobile = '" . $SearchKey . "'
	      ) " ) : ("");
		
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by o.OpportunityID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" desc");

        $strSQLQuery = "select o.OpportunityID as ID, l.LeadName as Name,l.primary_email as Email , l.Mobile as Mobile, l.LandlineNumber as LandlineNumber , o.OpportunityID,o.created_id,o.LeadID,o.Status,o.OpportunityName,o.lead_source,o.AddedDate,o.CloseDate,o.SalesStage,o.AssignTo ,o.description,o.AssignType,o.GroupID,e.EmpID,d.Department,e.Role,e.UserName  from c_opportunity o left outer join  h_employee e on e.EmpID=o.AssignTo left outer join  h_department d on e.Department=d.depID
          left outer join  c_lead l on l.leadID=o.leadID " . $strAddQuery;
		  
		  
		
		return $this->query($strSQLQuery, 1);   
		   
	   }
		
	   function ListCustomerbyphone($id = 0, $SearchKey='', $SortBy='', $AscDesc='', $limit='') {	
	   
				global $Config;
				$strAddQuery = 'where 1';
				$SearchKey   = strtolower(trim($SearchKey));
				$strAddQuery .= ($Status>0)?(" and c1.Status=".$Status.""):("");
			    $strAddQuery .= (!empty($id)) ? (" and c1.Cid=" . $id . "") : ("  ");

				//$strAddQuery .= (" and (c1.AdminType='".$_SESSION['AdminType']."' and c1.AdminID='".$_SESSION['AdminID']."') "); 
				//$strAddQuery .= (" and (c1.AdminID='".$_SESSION['AdminID']."') "); 

				$strAddQuery .= (!empty($SearchKey)) ? (" and ( c1.Landline = '" . $SearchKey . "'  or c1.Mobile = '" . $SearchKey . "'
	      ) " ) : ("");
				
				
				//$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.FullName ");
				//$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");


				$SqlCustomer = "select c1.Cid as ID, c1.FullName as Name, c1.Email as Email , c1.Mobile as Mobile, c1.Landline as LandlineNumber ,ab.CountryName ,ab.StateName from s_customers c1 left outer join s_address_book ab ON (c1.Cid = ab.CustID and ab.AddType = 'contact' and ab.PrimaryContact='1') ".$strAddQuery;
				
				
				
				return $this->query($SqlCustomer, 1);  
	
	    }
	
		function ListContactbyphone($id = 0, $SearchKey='', $SortBy='', $AscDesc='', $limit='') {
				global $Config;
				extract($arryDetails);
				$strAddQuery = '';
				$SearchKey   = strtolower(trim($SearchKey));

				$SortBy = $sortby;
				$strAddQuery .= (!empty($id))?(" where c.AddID=".$id):(" where c.CrmContact=1 and c.AddType='contact' ");

				//$strAddQuery .= (" and (c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."') ");
				
				$strAddQuery .= (!empty($SearchKey)) ? (" and ( c.Landline = '" . $SearchKey . "'  or c.Mobile = '" . $SearchKey . "'
	      ) " ) : ("");

				
				
				$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.FirstName ");
				$strAddQuery .= (!empty($AscDesc))?($asc):(" Asc");

				$strSQLQuery = "select c.AddID as ID, c.FullName as Name, c.Email as Email , c.Mobile as Mobile, c.Landline as LandlineNumber ,e.EmpID,e.UserName as AssignTo,cus.FullName as CustomerName, cus.CustCode   from s_address_book c left outer join  h_employee e on e.EmpID=c.AssignTo left outer join s_customers cus ON cus.Cid = c.CustID  ".$strAddQuery;

				//echo $strSQLQuery;die;
				
               return $this->query($strSQLQuery, 1);          

		}	


		# list country 
		function ListCountryCode($condi=array(), $type=""){
			
		$where=' WHERE 1 ';
		foreach($condi as $k=>$cond){
			if($type=="search"){
		      $where .=' AND '.$k.'  LIKE  "'.$cond.'%"';	
            }else{
			  $where .=' AND '.$k.'  =  "'.$cond.'"';			
			}		
		}

		$sql="Select * FROM country $where  order by name ASC ";	
	
		$results =$this->get_results($sql);	

		return $results;	
		}
		
		# get country code by company id 
		function CountryCodebyCompanyId($condi=array(), $type=''){
			$where=' WHERE 1 '; 
			if(is_array($condi)){ //added by chetan on 24jan2017//
				foreach($condi as $k=>$cond){
				$where .=' AND '.$k.' = "'.$cond.'"';		
				}
			}
			$sql="Select c.country_id, c.name, c.isd_code,c.isd_prefix FROM country as c inner join call_country_code as code on c.country_id = code.country_id $where  order by name ASC ";
			$results =$this->get_results($this->prepare($sql));	
			if($type=='') {
			    $data =  array();
				foreach($results as $val){
					$data[] = $val->country_id;
					
				}
			    return $data; 
		    }else{
				return $results;
			}
				
		}
		
		# get comment by  user id 
		function GetCommentByID($userID, $type , $fromDate="",  $todate=""){
			
			
			if(!empty($fromDate) && !empty($todate)){
				$cond = " and Date(CommentDate) >= '".date('Y-m-d', strtotime($fromDate))."'  and Date(CommentDate) <= '".date('Y-m-d', strtotime($todate))."'";
			}
			
			
			$sql = "select * from c_comments where commented_id = $userID and parent_type = '".$type."'";
			if($cond){
				$sql .= $cond;
			}
			
			
			
			$results =$this->get_results($this->prepare($sql));	
			return $results;
		}
		
		# get country code by user id 
		function CountryCodebyEmp($EmpID){
			$sql = "select phone_country_id from h_employee where EmpID = $EmpID";
			$results = $this->get_results($sql);
			return (!empty($results)) ? $results[0]->phone_country_id : false; //by chetan on 24Jan2017//
			
		}
		
		# get country code by company id 
		function CountryCodePrxbyEmp($EmpID){
	        $db = 'erp_'.$_SESSION['DisplayName'];
			$sql="Select c.country_id, c.name, c.isd_code,c.isd_prefix FROM erp.country as c 
			          inner join $db.h_employee as emp on c.country_id = emp.phone_country_id  
					  where emp.EmpID = $EmpID order by name ASC ";		 
			
			$results =$this->get_results($sql);	
			return $results;	
		}
		
		
		#get all extension of employee
		function getEmpExtenstion($EmpID, $userType = 'employee'){
			
			$sql="Select agent_id FROM c_callUsers 
					  where user_id = $EmpID  and type = '".$userType."'";		 
			
			$results =$this->get_results($sql);	
			return $results;	
		}
			
		
}

?>
