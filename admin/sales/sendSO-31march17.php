<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
        require_once($Prefix."classes/email.class.php");
        $objImportEmail=new email();
				$ModuleDepName="Sales";//by sachin


	$objSale = new sale();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sales ".$_GET['module'];

	$RedirectURL = "viewSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP'];

	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE;  $MailSend = SO_QUOTE_SEND; $TemplateID=57;
	}else{
		$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER; $MailSend = SO_ORDER_SEND; $TemplateID=58;
	}

	/************/
	$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
	if($TemplateContent[0]['Status'] != 1) {
		$ErrorMSG = str_replace("[MODULE]",$_GET['module'],EMAIL_TEMPLATE_INACTIVE);	 
		
	}
	/************/


	
	if(!empty($_POST["ToEmail"]) && !empty($_GET["view"])){
		 
		if($_POST["ToEmail"][0]=="Other"){
			$_POST["ToEmail"] = $_POST["OtherEmail"];
		}else{
			$_POST["ToEmail"] = implode(",", $_POST["ToEmail"]); 
			$_POST["ToEmail"] = str_replace(",Other","",$_POST["ToEmail"]);
		}	 
		 

		$_POST['OrderID'] = $_GET["view"];
		/***********/
		$AttachFlag = 1; $_GET['o'] = $_GET["view"];
		//include_once("pdfSO.php");
		//$ConvetFilename=str_replace('upload/pdf/','',$file_path);
		/****New code for html2pdf********/
		$arrySale = $objSale->GetSale($_GET['view'],'',$module);
		$time=time();
		$file_path='upload/pdf/'.$ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'.pdf';
		$ConvetFilename=$ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).''.$time.'.pdf';
		/*********************************/
                
		$_POST['Attachment'] = getcwd()."/".$file_path;
		/***********/	

		/****************/
                if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){
                $newDefaultEmail=$objConfigure->GetEmailListId($_SESSION["AdminID"],$_SESSION["CmpID"]);
                if(!empty($newDefaultEmail[0]["EmailId"])){
			$Config["AdminEmail"]= $newDefaultEmail[0]["EmailId"];
                        $_POST['DefaultEmailConfig']=1;
                        }
                if($_SESSION['AdminType']!='admin')
                    {
                        $OwnerEmailId=$_SESSION['EmpEmail'];
                    }else{
                         $OwnerEmailId=$_SESSION['AdminEmail'];
                    }
                    
                     $output_dir = "../crm/upload/emailattachment/";
                    $output_dir=$output_dir.$OwnerEmailId."/";
                    $_POST['OwnerEmailId']=$OwnerEmailId;
                    $_POST['output_dir']=$output_dir;
                    $_POST['ConvetFilename']=$ConvetFilename;

		}
		/***************/


			
		$objSale->sendOrderToCustomer($_POST);
		$_SESSION['mess_Sale'] = $MailSend;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}


	
	if(!empty($_GET['view']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['view'],$_GET['so'],$module);
		
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);

			/****start code for get tempalte name for dynamic pdf by sachin***/
			$_GET['ModuleName']=$ModuleDepName;
			$_GET['Module']=$ModuleDepName.$_GET['module'];
			$_GET['ModuleId']=$_GET['view'];
			$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);
			/****end code for get tempalte name for dynamic pdf by sachin***/


			/*************/
			$MainEmail = stripslashes($arrySale[0]['CustomerEmail']);
			$arrayContact = $objSale->GetSalesContactInformationSO($arrySale[0]['CustID']);
			if(!empty($MainEmail))$arrayEmail[] = $MainEmail;
			foreach($arrayContact as $values){
			 	$arrayEmail[] = $values['Email'];
			}     
			$arrayEmail = array_unique($arrayEmail);			
			sort($arrayEmail); 
			 
			$numEmail = sizeof($arrayEmail);
			if($numEmail>0){
				$OtherEmailHide = 'style="display:none"';
			}else{
				$ToEmailHide = ';display:none;';
				$OtherSelected = ' selected';
			}
			/*************/



		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				


	

	require_once("../includes/footer.php"); 	 
?>


