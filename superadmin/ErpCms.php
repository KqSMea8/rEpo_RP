<?php
	require_once("includes/header.php");

	$cmsObj=new cms();
	(!$_GET['CatID'])?($_GET['CatID']=1):(""); 


	if($_SERVER['REQUEST_METHOD']=="POST"){
		if (empty($_POST['PageContent'])) {
			$_SESSION['mess'] = $MSG[5];
		}else {
			$cmsObj->UpdatePageContent($_POST);
			$_SESSION['mess'] =  $MSG[6];
			header("location: cms.php?CatID=".$_GET['CatID']."&PageID=".$_GET['PageID']);
			 exit;
		}
	}


	$arrayCat = $objMenu->GetContentCategory($_GET['CatID']);

	$arryPages = $objMenu->GetPagesByCategory($_GET['CatID']);


	if(empty($_GET['PageID'])){
		$PageID=$arryPages[0]['PageID'];
	}else{
		$PageID = $_GET['PageID'];
	}

	$arrayContents = $cmsObj->GetPageContent($PageID,'');
	require_once("includes/footer.php");

?>
 