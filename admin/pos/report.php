<?php 

/**************************************************/
	//$ThisPageName = 'vendor.php'; 
	$InnerPage=1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once("classes/order.class.php");
	require_once("classes/user.class.php"); 
	require_once("currency.php");  
	$objorder=new order();
    
   
	$db = new dbFunction();
	$ObjUser = new user();
        
        /*****************************Pagination Amit Singh**************************************/
       
        $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
        $limit=$_GET['limit']=20; 
        $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
	     $c=0;
        $strURL='';
	//**************************end*************************/
        
        
        
    $cmpId  = $_SESSION['CmpID'];
	//echo  "<pre>";print_r($_SESSION);
	$objConfig->dbName = $Config['DbMain'];
    $objConfig->connect();
	

	
	
    $Config['RecordsPerPage'] = $RecordsPerPage;
    $getvendorByCompnay =    $objorder->getvendorByCompnayID(array('cmpId'=>$cmpId,'user_type'=>'vendorpos','isvendor_admin'=>'Yes'));
	//echo  "<pre>";print_r($getvendorByCompnay);die;
    $getvendorByCompnayID =    $getvendorByCompnay['result'];
	
	
	if(!empty($_GET) && ($_GET['search'] =="Search")){
		$objConfig->dbName = $Config['DbName'];
        $objConfig->connect();
	
		$OrderList =  $objorder->getOrderList(array('vendor_id'=>trim($_GET['vendor']),'OrderStatus'=>trim($_GET['OrderStatus']),'f'=>trim($_GET['f']),'t'=>trim($_GET['t']),'OrderID'=>trim($_GET['OrderID']),'limit'=>$limit,'offset'=>$offset,'location'=>trim($_GET['location'])));

$OrderListTotal =  $objorder->getOrderList(array('vendor_id'=>trim($_GET['vendor']),'OrderStatus'=>trim($_GET['OrderStatus']),'f'=>trim($_GET['f']),'t'=>trim($_GET['t']),'OrderID'=>trim($_GET['OrderID']),'location'=>trim($_GET['location'])));


$pageset=array('vendor'=>trim($_GET['vendor']),'OrderStatus'=>trim($_GET['OrderStatus']),'f'=>trim($_GET['f']),'t'=>trim($_GET['t']),'OrderID'=>trim($_GET['OrderID']),'search'=>trim($_GET['search']),'location'=>trim($_GET['location']));
		
        /*****************Amit Singh Pagination***************/
        if(!empty($OrderList)){
            $totalrecords=$num=count($OrderListTotal);
        }
    
        $totalrecords=ceil($totalrecords/$_GET['limit']);
        $pageslink='';

        $pageslink=$ObjUser->pagingChat($page,$limit,$offset,$num,$totalrecords,$pageset);
        /*******************************************************************/
                //*************end********************/
		
	   
	}
	
	

 
  require_once("../includes/footer.php");
  
?>
