<?  ob_start();
	session_start();

	require_once("../includes/settings.php");
	require_once($Prefix."classes/payroll.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objPayroll=new payroll();
	$objEmployee=new employee();

	$RedirectUrl ="viewGeneratedSalary.php";

	if(isset($_GET['view']) && $_GET['view'] >0){
		$arrySalary = $objPayroll->getPaySalary($_GET['view'],'','','');
		$_GET['y'] = $arrySalary[0]['Year'];
		$_GET['m'] = $arrySalary[0]['Month'];
		$ShowList = 1;
		/********************/
		$SalaryData = $arrySalary[0]['SalaryData'];
		if(!empty($SalaryData)){
			$arrySalaryData = explode("#",$SalaryData);
			foreach($arrySalaryData as $values_sal){
				$arryIDSalary = explode(":",$values_sal);
				$arrySalaryDb[$arryIDSalary[0]] = $arryIDSalary[1];
			}
		}
		/********************/
		$RedirectUrl ="viewGeneratedSalary.php?emp=".$_GET['emp']."&y=".$_GET['y']."&m=".$_GET['m'];
		$_GET['emp'] = $arrySalary[0]['EmpID'];
	}else{
		header("location:".$RedirectUrl);
		exit;		
	}
	$arryPayCategory=$objPayroll->getPayCategory('','');

	$arryEmployeeDt = $objEmployee->GetEmployeeBrief($_GET['emp']); 

$PageContent = '<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
			
	 <tr>
		 <td colspan="2" align="left" ><strong>Salary For Month:</strong>&nbsp;&nbsp;&nbsp;'.date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01')).'</td>
	</tr>	
          
 </table> ';

$PageContent .= '<br><table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Employee Profile</td>
	</tr>   
	  
	   <tr>
		  <td align="left" class="blackbold" width="14%"><strong>Employee Name :</strong> </td>
		  <td align="left" width="50%" >'.stripslashes($arryEmployeeDt[0]['UserName']).'	 </td>
		  <td align="left" class="blackbold" width="11%"><strong>Designation :</strong> </td>
		  <td align="left" >'.stripslashes($arryEmployeeDt[0]['JobTitle']).'	 </td>
		  
		</tr>
	   <tr>
		  <td align="left" class="blackbold"><strong>Employee Code : </strong></td>
		  <td align="left" >'.$arryEmployeeDt[0]["EmpCode"].'</td>
		   <td align="left" class="blackbold"><strong>Department :</strong> </td>
		  <td align="left" >'.stripslashes($arryEmployeeDt[0]['Department']).' </td>
		</tr>	
	  </table>';



//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2010-08-08
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 061');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// define some HTML content with style


/*$Url = 'http://localhost/erp/admin/hrms/salaryInfo.php?view='.$_GET['view'];

$PageContent = file_get_contents($Url);

*/

$html = "
<style>
.borderall {
	border:1px solid #E1E1E1;
	border-radius:2px;
}
.head {
	text-decoration:none;
	background:#EFEFEF;
	font-weight:bold;
	height: 28px;
}
</style>
".$PageContent;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// *******************************************************************
// HTML TIPS & TRICKS
// *******************************************************************

// REMOVE CELL PADDING
//
// $pdf->SetCellPadding(0);
// 
// This is used to remove any additional vertical space inside a 
// single cell of text.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// REMOVE TAG TOP AND BOTTOM MARGINS
//
// $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
// $pdf->setHtmlVSpace($tagvs);
// 
// Since the CSS margin command is not yet implemented on TCPDF, you
// need to set the spacing of block tags using the following method.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// SET LINE HEIGHT
//
// $pdf->setCellHeightRatio(1.25);
// 
// You can use the following method to fine tune the line height
// (the number is a percentage relative to font height).

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// CHANGE THE PIXEL CONVERSION RATIO
//
// $pdf->setImageScale(0.47);
// 
// This is used to adjust the conversion ratio between pixels and 
// document units. Increase the value to get smaller objects.
// Since you are using pixel unit, this method is important to set the
// right zoom factor.
// 
// Suppose that you want to print a web page larger 1024 pixels to 
// fill all the available page width.
// An A4 page is larger 210mm equivalent to 8.268 inches, if you 
// subtract 13mm (0.512") of margins for each side, the remaining 
// space is 184mm (7.244 inches).
// The default resolution for a PDF document is 300 DPI (dots per 
// inch), so you have 7.244 * 300 = 2173.2 dots (this is the maximum 
// number of points you can print at 300 DPI for the given width).
// The conversion ratio is approximatively 1024 / 2173.2 = 0.47 px/dots
// If the web page is larger 1280 pixels, on the same A4 page the 
// conversion ratio to use is 1280 / 2173.2 = 0.59 pixels/dots

// *******************************************************************

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
