<?php


class mgt extends dbClass
{
	//constructor
	function mgt()
	{
		$this->dbClass();
	} 
		
		
	
	
	
function MagentoImportOrders(){

$result  = $this->httpGetWithErros('https://www.eoptionsonline.com/service/api.php');

$orders  = json_decode($result);

if(count($orders)>0 && is_object($orders)){
	
	//echo  "<pre>";print_r($orders->result);die;
	foreach($orders->result as $order){
	      $this->importOrder($order);
	
	}
}
}	
	
	
	

function httpGetWithErros($url)
{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
 
    $output=curl_exec($ch);
 
    if($output === false)
    {
        echo "Error Number:".curl_errno($ch)."<br>";
        echo "Error String:".curl_error($ch);
    }
    curl_close($ch);
	
    return $output;
}	
	
function importOrder($order) {
	
	//echo  "<pre>";print_r($order);
	///echo $order->data->orderId;
	//die;
	$orderitem  =  count($order->item);
	 $data = array(
				'OrderType' 		   => 'Magento',
				'AmazonOrderId'        => $order->data->orderId,
				'OrderStatus'          => $order->data->Status,
				'SellerChannel'		   => 'magento',
				'AmazonAccountID'	   => '',
				'PaymentStatus'	       => 1,
				'TotalPrice'           =>  $order->data->baseGrandTotal,
				'Currency'             => $order->data->CurrencyCode,
				'Email'         	   => $order->data->customerEmail,
				'PaymentGateway'        => $order->data->payment_method,
				'PaymentGatewayID'        => $order->data->payment_method,
				'OrderDate'            => $order->data->CreatedAt,
				'OrderComplatedDate'   => $order->data->CreatedAt,
				'ShippingMethod'	   => $order->data->ShippingMethod,
				'Phone'			   	   => $order->data->phone,
				'DelivaryDate'		   => '',
				'TotalQuantity' 	   => $orderitem
			);
		
			if(is_object($order->shippingAddress)){
				$data['ShippingName'] = addslashes($order->shippingAddress->firstname.' '.$order->shippingAddress->lastname);
				$data['ShippingCompany'] = addslashes($order->shippingAddress->company);
				$data['ShippingAddress'] = addslashes($order->shippingAddress->street);
				$data['ShippingCity'] = addslashes($order->shippingAddress->city);
				$data['ShippingState'] = addslashes($order->shippingAddress->region);
				$data['ShippingCountry'] = addslashes($order->shippingAddress->country_id);
				$data['ShippingZip'] = addslashes($order->shippingAddress->postcode);
				$data['ShippingPhone'] = addslashes($order->shippingAddress->telephone);		
			}
			
			if(is_object($order->billingaddress)){
				$data['BillingName'] = addslashes($order->billingaddress->firstname);
				$data['BillingCompany'] = addslashes($order->shippingAddress->company);
				$data['BillingAddress'] = addslashes($order->shippingAddress->street);
				$data['BillingCity'] = addslashes($order->shippingAddress->city);
				$data['BillingState'] = addslashes($order->shippingAddress->region);
				$data['BillingCountry'] = addslashes($order->shippingAddress->country_id);
				$data['BillingZip'] = addslashes($order->shippingAddress->postcode);
			}
			
			//$orderExistance = $this->order_id_exists($order->data->orderId);
			
			 # Remove pending order and insert the same order with new data
			$orderExistance = $this->order_id_exists( $order->data->orderId);
			if(!empty($orderExistance['OrderID'])){
				$this->deleteSyncOrder($orderExistance['OrderID']);
				$data['OrderID'] = $orderExistance['OrderID'];
				$orderExistance['OrderID']=false;
			}
		
		    $data['Shipping'] = $order->data->shippingAmount;
			$data['DiscountAmount'] = $order->data->DiscountTotal;
			$data['Tax'] = $order->data->taxAmount;
			$data['SubTotalPrice'] = $order->data->subtotal;
			 
				 // save order
				 $this->saveAmazonOrder($data);
			     $orderId = $this->lastInsertId();
				 
				 // insertOrder item 
				 foreach ($order->item as $item) {
						$success = $this->processAmazonListingItem( $item, $orderId);
						
					}
				 
				
				 if($orderId){
					
					# Sync amazon orders directaly into sales orders
					$this->SyncAmazonOrderInSalesOrder($data, $orderId);
				}
 }
 
function saveAmazonOrder($arryDetails){
	  $fields = join(',',array_keys($arryDetails));
      $values = join("','",array_values($arryDetails));
      $strSQLQuery = "insert into e_orders ($fields)  values('" .$values."')"; 
      $this->query($strSQLQuery, 0);
      
	}	
	
function processAmazonListingItem($arryRow, $OrderID){
               
            $Price = $arryRow->price;
            $ProductID = 0;
            $OrderItemId = $arryRow->product_id;
            $ProductName = addslashes($arryRow->name);
            $Quantity = $arryRow->QtyOrdered;
            $ProductOptions = '';
            $TaxRate = 0;
            $TaxDescription = 'All taxes are included (itemtax, ShippingTax, GiftWrapTax)';
            $AmazonSku = addslashes($arryRow->sku);
           // $ASIN	   = addslashes($arryRow->ASIN);

            $strSQLQuery = "insert into e_orderdetail(OrderID,ProductID,ProductName,ProductOptions,Quantity ,Price, TaxRate, TaxDescription, AmazonSku, ASIN, OrderItemId) values('" . $OrderID . "','" . $ProductID . "','" . addslashes($ProductName) . "', '" . addslashes($ProductOptions) . "', '" . $Quantity . "', '" . $Price . "', '" . $TaxRate . "', '" . addslashes($TaxDescription) . "', '".$AmazonSku."', '".$ASIN."', '".$OrderItemId."')"; 
            $this->query($strSQLQuery, 0);	
	
}

 function SyncAmazonOrderInSalesOrder($data, $OrderID){
    global $Config;

	$listName = $this->split_name($data['ShippingName']);

	$sql = "select count(*) as total,Cid, Email, FirstName, LastName, Phone, Company from e_customers where Email='" . addslashes($data['Email']) . "' ";
	$res = $this->query($sql, 1);
	
	
	$cust = array();


        if($res['0']['total'] == '0') {
		$cust['Email'] = addslashes($data['Email']);
		$cust['Phone'] = addslashes($data['Phone']);
		$cust['Company'] = addslashes($data['ShippingName']);			
		$cust['FirstName'] = addslashes($listName[0]);
		$cust['LastName'] = addslashes($listName[1]);
		$cust['Address1'] = addslashes($data['BillingAddress']);
		$cust['City']     = addslashes($data['BillingCity']);
		$cust['State']    = addslashes($data['BillingState']);
		$cust['Country']  = addslashes($data['BillingCountry']);
		$cust['ZipCode']  = addslashes($data['BillingZip']);
		
		$cust['ShippingName'] = addslashes($data['ShippingName']);
		$cust['ShippingCompany'] = addslashes($data['ShippingName']);
		$cust['ShippingAddress1'] = addslashes($data['ShippingAddress']);
		$cust['ShippingCity'] = addslashes($data['ShippingCity']);
		$cust['ShippingState'] = addslashes($data['ShippingState']);
		$cust['ShippingCountry'] = addslashes($data['ShippingCountry']) ;
		$cust['ShippingZip'] = addslashes($data['ShippingZip']) ;
		$cust['ShippingPhone'] = addslashes($data['ShippingPhone']) ;
		
		$cust['Removed'] = 'No';
		$cust['CreatedDate'] = mysql_real_escape_string($Config['TodayDate']);
		$cust['LastUpdate'] = mysql_real_escape_string($Config['TodayDate']);
		$cust['Status'] = 'Yes';
		
		$fields = join(',',array_keys($cust));
		$values = join("','",array_values($cust));
		$strSQLQuery = "INSERT INTO e_customers($fields) values('" .$values."')";
		$this->query($strSQLQuery);
		$CustID = $this->lastInsertId();
		
		$sql2 = "update e_orders set Cid='".$CustID."' where AmazonOrderId='".$data['AmazonOrderId']."'";
		$this->query($sql2);

		}else{
			$cust['Email']     = $res['0']['Email'];
            $cust['FirstName'] = $res['0']['FirstName'];
            $cust['LastName']  = $res['0']['LastName'];
            $cust['Phone']     = $res['0']['Phone'];
            $cust['Company']   = $res['0']['Company'];
	    	$cust['ShippingAddress1'] =  $res['0']['ShippingAddress1'];
            $cust['ShippingCity']     =  $res['0']['ShippingCity'];
            $cust['ShippingState']    =  $res['0']['ShippingState'];
	    	$cust['ShippingCountry']  =  $res['0']['ShippingCountry'] ;
	    	$cust['ShippingZip']      =  $res['0']['ShippingZip'] ;

			$sql2 = "update e_orders set Cid='".$res['0']['Cid']."' where AmazonOrderId='".$data['AmazonOrderId']."'";
			$this->query($sql2);

		}
	
		#Insert only for valid users
		if(!($data['OrderStatus']=='Pending' || $data['OrderStatus']=='Cancelled' || $data['OrderStatus']=='Active')){
		    $this->sync_order_in_sales($OrderID, $cust);
		}
    }

	function split_name($name) {
		list($first_name, $last_name) = explode(' ', $name,2);
		return array($first_name, $last_name);
	}

 	function sync_order_in_sales($OrderID,$arryCustDetails) {
    	global $Config;
        if ($OrderID != '') {

           $sql = "SELECT o.* FROM e_orders as o
			where o.OrderID='" . addslashes($OrderID) . "' ";
            $orderres = $this->query($sql, 1);

          list($CustID, $CustCode, $CustomerName, $CustomerCompany) = $this->sync_customer_in_sales($arryCustDetails);
	    
	   if($orderres['0']['Currency'] != $Config['Currency']){  
                //$ConversionRate = CurrencyConvertor(1,$orderres['0']['Currency'],$Config['Currency'],'AR',$orderres['0']['OrderDate']);
                            $ConversionRate='';
			}else{   
                $ConversionRate=1;
            }

            $SqlOrder = "INSERT INTO s_order SET
			OrderDate = '" . addslashes($orderres['0']['OrderDate']) . "',
			Module = 'Order',
			CustID = '" . addslashes($CustID) . "',
			CustCode = '" . addslashes($CustCode) . "',
			CustomerCurrency = '" . addslashes($orderres['0']['Currency']) . "',
			Status = 'Open',
			Approved = '1',
			OrderPaid = '1',
			DeliveryDate = '" . addslashes($orderres['0']['DelivaryDate']) . "',
			PaymentMethod = '" . addslashes($orderres['0']['PaymentGateway']) . "',			
			TotalAmount = '" . addslashes($orderres['0']['TotalPrice']) . "',
			CustomerName = '" . addslashes($CustomerName) . "',
			CustomerCompany = '" . addslashes($orderres['0']['BillingName']) . "',
			BillingName = '" . addslashes($orderres['0']['BillingName']) . "',
			Address = '" . addslashes($orderres['0']['BillingAddress']) . "',
			City = '" . addslashes($orderres['0']['BillingCity']) . "',
			State = '" . addslashes($orderres['0']['BillingState']) . "',
			Country = '" . addslashes($orderres['0']['BillingCountry']) . "',
			ZipCode = '" . addslashes($orderres['0']['BillingZip']) . "',
			Mobile = '" . addslashes($orderres['0']['Phone']) . "',
			Email = '" . addslashes($orderres['0']['Email']) . "',
			ShippingName = '" . addslashes($orderres['0']['ShippingName']) . "',
			ShippingCompany = '" . addslashes($orderres['0']['ShippingCompany']) . "',
			ShippingAddress = '" . addslashes($orderres['0']['ShippingAddress']) . "',
			ShippingCity = '" . addslashes($orderres['0']['ShippingCity']) . "',
			ShippingState = '" . addslashes($orderres['0']['ShippingState']) . "',
			ShippingCountry = '" . addslashes($orderres['0']['ShippingCountry']) . "',
			ShippingZipCode = '" . addslashes($orderres['0']['ShippingZip']) . "',			
			ShippingMobile = '" . addslashes($orderres['0']['ShippingPhone']) . "',
			discountAmnt = '" . addslashes($orderres['0']['DiscountAmount']) . "',
			tax_auths = 'Yes',
			taxAmnt = '" . addslashes($orderres['0']['Tax']) . "',
			SalesPersonID = '" . addslashes($Config['CmpID']) . "',
			AdminID = '" . addslashes($Config['CmpID']) . "',
			CustomerPO = '" . addslashes($orderres['0']['AmazonOrderId']) . "',
			OrderSource = '" . addslashes($orderres['0']['OrderType']) . "',
			Freight = '" . addslashes($orderres['0']['Shipping']) . "',
			ConversionRate = '" . addslashes($ConversionRate) . "',
			ecom_order_id = '" . addslashes($OrderID) . "',
			EntryBy = 'C' ";

            $this->query($SqlOrder, 0);
 
            $saleorderId = $this->lastInsertId();
            $SaleID = 'SO000' . $saleorderId;
            $sql = "update s_order set SaleID = '" . mysql_real_escape_string($SaleID) . "'
			 where OrderID='" . addslashes($saleorderId) . "'";
            $this->query($sql, 0);

           $sql = "SELECT od.OrderItemId as ProductID, od.AmazonSku as ProductSku, od.ProductName, od.Quantity, od.Price, od.TaxRate FROM e_orderdetail as od where od.OrderID='" . addslashes($OrderID) . "' ";
            $orderitemsres = $this->query($sql, 1);
            
            for ($count = 0; $count < count($orderitemsres); $count++) {
		
				$refid = 0;
				if(!is_numeric($orderitemsres[$count]['ProductID'])){
					$itemID = explode("-", $orderitemsres[$count]['ProductID']);
					$orderitemsres[$count]['ProductID'] = $itemID[0];
					$refid = $itemID[1];
				}	
		
             $SqlOrderitem = "INSERT INTO s_order_item SET
			OrderID = '" . addslashes($saleorderId) . "',
			item_id = '" . addslashes($orderitemsres[$count]['ProductID']) . "',
			sku = '" . addslashes($orderitemsres[$count]['ProductSku']) . "',
			description = '" . addslashes($orderitemsres[$count]['ProductName']) . "',
			qty = '" . addslashes($orderitemsres[$count]['Quantity']) . "',		
			price = '" . addslashes($orderitemsres[$count]['Price']) . "',			
			amount = '" . addslashes($orderitemsres[$count]['Price']*$orderitemsres[$count]['Quantity']) . "',
			Taxable = 'Yes',
			ref_id = '".$refid."',
			tax = '" . addslashes($orderitemsres[$count]['TaxRate']) . "' ";
            
            $this->query($SqlOrderitem, 0);

			# Sync inventory;
			$this->syncInventoryAndUpdatePrice($orderitemsres[$count]['ProductSku'],$orderitemsres[$count]['Quantity']);

            }
        }
    }

    function sync_customer_in_sales($arryDetails) {
        @extract($arryDetails);
        global $Config;

        /* check email exist or not if exit return sales customer id
         * or insert customer and return inserted customer id		 *
         */
	$str = '';
	if(!empty($Phone)) { $str = " and Mobile='".addslashes($Phone)."' "; }
	$sql = "select count(*) as total,Cid,CustCode,FullName,Company from s_customers where FirstName='" . addslashes($FirstName) . "' and LastName='" . addslashes($LastName) . "' $str ";
        $res = $this->query($sql, 1);
	
        if ($res['0']['total'] == '0') {
            // add new
            $ipaddress = '';
            $FullName = $FirstName . ' ' . $LastName;

            $SqlCustomer = "INSERT INTO s_customers SET
			CustomerType = 'Individual', 
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FirstName='" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "', 
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "', 
			Gender = 'Male', 
			 
			Mobile = '" . mysql_real_escape_string($Phone) . "', 
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "', 
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "', 
			CustomerSince = '" . mysql_real_escape_string($Config['TodayDate']) . "', 
			ipaddress = '" . $ipaddress . "', 
			Status='Yes' ";

            $this->query($SqlCustomer, 0);



            $customerId = $this->lastInsertId();

            $CustCode = 'CUST00' . $customerId;

            $sql = "update s_customers set CustCode = '" . mysql_real_escape_string($CustCode) . "'
			 where Cid='" . addslashes($customerId) . "'";
            $this->query($sql, 0);

			   #save other details into address book
			   $this->insertToAddressBook($arryDetails,$customerId);
		
            return array($customerId, $CustCode, $FullName, $Company);
        } else {
            return array($res['0']['Cid'], $res['0']['CustCode'], $res['0']['FullName'], $res['0']['Company']);
        }
    }
	
	
 /*---------------------------*/
	function  GetStatebyID($name)
	{
		$strSQLQuery = "select state_id from erp.state where  LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'";
		return $this->query($strSQLQuery, 1);
	}

	function  GetCitybyID($name)
	{
		$strSQLQuery = "select city_id from erp.city where LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'";
		return $this->query($strSQLQuery, 1);
	}


        function getCountryByName($name)
	{
            $sql="select country_id from erp.country where LCASE(name) = '".mysql_real_escape_string(strtolower(trim($name)))."' ";
            return $this->query($sql);
	} 
    /*---------------------------*/
	
	
     function insertToAddressBook($Data, $CustID){
		global $Config;
		extract($Data);

		$city = $this->GetCitybyID($ShippingCity);
		$state = $this->GetStatebyID($ShippingState);
		$country = $this->getCountryByName($ShippingCountry);

		 $FullName = $FirstName . ' ' . $LastName;

		if($CustID):
			$SqlCustomer = "INSERT INTO s_address_book SET
			CustID = '".$CustID."',
			AddType = 'billing',
			PrimaryContact = '1',
			FirstName = '" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "',
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "',
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "',

			Address = '" . mysql_real_escape_string(strip_tags($ShippingAddress1)) . "',
			CountryName = '" . mysql_real_escape_string(strip_tags($ShippingCountry)) . "',
			StateName = '" . mysql_real_escape_string(strip_tags($ShippingState)) . "',
			CityName = '" . mysql_real_escape_string(strip_tags($ShippingCity)) . "',

			country_id = '" . mysql_real_escape_string(strip_tags($country[0]['country_id'])) . "',
			state_id = '" . mysql_real_escape_string(strip_tags($state[0]['state_id'])) . "',
			city_id = '" . mysql_real_escape_string(strip_tags($city[0]['city_id'])) . "',

			ZipCode = '" . mysql_real_escape_string(strip_tags($ShippingZip)) . "',
			Mobile = '" . mysql_real_escape_string(strip_tags($Phone)) . "',
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "',
			UpdatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "' 
			";
			$this->query($SqlCustomer, 0);
		
			$SqlCustomer = "INSERT INTO s_address_book SET
			CustID = '".$CustID."',
			AddType = 'shipping',
			PrimaryContact = '1',
			FirstName = '" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "',
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "',
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "',

			Address = '" . mysql_real_escape_string(strip_tags($ShippingAddress1)) . "',
			CountryName = '" . mysql_real_escape_string(strip_tags($ShippingCountry)) . "',
			StateName = '" . mysql_real_escape_string(strip_tags($ShippingState)) . "',
			CityName = '" . mysql_real_escape_string(strip_tags($ShippingCity)) . "',

			country_id = '" . mysql_real_escape_string(strip_tags($country[0]['country_id'])) . "',
			state_id = '" . mysql_real_escape_string(strip_tags($state[0]['state_id'])) . "',
			city_id = '" . mysql_real_escape_string(strip_tags($city[0]['city_id'])) . "',

			ZipCode = '" . mysql_real_escape_string(strip_tags($ShippingZip)) . "',
			Mobile = '" . mysql_real_escape_string(strip_tags($Phone)) . "',
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "',
			UpdatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "' 
			";
			$this->query($SqlCustomer, 0);
			
		endif;
	}

	 function syncInventoryAndUpdatePrice($sku, $quantity){
			global $Config;
				
			$sql = "select * from amazon_items where ProductSku ='".$sku."'";
			$data = $this->query($sql,1);

			if(!empty($data)){ 
				$finalQnt = $data[0]['Quantity'] - $quantity;
				$finalQnt = ($finalQnt>=0) ? $finalQnt : 0 ;
				$updateamazontSql = "update amazon_items set Quantity='".$finalQnt."' where ProductSku ='".$sku."'";
				$this->query($updateamazontSql,0);
			}
				
			$invsql = "select qty_on_hand from inv_items where Sku ='".$sku."' ";
			$exist = $this->query($invsql,1);
			#for Alias items check			
			if(empty($exist)){
				$invsql = "SELECT ii.* FROM `inv_item_alias` iia INNER JOIN inv_items ii on(iia.item_id=ii.ItemID) where iia.ItemAliasCode='".$sku."' ";
				$exist = $this->query($invsql,1);
				if(!empty($exist[0]['Sku'])) {
					$sku = $exist[0]['Sku'];
				}
			}

			if(!empty($exist)){ 
				$finalQnt1 = $exist[0]['qty_on_hand'] - $quantity;
				$finalQnt1 = ($finalQnt1>=0) ? $finalQnt1 : 0 ;
				$invsql = "update inv_items set qty_on_hand= '".$finalQnt1."' where Sku ='".$sku."' ";
				$this->query($invsql,0);
				
				$invConsql = "update inv_item_quanity_condition set condition_qty= '".$finalQnt1."' where Sku ='".$sku."' ";
				$this->query($invConsql,0);
			}else{
				
				if(empty($data)){ 
					$sql = "select * from e_products where ProductSku ='".$sku."'";
					$data = $this->query($sql,1);
					if(!empty($data)){ 
						$data[0]['Channel'] = 'e-commerce';
						$data[0]['ItemCondition'] = '';
						$data[0]['ItemConditionNote'] = $data[0]['Detail'];
						$data[0]['LastUpdateDate'] = $data[0]['AddedDate'];
						$data[0]['pid'] = $data[0]['ProductID'];
							
						$finalQnt = $data1[0]['Quantity'] - $quantity;
						$finalQnt = ($finalQnt>=0) ? $finalQnt : 0 ;
						$updatetSql = "update e_products set Quantity='".$quantity."' where ProductSku ='".$sku."'";
						$this->query($updatetSql,0);
					}
				}
		
				if(!empty($data)){  
					$split = explode('.',$data[0]['Channel']);
					$insert = "insert into inv_items SET
							   Sku = '".addslashes($data[0]['ProductSku'])."',
							   description = '".addslashes($data[0]['Name'])."',
							   `Condition` = '".addslashes($data[0]['ItemCondition'])."',
							   qty_on_hand = '".$finalQnt."',
							   sell_price = '".$data[0]['Price']."',
							   `Status` = '1',
							   AddedDate = '".$data[0]['LastUpdateDate']."',
							   AdminType = 'admin',
							   CreatedBy = 'admin',
							   long_description = '".addslashes($data[0]['ItemConditionNote'])."',
							   product_source = '".$split[0]."',
							   ref_id = '".$data[0]['pid']."'
							";
					$this->query($insert,0);
					
					if($lastID = $this->lastInsertId()){
						$insertCon = "insert into inv_item_quanity_condition SET
								   ItemID = '".$lastID."',
								   `condition` = '".addslashes($data[0]['ItemCondition'])."',
								   Sku = '".addslashes($data[0]['ProductSku'])."',
								   type = 'Sales',
								   condition_qty = '".$finalQnt."',
								   AvgCost = '".$data[0]['Price']."'
								";
						$this->query($insertCon,0);
					}
				}
			}
			# for update quantity while updating amazon qnt
			#updateTableQntPrice()
			
			
			
	 }

	 
	function order_id_exists($OrderID) {
		$strSQLQuery = "select OrderID, OrderStatus from e_orders where AmazonOrderId = '".trim($OrderID)."' ";

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['OrderID'])) {
		return array('OrderID'=>$arryRow[0]['OrderID'],'OrderStatus'=>$arryRow[0]['OrderStatus']);
		} else {
		return false;
		}
	}
			
			
			
	function deleteSyncOrder($oid)
	{
		$strSQLQuery = "DELETE FROM e_orders WHERE OrderID = '".mysql_real_escape_string($oid)."'";
		$this->query($strSQLQuery, 0);
		$strSQLQuery = "DELETE FROM e_orderdetail WHERE OrderID = '".mysql_real_escape_string($oid)."'";
		$this->query($strSQLQuery, 0);
	}	
			
			
	function Getdata($action){

        $strSQLQuery = "select * from site_setting where action = '".trim($action)."' ";
		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow;

	}	
			
			
			
	function adddata($arryDetails){
		
		$data =  base64_encode(serialize(array('SiteUrl'=>$arryDetails['SiteUrl'],'status'=>$arryDetails['status'])));
		$action =  'magneto_setting';
		
		$strSQLQuery ="insert into site_setting set data ='" . $data. "',
                                                    action = '".$action."'";
		
		
		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;
		
	}
	
	function updatedata($arryDetails){
		$data =  base64_encode(serialize(array('SiteUrl'=>$arryDetails['SiteUrl'],'status'=>$arryDetails['status'])));
		
		$strSQLQuery ="update site_setting set data ='" . $data. "' where action = 'magneto_setting'";
		$this->query($strSQLQuery, 0);
	}	

}
?>