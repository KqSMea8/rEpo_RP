<?
	/********* Lead Detail **************/
	/*************************************/
require_once("../includes/pdf_comman.php");
	

		require_once($Prefix."classes/lead.class.php");
		require_once($Prefix . "classes/group.class.php");
         require_once($Prefix . "classes/filter.class.php");
         require_once($Prefix."classes/sales.customer.class.php");
         require_once($Prefix."classes/employee.class.php");
		$objLead=new lead();
		$objGroup = new group();
		$objCustomer=new  Customer();
		$objEmployee=new employee();
		
	
		
	$arryContact = $objCustomer->GetContactAddress($_GET['AddID'],'');
      //echo "<pre>";	print_r($arryContact);exit;
	
		if(!empty($arryContact[0]['CustID'])){
			$arryCustomer = $objCustomer->GetCustomer($arryContact[0]['CustID'],'','');
		}
		$arryEmployee = $objEmployee->GetEmployeeBrief($arryContact[0]['AssignTo']);
	//$arryLead =$objLead->GetLead($_GET['leadid'],'');
	//if($_GET['d']==1){echo "<pre>";print_r($arryCustomer);exit;}
	
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	
	
	     	
	
	
	
	 $Title ="Contact # ".$arryContact[0]['FullName'];
	 HeaderTextBox($pdf,$Title,$arryCompany);
	//$UpdatedDate = ($arryLead[0]['UpdatedDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['UpdatedDate']))):("");
	///$LeadDate=($arryLead[0]['LeadDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LeadDate']))):("");
	//$LastContactDate=($arryLead[0]['LastContactDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryLead[0]['LastContactDate']))):("");

if($arryContact[0]['Status'] == 1)
{
$Status="Active";	
}
else 
{
	$Status="InActive";
}
	$customer = (isset($arryCustomer[0]['FullName'])) ? $arryCustomer[0]['FullName'] : '';
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => "First Name :", $Head2 => $arryContact[0]['FirstName']),
		array($Head1 => "Last Name :", $Head2 =>  $arryContact[0]['LastName']),
		array($Head1 => "Email  :", $Head2 => $arryContact[0]['Email']),
		array($Head1 => "Personal Email :", $Head2 => $arryContact[0]['PersonalEmail']),

		array($Head1 => "Title :", $Head2 => $arryContact[0]['Title']),
		array($Head1 => "Department :", $Head2 => $arryContact[0]['Department']),
		array($Head1 => "Lead Source :", $Head2 => $arryContact[0]['LeadSource']),
      array($Head1 => "AssignTo:", $Head2 => $arryEmployee[0]['UserName']),
      array($Head1 => "Reference :" , $Head2 => $arryContact[0]['Reference']),
		array($Head1 => "Do Not Call  :" , $Head2 => $arryContact[0]['DoNotCall']),
		array($Head1 => "Notify Owner:", $Head2 => $arryContact[0]['NotifyOwner']),
		
		array($Head1 => "Email Opt Out :", $Head2 => $arryContact[0]['EmailOptOut']),
		array($Head1 => "Customer :", $Head2 => $customer),

		array($Head1 => "Status  :" , $Head2 =>$Status)

		
		
			
		
	
		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'120')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	
	
	$Head1 = '<b>'."Address Details".'</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,125,$YCordLine);
	//$pdf->line(325,$YCordLine,405,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryContact[0]['Address']));
	
	
	unset($data);


	if(!empty($Address))  $data[][$Head1] =  $Address.",";
	if(!empty($arryContact[0]['CountryName']))  $data[][$Head1] = stripslashes($arryContact[0]['CityName']).", ".stripslashes($arryContact[0]['StateName']).",\n".stripslashes($arryContact[0]['CountryName'])."-".stripslashes($arryContact[0]['ZipCode']).  "\nMobile No: ".stripslashes($arryContact[0]['Mobile'])."\nLandlineNumber: ".stripslashes($arryContact[0]['LandlineNumber']);

	$pdf->ezSetDy(-10);
	$StartCd = $pdf->y;
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>176 ,'width'=>250,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	$EndCd = $pdf->y;
	$RightY = $StartCd - $EndCd;
	
	
	
	
	$file_path = 'upload/pdf/'.$arryContact[0]['CustID'].".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1)
	{
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>


