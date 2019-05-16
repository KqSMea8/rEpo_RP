<?php

$HideNavigation = 1;

include_once("../includes/header.php");

require_once($Prefix . "classes/sales.quote.order.class.php");
require_once($Prefix . "classes/email.class.php");
$objImportEmail = new email();
$objSale = new sale();

$ModuleName = "Invoice";
$module = $ModuleName;
$ModuleDepName = "SalesInvoice";


if(!empty($_GET['viewC'])){
	$RedirectURL = "vCustomer.php?view=" . $_GET['viewC'].'&tab=general';
}else if(!empty($_GET['editC'])){
	$RedirectURL = "editCustomer.php?edit=" . $_GET['editC'].'&tab=general';
}else{
	$RedirectURL = "viewInvoice.php?curP=" . $_GET['curP'];
}

?>

<SCRIPT TYPE="text/javascript">
 function RedirectPage(RedUrl){
	var tabcount = RedUrl.indexOf("tab"); 
	if(tabcount>0){
		parent.location.hash = "list_table"; 
	}
	parent.location.reload();
 }
</SCRIPT>
<?

$ModuleIDTitle = "Invoice ID";
$ModuleID = "InvoiceID";
$PrefixPO = "INV";
$NotExist = NOT_EXIST_INVOICE;
$MailSend = INVOICE_SEND;


/************/
$TemplateID = 60;
$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
if($TemplateContent[0]['Status'] != 1) {
	$ErrorMSG = str_replace("[MODULE]", $ModuleName, EMAIL_TEMPLATE_INACTIVE);	 
	
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
    //die('rrr');
    /*     * new code for attach file * */
    $arryInvoice = $objSale->GetSale($_GET['view'], '', "Invoice");

	if($arryInvoice[0]['InvoiceEntry'] == "2" || $arryInvoice[0]['InvoiceEntry'] == "3"){
		$ModuleDepName = "SalesInvoiceGl";
	}

    //echo '<pre>'; print_r($arryInvoice[0]['CreditID']);die; 
    $time = time();
    #$file_path = 'upload/pdf/'.$_SESSION['CmpID']."/".$ModuleDepName . '-' . stripslashes($arryInvoice[0]['InvoiceID']) . '.pdf';

	$PdfFolder = $Config['S_Invoice'];
	$PdfDir = $Config['FilePreviewDir'].$PdfFolder;
	//$file_path= $PdfDir.$ModuleDepName.'-'.stripslashes($arryInvoice[0]['InvoiceID']).'.pdf';
    //$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryInvoice[0]['InvoiceID']) . '' . $time . '.pdf';
  	//updated for dynamic template attachment in mail on 23Mar2018 by chetan//	
	if(isset($_POST['tempidd']) && $_POST['tempidd']!=''){
		$file_name = $ModuleDepName.'-'.stripslashes($arryInvoice[0]['InvoiceID']).'-temp'.$_POST['tempidd'].'.pdf';
		$file_path = $PdfDir.$file_name;
		$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryInvoice[0]['InvoiceID']) . '-temp'.$_POST['tempidd']. $time . '.pdf';
	}else{
		$file_name = $ModuleDepName.'-'.stripslashes($arryInvoice[0]['InvoiceID']).'.pdf';
		$file_path = $PdfDir.$file_name;
		$ConvetFilename = $ModuleDepName . '-' . stripslashes($arryInvoice[0]['InvoiceID']) . '' . $time . '.pdf';
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
    $objSale->sendOrderToCustomer($_POST);
    if($Config['ObjectStorage']=="1"){
			unlink($file_path);
		}
    $_SESSION['mess_Invoice'] = $MailSend;
    echo '<script>RedirectPage("'.$RedirectURL.'");</script>';
    exit;
}





if (!empty($_GET['view'])) {
    $arryInvoice = $objSale->GetSale($_GET['view'], '', "Invoice");
    //echo '<pre>'; print_r($arryInvoice);die;
    $OrderID = $arryInvoice[0]['OrderID'];
	


    /*     * **start code for get tempalte name for dynamic pdf by sachin** */
    $_GET['ModuleName'] = $ModuleDepName;
    //$_GET['Module'] = $ModuleDepName . $ModuleName;
	$_GET['Module'] = $ModuleDepName;// . $ModuleName; //updated on 23Mar2018 to get template listing in dropdown by chetan//
    $_GET['ModuleId'] = $_GET['view'];
    $GetPFdTempalteNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//added on 5Apr2018 by chetan for default dynamic template//	
	$_GET['setDefautTem']='1';
	$GetDefPFdTempNameArray = $objConfig->GetSalesPdfTemplate($_GET);
	//End//


    //echo '<pre>'; print_r($GetPFdTempalteNameArray);die;
    /*     * **end code for get tempalte name for dynamic pdf by sachin** */
    //$OrderID   = $arrySale[0]['OrderID'];	
    if ($OrderID > 0) {
        $arrySaleItem = $objSale->GetSaleItem($OrderID);
        $NumLine = sizeof($arrySaleItem);

	/*************/
	$numEmail=0;
	$MainEmail = stripslashes($arryInvoice[0]['CustomerEmail']);
	$arrayContact = $objSale->GetSalesContactInformationInv($arryInvoice[0]['CustID']);
	$arrayEmail='';
	if(!empty($MainEmail))$arrayEmail[] = $MainEmail;
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
        $ErrorMSG = NOT_EXIST_CREDIT;
    }
} else {
    header("Location:" . $RedirectURL);
    exit;
}





require_once("../includes/footer.php");
?>


