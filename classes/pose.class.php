<?php 

class pose extends dbFunction
{
		//constructor
		//var $tables;
		//public $server_id;
		function pose()
		{
			global $configTables,$Config;		
			//$this->tables=$configTables;
			$this->dbClass();
		} 

	
	
	
	function getServerUrl($server_id){	
   
		$sql="Select * from erp.call_server WHERE id = '$server_id'";
		$results =$this->get_results($this->prepare($sql));	
		return $results;
	
	}
	
	
	function SaveEmpQuota($data){
		$this->insert('c_callquota',$data);	
	}
	
	function updateEmpQuota($data,$where){
		$this->update('c_callquota',$data,$where);	
	
	}
		
	 function  getPlans($PlanId='')
	{

		$sql = "select ppp.* from erp.pos_plan_package ppp
		left join erp.pos_plan_package_element pppe on pppe.package_id=ppp.pckg_id
		where ppp.status ='1' ";
		if($PlanId!='')
		$sql .= " and ppp.pckg_id='".addslashes($PlanId)."'";

		$sql .= " group by  ppp.pckg_id";
 
		return $this->query($sql, 1);

	}		
	function  getplanelements($PlanId)	{

		$sql = "select * from erp.pos_plan_package_element where package_id= '".addslashes($PlanId)."' ";

		return $this->query($sql, 1);

	}


function addposUser($arryCompany,$plan_id,$objConfig){
	
	/********************/
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],12)==1){
		//echo 'ok';
	}else{
		return true;
	}

	$sql="Select comId from erp.company_user_pos WHERE comId = '".$arryCompany[0]['CmpID']."'";
	$results =$this->get_results($this->prepare($sql));	
	if(!empty($results[0]->comId)){
		return true;
	}    
	/********************/


                      $planData=$this->getPlans($plan_id);
								
							
								$planData[0]['elements']=$this->getplanelements($plan_id);
								
								
								 
							     $FirstName  =  $arryCompany[0]['CompanyName'];
							     $DisplayName  =  $arryCompany[0]['DisplayName'];
							     $Email  =  $arryCompany[0]['Email'];
							     $Password  =  $arryCompany[0]['Password'];
							     $city_id  =  $arryCompany[0]['city_id'];
							     $state_id  =  $arryCompany[0]['state_id'];
							     $ZipCode  =  $arryCompany[0]['ZipCode'];
							     $country_id  =  $arryCompany[0]['country_id'];
							     $Mobile  =  $arryCompany[0]['Mobile'];
							     $OtherCity  =  $arryCompany[0]['OtherCity'];
								 
								$data['customers']['FirstName'] = $FirstName;
								//$data['customers']['LastName'] = $LastName;
								$data['customers']['GroupID'] ='1';
								$data['customers']['Login'] ='Registered';
								$data['customers']['Password'] = $Password;
								$data['customers']['Company'] = $DisplayName;
								$data['customers']['Address1'] =  $OtherCity;
								//$data['customers']['Address2'] = $Address2;
								$data['customers']['City'] = $city_id ;
								$data['customers']['State'] = $state_id;
								$data['customers']['Country'] = $country_id;
								$data['customers']['Email'] = $Email;
								$data['customers']['Phone'] = $Mobile;
								$data['customers']['Status'] = 'Yes';
								$data['customers']['custType'] = 'vendorpos';
								$data['customers']['CreatedDate'] = date('Y-m-d h:i:s');
								
								$DbName2 = "erp"."_".$DisplayName;	
								$objConfig->dbName = $DbName2;
								$objConfig->connect();
								
	
								$this->insert('e_customers',  $data['customers']);
				                
							 $ref_id  = $this->lastInsertId();
 
							 	
								
								// start add user permission 
				
								$permissionData1['module_id']   = 1;
								$permissionData1['user_id']   = $ref_id;
								
								$permissionData2['module_id']   = 2;
								$permissionData2['user_id']   = $ref_id;
								
								$permissionData3['module_id']   = 3;
								$permissionData3['user_id']   = $ref_id;
								
								$permissionData4['module_id']   = 4;
								$permissionData4['user_id']   = $ref_id;
								
								$permissionData5['module_id']   = 5;
								$permissionData5['user_id']   = $ref_id;
								
								$permissionData6['module_id']   = 6;
								$permissionData6['user_id']   = $ref_id;
								
								
								
								$permissionData8['module_id']   = 30;
								$permissionData8['user_id']   = $ref_id;

								$this->insert('pos_module_user',  $permissionData1);
								$this->insert('pos_module_user',  $permissionData2);
								$this->insert('pos_module_user',  $permissionData3);
								$this->insert('pos_module_user',  $permissionData4);
								$this->insert('pos_module_user',  $permissionData5);
								$this->insert('pos_module_user',  $permissionData6);
								//$db->insert('pos_module_user',  $permissionData7);
								$this->insert('pos_module_user',  $permissionData8);
				
				             // end user permission 
								
								$data['dealer_subscription']['payment_status'] = 'Completed';
								$data['dealer_subscription']['txnId'] ="";
								$data['dealer_subscription']['subscr_id'] = "";
								$data['dealer_subscription']['vendor_id'] = $ref_id;
								$data['dealer_subscription']['plan_id'] = $plan_id;
								$data['dealer_subscription']['plandata'] = serialize($planData[0]);
								$data['dealer_subscription']['amount'] = 0;
								$data['dealer_subscription']['paymentDate'] = date('Y-m-d h:i:s');
								$data['dealer_subscription']['is_active'] = '1';
								$data['dealer_subscription']['renewDate'] =date('Y-m-d h:i:s', strtotime("+30 days"));
								$data['dealer_subscription']['expireDate'] =date('Y-m-d h:i:s', strtotime("+30 days"));
								$data['dealer_subscription']['currency_code'] = 'USD';
								$this->insert('pos_dealer_subscription',  $data['dealer_subscription']);
							 
								$data['user']['fname'] = $FirstName; 
								//$data['user']['lname'] = $_POST['inputLastName']; 
								$data['user']['user_name'] = $Email; 
								$data['user']['password'] = $Password; 
								$data['user']['address1'] = $OtherCity; 
                                $data['user']['status'] = '1';
								

								$data['user']['country'] = $country_id; 
								$data['user']['state'] = $state_id;
								$data['user']['city'] = $city_id;
								$data['user']['user_type'] = "vendorpos"; 
								$data['user']['ref_id'] =  $ref_id;
								$data['user']['comId'] =  $arryCompany[0]['CmpID']; 
								$data['user']['isvendor_admin'] =  'Yes'; 

								$objConfig->dbName = "erp";
								$objConfig->connect();
								$this->insert('company_user_pos',  $data['user']);

}	
		
}

?>
