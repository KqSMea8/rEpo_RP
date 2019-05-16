<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewRma.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
    require_once($Prefix."classes/email.class.php");
    $objImportEmail=new email();
	$ModuleDepName="Sales";//by sachin

	$objSale = new sale();
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

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	 $ModuleName = "Sales ".$_GET['module']; 
	 
	$RedirectURL = "viewRma.php?curP=".$_GET['curP'];

	
		$ModuleIDTitle = "RMA Number"; $ModuleID = "QuoteID"; $PrefixPO = "RMA";  $NotExist = NOT_EXIST_ORDER; $MailSend = RMA_SEND; $TemplateID=79;
	

	/************/
	$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
	//PR($TemplateContent);
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
		 
		/****New code for html2pdf********/
		$arrySale = $objSale->GetSale($_GET['view'],'',$module);	
		
		$time=time();
		
		 #$file_path='upload/pdf/'.$_SESSION['CmpID'].'/Sales'.$arrySale[0]['Module'].'-'.stripslashes($arrySale[0]['ReturnID']).'.pdf';
	
 		$PdfFolder = $Config['S_Rma'];
		$PdfDir = $Config['FilePreviewDir'].$PdfFolder;

		//$file_path= $PdfDir.$ModuleDepName.$arrySale[0]['Module'].'-'.stripslashes($arrySale[0]['ReturnID']).'.pdf';
		// $ConvetFilename=$ModuleDepName.$arrySale[0]['Module'].'-'.stripslashes($arrySale[0]['ReturnID']).''.$time.'.pdf';
		//updated for dynamic template attachment in mail on 17Apr2018 by chetan//	
		if(isset($_POST['tempidd']) && $_POST['tempidd']!=''){
			$file_name = $ModuleDepName.$arrySale[0]['Module'].'-'.stripslashes($arrySale[0]['ReturnID']).'-temp'.$_POST['tempidd'].'.pdf';
			$file_path = $PdfDir.$file_name;
			$ConvetFilename = $ModuleDepName.$arrySale[0]['Module'].'-'.stripslashes($arrySale[0]['ReturnID']) . '-temp'.$_POST['tempidd']. $time . '.pdf';
		}else{
			$file_name = $ModuleDepName.$arrySale[0]['Module'].'-'.stripslashes($arrySale[0]['ReturnID']).'.pdf';
			$file_path= $PdfDir.$file_name;
			$ConvetFilename=$ModuleDepName.$file_name;
		}
	  	//End//

		if($Config['ObjectStorage']=="1"){
			copy($Config['OsUploadUrl'].$Config['OsDir']."/".$PdfFolder.$file_name, $file_path);
		}	

		/*********************************/                
	     $_POST['Attachment'] =  $file_path; 
		
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
		$_POST['footerSingnature']=$footerSingnature;
		$objSale->sendOrderToCustomer($_POST);
		if($Config['ObjectStorage']=="1"){
			unlink($file_path);
		}
		$_SESSION['mess_return'] = $MailSend;	
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
			$_GET['ModuleName']= $ModuleDepName.$_GET['module'];//$ModuleDepName;
			$_GET['Module']=$ModuleDepName.$_GET['module'];
			$_GET['ModuleId']=$_GET['view'];
			$GetPFdTempalteNameArray=$objConfig->GetSalesPdfTemplate($_GET);
			//added on 5Apr2018 by chetan for default dynamic template//	
			$_GET['setDefautTem']='1';
			$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
			//End//
			/****end code for get tempalte name for dynamic pdf by sachin***/
			/*************/
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


