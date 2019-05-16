<?php  $HideNavigation = 1;
	require_once("../includes/header.php");
        require_once($Prefix."classes/item.class.php");
	require_once($Prefix . "classes/inv.class.php");
	$objitem=new items();
       	$objCommon = new common();
 
	(empty($disNone))?($disNone=""):("");  
	(empty($PrefixPO))?($PrefixPO=""):("");  

	$ModuleName  = "Alias";
	
      
                if ($_POST) {

					CleanPost();


                    if(empty($_POST['Sku'])) {
				$errMsg = ENTER_ITEM_ID;
			 } else {
				if (!empty($_POST['AliasID'])) {
					$objitem->UpdateAliasItem($_POST);
					$alias_id = $_POST['AliasID'];
					$_SESSION['mess_product'] = ALIAS_UPDATED;
                                 echo '<script>parent.window.location.reload();</script>';
				}else {	 
					$alias_id = $objitem->AddAliasItem($_POST); 
					$_SESSION['mess_product'] = ALIAS_ADDED;  
	
			}
			
			
			// for Company to Company Sync by karishma || 2 Dec 2015
		if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
		
			$post_data='alias_id='.$alias_id;
					exec('php /var/www/html/erp/superadmin/curlSyncCompanyInventory_add.php "'.$post_data.'" > /dev/null & echo $!;', $output, $return);
			/*$Companys = $objCompany->SelectAutomaticSyncCompany();
			for($count=0;$count<count($Companys);$count++){
				$CmpID=$Companys[$count]['CmpID'];
				$objCompany->syncInventoryCompany($CmpID,$alias_id,'alias items');

			}*/
		}

		// end

			
			//echo '<script>parent.window.location.reload();</script>';
				//exit;	
                    }
		}

	if(!empty($_GET['edit'])){
		$arryAlias = $objitem->GetAliasItem($_GET['edit']);

		$Sku  = $arryAlias[0]['sku'];
		$item_id = $arryAlias[0]['item_id'];
	} else{
		$Sku  = $_GET['Sku'];
		$item_id = $_GET['item_id'];

		$arryAlias = $objConfigure->GetDefaultArrayValue('inv_item_alias');		

		if(!empty($item_id)){
			$arryProduct = $objitem->GetItemById($item_id);
			$arryAlias[0]['description'] = $arryProduct[0]['description'];
		}
	}


	

	$arryManufacture = $objCommon->GetCrmAttribute('Manufacture', '');
	
	
	
	require_once("../includes/footer.php"); 
	
?>
