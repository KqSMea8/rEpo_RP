<?php

class order extends dbClass
{
	//constructor
	function order()
	{
		$this->dbClass();
	} 
		
		
		
	function getOrderList($where=array()){
		
		$type =  $where['type'];
		$whereData ="where 1";
		$whereData  .= " and orders.vendor_id='".$where['vendor_id']."'";
		
		switch($type){
			case 'day':
			if(!empty($where['startdate'])){
		
			   if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
			   }else{
				   $startTime   = '00:00'; 
				   
			   }
			   
			   $startDateTime =  date('Y-m-d',strtotime($where['startdate']))." ".$startTime;
		       $whereData .=" and orders.date_order>='".$startDateTime."'";
			
		    }else{
				  if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
				   }else{
					   $startTime   = '00:00'; 
					   
			      } 
				  $startDateTime =  date('Y-m-d')." ".$startTime;
		          $whereData .=" and orders.date_order>='".$startDateTime."'";
				
				
			}
		
			if(!empty($where['enddate'])){
				   if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
				  $endDateTime =  date('Y-m-d',strtotime($where['enddate']))." ".$enddTime; 
			   $whereData .=" and orders.date_order<='".$endDateTime."'";
				
			}else{
				 if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
                $endDateTime =  date('Y-m-d')." ".$enddTime; 
			    $whereData .=" and orders.date_order<='".$endDateTime."'";
				
				
			}
			
			break;
			
			case 'month':
			if(!empty($where['startdate'])){
			   $startDateTime =  date('m-Y',strtotime($where['startdate']));
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%m-%Y\")='".$startDateTime."'";
			   
		    }
		
			break;
			
			
			case 'year':
			if(!empty($where['startdate'])){


			  $startDateTime =  trim($where['startdate']);
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%Y\")='".$startDateTime."'";
			   
		    }
			
			break;
			
		}
	
		$strSQLQuery =  "select a.*,(sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))) as gross,
		sum(a.item_quantity)as quantity, sum(a.item_discount_price)+a.order_discount_price as discount, 
		sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))- sum(a.item_discount_price)-a.order_discount_price +sum(a.item_total_tax_price)+a.order_total_tax_price as net,sum(a.item_total_tax_price)+a.order_total_tax_price as tax,sum(item_total_include_tax_price)+order_total_include_tax_price as include_tax
		from (select orders.order_id, sum(DISTINCT item.product_price)as item_price, sum(modifiers.modifiers_product_price)as modifiers_price, sum(DISTINCT item.quantity) as item_quantity,sum(DISTINCT item.item_discount_price) as item_discount_price,orders.order_discount_price as order_discount_price,sum(DISTINCT item.item_total_tax_price) as item_total_tax_price,orders.order_total_tax_price,sum(DISTINCT item.item_total_include_tax_price) as item_total_include_tax_price,orders.order_total_include_tax_price
		from pos_order as orders left join pos_order_item as item on orders.order_id=item.order_id left join pos_order_item_modifiers as modifiers on item.order_item_id=modifiers.order_item_id ".$whereData." GROUP BY item.order_item_id ) as a GROUP by order_id";
		

		$result =  $this->query($strSQLQuery, 1);
		return $result;

	}	
	
	
	function getOrderListbyOrderType($where=array()){
		
		$type =  $where['type'];
		$whereData ="where 1";
		$whereData  .= " and orders.vendor_id='".$where['vendor_id']."'";
		
		switch($type){
			case 'day':
			if(!empty($where['startdate'])){
		
			   if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
			   }else{
				   $startTime   = '00:00'; 
				   
			   }
			   
			   $startDateTime =  date('Y-m-d',strtotime($where['startdate']))." ".$startTime;
		       $whereData .=" and orders.date_order>='".$startDateTime."'";
			
		    }else{
				  if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
				   }else{
					   $startTime   = '00:00'; 
					   
			      } 
				  $startDateTime =  date('Y-m-d')." ".$startTime;
		          $whereData .=" and orders.date_order>='".$startDateTime."'";
				
				
			}
		
			if(!empty($where['enddate'])){
				   if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
				  $endDateTime =  date('Y-m-d',strtotime($where['enddate']))." ".$enddTime; 
			   $whereData .=" and orders.date_order<='".$endDateTime."'";
				
			}else{
				 if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
                $endDateTime =  date('Y-m-d')." ".$enddTime; 
			    $whereData .=" and orders.date_order<='".$endDateTime."'";
				
				
			}
			
			break;
			
			case 'month':
			if(!empty($where['startdate'])){
			   $startDateTime =  date('m-Y',strtotime($where['startdate']));
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%m-%Y\")='".$startDateTime."'";
			   
		    }
		
			break;
			
			
			case 'year':
			if(!empty($where['startdate'])){


			  $startDateTime =  trim($where['startdate']);
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%Y\")='".$startDateTime."'";
			   
		    }
			
			break;
			
		}
	
		$strSQLQuery =  "select  sum(b.gross)as gross, sum(b.quantity) as quantity, sum(b.discount) as discount, sum(b.net) as net, sum(b.tax) as tax, sum(b.include_tax) as include_tax,b.order_type from (select a.*,(sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))) as gross,
		sum(a.item_quantity)as quantity, sum(a.item_discount_price)+a.order_discount_price as discount, 
		sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))- sum(a.item_discount_price)-a.order_discount_price +sum(a.item_total_tax_price)+a.order_total_tax_price as net,sum(a.item_total_tax_price)+a.order_total_tax_price as tax,sum(item_total_include_tax_price)+order_total_include_tax_price as include_tax
		from (select orders.order_id,orders.order_type, sum(DISTINCT item.product_price)as item_price, sum(modifiers.modifiers_product_price)as modifiers_price, sum(DISTINCT item.quantity) as item_quantity,sum(DISTINCT item.item_discount_price) as item_discount_price,orders.order_discount_price as order_discount_price,sum(DISTINCT item.item_total_tax_price) as item_total_tax_price,orders.order_total_tax_price,sum(DISTINCT item.item_total_include_tax_price) as item_total_include_tax_price,orders.order_total_include_tax_price
		from pos_order as orders left join pos_order_item as item on orders.order_id=item.order_id left join pos_order_item_modifiers as modifiers on item.order_item_id=modifiers.order_item_id ".$whereData." GROUP BY item.order_item_id ) as a GROUP by order_id) as b group by order_type";
		
	

		$result =  $this->query($strSQLQuery, 1);
		return $result;

	}	

	function getOrderListbyOrderServer($where=array()){
		
		$type =  $where['type'];
		$whereData ="where 1";
		$whereData  .= " and orders.vendor_id='".$where['vendor_id']."'";
		
		switch($type){
			case 'day':
			if(!empty($where['startdate'])){
		
			   if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
			   }else{
				   $startTime   = '00:00'; 
				   
			   }
			   
			   $startDateTime =  date('Y-m-d',strtotime($where['startdate']))." ".$startTime;
		       $whereData .=" and orders.date_order>='".$startDateTime."'";
			
		    }else{
				  if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
				   }else{
					   $startTime   = '00:00'; 
					   
			      } 
				  $startDateTime =  date('Y-m-d')." ".$startTime;
		          $whereData .=" and orders.date_order>='".$startDateTime."'";
				
				
			}
		
			if(!empty($where['enddate'])){
				   if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
				  $endDateTime =  date('Y-m-d',strtotime($where['enddate']))." ".$enddTime; 
			   $whereData .=" and orders.date_order<='".$endDateTime."'";
				
			}else{
				 if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
                $endDateTime =  date('Y-m-d')." ".$enddTime; 
			    $whereData .=" and orders.date_order<='".$endDateTime."'";
				
				
			}
			
			break;
			
			case 'month':
			if(!empty($where['startdate'])){
			   $startDateTime =  date('m-Y',strtotime($where['startdate']));
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%m-%Y\")='".$startDateTime."'";
			   
		    }
		
			break;
			
			
			case 'year':
			if(!empty($where['startdate'])){


			  $startDateTime =  trim($where['startdate']);
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%Y\")='".$startDateTime."'";
			   
		    }
			
			break;
			
		}
	
		$strSQLQuery =  "select  sum(b.gross)as gross, sum(b.quantity) as quantity, sum(b.discount) as discount, sum(b.net) as net, sum(b.tax) as tax, sum(b.include_tax) as include_tax,b.server_id,b.server_name from (select a.*,(sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))) as gross,
		sum(a.item_quantity)as quantity, sum(a.item_discount_price)+a.order_discount_price as discount, 
		sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))- sum(a.item_discount_price)-a.order_discount_price +sum(a.item_total_tax_price)+a.order_total_tax_price as net,sum(a.item_total_tax_price)+a.order_total_tax_price as tax,sum(item_total_include_tax_price)+order_total_include_tax_price as include_tax
		from (select orders.order_id,orders.server_id, sum(DISTINCT item.product_price)as item_price, sum(modifiers.modifiers_product_price)as modifiers_price, sum(DISTINCT item.quantity) as item_quantity,sum(DISTINCT item.item_discount_price) as item_discount_price,orders.order_discount_price as order_discount_price,sum(DISTINCT item.item_total_tax_price) as item_total_tax_price,orders.order_total_tax_price,sum(DISTINCT item.item_total_include_tax_price) as item_total_include_tax_price,orders.order_total_include_tax_price,concat(FirstName,' ',LastName) as server_name
		from pos_order as orders left join pos_order_item as item on orders.order_id=item.order_id left join pos_order_item_modifiers as modifiers on item.order_item_id=modifiers.order_item_id left join e_customers as customers on customers.Cid=orders.server_id
		".$whereData." GROUP BY item.order_item_id ) as a GROUP by order_id) as b group by server_id";
		
	

		$result =  $this->query($strSQLQuery, 1);
		return $result;

	}	


	
  function getOrderDetails($where=array()){	
	    $whereData ="where 1";
		$whereData  .= " and orders.vendor_id='".$where['vendor_id']."'";
		$whereData  .= " and orders.order_id='".$where['order_id']."'";
	
	$strSQLQuery =  "select orders.*,item.*,concat(customers.FirstName,' ',customers.LastName) as serverName from pos_order as orders 
left join pos_order_item as item on orders.order_id=item.order_id 
left join  e_customers as customers on orders.server_id=customers.Cid ".$whereData."";
	$result =  $this->query($strSQLQuery, 1);
	$arrayresult =  array();
	if(count($result)>0){
		 foreach($result as $val){
			        $arrayresult[$val['product_id']][]= $val;
					$strSQLQuerymodifiers =  "select * from pos_order_item_modifiers where order_item_id='".$val['order_item_id']."'";
	                $resultmodifiers =  $this->query($strSQLQuerymodifiers, 1);
				   if(count($resultmodifiers)>0){
						   foreach($resultmodifiers as $modifiers){
								 if(!empty($modifiers['modifiers_id'])){
									 $arrayresult[$val['product_id']]['modifiers'][]=$modifiers;
									 
								 }

						   }
				   }  
			 
		 }
		
	}


	return $arrayresult;
	
	}
		
		
	function getOrderListbyOrderItem($where=array()){
		
		$type =  $where['type'];
		$whereData ="where 1";
		$whereData  .= " and orders.vendor_id='".$where['vendor_id']."'";
		
		switch($type){
			case 'day':
			if(!empty($where['startdate'])){
		
			   if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
			   }else{
				   $startTime   = '00:00'; 
				   
			   }
			   
			   $startDateTime =  date('Y-m-d',strtotime($where['startdate']))." ".$startTime;
		       $whereData .=" and orders.date_order>='".$startDateTime."'";
			
		    }else{
				  if(!empty($where['startTime'])){
				   $startTime   = trim($where['startTime']); 
				   }else{
					   $startTime   = '00:00'; 
					   
			      } 
				  $startDateTime =  date('Y-m-d')." ".$startTime;
		          $whereData .=" and orders.date_order>='".$startDateTime."'";
				
				
			}
		
			if(!empty($where['enddate'])){
				   if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
				  $endDateTime =  date('Y-m-d',strtotime($where['enddate']))." ".$enddTime; 
			   $whereData .=" and orders.date_order<='".$endDateTime."'";
				
			}else{
				 if(!empty($where['enddTime'])){
					   $enddTime   = trim($where['enddTime']); 
				   }else{
					   $enddTime   = '59:59'; 
					   
				   }
                $endDateTime =  date('Y-m-d')." ".$enddTime; 
			    $whereData .=" and orders.date_order<='".$endDateTime."'";
				
				
			}
			
			break;
			
			case 'month':
			if(!empty($where['startdate'])){
			   $startDateTime =  date('m-Y',strtotime($where['startdate']));
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%m-%Y\")='".$startDateTime."'";
			   
		    }
		
			break;
			
			
			case 'year':
			if(!empty($where['startdate'])){


			  $startDateTime =  trim($where['startdate']);
		       $whereData .=" and DATE_FORMAT(orders.date_order, \"%Y\")='".$startDateTime."'";
			   
		    }
			
			break;
			
		}
	
		$strSQLQuery =  "select  sum(b.gross)as gross, sum(b.quantity) as quantity, sum(b.discount) as discount, sum(b.net) as net, sum(b.tax) as tax, sum(b.include_tax) as include_tax,b.product_name from (select a.*,(sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))) as gross,
		sum(a.item_quantity)as quantity, sum(a.item_discount_price) as discount, 
		sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))- sum(a.item_discount_price) +sum(a.item_total_tax_price)+a.order_total_tax_price as net,sum(a.item_total_tax_price)+a.order_total_tax_price as tax,sum(item_total_include_tax_price)+order_total_include_tax_price as include_tax
		from (select orders.order_id,item.product_name, sum(DISTINCT item.product_price)as item_price, sum(modifiers.modifiers_product_price)as modifiers_price, sum(DISTINCT item.quantity) as item_quantity,sum(DISTINCT item.item_discount_price) as item_discount_price,orders.order_discount_price as order_discount_price,sum(DISTINCT item.item_total_tax_price) as item_total_tax_price,orders.order_total_tax_price,sum(DISTINCT item.item_total_include_tax_price) as item_total_include_tax_price,orders.order_total_include_tax_price
		from pos_order as orders left join pos_order_item as item on orders.order_id=item.order_id left join pos_order_item_modifiers as modifiers on item.order_item_id=modifiers.order_item_id ".$whereData." GROUP BY item.product_name ,orders.order_id ) as a GROUP BY product_name) as b GROUP BY product_name";
		
		
		$result =  $this->query($strSQLQuery, 1);
		return $result;

	}		
		
	function getOrderListLatest($where=array()){
		
		$type =  $where['type'];
		$whereData ="where 1";
		$whereData  .= " and orders.vendor_id='".$where['vendor_id']."'";
		$strSQLQuery =  "select a.*,(sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))) as gross,
		sum(a.item_quantity)as quantity, sum(a.item_discount_price)+a.order_discount_price as discount, 
		sum(a.item_price)+(if(a.modifiers_price IS NULL,0,a.modifiers_price))- sum(a.item_discount_price)-a.order_discount_price +sum(a.item_total_tax_price)+a.order_total_tax_price as net,sum(a.item_total_tax_price)+a.order_total_tax_price as tax,sum(item_total_include_tax_price)+order_total_include_tax_price as include_tax
		from (select orders.order_id,orders.order_status, sum(DISTINCT item.product_price)as item_price, sum(modifiers.modifiers_product_price)as modifiers_price, sum(DISTINCT item.quantity) as item_quantity,sum(DISTINCT item.item_discount_price) as item_discount_price,orders.order_discount_price as order_discount_price,sum(DISTINCT item.item_total_tax_price) as item_total_tax_price,orders.order_total_tax_price,sum(DISTINCT item.item_total_include_tax_price) as item_total_include_tax_price,orders.order_total_include_tax_price
		from pos_order as orders left join pos_order_item as item on orders.order_id=item.order_id left join pos_order_item_modifiers as modifiers on item.order_item_id=modifiers.order_item_id ".$whereData." GROUP BY item.order_item_id order by orders.date_order DESC limit 0,10) as a GROUP by order_id";
		

		$result =  $this->query($strSQLQuery, 1);
		return $result;

	}	
	
	
	function getdashboardreport($where=array()){
		     $strSQLQueryOrders = "select * from pos_order where order_status='completed' and vendor_id='".$where['vendor_id']."'";
		     $resultOrders =  $this->query($strSQLQueryOrders, 1);
			 
			 $arrayReport  = array();
			 $arrayReport['orders'] = count($resultOrders);
			 
			$strSQLQueryIncome = "select sum(a.price) as totalPrice from (select sum(DISTINCT item.product_price)+sum(if(modifires.modifiers_product_price IS NULL,0,modifires.modifiers_product_price)) as price  from pos_order as orders 
			left join pos_order_item as item on item.order_id=orders.order_id
			left join pos_order_item_modifiers as modifires on modifires.order_item_id=item.order_item_id
			where orders.order_status='completed' and orders.vendor_id='".$where['vendor_id']."' GROUP by orders.order_id) as a";
		    $resultIncome =  $this->query($strSQLQueryIncome, 1);
			$arrayReport['totalPrice'] = $resultIncome[0]['totalPrice'];
			
			
			 $strSQLQueryServer = "select * from e_customers where custType in ('server','seniorserver') and Parent='".$where['vendor_id']."'";
		     $resultServer =  $this->query($strSQLQueryServer, 1);
			 $arrayReport['server'] = count($resultServer);
			 
			 
			$strSQLQueryCustomer = "select * from e_customers where custType = 'poscustomer' and Parent='".$where['vendor_id']."'";
			$resultCustomer =  $this->query($strSQLQueryCustomer, 1);
			$arrayReport['customer'] = count($resultCustomer);
				 
			 
		return $arrayReport;
		
	}
	
	function getAttendance($where=array()){
		
		
		$whereData ="where 1";
		$whereData  .= " and vendor_id='".$where['vendor_id']."'";
		$whereData  .= " and user_id='".$where['user_id']."'";
		if(!empty($where['month'])){
			$whereData  .= " and DATE_FORMAT(attendance_date, \"%m\")='".$where['month']."'";
		}else{
			$whereData  .= " and DATE_FORMAT(attendance_date, \"%m\")='".date('m')."'";
		}
		if(!empty($where['year'])){
			$whereData  .= " and DATE_FORMAT(attendance_date, \"%Y\")='".$where['year']."'";
		}else{
			$whereData  .= " and DATE_FORMAT(attendance_date, \"%Y\")='".date('Y')."'";
		}
		
		$strSQLQuery = "select * from pos_attendance ".$whereData."";
		$result =  $this->query($strSQLQuery, 1);
		echo "<pre>";print_r($result);die;
		return $result;
	}
	
	function getLastPunchinTime($where=array()){
		$whereData ="where 1";
		$whereData  .= " and vendor_id='".$where['vendor_id']."'";
		$whereData  .= " and user_id='".$where['user_id']."'";
		$whereData  .= " and type='".$where['type']."'";
		$whereData  .= " order by attendance_date DESC limit 0,1";
        
		$strSQLQuery = "select * from pos_attendance ".$whereData."";
		
		$result =  $this->query($strSQLQuery, 1);
		return $result;
	}
	
		
	function getvendorByCompnayID($where=array()){
		
		global $Config;
				$whereData ="where 1";
				$whereData  .= " and comId='".$where['cmpId']."'";
				$whereData  .= " and user_type='".$where['user_type']."'";
				$whereData  .= " and isvendor_admin='".$where['isvendor_admin']."'";
				$whereData .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				$companyuser = "select SQL_CALC_FOUND_ROWS id,pos.* from company_user_pos as pos ".$whereData."";
				$result =  $this->query($companyuser, 1);
				$resultCount =  "SELECT FOUND_ROWS() as totalCount";
				$resultCountNew =  $this->query($resultCount, 1);
				$finalarray = array('result'=>$result,'totalCount'=>$resultCountNew[0]['totalCount']);
			return $finalarray;

		}	
		
}
























?>