<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesPayments.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
        require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	//require_once($Prefix."classes/finance_tax.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
        require_once($Prefix . "classes/sales.quote.order.class.php");
         $objSale = new sale();
        $objImportEmail=new email();
	$objCustomer = new Customer();
           
        (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	$objTax=new tax();
	$objBankAccount= new BankAccount();
	$objReport = new report();

	$objPurchase=new purchase();

	$module = 'Case Receipt';
	$ModuleName = "Purchase ".$_GET['module'];

	$RedirectURL = "viewSalesPayments.php?curP=".$_GET['curP'];

	
	$ModuleIDTitle = "Case Payment ID"; $ModuleID = "PaymentID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_PAYMENT; $MailSend = Send_Case_Payment;
	

	
	if(!empty($_POST["ToEmail"]) && !empty($_GET["view"])){
		$_POST['OrderID'] = $_GET["ID"];
		/***********/
		$AttachFlag = 1; $_GET['o'] = $_GET["view"];
		include_once("pdf_case_reciept.php");
                
                $ConvetFilename=str_replace('upload/pdf/','',$file_path);
                
		$_POST['Attachment'] = getcwd()."/".$file_path;
		/***********/	

		/****************/
                if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){
                $newDefaultEmail=$objConfigure->GetEmailListId($_SESSION["AdminID"],$_SESSION["CmpID"]);
                if(!empty($newDefaultEmail[0]["EmailId"])){
			$Config["AdminEmail"]= $newDefaultEmail[0]["EmailId"];
                         $_POST['DefaultEmailConfig']=1;
		}
		/***************/

                //echo '<pre>'; print_r($_POST);die;
                /*******new sac****/
               
                //$ConvetFilename=$arryPurchase[0][$ModuleID].".pdf";
                //echo $ConvetFilename;die;
                    //unset($_SESSION['attcfile']);

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
                    //echo $OwnerEmailId;die;
                /*********end ******/
                //echo '<pre>'; print_r($_POST);die;
		//$objPurchase->sendOrderToSupplier($_POST);
                $objReport->sendCaseReceiptToCustomer($_POST);
                
		$_SESSION['mess_Invoice'] = $MailSend;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}





	if(!empty($_GET['ID'])){
		
				$arryCasePayment = $objBankAccount->GetCaseRecipetReceivePaymentInvoice($_GET['ID']);
                                $arrySale = $objSale->GetSale($_GET['view'],'',$module);
                                //echo '<pre>';print_r($arrySale);die;
                               
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				


	

	require_once("../includes/footer.php"); 	 
?>


