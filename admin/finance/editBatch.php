<?php 
	/**************************************************/
	$ThisPageName = 'viewBatch.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");	
	require_once($Prefix . "classes/finance.class.php");

	$objCommon = new common();
	$ModuleName = "Batch";	
	$_GET["BatchType"] = "Check";
	$RedirectURL = "viewBatch.php?curP=" . $_GET['curP'];

	$_GET['del_id']=(int)$_GET['del_id'];
	$_GET['active_id']=(int)$_GET['active_id'];
	$_GET['edit']=(int)$_GET['edit'];

	if($_GET['del_id'] && !empty($_GET['del_id'])) {
	    $_SESSION['mess_batch'] = BATCH_REMOVED;
	    $objCommon->RemoveBatch($_GET['del_id']);
	    header("Location:" . $RedirectURL);
	    exit;
	}

	if($_GET['active_id'] && !empty($_GET['active_id'])) {	    
	    $objCommon->changeBatchStatus($_GET['active_id']);
	    header("Location:" . $RedirectURL);
	    exit;
	}


	if($_POST) {
	    CleanPost();
	    if (empty($_POST['BatchName'])) {
		$errMsg = BATCH_ENTER;
	    } else { 	
		if (!empty($_POST['BatchID'])) {
		    $BatchID = $_POST['BatchID'];
		    $objCommon->UpdateBatch($_POST);
		    $_SESSION['mess_batch'] = BATCH_UPDATED;
		} else {
		    $BatchID = $objCommon->AddBatch($_POST);
		    $_SESSION['mess_batch'] = BATCH_ADDED;
		}
		header("Location:" . $RedirectURL);
		exit;
	    }
	}
 
	if (!empty($_GET['edit'])) {
	    $arryBatch = $objCommon->GetBatch($_GET['edit'], '');
	    $BatchID = $_GET['edit'];
	    $Status = $arryBatch[0]['Status'];	   
	}       
	

	require_once("../includes/footer.php"); 	 
?>
