<?php
(empty($_GET['IE']))?($_GET['IE']=""):("");
(empty($_GET['rtn']))?($_GET['rtn']=""):("");
(empty($_GET['rcpt']))?($_GET['rcpt']=""):("");
(empty($_GET['tempid']))?($_GET['tempid']=""):("");
(empty($_GET['ModuleDepName']))?($_GET['ModuleDepName']=""):("");
(empty($_GET['module']))?($_GET['module']=""):("");
(empty($_GET['Module']))?($_GET['Module']=""):("");
(empty($_GET['po']))?($_GET['po']=""):("");
(empty($_GET['InvoiceID']))?($_GET['InvoiceID']=""):("");

(empty($_POST['Update']))?($_POST['Update']=""):("");
(empty($_POST['Save']))?($_POST['Save']=""):("");

if (!empty($_GET['pop']))
    $HideNavigation = 1;$SetFullPage = 1;
/* * *********************************************** */
$ModuleDepName = $_GET['ModuleDepName'];

if ($ModuleDepName == 'Sales') {
    $ThisPageName = 'viewSalesQuoteOrder.php';
} elseif ($ModuleDepName == 'Purchase') {
    $ThisPageName = 'viewPO.php';
} elseif ($ModuleDepName == 'SalesInvoice') {
    $ThisPageName = 'viewInvoice.php';
} elseif ($ModuleDepName == 'PurchaseInvoice') {
    //$ThisPageName = 'viewVendorInvoiceEntry.php';
 $ThisPageName = 'viewPoCreditNote.php';
    
} elseif ($ModuleDepName == 'SalesRMA') {

    $ThisPageName = 'viewRma.php';
} elseif ($ModuleDepName == 'PurchaseRMA') {

    $ThisPageName = 'viewRma.php';
} elseif ($ModuleDepName == 'SalesCreditMemo') {
//die('dd');
    $ThisPageName = 'viewCreditNote.php';
} elseif ($ModuleDepName == 'PurchaseCreditMemo') {
//die('dd');
    $ThisPageName = 'viewPoCreditNote.php';
}
elseif ($ModuleDepName == 'WhouseCustomerRMA') {
//die('dd');
    $ThisPageName = 'viewSalesReturn.php';
}
elseif ($ModuleDepName == 'WhouseVendorRMA') {
//die('dd');
    $ThisPageName = 'viewPoRma.php';
}
elseif ($ModuleDepName == 'WhousePOReceipt') {
//die('dd');
    $ThisPageName = 'viewPoReceipt.php';
}
elseif ($ModuleDepName == 'WhouseBatchMgt') {
//die('dd');
    $ThisPageName = 'viewbatchmgmt.php';
}
else if($ModuleDepName == 'Quote' ){
    
    $ThisPageName = 'viewQuote.php';
    
}


$Config['ModuleDepName'] = $ModuleDepName;
//viewRma.php
//echo $ThisPageName;die;
/* * *********************************************** */
$Prefix = "../";
include_once("includes/header.php");
require_once($Prefix . "classes/employee.class.php"); 
require_once($Prefix . "classes/configure.class.php"); 
require_once($Prefix . "classes/function.class.php"); 
$objEmp=new employee(); 
$objConfigure=new configure(); 
$objFunction=new functions();
$module = $_GET['module'];

$PdfUrl = "pdfCommonhtml.php";
if ($ModuleDepName == 'Sales') {
    //die('tt');

    $ModuleName = $_GET['module'];//"Sale " . $_GET['module'];
    //$PdfUrl="sales/pdfSOhtml.php";
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";

    $RedirectURL = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $EditUrl = "editSalesQuoteOrder.php?edit=" . $_GET["view"] . "&module=" . $module . "&curP=" . $_GET["curP"];
    $DownloadUrl = "pdfSO.php?o=" . $_GET["view"] . "&module=" . $module;
    $editsalespdf = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view" . $_GET["view"];
    $AddredirectURL = "sales/vSalesQuoteOrder.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $convertUrl = "sales/vSalesQuoteOrder.php?module=" . $module . "&curP=" . $_GET["curP"] . "&view=" . $_GET["view"] . "&convert=1";
    //$PdfUrl="pdfCommonhtml.php?o";
	$PdfDir = ($_GET['module']=='Quote')?($Config['S_Quote']):($Config['S_Order']);
    $ModuleID = ($_GET['module']=='Quote')? "QuoteID" : "SaleID";
	$tableName = 's_order';
} else if ($ModuleDepName == 'Purchase') {
    $ModuleName = $_GET['module'];//"Purchase " . $_GET['module'];
    //$PdfUrl="purchasing/pdfPOhtml.php";
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $RedirectURL = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $AddredirectURL = "purchasing/vPO.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $convertUrl = "purchasing/vPO.php?module=" . $module . "&curP=" . $_GET["curP"] . "&view=" . $_GET["view"] . "&convert=1";
    //$PdfUrl="pdfCommonhtml.php?o";
	$PdfDir = ($_GET['module']=='Quote')?($Config['P_Quote']):($Config['P_Order']);
	$ModuleID = ($_GET['module']=='Quote')? "QuoteID" : "PurchaseID";
	$tableName = 'p_order';
} else if ($ModuleDepName == 'SalesInvoice') {
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "finance/vInvoice.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
    //$PdfUrl="pdfCommonhtml.php?IN";
	$PdfDir = $Config['S_Invoice'];
	$ModuleID = "InvoiceID";
	$tableName = 's_order';
} else if ($ModuleDepName == 'PurchaseInvoice') {
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "finance/vPoInvoice.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&po=" . $_GET["po"] . "&IE=" . $_GET["IE"];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
	$PdfDir = $Config['P_Invoice'];
	$ModuleID = "InvoiceID";
	$tableName = 'p_order';
} else if ($ModuleDepName == 'SalesRMA') {

    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "sales/vRma.php?view=" . $_GET['view'] . "&curP=" . $_GET['curP'] . "&rtn=" . $_GET['rtn'] . "&Module=RMA";
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
	$PdfDir = $Config['S_Rma'];
	$ModuleID = "ReturnID";
	$tableName = 's_order';
} else if ($ModuleDepName == 'PurchaseRMA') {

    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "purchasing/vRma.php?view=" . $_GET['view'] . "&curP=" . $_GET['curP'] . "&po=" . $_GET['po'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "Invoice";
	$PdfDir = $Config['P_Rma'];
	$ModuleID = "ReturnID";
	$tableName = 'p_order';
} else if ($ModuleDepName == 'SalesCreditMemo') {

    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "finance/vCreditNote.php?curP=" . $_GET['curP'] . "&view=" . $_GET['view'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "CreditMemo";
	$PdfDir = $Config['S_Credit'];
	$ModuleID = "CreditID";
	$tableName = 's_order';
} else if ($ModuleDepName == 'PurchaseCreditMemo') {

    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "finance/vPoCreditNote.php?curP=" . $_GET['curP'] . "&view=" . $_GET['view'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $ModuleName = "CreditMemo";
	$PdfDir = $Config['P_Credit'];
	$ModuleID = "CreditID";
	$tableName = 'p_order';
}

elseif ($ModuleDepName == 'SalesCashReceipt') {
    //
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "finance/receiveInvoiceHistory.php?curP=" . $_GET['curP'] . "&edit=".$_GET["view"]."&InvoiceID=".$_GET["InvoiceID"]."&IE=".$_GET["IE"];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&IE=".$_GET["IE"];
    $ModuleName = "CashReceipt";
}

elseif ($ModuleDepName == 'WhouseVendorRMA') {
    //
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "warehouse/vPoRma.php?view=".$_GET['view']."&curP=".$_GET['curP']."&rcpt=".$_GET['rcpt'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&IE=".$_GET["IE"];
    $ModuleName = "VendorRMA";
}

elseif ($ModuleDepName == 'WhousePOReceipt') {
    //
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "warehouse/vPoReceipt.php?view=".$_GET['view']."&curP=".$_GET['curP']."&po=".$_GET['po'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&po=".$_GET['po'];
    $ModuleName = "VendorRMA";
}

elseif ($ModuleDepName == 'WhouseCustomerRMA') {
    //
    $Address1 = "Vendor Address";
    $Address2 = "Ship-To Address";
    $AddredirectURL = "warehouse/vSalesReturn.php?view=".$_GET['view']."&curP=".$_GET['curP']."&rcpt=".$_GET['rcpt'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&po=".$_GET['po'];
    $ModuleName = "VendorRMA";
}
elseif ($ModuleDepName == 'WhouseBatchMgt') {

    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";
    $AddredirectURL = "warehouse/vShipment.php?view=".$_GET['view']."&curP=".$_GET['curP']."&ship=".$_GET['ship']."&batch=".$_GET['batch'];
    $RedirectURL = "editcustompdf.php?curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName."&InvoiceID=".$_GET["InvoiceID"]."&po=".$_GET['po'];
    $ModuleName = "VendorRMA";

}
elseif ($ModuleDepName == 'Quote') {
    
    $ModuleName = "Quote";
    $Address1 = "Billing Address";
    $Address2 = "Shipping Address";    
    $RedirectURL = "editcustompdf.php?module=" . $module . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"] . "&tempid=" . $_GET["tempid"] . "&ModuleDepName=" . $ModuleDepName;
    $AddredirectURL = "crm/vQuote.php?module=" . $ModuleName . "&curP=" . $_GET['curP'] . "&view=" . $_GET["view"];
    $PdfDir = ($_GET['module']=='Quote')?($Config['C_Quote']):($Config['C_Quote']);
    $PdfDir = $Config['C_Quote'];
    $ModuleID = "quoteid";
    $tableName = 'c_quotes'; 
    $_GET['module'] = $module = '';
}





/* * code by sachin 17-11* */
//echo '<pre>'; print_r($arryCompany);die;
if (!empty($_GET['view']) && !empty($_GET['tempid'])) {
    $_GET['ModuleName'] = $ModuleDepName;
    $_GET['Module'] = $ModuleDepName . $_GET['module'];
    $_GET['ModuleId'] = $_GET['view'];
    $_GET['id'] = $_GET['tempid'];
    $_GET['listview']='1';
    /****feb-28-2K17****/
    $GetPFdTempalteVal = $objConfig->GetSalesPdfTemplate($_GET);

 	$createdBy='';
	if(!empty($GetPFdTempalteVal[0]['id'])){
	    if(trim($GetPFdTempalteVal[0]['UserType'])=='admin'){		
		$createdBy='Admin';
	    }else if(!empty($GetPFdTempalteVal[0]['AdminID'])){
		$GetEmpDetails=$objEmp->GetEmployee($GetPFdTempalteVal[0]['AdminID'],'');
		if(!empty($GetEmpDetails[0]['UserName'])){		 
			$createdBy=$GetEmpDetails[0]['UserName'];
		}
	    }
	}
 
     /****feb-28-2K17****/
    
    //$ttt=$objEmp->GetEmployee($GetEmployeeBrief[0]['AdminID'],'');
    
    //PR($GetEmpDetails);die;
    //echo '<pre>'; print_r($GetPFdTempalteVal); die;
}

/*updated on 3May2018 by chetan for Template pdf download*/
if(($_POST['Update'] == 'Update' || $_POST['Save'] == 'Save') && !empty($_GET['view'])){
			/*******Generate Template PDF Parameter************/			
			if ($ModuleDepName == 'SalesInvoice' || $ModuleDepName == 'PurchaseInvoice' || $ModuleDepName == 'Sales' || $ModuleDepName == 'SalesRMA' || $ModuleDepName == 'PurchaseRMA' || $ModuleDepName == 'Purchase' || $ModuleDepName == 'SalesCreditMemo' || $ModuleDepName == 'PurchaseCreditMemo'  || $ModuleDepName == 'Quote') {	
			$PdfArray['ModuleDepName'] 	= 	$ModuleDepName;//"SalesInvoice";
			$PdfArray['Module'] 		= 	$ModuleName;//"Invoice";
			$PdfArray['ModuleID'] 		= 	$ModuleID;//"InvoiceID";
			$PdfArray['TableName'] 		= 	$tableName;//"s_order";
			if($ModuleDepName == 'Quote') {
			    $PdfArray['OrderColumn'] 	=  	"quoteid";
			}
			else{
			    $PdfArray['OrderColumn'] 	=  	"OrderID";//$orderCol;// 
			}
			$PdfArray['OrderID'] 		=  	$_GET['view'];
			$PdfArray['dir'] 		= 	$PdfDir;//$Config['S_Invoice'];
			}					
}
/*End*/	




if (!empty($GetPFdTempalteVal[0]['id'])) {
	if(!empty($_POST['Update'])){
		    if (($_POST['Update'] == 'Update') && !empty($_GET['view'])) {
		
			$_POST['ModuleName'] = $ModuleDepName;     
			if($_POST['Deftformult']==1){        
		       	 	//$_POST['defaultFor']=$defltmultVal;
				$_POST['createdBy']=$GetPFdTempalteVal[0]['AdminID'];
			}         
			$objConfig->UpdateSalesPdfTempalte($_POST);
			$_SESSION['mess_Sale'] = PDF_TEMPLATE_UPDATED;

			/*template Pdf download update generation on 12Mar2018 by chetan*/
				if ($ModuleDepName == 'SalesInvoice' || $ModuleDepName == 'PurchaseInvoice' || $ModuleDepName == 'Sales' || $ModuleDepName == 'SalesRMA' || $ModuleDepName == 'PurchaseRMA' || $ModuleDepName == 'Purchase' || $ModuleDepName == 'SalesCreditMemo' || $ModuleDepName == 'PurchaseCreditMemo'  || $ModuleDepName == 'Quote') {
				$PdfArray['templId'] = $GetPFdTempalteVal[0]['id'];	 	
				$objConfigure->GeneratePDF($PdfArray);
				}
			//END//

			header("Location:" . $RedirectURL);
			exit;
		    }
	}
} else {

	if(!empty($_POST['Save'])){

		    if (($_POST['Save'] == 'Save') && !empty($_GET['view'])) {
			//echo '<pre>'; print_r($_POST);die('add');
			if (!empty($_POST['TemplateName'])) {
			    $_POST['ModuleName'] = $ModuleDepName;
			    $objConfig->SaveSalesPdfTempalte($_POST);
			    $_SESSION['mess_Sale'] = PDF_TEMPLATE_ADDED;
				
				/*template Pdf generation on 12Mar2018 by chetan*/
				if ($ModuleDepName == 'SalesInvoice' || $ModuleDepName == 'PurchaseInvoice' || $ModuleDepName == 'Sales' || $ModuleDepName == 'SalesRMA' || $ModuleDepName == 'PurchaseRMA' || $ModuleDepName == 'Purchase' || $ModuleDepName == 'SalesCreditMemo' || $ModuleDepName == 'PurchaseCreditMemo'  || $ModuleDepName == 'Quote') {
				$PdfArray['templId'] = $objConfig->lastInsertId();	 	
				$objConfigure->GeneratePDF($PdfArray);
				}
				/*End*/

			    header("Location:" . $AddredirectURL);
			    exit;
			} else {

			    $_SESSION['mess_dynamicpdf'] = "Please Enter Template Name";
			    header("Location:" . $RedirectURL);
			    exit;
			}
		    }
	}


	$GetPFdTempalteVal = $objConfigure->GetDefaultArrayValue('dynamic_pdf_template');
	 

}

/* * code by sachin 17-11* */
//code for delete tempname
if (!empty($_GET['Deltempid']) && !empty($_GET['view'])) {
	$DeleteArray = array();

	$DeleteArray['ModuleDepName'] 	= 	$ModuleDepName;//"SalesInvoice";
	$DeleteArray['Module'] 		= 	$ModuleName;//"Invoice";
	$DeleteArray['ModuleID'] 	= 	$ModuleID;//"InvoiceID";
	$DeleteArray['TableName'] 	= 	$tableName;//"s_order";
	$DeleteArray['PdfDir'] 		= 	$PdfDir;//"PdfDir";
	$DeleteArray['OrderID'] 	= 	$_GET['view'];//"OrderID";
	$DeleteArray['id'] 		= 	$_GET['Deltempid'];//"tempid";
	if($ModuleDepName == 'Quote') {
	    $DeleteArray['OrderColumn'] =  	"quoteid"; //$orderCol;// 
	}else{
	    $DeleteArray['OrderColumn'] =  	"OrderID";//$orderCol;// 
	}

	$objConfig->DeleteTemplateName($DeleteArray);

	$_SESSION['mess_Sale'] = "PDF Template has been removed successfully.";
	header("Location:" . $AddredirectURL);
	exit;
}

/* * code by sachin 16-11* */
$col = '12';
$FieldFontSize = 'Field Font Size :';
$FieldAlign = 'Field Align :';
$TabFontSize = 'Heading Font Size :';
$TabAlign = 'Heading Align :';
$Tab = 'Heading :';
$ItemHeading = 'Item Heading :';
$ItemFontSize = 'Item Font Size :';
//$FieldSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,22);
$FieldSizeArry = array(9, 10, 11, 12, 13, 14);
//$HeadingSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,22,24,25,26);
//$HeadingSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,21,22);
$HeadingSizeArry = array(14, 15, 16, 17, 18, 19, 20, 21, 22);
$lineItemHeadFontSize = array(8, 9, 10, 11, 12);
$borderarry = array('Yes' => '1', 'No' => '0');
$AlignArry = array('Left', 'Right');
//$AlignArryTitle=array('left','right','center');
$AlignArryTitle = array('Left' => 'left', 'Right' => 'right');
$Color = array('Red' => '#ff0000', 'Blue' => '#004269', 'Purple' => '#800080', 'Black' => '#000000', 'white' => '#fff', 'Green' => '#266A2E', 'Grey' => '#d3d3d3', 'Pink' => '#C71585', 'Yellow' => '#FFFF00');
$logosize = array(100, 150, 200);
$HeadingArry = array('Bold' => 'bold', 'Normal' => 'normal');
$showHideArray=array('Show'=>'show','Hide'=>'hide');
$PublicPvtArry=array('Public'=>'0','Private'=>'1');//feb-27-17
$FieldFontSizeName = 'FieldFontSize';
$FieldAlignName = 'FieldAlign';
$HeadingFontSizeName = 'HeadingFontSize';
$HeadingAlignName = 'HeadingAlign';
$HeadingName = 'Heading';
$ItemHeadingName = 'Heading';
$ItemFontSizeName = 'FontSize';
/* * code by sachin 16-11* */
require_once("includes/footer.php");
?>


