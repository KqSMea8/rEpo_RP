<?php
class hostbill extends dbClass
{
public $url='http://199.227.27.208/hostbillapi/';
public $api_url='';
public $api_key='';
public $api_id='';
public $customapi_url='http://www.virtualstacks.com/vsvpc/admin/customapi.php';
function __construct($data=array()){

	$hostbillsetting=$this->GetTempHostbillSetting();	
		$this->api_url=$hostbillsetting['api_url'];
		$this->api_key=$hostbillsetting['api_key'];
		$this->api_id=$hostbillsetting['api_id'];	
		if(!empty($this->api_url) AND !empty($this->api_key) AND !empty($this->api_id) ){
			HBWrapper::setAPI($this->api_url,$this->api_id,$this->api_key,0);
		}else{
			if(empty($data)){
				echo 'Host Bill Not Active';
				//die('Host Bill Not Active');
				exit;
			}
		}
	

}

/**
 * isActiveHostbill
 *
 * Check Hostbill active or not
 *
 * @param  No
 * @return (boolen)
 */

function isActiveHostbill(){
	$sql="SELECT Status FROM `admin_modules` WHERE `Module` ='Hostbill Setting'"; 
 	$res = $this->query($sql, 1);
 
	 if(!empty($res[0]['Status']) AND  $res[0]['Status']==1){
		 return true;
	 }else{
	
		 return false;
	 }
}

 /**
 * GetTempHostbillPayment
 *
 * 
 *
 * @param  boolen $full  Get data from s_hostbill_payment if full is true then it return all data else return ref_id
 * @return array  $data
 */

function GetTempHostbillPayment($full=false){
$results=array();
$sql="Select * FROM s_hostbill_payment";
  $data= $this->query($sql, 1);
  if(!empty($data)){
	  foreach($data as  $value){
	 	 $results[]=$value['ref_id'];
	  }
  }
  if($full==false){
  return $results;
  }else if($full==true){
  return $data;
  }

}




function updateInvoiceFee(){
ini_set('display_errors',1);
  $sql="select s_hostbill_payment.fee, s_hostbill_payment.invoice_id, s_order.OrderID, s_order.InvoiceID from s_order
  INNER JOIN s_hostbill_payment  ON 
  (s_order.CustomerPO = s_hostbill_payment.invoice_id AND s_order.OrderSource='hostbill' 
  AND s_order.Module='Invoice') WHERE (s_order.Fee='' OR s_order.Fee=0.00) and s_hostbill_payment.fee>0";
 $data= $this->query($sql, 1);

 if(!empty($data)){
	$objReport = new report();
 	foreach($data as $value){
	 	$sql="Update s_order SET Fee ='".$value['fee']."' WHERE OrderID='".$value['OrderID']."'";
	 	$data= $this->query($sql, 0);

		/*****************************/
		/******Create Journal Entry If Fee updated later******/
		$InvoiceID = trim($value['InvoiceID']);
		$strSQL = "select ReferenceID from f_gerenal_journal where ReferenceID = '" .$InvoiceID."' ";
		$arryJor = $this->query($strSQL, 1);
		if(empty($arryJor[0]['ReferenceID'])){
			$strSQLQuery = "SELECT s.* from s_order s where s.InvoiceID = '".$InvoiceID."' and s.Module='Invoice' and s.OrderSource='hostbill' and s.PostToGL = '1' ";
			$arryRow = $this->query($strSQLQuery, 1);
			if($arryRow[0]['Fee']>0){				
				if(empty($arryRow[0]['ConversionRate'])) $arryRow[0]['ConversionRate']=1;
				
				$objReport->CreateGeneralEntryDirect($arryRow);
			}
		}
		/*****************************/
		/*****************************/
 	}
 
 }
}



 
 	
	 
 



/*******Product**************/

 /**
 * GetTempHostbillProduct
 *
 * 
 *
 * @param  boolen $full  Get data from s_hostbill_product_temp if full is true then it return all data else return ref_id
 * @return array  $data
 */

function GetTempHostbillProduct($full=false){
	$results=array();
	$sql="Select * FROM s_hostbill_product_temp";
	  $data= $this->query($sql, 1);
	  if(!empty($data)){
		  foreach($data as  $value){
		 	 $results[]=$value['ref_id'];
		  }
	  }
	  if($full==false){
	  return $results;
	  }else if($full==true){
	  return $data;
	  }

}


 /**
 * ImportCustomerTmp 
 * Get data from s_hostbill_product_temp if full is true then it return all data else return ref_id
 *
 * 
 *
 *  
 * @return boolen 
 */

function ImportCustomerTmp(){
			$customersrefid=$this->GetTempHostbillCustomer();	 	
	 		$page=$this->GetTempHostbillSetting('customer_temp_import');
	 		$cpage=(!empty($page) AND !is_array($page))?$page:0;	 		
	 		$customers=$this->importclinetTmp($cpage);
	 		$ss=$customers['sorter']['totalpages']-$cpage;
  			$updatepage=$cpage;
			 
			for($i=$ss; $i>=0; $i--)
			 	{		 	
			 		
			 		$customers=$this->importclinetTmp($i);			 	
					if(!empty($customers['clients'])){
					foreach ($customers['clients'] as $clients){

					if(in_array($clients['id'],$customersrefid)){
							continue;					
					}
						$data=array();
				 		$data['firstname']=$clients['firstname'];
				 		$data['lastname']=$clients['lastname'];
				 		$data['datecreated']=$clients['datecreated'];
				 		$data['email']=$clients['email'];
				 		$data['companyname']=$clients['companyname'];
				 		$data['services']=$clients['services'];
				 		$data['hostbill_userid']=$clients['id'];
				 		
				 		
				 		$this->insert('s_hostbill_customer_tmp',$data);
					}
					
					}
					
				
			 		$this->update('s_hostbill_setting',array('meta_value'=>$updatepage),array('meta_key'=>'customer_temp_import'));
			 			$updatepage++;
			 	}
			 
}
	
/**
 * importAccountTmp 
 * Get data from s_hostbill_product_temp if full is true then it return all data else return ref_id
 *
 * 
 *
 *  
 * @return boolen
 */

function importAccountTmp(){

			$accountefid=$this->GetTempHostbillAccount();	 	
	 		
	 		$page=$this->GetTempHostbillSetting('account_temp_import');
	 		
	 		$cpage=(!empty($page) AND !is_array($page))?$page:0;
	 		
	 		$account=$this->getAccountlist($cpage);
	 		
			for($i=($account['sorter']['totalpages']-1); $i>=$cpage; $i--)
			 	{		 	
			 		$account=$this->getAccountlist($i);
					if(!empty($account['accounts'])){
					foreach ($account['accounts'] as $accou){
							if(in_array($accou['id'],$accountefid)){
									continue;					
							}
							$itemdetail=array();
						$itemdetail=	$this->getItemDetail($accou['id']);
						$data=array();
				 		$data['manual']=$accou['manual'];
				 		$data['domain']=$accou['domain'];
				 		$data['billingcycle']=$accou['billingcycle'];
				 		$data['status']=$accou['status'];
				 		$data['total']=$accou['total'];
				 		$data['next_due']=$accou['next_due'];
				 		$data['name']=$accou['name'];				
				 		$data['type']=$accou['type'];				
				 		$data['lastname']=$accou['lastname'];				
				 		$data['firstname']=$accou['firstname'];				
				 		$data['client_id']=$accou['client_id'];				
				 		$data['currency_id']=$accou['currency_id'];	
				 		$data['paytype']=$accou['paytype'];		
				 		$data['account_id']=$accou['id'];			
				 		$data['product_id']=$itemdetail['details']['product_id'];			
				 		$data['product_name']=$itemdetail['details']['product_name'];		 		
				 		$this->insert('s_hostbill_Account_tmp',$data);
				 		$accountefid[]=$accou['id'];
					}
					
					}
			 		
			 	}
				$this->update('s_hostbill_setting',array('meta_value'=>$customers['sorter']['totalpages']),array('meta_key'=>'account_temp_import'));
	 			

}

/**
 * getHostbillsalesCustomer 
 * get Hostbill Sales Customer from s_customers
 
 *  
 * @return array $data
 */

function getHostbillsalesCustomer(){

	$sql="Select sc.* ,Ship_sAd.FullName as ship_FullName,Ship_sAd.Address as ship_Address,Ship_sAd.Company as ship_Company,
	Ship_sAd.Mobile as ship_Mobile,Ship_sAd.Landline as ship_Landline,
	Ship_sAd.Email as ship_Email,Ship_sAd.Email as ship_Email,Ship_sAd.CountryName as ship_Country,Ship_sAd.StateName as ship_State,Ship_sAd.CityName as ship_City,Ship_sAd.ZipCode as ship_zip,
	Bill_bAd.FullName as bill_FullName,Bill_bAd.Address as bill_Address,Bill_bAd.Company as bill_Company,
	Bill_bAd.Mobile as bill_Mobile,Bill_bAd.Landline as bill_Landline,
	Bill_bAd.Email as bill_Email,Bill_bAd.Email as bill_Email
	,Bill_bAd.CountryName as bill_Country,Bill_bAd.StateName as bill_State,Bill_bAd.CityName as bill_City,Bill_bAd.ZipCode as bill_zip
	
	FROM s_customers as sc LEFT JOIN s_address_book Ship_sAd ON (Ship_sAd.CustID = sc.Cid AND Ship_sAd.AddType='shipping' AND Ship_sAd.PrimaryContact=1)
	LEFT JOIN s_address_book Bill_bAd ON (Bill_bAd.CustID = sc.Cid AND Bill_bAd.AddType='shipping' AND Bill_bAd.PrimaryContact=1 )
	where sc.RigisterType ='hostbill'  ORDER BY `sc`.`Cid` ASC ";
	return  $res = $this->query($sql, 1);
}

/**
 * getHostbillsalesOrder 
 * get Hostbill Sales Customer from s_customers
 * @param String $type  Invoice or Order
 * @return array $data
 */
function getHostbillsalesOrder($type='Order'){
	$sql="Select * FROM s_order where OrderSource='hostbill' AND Module='$type'";
	return  $res = $this->query($sql, 1);
 
}

/**
 * getinventoryHostbillitems 
 * get Hostbill Sales Customer from s_customers
 * @param no
 * @return array $data
 */
 function getinventoryHostbillitems(){
    
    $sql="Select ItemID,Sku,description,product_source, ref_id,sell_price FROM inv_items where product_source='hostbill'";
	return  $res = $this->query($sql, 1);
    }

    
 /**
 * insert 
 * Save data 
 * @param String $table Table name
 * @param array $data key value data
 * @return int $lastinsertid Last Inserted Id
 */
function insert($table,$data){

 	  $fields = join(',',array_keys($data));
      $values = join("','",array_values($data));
      $strSQLQuery = "insert into $table ($fields)  values('" .$values."')"; 
      $this->query($strSQLQuery, 0);
     return  $this->lastInsertId();
}

/**
 * update 
 * update data 
 * @param String $table Table name
 * @param array $data key value data
 * @param array $where key value Where
 * @return int $lastinsertid Last Inserted Id
 */

function update($table,$data, $where){
 $s='';
 $w='';
 	 if(!empty($data)){
 	 $s .=" Set ";
 	 $i=0;
 	 foreach($data as $k=>$val){
 	 
 	 		if($i==0){
 	 		 $s .=" $k = '$val'";
 	 		}else{
 			 $s .=" , $k = '$val'";
 	 		}
 			 
 			 $i++;
 	 }
 	 }
 	if(!empty($where)){
 	 foreach($where as $k=>$val){
 			 $w .=" AND  $k = '$val'";
 	 }
 	 }
      $strSQLQuery = "Update  $table $s WHERE 1 $w "; 
   
      $this->query($strSQLQuery, 0);
   
}


/**
 * saveItems 
 * Save Item 
 * @param id $ref_id Ref id
 * @param array $pdata key value data
 * @return int $lastinsertid Last Inserted Id
 */
function saveItems($ref_id,$pdata){

		$data=array();
		$data['description']=$pdata['description'];
		$data['procurement_method']='SALE';
		$data['CategoryID']=0;
		$data['evaluationType']='';
		$data['itemType']='';
		$data['non_inventory']='yes';
		$data['UnitMeasure']='';
		$data['min_stock_alert_level']='';
		$data['max_stock_alert_level']='';
		$data['purchase_tax_rate']='';
		$data['sale_tax_rate']='';
		$data['Status']=1;
		$data['AddedDate']=date('Y-m-d H:i:s');
		//$data['Sku']='host'.rand(1111,9999).rand(1111,9999);
		$data['Sku']=!empty($pdata['Sku'])?$pdata['Sku']:'host'.rand(1111,9999).rand(1111,9999); 
		$data['item_alias']='';
		$data['sell_price']=$pdata['amount'];
		$data['qty_on_hand']='';
		$data['long_description']='';
		$data['Model']='';
		$data['Generation']='';		
		$data['Extended']='';
		$data['Manufacture']='';
		$data['ReorderLevel']='';
		$data['is_exclusive']='';
		$data['Reorderlabelbox']='';
		$data['product_source']='hostbill';
		$data['ref_id']=$ref_id;
		
				
			  $fields = join(',',array_keys($data));
		      $values = join("','",array_values($data));
		      
		     $strSQLQuery = "insert into inv_items ($fields)  values('" .$values."')"; 
		     
		      $this->query($strSQLQuery, 0);
				 $data['ItemID'] = $this->lastInsertId();
				 return $data;

}

function GetTempHostbillCustomer($full=false){
$results=array();
$sql="Select * FROM s_hostbill_customer_tmp";
  $data= $this->query($sql, 1);
  if(!empty($data)){
	  foreach($data as  $value){
	  $results[]=$value['hostbill_userid'];
	  }
  }
  if($full==false){
  return $results;
  }else if($full==true){
  return $data;
  }

}

function GetTempHostbillAccount($full=false){
$results=array();
$sql="Select * FROM s_hostbill_Account_tmp";
  $data= $this->query($sql, 1);
  if(!empty($data)){
	  foreach($data as  $value){
	 	 $results[]=$value['account_id'];
	  }
  }
  if($full==false){
  return $results;
  }else if($full==true){
  return $data;
  }

}

function GetTempHostbillSetting($key=''){
$results=array();
$w='';
$res='';
$sql="Select meta_value,meta_key FROM s_hostbill_setting WHERE 1 ";
  $data= $this->query($sql, 1);
 
  if(!empty($data)){
	  foreach($data as  $value){
	  $results[$value['meta_key']]=$value['meta_value'];
	  }
  }
  if(!empty($key)){
  return ( array_key_exists($key,$results))?$results[$key]:'';
  }else{
  return $results;
  }
}


function GetProductFromTempAccount($full=false){
$results=array();
$w='';
$res='';
$sql="SELECT * FROM `s_hostbill_Account_tmp` GROUP by `product_id` ";
  $data= $this->query($sql, 1);
 
  if(!empty($data)){
	  foreach($data as  $value){
	  $results[$value['product_id']]=$value['product_name'];
	  }
  }
  if($full==false){
 		return $results;
  }else{
  return $data;
  }
}

function addHostbillcustomer($client_id){
	$IPAddress = GetIPAddress();

$data=$this->hostbillcurl(array('task'=>'getCustomerdetail','client_id'=>$client_id));
   $return = json_decode($data, true);
	if($return){
	$return=$return['client'];
	  		$FullName=$return['firstname'].' '.$return['lastname'];
			$clientdata['CustomerType'] = 'Individual';
			$clientdata['Company'] = !empty($return['companyname'])?mysql_real_escape_string(strip_tags($return['companyname'])):$FullName ;
			$clientdata['FirstName']=mysql_real_escape_string(strip_tags($return['firstname'])) ;
			$clientdata['LastName'] =mysql_real_escape_string(strip_tags($return['lastname']));
			$clientdata['FullName'] = mysql_real_escape_string(strip_tags($FullName)) ;
			$clientdata['Gender'] = 'Male';			 
			$clientdata['Mobile'] = mysql_real_escape_string(strip_tags($return['phonenumber']));
			$clientdata['Email'] = mysql_real_escape_string(strip_tags($return['email'])) ;
			$clientdata['CreatedDate'] =mysql_real_escape_string($return['datecreated']);
			//$clientdata['ipaddress'] =mysql_real_escape_string($return['ip']);
			$clientdata['ipaddress']=!empty($return['ip'])?$return['ip']:$IPAddress;

			$clientdata['Status']='Yes';
			$clientdata['RigisterType']='hostbill';
			$clientdata['RigisterTypeID']=$client_id;
			
	  $fields = join(',',array_keys($clientdata));
      $values = join("','",array_values($clientdata));
      
      $strSQLQuery = "insert into s_customers ($fields)  values('" .$values."')"; 
      $this->query($strSQLQuery, 0);
		 $customerId = $this->lastInsertId();

            $CustCode = 'CUST00' . $customerId;

            $sql = "update s_customers set CustCode = '" . mysql_real_escape_string($CustCode) . "'
			 where Cid='" . addslashes($customerId) . "'";
            $this->query($sql, 0);	
          $return['Cid']=$customerId;
          $return['type']='shipping';
          $billingaddress= $this->SaveCustomerAddress($return);
          $return['type']='billing';
          $billingaddress= $this->SaveCustomerAddress($return);
            
            
            $clientdata['CustCode']=$CustCode;
            $clientdata['Cid']=$customerId;
            
    $clientdata['ship_FullName'] 	=$sippingaddress['FullName'];
    $clientdata['ship_Address']  	=$sippingaddress['Address'];
    $clientdata ['ship_Company'] 	=$sippingaddress['Company'];
    $clientdata['ship_Mobile']	 	=$sippingaddress['Mobile'];
    $clientdata['ship_Landline'] 	=$sippingaddress['Landline'];
    $clientdata['ship_Email']    	=$sippingaddress['Email'];
    $clientdata['ship_Country']    	=$sippingaddress['CountryName'];
    $clientdata['ship_State']    	=$sippingaddress['StateName'];
    $clientdata['ship_City']    	=$sippingaddress['CityName'];       
    $clientdata['ship_zip']    	    =$sippingaddress['ZipCode'];           
    $clientdata['bill_FullName'] 	=$billingaddress['FullName'];
    $clientdata['bill_Address'] 	=$billingaddress['Address'];
    $clientdata['bill_Company'] 	=$billingaddress['Company'];
    $clientdata['bill_Mobile']  	=$billingaddress['Mobile'];
    $clientdata['bill_Landline'] 	=$billingaddress['Landline'];
    $clientdata['bill_Email']    	=$billingaddress['Email'];
    $clientdata['bill_Country'] 	=$sippingaddress['CountryName'];
    $clientdata['bill_State']    	=$sippingaddress['StateName'];
    $clientdata['bill_City']    	=$sippingaddress['CityName'];      
    $clientdata['bill_zip']    	    =$sippingaddress['ZipCode'];           
            
           return $clientdata;
	}
}

function saveCustomerAddressByRefid($client_id,$cid){
	$clientdata =array();
	$data=$this->hostbillcurl(array('task'=>'getCustomerdetail','client_id'=>$client_id));
   $return = json_decode($data, true);
	if($return){
	$return=$return['client'];	
		  $return['Cid']=$cid;
          $return['type']='shipping';
          $sippingaddress= $this->SaveCustomerAddress($return);
          $return['type']='billing';
          $billingaddress= $this->SaveCustomerAddress($return);
          
    $clientdata['ship_FullName'] 	=$sippingaddress['FullName'];
    $clientdata['ship_Address']  	=$sippingaddress['Address'];
    $clientdata['ship_Company'] 	=$sippingaddress['Company'];
    $clientdata['ship_Mobile']		=$sippingaddress['Mobile'];
    $clientdata['ship_Landline']	=$sippingaddress['Landline'];
    $clientdata['ship_Email']    	=$sippingaddress['Email'];
    $clientdata['ship_Country']    	=$sippingaddress['CountryName'];
    $clientdata['ship_State']    	=$sippingaddress['StateName'];
    $clientdata['ship_City']    	=$sippingaddress['CityName'];      
    $clientdata['ship_zip']    	    =$sippingaddress['ZipCode'];             
    $clientdata['bill_FullName'] 	=$billingaddress['FullName'];
    $clientdata['bill_Address'] 	=$billingaddress['Address'];
    $clientdata['bill_Company'] 	=$billingaddress['Company'];
    $clientdata['bill_Mobile']  	=$billingaddress['Mobile'];
    $clientdata['bill_Landline'] 	=$billingaddress['Landline'];
    $clientdata['bill_Email']    	=$billingaddress['Email'];
    $clientdata['bill_Country']    	=$sippingaddress['CountryName'];
    $clientdata['bill_State']    	=$sippingaddress['StateName'];
    $clientdata['bill_City']    	=$sippingaddress['CityName'];
    $clientdata['bill_zip']    	    =$sippingaddress['ZipCode'];        
	}
	
	return $clientdata;


}

function SaveCustomerAddress($data){
		$IPAddress = GetIPAddress();
		$fullname=$data['firstname'].' '.$data['lastname'];
		$address=array();
		$address['CustID']=$data['Cid'];
		$address['AddType']=$data['type'];
		$address['PrimaryContact']=1;
		$address['CrmContact']=0;
		$address['FirstName']=$data['firstname'];
		$address['LastName']=$data['lastname'];
		$address['FullName']=$fullname;
		$address['Company']=!empty($data['company'])?$data['company']:$fullname;
		$address['Address']=$data['address1'];
		$address['CountryName']=$data['countryname'];
		$address['StateName']=$data['state'];
		$address['ZipCode']=$data['postcode'];
		$address['CityName']=$data['city'];
		$address['Mobile']=$data['phonenumber'];
		$address['Landline']=$data['phonenumber'];
		$address['Email']=$data['email'];
		$address['AdminID']=!empty($_SESSION['AdminID'])?$_SESSION['AdminID']:$Config['AdminID'];
		$address['AdminType']=!empty($_SESSION['AdminType'])?$_SESSION['AdminType']:$Config['AdminType'];
		$address['CreatedBy']=$_SESSION['UserName'];
		$address['IpAddress']=!empty($data['ip'])?$data['ip']:$IPAddress;
		$address['Status']=1;
		$address['RigisterType']='crm';
		$fields = join(',',array_keys($address));
		$values = join("','",array_values($address));
		$strSQLQuery = "insert into s_address_book ($fields)  values('" .$values."')";      
		$this->query($strSQLQuery, 0);
		$address['AddID'] = $this->lastInsertId();
		return $address;

}


function hostbillcurl($post=array()){

try{
		  if(!empty($post['task'])){
		 	 switch($post['task']){
				 	 case 'getorderdes':
						 $return = HBWrapper::singleton()->getOrders();
		   				 return json_encode($return);
		   				 exit;
				 	 break;		 	 
				 	  case 'getorderdesdetail':
						$params = array('id'=>$post['id'] );
					    $return = HBWrapper::singleton()->getOrderDetails($params);
					    return json_encode($return);
						exit;
				 	 break;
				 	 case 'getinvoicedetail':
						$params = array('id'=>$post['id'] );
						   $return = HBWrapper::singleton()->getInvoiceDetails($params);
						   return json_encode($return);
						   exit;
				 	 break;
				 	 case 'getorderdesdetaillist':
				 	 $result=array();
				 	    $return = HBWrapper::setPageNum((int) $post['page']);
						$return = HBWrapper::singleton()->getOrders();
		   				if(!empty($return['orders'])){
				   				foreach($return['orders'] as $k=>$order){
				   				$params = array('id'=>$order['id']);
		   							$orderdetail = HBWrapper::singleton()->getOrderDetails($params);
				   					$return['orders'][$k]['orderdetail']=$orderdetail['details'];
				   				
				   				}
		   				
		   				}   			
						 return json_encode($return);
		   				 exit;
						
				 	 break;		 	 
				 	 case 'getCustomerdetail':
				 		 $cid=$post['client_id'];
				 	 	$return = HBWrapper::singleton()->getClientDetails(array('id'=>$cid)); 	
				 	 	 return json_encode($return);
		   				 exit;				
				 	 break;
				 	 case 'getCustomerlist':			 
				 	     $return = HBWrapper::setPageNum((int) $post['page']);
				 	 	 $return = HBWrapper::singleton()->getClients();
				 	 	 return json_encode($return);
		   				 exit;				
				 	 break;
				 	 case 'getInvoicedetaillist':	 
				 	     $return = HBWrapper::setPageNum((int) $post['page']);
				 	 	 $return = HBWrapper::singleton()->getInvoices();		 	 	
		 	 			if(!empty($return['invoices'])){
				   				foreach($return['invoices'] as $k=>$invoice){
				   				$params = array('id'=>$invoice['id']);
		   							$invoicedetail = HBWrapper::singleton()->getInvoiceDetails($params);
				   					$return['invoices'][$k]=$invoicedetail['invoice'];
				   				
				   				}
		   				
		   				} 			
				 	 	 return json_encode($return);
		   				 exit;				
				 	 break;
				 	 case 'getDomainDetails':
				 	   $return = HBWrapper::singleton()->getDomainDetails(array('id'=>$post['id']));
		 			   return json_encode($return);
		   				 exit;	
				 	 	 break;
				 	  case 'getProductDetails':		 
				 	   $return = HBWrapper::singleton()->getProductDetails(array('id'=>$post['id'])); 			
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	   case 'getServerDetails':
				 	   $return = HBWrapper::singleton()->getServerDetails(array('id'=>$post['id']));
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	 case 'getAddonDetails':
				 	   $return = HBWrapper::singleton()->getAddonDetails(array('id'=>$post['id']));
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	  
				 	  case 'getAppGroups':
				 	   $return = HBWrapper::singleton()->getAppGroups();		 
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	   case 'getAddons':
				 	   $return = HBWrapper::singleton()->getAddons();
				 	 
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	   case 'getAppServers':
				 	   $return = HBWrapper::singleton()->getAppServers(array('group'=>$post['group']));		 	
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	   case 'getProducts':
				 	      $return = HBWrapper::singleton()->getProducts(array('id'=>$post['id']));		 	   
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	   case 'getAccounts':
				 	     HBWrapper::setPageNum((int) $post['page']);
				 	      $return = HBWrapper::singleton()->getAccounts();		 		 	     	  
				 	    return json_encode($return);
		   				 exit;	
				 	  break;
				 	    case 'getAccountDetails':		 	    
				 	      $return = HBWrapper::singleton()->getAccountDetails(array('id'=>$post['id']));
				 	    return  json_encode($return);
		   				 exit;	
				 	  break; 
				 	    case 'getPaymentlist':	
						$return = HBWrapper::setPageNum((int) $post['page']);
				 	     $return = HBWrapper::singleton()->getTransactions(); 	 			 	  
				 	    return  json_encode($return);
		   				 exit;	
				 	  break; 
						
				 	  case 'getHostBillversion':					
				 	    $return = HBWrapper::singleton()->getHostBillversion(); 	 				  
				 	    return  json_encode($return);
		   				 exit;	
				 	  break; 
				 	  
				 	  case 'getOrderPages':
				 	   	$return = HBWrapper::singleton()->getOrderPages(); 	 				  
				 	    return  json_encode($return);
		   				 exit;	
				 	   break;
				 	  
					case 'getPaymentModules':
						$return = HBWrapper::singleton()->getPaymentModules(); 	 				  
				 	    return  json_encode($return);
		   				 exit;	
					break;
		 	 
		 	 }
		  }
	}catch(Exception $e) {
			$return["error"][]="Server Not Responding OR Please Check Hostbill Authentication Detail";
	 		 return  json_encode($return);
		   				 exit;	
  			
		}
}


function SaveHostbillpayment($date=''){
$date=!empty($date)?date('Y-m-d',strtotime($date)):date('Y-m-d');

			$paymentdata=$this->GetTempHostbillPayment(true);		 			
	 		//print_r($paymentdata);
	 		$Paymentinvoice=array();
	 		if(!empty($paymentdata)){
	 			foreach($paymentdata as $pay){
	 					$Paymentinvoice[$pay['invoice_id']]=$pay['fee'];
	 			}
	 		}
	 		
	 		
	 		
	 		
	 		require_once("/var/www/html/erp/lib/paypal/paypal_pro.inc.php");
			  $nvpRecurring = '';
              $methodToCall = 'TransactionSearch';
			  $tid=$date.'T00:00:01Z';
			  $nvpstr = '&STARTDATE=' . $tid . $nvpRecurring;
			  $Username = 'admin_api1.virtualstacks.com';
              $APIPassword = 'LFVHZUKECP9LUTTP';
              $APISignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AkcWpUe5S.hEq6uDlWHv5umDiMF4';
              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);	       
	         $newarray=$filterarray=array();
	         $i=0;
	       if(!empty($resArray))  {
		       foreach($resArray as $k=>$res){
		       if(strpos($k, 'L_TIMESTAMP')!==false){
		       $i++;
		       
		       }
		       
		       
		       }
	       
	       } 
	      
	       $updateinvoiceFee=$insertinvoiceFee=array();
	      
	       for($j=0; $j<$i;$j++){
	       $filterarray[$j]['L_TIMESTAMP']=$resArray['L_TIMESTAMP'.$j];
	       $filterarray[$j]['L_TIMEZONE']=$resArray['L_TIMEZONE'.$j];
	       $filterarray[$j]['L_TYPE']=$resArray['L_TYPE'.$j];
	       $filterarray[$j]['L_EMAIL']=$resArray['L_EMAIL'.$j];
	       $filterarray[$j]['L_NAME']=$resArray['L_NAME'.$j];
	       $filterarray[$j]['L_TRANSACTIONID']=$resArray['L_TRANSACTIONID'.$j];
	       $filterarray[$j]['L_STATUS']=$resArray['L_STATUS'.$j];
	       $filterarray[$j]['L_AMT']=$resArray['L_AMT'.$j];
	       $filterarray[$j]['L_CURRENCYCODE']=$resArray['L_CURRENCYCODE'.$j];
	       $filterarray[$j]['L_FEEAMT']=$resArray['L_FEEAMT'.$j];
	       $filterarray[$j]['L_NETAMT']=$resArray['L_NETAMT'.$j];
	      
	       		$nvpRecurring = '';
              $methodToCall = 'GetTransactionDetails';
			  $tid=$resArray['L_TRANSACTIONID'.$j];
			  $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
			 
              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
              $resArray1 = $paypalPro->hash_call($methodToCall, $nvpstr);	        
	       
	       	if($resArray1['TRANSACTIONTYPE']=='webaccept' AND !empty(substr($resArray1['INVNUM'],5))){
	      			$filterarray[$j]['invoice_id']=substr($resArray1['INVNUM'],5);
	      			
	      			if(array_key_exists($filterarray[$j]['invoice_id'],$Paymentinvoice)){
	      			
	      				if($Paymentinvoice[$filterarray[$j]['invoice_id']]=='0.00'){
	      						$updateinvoiceFee[$filterarray[$j]['invoice_id']]=$resArray1['FEEAMT'];
	      						$sql='Update s_hostbill_payment Set fee="'.$resArray1['FEEAMT'].'"  WHERE invoice_id="'.$filterarray[$j]['invoice_id'].'"';
	      						$this->query($sql, 0);
	      						
	      				}
	      			}else{
	      					$insertinvoiceFee[$filterarray[$j]['invoice_id']]=$resArray1['FEEAMT'];
	      				$data=array();
				 		$data['hostbill_in']=$resArray1['AMT'];
				 		$data['hostbill_out']='0.00';
				 		$data['ref_id']=$resArray1['INVNUM'];
				 		$data['firstname']= $resArray1[$j]['FIRSTNAME'];
				 		$data['lastname']=$resArray1[$j]['LASTNAME'];
				 		$data['date']=date('Y-m-d h:i:s',strtotime($resArray1['TIMESTAMP']));
				 		$data['currency_id']=$resArray1['COUNTRYCODE'];
				 		$data['description']='';
				 		$data['fee']=$resArray1['FEEAMT'];				 	
				 		$data['module']='Pay with Credit Card <img src="https://www.virtualstacks.com/images/creditcards.PNG">';
				 		$data['client_id']=$resArray1['PAYERID'];
				 		$data['trans_id']=$resArray1['TRANSACTIONID'];
				 		$data['invoice_id']=$filterarray[$j]['invoice_id'];
	      				$this->insert('s_hostbill_payment',$data);	
	      					
	      			
	      			}
	       	}else{
	       	
	       //	$filterarray[$j]['invoice_id']=null;
	       	}
	       // $filterarray[$j]['detail']=$resArray1;
	       
	       }
	       
	      
	 		
	 		
}


function SaveHostbillpayment1(){
			$paymentrefid=$this->GetTempHostbillPayment();		 			
	 		$payments=$this->importPaymentTmp($cpage);

	 			$kk=0;	 	
			for($i=($payments['sorter']['totalpages']-1); $i>=0; $i--)
			 	{		 	
			 		$payments=$this->importPaymentTmp($i);
					if(!empty($payments['transactions'])){
					foreach ($payments['transactions'] as $payment){						
						if(in_array($payment['id'],$paymentrefid)){
								continue;					
						}
						$data=array();
				 		$data['hostbill_in']=$payment['in'];
				 		$data['hostbill_out']=$payment['out'];
				 		$data['ref_id']=$payment['id'];
				 		$data['firstname']=$payment['firstname'];
				 		$data['lastname']=$payment['lastname'];
				 		$data['date']=$payment['date'];
				 		$data['currency_id']=$payment['currency_id'];
				 		$data['description']=$payment['description'];
				 		$data['fee']=$payment['fee'];				 	
				 		$data['module']=$payment['module'];
				 		$data['client_id']=$payment['client_id'];
				 		$data['trans_id']=$payment['trans_id'];
				 		$data['invoice_id']=$payment['invoice_id'];					 		
				 		if(strpos($payment['module'], 'Pay with Credit Card')!==false){
				 				$outputs=$this->getTransactiondetail($payment['id']);
				 				
				 			$ppref=!empty($outputs['PPREF'])?$outputs['PPREF']:'';	
				 			$pnref=!empty($outputs['PNREF'])?$outputs['PNREF']:'';			 			
				 			$data['PPREF']=$ppref;
				 			$data['PNREF']=$pnref;
				 			if(!empty($ppref)){
				 				$paymentdata=	$this->getTransactionFee($ppref);
				 				if(!empty($paymentdata['FEEAMT'])){
				 					$data['fee']=$paymentdata['FEEAMT'];
				 				}
				 					
				 			}
				 		}
				 		$this->insert('s_hostbill_payment',$data);
					}
					
					}
			 		
					$kk++;
					
					if($kk==2){
					//die('sdfsdf');
					}
			 	}
				//$this->update('s_hostbill_setting',array('meta_value'=>$customers['sorter']['totalpages']),array('meta_key'=>'customer_temp_import'));
	 		
}


/*************Save Product ************/

		function SaveHostbillProduct(){
								$productrefid=$this->GetTempHostbillProduct();		 			
						 		$orderGroups=$this->getProductOrderGroup();						 		
						 		if($orderGroups['success']=='1' AND !empty($orderGroups['categories'])){
						 			foreach($orderGroups['categories'] as $order_group){
						 				$products=$this->getHostbullProductByGroup($order_group['id']);	 				
						 				if($products['success']=='1' AND !empty($products['products'])){
						 					foreach($products['products'] as $product){
								 				if(!in_array($product['id'],$productrefid)){
								 					$data['product_name']=$product['name'];
											 		$data['group_name']=$order_group['name'];
											 		$data['ref_id']=$product['id'];
											 		$data['group_id']=$order_group['id'];
											 		$data['price']='0';						 		
										 			$this->insert('s_hostbill_product_temp',$data);
								 				}
						 					}
									 		
						 				}	
						 			}			 		
						 		}
								 	
			}


	function getTransactiondetail($id){
		$responce	=	$results	=	array();
			$fields=array('task'=>'getgetwaydetail','id'=>$id);
	 		$postvars = '';
		  foreach($fields as $key=>$value) {
		    $postvars .= $key . "=" . $value . "&";
		  }
		   $url =$this->customapi_url;  
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_POST, 1);
		   curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
		   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		   $data = curl_exec($ch);
		   curl_close($ch);
		   $results=json_decode($data);
			 
			$responce=  $this->ConvertStrToarrayOutput( $results->output);
   			return $responce;
			
	}

	
	function ConvertStrToarrayOutput($output){	
		$aaaa=explode('[',$output);
		$newarray = array();
		if(!empty($aaaa)){
			$i=0;
			foreach($aaaa as $value){
				if(!empty($value)){
					$nnn=explode('=>',$value);
					$newarray[trim(str_replace(']','',$nnn[0]))]=trim($nnn[1]);
				}
			}
		}
		
		return $newarray;
	}
	
	function getTransactionFee($transactionid){
			  require_once("/var/www/html/erp/lib/paypal/paypal_pro.inc.php");
			  $nvpRecurring = '';
              $methodToCall = 'GetTransactionDetails';
			  $tid=$transactionid;
			  $nvpstr = '&TRANSACTIONID=' . $tid . $nvpRecurring;
			  $Username = 'admin_api1.virtualstacks.com';
              $APIPassword = 'LFVHZUKECP9LUTTP';
              $APISignature = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AkcWpUe5S.hEq6uDlWHv5umDiMF4';
              $paypalPro = new paypal_pro($Username, $APIPassword, $APISignature, '', '', true, FALSE);
              $resArray = $paypalPro->hash_call($methodToCall, $nvpstr);
	          return $resArray;
              
	}
	
    function importorderProcess(){
		 $customerexits=$customerexitsdetail=$orderexits=$orderexitsdetail=$productexists=$productdetail=array();
		   
		$customers =  $this->getHostbillsalesCustomer();
		$orders =  $this->getHostbillsalesOrder();
		$products= $this->getinventoryHostbillitems();		
		if(!empty($customers)){
			foreach($customers as $cust){
					$customerexits[$cust['CustCode']]=$cust['RigisterTypeID'];
					$customerexitsdetail[$cust['CustCode']]=$cust;
			}
			
		}


		if(!empty($orders)){
			foreach($orders as $order){
					$orderexits[$order['OrderID']]=$order['CustomerPO'];
					$orderexitsdetail[$order['OrderID']]=$order;
			}
		
		}
	     if(!empty($products)){
			foreach($products as $product){
					$productexists[$product['ItemID']]=$product['ref_id'];
					$productdetail[$product['ItemID']]=$product;
			}
		}

	
		
		$page=$this->GetTempHostbillSetting('order_import_page');
		$cpage=(!empty($page) AND !is_array($page))?$page:0;
		$return=$this->getOrderData($cpage);
		for($i=($return['sorter']['totalpages']); $i>=$cpage; $i--)
			{				
			$return=$this->getOrderData($i);		  
		  if(!empty($return['orders'])){
				  foreach($return['orders'] as $orderres){
					   if(array_search($orderres['id'],$orderexits)!=false){
					   			continue;
					   }
		  
				 		 if(array_search($orderres['client_id'],$customerexits)==false){
				 				 $cdata= $this->addHostbillcustomer($orderres['client_id']);
				 				 $customerexitsdetail[$cdata['CustCode']]=$cdata;
				 				 $customerexits[$cdata['CustCode']]=$orderres['client_id'];
				 				 $CustCode=$cdata['CustCode'];
				 		 
				 		 }else{		 		 
				 				 $CustCode=array_search($orderres['client_id'],$customerexits);		 
				 				 if(empty($customerexitsdetail[$CustCode]['ship_FullName']) && empty($customerexitsdetail[$CustCode]['bill_FullName'])){
										$dataresponce=$this->saveCustomerAddressByRefid($orderres['client_id'],$customerexitsdetail[$CustCode]['Cid']);
				 				 		if(!empty($dataresponce)){
				 				 			foreach($dataresponce as $kkk=>$ddd){
				 				 					$customerexitsdetail[$CustCode][$kkk]=$ddd;
				 				 			}
				 				 		}
				 				 	
				 				 }	
				 				
				 		 }
		 		
				 	$importdata=array();				 	
				 	$importdata['OrderDate'] = $orderres['date_created'] ;
				    $importdata['Module'] = 'Order';			
					$importdata['CustID'] =  addslashes($customerexitsdetail[$CustCode]['Cid']);
					$importdata['CustCode'] = addslashes($CustCode) ;
					$importdata['CustomerCurrency'] =  addslashes($orderres['currency_id']);
					$importdata['DeliveryDate'] =  addslashes($orderres['date_created']);				
					$importdata['TotalAmount'] =  addslashes($orderres['total']) ;
					$importdata['CustomerName'] = addslashes($orderres['firstname']).' '.addslashes($orderres['lastname']);
					$importdata['BillingName'] =  $customerexitsdetail[$CustCode]['bill_FullName'];				
					$importdata['Address'] =  $customerexitsdetail[$CustCode]['bill_Address'];		
					$importdata['City'] = $customerexitsdetail[$CustCode]['bill_City'];
					$importdata['State'] =  $customerexitsdetail[$CustCode]['bill_State'];
					$importdata['Country'] = $customerexitsdetail[$CustCode]['bill_Country'];
					$importdata['ZipCode'] = $customerexitsdetail[$CustCode]['bill_zip'];	
					$importdata['Mobile'] =  addslashes($customerexitsdetail[$CustCode]['Mobile']);
					$importdata['Email'] = addslashes($customerexitsdetail[$CustCode]['Email']);
					$importdata['ShippingName'] = $customerexitsdetail[$CustCode]['bill_FullName'];			
					$importdata['ShippingCompany'] =  addslashes($customerexitsdetail[$CustCode]['Company']);
					$importdata['ShippingAddress'] =   $customerexitsdetail[$CustCode]['ship_Address'];		
					$importdata['ShippingCity'] =   $customerexitsdetail[$CustCode]['ship_City'];	
					$importdata['ShippingState'] =  $customerexitsdetail[$CustCode]['ship_State'];	
					$importdata['ShippingCountry'] =   $customerexitsdetail[$CustCode]['ship_Country'];	
					$importdata['ShippingZipCode'] =   $customerexitsdetail[$CustCode]['ship_zip'];	
					$importdata['ShippingMobile'] = $customerexitsdetail[$CustCode]['ship_Mobile'];		
					$importdata['OrderSource'] = 'hostbill';
					$importdata['CustomerPO'] = addslashes($orderres['id']);
					$importdata['AdminID']=!empty($_SESSION['AdminID'])?$_SESSION['AdminID']:$Config['AdminID'];
					$importdata['AdminType']=!empty($_SESSION['AdminType'])?$_SESSION['AdminType']:$Config['AdminType'];
					
		
					$fields = join(',',array_keys($importdata));
		            $values = join("','",array_values($importdata));      
		            $order_id=time().rand(1111,9999);     
			  		$ppp=array();
		            if(!empty($orderres['orderdetail']['hosting'])){		          
				            foreach($orderres['orderdetail']['hosting'] as $hosting){
					            if(in_array($hosting['product_id'],$productexists)){
					            	$ppp[]=$productdetail[array_search($hosting['product_id'],$productexists)];		 
					            
					            }else{			            
					            
					            $itemdata['name']=$hosting['name'];
					            $itemdata['product_id']=$hosting['product_id'];
					            $itemdata['description']=$hosting['description'];
					            $itemdata['total']=$hosting['total'];
					            		$resss=$this->saveOrderItem($itemdata);
					            		$productexists[$resss['ItemID']]=$resss['ref_id'];
										$productdetail[$resss['ItemID']]=array('ItemID'=>$resss['ItemID'],'Sku'=>$resss['Sku'],'description'=>$resss['description'],'product_source'=>$resss['product_source'],'ref_id'=>$resss['ref_id'],'sell_price'=>$resss['sell_price']);
					            		$ppp[]=array('ItemID'=>$resss['ItemID'],'Sku'=>$resss['Sku'],'description'=>$resss['description'],'product_source'=>$resss['product_source'],'ref_id'=>$resss['ref_id'],'sell_price'=>$resss['sell_price']);
					           	
					            }
				            
				            }   
		            }
					            
					   if(!empty($orderres['orderdetail']['domains'])){
			          
					            foreach($orderres['orderdetail']['domains'] as $domain){
					          		  pr($domain);
						            if(in_array('domain-'.$domain['id'],$productexists)){
						            	$ppp[]=$productdetail[array_search('domain-'.$domain['id'],$productexists)];		 
						            
						            }else{	
							            if(!empty($domain['name'])){
							            		$itemdata=array();		
									            $itemdata['name']=$domain['name'];
									            $itemdata['product_id']='domain-'.$domain['id'];
									            $itemdata['description']=$domain['name'];
									            $itemdata['total']=$domain['firstpayment'];
									            echo '<br>';
									            echo 'Item Array';
									            pr($itemdata);            
							            		$resss=$this->saveOrderItem($itemdata);
							            		$productexists[$resss['ItemID']]=$resss['ref_id'];
												$productdetail[$resss['ItemID']]=array('ItemID'=>$resss['ItemID'],'Sku'=>$resss['Sku'],'description'=>$resss['description'],'product_source'=>$resss['product_source'],'ref_id'=>$resss['ref_id'],'sell_price'=>$resss['sell_price']);
							            		$ppp[]=array('ItemID'=>$resss['ItemID'],'Sku'=>$resss['Sku'],'description'=>$resss['description'],'product_source'=>$resss['product_source'],'ref_id'=>$resss['ref_id'],'sell_price'=>$resss['sell_price']);
							          	  }
						            }
					            
					            }   
			            }
			          
			       
		             if(!empty($ppp)){
				            foreach($ppp as $pppval){
					            $SqlOrderitem = "INSERT INTO s_order_item SET
									OrderID = '" . addslashes($order_id) . "',
									item_id = '" . addslashes($pppval['ItemID']) . "',
									sku = '" . addslashes($pppval['Sku']) . "',
									description = '" . addslashes($pppval['description']) . "',
									qty = '1',	
									qty_invoiced = '1',		
									price = '" . addslashes($pppval['sell_price']) . "',			
									amount = '" . addslashes($pppval['sell_price']) . "',
									Taxable = '',
									tax = ''";					         
				            }
				            }	
		  }
    
	    }
	  
	    
		}
		
		die;
		$this->update('s_hostbill_setting',array('meta_value'=>$return['sorter']['totalpages'],'meta_date'=>date('Y-m-d H:i:s')),array('meta_key'=>'order_import_page'));

    return true;
    }
    
    function saveOrderItem($pdata){    
   		$data=array();
		$data['description']=$pdata['name'];
		$data['long_description']=$pdata['description'];
		$data['procurement_method']='SALE';
		$data['CategoryID']=0;
		$data['evaluationType']='';
		$data['itemType']='';
		$data['non_inventory']='yes';
		$data['UnitMeasure']='';
		$data['min_stock_alert_level']='';
		$data['max_stock_alert_level']='';
		$data['purchase_tax_rate']='';
		$data['sale_tax_rate']='';
		$data['Status']=1;
		$data['AddedDate']=date('Y-m-d H:i:s');
		$data['Sku']='host'.rand(1111,9999).rand(1111,9999);
		$data['item_alias']='';
		$data['sell_price']=$pdata['total'];
		$data['qty_on_hand']='';
		$data['long_description']='';
		$data['Model']='';
		$data['Generation']='';		
		$data['Extended']='';
		$data['Manufacture']='';
		$data['ReorderLevel']='';
		$data['is_exclusive']='';
		$data['Reorderlabelbox']='';
		$data['product_type']='Virtual';
		$data['secure_type']='Secure';
		$data['product_source']='hostbill';
		$data['ref_id']=$pdata['product_id'];
		$fields = join(',',array_keys($data));
	    $values = join("','",array_values($data));      
    	 $strSQLQuery = "insert into inv_items ($fields)  values('" .$values."')";      
         $this->query($strSQLQuery, 0);
		 $data['ItemID'] = $this->lastInsertId();
		 return $data;
    }
    
    
    
    function SaveInvoice($orderres,$customerdata,$refund=false){ 
			$IPAddress = GetIPAddress();  
			global $Config;		
			$importdata=array();

			if($refund==true){
				$importdata['Module'] = 'Credit';			 	
			 	$importdata['Status'] = 'Open';
				$importdata['PostedDate'] = $orderres['date'] ;
				$importdata['Approved'] = '0';
				$importdata['InvoiceEntry'] = '0';	
			}else{
				$importdata['Module'] = 'Invoice';				
				$importdata['InvoicePaid'] = 'Unpaid'; // will be changed to paid after post to gl
				$importdata['ShippedDate'] = $orderres['date'] ;
				$importdata['InvoiceDate'] = $orderres['date'] ;
				$importdata['PaymentDate'] = @date('Y-m-d',strtotime($orderres['datepaid'])) ;	
				$importdata['OrderDate'] = $orderres['date'] ;
				$importdata['Approved'] = '1';		    
				$importdata['InvoiceEntry'] = '1';
				$importdata['Fee'] =  addslashes($orderres['fee']) ;
				$importdata['PostedDate'] = $Config['TodayDate'];
			}	     
		  
		    $importdata['EntryType'] = 'one_time';
		    $importdata['Fee'] =  addslashes($orderres['fee']) ;		    
		    $importdata['CustomerCompany'] =  !empty($orderres['client']['companyname'])?addslashes($orderres['client']['companyname']):addslashes($customerdata['FullName']);
			$importdata['CustID'] =  addslashes($customerdata['Cid']);
			$importdata['CustCode'] = addslashes($customerdata['CustCode']) ;
			$importdata['CustomerCurrency'] =  addslashes($orderres['currency_id']);
			$importdata['DeliveryDate'] =  addslashes($orderres['duedate']);
			$importdata['PaymentMethod'] =  addslashes(strip_tags($orderres['gateway']));
			$importdata['TotalAmount'] =  addslashes($orderres['total']) ;
			$importdata['TotalInvoiceAmount'] =  addslashes($orderres['total']) ;
			$importdata['CustomerName'] = addslashes($customerdata['FullName']);
			$importdata['BillingName'] =  addslashes($customerdata['FullName']);			
			$importdata['Address'] = addslashes($orderres['client']['address1']) ;
			$importdata['City'] =   addslashes($orderres['client']['city']) ;
			$importdata['State'] =  addslashes($orderres['client']['state']) ;
			$importdata['Country'] =   addslashes($orderres['client']['country']) ;
			$importdata['ZipCode'] =addslashes($orderres['client']['postcode']) ;
			$importdata['Mobile'] =  addslashes($customerdata['Mobile']);
			$importdata['Email'] = addslashes($customerdata['Email']);
			$importdata['ShippingName'] = addslashes($customerdata['FullName']);
			$importdata['ShippingCompany'] =  !empty($orderres['client']['companyname'])?addslashes($orderres['client']['companyname']):addslashes($customerdata['FullName']);
			$importdata['ShippingAddress'] =  addslashes($orderres['client']['address1']) ;
			$importdata['ShippingCity'] =   addslashes($orderres['client']['city']) ;
			$importdata['ShippingState'] = addslashes($orderres['client']['state']) ;
			$importdata['ShippingCountry'] =  addslashes($orderres['client']['country']) ;
			$importdata['ShippingZipCode'] = addslashes($orderres['client']['postcode']) ;
			$importdata['ShippingMobile'] = addslashes($customerdata['Mobile']);
			$importdata['ShippingEmail'] = addslashes($customerdata['Email']);
			
			$importdata['discountAmnt'] = !empty($orderres['discount'])?$orderres['discount']:0;		
			$importdata['taxAmnt'] =  addslashes($orderres['tax']) ;
			$importdata['TaxRate'] =  addslashes($orderres['taxrate']) ;
			$importdata['InvoiceComment'] =  addslashes($orderres['notes']) ;
			$importdata['SaleID'] = !empty($orderres['SaleID'])?addslashes($orderres['SaleID']):'' ;
			
			$importdata['OrderSource'] = 'hostbill';
			$importdata['EntryBy'] = 'C';
			$importdata['CustomerPO'] = addslashes($orderres['id']);
			$importdata['AdminID']=!empty($_SESSION['AdminID'])?$_SESSION['AdminID']:$Config['AdminID'];
			$importdata['AdminType']=!empty($_SESSION['AdminType'])?$_SESSION['AdminType']:$Config['AdminType'];
			$importdata['IPAddress'] = $IPAddress;			
			$importdata['UpdatedDate'] = $Config['TodayDate'];
		
			$fields = join(',',array_keys($importdata));
            $values = join("','",array_values($importdata));      
            $strSQLQuery = "insert into s_order ($fields)  values('" .$values."')"; 
          
           
			$this->query($strSQLQuery, 0);	
	  		$orderId = $this->lastInsertId(); 

			/*********************************/
		
			/*********************************/
		 	
		 	/****************************************/
		 		if($refund==true){
		 		$sqlInvc = "select CreditID from s_order where CreditID = '".$orderres['id']."' and  OrderID!='".$orderId."'";
				$arrInvc = $this->query($sqlInvc, 1);
				$numInvc = sizeof($arrInvc);
	
				$AutoID = filter_var($orderres['id'], FILTER_SANITIZE_NUMBER_INT);
				if(!empty($arrInvc[0]['CreditID'])){				
					$InvoiceID = $orderres['id'].'-'.$numInvc;				
				}else{	
					$InvoiceID = $orderres['id'];					
				}
				$strSQLFinal = "update s_order set CreditID='" .$InvoiceID . "', AutoID='" . $AutoID . "' where OrderID='" . $orderId . "'";
		 		$this->query($strSQLFinal, 0);
		 		

				/*********CreditLimit Updation***********/
				$strSQlCust = "select PaymentTerm from s_customers WHERE CustCode='".$customerdata['CustCode']."'";
				$arrCust = $this->query($strSQlCust, 1);			
				if(!empty($arrCust[0]['PaymentTerm'])){
					$arryTerm = explode("-",$arrCust[0]['PaymentTerm']);
					$TermDays = (int)trim($arryTerm[1]);
					if($TermDays > 0){
						$sql="UPDATE s_customers SET CreditLimit=CreditLimit-".$orderres['total']." WHERE CustCode='".$customerdata['CustCode']."' and CreditLimit>0";
						$this->query($sql,0);
						$sql2="UPDATE s_customers SET CreditLimit='0' WHERE CustCode='".$customerdata['CustCode']."' and CreditLimit<0";
						$this->query($sql2,0);
					}
				}
				/*****************************************/
			 	
				/*$sql="UPDATE s_customers SET 
				CreditLimit=CreditLimit-".$orderres['total']." WHERE 
				CustCode='".$customerdata['CustCode']."' and CreditLimit>0 ";
			        $this->query($sql,0);*/
				         
				         
		 		}else{
		 		
			 	$sqlInvc = "select InvoiceID from s_order where InvoiceID = '".$orderres['id']."' and  OrderID!='".$orderId."'";
				$arrInvc = $this->query($sqlInvc, 1);
				$numInvc = sizeof($arrInvc);
	
				$AutoID = filter_var($orderres['id'], FILTER_SANITIZE_NUMBER_INT);
				if(!empty($arrInvc[0]['InvoiceID'])){				
					$InvoiceID = $orderres['id'].'-'.$numInvc;				
				}else{	
					$InvoiceID = $orderres['id'];					
				}
				$strSQLFinal = "update s_order set InvoiceID='" .$InvoiceID . "',AutoID='" . $AutoID . "' where OrderID='" . $orderId . "'";
		 		$this->query($strSQLFinal, 0);
		 		
		 	}
		 	
		 	/***************************************/
 
			$importdata['InvoiceID']=$InvoiceID;
			$importdata['OrderID']=$orderId;

			if(!empty($orderres['items'])){
			
					foreach($orderres['items'] as $billitem){
						$sku=!empty($billitem['Sku'])?$billitem['Sku']:'hostbill_' .time(). rand(1111,9999);
						$tx=(empty($billitem['taxed']))?'No':'Yes';
						$descript='';
						if(!empty($billitem['pName'])){
							$descript=$billitem['pName'];
						}else if(strpos($billitem['type'],'Domain')!=false){
							$itemdetail=$this->itemdetail($billitem['item_id']);
							if(!empty($itemdetail['details'])){						
								$descript=$itemdetail['details']['name'];
							
							}
						}
						if(empty($descript)){
							$descript=$billitem['description'];
						}
							$SqlOrderitem = "INSERT INTO s_order_item SET
							OrderID = '" . addslashes($orderId) . "',
							item_id = '" . addslashes($billitem['pid']) . "',
							sku = '" . $sku . "',
							description = '" . addslashes($descript) . "',
							qty = '" . addslashes($billitem['qty']) . "',	
							qty_invoiced = '" . addslashes($billitem['qty']) . "',		
							price = '" . addslashes($billitem['linetotal']) . "',			
							amount = '" . addslashes($billitem['amount']) . "',
							Taxable = '".$tx."',
							tax = '" . addslashes($billitem['taxed']) . "' ";
							//echo $SqlOrderitem;
				           $this->query($SqlOrderitem, 0);
				}
			}
			
			
			if($orderres['status']=='Refunded'){
					unset($orderres['status']);
					$this->SaveInvoice($orderres,$customerdata,true);
			}
			
			return $importdata;
    }
    
    
    function SaveInvoiceOld($orderres,$customerdata){ 
			$IPAddress = GetIPAddress();  
			global $Config;		
			$importdata=array();
		    $importdata['OrderDate'] = $orderres['date'] ;
		    $importdata['PaymentDate'] = @date('Y-m-d',strtotime($orderres['datepaid'])) ;
		    $importdata['InvoiceDate'] = $orderres['date'] ;
		    $importdata['ShippedDate'] = $orderres['date'] ;
		    //$importdata['InvoicePaid'] = $orderres['status'] ;
		    $importdata['InvoicePaid'] = 'Unpaid'; // will be changed to paid after post to gl
		    $importdata['Module'] = 'Invoice';		    
		  
		    $importdata['EntryType'] = 'one_time';	
		  
		    $importdata['Approved'] = '1';	
		    $importdata['InvoiceEntry'] = '1';				    	    
		    $importdata['Fee'] =  addslashes($orderres['fee']) ;		    
		    $importdata['CustomerCompany'] =  !empty($orderres['client']['companyname'])?addslashes($orderres['client']['companyname']):addslashes($customerdata['FullName']);
			$importdata['CustID'] =  addslashes($customerdata['Cid']);
			$importdata['CustCode'] = addslashes($customerdata['CustCode']) ;
			$importdata['CustomerCurrency'] =  addslashes($orderres['currency_id']);
			$importdata['DeliveryDate'] =  addslashes($orderres['duedate']);
			$importdata['PaymentMethod'] =  addslashes(strip_tags($orderres['gateway']));
			$importdata['TotalAmount'] =  addslashes($orderres['total']) ;
			$importdata['TotalInvoiceAmount'] =  addslashes($orderres['total']) ;
			$importdata['CustomerName'] = addslashes($customerdata['FullName']);
			$importdata['BillingName'] =  addslashes($customerdata['FullName']);			
			$importdata['Address'] = addslashes($orderres['client']['address1']) ;
			$importdata['City'] =   addslashes($orderres['client']['city']) ;
			$importdata['State'] =  addslashes($orderres['client']['state']) ;
			$importdata['Country'] =   addslashes($orderres['client']['country']) ;
			$importdata['ZipCode'] =addslashes($orderres['client']['postcode']) ;
			$importdata['Mobile'] =  addslashes($customerdata['Mobile']);
			$importdata['Email'] = addslashes($customerdata['Email']);
			$importdata['ShippingName'] = addslashes($customerdata['FullName']);
			$importdata['ShippingCompany'] =  !empty($orderres['client']['companyname'])?addslashes($orderres['client']['companyname']):addslashes($customerdata['FullName']);
			$importdata['ShippingAddress'] =  addslashes($orderres['client']['address1']) ;
			$importdata['ShippingCity'] =   addslashes($orderres['client']['city']) ;
			$importdata['ShippingState'] = addslashes($orderres['client']['state']) ;
			$importdata['ShippingCountry'] =  addslashes($orderres['client']['country']) ;
			$importdata['ShippingZipCode'] = addslashes($orderres['client']['postcode']) ;
			$importdata['ShippingMobile'] = addslashes($customerdata['Mobile']);
			$importdata['ShippingEmail'] = addslashes($customerdata['Email']);
			
			$importdata['discountAmnt'] = !empty($orderres['discount'])?$orderres['discount']:0;		
			$importdata['taxAmnt'] =  addslashes($orderres['tax']) ;
			$importdata['TaxRate'] =  addslashes($orderres['taxrate']) ;
			$importdata['InvoiceComment'] =  addslashes($orderres['notes']) ;
			$importdata['SaleID'] = !empty($orderres['SaleID'])?addslashes($orderres['SaleID']):'' ;
			
			$importdata['OrderSource'] = 'hostbill';
			$importdata['EntryBy'] = 'C';
			$importdata['CustomerPO'] = addslashes($orderres['id']);
			$importdata['AdminID']=!empty($_SESSION['AdminID'])?$_SESSION['AdminID']:$Config['AdminID'];
			$importdata['AdminType']=!empty($_SESSION['AdminType'])?$_SESSION['AdminType']:$Config['AdminType'];
			$importdata['IPAddress'] = $IPAddress;
			$importdata['PostedDate'] = $Config['TodayDate'];
			$importdata['UpdatedDate'] = $Config['TodayDate'];
		
			$fields = join(',',array_keys($importdata));
            $values = join("','",array_values($importdata));      
            $strSQLQuery = "insert into s_order ($fields)  values('" .$values."')"; 
          
           
			$this->query($strSQLQuery, 0);	
	  		$orderId = $this->lastInsertId(); 

			/*********************************/
			$sqlInvc = "select InvoiceID from s_order where InvoiceID = '".$orderres['id']."' and  OrderID!='".$orderId."'";
			$arrInvc = $this->query($sqlInvc, 1);
			$numInvc = sizeof($arrInvc);

			$AutoID = filter_var($orderres['id'], FILTER_SANITIZE_NUMBER_INT);
			if(!empty($arrInvc[0]['InvoiceID'])){				
				$InvoiceID = $orderres['id'].'-'.$numInvc;				
			}else{	
				$InvoiceID = $orderres['id'];					
			}
			$strSQLFinal = "update s_order set InvoiceID='" .$InvoiceID . "',AutoID='" . $AutoID . "' where OrderID='" . $orderId . "'";
		 	$this->query($strSQLFinal, 0);
			/*********************************/
 
			$importdata['InvoiceID']=$InvoiceID;
			$importdata['OrderID']=$orderId;

			if(!empty($orderres['items'])){
			
					foreach($orderres['items'] as $billitem){
						$sku=!empty($billitem['Sku'])?$billitem['Sku']:'hostbill_' .time(). rand(1111,9999);
						$tx=(empty($billitem['taxed']))?'No':'Yes';
						$descript='';
						if(!empty($billitem['pName'])){
							$descript=$billitem['pName'];
						}else if(strpos($billitem['type'],'Domain')!=false){
							$itemdetail=$this->itemdetail($billitem['item_id']);
							if(!empty($itemdetail['details'])){						
								$descript=$itemdetail['details']['name'];
							
							}
						}
						if(empty($descript)){
							$descript=$billitem['description'];
						}
							$SqlOrderitem = "INSERT INTO s_order_item SET
							OrderID = '" . addslashes($orderId) . "',
							item_id = '" . addslashes($billitem['pid']) . "',
							sku = '" . $sku . "',
							description = '" . addslashes($descript) . "',
							qty = '" . addslashes($billitem['qty']) . "',	
							qty_invoiced = '" . addslashes($billitem['qty']) . "',		
							price = '" . addslashes($billitem['linetotal']) . "',			
							amount = '" . addslashes($billitem['amount']) . "',
							Taxable = '".$tx."',
							tax = '" . addslashes($billitem['taxed']) . "' ";
							//echo $SqlOrderitem;
				           $this->query($SqlOrderitem, 0);
				}
			}
			
			
			return $importdata;
    }
    
    function getinvoiceData($page=0){
    
   $post=array('task'=>'getInvoicedetaillist','page'=>$page);
  		$data=$this->hostbillcurl($post);
		  return  $return = json_decode($data, true);  
    
    }
    
    
      function getOrderData($page=0){  
			   
			   $post=array('task'=>'getorderdesdetaillist','page'=>$page);
			   $data=$this->hostbillcurl($post);			  
				return $return = json_decode($data, true);
    	}
    
    
        function getItemDetail($itemid){
		     $url = $this->url;  
		   $post=array('task'=>'getAccountDetails','id'=>$itemid);
		   $data=$this->hostbillcurl($post);
		  return  $return = json_decode($data, true);
    	}
    
   
    
    
    function importInvoiceProcess(){


    global $Config;
	$Config['TodayDate']=urldecode($Config['TodayDate']);
	$YesterDay = date('Y-m-d',strtotime("-1 day", strtotime($Config['TodayDate'])));

    $page=$this->GetTempHostbillSetting('inventory_import_page');
    $allhostbillconfig=$this->GetTempHostbillSetting();
   
	$cpage=(!empty($page) AND !is_array($page))?$page:0;
    
    $customerexits=$customerexitsdetail=$orderexits=$orderexitsdetail=$productexists=$productdetail=    
    $itemsdetail=$itemslist=array();
    $paymentFilter=array();
    $customers =  $this->getHostbillsalesCustomer();
	$invoices =  $this->getHostbillsalesOrder($type='Invoice');
	$products= $this->getinventoryHostbillitems();
	$items= $this->GetTempHostbillAccount(true);
		
	$tempPayments= $this->GetTempHostbillPayment(true);

	
	if(!empty($tempPayments)){
		foreach($tempPayments as $ppp){
				$paymentFilter[$ppp['invoice_id']][$ppp['trans_id']]=$ppp['fee'];
		}
	}
		
    
    if(!empty($customers)){
		foreach($customers as $cust){
				$customerexits[$cust['CustCode']]=$cust['RigisterTypeID'];
				$customerexitsdetail[$cust['CustCode']]=$cust;
		}

	}
	
	if(!empty($invoices)){
		foreach($invoices as $invoice){
				$orderexits[$invoice['OrderID']]=$invoice['CustomerPO'];
				$orderexitsdetail[$invoice['OrderID']]=$invoice;
		}
	}
    if(!empty($products)){
		foreach($products as $product){
				$productexists[$product['ItemID']]=$product['ref_id'];
				$productdetail[$product['ItemID']]=$product;
		}
	}
	
    if(!empty($items)){
		foreach($items as $item){
				$itemslist[$item['account_id']]=$item['product_id'];
				$itemsdetail[$item['account_id']]=$item;
		}
	}

   $invoicedata=$this->getinvoiceData($cpage); 

  $ss=$invoicedata['sorter']['totalpages']-$cpage;
 
  $updatepage=$cpage;  
  //print_r($Config);
		  if(!empty($Config['SyncButton'])){
		  	$ss=$invoicedata['sorter']['totalpages'];
		  	$updatepage=0;
		  }
		//  echo $ss;
		//  echo "<br>";
		//  echo $updatepage;
		//  die;
		
		  
		  
	 for($i=$ss; $i>=0; $i--)	
		
		 // for($i=0; $i<=$ss; $i++)	
			{
		 $invoicedata=$this->getinvoiceData($i);		
		   if(!empty($invoicedata['invoices'])){   
		   			foreach($invoicedata['invoices'] as $invoice){
		   					$invoice['currency_id'] = 'USD'; //need api to make it dyanamic
$validDate=0;
 
if($invoice['date']==$YesterDay ){
	$validDate=1;
}

if(!empty($Config['SyncButton'])){

	if(empty($allhostbillconfig['sycnInvoice']) || $allhostbillconfig['sycnInvoice']=='all'){
		$validDate=1;
	}else if($allhostbillconfig['sycnInvoice']=='current' AND $Config['TodayDate']==$invoice['date']){
			$validDate=1;
	
	}else if($allhostbillconfig['sycnInvoice']=='fromdate' AND strtotime($invoice['date'])>=strtotime($allhostbillconfig['fromdate'])){
		$validDate=1;
		
	}

}

				   			if(!in_array($invoice['id'],$orderexits) && $validDate==1 && $invoice['status']!='Cancelled'){
				   			
				   			
					   			if(!isset($invoice['discount'])){
					   				$invoice['discount']=0;
					   			}
					   			
				   					$invoicecustomer=array();
				   					if(in_array($invoice['client']['id'],$customerexits)){		   					
				   							$invoicecustomer=$customerexitsdetail[array_search($invoice['client']['id'],$customerexits)];		   					
				   					}else{
					   				 $cdata= $this->saveHostbillSaleCustomer($invoice['client']);
					 				 $customerexitsdetail[$cdata['CustCode']]=$cdata;
					 				 $customerexits[$cdata['CustCode']]=$cdata['RigisterTypeID'];
				 					 $invoicecustomer=$cdata;
				   					}	
							$soRefrence=array();
				   					if(!empty($invoice['items'])){					   					
					   					foreach($invoice['items'] as $k=>$items){	

					   					
						   					if($items['type']=='Discount')	{						   					
						   							$invoice['discount']=$invoice['discount']+abs($items['amount']);
						   							unset($invoice['items'][$k]);
						   							continue;
						   					}  

						   					
						   					
								   		//	if(!array_key_exists($items['item_id'],$itemslist)){
								   		
						   					$productinfo=array();
								   			$pos = strpos(strtolower($items['type']), 'domain');	
								   			if(strtolower($items['type'])=='other'){
								   				$product_id =	'other';				   				
	 										    $productinfo['product_name']='Hostbill Other';
	 										    $soRefrence[]=$items['description'];
								   			}else if($pos===false){
						   						$hostbillitemdetail=$this->getItemDetail($items['item_id']);	
						   						$product_id=	$hostbillitemdetail['details']['product_id'];				   				
	 										      $productinfo['product_name']=$hostbillitemdetail['product_name'];
	 										      $soRefrence[]=$items['description'];
	 										    
						   						
						   					}else{
						   							$hostbillitemdetail=$this->itemdetail($items['item_id']);	
						   							$product_id=$hostbillitemdetail['details']['tld_id'];		
						   							$productinfo['product_name']=$hostbillitemdetail['details']['tld_name'];
						   							$soRefrence[]=$hostbillitemdetail['details']['name'];
						   							
						   					}
						   							$productinfo['amount']=$items['amount'];
						   					
						   						
					   						if(empty($hostbillitemdetail['success'])){
						   							continue;
						   					}
						   										   				
						   					$pdetail=array();
						   					
							   				if(!in_array($product_id,$productexists)){
							   								$tmpdata=array();
							   								$tmpdata=array('description'=>$productinfo['product_name'],'amount'=>$productinfo['amount']);
							   										if(strtolower($items['type'])=='other'){
							   											$tmpdata['Sku']='hostbill-other';
							   											$tmpdata['product_name']='Hostbill Other';							   									
								   									}
							   								
							   									$pdetail=$this->saveItems($product_id,$tmpdata);
							   									$productexists[$pdetail['ItemID']]=$product_id;
																$productdetail[$pdetail['ItemID']]=$pdetail;
							   							}else{	
								   							$pdetail=$productdetail[array_search($product_id,$productexists)];
								   					
								   						}
								   						
								   					$invoice['items'][$k]['Sku']=$pdetail['Sku'];
								   					$invoice['items'][$k]['pName']=$pdetail['description'];
								   					$invoice['items'][$k]['pid']=$pdetail['ItemID'];
								   					
					   					}
				   					}		
				   								
				   					$feedata=$paymentFilter[$invoice['id']];
				   					$invoice['fee']=0;
				   					if(!empty($feedata)){
					   					foreach($feedata as $fee){
					   						if(!empty($fee)){
					   							$invoice['fee']=$fee;
					   							continue;
					   						}
					   					}
				   					}			

				   					$invoice['SaleID']='';
				   					if(!empty($soRefrence)){
				   						$invoice['SaleID']=implode(' , ',$soRefrence);
				   					}
				   					
				   					//echo "<pre>";
				   			//	print_r($invoice);
				   					$return=	$this->SaveInvoice($invoice,$invoicecustomer);		   					
				   					$orderexits[$return['OrderID']]=$return['CustomerPO'];
				   					$orderexitsdetail[$return['OrderID']]=$return;
				   				
				   			
				   			}
		   			}
			}
			
			if($i==2 ){
				//break;
			
			//	die('dgdfg');
			}
			
			
			 if(!empty($Config['SyncButton'])){
					$this->update('s_hostbill_setting',array('meta_value'=>$updatepage,'meta_date'=>date('Y-m-d H:i:s')),array('meta_key'=>'inventory_import_page'));
			 }
			 $updatepage++; 
	}
   //$this->update('s_hostbill_setting',array('meta_value'=>$invoicedata['sorter']['totalpages'],'meta_date'=>date('Y-m-d H:i:s')),array('meta_key'=>'inventory_import_page'));

    return true;
   
    }
    
    
    function saveHostbillSaleCustomer($return){   
			$IPAddress = GetIPAddress();

	  		$FullName=$return['firstname'].' '.$return['lastname'];
			$clientdata['CustomerType'] = 'Individual';
			$clientdata['Company'] = !empty($return['companyname'])?mysql_real_escape_string(strip_tags($return['companyname'])):$FullName ;
			$clientdata['FirstName']=mysql_real_escape_string(strip_tags($return['firstname'])) ;
			$clientdata['LastName'] =mysql_real_escape_string(strip_tags($return['lastname']));
			$clientdata['FullName'] = mysql_real_escape_string(strip_tags($FullName)) ;
			$clientdata['Gender'] = 'Male';			 
			$clientdata['Mobile'] = mysql_real_escape_string(strip_tags($return['phonenumber']));
			$clientdata['Email'] = mysql_real_escape_string(strip_tags($return['email'])) ;
			$clientdata['CreatedDate'] =mysql_real_escape_string($return['datecreated']);
			//$clientdata['ipaddress'] =mysql_real_escape_string($return['ip']);
			$clientdata['ipaddress']=!empty($return['ip'])?$return['ip']:$IPAddress;
			$clientdata['Status']='Yes';
			$clientdata['RigisterType']='hostbill';
			$clientdata['RigisterTypeID']=$return['id'];
			
		  $fields = join(',',array_keys($clientdata));
	      $values = join("','",array_values($clientdata));

    	 $strSQLQuery = "insert into s_customers ($fields)  values('" .$values."')"; 
    	  $this->query($strSQLQuery, 0);
      
		
			$customerId=$this->lastInsertId();
            $CustCode = 'CUST00' . $customerId;

            $sql = "update s_customers set CustCode = '" . mysql_real_escape_string($CustCode) . "'
			 where Cid='" . addslashes($customerId) . "'";
            $this->query($sql, 0);	
            $clientdata['CustCode']=$CustCode;
            $clientdata['Cid']=$customerId;
            
           return $clientdata;
	
    }
    
 	function lastInsertId(){
		    return mysql_insert_id();
		 }
    
    function saveProductTemp($accou){
	    $data=array();
	    $data['manual']=$accou['manual'];
	    $data['domain']=$accou['domain'];
	    $data['billingcycle']=$accou['billingcycle'];
	    $data['status']=$accou['status'];
	    $data['total']=$accou['total'];
	    $data['next_due']=$accou['next_due'];
	    $data['name']=$accou['name'];
	    $data['type']=$accou['type'];
	    $data['lastname']=$accou['lastname'];
	    $data['firstname']=$accou['firstname'];
	    $data['client_id']=$accou['client_id'];
	    $data['currency_id']=$accou['currency_id'];
	    $data['paytype']=$accou['paytype'];
	    $data['account_id']=$accou['id'];
	    $data['product_id']=$itemdetail['details']['product_id'];
	    $data['product_name']=$itemdetail['details']['product_name'];
	   $id= $this->insert('s_hostbill_Account_tmp',$data);    
   		$data['id']=$id;
   		return $data;
    }
    
    
    
    
    
    
    
    function importclinetTmp($page=0){
      $url = $this->url;  
   $post=array('task'=>'getCustomerlist','page'=>$page);
   
   $data=$this->hostbillcurl($post); 
   return $return = json_decode($data, true);
    
    }
 function getAccountlist($page=0){
   $url = $this->url;  
   $post=array('task'=>'getAccounts','page'=>$page); 
   $data=$this->hostbillcurl($post);
   return $return = json_decode($data, true);
    
    }
 function getproductsList(){
      $url = $this->url;  
   $post=array('task'=>'getProducts');

     $data=$this->hostbillcurl($post);
   return $return = json_decode($data, true);
    
    }
    
    function itemdetail($id){
      $url = $this->url;  
   $post=array('task'=>'getDomainDetails','id'=>$id);
     $data=$this->hostbillcurl($post);
   return $return = json_decode($data, true);
    }
    
  function HostbillgetProductDetails($id){
      $url = $this->url;  
   $post=array('task'=>'getProductDetails','id'=>$id);

     $data=$this->hostbillcurl($post);
   return $return = json_decode($data, true);
    }
    
  function HostbillgetServerDetails($id){
      $url = $this->url;  
   $post=array('task'=>'getServerDetails','id'=>$id);

   $data=$this->hostbillcurl($post);
   return $return = json_decode($data, true);
    }
 function HostbillgetAddonDetails($id){
      $url = $this->url;  
   $post=array('task'=>'getAddonDetails','id'=>$id);
 
     $data=$this->hostbillcurl($post);
   return $return = json_decode($data, true);
    }
    
function importPaymentTmp($page=0){
      $url = $this->url;  
   $post=array('task'=>'getPaymentlist','page'=>$page);   
   $data=$this->hostbillcurl($post); 
   return $return = json_decode($data, true);
    
    }
    
     function CheckHostbillcredencial(){
	   $url = $this->url;  
	   $post=array('task'=>'getHostBillversion');   
	   $data=$this->hostbillcurl($post);
	   return $return = json_decode($data, true);
    }
 /****************Product Import  *******************/

function getProductOrderGroup(){
   $url = $this->url;  
   $post=array('task'=>'getOrderPages');   
   $data=$this->hostbillcurl($post); 
   return $return = json_decode($data, true);
    
    }
    
  function getHostbullProductByGroup($id){
   $url = $this->url;  
   $post=array('task'=>'getProducts','id'=>$id);   
   $data=$this->hostbillcurl($post); 
   return $return = json_decode($data, true);
  }
		
    
}
