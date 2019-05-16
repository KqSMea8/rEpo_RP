<?php 

/**************************************************/
	$ThisPageName = 'ViewInventoryWritedown.php';  $EditPage = 1;
    /**************************************************/
	
	include_once("../includes/header.php");
    	require_once($Prefix . "classes/item.class.php");
	require_once($Prefix . "classes/inv_category.class.php");
	require_once($Prefix . "classes/inv.condition.class.php");
	
     $objItem = new items();  
     $objCategory = new category();
     $objCondition = new condition();
     $RedirectUrl = "ViewInventorywritedown.php";
     $ModuleName = 'InventoryWritedown';
     
	error_reporting(E_ALL);
        
        if($_POST) {  
        	if ($_POST["Status"]=='1') {
        		$updatedata = $objItem->UpdateAllInvAvgCost($_POST);
        		$insertdata = $objItem->InvWriteDown($_POST);
        		$_SESSION['mess_product'] = 'Inventory Writedown' . ADJ_UPDATED;
        	}elseif($_POST["ID"] > 0){
        		$insertdata = $objItem->InvWriteDown($_POST);
        		$_SESSION['mess_product'] = 'Inventory Writedown' . ADJ_UPDATED;
        	}else{
        		$insertdata = $objItem->InvWriteDown($_POST);
        		$_SESSION['mess_product'] = 'Inventory Writedown' . ADJ_ADDED;
        	}
        	
        	 
             header("location: " . $RedirectUrl."?curP=$_GET[curP]&");
             exit;	
        }
        
        if($_GET['edit']>0){
        	$arraydetails = $objItem->getAllwritedown($_GET['edit']);
        	
        }
        if ($_GET['active_id']>0){
        	if ($_GET['status']== 0){
        		$changestatus = $objItem->ChangeInvWrtDownStatus($_GET['active_id']);
        		$arrdata = $objItem->getAllwritedown($_GET['active_id']);
        		$updatedata = $objItem->UpdateAllInvAvgCost($arrdata['0']);
        		$_SESSION['mess_product'] = 'Inventory Writedown ' . ACTIVATED;
        	}
        	 header("location: " . $RedirectUrl."?curP=$_GET[curP]&");
        	 exit;
        }
        if ($_GET['del_id']>0){
        	$deldata = $objItem->DelWritedownInv($_GET['del_id']);
            $_SESSION['mess_product'] = 'Inventory Writedown' . REMOVED;
            
          header("location: " . $RedirectUrl."?curP=$_GET[curP]&");
          exit;
        }
        
        
        
        
        require_once("../includes/footer.php");
?>

