<?php
require_once("../includes/config.php");
require_once("../classes/dbClass.php");
require_once("../classes/member.class.php");
require_once("../classes/orders.class.php");
require_once("../includes/function.php");

$objMember=new member();
$objOrder=new orders();

if(!empty($_GET['OrderID'])){
	$arryOrder=$objOrder->GetOrders($_REQUEST['OrderID'],'','','');
	if($arryOrder[0]['ProductIDs'] != ''){
		$arryProducts = $objOrder->GetOrderDetails($_REQUEST['OrderID'],$arryOrder[0]['ProductIDs']);			
		$numProducts  = $objOrder->numRows();
	}
	if (!empty($arryOrder[0]['StoreID'])) {
		$arryMember = $objMember->GetMemberDetail($arryOrder[0]['StoreID']);
		$arryMember2 = $objMember->GetMembers($arryOrder[0]['StoreID'],'','');
	}
	
}else{
	echo 'Invalid Order.';
	exit;
}	


 
require('fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
// Whatever written here will come in header of the pdf file.

//$this->Image('images/btn.jpg',10,8,38);
$this->SetFont('Arial','B',30);
$this->SetTextColor(65,174,47);
/*
$this->Cell(30,10,stripslashes($arryMember[0]['CompanyName']));
$this->Line(10,20,200,20);
*/
}

//Page footer
function Footer()
{
	// Whatever written here will come in footer of the pdf file.
	
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Adds image to beginning of 
$pdf->SetTextColor(65,174,47);
$pdf->Cell(30,10,stripslashes($arryMember[0]['CompanyName']));
$pdf->Line(10,20,200,20);

/*
if($arryMember[0]['Image'] !='' && file_exists('../upload/company/'.$arryMember[0]['Image']) ){
	$ImgFile = $arryMember[0]['Image'];
	
	$ImageFileArry = explode('.',$arryMember[0]['Image']);
	
	if($ImageFileArry[1]=='gif'){ 
		$ImgFile = 'thumb/'.$ImageFileArry[0].'.jpg';
		imageThumb('../upload/company/'.$arryMember[0]['Image'],'../upload/company/'.$ImgFile,120,120);
	}
	
	if($ImageFileArry[1]!='gif'){ 
		$pdf->Image($Config['Url'].'upload/company/'.$ImgFile,139,49,50,50,'','');
	}
}
*/

$pdf->Ln(5);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(53,53,53);
$pdf->Cell(40,20,'Order Number: #'.stripslashes($arryOrder[0]['OrderID']));
$pdf->Ln(5);
$pdf->Cell(40,20,'Order Date: '.date('d-m-Y',strtotime($arryOrder[0]['OrderDate'])));
$pdf->Ln(5);
$pdf->Cell(40,20,'Order Viewed On: '.date('d-m-Y'));
$pdf->Ln(7);

$pdf->SetTextColor(41,92,159);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,20,'Store Details');





$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(53,53,53);
$pdf->Ln(5);
$pdf->Cell(80,20,'First Name: '.stripslashes($arryMember[0]['FirstName']));
$pdf->Cell(80,20,'Last Name : '.stripslashes($arryMember[0]['LastName']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Contact Person: '.stripslashes($arryMember[0]['ContactPerson']));
$pdf->Cell(80,20,'Contact Number: '.stripslashes($arryMember[0]['ContactNumber']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Address: '.stripslashes($arryMember[0]['Address']));
$pdf->Cell(80,20,'Country : '.stripslashes($arryMember[0]['Country']));
$pdf->Ln(5);
$pdf->Cell(80,20,'State/Region: '.stripslashes($arryMember[0]['State']));
$pdf->Cell(80,20,'City: '.stripslashes($arryMember[0]['City']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Postal Code: '.stripslashes($arryMember[0]['PostCode']));
$pdf->Cell(80,20,'Landline Number: '.stripslashes($arryMember[0]['LandlineNumber']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Mobile Number: '.stripslashes($arryMember[0]['Phone']));
$pdf->Cell(80,20,'Fax: '.stripslashes($arryMember[0]['Fax']));
$pdf->Ln(5);


if($arryOrder[0]['payment_gateway']=='EFT / Bank Tranfer' || $arryOrder[0]['payment_gateway']=='Direct Deposit'){ 
	$pdf->Ln(7);
	$pdf->SetTextColor(41,92,159);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,20,"Store Banking Details");

	$pdf->SetFont('Arial','',9);
	$pdf->SetTextColor(53,53,53);
	$pdf->Ln(5);
	$pdf->Cell(80,20,'Account Holder: '.stripslashes($arryMember2[0]['AccountHolder']));
	$pdf->Cell(80,20,'Account Number:'.stripslashes($arryMember2[0]['AccountNumber']));
	$pdf->Ln(5);
	$pdf->Cell(80,20,'Bank Name: '.stripslashes($arryMember2[0]['BankName']));
	$pdf->Cell(80,20,'Branch Code: '.stripslashes($arryMember2[0]['BranchCode']));
	$pdf->Ln(5);
	$pdf->Cell(80,20,'Swift Number: '.stripslashes($arryMember2[0]['SwiftNumber']));
	$pdf->Ln(5);
}



$pdf->Ln(7);
$pdf->SetTextColor(41,92,159);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,20,'Customer Billing Details');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(53,53,53);

$pdf->Ln(5);
$pdf->Cell(80,20,'Billing Name: '.stripslashes($arryOrder[0]['BillingName']));
$pdf->Cell(80,20,'Email: '.stripslashes($arryOrder[0]['Email']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Phone: '.stripslashes($arryOrder[0]['Phone']));
$pdf->Cell(80,20,'Address: '.stripslashes($arryOrder[0]['BillingAddress']));
$pdf->Ln(5);
$pdf->Cell(80,20,'City: '.stripslashes($arryOrder[0]['BillingCity']));
$pdf->Cell(80,20,'State: '.stripslashes($arryOrder[0]['BillingState']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Country: '.stripslashes($arryOrder[0]['BillingCountry']));
$pdf->Cell(80,20,'Postal Code: '.stripslashes($arryOrder[0]['BillingZip']));

$pdf->Ln(7);
$pdf->SetTextColor(41,92,159);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,20,'Customer Delivery Details');

$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(53,53,53);
$pdf->Ln(5);
$pdf->Cell(80,20,'Shipping Name: '.stripslashes($arryOrder[0]['ShippingName']));
$pdf->Cell(80,20,'Address: '.stripslashes($arryOrder[0]['ShippingAddress']));
$pdf->Ln(5);
$pdf->Cell(80,20,'City: '.stripslashes($arryOrder[0]['ShippingCity']));
$pdf->Cell(80,20,'State: '.stripslashes($arryOrder[0]['ShippingState']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Country: '.stripslashes($arryOrder[0]['ShippingCountry']));
$pdf->Ln(5);
$pdf->Cell(80,20,'Postal Code: '.stripslashes($arryOrder[0]['ShippingZip']));

$pdf->Ln(7);
$pdf->SetTextColor(41,92,159);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,20,'Order Details');

$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(53,53,53);
$pdf->Ln(5);

$pdf->Cell(40,20,'Product Name');
$pdf->Cell(40,20,'Product Number');
$pdf->Cell(40,20,'Quantity');
$pdf->Cell(40,20,'Unit Price');
$pdf->Cell(40,20,'Amount');

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(53,53,53);
$pdf->Ln(5);

if(is_array($arryProducts) && $numProducts>0){
$flag=true;
$TOTAL = 0;
$Count = 0;
$SubTotal = 0;

	for($i=0;$i<sizeof($arryProducts);$i++){
		//foreach($arryProducts as $key=>$arryProducts[$i]){
		$flag=!$flag;
		$Count++;
		$j=$i+1;
		$SubTotal += ($arryProducts[$i]['Quantity']*$arryProducts[$i]['Price']); 
		$TotalQuantity += $arryProducts[$i]['Quantity'];
		
		
		$pdf->Cell(40,20,stripslashes($arryProducts[$i]['ProductName']));
		$pdf->Cell(40,20, stripslashes($arryProducts[$i]['ProductNumber']));
		$pdf->Cell(40,20,$arryProducts[$i]['Quantity']);
		$pdf->Cell(40,20,display_price($arryProducts[$i]['Price'],'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
		$pdf->Cell(40,20,display_price($arryProducts[$i]['Quantity']*$arryProducts[$i]['Price'],'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
		$pdf->Ln(4);

	}

	//$Tax=$arryOrder[0]['Tax'];
	$Ship=$arryOrder[0]['Shipping'];
	$VatAmount=$arryOrder[0]['VatAmount'];
	
  $Total = $SubTotal +$Tax+$Ship+$VatAmount;

$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(53,53,53);

$pdf->Ln(5);

$pdf->Cell(145);
$pdf->Cell(40,20,'Sub Total: '.display_price($SubTotal,'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
$pdf->Ln(5);
if($Tax > 0){
	$pdf->Cell(145);
	$pdf->Cell(40,20,'Tax: '.display_price($Tax,'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
	$pdf->Ln(5);
}

if($VatAmount > 0){
	//if(!empty($arryOrder[0]['VatPercentage'])) $VTPr = '('.$arryOrder[0]['VatPercentage'].' %)'; 
	
	$VatType = (!empty($arryOrder[0]['VatType']))?(stripslashes($arryOrder[0]['VatType'])):("VAT");

	$pdf->Cell(145);
	$pdf->Cell(40,20,$VatType.': '.display_price($VatAmount,'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
	$pdf->Ln(5);
}

if($Ship > 0){
	$pdf->Cell(145);
	$pdf->Cell(40,20,'Delivery Fee: '.display_price($Ship,'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
	$pdf->Ln(5);
}


$pdf->Cell(145);
$pdf->Cell(40,20,'Total Amount: '.display_price($Total,'','',$arryOrder[0]['symbol_left'],$arryOrder[0]['symbol_right']));
$pdf->Ln(5);

}


if($arryOrder[0]['Status'] == 1){
	if($_GET['opt']=='Buyer') $DeliveryStatus= 'Received';
	else $DeliveryStatus= 'Delivered';
}
if($arryOrder[0]['Status'] == 0) $DeliveryStatus='Pending';


if($arryOrder[0]['PaymentStatus'] == 1){
	if($_GET['opt']=='Buyer') $PaymentStatus='Paid';
	else $PaymentStatus='Received';
}
if($arryOrder[0]['PaymentStatus'] == 0){
	if($_GET['opt']=='Buyer') $PaymentStatus='Not Paid';
	else $PaymentStatus='Not Received';
}


$pdf->Cell(40,20,'Delivery  Method: '.stripslashes($arryOrder[0]['DeliveryMethod']));
$pdf->Ln(5);
$pdf->Cell(40,20,'Delivery Status: '.$DeliveryStatus);
$pdf->Ln(5);
$pdf->Cell(40,20,'Payment Status: '.$PaymentStatus);
$pdf->Ln(5);
$pdf->Cell(40,20,'Payment Method: '.stripslashes($arryOrder[0]['payment_gateway']));
$pdf->Ln(5);


$PdfName = 'Order_'.$arryOrder[0]['OrderID'].'_'.date('d-m-Y').'.pdf';

$pdf->Output($PdfName,'D');
//$pdf->Output($PdfName,'');

?>