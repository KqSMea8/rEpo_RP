<?php  $FancyBox=1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	
	$ModuleName = "Folder";
	$objLead=new lead();

	$parent_type = (isset($_GET['parent_type'])) ? $_GET['parent_type'] :''; 
	$parentID = (isset($_GET['parentID'])) ? $_GET['parentID'] :'';  
	if((isset($_GET['parent_type']) && $_GET['parent_type']!='') && (isset($_GET['parentID']) && $_GET['parentID']!='')){
	

	$AddUrl = "editDocumentFolder.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID'];
	$ViewUrl = "viewDocumentFolder.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID'];
	//$AddUrl = "editDocument.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	
		//echo $AddUrl;  exit;
	}else{
	$AddUrl = "editDocumentFolder.php?module=".$_GET["module"];
	$ViewUrl = "viewDocumentFolder.php?module=".$_GET["module"];
	}



if(!empty($_GET['del_id'])){
$RedirectURL = "viewDocumentFolder.php?curP=&module=Document";
		$objLead->RemoveDocumentFolder($_GET['del_id']);

        $_SESSION['mess_Document'] = "Folder has been removed successfully.";
		header("location:".$RedirectURL);
		exit;
	}

	//$EditUrl = "editDocument.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&curP=".$_GET["curP"];
	//$arryDocument=$objLead->Listxyz();
	$arryDocument=$objLead->ListDocumentFolder();
	$num=$objLead->numRows();

	$pagerLink=$objPager->getPager($arryDocument,$RecordsPerPage,$_GET['curP']);
	(count($arryDocument)>0)?($arryDocument=$objPager->getPageRecords()):("");



	require_once("../includes/footer.php"); 	 
?>

