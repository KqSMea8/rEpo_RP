<?php
header ("Content-type: application/pdf"); 
					  
$uname=$_POST['textuser'];
$pass=$_POST['textpass'];
////////////////////////////////
$sadd=$_POST['textsadd'];
$scity=$_POST['textscity'];
$spin=$_POST['textspin'];
$scno=$_POST['textscno'];
$semail=$_POST['textsemail'];
if($_POST['textpass'] == $_POST['textcpass'])
{
// You can also insert it into mysql by writing mysql queries here.
// Code for pdf generation
 
require('fpdf.php');
class PDF extends FPDF
{
//Page header
function Header()
{
// Whatever written here will come in header of the pdf file.

//$this->Image('images/btn.jpg',10,8,38);
$this->SetFont('Arial','B',15);
$this->Cell(80);
$this->Cell(30,10,'Pdf Creator',0,0,'C');
$this->Ln(20);
$this->Cell(120);
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
$pdf->Cell(30,10,'-Information',0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Times','',12);
$pdf->Cell(40,20,'Username : '.$uname);
$pdf->Ln(20);
$pdf->Cell(40,20,'Password : '.$pass);
$pdf->Ln(20);
$pdf->Cell(40,20,'Address : '.$sadd);
$pdf->Ln(20);
$pdf->Cell(40,20,'City : '.$scity);
$pdf->Ln(20);
$pdf->Cell(40,20,'Pincode : '.$spin);
$pdf->Ln(20);
$pdf->Cell(40,20,'Contact No : '.$scno);
$pdf->Ln(20);
$pdf->Cell(40,20,'Email : '.$semail);
$pdf->Ln(20);
$pdf->Output('pp2.pdf','D');
}
else
{
echo "Password and Confirm password do not match.";
echo "<br>";
echo '<a href="registation.php">&lt;&lt;Back</a>';
}
?>