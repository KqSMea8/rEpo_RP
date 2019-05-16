<?	session_start();

    require_once("../../includes/config.php");
    require_once("../../includes/function.php");
	require_once("../../classes/dbClass.php");
	require_once("../../classes/admin.class.php");	
	require_once("language/english.php");
	$objConfig=new admin();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}


	CleanGet();


	switch($_GET['action']){
		case 'upgradeprice':			
			$AjaxHtml = '<br>Local Time: <strong>fggg</strong>';
			
			break;
			
		case 'CouponCode':
			 $CouponCode=$_GET['CouponCode'];
			 $TotalAmount=$_GET['TotalAmount'];
			 $startDate=date('Y-m-d');
			 $sql="SELECT COUNT(OrderID) as total FROM orders WHERE CouponCode='".$CouponCode."'";
			 $ct = mysql_query($sql);
			 $row = mysql_fetch_object($ct);
             $countOrder=$row->total;
			

			 
			 if($TotalAmount>0 && $CouponCode!=''){
				 $strSQLQuery="SELECT * FROM coupons WHERE CouponCode='".addslashes(trim($CouponCode))."' AND Status='Yes' AND MinAmount<=".$TotalAmount." AND ExpiryDate>='".$startDate."'";
				 //echo $strSQLQuery;exit;
				 $res=mysql_query($strSQLQuery);
				 $count=mysql_num_rows($res);	
			 }
			 if($count>0){
			 	$results=mysql_fetch_array($res);
					if($results['UseLimit']>0 && $countOrder>=$results['UseLimit']){
						unset($results);
						$results['id']=0;		 		
					}
     		  }else{
			 	//echo "Coupon Code Not Applied.";
			 	$results['id']=0;
			 }
			   echo json_encode($results);exit;
					
	}
	
	if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
