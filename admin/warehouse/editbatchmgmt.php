<?php 
    /**************************************************/
    $ThisPageName = 'viewbatchmgmt.php'; $EditPage = 1;
    /**************************************************/
   
    require_once("../includes/header.php");

    require_once($Prefix."classes/warehouse.class.php");
     require_once($Prefix."classes/sales.quote.order.class.php");
    include_once("language/english.php");
			 require_once($Prefix."classes/inv.condition.class.php");
    $ModuleName = "Batch Mgmt";
    $RedirectURL = "viewbatchmgmt.php?curP=".$_GET['curP'];
    $EditUrl = "editbatchmgmt.php?edit=".$_GET["edit"];
    $objWarehouse = new warehouse();
		  $objCondition=new condition();
    if($_GET['del_id'] && !empty($_GET['del_id'])){
           $_SESSION['mess_batch'] = BATCH_REMOVE;
           $objWarehouse->RemoveBatch($_GET['del_id']);
           header("Location:".$RedirectURL);
    }

    /***************************************************************/
	
    if (!empty($_POST)) {

        if (!empty($_POST['batchId']))
        {
            /***************************/		
            $objWarehouse->UpdateBatch($_POST);
            $_SESSION['mess_batch'] = BATCH_UPDATED;
            /***************************/
            
        }else {	
            
            $batchId = $objWarehouse->AddBatch($_POST); 
            $_SESSION['mess_batch'] = BATCH_ADDED;
        }

        header("Location:".$RedirectURL);
        exit;

    }

    if(!empty($_GET['edit'])) {
        $batcharr = $objWarehouse->ListBatches($_GET['edit'],'','');
        $objSale	=	new sale();
        $EntriesArr	=  	$objSale->ListbatchEntries($_GET['edit']);
    }		
	
    $ConditionDrop  =$objCondition-> GetConditionDropValue('');
    require_once("../includes/footer.php"); 
?>


