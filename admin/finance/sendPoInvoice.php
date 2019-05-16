<?php

$HideNavigation = 1;

include_once("../includes/header.php");
require_once($Prefix . "classes/purchase.class.php");
require_once($Prefix . "classes/email.class.php");
$objImportEmail = new email();

$objPurchase = new purchase();

$ModuleName = "Invoice";
$module = $ModuleName;
$ModuleDepName = "PurchaseInvoice";  
$RedirectURL = "viewPoInvoice.php?curP=" . $_GET['curP'];

$ModuleIDTitle = "Invoice ID";
$ModuleID = "InvoiceID";

$NotExist = NOT_EXIST_INVOICE;
$MailSend = INVOICE_SEND;

/************/
$TemplateID=70;
$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
if($TemplateContent[0]['Status'] != 1) {
	 $ErrorMSG = str_replace("[MODULE]",$ModuleName,EMAIL_TEMPLATE_INACTIVE);	 
	
}
/************/	

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


if (!empty($_POST["ToEmail"]) && !empty($_GET["view"])) {
	if($_POST["ToEmail"][0]=="Other"){
		$_POST["ToEmail"] = $_POST["OtherEmail"];
	}else{
		$_POST["ToEmail"] = implode(",", $_POST["ToEmail"]); 
		$_POST["ToEmail"] = str_replace(",Other","",$_POST["ToEmail"]);
	}
	 
    $_POST['OrderID'] = $_GET["view"];
    /*     * ******** */
    $AttachFlag = 1;
    $_GET['o'] = $_GET["view"];
    $arryPurchase = $objPurchase->GetPurchase($_GET['view'], '', $ModuleName);
    $time = time();
    #$file_path = 'upload/pdf/'.$_SESSION['CmpID'].'/'. $ModuleDepName . '-' . stripslashes($arryPurchase[0]['InvoiceID']) . '.pdf';

	$PdfFolder = $Config['P_Invoice'];
	$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
	$file_path= $PdfDir.$ModuleDepName.'-'.stripslashes($arryPurchase[0]['InvoiceID']).'.pdf';
    //$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryPurchase[0]['InvoiceID']) . '' . $time . '.pdf';

    //updated for dynamic template attachment in mail on 23Mar2018 by chetan//	
	if(isset($_POST['tempidd']) && $_POST['tempidd']!=''){
		$file_name = $ModuleDepName.'-'.stripslashes($arryPurchase[0]['InvoiceID']).'-temp'.$_POST['tempidd'].'.pdf';
		$file_path = $PdfDir.$file_name;
		$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryPurchase[0]['InvoiceID']) . '-temp'.$_POST['tempidd']. $time . '.pdf';
	}else{
		$file_name = $ModuleDepName.'-'.stripslashes($arryPurchase[0]['InvoiceID']).'.pdf';
		$file_path = $PdfDir.$file_name;
		$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryPurchase[0]['InvoiceID']) . '' . $time . '.pdf';
	}
	//End//

	if($Config['ObjectStorage']=="1"){
		 copy($Config['OsUploadUrl'].$Config['OsDir']."/".$PdfFolder.$file_name, $file_path);
	}
	

	$_POST['Attachment'] =  $file_path;
    /*     * ******** */

    if (empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'], 5) == 1) {
        $newDefaultEmail = $objConfigure->GetEmailListId($_SESSION["AdminID"], $_SESSION["CmpID"]);
        if (!empty($newDefaultEmail[0]["EmailId"])) {
            $Config["AdminEmail"] = $newDefaultEmail[0]["EmailId"];
            $_POST['DefaultEmailConfig'] = 1;
        }

        if ($_SESSION['AdminType'] != 'admin') {
            $OwnerEmailId = $_SESSION['EmpEmail'];
        } else {
            $OwnerEmailId = $_SESSION['AdminEmail'];
        }

        $output_dir = "../crm/upload/emailattachment/";
        $output_dir = $output_dir . $OwnerEmailId . "/";
        $_POST['OwnerEmailId'] = $OwnerEmailId;
        $_POST['output_dir'] = $output_dir;
        $_POST['ConvetFilename'] = $ConvetFilename;
        //echo $OwnerEmailId;die;
    }
    /*     * *******end ***** */
    $_POST['footerSingnature']=$footerSingnature;
    $objPurchase->sendOrderToSupplier($_POST);
	if($Config['ObjectStorage']=="1"){
			unlink($file_path);
		}
    $_SESSION['mess_invoice'] = $MailSend;
    echo '<script>window.parent.location.href="' . $RedirectURL . '";</script>';
    exit;
}





if (!empty($_GET['view'])) {
    $arryPurchase = $objPurchase->GetPurchase($_GET['view'], '', $ModuleName);
    $OrderID = $arryPurchase[0]['OrderID'];
    /*     * **start code for get tempalte name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName;// . $ModuleName; //updated on 16Apr2018 to get template listing in dropdown by chetan//
    $_GET['ModuleId'] = $_GET['view'];
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//added on 16Apr2018 by chetan for default dynamic template//	
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//End//
    //echo '<pre>'; print_r($GetPFdTempalteNameArray);die;
    /*     * **end code for get tempalte name for dynamic pdf by sachin** */
    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);


	/*************/
	$numEmail=0;$arrayEmail='';
	$MainEmail = stripslashes($arryPurchase[0]['VendorEmail']);
	$arrayContact = $objPurchase->GetVenderContactInformationInv($arryPurchase[0]['SuppID']);
	if(!empty($MainEmail)) $arrayEmail[] = $MainEmail;
	foreach($arrayContact as $values){
	 	if(!empty($values['Email']))$arrayEmail[] = $values['Email'];
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

		
    } else {
        $ErrorMSG = $NotExist;
    }
} else {
    header("Location:" . $RedirectURL);
    exit;
}





require_once("../includes/footer.php");
?>


