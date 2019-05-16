<?php  $HideNavigation = 1;
	require_once("../includes/header.php");
        require_once($Prefix."classes/item.class.php");
	
      	$objItem=new items();
	(empty($DisabledButton))?($DisabledButton=""):("");  
	(empty($ButtonID))?($ButtonID=""):("");  
 
	if($_POST){
		CleanPost();
		
		$objItem->AddUpdateRequiredItem($_POST['ItemID'],$_POST); 
		$_SESSION['mess_product'] = UPDATE_RQUEIRED;
 
		echo '<script>parent.window.location.href ="editItem.php?edit='.$_POST['ItemID'].'&tab='.$_POST['tab'].'&CatID='.$_POST['CatID'].'&curP='.$_POST['curP'].' ";</script>';
		exit;
	}
	



	if($_GET['edit']>0){
		 $aliasID= $_GET['edit'];
	}else{
		$aliasID= $_GET['view'];
	}
         $itemID= $_GET['item_id'];


	if($aliasID>0){
	       $arryAlias44 = $objItem->GetAliasItem($aliasID);
	 
		$arryRequired = $objItem->GetAliasRequiredItem($aliasID,'');
	 
		$NumLine = sizeof($arryRequired);	

	
		if($NumLine==0){
		 	$NumLine=1;
		}

	} 

 

	


	
	
	require_once("../includes/footer.php"); 
	
?>
