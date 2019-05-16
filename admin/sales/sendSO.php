<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
    require_once($Prefix."classes/email.class.php");
    require_once($Prefix."classes/employee.class.php");//by sachin 29-3-2017
    $objImportEmail=new email();
	$ModuleDepName="Sales";//by sachin
	$objEmployee=new employee();//by sachin 29-3-2017

    //PR($arryCompany);
	$objSale = new sale();
    /**singnature code**/
	if(!empty($_SESSION['AdminID'])) {
		//PR($arryCompany);
		$footerSingnature='';
		$listSignatureArry=$objConfig->GetEmailSignature();
		/*if($_SESSION['AdminType']=='employee'){
		$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
		$footerSingnature=$arryEmployee[0]['empSignature'];
		}else if($_SESSION['AdminType']=='admin'){
			$footerSingnature=$arryCompany[0]['empSignature'];
		}*/
		$footerSingnature=$listSignatureArry[0]['Content'];
	}
	/**singnature code**/
	//PR($Config['MailFooter']);
    //PR($arryEmployee);
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
		$ErrorMSG = str_replace("[MODULE]",$_GET['module'],EMAIL_TEMPLATE_INACTIVE);}
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
		#$file_path='upload/pdf/'.$_SESSION['CmpID'].'/'.$ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'.pdf';

		$PdfFolder = ($_GET['module']=='Quote')?($Config['S_Quote']):($Config['S_Order']);
		$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
		//$file_path= $PdfDir.$ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'.pdf';


		//$ConvetFilename=$ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).''.$time.'.pdf';
		/*********************************/
        //updated for dynamic template attachment in mail on 19Apr2018 by chetan//	
		if(isset($_POST['tempidd']) && $_POST['tempidd']!=''){
			$file_name = $ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'-temp'.$_POST['tempidd'].'.pdf';
			$file_path = $PdfDir.$file_name;
			$ConvetFilename = $ModuleDepName . '-' . stripslashes($arrySale[0][$ModuleID]) . '-temp'.$_POST['tempidd']. $time . '.pdf';
		}else{
			$file_name =$ModuleDepName.'-'.stripslashes($arrySale[0][$ModuleID]).'.pdf';
			$file_path = $PdfDir.$file_name;
			$ConvetFilename = $ModuleDepName . '-' . stripslashes($arrySale[0][$ModuleID]) . '' . $time . '.pdf';
		}
	  	//End// 

		if($Config['ObjectStorage']=="1"){
			copy($Config['OsUploadUrl'].$Config['OsDir']."/".$PdfFolder.$file_name, $file_path);
		}
        
		$_POST['Attachment'] = $file_path;
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
                    $_POST['footerSingnature']=$footerSingnature;

		}
		/***************/


			//PR($_POST);die;
		$objSale->sendOrderToCustomer($_POST);
		if($Config['ObjectStorage']=="1"){
			unlink($file_path);
		}
		$_SESSION['mess_Sale'] = $MailSend;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}


	
	if(!empty($_GET['view']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['view'],$_GET['so'],$module);
		
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$numEmail=0;$arrayEmail='';
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			/****start code for get tempalte name for dynamic pdf by sachin***/
			$_GET['ModuleName']=$ModuleDepName;
			$_GET['Module']=$ModuleDepName.$_GET['module'];
			$_GET['ModuleId']=$_GET['view'];
			$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);
			//added on 19Apr2018 by chetan for default dynamic template//	
			$_GET['setDefautTem']='1';
			$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
			//End//
			//$GETEmaiSignatureArray=$objSale->GetEmailSignature();
			//PR($GETEmaiSignatureArray);
			/****end code for get tempalte name for dynamic pdf by sachin***/


			/*************/
//echo $arrySale[0]['CustID'];
			$MainEmail = stripslashes($arrySale[0]['CustomerEmail']);
			$arrayContact = $objSale->GetSalesContactInformationSO($arrySale[0]['CustID']);
			if(!empty($MainEmail))$arrayEmail[] = $MainEmail;
			foreach($arrayContact as $values){
			 	$arrayEmail[] = $values['Email'];
			}  
			if(!empty($arrayEmail[0])){     
				$arrayEmail = array_unique($arrayEmail);			
				sort($arrayEmail); 
				$numEmail = sizeof($arrayEmail);
			}
			 
			
			if($numEmail>0){
				$OtherEmailHide = 'style="display:none"';
				$ToEmailHide = '';
				$OtherSelected = '';
			}else{
				$ToEmailHide = ';display:none;';
				$OtherSelected = ' selected';
				$OtherEmailHide='';
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


