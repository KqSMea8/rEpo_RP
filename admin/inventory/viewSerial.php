<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;	
		include_once("../includes/header.php");
		require_once($Prefix."classes/item.class.php");
		require_once($Prefix."classes/inv_category.class.php");
		require_once($Prefix."classes/purchase.class.php");
		require_once($Prefix . "classes/inv.condition.class.php");
		include_once("includes/FieldArray.php");
		$objItem=new items();
		$objCategory=new category();
		$objPurchase= new purchase();
		$objCondition = new condition();


		$ViewUrl = "viewSerial.php?curP=".$_GET['curP'];
		$ModuleName ='Serial Number';
		$ViewUrl = "viewSerial.php?curP=".$_GET['curP'];


		if ($_GET['active_id'] && !empty($_GET['active_id'])) {
				$_SESSION['mess_product'] = $ModuleName . STATUS;
				$objItem->changeSerialStatus($_GET['active_id']);
		if($_GET['sortby']!='' || $_GET['UsedSerial']!=''||$_GET['Condition']!=''||$_GET['key']!=''||$_GET['FromDate']!=''||$_GET['ToDate']!=''||$_GET['asc']!=''){
	      $UR = '&sortby='.$_GET['sortby'].'&UsedSerial='.$_GET['UsedSerial'].'&key='.$_GET['key'].'&FromDate='.$_GET['FromDate'].'&ToDate='.$_GET['ToDate'].'&asc='.$_GET['asc'];
		}
				header("location: " . $ViewUrl."".$UR."");
				exit;
		}


if($_POST){
		$newout = preg_replace('/\s+/', ',', $_POST['SearchValue']); 
		$_GET['Multiple'] =1;
		$_GET['SerialSearch'] = $newout;
		$numflag = 1;
}else{
		$newout = 0; 
		$_GET['Multiple'] =0;
		$_GET['SerialSearch'] = 0;
		$numflag = 0;

}
	if($_GET['Duplicate']==1){
	
	$arrySerial = $objItem->GetDuplicatSerial();
	$num=count($arrySerial);
	}else{
  $Config['RecordsPerPage'] = $RecordsPerPage;
		$arrySerial=$objItem->ListSerialNumberList($_GET);
		$Config['GetNumRecords'] = 1;
		$arryCount=$objItem->ListSerialNumberList($_GET);
		//$num=$arryCount[0]['NumCount'];
			if($numflag==1) {
					$num=$objItem->numRows();
			}else{
					$num=$arryCount[0]['NumCount'];
			}
			$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	}

		

		


	
		  $ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($_GET["Condition"]);

  require_once("../includes/footer.php");

?>
