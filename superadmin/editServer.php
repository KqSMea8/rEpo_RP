<?php 
	require_once("includes/header.php");
	require_once("../classes/server.class.php");
	$objServer = new server();
	
	$RedirectURL = "viewServer.php?curP=".$_GET['curP'];

	if(!empty($_GET['edit'])){
		$arryServer = $objServer->ListServer($_GET['edit']);
	}

	if (!empty($_POST)){	
		CleanPost();
		$result = $objServer->save($_POST); 
		if($result['error']==0){
			$_SESSION['mess_company'] = $result['msg'];
			header("Location:".$RedirectURL);
		}
		$arryServer[0]=$_POST;
		$errMsg = $result['msg'];
	}
	
	
	if (!empty($_GET['del_id'])){
		 $result = $objServer->delete($_GET['del_id']); 
			header("Location:".$RedirectURL);
	}
	

	require_once("includes/footer.php"); 
?>


