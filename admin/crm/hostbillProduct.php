<?php 	
	/**************************************************/
	$ThisPageName = 'hostbillProduct.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."lib/hostbillapi/class.hbwrapper.php");
	require_once($Prefix."classes/hostbill.class.php");
	require_once($Prefix."classes/item.class.php");
	
	
	$objEmployee=new employee();
	$objCustomer=new Customer();   // Sales Customer object
	
	$objhostbill=new hostbill();
	$objitems=new items();
	
	
	if(!empty($_GET['del_id'])){
	
		$del_id= (int) base64_decode($_GET['del_id']);
		if($del_id){
		
			$objhostbill->update('inv_items',array('product_source'=>'inventory','ref_id'=>''),array('ItemID'=>$del_id));
			$_SESSION['mess_phone']='delete successfully.';
				header('Location: hostbillProduct.php');
				exit;
		}
	
	}
	if(!empty($_POST)){
		if(!empty($_POST['pid']) AND !empty($_POST['hostbillpid'])){				
				$objhostbill->update('inv_items',array('product_source'=>'hostbill','ref_id'=>$_POST['hostbillpid']),array('ItemID'=>$_POST['pid']));
				$_SESSION['mess_phone']='Update successfully.';
				header('Location: hostbillProduct.php');
				exit;
			}
	
	}
	
	$products=$listproduct=$selectproduct=$assigneHostbillproduct=array();
	//$agents=$objphone->api('acl_users.php',array());	
	


	/**********Sales Customer**************/
	$assigneHostbillproduct=$hostbillproducts=array();
	$_GET['customColums']=' product_source , ref_id ';
	$products=$objitems->GetItemsView($_GET);
//	$customers=$objCustomer->getCustomers($_GET);
	//print_r($products);die('sdfsdf');
	if(!empty($products)){
			foreach($products as $product){
	
					if($product['product_source']=='inventory' OR empty($product['product_source'])){
						$selectproduct[$product['ItemID']]=$product['description'];					
					}else if($product['product_source']=='hostbill'){		
				
						$listproduct[$product['ItemID']]=array('description'=>$product['description'],'sku'=>$product['sku'],'ref_id'=>$product['ref_id']);
						$assigneHostbillproduct[]=$product['ref_id'];
					}
			
			}
	
	}
	/*************************/
	
	/**********Hostbill Temp Product**************/
	$selectHostaccount=$listHostaccount=array();
	$hostbillproducts=$objhostbill->GetProductFromTempAccount();
		if(!empty($hostbillproducts)){
				foreach($hostbillproducts as $k=>$Product){					
					if(!in_array($k,$assigneHostbillproduct)){
								$selectHostaccount[$k]=$Product;					
					}
				
					$listhostbillproduct[$k]=array('name'=>$Product);
				}
			}
	/*
	if(!empty($hostbillproducts['accounts'])){
			foreach($hostbillproducts['accounts'] as $Product){	

					if(!in_array($Product['id'],$assigneHostbillproduct)){
								$selectHostaccount[$Product['id']]=$Product['name'];					
					}						
						$listhostbillproduct[$Product['id']]=array('name'=>$Product['name']);
					
			
			}
	
	}*/
	
	//print_R($selectHostaccount);die;
	/*************************/
	
	
	
	
	
	
	/*  invoice synchronize date */
	
$sql="Select meta_value,meta_key,meta_date FROM s_hostbill_setting WHERE 1=1 AND meta_key='inventory_import_page'";
$synchronizedate=$objhostbill->query($sql);
//	print_R($Config['Url']);
	require_once("../includes/footer.php"); 	
?>


