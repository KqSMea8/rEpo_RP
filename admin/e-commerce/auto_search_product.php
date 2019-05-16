<?php
        session_start();
        $Prefix = "../../";
        require_once($Prefix . "includes/config.php");
	require_once($Prefix."includes/function.php");
        require_once($Prefix . "classes/dbClass.php");
        require_once($Prefix . "classes/admin.class.php");
        require_once($Prefix . "classes/product.class.php");
        require_once($Prefix . "classes/cartsettings.class.php");
        require_once($Prefix . "classes/manufacturer.class.php");
        require_once($Prefix.  "classes/customer.class.php");
        $objConfig = new admin();
        $objProduct = new product();
        $objCartSettings = new Cartsettings();
        $objManufacturer = new manufacturer();
        $cmsCustomer = new Customer();

	if(empty($_SERVER['HTTP_REFERER'])){
		echo 'Protected.';exit;
	}
        /* * ******Connecting to main database******** */
        $Config['DbName'] = $_SESSION['CmpDatabase'];
        $objConfig->dbName = $Config['DbName'];
        $objConfig->connect();
        /* * **************************************** */
      CleanGet();

        $r = 0;
	$c = 0;
	$mode = isset($_REQUEST["mode"])?$_REQUEST["mode"]:"";
	$ac_data = array();

	
		$q = isset($_REQUEST["q"])?$_REQUEST["q"]:"";
		$l = isset($_REQUEST["l"])?intval($_REQUEST["l"]):0;
		if($q != ""){
			$sql = "SELECT COUNT(*) AS c FROM e_products WHERE Name LIKE '%".trim($q)."%' OR ProductSku LIKE '%".trim($q)."%' AND Status='1'";
			$r = mysql_query($sql);

			$sql2 = "SELECT ProductID, ProductSku, Name FROM e_products WHERE (Name LIKE '%".trim($q)."%' OR ProductSku LIKE '%".trim($q)."%') AND Status='1' ORDER BY ProductSku".($l>0?" LIMIT ".$l:"");
                        $r2 = mysql_query($sql2);
			if (mysql_num_rows($r2)>0)
			{
				$c = mysql_num_rows($r2);
				while ($product = mysql_fetch_array($r2))
				{
					
				      $ac_data[] = array('ProductID' => $product['ProductID'], 'ProductSku' => $product['ProductSku'], 'Name' => $product['Name']);
				}
			}
		}
	
	echo json_encode($ac_data);


?>
