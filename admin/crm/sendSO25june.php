<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewQuote.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/quote.class.php");
	$objQuote=new quote();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sales ".$_GET['module'];

	$RedirectURL = "viewQuote.php?module=".$module."&curP=".$_GET['curP'];

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE;  $MailSend = SO_QUOTE_SEND;
	}else{
		$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER; $MailSend = SO_ORDER_SEND;
	}

	
	if(!empty($_POST["ToEmail"]) && !empty($_GET["view"])){
		
		$_POST['quoteid'] = $_GET["view"];
		/***********/
		$AttachFlag = 1; $_GET['o'] = $_GET["view"];
		include_once("pdfQuote.php");
		$_POST['Attachment'] = $file_path;
		/***********/
		$MainDir = "upload/temp/";		
		$documentDestination = $MainDir.$_FILES['document']['name'];				
		if(@move_uploaded_file($_FILES['document']['tmp_name'], $documentDestination)){
			$_POST['AttachDocument'] = $documentDestination;
		}
			
		/****************/
                $newDefaultEmail=$objConfigure->GetEmailListId($_SESSION["AdminID"],$_SESSION["CmpID"]);
                if(!empty($newDefaultEmail[0]["EmailId"])){
			$Config["AdminEmail"]= $newDefaultEmail[0]["EmailId"];

		}
		/***************/

		$objQuote->sendOrderToCustomer($_POST);
		$_SESSION['mess_quote'] = $MailSend;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}


	if(!empty($_GET['view'])){
		$arrySale = $objQuote->GetQuote($_GET['view'],'','');
		
		$quoteid   = $arrySale[0]['quoteid'];	
		if($quoteid>0){
			//$arrySaleItem = $objQuote->GetQuoteItem($quoteid);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	$arryCustomer = $objQuote->GetLeadCustomer('');


	require_once("../includes/footer.php"); 	 
?>


