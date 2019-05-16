<?php

$HideNavigation = 1;

include_once("../includes/header.php");
require_once($Prefix . "classes/purchase.class.php");
require_once($Prefix . "classes/email.class.php");
$objImportEmail = new email();

$objPurchase = new purchase();

$ModuleName = "Credit Memo";
$module = $ModuleName;
$ModuleDepName = "PurchaseCreditMemo"; //by sachin
$RedirectURL = "viewPoCreditNote.php?curP=" . $_GET['curP'];

$ModuleIDTitle = "Credit Note ID";
$ModuleID = "CreditID";
$PrefixPO = "CR";
$NotExist = NOT_EXIST_CREDIT;
$MailSend = CREDIT_MEMO_SEND;

(empty($_GET['moduleu']))?($_GET['moduleu']=""):("");
/************/
$TemplateID=69;
$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
if($TemplateContent[0]['Status'] != 1) {
	$ErrorMSG = str_replace("[MODULE]",$_GET['module'],EMAIL_TEMPLATE_INACTIVE);	 
	
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
    $arryPurchase = $objPurchase->GetPurchase($_GET['view'], '', "Credit");
    $time = time();

	# $file_path = 'upload/pdf/'. $_SESSION['CmpID'].'/' . $ModuleDepName . '-' . stripslashes($arryPurchase[0]['CreditID']) . '.pdf';

	$PdfFolder = $Config['P_Credit'];
    	$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
	//$file_path= $PdfDir.$ModuleDepName.'-'.stripslashes($arryPurchase[0]['CreditID']).'.pdf';
	//$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryPurchase[0]['CreditID']) . '' . $time . '.pdf';

	//updated for dynamic template attachment in mail on 3May2018 by chetan//	
	if(isset($_POST['tempidd']) && $_POST['tempidd']!=''){
		$file_name = $ModuleDepName.'-'.stripslashes($arryPurchase[0]['CreditID']).'-temp'.$_POST['tempidd'].'.pdf';
		$file_path = $PdfDir.$file_name;
		$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryPurchase[0]['CreditID']) . '-temp'.$_POST['tempidd']. $time . '.pdf';
	}else{
		$file_name = $ModuleDepName.'-'.stripslashes($arryPurchase[0]['CreditID']).'.pdf';
		$file_path = $PdfDir.$file_name;
		$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryPurchase[0]['CreditID']) . '' . $time . '.pdf';
	}
  	//End//


	if($Config['ObjectStorage']=="1"){
		copy($Config['OsUploadUrl'].$Config['OsDir']."/".$PdfFolder.$file_name, $file_path);
	}

	$_POST['Attachment'] = $file_path;

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
    $_SESSION['mess_credit'] = $MailSend;
    echo '<script>window.parent.location.href="' . $RedirectURL . '";</script>';
    exit;
}





if (!empty($_GET['view'])) {
    $arryPurchase = $objPurchase->GetPurchase($_GET['view'], '', "Credit");
    $OrderID = $arryPurchase[0]['OrderID'];
    /*     * **start code for get tempalte name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName . $_GET['moduleu'];
    $_GET['ModuleId'] = $_GET['view'];
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
    //echo '<pre>'; print_r($GetPFdTempalteNameArray);die;
    /*     * **end code for get tempalte name for dynamic pdf by sachin** */
    if ($OrderID > 0) {
        $arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
        $NumLine = sizeof($arryPurchaseItem);


	/*************/
	$numEmail=0;
	$MainEmail = stripslashes($arryPurchase[0]['VendorEmail']);
	$arrayContact = $objPurchase->GetVenderCreditContactInformation($arryPurchase[0]['SuppID']);
	if(!empty($MainEmail)) $arrayEmail[] = $MainEmail;
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
		$OtherSelected='';
		$ToEmailHide ='';
	}else{
		$OtherEmailHide='';
		$ToEmailHide = ';display:none;';
		$OtherSelected = ' selected';
	}
	/*************/

		
    } else {
        $ErrorMSG = NOT_EXIST_CREDIT;
    }
} else {
    header("Location:" . $RedirectURL);
    exit;
}





require_once("../includes/footer.php");
?>


