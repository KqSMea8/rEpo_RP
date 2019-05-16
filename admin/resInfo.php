<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/reseller.class.php");	
	$objReseller=new reseller();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/

	if($_GET['view']>0) {
		$arryReseller = $objReseller->GetReseller($_GET['view'],'');
		if($arryReseller[0]['RsID']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.NO_RECORD.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}

	require_once("includes/footer.php");  

?>
