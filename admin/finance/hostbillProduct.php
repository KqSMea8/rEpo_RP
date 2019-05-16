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
if(!empty($_GET['test'])){
	print_r($products);die('sdfsdf');
}
	if(!empty($products)){
			foreach($products as $product){
	
					if($product['product_source']=='inventory' OR empty($product['product_source'])){
						$selectproduct[$product['ItemID']]=$product['description'];					
					}else if($product['product_source']=='hostbill'){		
				
						$listproduct[$product['ItemID']]=array('description'=>$product['description'],'sku'=>$product['Sku'],'ref_id'=>$product['ref_id']);
						$assigneHostbillproduct[]=$product['ref_id'];
					}
			
			}
	
	}
	/*************************/
	
	/**********Hostbill Temp Product**************/
	$selectHostaccount=$listHostaccount=array();
	$hostbillproducts=$objhostbill->GetTempHostbillProduct(true);
	//$hostbillproducts=$objhostbill->GetProductFromTempAccount();
		$groupfilter=array();
		if(!empty($hostbillproducts)){
				foreach($hostbillproducts as $k=>$Product){					
					if(!in_array($Product['ref_id'],$assigneHostbillproduct)){
							
									$groupfilter[$Product['group_id']]['group_name']=$Product['group_name'];
									$groupfilter[$Product['group_id']]['products'][$Product['ref_id']]=$Product['product_name'];	
								    $selectHostaccount[$Product['ref_id']]=$Product['product_name'];					
					}
				
					$listhostbillproduct[$Product['ref_id']]=array('name'=>$Product['product_name']);
				}
			}
	
	//print_R($selectHostaccount);die;
	/*************************/
	
	
	
	
	
	
	/*  invoice synchronize date */
	
$sql="Select meta_value,meta_key,meta_date FROM s_hostbill_setting WHERE 1=1 AND meta_key='inventory_import_page'";
$synchronizedate=$objhostbill->query($sql);
//	print_R($Config['Url']);
	require_once("../includes/footer.php"); 	
?>


